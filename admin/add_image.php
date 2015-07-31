<?php
set_time_limit(0);
$strPageTitle = 'Add Image';

include("../includes/logincheck.php");
if(!empty($_FILES)) {
    $objEvaluation = new Evaluation(NULL, NULL);
    $arrImageAdded = $objEvaluation->addImage(isset($_POST['imageid']) ? $_POST['imageid'] : NULL, isset($_POST['evalid']) ? $_POST['evalid'] : NULL);
    if(!empty($arrImageAdded) && $arrImageAdded != 'error') {
      echo $arrImageAdded[0];
    } else {
      echo 'error';
    }
}
?>