<?php
mysql_connect($strHost, $strUser, $strPass)or die("Unable to Connect to Database Server"); 
mysql_select_db($strDb)or die("Unable to Connect to Database");
?>