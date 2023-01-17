<?php
$comp_model = new SharedController;
$page_element_id = "scan-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view" data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
    ?>
        <div class="bg-light p-3 mb-3">
            <div class="container">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Scan QR Code Barang</h4>
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
                <div class="col-md-12 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class="card animated fadeIn page-content">
                        <script src="https://unpkg.com/html5-qrcode"></script>
                        <div id="qr-reader" style="width:500px; margin:auto;"></div>
                        <script>
                            var lastResult, countResults = 0;

                            function onScanSuccess(decodedText, decodedResult) {
                                if (decodedText !== lastResult) {
                                    ++countResults;
                                    lastResult = decodedText;
                                    // Handle on success condition with the decoded message.
                                    // alert(`Scan result ${decodedText}`, decodedResult);
                                    window.location.replace("<?php print_link("peminjaman/add?barang=") ?>" + `${decodedText}`);
                                }
                            }

                            var html5QrcodeScanner = new Html5QrcodeScanner(
                                "qr-reader", {
                                    fps: 10,
                                    qrbox: 250
                                });
                            html5QrcodeScanner.render(onScanSuccess);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>