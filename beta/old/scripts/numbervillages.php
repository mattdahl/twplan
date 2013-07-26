<?php

session_start();
  
  $username = $_SESSION["username"];
  $world = $_SESSION["world"];
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  
  mysql_select_db("players", $con);
  $query = "SELECT `numvillages` FROM `players`.`en" . $world . "` WHERE `username` = '$username'";
  $result = mysql_query($query, $con);
  
  $resultarray = mysql_fetch_array($result);
  
  echo $resultarray["numvillages"];

?>