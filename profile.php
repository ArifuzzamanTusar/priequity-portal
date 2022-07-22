<?php include 'layouts/head-main.php'; ?>
<?php $getUserMeta = $portal->userAllData($getuser[0]['useremail'])[0]; ?>

<head>

    <title>Profile | Priequity - Admin & Dashboard Template</title>
    <?php include 'layouts/head.php'; ?>
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
                            <h4 class="mb-sm-0 font-size-18">Profile</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Contact</a></li>
                                    <li class="breadcrumb-item active">Profile</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm order-2 order-sm-1">
                                        <div class="d-flex align-items-start mt-3 mt-sm-0">
                                            <div class="flex-shrink-0">
                                                <div class="avatar-xl me-3">
                                                    <img src="assets/images/users/avatar-2.jpg" alt="" class="img-fluid rounded-circle d-block">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div>
                                                    <h5 class="font-size-16 mb-1"><?php echo $getUserMeta['first_name'] ? $getUserMeta['first_name'] . " " . $getUserMeta['last_name'] : $getuser[0]['username'] ?></h5>
                                                    <p class="text-muted font-size-13"><?php echo ($getuser[0]['role'] == 10000) ? 'admin' : 'user' ?></p>

                                                    <div class="d-flex flex-wrap align-items-start gap-2 gap-lg-3 text-muted font-size-13">
                                                        <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>Phone: <?php echo  $getUserMeta['phone'] ?  $getUserMeta['phone'] : 'not set' ?></div>
                                                        <div><i class="mdi mdi-circle-medium me-1 text-success align-middle"></i>Email: <?php echo $getuser[0]['useremail'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto order-1 order-sm-2">
                                        <div class="d-flex align-items-start justify-content-end gap-2">
                                            <div>
                                                <a type="button" href="edit-profile.php" class="btn btn-soft-light"><i class="me-1"></i> Edit Profile</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs-custom card-header-tabs border-top mt-4" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link px-3 active" data-bs-toggle="tab" href="#overview" role="tab">Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <?php
                                        if (!isAdmin) {
                                        ?>
                                            <a class="nav-link px-3" data-bs-toggle="tab" href="#about" role="tab">Applications</a>
                                        <?php
                                        }
                                        ?>

                                    </li>

                                </ul>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="tab-content">
                            <div class="tab-pane active" id="overview" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">User Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <div class="pb-3">
                                                <div class="row">
                                                    <div class="col-xl-2">
                                                        <div>
                                                            <h5 class="font-size-15">Address :</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl">
                                                        <div class="text-muted">
                                                            <p>City: <?php echo  $getUserMeta['city'] ? $getUserMeta['city'] : "not set" ?></p>
                                                            <p>Zipcode: <?php echo  $getUserMeta['zip_code'] ? $getUserMeta['zip_code'] : "not set" ?></p>
                                                            <p>State: <?php echo  $getUserMeta['state'] ? $getUserMeta['state'] : "not set" ?></p>
                                                            <p>Country: <?php echo  $getUserMeta['country'] ? $getUserMeta['country'] : "not set" ?></p>
                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="py-3">
                                                <div class="row">
                                                    <div class="col-xl-2">
                                                        <div>
                                                            <h5 class="font-size-15">Birthday :</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl">
                                                        <div class="text-muted">
                                                            <p><?php echo  $getUserMeta['birthday'] ? $getUserMeta['birthday'] : "not set" ?></p>

                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->


                                <!-- end card -->
                            </div>
                            <!-- end tab pane -->

                            <div class="tab-pane" id="about" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">My Recent Applications</h5>
                                    </div>
                                    <div class="card-body">


                                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>App ID</th>
                                                    <th>Date</th>
                                                    <th>Status</th>

                                                </tr>
                                            </thead>


                                            <tbody>


                                                <?php
                                                $u_app = $portal->usersApplicationList($getuser[0]['useremail']);
                                                foreach ($u_app as $app) {
                                                ?>
                                                    <tr>
                                                        <td> <?php echo $app['id'] ?> </td>
                                                        <td>
                                                            <?php
                                                            echo $app['created_at'];


                                                            ?>
                                                        </td>
                                                        <td> <?php $portal->appStatus($app['status']) ?> </td>


                                                    </tr>


                                                <?php

                                                }


                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end tab pane -->


                        </div>
                        <!-- end tab content -->
                    </div>
                    <!-- end col -->


                    <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container-fluid -->
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

<script src="assets/js/app.js"></script>

</body>

</html>