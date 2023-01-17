<?php
$comp_model = new SharedController;
$page_element_id = "edit-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="edit" data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Edit Peminjaman</h4>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="bg-light p-3 animated fadeIn page-content">
                        <form novalidate id="" role="form" enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("peminjaman/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="Id_Barang">Id Barang <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required="" id="ctrl-Id_Barang" name="Id_Barang" placeholder="Select a value ..." class="custom-select">
                                                    <option value="">Select a value ...</option>
                                                    <?php
                                                    $rec = $data['Id_Barang'];
                                                    $Id_Barang_options = $comp_model->peminjaman_Id_Barang_option_list();
                                                    if (!empty($Id_Barang_options)) {
                                                        foreach ($Id_Barang_options as $option) {
                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                            $Nama_Barang = (!empty($option['Nama_Barang']) ? $option['Nama_Barang'] : $value);
                                                            $Merek = (!empty($option['Merek']) ? $option['Merek'] : $value);
                                                            $Jumlah_Aset = (!empty($option['Jumlah_Aset']) ? $option['Jumlah_Aset'] : $value);
                                                            $selected = ($value == $rec ? 'selected' : null);
                                                    ?>
                                                            <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                Nama: <?php echo $Nama_Barang; ?> - Merek: <?php echo $Merek; ?> - Stok: <?php echo $Jumlah_Aset; ?>
                                                            </option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="Id_User">Id Peminjam <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-Id_User" value="<?php echo $data['Id_User']; ?>" type="text" placeholder="Enter Id Peminjam" required="" name="Id_User" class="form-control" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="Qty">Qty <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-Qty" value="<?php echo $data['Qty']; ?>" type="text" placeholder="Enter Qty" required="" name="Qty" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="Tgl_Pinjam">Tgl_Pinjam <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-Tgl_Pinjam" value="<?php echo $data['Tgl_Pinjam']; ?>" type="date" required="" name="Tgl_Pinjam" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-ajax-status"></div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary" type="submit">
                                    Update
                                    <i class="fa fa-send"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>