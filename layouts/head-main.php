<?php
session_start();
// include language configuration file based on selected language
$lang = "en";
if (isset($_GET['lang'])) {
    $lang = $_GET['lang'];
    $_SESSION['lang'] = $lang;
}
if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
} else {
    $lang = "en";
}
require_once("./assets/lang/" . $lang . ".php");

// ====
include 'Classes/function.php';
$portal = new DbClass();

// ====ROLE MANAGEMENT===
include 'role.php';

// ====EXTRAS====
function debug($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

// ======= Mailing =======
$admin_emails = array (
    'support@priequity.com',
    'arifuzzamantusar50@gmail.com'
);



?>
<!DOCTYPE html>

<html lang="<?php echo $lang ?>">