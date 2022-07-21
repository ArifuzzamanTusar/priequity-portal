<?php

define("user_code", 10001);
define("admin_code", 10000);
// include 'Classes/function.php';
// $portal = new DbClass();
$portal->checkLoggedIn();


$session_user_id = $_SESSION["id"];
$session_user_name = $_SESSION["username"];
function getRoles($role_id)
{
    if ($role_id === admin_code) {
        define("isAdmin", true);
    } else {
        define("isAdmin", false);
    }

    if ($role_id === user_code) {
        define("isUser", true);
    } else {
        define("isUser", false);
    }
}
// GET LOGGED IN USERS DATA 
$getuser = $portal->userData($session_user_id);
// call for role check 
getRoles(intval($getuser[0]['role']));
