<?php include 'layouts/head-main.php'; ?>

<!-- Sweet Alert-->
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>

<?php


if (isset($_POST['update_profile'])) {
    $phone_number = $_REQUEST['phone_number'];
    $first_name = $_REQUEST['f_name'];
    $last_name = $_REQUEST['l_name'];
    $gender = $_REQUEST['gender'];
    $birthday = $_REQUEST['birthday'];
    $country = $_REQUEST['country'];
    $state = $_REQUEST['state'];
    $city  = $_REQUEST['city'];
    $zip_code = $_REQUEST['zip_code'];

    // ------
    $data = array(
        'phone' => $phone_number,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'gender' => $gender,
        'birthday' => $birthday,
        'country' => $country,
        'state' => $state,
        'city' => $city,
        'zip_code' => $zip_code
    );

    $portal->updateUserMeta($getuser[0]['useremail'], $data);
    // if ($portal->updateUserMeta($getuser[0]['useremail'], $data)) {
    //     header("location: unauthorised.php");
    // }
}

?>

<?php
$getUserMeta = $portal->userAllData($getuser[0]['useremail']);
?>








<head>

    <title>Edit Profile</title>
    <?php include 'layouts/head.php'; ?>


    <!-- datepicker css -->
    <link rel="stylesheet" href="assets/libs/flatpickr/flatpickr.min.css">
    <!-- choices css -->
    <link href="assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />





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
                                <h4 class="card-title">Update My Profile</h4>
                                <p class="card-title-desc">Fill Up data and keep profile up to date to easy apply everytime</p>
                            </div>
                            <!-- end card header -->

                            <div class="card-body">
                                <div>

                                    <form id="pristine-valid-example" novalidate method="post" action="">

                                        <h5>Primary Information</h5>
                                        <div class="row">
                                            <?php /*isset($data) ? var_dump($data) : '' */ ?>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Username</label>
                                                    <input name="username" type="text" required data-pristine-required-message="Please Enter a username" class="form-control" value="<?php echo $getuser[0]['username'] ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Email</label>
                                                    <input type="email" required data-pristine-required-message="Please Enter a Email" class="form-control" value="<?php echo $getuser[0]['useremail'] ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Phone Number</label>
                                                    <input name="phone_number" value="<?php echo (isset($phone_number)) ? ($phone_number) : $getUserMeta[0]['phone'] ?>" placeholder="+(123) - 456-78-90" type="text" data-pristine-pattern="/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/" data-pristine-pattern-message="Enter Valid Phone Number" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="py-3"></div>

                                            <!-- -------------------------------  -->
                                            <h5>Personal Information</h5>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>First Name</label>
                                                    <input name="f_name" type="text" required data-pristine-required-message="First Name" class="form-control" value="<?php echo (isset($first_name)) ? ($first_name) : $getUserMeta[0]['first_name'] ?>" placeholder="John" />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Last Name</label>
                                                    <input name="l_name" type="text" required data-pristine-required-message="Last Name" class="form-control" value="<?php echo (isset($last_name)) ? ($last_name) : $getUserMeta[0]['last_name'] ?>" placeholder="Doe" />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Gender</label>
                                                    <select name="gender" class="form-control" name="" id="">
                                                        <option value="male" <?php echo (($getUserMeta[0]['gender'] == 'male')) ? 'selected' : '' ?>>Male</option>
                                                        <option value="female" <?php echo (($getUserMeta[0]['gender'] == 'female')) ? 'selected' : ''  ?>>Female</option>
                                                        <option value="others" <?php echo (($getUserMeta[0]['gender'] == 'others')) ? 'selected' : ''  ?>>Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Birthday</label>
                                                    <input name="birthday" value="<?php echo (isset($birthday)) ? ($birthday)  : $getUserMeta[0]['birthday'] ?>" type="text" class="form-control" id="birthdayPicker" placeholder="Select your birthday">
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="mb-3">
                                                    <label for="choices-single-default" class="form-label ">Country</label>
                                                    <select name="country" class="form-control" data-trigger name="choices-single-default" id="choices-single-default" placeholder="This is a search placeholder">
                                                        <option value="">Select Country</option>


                                                        <?php
                                                        $myCountry =  $getUserMeta[0]['country'];
                                                        $get_country_list = $portal->countryData();
                                                        // var_dump($get_country_list);
                                                        foreach ($get_country_list as $list) {
                                                        ?>
                                                            <option value="<?php echo $list['name'] ?>" <?php echo ($list['name'] === $myCountry) ? 'selected' : '' ?>> <?php echo $list['nicename'] ?> </option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label ">State</label>
                                                    <input value="<?php echo (isset($state)) ? ($state) :  $getUserMeta[0]['state'] ?>" name="state" type="text" class="form-control" placeholder="California">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label ">City</label>
                                                    <input value="<?php echo (isset($city)) ? ($city) :  $getUserMeta[0]['city'] ?>" name="city" type="text" class="form-control" placeholder="San Diego">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label ">ZIP Code</label>
                                                    <input value="<?php echo (isset($zip_code)) ? ($zip_code) :  $getUserMeta[0]['zip_code'] ?>" name="zip_code" type="number" class="form-control" placeholder="22400">
                                                </div>
                                            </div>


                                        </div>
                                        <!-- end row -->


                                        <div class="form-group">
                                            <button name="update_profile" type="submit" class="btn btn-primary waves-effect waves-light">Update Profile</button>
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
                                    if (isset($_REQUEST['message'])) {

                                        $message = $_REQUEST['message'];
                                        echo '<script>triggerSuccess("' . $message . '")</script>';
                                    }

                                    ?>

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
        var form = document.getElementById("pristine-valid-example");
        var pristine = new Pristine(form);
        form.addEventListener('submit', function(e) {

            var valid = pristine.validate();
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

<!-- Date picker  -->
<!-- datepicker js -->
<script src="assets/libs/flatpickr/flatpickr.min.js"></script>
<script>
    flatpickr('#birthdayPicker');
</script>

<!-- Choice  -->
<!-- choices js -->
<script src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<!-- init js -->


<script>
    // Chocies Select plugin
    document.addEventListener('DOMContentLoaded', function() {
        var genericExamples = document.querySelectorAll('[data-trigger]');
        for (i = 0; i < genericExamples.length; ++i) {
            var element = genericExamples[i];
            new Choices(element, {
                placeholderValue: '-',
                searchPlaceholderValue: 'Search Countries',
            });
        }

    });
</script>



<script src="assets/js/app.js"></script>

</body>

</html>