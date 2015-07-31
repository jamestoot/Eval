<?php

class Series {
  protected $seriesName;

  public function __construct ( $seriesName ) {
    $this->seriesName = $seriesName;
  }
  
  function getSeries() {
    $strSql = "SELECT * FROM ".SERIES_TABLE;
    $objResult = mysql_query($strSql);
    $arrResult = convertToArray($objResult);
    return $arrResult;
  }
}