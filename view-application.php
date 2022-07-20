<?php include 'layouts/head-main.php'; ?>

<?php

if (isset($_GET['app-id'])) {
    if (count($portal->getSingleAppData($_REQUEST['app-id'])) === 0) {
        die("invalid prams");
    }
    $singledata = $portal->getSingleAppData($_REQUEST['app-id'])[0];

    if ($singledata['status'] === 'pending') {
        $status_bg = 'bg-warning';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'processing') {
        $status_bg = 'bg-info';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'cancelled') {
        $status_bg = 'bg-danger';
        $status_color = 'text-white';
    }
    if ($singledata['status'] === 'completed') {
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
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="application-status rounded <?php echo $status_bg ?>">
                                    <div class=" h4 p-3 <?php echo $status_color ?>">Application Status: <?php echo $singledata['status'] ?></div>
                                </div>
                                <?php

                                if ($singledata['status'] == "pending") {
                                ?>

                                    <div class="py-5 text-center">
                                        <a class="btn btn-primary waves-effect waves-light" href="action.php?update-app-status=1&app_id=<?php echo $singledata['id'] ?>&app_status=processing&token=<?php echo $token ?>">Process This Application</a>
                                    </div>

                                <?php

                                }
                                if ($singledata['status'] == "processing") {
                                ?>



                                    <div class="card ">


                                        <div class="conv_areaa">
                                            <!-- ====================================================== -->
                                            <!-- ============== CONV AREA Starts ======================= -->
                                            <div class="chat-conversation p-3" data-simplebar>

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
                                                                        <div class="Submission_area">

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
                                                                                            <div class="my-2 me-2 px-4 py-2 rounded-pill bg-info text-white">
                                                                                                <?php echo $files ?>
                                                                                            </div>
                                                                                        <?php
                                                                                        }
                                                                                        ?>


                                                                                    </div>
                                                                                </div>
                                                                                <!-- Submitted Files end -->
                                                                            <?php


                                                                            } else {

                                                                            ?>

                                                                                <!-- Submit Files  -->

                                                                                <div class="submit_files">


                                                                                    <a class="text-center d-block text-primary p-2 outline-none btn-link waves-effect waves-dark" data-bs-toggle="collapse" href="#que<?php echo $conv['id'] ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                                                        <strong>Submit Documents</strong>
                                                                                    </a>
                                                                                    <div class="collapse my-2" id="que<?php echo $conv['id'] ?>">
                                                                                        <div class="card card-body">

                                                                                            <?php
                                                                                            if (isset($_POST['request_file_'.$conv['id']])) {
                                                                                                $ask_for = $_REQUEST['req_message'];
                                                                                                $conv_id = $conv['id'];
                                                                                                $app_id = $singledata['id'];

                                                                                                $uploaded_files = array();


                                                                                                $uploadsDir = __DIR__ . "/_uploads/";
                                                                                                // $allowedFileType = array('jpg', 'png', 'jpeg');



                                                                                                // Velidate if files exist
                                                                                                if (!empty(array_filter($_FILES['fileUpload']['name']))) {

                                                                                                    // Loop through file items
                                                                                                    foreach ($_FILES['fileUpload']['name'] as $id => $val) {
                                                                                                        // Get files upload path

                                                                                                        $getfileName        = $_FILES['fileUpload']['name'][$id];
                                                                                                        $fileName        = $portal->slugify($getfileName);
                                                                                                        $tempLocation    = $_FILES['fileUpload']['tmp_name'][$id];
                                                                                                        $targetFilePath  = $uploadsDir . $fileName;
                                                                                                        $fileType        = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                                                                                                        $uploadDate      = date('Y-m-d-H-i-s');
                                                                                                        $uploadOk = 1;

                                                                                                        // if(in_array($fileType, $allowedFileType))
                                                                                                        if ($fileType !== 'php') {
                                                                                                            if (move_uploaded_file($tempLocation, $targetFilePath)) {
                                                                                                                $sqlVal = $fileName;
                                                                                                            } else {
                                                                                                                $response = array(
                                                                                                                    "status" => "alert-danger",
                                                                                                                    "message" => "File coud not be uploaded."
                                                                                                                );
                                                                                                            }
                                                                                                        } else {
                                                                                                            $response = array(
                                                                                                                "status" => "alert-danger",
                                                                                                                "message" => "Only .jpg, .jpeg and .png file formats allowed."
                                                                                                            );
                                                                                                        }


                                                                                                        // Add into MySQL database
                                                                                                        if (!empty($sqlVal)) {


                                                                                                            array_push($uploaded_files, $sqlVal);
                                                                                                        }
                                                                                                    }
                                                                                                    $data = array(
                                                                                                        'asked_by' =>  $getuser[0]['username'],
                                                                                                        'app_id' => $app_id,
                                                                                                        'submissions' => $ask_for,
                                                                                                        'files' => serialize($uploaded_files)
                                                                                                    );
                                                                                                    if ($portal->updateRequestedFile($conv_id, $data)) {
                                                                                                        // echo "kaj hoise;";
                                                                                                        debug($data);

                                                                                                        echo '<script> window.location.replace("view-application.php?app-id=' . $app_id . '");  </script>';
                                                                                                    }
                                                                                                } else {
                                                                                                    // Error
                                                                                                    $response = array(
                                                                                                        "status" => "alert-danger",
                                                                                                        "message" => "Please select a file to upload."
                                                                                                    );
                                                                                                }
                                                                                            }
                                                                                            ?>

                                                                                            <form action="" method="post" enctype="multipart/form-data">


                                                                                                <div class="mb-3">
                                                                                                    <label for="" class="form-label">Your Files </label>
                                                                                                    <input type="file" class="form-control" name="fileUpload[]" id="file" multiple='multiple'>
                                                                                                </div>
                                                                                                <div class="mb-3">
                                                                                                    <label for="" class="form-label">Remarks </label>
                                                                                                    <textarea class="form-control " name="req_message" ></textarea>
                                                                                                </div>

                                                                                                <input name="request_file_<?php echo  $conv['id']?>" id="" class="col-12 btn btn-primary waves-effect waves-light" type="submit" value="Submit Files">
                                                                                            </form>



                                                                                        </div>
                                                                                        <!-- Submit Files ends  -->
                                                                                    </div>
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
                    <div class="col-md-4">
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


                                <div class="application_letter">
                                    <?php echo $singledata['letter'] ?>
                                </div>

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
    //issues : cannot get multiple classes
    ClassicEditor
        .create(document.querySelector('._remarks'), {
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