<?php
// include 'layouts/head-main.php'; 
include 'Classes/function.php';
$portal = new DbClass();

?>

<?php
// Include config file
require_once "layouts/config.php";
$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri_segments = explode('/', $uri_path);
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$uri_segments[1]";
} else {

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
}

$useremail_err = $msg = "";
if (isset($_POST['submit'])) {

    $useremail = mysqli_real_escape_string($link, $_POST['useremail']);

    $sql = "SELECT * FROM users WHERE useremail = '$useremail'";
    $query = mysqli_query($link, $sql);
    $emailcount = mysqli_num_rows($query);

    if ($emailcount) {
        $userdata = mysqli_fetch_array($query);
        $username = $userdata['username'];
        $token = $userdata['token'];
        $body = "Hi, $username. Click here to reset your password " . $actual_link . "/auth-reset-password.php?token=$token ";



        $portal->sendMail($useremail, 'Password Reset', $body);
        $msg = "We have emailed your password reset link!";
    } else {
        $useremail_err = "No Email Found";
    }
}
?>
<?php
//  include 'layouts/head-main.php'; 
?>

<head>

    <title>Recover Password | Priequity Portal</title>
    <?php include 'layouts/head.php'; ?>
    <?php include 'layouts/head-style.php'; ?>

</head>

<?php include 'layouts/body.php'; ?>
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-3 col-lg-4 col-md-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="index.php" class="d-block auth-logo">
                                    <img src="assets/images/logo.png" alt="" height="28"> <span class="logo-txt">Priequity</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Reset Password</h5>
                                    <p class="text-muted mt-2">Reset Password with Priequity.</p>
                                </div>
                                <?php if ($msg) { ?>
                                    <div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
                                        <?php echo $msg; ?>
                                    </div>
                                <?php } ?>

                                <form class="custom-form mt-4" action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="mb-3 <?php echo (!empty($useremail_err)) ? 'has-error' : ''; ?>">
                                        <label class="form-label">Email</label>
                                        <input type="text" name="useremail" class="form-control" id="email" placeholder="Enter email">
                                        <span class="text-danger"><?php echo $useremail_err ? $useremail_err : ''; ?></span>
                                    </div>
                                    <div class="mb-3 mt-4">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type='submit' name='submit' value='Submit'>Reset</button>
                                    </div>
                                </form>

                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Remember It ? <a href="auth-login.php" class="text-primary fw-semibold"> Sign In </a> </p>
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>
                                        document.write(new Date().getFullYear())
                                    </script> <a href="http://priequity.com/">Priequity LLC</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-9 col-lg-8 col-md-7">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay bg-primary"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-center w-100">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div class="intro text-center">
                                    <img width="250px" class="text-center" src="assets/images/logo.png" alt="">
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>


<!-- JAVASCRIPT -->

<?php include 'layouts/vendor-scripts.php'; ?>

</body>

</html>