<?php
if(!empty($_SESSION['topMessage'])) {
  $arrTopMessages = $_SESSION['topMessage'];
  
  foreach($arrTopMessages as $iType => $strTopMessage) { 
    ?>
    <div data-alert class="alert-box <?=$iType?> fixed">
      <?=$strTopMessage?>
      <a href="#" class="close">&times;</a>
    </div>
  <?
  }
  unset($_SESSION['topMessage']);
}
?>