<?php
session_start();

function __autoload($class_name) {
  require_once __DIR__.'/../classes/' . $class_name . '.class.php';
}
include(__DIR__."/../config/config.php");
include(__DIR__."/../includes/dbconnect.php");
include(__DIR__."/../includes/functions.php");

