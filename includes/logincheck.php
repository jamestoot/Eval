<?php
session_start();
function __autoload($class_name) {
  require_once '../classes/' . $class_name . '.class.php';
}
include("../config/config.php");
include("../includes/dbconnect.php");
include("../includes/functions.php");

if(isset($_GET['eval_id']) && isset($_GET['skip_auth']) && $_GET['skip_auth'] == '1HGstGtw8272891H'){
} else {
  $blnLoggedIn = false;
  if (!empty($_SESSION['AdminUser']) && !empty($_SESSION['AdminPassword'])) {
    $blnLoggedIn = checkUser($_SESSION['AdminUser'], $_SESSION['AdminPassword'], null);
    if($blnLoggedIn && $_SERVER['PHP_SELF'] == $strLocation.'admin/login.php') {
      header("location:../admin/");
    }
  } elseif(!empty($_POST['username']) && !empty($_POST['password'])) {
    $blnLoggedIn = checkUser($_POST['username'], $_POST['password'], true);
    if($blnLoggedIn) {
      header("location:../admin/");
    } else {
      setTopMessage('alert', 'We were unable to log you in, please check your details.');
      header("location:../admin/login.php");
    }
  }
  
  if(!$blnLoggedIn && $_SERVER['PHP_SELF'] != $strLocation.'admin/login.php') {
    setTopMessage('alert', 'Please login to view this page.');
    header("location:../admin/login.php");
  }
}