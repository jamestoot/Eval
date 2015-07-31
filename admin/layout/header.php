<?php
include("../includes/logincheck.php");
?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$strPageTitle?> | Puckstoppers Admin</title>
    <?
    if(!isset($_GET['remove_formatting'])) {
    ?>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/foundation.min.css" />
    <link rel="stylesheet" href="../css/foundation-datepicker.css" />
    <link rel="stylesheet" href="../css/styles.css" />
    <script src="../js/vendor/modernizr.js"></script>
    <?
    }
    ?>
    <script src="../js/jquery.js"></script>
    <script src="../js/vendor/jquery.ui.widget.js"></script>
    <script src="../js/jquery.iframe-transport.js"></script>
    <script src="../js/ajaxupload.js"></script>
  </head>
  <body class="body-<?=strtolower(str_replace(' ', '-', $strPageTitle))?>">
    <?
    if(isset($_GET['eval_id']) && isset($_GET['skip_auth']) && $_GET['skip_auth'] == '1HGstGtw8272891H' || isset($_GET['remove_formatting'])){?>
    <style>
      body{font-family: Helvetica,Roboto,Arial,sans-serif;margin:0;padding:0;}
      h1, h2, h3, h4, h5, h6 {
          color: #222;
          font-family: Helvetica,Roboto,Arial,sans-serif;
          font-style: normal;
          font-weight: normal;
          line-height: 1.4;
          text-rendering: optimizelegibility;
      }
      h1 small, h2 small, h3 small, h4 small, h5 small, h6 small {
          color: #008cba;
          display: block;
          font-size: 80%;
          line-height: 2rem;
      }
      h3{
        line-height:1;
      }
      .row{}
      blockquote{margin: 0 5px;padding:5px 15px;border-left:1px solid #ddd}
      p{margin:0;padding:8px 0;color:#6f6f6f;line-height:24px;font-size:15px;}
      blockquote cite::before {content: "— ";}
      blockquote cite{color: #555;display: block;font-size:12px}
      .panel{
        background: #f2f2f2 none repeat scroll 0 0;
        border-color: #d8d8d8;
        border-style: solid;
        border-width: 1px;
        color: #333;
        margin-bottom: 15px;
        padding: 15px;
        line-height:28px;
      }
      .panel > *:last-child {
          margin-bottom: 0;
      }
      .panel > *:first-child {
          margin-top: 0;
      }
      ul.square {
          list-style-type: square;
          margin-left: 1.1rem;
      }
    </style>
    <?
    }else{
    include("widgets/navigation.php");
    include("widgets/topmessage.php");
    }
    ?>
    <?
    if(!isset($_GET['remove_formatting'])) {
    ?>
    <div class="body-container">
      <div class="row">
        &nbsp;
      </div>
      <div class="row">
        <div class="medium-3 columns logo right">
          <img src="../images/logo.png" title=""/>
        </div>
        <div class="medium-2 columns logo right">
          <div class="row">
            <div class="hide-for-small-only medium-9 columns medium-offset-2">
              <img src="../images/logo2.png" title=""/>
            </div>
          </div>
        </div>
        <div class="medium-3 columns logo right hide-for-small-only">
          <img src="../images/logo3.jpg" title=""/>
        </div>
        <div class="medium-4 columns left">
          <h2><?=$strPageTitle?></h2>
        </div>
      </div>
      <div class="row">
        &nbsp;
      </div>
    <?
    }
    ?>