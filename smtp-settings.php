<?php include 'layouts/head-main.php'; ?>
<?php $portal->requireAdmin(); ?>



<head>
    <title><?php echo $language["Dashboard"]; ?> | Priequity</title>

    <?php include 'layouts/head.php'; ?>

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-style.php'; ?>


    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
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
                            <h4 class="mb-sm-0 font-size-18">Email Server Settings</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                                    <li class="breadcrumb-item active">SMTP</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- ------------------------  -->
                <div class="row">

                    <?php
                    $site = '2d58745e5af8524a5c0f9366ab25d493f98b160f';
                    $site_options = $portal -> getOptions($site)[0];
                    if (isset($_POST['update-smtp'])) {
                        if ($portal->updateSMTP($site, $_REQUEST)) {
                            echo '<script> window.location.replace("smtp-settings.php?status=SMTP settings updated!");  </script>';
                        }
                    }

                    ?>


                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">SMTP Host Name</label>
                                    <input type="text" class="form-control" name="smtp_host" id="" placeholder="" value="<?php echo $site_options['smtp_host'] ? $site_options['smtp_host'] : "" ?>">
                                    <small class="form-text text-muted">Help text</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">SMTP User</label>
                                    <input type="text" class="form-control" name="smtp_user" id="" placeholder="" value="<?php echo $site_options['smtp_user'] ? $site_options['smtp_user'] : "" ?>">
                                    <small class="form-text text-muted">Help text</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">SMTP Password</label>
                                    <input type="text" class="form-control" name="smtp_password" id="" placeholder="" value="<?php echo $site_options['smtp_password'] ? $site_options['smtp_password'] : "" ?>">
                                    <small class="form-text text-muted">Help text</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">SMTP PORT</label>
                                    <input type="text" class="form-control" name="smtp_port" id="" placeholder="" value="<?php echo $site_options['smtp_port'] ? $site_options['smtp_port'] : "" ?>">
                                    <small class="form-text text-muted">Help text</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">

                                    <input type="submit" class="btn btn-primary" value="Save Changes" name="update-smtp">

                                </div>
                            </div>

                        </div>


                    </form>

                    <script>
                        function triggerSuccess(message) {
                            Swal.fire({
                                title: 'Well Done',
                                text: message,
                                icon: 'success',
                                confirmButtonColor: '#5156be',
                                cancelButtonColor: "#fd625e"
                            })
                        }
                    </script>

                    <?php
                    if (isset($_REQUEST['status'])) {

                        $message = $_REQUEST['status'];
                        echo '<script>triggerSuccess("' . $message . '")</script>';
                    }

                    ?>

                </div>



                <!-- end row-->


                <!-- end row -->
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




<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>