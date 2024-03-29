<?php
//  include 'layouts/session.php';
?>
<?php include 'layouts/head-main.php'; ?>



<head>
    <title><?php echo $language["Dashboard"]; ?> | Priequity</title>

    <?php include 'layouts/head.php'; ?>

    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />

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
                            <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Priequity</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <?php
                // conditional dashboard options
                $email = $getuser[0]['useremail'];
                $count_UAPP = $portal->countUserApplications($email);
                if (isAdmin) {
                    $u_app = $portal->applicationList();
                } else {
                    $u_app = $portal->usersApplicationList($getuser[0]['useremail']);
                }


                ?>
                <!-- Counter Elements  -->
                <div class="row">
                    <?php
                    if (isAdmin) {

                    ?>
                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="row align-items-center">


                                        <div class="col-6">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Application</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo $portal->countApplications() ?>">0</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-end">
                                                <a class="text-right" href="manage-application.php" class="btn">See All</a>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Pending Application</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo $portal->countApplications('pending') ?>">0</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-end">
                                                <a class="text-right" href="manage-application.php" class="btn">See All</a>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col-->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Approved Application</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo $portal->countApplications('approved') ?>">0</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-end">
                                                <a class="text-right" href="manage-application.php" class="btn">See All</a>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-h-100">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Applicants</span>
                                            <h4 class="mb-3">
                                                <span class="counter-value" data-target="<?php echo $portal->countApplicant(10001) ?>">0</span>
                                            </h4>
                                        </div>

                                        <div class="col-6">
                                            <div class="d-flex justify-content-end">
                                                <a class="text-right" href="all-users.php" class="btn">See All</a>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        <?php
                    } else {


                    

                        if ($count_UAPP === 0) {
                        ?>
                            <div class="col-xl-12 col-md-12">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">My Total Applications</span>
                                                <h4 class="mb-3">
                                                    <span>You have no application to see! Apply today</span>
                                                </h4>
                                            </div>

                                            <div class="colmd--6">
                                                <div class="d-flex justify-content-end">
                                                    <a type="button" href="apply-now.php" class="btn btn-primary waves-effect waves-light">APPLY NOW</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        <?php
                        } else {
                        ?>
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">My Total Applications</span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?php echo $count_UAPP ?>">0</span>
                                                </h4>
                                            </div>

                                            <div class="col-6">
                                                <div class="d-flex justify-content-end">
                                                    <a class="text-right" href="my-application.php" class="btn">See All</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">My Pending Applications</span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?php echo $portal->countUserApplications($email,'pending')?>">0</span>
                                                </h4>
                                            </div>

                                            <div class="col-6">
                                                <div class="d-flex justify-content-end">
                                                    <a class="text-right" href="my-application.php" class="btn">See All</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                            <div class="col-xl-3 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 lh-1 d-block text-truncate">My Approved Applications</span>
                                                <h4 class="mb-3">
                                                    <span class="counter-value" data-target="<?php $portal->countUserApplications($email,"approved")?>">0</span>
                                                </h4>
                                            </div>

                                            <div class="col-6">
                                                <div class="d-flex justify-content-end">
                                                    <a class="text-right" href="my-application.php" class="btn">See All</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                    <?php
                        }
                    }
                    ?>

                </div><!-- end row-->
                <!-- Counter Ends  -->

                <!-- ------------------------  -->


                <?php
                if ($count_UAPP !== 0) {
                ?>
                    <div class="row">
                        <div class="col-xl-8">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h5 class="card-title me-2">Application Overview</h5>
                                        <div class="ms-auto">
                                            <div>
                                                <button type="button" class="btn btn-soft-primary btn-sm">
                                                    ALL
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                                    1M
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary btn-sm">
                                                    6M
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary btn-sm active">
                                                    1Y
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- add content here  -->
                                    Comin soon

                                    <!-- ================= -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="col-xl-4">
                            <!-- card -->
                            <div class="card">
                                <!-- card body -->
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-4">
                                        <h5 class="card-title me-2">Recent Applications</h5>
                                        <div class="ms-auto">

                                            <a href="manage-application.php" class="btn btn-primary">See All</a>
                                        </div>
                                    </div>

                                    <div class="table">
                                        <div class="">


                                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>App ID</th>
                                                        <th>Name</th>
                                                        <th>Creation Date</th>
                                                        <th>Status</th>

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


                                                        </tr>


                                                    <?php

                                                    }


                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                <?php

                }
                ?>

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

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>


<!-- dashboard init -->
<script src="assets/js/pages/dashboard.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>

</html>