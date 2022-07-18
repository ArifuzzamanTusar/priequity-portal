<?php include 'layouts/head-main.php'; ?>
<?php $portal->requireAdmin(); ?>

<?php
$user_token = md5($getuser[0]['username']);

?>

<?php

if (isset($_GET['delete-user'])) {

    if ($portal->deleteUsers($_REQUEST['delete-user'])) {
        header("location: all-users.php");
    }
}

if (isset($_GET['update-app-status'])) {
    $app_id = $_REQUEST['app_id'];
    $app_status = $_REQUEST['app_status'];
    $token = $_REQUEST['token'];

    if ($user_token === $token) {
        if ($portal->updateApplicationStatus($app_id, $app_status)) {
          
            header("location: application.php?app-id=$app_id");
           
        }

        // 
    }
}


if (isset($_GET['delete-application'])) {

    echo 'Trying to Delete Application - ' . $_REQUEST['delete-application'] . '<br><br><br><br>';
}

?>