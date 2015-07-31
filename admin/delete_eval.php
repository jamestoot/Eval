<?php
$strPageTitle = 'Puckstoppers Goaltending Evaluation';
include("layout/header.php");
if(isset($_GET['eval_id']) && is_numeric($_GET['eval_id'])){
  $iEvaluationId = $_GET['eval_id'];
  $objEvaluation = new Evaluation(NULL, $iEvaluationId);
  $blnDeleted = $objEvaluation->deleteEvaluation();
  if($blnDeleted){
    setTopMessage('success', 'Success! The Evaluation has been deleted.');
    header('Location: '.$strLocation.'admin/');
  } else {
    setTopMessage('error', 'Error! The Evaluation has not been deleted, please try again.');
    header('Location: '.$strLocation.'admin/');
  }
} else {
  header('Location: '.$strLocation.'admin/');
}
?>
<?php
include("layout/footer_js.php");
?>
<?
include("layout/footer.php");
?>