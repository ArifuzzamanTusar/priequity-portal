<?php include 'layouts/head-main.php'; ?>

<head>

    <title>Edit Profile</title>
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
                            <h4 class="mb-sm-0 font-size-18">Edit Profile</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Profile</a></li>
                                    <li class="breadcrumb-item active">Edit</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <!-- end row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Password Update</h4>
                                <p class="card-title-desc">Fill Up data and keep profile up to date to easy apply everytime</p>
                            </div>
                            <!-- end card header -->

                            <div class="card-body">
                                <div>

                                    <form id="pristine-password-update-form" novalidate method="post" action="">
                                        <input type="hidden" />

                                        <div class="row">


                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Password (required)</label>
                                                    <input type="password" id="pwd" required data-pristine-required-message="Please Enter a password" data-pristine-pattern="/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/" data-pristine-pattern-message="Minimum 8 characters, at least one uppercase letter, one lowercase letter and one number" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Retype password</label>
                                                    <input type="password" data-pristine-equals="#pwd" data-pristine-equals-message="Passwords don't match" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end row -->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                        <!-- end card -->
                    </div>
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


<!-- ||||||||||||| PRISTINE JS FORM VALIDATION ||||||| -->
<!-- pristine js -->
<script src="assets/libs/pristinejs/pristine.min.js"></script>
<!-- form validation -->

<script>
    window.onload = function() {
        // pristinejs validation


        var password_form = document.getElementById("pristine-password-update-form");
        var passwordvalidate = new Pristine(password_form);
        password_form.addEventListener('submit', function(e) {

            var valid = passwordvalidate.validate();
            // alert('Form is valid: ' + valid);
            if (valid) {
                return true;
            } else {
                e.preventDefault();
            }


        });

    }
</script>
<!-- ||||||||||||||||||||||||||||||| -->


<script src="assets/js/app.js"></script>

</body>

</html>