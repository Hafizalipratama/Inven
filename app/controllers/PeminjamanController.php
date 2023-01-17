<?php 
/**
 * Peminjaman Page Controller
 * @category  Controller
 */
class PeminjamanController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "peminjaman";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("Id_Peminjaman", 
			"Id_Barang", 
			"Id_User", 
			"Qty", 
			"Tgl_Pinjam", 
			"Tgl_Kembali");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				peminjaman.Id_Peminjaman LIKE ? OR 
				peminjaman.Id_Barang LIKE ? OR 
				peminjaman.Id_User LIKE ? OR 
				peminjaman.Qty LIKE ? OR 
				peminjaman.Tgl_Pinjam LIKE ? OR 
				peminjaman.Tgl_Kembali LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "peminjaman/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("peminjaman.Id_Peminjaman", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Peminjaman";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("peminjaman/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("peminjaman.Id_Peminjaman", 
			"peminjaman.Id_Barang", 
			"peminjaman.Id_User", 
			"peminjaman.Qty", 
			"peminjaman.Tgl_Pinjam", 
			"peminjaman.Tgl_Kembali",
			"barang.Nama_Barang AS barang_Nama_Barang", 
			"barang.Merek AS barang_Merek",
			"user.nama AS user_nama");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("peminjaman.Id_Peminjaman", $rec_id);; //select record based on primary key
		}
		$db->join("barang", "peminjaman.Id_Barang = barang.Id_Barang", "INNER");
		$db->join("user", "peminjaman.Id_User = user.id", "INNER");
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View Peminjaman";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("peminjaman/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
    function scan(){
        $page_title = $this->view->page_title = "Scan QR Code Barang";
		$this->render_view("peminjaman/scan.php");
    }

	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("Id_Barang","Id_User","Qty","Tgl_Pinjam");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Id_Barang' => 'required',
				'Id_User' => 'required',
				'Qty' => 'required|numeric',
				'Tgl_Pinjam' => 'required',
			);
			$this->sanitize_array = array(
				'Id_Barang' => 'sanitize_string',
				'Id_User' => 'sanitize_string',
				'Qty' => 'sanitize_string',
				'Tgl_Pinjam' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
                //ubah jumlah aset barang
			    $ubah_jumlah_aset = $this->update_jumlah_aset_barang($_POST['Id_Barang'], $_POST['Qty']);
                if($ubah_jumlah_aset == 1){
                    $rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
                    if($rec_id){
                        $this->set_flash_msg("Record added successfully", "success");
                        return	$this->redirect("peminjaman");
                    }
                    else{
                        $this->set_page_error();
                    }
                } else {
                    $this->set_flash_msg("Gagal! Qty Peminjaman Melebihi Stok Barang Yang Tersedia", "danger");
                    return	$this->redirect("peminjaman/add");
                }
			}
		}
		$page_title = $this->view->page_title = "Add New Peminjaman";
		$this->render_view("peminjaman/add.php");
	}

    function update_jumlah_aset_barang($id, $qty){
        $db = $this->GetModel();

        //cek jumlah aset
        $sqltext = "SELECT Jumlah_Aset FROM barang WHERE Id_Barang = $id";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			$jumlah_aset = $val[0];
		} else {
            $jumlah_aset = 0;
        }

        $hitung_aset = $jumlah_aset - $qty;

        //update jumlah aset
        if($hitung_aset > 0){
            $postdata = array();
            $postdata['Jumlah_Aset'] = $hitung_aset;
            $postdata = $this->format_request_data($postdata);
            $modeldata = $this->modeldata = $postdata;
            $db->where("barang.Id_Barang", $id);
            $db->update('barang', $modeldata);

            return 1;
        } else {
            return 0;
        }

    }

    function kembalikan($id_peminjaman){
        Csrf::cross_check();
        $db = $this->GetModel();

        //get peminjaman
        $peminjaman_fields = array(
            "Id_Barang", 
			"Qty",
        );

        $db->where("peminjaman.Id_Peminjaman", $id_peminjaman);
        $peminjaman_record = $db->getOne('peminjaman', $peminjaman_fields);

        $Id_Barang = $peminjaman_record['Id_Barang'];
        $Qty = $peminjaman_record['Qty'];

        //cek jumlah aset
        $sqltext = "SELECT Jumlah_Aset FROM barang WHERE Id_Barang = $Id_Barang";
		$queryparams = null;
		$val = $db->rawQueryValue($sqltext, $queryparams);
		
		if(is_array($val)){
			$jumlah_aset = $val[0];
		} else {
            $jumlah_aset = 0;
        }

        $hitung_aset = $jumlah_aset + $Qty;

        //update jumlah aset
        $postdata = array();
        $postdata['Jumlah_Aset'] = $hitung_aset;
        $postdata = $this->format_request_data($postdata);
        $modeldata = $this->modeldata = $postdata;
        $db->where("barang.Id_Barang", $Id_Barang);
        $db->update('barang', $modeldata);

        //update tgl_kembali
        $postdata2 = array();
        $postdata2['Tgl_Kembali'] = date('Y-m-d');
        $postdata2 = $this->format_request_data($postdata2);
        $modeldata2 = $this->modeldata = $postdata2;
        $db->where("peminjaman.Id_Peminjaman", $id_peminjaman);
        $db->update('peminjaman', $modeldata2);

        $this->set_flash_msg("Barang Telah Dikembalikan", "success");
        return	$this->redirect("peminjaman/view/". $id_peminjaman);
    }
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("Id_Barang","Id_User","Qty","Tgl_Pinjam");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'Id_Barang' => 'required',
				'Id_User' => 'required',
				'Qty' => 'required|numeric',
				'Tgl_Pinjam' => 'required',
			);
			$this->sanitize_array = array(
				'Id_Barang' => 'sanitize_string',
				'Id_User' => 'sanitize_string',
				'Qty' => 'sanitize_string',
				'Tgl_Pinjam' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("peminjaman.Id_Peminjaman", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("peminjaman");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("peminjaman");
					}
				}
			}
		}
		$db->where("peminjaman.Id_Peminjaman", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit Peminjaman";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("peminjaman/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("Id_Barang","Id_User","Qty","Tgl_Pinjam");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'Id_Barang' => 'required',
				'Id_User' => 'required',
				'Qty' => 'required|numeric',
				'Tgl_Pinjam' => 'required',
			);
			$this->sanitize_array = array(
				'Id_Barang' => 'sanitize_string',
				'Id_User' => 'sanitize_string',
				'Qty' => 'sanitize_string',
				'Tgl_Pinjam' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("peminjaman.Id_Peminjaman", $rec_id);
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("peminjaman.Id_Peminjaman", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("peminjaman");
	}
}
