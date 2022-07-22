<?php include 'layouts/head-main.php'; ?>

<!-- Sweet Alert-->
<link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>



<?php
$getUserMeta = $portal->userAllData($getuser[0]['useremail']);
?>








<head>

    <title>Create Application</title>
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


                <!-- ======================================================== -->
                <!-- PHP OPERATIONS -->
                <!-- =============================================== -->






                <?php


                if (isset($_POST['create_application'])) {
                    $useremail = $_REQUEST['useremail'];

                    if ($useremail === $getuser[0]['useremail']) {
                        $first_name = $_REQUEST['f_name'];
                        $last_name = $_REQUEST['l_name'];
                        // mail from database
                        $phone_number = $_REQUEST['phone_number'];

                        $company_name = $_REQUEST['company_name'];
                        $position = $_REQUEST['position'];
                        $business_address = $_REQUEST['business_address'];
                        $state = $_REQUEST['state'];
                        $city  = $_REQUEST['city'];
                        $zip_code = $_REQUEST['zip_code'];
                        $country = $_REQUEST['country'];


                        $capital_uses = $_REQUEST['capital_uses'];
                        $capital_need = $_REQUEST['capital_need'];
                        $experience = $_REQUEST['experience'];
                        $letter = $_REQUEST['letter'];

                        // Attachments



                        // ------------------------------

                        if (isset($_FILES["attachment"]['tmp_name']) && $_FILES["attachment"]['tmp_name'] !== '') {

                            // debug($_FILES["attachment"]);

                            $filepath = $_FILES['attachment']['tmp_name'];
                            $fileSize = filesize($filepath);
                            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
                            $filetype = finfo_file($fileinfo, $filepath);

                            if ($fileSize === 0) {
                                $fileSizeError = ' <div class="bg-danger text-white p-2">File Empty</div>';
                            }

                            if ($fileSize > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))

                                $fileSizeError = ' <div class="bg-danger text-white p-2">File Too Big please Upload max 3M or attach drive link bellow</div>';
                            }



                            $filename =  $getuser[0]['username'] . "-" . rand(1000, 10000); // I'm using the original name here, but you can also change the name of the file here
                            $extension =  pathinfo(basename($_FILES["attachment"]["name"]), PATHINFO_EXTENSION);

                            if ($extension !== 'php') {
                                # code...

                                // debug($extension);
                                $targetDirectory = __DIR__ . "/_uploads"; // __DIR__ is the directory of the current PHP file

                                $newFilepath = $targetDirectory . "/" . $filename . "." . $extension;

                                if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
                                    die("Can't move file.");
                                }
                                unlink($filepath); // Delete the temp file

                                $attachment = $filename . "." . $extension;
                            } else {
                                $fileSizeError = ' <div class="bg-danger text-white p-2">Invalid File Type</div>';
                                $attachment = '';
                            }
                        } else {
                            $attachment = '';
                        }





                        // ------
                        $data = array(
                            'username' =>  $getuser[0]['username'],
                            'first_name' => $first_name,
                            'last_name' => $last_name,
                            'phone' => $phone_number,
                            'company_name' => $company_name,
                            'position' => $position,
                            'business_address' => $business_address,
                            'state' => $state,
                            'city' => $city,
                            'zip_code' => $zip_code,
                            'country' => $country,
                            'capital_uses' => $capital_uses,
                            'capital_need' => $capital_need,
                            'experience' => $experience,
                            'attachment' => $attachment,
                            'letter' => $letter
                        );
                    }
                    // Else userVerification failed
                    else {
                        header('location: unauthorised.php?errorcode=' . $useremail . " " . $getuser[0]['useremail'] . '');
                    }

                    // debug($data);



                    // $portal->saveApplication($getuser[0]['useremail'], $data);
                    if ($portal->saveApplication($getuser[0]['useremail'], $data)) {

                        // header("location : apply-nowl.php?message=hoise re" );
                        // header("location: apply-now.php?message=hoise re");
                        $success_message = "done";
                    } else {
                        $submissionError = ' <div class="bg-danger text-white p-2">Something Went Wrong!</div>';
                    }
                }

                ?>








                <!-- 
