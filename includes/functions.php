<?php

/*
 * Top Message
 * 
 * */
 
function setTopMessage($strType, $strMessage) {
  if(!empty($strType) && !empty($strMessage)) {
    session_start();
    $arrMessage[$strType] = $strMessage;
    $_SESSION['topMessage'] = $arrMessage;
    return true;
  }
  return false;
}

/*
 * User
 * 
 * */
 
function checkUser($strUsername, $strPassword, $blnSetSession) {
  if(!empty($strUsername) && !empty($strPassword)) {
    $strSql = "SELECT * FROM admin_users WHERE username='".mysql_escape_string($strUsername)."' and password='".md5(mysql_escape_string($strPassword))."'";
    $arrResult = mysql_query($strSql);
    $iCount=mysql_num_rows($arrResult);
    if($iCount > 0) {
      if($blnSetSession) {
        $_SESSION['AdminUser'] = $strUsername;
        $_SESSION['AdminPassword'] = $strPassword;
      }
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function logoutUser() {
  // Unset all of the session variables.
  $_SESSION = array();
  
  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
      $params["path"], $params["domain"],
      $params["secure"], $params["httponly"]
    );
  }
  
  // Finally, destroy the session.
  session_destroy();
  session_start();
  setTopMessage('success', 'You have been logged out.');
  header("location:../admin/login.php");
}

function convertToArray($objResult) {
  $arrResult = array();
  while($row = mysql_fetch_array($objResult))
  {
      $arrResult[] = $row;
  }
  return $arrResult;
}
 