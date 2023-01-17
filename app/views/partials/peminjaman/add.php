<?php
//check if current user role is allowed access to the pages
$can_scan = ACL::is_allowed("peminjaman/scan");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add" data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Add New Peminjaman</h4>
                    </div>
                    <?php if ($can_scan) { ?>
                        <div class="col-sm-3 ">
                            <a class="btn btn btn-primary my-1" href="<?php print_link("peminjaman/scan") ?>">
                                <i class="fa fa-qrcode"></i>
                                Scan QR Code Barang
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="">
        <div class="container">
            <?php
            if (!empty($_GET['barang'])) {
            ?>
                <?php
                $cek_barang = $comp_model->peminjaman_cek_barang($_GET['barang']);
                if ($cek_barang > 0) {
                ?>
                    <span class="badge badge-primary p-2 mb-2">Hasil scan QR Code Barang Ditemukan | Id = <?php echo $_GET['barang']; ?></span>
                <?php } else { ?>
                    <span class="badge badge-danger p-2 mb-2">Hasil scan QR Code Barang Tidak Ditemukan</span>
                <?php } ?>
            <?php } ?>
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="bg-light p-3 animated fadeIn page-content">
                        <form id="peminjaman-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("peminjaman/add?csrf_token=$csrf_token") ?>" method="post">
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
                                                    $Id_Barang_options = $comp_model->peminjaman_Id_Barang_option_list();
                                                    if (!empty($Id_Barang_options)) {
                                                        foreach ($Id_Barang_options as $option) {
                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                            $Nama_Barang = (!empty($option['Nama_Barang']) ? $option['Nama_Barang'] : $value);
                                                            $Merek = (!empty($option['Merek']) ? $option['Merek'] : $value);
                                                            $Jumlah_Aset = (!empty($option['Jumlah_Aset']) ? $option['Jumlah_Aset'] : $value);
                                                            if (!empty($_GET['barang'])) {
                                                                $selected = ($value == $_GET['barang'] ? 'selected' : null);
                                                                $disabled = ($cek_barang > 0 && $value != $_GET['barang']  ? 'disabled' : null);
                                                            } else {
                                                                $selected = $this->set_field_selected('Id_Barang', $value, "");
                                                                $disabled = $this->set_field_selected('Id_Barang', $value, "");
                                                            }
                                                    ?>
                                                            <option <?php echo $selected; ?> <?php echo $disabled; ?> value="<?php echo $value; ?>">
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
                                                <input id="ctrl-Id_User" value="<?php echo USER_ID; ?>" type="text" placeholder="Enter Id Peminjam" required="" name="Id_User" class="form-control" readonly />
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
                                                <input id="ctrl-Qty" value="<?php echo $this->set_field_value('Qty', ""); ?>" type="number" placeholder="Enter Qty" step="1" required="" name="Qty" class="form-control " />
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
                                                <input id="ctrl-Tgl_Pinjam" value="<?php echo date('Y-m-d'); ?>" type="date" required="" name="Tgl_Pinjam" class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                    <div class="form-ajax-status"></div>
                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                        <i class="fa fa-send"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>