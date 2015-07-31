<?php
set_time_limit(0);
class Evaluation {
  
  public function __construct ( $arrEvaluation, $iEvaluationId ) {
    $this->arrEvaluation = $arrEvaluation;
    $this->iEvaluationId = $iEvaluationId;
  }
  
  function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
  }
  
  function emailEvaluation($strEmail, $strName, $PDF, $strFilename) {
    
    $strMessage = '
    <html>
      <head>
        <title>Your Puckstoppers Goaltending Evaluation</title>
      </head>
      <body>
        <p>
          Hi '.$strName.',<br /><br />
          Please find attached your Puckstoppers Goaltending Evaluation in PDF format.
        </p>
        <p>
        Hope to see you again soon,<br />
        <strong>Puckstoppers</strong>
        </p>
        <p>
          If you have any trouble opening the attachment you may need to download a PDF reader.<br />
          You can download one by clicking this link: https://get.adobe.com/reader/
        </p>
      </body>
    </html>
    ';
    $strSubject = 'Your Puckstoppers Goaltending Evaluation';
    
      $email = new PHPMailer();
      $email->From      = 'noreply@kaftans.boutique';
      $email->FromName  = 'Puckstoppers';
      $email->Subject   = $strSubject;
      $email->Body      = $strMessage;
      $email->IsHTML(true); 
      $email->AddAddress( $strEmail );
      $email->AddBCC( 'jimmytootall3@gmail.com' );
      
      //$email->AddAttachment( $PDF , 'eval.pdf' );
      $email->AddStringAttachment($PDF, $strFilename, $encoding = 'base64', $type = 'application/pdf');
      
      
      return $email->Send();
  }
  
  function addImage($iImageId, $iEvalId) {
    if(!empty($_FILES)) {
      $arrUploadedFiles = array();
      foreach ($_FILES AS $arrFile) {
        if(!empty($arrFile['tmp_name'])){
          try {
             
              // Undefined | Multiple Files | $_FILES Corruption Attack
              // If this request falls under any of them, treat it invalid.
              if (
                  !isset($arrFile['error']) ||
                  is_array($arrFile['error'])
              ) {
                  return 'error';
              }
          
              // Check $arrFile['error'] value.
              switch ($arrFile['error']) {
                  case UPLOAD_ERR_OK:
                      break;
                  case UPLOAD_ERR_NO_FILE:
                      return 'error';
                  case UPLOAD_ERR_INI_SIZE:
                  case UPLOAD_ERR_FORM_SIZE:
                      return 'error';
                  default:
                      return 'error';
              }
          
              // You should also check filesize here.
              if ($arrFile['size'] > 1000000) {
                  return 'error';
              }
          
              // DO NOT TRUST $arrFile['mime'] VALUE !!
              // Check MIME Type by yourself.
              $finfo = new finfo(FILEINFO_MIME_TYPE);
              if (false === $ext = array_search(
                  $finfo->file($arrFile['tmp_name']),
                  array(
                      'jpg' => 'image/jpeg',
                      'png' => 'image/png',
                      'gif' => 'image/gif',
                  ),
                  true
              )) {
                  return 'error';
              }
          
              // You should name it uniquely.
              // DO NOT USE $arrFile['name'] WITHOUT ANY VALIDATION !!
              // On this example, obtain safe unique name from its binary data.
              $strNewFileName = sprintf('../uploads/%s.%s',sha1_file($arrFile['tmp_name']),$ext);
              if (!move_uploaded_file(
                  $arrFile['tmp_name'],
                  $strNewFileName
              )) {
                  return 'error';
              }
              $arrUploadedFiles[] = str_replace('../uploads/', '', $strNewFileName);
              
              if(!empty($iEvalId) && !empty($iImageId)){     
                $strSql = "UPDATE ".EVALUATIONS_TABLE." 
                            SET image$iImageId = '".mysql_escape_string($arrUploadedFiles[0])."',
                            size = '".mysql_escape_string($arrFile['size'])."'
                            WHERE id = '".mysql_escape_string($iEvalId)."';";
                $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
              }

              return $arrUploadedFiles;
          
          } catch (RuntimeException $e) {
          
              echo $e->getMessage();
          
          }
        }
      }
    }
  }
  
  
  function addEvaluation($blnUpdate = false) {
    
    
    if(!$blnUpdate){
      $strSql = "INSERT INTO ".EVALUATIONS_TABLE." (program, student, email, comments, image1, image2, image3)
                 VALUES ('".mysql_escape_string($this->arrEvaluation['program'])."',
                         '".mysql_escape_string($this->arrEvaluation['name'])."',
                         '".mysql_escape_string($this->arrEvaluation['email'])."',
                         '".mysql_escape_string($this->arrEvaluation['comments'])."',
                         '".mysql_escape_string($this->arrEvaluation['image1'])."',
                         '".mysql_escape_string($this->arrEvaluation['image2'])."',
                         '".mysql_escape_string($this->arrEvaluation['image3'])."')";
      $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
      $iEvaluationId = mysql_insert_id();
    } else {
      $iEvaluationId = $this->iEvaluationId;      
      $strSql = "UPDATE ".EVALUATIONS_TABLE." 
                  SET program = '".mysql_escape_string($this->arrEvaluation['program'])."',";
      if(!empty($this->arrEvaluation['image1'])) {            
        $strSql .= "image1 = '".mysql_escape_string($this->arrEvaluation['image1'])."',";
      }
      if(!empty($this->arrEvaluation['image2'])) {            
        $strSql .= "image2 = '".mysql_escape_string($this->arrEvaluation['image2'])."',";
      }
      if(!empty($this->arrEvaluation['image3'])) {            
        $strSql .= "image3 = '".mysql_escape_string($this->arrEvaluation['image3'])."',";
      }
      $strSql .= "student = '".mysql_escape_string($this->arrEvaluation['name'])."',
                  email = '".mysql_escape_string($this->arrEvaluation['email'])."',
                  comments = '".mysql_escape_string($this->arrEvaluation['comments'])."'
                  WHERE id = '".mysql_escape_string($iEvaluationId)."';";
      $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
      $strSql = "DELETE FROM ".EVALUATIONS_TO_COMPONENTS_TABLE." WHERE evaluation_id = '".mysql_escape_string($iEvaluationId)."';";
      $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
      $strSql = "DELETE FROM ".EVALUATIONS_TO_COMMENTS_TABLE." WHERE evaluation_id = '".mysql_escape_string($iEvaluationId)."';";
      $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    }
    if(is_array($this->arrEvaluation['component']) && count($this->arrEvaluation['component']) > 0) {
      $iRowCount = 0;
      $arrComments = array();
      $strSql = "INSERT INTO ".EVALUATIONS_TO_COMPONENTS_TABLE." (evaluation_id,component_id,comments,component_score)
                 VALUES ";
      foreach($this->arrEvaluation['component'] as $iComponentId => $arrComponent) {
        
        if(!empty($arrComponent['comments'])) {
          foreach($arrComponent['comments'] as $iCommentId => $arrComment) {
            $arrComments[$iCommentId] = $arrComment;
          }
        }
        
        if(!empty($arrComponent['component_comments'])){
          $strComments = $arrComponent['component_comments'];
        } else {
          $strComments = '';
        }
        if(!empty($arrComponent['score'])){
          $iScores = '';
          foreach($arrComponent['score'] as $iScoreId => $arrScore) {
            $iScores .= $iScoreId.',';
          }
          $iScores = rtrim($iScores, ",");
          $iRowCount++;
          $strSql .= "('".mysql_escape_string($iEvaluationId)."', 
                       '".mysql_escape_string($iComponentId)."',
                       '".mysql_escape_string($strComments)."',
                       '".mysql_escape_string($iScores)."'),";
        }
      }
      
      if($iRowCount > 0) {
        $strSql = rtrim($strSql, ",");
        $strSql .= ';';
        $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
      }
    }

    if(is_array($arrComments) && count($arrComments) > 0) {
      $iRowCount = 0;
      $strSql = "INSERT INTO ".EVALUATIONS_TO_COMMENTS_TABLE." (evaluation_id,comment_id)
                 VALUES ";
      foreach($arrComments as $iCommentId => $arrComment) {
        $iRowCount++;
        $strSql .= "('".mysql_escape_string($iEvaluationId)."', 
                       '".mysql_escape_string($iCommentId)."'),";
      }
      
      if($iRowCount > 0) {
        $strSql = rtrim($strSql, ",");
        $strSql .= ';';
        $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
      }
    }

    if($objResult){
      return true;
    }
  }

  function getEvaluation() {
    $strSql = "SELECT e.*
                FROM ".EVALUATIONS_TABLE." e
                WHERE e.id = ".mysql_escape_string($this->iEvaluationId).";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    return $arrResult[0];
  } 
  
  function getEvaluations($blnComplete = false) {
    $strSql = "SELECT e.*
                FROM ".EVALUATIONS_TABLE." e ";
    if($blnComplete) {
      $strSql .= "WHERE e.complete = 'Y'";
    } else {
      $strSql .= "WHERE e.complete = 'N'";
    }
    $strSql .= "AND e.deleted = 'N';";          
 
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResultTemporary = convertToArray($objResult);
    $arrResult = array();
    foreach($arrResultTemporary as $iKey => $arrResultTemp){
      $arrResult[$arrResultTemp['program']][$iKey] = $arrResultTemp;
    }
    return $arrResult;
  } 
  
  function markComplete() {
    $strSql = "UPDATE ".EVALUATIONS_TABLE."
                SET complete = 'Y'
                WHERE id = ".mysql_escape_string($this->iEvaluationId).";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    return true;
  } 
  
  function deleteEvaluation() {
    $strSql = "UPDATE ".EVALUATIONS_TABLE."
                SET deleted = 'Y'
                WHERE id = ".mysql_escape_string($this->iEvaluationId).";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    return true;
  } 
  
  function getCommentCount($iEvaluationId) {
    $strSql = "SELECT COUNT(*) AS count
                FROM ".EVALUATIONS_TO_COMMENTS_TABLE." 
                WHERE evaluation_id = ".mysql_escape_string($iEvaluationId).";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    $arrResult = $arrResult[0]['count'];
    return $arrResult;
  }
  
  function getCompletedComponents() {
    $strSql = "SELECT *
                FROM ".EVALUATIONS_TO_COMPONENTS_TABLE." 
                WHERE evaluation_id = ".mysql_escape_string($this->iEvaluationId).";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    $arrNewResult = array();
    foreach($arrResult AS $arrTempResult) {
      $arrNewResult[$arrTempResult['component_id']]['component_id'] = $arrTempResult['component_id'];
      if(!empty($arrTempResult['component_score'])) {
        $arrScores = explode(',',$arrTempResult['component_score']);
        foreach($arrScores as $arrScore){
          $arrNewResult[$arrTempResult['component_id']]['component_score'][$arrScore] = true;
        }
      }      
      $arrNewResult[$arrTempResult['component_id']]['comments'] = $arrTempResult['comments'];
    }
    return $arrNewResult;
  }
  
  function getCompletedComments() {
    $strSql = "SELECT *
                FROM ".EVALUATIONS_TO_COMMENTS_TABLE." 
                WHERE evaluation_id = ".mysql_escape_string($this->iEvaluationId).";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    $arrNewResult = array();
    foreach($arrResult AS $arrTempResult) {
      $arrNewResult[$arrTempResult['comment_id']] = 'Y';
    }
    return $arrNewResult;
  }
  
  function getPointsForEvent($iDriverId, $iEventId) {
    $strSql = "SELECT SUM(points) AS points
                FROM
                  (SELECT ".POINTS_TABLE.".points
                   FROM ".POINTS_TABLE." JOIN ".DRIVERS_TO_EVENTS_TABLE." 
                   ON(".DRIVERS_TO_EVENTS_TABLE.".position = ".POINTS_TABLE.".position)
                   WHERE ".DRIVERS_TO_EVENTS_TABLE.".driver_id = ".mysql_escape_string($iDriverId)."
                   AND ".DRIVERS_TO_EVENTS_TABLE.".event_id = ".mysql_escape_string($iEventId)."
                   UNION ALL ";
                   
      $strSql .= "SELECT ".MODEL_POINTS_TABLE.".points
                   FROM ".MODEL_POINTS_TABLE." JOIN ".DRIVERS_TO_EVENTS_TABLE." 
                   ON(".DRIVERS_TO_EVENTS_TABLE.".heat_position = ".MODEL_POINTS_TABLE.".position)
                   WHERE ".DRIVERS_TO_EVENTS_TABLE.".driver_id = ".mysql_escape_string($iDriverId)."
                   AND ".DRIVERS_TO_EVENTS_TABLE.".event_id = ".mysql_escape_string($iEventId)."
                   UNION ALL ";
    
    $strSql .= "SELECT COUNT(*) AS points
                   FROM ".DRIVERS_TO_EVENTS_TABLE."
                   WHERE led = 'Y' 
                   AND driver_id = ".mysql_escape_string($iDriverId)."
                   AND event_id = ".mysql_escape_string($iEventId)."
                   UNION ALL
                   SELECT COUNT(*) AS points
                   FROM ".DRIVERS_TO_EVENTS_TABLE."
                   WHERE led_most = 'Y' 
                   AND driver_id = ".mysql_escape_string($iDriverId)."
                   AND event_id = ".mysql_escape_string($iEventId).") 
                driver_points";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    
    if(is_array($arrResult) && count($arrResult) > 0) {
      foreach($arrResult AS $arrPoints){
        $iPoints = $arrPoints['points'];
      }
    }

    if(!empty($iPoints)) {
      return $iPoints;
    } else {
      return 0;
    }
    
  }

  function getLatestEvent($iSeriesChoice) {
    $strSql = "SELECT * FROM events WHERE series_id = ".mysql_escape_string($iSeriesChoice)." ORDER BY date DESC, race_no DESC limit 1";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    if($arrResult){
      return $arrResult[0];  
    }
  }

  function checkResetPassword($strPassword) {
    if(!empty($strPassword)) {
      if(md5(mysql_escape_string($strPassword)) == 'fc6021f9b0d732c142cfe950a14d55af') {
        $_SESSION['ResetPassword'] = $strPassword;
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

}