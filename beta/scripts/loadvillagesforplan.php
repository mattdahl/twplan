<?php
  
  session_start();
  
  $username = urlencode(rawurldecode($_SESSION["username"]));
  $world = $_SESSION["world"];
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  
  mysql_select_db("players", $con);
  $query = "SELECT `playerid` FROM `players`.`en" . $world . "` WHERE `username` = '$username'";
  $result = mysql_query($query, $con);
  
  $resultarray = mysql_fetch_array($result);
  
  $pid = $resultarray["playerid"];
  
  mysql_select_db("villages", $con);
  $query = "SELECT name, xcoord, ycoord, villageid FROM `villages`.`en" . $world . "` WHERE `playerid` = '$pid' ORDER BY `name` ASC";
  $result = mysql_query($query, $con);
      
  $sql_array = array();
    
  while ($row = mysql_fetch_array($result))
  	array_push($sql_array, $row);
    
  echo json_encode($sql_array);
?>