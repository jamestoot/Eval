<?php

class Comment {

  public function __construct ( $commentName, $iComponentId, $iTypeId ) {
    $this->commentName = $commentName;
    $this->iComponentId = $iComponentId;
    $this->iTypeId = $iTypeId;
  }
  
  function getComponents() {
    $strSql = "SELECT *
                FROM ".COMPONENTS_TABLE.";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    return $arrResult;
  }
  
  function getCommentTypes() {
    $strSql = "SELECT *
                FROM ".COMMENT_TYPES_TABLE.";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    return $arrResult;
  }
  
  function getComments($iComponentId, $iCommentTypeId, $iEvaluationId) {
    $strSql = "SELECT *
                FROM ".COMMENTS_TABLE." c ";
    if(!empty($iEvaluationId)) {
      $strSql .= "LEFT JOIN ".EVALUATIONS_TO_COMMENTS_TABLE." etc
                  ON c.id = etc.comment_id ";
    }
    $strSql .= "WHERE c.component_id = '".mysql_escape_string($iComponentId)."'
                AND c.type = '".mysql_escape_string($iCommentTypeId)."'";
    if(!empty($iEvaluationId)) {            
      $strSql .= "AND etc.evaluation_id = '".mysql_escape_string($iEvaluationId)."'";
    }
    $strSql .= ";";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResultsTemp = convertToArray($objResult);
    $arrResult = array();
    foreach($arrResultsTemp as $iKey => $arrResultTemp) {
      if(!empty($arrResultTemp['sub_type'])) {
        $arrResult[$arrResultTemp['sub_type']][$iKey]['id'] = $arrResultTemp['id'];
        $arrResult[$arrResultTemp['sub_type']][$iKey]['component_id'] = $arrResultTemp['component_id'];
        $arrResult[$arrResultTemp['sub_type']][$iKey]['comment'] = $arrResultTemp['comment'];
        $arrResult[$arrResultTemp['sub_type']][$iKey]['type'] = $arrResultTemp['type'];
        $arrResult[$arrResultTemp['sub_type']][$iKey]['sub_type'] = $arrResultTemp['sub_type'];
      } else {
        $arrResult[0][$iKey]['id'] = $arrResultTemp['id'];
        $arrResult[0][$iKey]['component_id'] = $arrResultTemp['component_id'];
        $arrResult[0][$iKey]['comment'] = $arrResultTemp['comment'];
        $arrResult[0][$iKey]['type'] = $arrResultTemp['type'];
        $arrResult[0][$iKey]['sub_type'] = $arrResultTemp['sub_type'];
      }
    }
    return $arrResult;
  }
  