===============================================
===============================================
 -->























                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Application</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Application</a></li>
                                    <li class="breadcrumb-item active">Apply New</li>
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
                                <h4 class="card-title">Apply now</h4>
                                <p class="card-title-desc">Fill Up data and submit to apply today</p>
                            </div>
                            <!-- end card header -->

                            <div class="card-body">
                                <div>


                                    <form id="pristine-valid-example" novalidate method="post" action="" enctype="multipart/form-data">


                                        <div class="row">
                                            <?php /*isset($data) ? var_dump($data) : '' */ ?>

                                            <input name="username" type="hidden" class="form-control" value="<?php echo $getuser[0]['username'] ?>" readonly />


                                            <div class="py-3"></div>

                                            <!-- -------------------------------  -->
                                            <h5>Personal Information</h5>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>First Name</label>
                                                    <input name="f_name" type="text" required data-pristine-required-message="Enter First Name" class="form-control" value="<?php echo (isset($first_name)) ? ($first_name) : $getUserMeta[0]['first_name'] ?>" placeholder="John" />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Last Name</label>
                                                    <input name="l_name" type="text" required data-pristine-required-message="Enter Last Name" class="form-control" value="<?php echo (isset($last_name)) ? ($last_name) : $getUserMeta[0]['last_name'] ?>" placeholder="Doe" />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Email</label>
                                                    <input name="useremail" type="email" required data-pristine-required-message="Please Enter a Email" class="form-control" value="<?php echo $getuser[0]['useremail'] ?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Phone Number</label>
                                                    <input name="phone_number" value="<?php echo (isset($phone_number)) ? ($phone_number) : $getUserMeta[0]['phone'] ?>" placeholder="+(123) - 456-78-90" type="text" data-pristine-pattern="/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/" data-pristine-pattern-message="Enter Valid Phone Number" required data-pristine-required-message="Enter Phone Number" class="form-control" />
                                                </div>
                                            </div>

                                            <div class="py-3"></div>

                                            <h5>Business Information</h5>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">Company</label>
                                                    <input value="<?php echo (isset($business_address)) ? ($business_address) : '' ?>" name="company_name" type="text" class="form-control" placeholder="California">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">Position</label>
                                                    <input value="<?php echo (isset($business_address)) ? ($business_address) : '' ?>" name="position" type="text" class="form-control" placeholder="California">
                                                </div>
                                            </div>

                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">Business Address</label>
                                                    <input value="<?php echo (isset($business_address)) ? ($business_address) : '' ?>" name="business_address" type="text" class="form-control" placeholder="California">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">City</label>
                                                    <input value="<?php echo (isset($city)) ? ($city) :  $getUserMeta[0]['city'] ?>" name="city" type="text" class="form-control" placeholder="San Diego">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">State</label>
                                                    <input value="<?php echo (isset($state)) ? ($state) :  $getUserMeta[0]['state'] ?>" name="state" type="text" class="form-control" placeholder="California">
                                                </div>
                                            </div>

                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">ZIP Code</label>
                                                    <input value="<?php echo (isset($zip_code)) ? ($zip_code) :  $getUserMeta[0]['zip_code'] ?>" name="zip_code" type="number" class="form-control" placeholder="22400">
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="choices-single-default" class="form-label ">Country</label>

                                                    <?php
                                                    $myCountry = "UNITED STATES";
                                                    // $myCountry =  $getUserMeta[0]['country'];
                                                    $get_country_list = $portal->countryData();
                                                    ?>


                                                    <select name="country" class="form-control" data-trigger name="choices-single-default" id="choices-single-default" placeholder="This is a search placeholder">
                                                        <option value="">Select Country</option>
                                                        <?php
                                                        foreach ($get_country_list as $list) {
                                                        ?>
                                                            <option value="<?php echo $list['name'] ?>" <?php echo ($list['name'] === $myCountry) ? 'selected' : '' ?>> <?php echo $list['nicename'] ?> </option>
                                                        <?php
                                                        }
                                                        ?>

                                                    </select>

                                                </div>
                                            </div>


                                            <div class="py-3"></div>

                                            <h5>Capital Information</h5>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">Capital Needed</label>
                                                    <input name="capital_need" type="number" class="form-control" placeholder="$5,000" required data-pristine-required-message="Enter Desired Capital">
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label class="form-label ">Capital Use (How your company is planning to use it)</label>
                                                    <!-- <input name="capital_uses" type="text" class="form-control" placeholder="Descri" > -->
                                                    <textarea name="capital_uses" class="form-control" id="" cols="30" rows="1" placeholder="Describe How your company is planning to use it" required data-pristine-required-message="Enter Current Capital usages"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-6">
                                                <div class="form-group mb-3">
                                                    <label>Experience (Years)</label>
                                                    <input name="experience" type="number" class="form-control" placeholder="9+" required data-pristine-required-message="Enter Your Experiences">

                                                </div>
                                            </div>


                                            <div class="col-xl-12 col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label ">Upload Business Plan for review (document)</label>


                                                    <input type="file" class="form-control" name="attachment" id="" placeholder="" aria-describedby="fileHelpId" accept=".pdf, .docx, .doc, .png, .jpg, .rtf, .xls">
                                                    <div id="fileHelpId" class="form-text">pdf,doc,docx are aceptable</div>

                                                    <?php echo $fileSizeError ?? "" ?>




                                                </div>
                                            </div>

                                            <div class="col-xl-12 col-md-12 py-3">
                                                <label class="form-label ">More Data</label>
                                                <textarea name="letter" id="ckeditor-classic">
                                                       &lt;p&gt;This is some sample content.&lt;/p&gt;
                                                </textarea>
                                            </div>
                                            <div class="col-xl-12 col-md-12 py-3">

                                                <?php echo $submissionError ?? "" ?>

                                            </div>





                                        </div>
                                        <!-- end row -->


                                        <div class="form-group">
                                            <button name="create_application" type="submit" class="btn btn-primary waves-effect waves-light">Submit Application</button>
                                        </div>
                                    </form>

                                </div>


                                <!-- ===================== -->
                                <div id="success_modal" class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">

                                            <div class="modal-body">
                                                <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                <center>
                                                    <h3 class="text-success py-2">Applied successful!</h3>

                                                    <lottie-player src="assets/lottie/doc-check.json" background="transparent" speed="1" style="width: 200px; height: 200px;" loop autoplay></lottie-player>


                                                    <h5>We have received your application </h5>
                                                    <p>Keep eyes at your application to see status!</p>
                                                    <div class="py-3">
                                                        <a href="my-application.php" class="btn btn-primary  waves-effect waves-light">See All Applications</a>
                                                    </div>

                                                </center>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- ========================== -->



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


<!-- CK Editor  -->

<!-- ckeditor -->
<script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

<!-- init js -->
<script src="assets/js/pages/form-editor.init.js"></script>



<script src="assets/js/app.js"></script>

<script>
    var myModal = new bootstrap.Modal(document.getElementById('success_modal'), {
        keyboard: false
    })
</script>
<?php

if (isset($success_message)) {
    // echo '<script>triggerSuccess("' . $success_message . '")</script>';
    echo '<script> myModal.show()</script>';
} ?>

</body>

</html>