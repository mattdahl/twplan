<?php
  
  function getLastUpdated() {
  
	  session_start();
	  
	  if (!isset($_SESSION["world"]))
		return false;
	  
	  $world = $_SESSION["world"];  
	  
	  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
	  mysql_select_db("analytics", $con);
	  
	  $find = "SELECT `dateTime` FROM `analytics`.`lastUpdated` WHERE `world` = '$world'";
	  $found = mysql_query($find, $con);
	  $foundarray = mysql_fetch_array($found);
	  
	  mysql_close($con);
	  
	  $t = date($foundarray["dateTime"]);
	  
	  date_default_timezone_set("Europe/London");
	  
	  $now = date('Y-m-d H:i:s', time());
	  
	  $diff = strtotime($now) - strtotime($t);
	  
	  return round(($diff/60)/60);
  
  }
?>