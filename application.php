<?php include 'layouts/head-main.php'; ?>
<?php $portal->requireAdmin(); ?>
<?php

if (isset($_GET['app-id'])) {
    if (count($portal->getSingleAppData($_REQUEST['app-id'])) === 0) {
        die("invalid prams");
    }
    $singledata = $portal->getSingleAppData($_REQUEST['app-id'])[0];

    if ($singledata['status'] === 'unpaid') {
        $status_bg = 'bg-danger';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'pending') {
        $status_bg = 'bg-warning';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'require-files') {
        $status_bg = 'bg-warning';
        $status_color = 'text-white';
    }

    if ($singledata['status'] === 'processing') {
        $status_bg = 'bg-info';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'rejected') {
        $status_bg = 'bg-danger';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'approved') {
        $status_bg = 'bg-success';
        $status_color = 'text-white';
    }

} else {
    die("invalid prams");
}




$token = md5($getuser[0]['username']);


?>

<head>
    <title><?php echo $language["Dashboard"]; ?> | Priequity</title>

    <?php include 'layouts/head.php'; ?>

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>
</head>

<?php include 'layouts/body.php'; ?>

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include 'layouts/menu.php'; ?>
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Application #<?php echo $singledata['id'] ?></h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Application</a></li>
                                    <li class="breadcrumb-item active">Application#<?php echo $singledata['id'] ?></li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <!-- ###############################  TABLE START #############################  -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="application-status rounded <?php echo $status_bg ?>">
                                    <div class=" h4 p-3 <?php echo $status_color ?>">Application Status: <?php echo $singledata['status'] ?></div>
                                </div>
                                <?php

                                if ($singledata['status'] == "pending") {
                                ?>

                                    <div class="py-5 text-center">
                                        <p>Analyze the application. Send the invoice to the client if everything looks good.</p>
                                        <p>Client's Email: <a href="mailto:<?php echo $singledata['useremail'] ?>"><?php echo $singledata['useremail'] ?></a></p>
                                        <a class="btn btn-primary waves-effect waves-light" href="action.php?update-app-status=1&app_id=<?php echo $singledata['id'] ?>&app_status=unpaid&token=<?php echo $token ?>">Invoice Sent, Proceed to the Next Step</a>
                                    </div>

                                <?php

                                }
                                if ($singledata['status'] == "require-files") {
                                ?>

                                    <div class="py-5 text-center">
                                        <p>Waiting for Clients to Upload the Required Files</p>
                                        <p>Client's Email: <a href="mailto:<?php echo $singledata['useremail'] ?>"><?php echo $singledata['useremail'] ?></a></p>
                                        <!-- <a class="btn btn-primary waves-effect waves-light" href="action.php?update-app-status=1&app_id=<?php echo $singledata['id'] ?>&app_status=unpaid&token=<?php echo $token ?>">Invoice Sent, Proceed to the Next Step</a> -->
                                    </div>

                                <?php

                                }

                                if ($singledata['status'] == "unpaid") {
                                ?>

                                    <div class="py-5 text-center">
                                        <p>Check the payment gateway. If the client paid the fees, proceed with the application.</p>
                                        <a class="btn btn-primary waves-effect waves-light" href="action.php?update-app-status=1&app_id=<?php echo $singledata['id'] ?>&app_status=processing&token=<?php echo $token ?>">Process This Application</a>
                                    </div>

                                <?php

                                }
                                if ($singledata['status'] == "processing") {
                                ?>



                                    <div class="card p-3">


                                        <div class="conv_areaa">
                                            <!-- ====================================================== -->
                                            <!-- ============== CONV AREA Starts ======================= -->
                                            <div class="chat-conversation p-3 px-2" data-simplebar>

                                                <?php
                                                $conv_list = $portal->requestFileList($singledata['id']);

                                                foreach ($conv_list as $conv) {
                                                    $conv_date = date_create($conv['created_at']);
                                                ?>


                                                    <ul class="list-unstyled mb-0">
                                                        <li>
                                                            <div class="conversation-list">
                                                                <div class="shadow p-3">
                                                                    <div class="admin_message">
                                                                        <span class="date py-2 px-3 rounded-pill " style="background:rgba(162, 255, 177,0.5)"> <i class="fas fa-clock"></i> <?php echo date_format($conv_date, "d F - g:ia") ?> </span>
                                                                        <div class="p-2"></div>
                                                                        <div class="text-success">
                                                                            <?php echo $conv['ask_for'] ?>
                                                                        </div>
                                                                        <hr>



                                                                        <div class="submission_area">
                                                                            <?php

                                                                            $s_files =  unserialize($conv['files']);


                                                                            if ($s_files && count($s_files) > 0) {

                                                                            ?>
                                                                                <!-- Submitted Files  -->
                                                                                <div class="submitted_files">
                                                                                    <h6 class="text-primary"> <i class="fas fa-reply"></i> Submitted Files</h6>
                                                                                    <div class=""> <?php echo $conv['submissions'] ?> </div>
                                                                                    <div class="d-flex flex-wrap">
                                                                                        <?php
                                                                                        foreach ($s_files as $files) {
                                                                                        ?>
                                                                                            <a href="_uploads/<?php echo $files ?>" target="_BLANK">
                                                                                                <div class="my-2 me-2 px-4 py-2 rounded-pill bg-info text-white">
                                                                                                    <?php echo $files ?>
                                                                                                </div>
                                                                                            </a>
                                                                                        <?php
                                                                                        }
                                                                                        ?>


                                                                                    </div>
                                                                                </div>
                                                                                <!-- Submitted Files end -->
                                                                            <?php


                                                                            } else {
                                                                            ?>
                                                                                <div class="p-3 bg-warning text-white">
                                                                                    Waiting for client's response . . .
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>


                                                <?php
                                                }

                                                ?>
                                            </div>
                                            <!-- ====================================================== -->
                                            <!-- ============== CONV AREA Ends======================= -->

                                        </div>



                                        <a class="text-center text-success p-3 outline-none btn-link waves-effect waves-dark" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <strong>Ask For More Documents</strong>
                                        </a>


                                        <div class="collapse my-2" id="collapseExample">
                                            <div class="card card-body">
                                                <?php
                                                if (isset($_POST['request_file'])) {
                                                    $ask_for = $_REQUEST['req_message'];
                                                    $app_id = $singledata['id'];


                                                    $data = array(
                                                        'asked_by' =>  $getuser[0]['username'],
                                                        'app_id' => $app_id,
                                                        'ask_for' => $ask_for
                                                    );
                                                    if ($portal->requestFiles($app_id, $data)) {
                                                        // echo "kaj hoise;";

                                                        echo '<script> window.location.replace("application.php?app-id=' . $app_id . '");  </script>';
                                                    }
                                                }
                                                ?>

                                                <form action="" method="post">

                                                    <div class="mb-3">
                                                        <label for="" class="form-label"></label>
                                                        <textarea class="form-control" name="req_message" id="ckeditor-classic" rows="3"></textarea>
                                                    </div>

                                                    <input name="request_file" id="" class="col-12 btn btn-primary waves-effect waves-light" type="submit" value="Ask Now">
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                <?php



                                } else {
                                ?>
                                    <!-- <a href="">Unknown</a> -->
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4>Application Details</h4>
                                <hr>
                                <p><strong>Applicant Name: </strong> <?php echo $singledata['first_name'] . " " . $singledata['last_name'] ?></p>
                                <p><strong>Applicant Email: </strong> <a href="mailto:<?php echo $singledata['useremail'] ?>"><?php echo $singledata['useremail'] ?></a> </p>
                                <p><strong>Applicant phone: </strong> <a href="tel:<?php echo $singledata['phone'] ?>"><?php echo $singledata['phone'] ?></a> </p>
                                <p><strong>Application created_at: </strong> <?php echo $singledata['created_at'] ?> </p>
                                <p><strong>Company Name: </strong> <?php echo $singledata['company_name'] ?> </p>
                                <p><strong>Position: </strong> <?php echo $singledata['position'] ?> </p>
                                <p><strong>Business address: </strong> <?php echo $singledata['business_address'] ?> </p>
                                <p><strong>State: </strong> <?php echo $singledata['state'] ?> </p>
                                <p><strong>City: </strong> <?php echo $singledata['city'] ?> </p>
                                <p><strong>Zip Code: </strong> <?php echo $singledata['zip_code'] ?> </p>
                                <p><strong>Capital Uses: </strong> <?php echo $singledata['capital_uses'] ?> </p>
                                <p><strong>Capital Need: </strong> <?php echo $singledata['capital_need'] ?> </p>
                                <p><strong>Experiences: </strong> <?php echo $singledata['experience'] ?> </p>
                                <div class="py-3"></div>
                                <?php

                                if (isset($singledata['attachment']) && strlen($singledata['attachment']) !== 0) {
                                ?>
                                    <div><a class=" py-3 px-5 attachments bg-success text-white waves-effect waves-light" href="_uploads/<?php echo $singledata['attachment']  ?>">Download Attachment (<?php echo $singledata['attachment'] ?>)</a> </div>

                                <?php

                                }

                                ?>


                                <div class="py-3"></div>
                                <div class="application_letter">
                                    <?php echo $singledata['letter'] ?>
                                </div>

                            </div>


                        </div>

                        <div class="card">
                            <div class="card-body p-2">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger waves-effect waves-light me-3" data-bs-toggle="modal" data-bs-target="#delete_application_modal">
                                    Delete Application
                                </button>
                                <button type="button" class="btn btn-warning waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#update_application_status_modal">
                                    Update Application status
                                </button>



                                <!-- |||||||||||||||||| MODALS ||||||||||||||  -->

                                <!-- Modal for  Delete Application  -->
                                <div class="modal fade" id="delete_application_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Are you sure to delete?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <center>

                                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                    <lottie-player src="assets/lottie/15120-delete.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></lottie-player>

                                                    <div class="py-3">
                                                        <p>Type "CONFIRM" to delete this application</p>
                                                        <input class="form-control text-center" type="text" placeholder="CONFIRM" id="confirm_delete">
                                                    </div>
                                                    <div class="py-3">
                                                        <a id="delete_button" href="action.php?delete-application=<?php echo $singledata['id'] ?>" class="btn btn-danger waves-effect waves-light col-12"><i class="fas fa-exclamation-triangle"></i> Yes! I'm sure to <strong>DELETE</strong></a>
                                                    </div>
                                                </center>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ----------------------  -->
                                <!-- Modal for  Delete Application  -->
                                <div class="modal fade" id="update_application_status_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Update Application Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="py-3">
                                                    <?php
                                                    if (isset($_POST['change_app_status'])) {

                                                        $app_id = $singledata['id'];

                                                        if ($portal->updateApplicationStatus($singledata['id'], $_REQUEST['status'])) {

                                                            echo '<script> window.location.replace("application.php?app-id=' . $app_id . '");  </script>';
                                                        } else {
                                                            echo "error";
                                                        }
                                                    }

                                                    ?>

                                                    <form action="" method="post">
                                                        <div class="mb-3">
                                                            <label for="" class="form-label">Change Application Status</label>
                                                            <select class="form-control" name="status" id="">
                                                                <option value="approved">approved</option>
                                                                <option value="unpaid">unpaid</option>
                                                                <option value="processing">processing</option>
                                                                <option value="pending">pending</option>
                                                                <option value="require-files">Require Files</option>
                                                                <option value="rejected">rejected</option>
                                                            </select>
                                                        </div>
                                                        <div class="py-3">
                                                            <button type="submit" name="change_app_status" class="btn btn-danger waves-effect waves-light col-12">Update Status</button>
                                                        </div>

                                                    </form>

                                                </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ----------------------  -->



                                <!-- |||||||||||||||||||||| MODAL ENDS |||||||||||||||| -->
                            </div>
                        </div>
                        <!-- end cardaa -->
                    </div> <!-- end col -->
                </div> <!-- end row -->




                <!-- ###############################  TABLE ENDS #############################  -->


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include 'layouts/footer.php'; ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right Sidebar -->
<?php include 'layouts/right-sidebar.php'; ?>
<!-- /Right-bar -->

<!-- JAVASCRIPT -->
<?php include 'layouts/vendor-scripts.php'; ?>
<!-- ckeditor -->
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>


<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="assets/libs/jszip/jszip.min.js"></script>
<script src="assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

<!-- Datatable init js -->
<script src="assets/js/pages/datatables.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<!-- ------ -->

<!-- Delete JS  -->


<script>
    document.getElementById("confirm_delete").addEventListener("keyup", myFunction);
    document.getElementById("delete_button").style.display = "none";

    function myFunction() {
        var x = document.getElementById("confirm_delete");
        x.value = x.value.toUpperCase();
        if (x.value == "CONFIRM") {

            document.getElementById("delete_button").style.display = "block";
        } else {
            document.getElementById("delete_button").style.display = "none";
        }
    }



    ClassicEditor
        .create(document.querySelector('#ckeditor-classic'), {
            removePlugins: ['Heading'],
            toolbar: ['bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'link']
        })
        .then(function(editor) {
            editor.ui.view.editable.element.style.height = '100px';
        })
        .catch(function(error) {
            console.error(error);
        });
</script>



</body>

</html>