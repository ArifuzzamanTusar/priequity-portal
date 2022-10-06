<?php include 'layouts/head-main.php'; ?>

<?php
$u_app = $portal->applicationList();

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
                            <h4 class="mb-sm-0 font-size-18">All Applications</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Application</a></li>
                                    <li class="breadcrumb-item active">All Applications</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <!-- ###############################  TABLE START #############################  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="datatable-buttons_wrapper"></div>
                                    </div>
                                    <div class="col-md-6">
                                        -
                                    </div>
                                </div>
                            </div> -->
                            <div class="card-body">


                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>App ID</th>
                                            <th>Name</th>
                                            <th>Creation Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>


                                        <?php
                                        foreach ($u_app as $app) {

                                            // debug($app['id']);

                                        ?>
                                            <tr>
                                                <td> <?php echo $app['id'] ?> </td>
                                                <td> <?php echo $app['first_name'] . " " . $app['last_name'] ?> </td>
                                                <td> <?php echo $app['created_at'] ?> </td>
                                                <td> <?php echo $app['status'] ?> </td>
                                                <td>
                                                    <button title="Quick View" type="button" class="btn btn-warning waves-effect waves-light mx-2" data-bs-toggle="modal" data-bs-target=".<?php echo 'edit-' . $app['id'] ?>"><i class="far fa-eye"></i></button>
                                                    <a href="application.php?app-id=<?php echo $app['id'] ?>" title="Manage" class="btn btn-primary waves-effect waves-light mx-2"><i class="fas fa-cog"></i></a>
                                                </td>

                                            </tr>
                                            <div class="modal fade <?php echo 'edit-' . $app['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Managing <span class="text-warning"><?php echo $app['username'] ?></span> </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <?php
                                                            $singledata = $portal->getSingleAppData($app['id'])[0];
                                                            ?>
                                                            <p><strong>Applicant Name: </strong> <?php echo $singledata['first_name'] . " " . $singledata['last_name'] ?></p>
                                                            <p><strong>Applicant Email: </strong> <a href="mailto:<?php echo $singledata['useremail'] ?>"><?php echo $singledata['useremail'] ?></a> </p>
                                                            <p><strong>Applicant phone: </strong> <a href="tel:<?php echo $singledata['useremail'] ?>"><?php echo $singledata['phone'] ?></a> </p>
                                                            <p><strong>Date: </strong> <?php echo $singledata['created_at'] ?> </p>
                                                         
                                                            <?php

                                                            ?>

                                                            <center>
                                                                <div class="py-3"></div>
                                                            <a href="application.php?app-id=<?php echo $app['id'] ?>" title="Manage" class="btn btn-primary waves-effect waves-light mx-2"><i class="fas fa-cog"></i> Manage This Application</a>
                                                

                                                            </center>

                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

                                        <?php

                                        }


                                        ?>

                                    </tbody>
                                </table>
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

</body>

</html>