  function addComment() {
    $strSql = "INSERT INTO ".COMMENTS_TABLE." (component_id, comment, type)
               VALUES ('".mysql_escape_string($this->iComponentId)."',
                       '".mysql_escape_string($this->commentName)."',
                       '".mysql_escape_string($this->iTypeId)."')";
    
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      return true;
    }
  }
  
  function getSubTypeName($iSubTypeId) {
    $strSql = "SELECT title FROM ".COMMENT_SUBTYPES_TABLE." WHERE id = '".mysql_escape_string($iSubTypeId)."'";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['title'];
    }
  }

  
  function getDriverWins() {
    $strSql = "SELECT count(*) AS wins FROM ".DRIVERS_TO_EVENTS_TABLE." WHERE driver_id = '".mysql_escape_string($this->iDriverId)."' AND position = '1'";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['wins'];
    }
  }
  
  function getDriverTop5() {
    $strSql = "SELECT count(*) AS top5 FROM ".DRIVERS_TO_EVENTS_TABLE." WHERE driver_id = '".mysql_escape_string($this->iDriverId)."' AND position <= 5";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['top5'];
    }
  }
  
  function getDriverTop10() {
    $strSql = "SELECT count(*) AS top10 FROM ".DRIVERS_TO_EVENTS_TABLE." WHERE driver_id = '".mysql_escape_string($this->iDriverId)."' AND position <= 10";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['top10'];
    }
  }
  
  function getDriverPoles() {
    $strSql = "SELECT count(*) AS poles FROM ".DRIVERS_TO_EVENTS_TABLE." WHERE driver_id = '".mysql_escape_string($this->iDriverId)."' AND pole = 'Y'";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['poles'];
    }
  }
  
  function getDriverDnf() {
    $strSql = "SELECT count(*) AS dnf FROM ".DRIVERS_TO_EVENTS_TABLE." WHERE driver_id = '".mysql_escape_string($this->iDriverId)."' AND dnf = 'Y'";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['dnf'];
    }
  }
  
  function getDriverEarnings() {
    $strSql = "SELECT SUM(earnings) AS earnings
                   FROM ".DRIVERS_TO_EVENTS_TABLE."
                   WHERE driver_id = ".mysql_escape_string($this->iDriverId);
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if($objResult){
      $arrResult = convertToArray($objResult);
      return $arrResult[0]['earnings'];
    }
  }
  
  function getDriversForSeries($iSeriesId, $blnAdmin, $iRemoveEventId) {
    if($blnAdmin){
      $strSql = "SELECT * FROM ".DRIVERS_TABLE." WHERE series_id='".mysql_escape_string($iSeriesId)."'";
    } else {
      $strSql = "SELECT * FROM ".DRIVERS_TABLE." WHERE series_id='".mysql_escape_string($iSeriesId)."'";
    } 
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    $arrResult = convertToArray($objResult);
    $arrResultTemp = array();
    foreach($arrResult AS $strKey => $arrResults){
      $arrResultTemp[$strKey] = $arrResults;
      $arrResultTemp[$strKey]['points'] = $this->getPointsForDriver($arrResults['driver_id'], null);
      if(isset($iRemoveEventId)){
        $arrResultTemp[$strKey]['points_change'] = $this->getPointsForDriver($arrResults['driver_id'], $iRemoveEventId);
      }
    }
    usort($arrResultTemp, function($a, $b) {
        return $b['points'] - $a['points'];
    });
    return $arrResultTemp;
  }

  function getDriverPreviousPosition($iDriverId, $iSeriesId, $iRemoveEventId) {
    $arrResults = $this->getDriversForSeries($iSeriesId, false, $iRemoveEventId);
    usort($arrResults, function($a, $b) {
      return $b['points_change'] - $a['points_change'];
    });
    
    foreach($arrResults as $iKey => $arrResult) {
      if($arrResult['driver_id'] == $iDriverId) {
        $iPreviousPosition = $iKey+1;
      }
    }
    return $iPreviousPosition;
  }
  
  function getPointsForDriver($iDriverId, $iRemoveEventId) {
    $strSql = "SELECT SUM(points) AS points
                FROM
                  (SELECT ".POINTS_TABLE.".points
                   FROM ".POINTS_TABLE." JOIN ".DRIVERS_TO_EVENTS_TABLE." 
                   ON(".DRIVERS_TO_EVENTS_TABLE.".position = ".POINTS_TABLE.".position)
                   WHERE ".DRIVERS_TO_EVENTS_TABLE.".driver_id = ".mysql_escape_string($iDriverId);
    if(isset($iRemoveEventId)){ 
       $strSql .= " AND ".DRIVERS_TO_EVENTS_TABLE.".event_id != ".mysql_escape_string($iRemoveEventId);
    }
       $strSql .= " UNION ALL ";                   
       $strSql .= "SELECT ".MODEL_POINTS_TABLE.".points
                   FROM ".MODEL_POINTS_TABLE." JOIN ".DRIVERS_TO_EVENTS_TABLE." 
                   ON(".DRIVERS_TO_EVENTS_TABLE.".heat_position = ".MODEL_POINTS_TABLE.".position)
                   WHERE ".DRIVERS_TO_EVENTS_TABLE.".driver_id = ".mysql_escape_string($iDriverId);
    if(isset($iRemoveEventId)){ 
       $strSql .= " AND ".DRIVERS_TO_EVENTS_TABLE.".event_id != ".mysql_escape_string($iRemoveEventId);
    }
       $strSql .= " UNION ALL ";  
                   
       $strSql .= "SELECT COUNT(*) AS points
                   FROM ".DRIVERS_TO_EVENTS_TABLE."
                   WHERE led = 'Y' 
                   AND driver_id = ".mysql_escape_string($iDriverId);
    if(isset($iRemoveEventId)){ 
       $strSql .= " AND event_id != ".mysql_escape_string($iRemoveEventId);
    }
       $strSql .= " UNION ALL
                   SELECT ".ELIMINATOR_POINTS." AS points
                   FROM ".DRIVERS_TABLE."
                   WHERE eliminator = 'Y' 
                   AND driver_id = ".mysql_escape_string($iDriverId)."
                   UNION ALL
                   SELECT COUNT(*) AS points
                   FROM ".DRIVERS_TO_EVENTS_TABLE."
                   WHERE led_most = 'Y' 
                   AND driver_id = ".mysql_escape_string($iDriverId);
    if(isset($iRemoveEventId)){ 
       $strSql .= " AND event_id != ".mysql_escape_string($iRemoveEventId);
    }
       $strSql .= ") 
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

  function updateEliminator($arrDrivers) {
    $strSql = "UPDATE ".DRIVERS_TABLE." SET eliminator = 'N' WHERE series_id = '".mysql_escape_string($arrDrivers['series_choice'])."';";
    $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
    if(is_array($arrDrivers['driver']) && count($arrDrivers['driver']) > 0) {
      foreach($arrDrivers['driver'] as $iDriverId => $arrDriver) {
        $strSql = "UPDATE ".DRIVERS_TABLE." SET eliminator = 'Y' WHERE series_id = '".mysql_escape_string($arrDrivers['series_choice'])."' AND driver_id = '".mysql_escape_string($iDriverId)."';";;
        $objResult = mysql_query($strSql) or die("A MySQL error has occurred.<br />Your Query: " . $strSql . "<br /> Error: (" . mysql_errno() . ") " . mysql_error());
      }
    }
    return true;
  }
  
}