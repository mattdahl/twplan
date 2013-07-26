<?php
    
  session_start();
  
  if (!isset($_SESSION["username"]))
    return false;
  
  $username = urldecode($_SESSION["username"]);  
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  mysql_select_db("analytics", $con);
  
  $find = "SELECT `localTimezone` FROM `users`.`userinfo` WHERE `username` = '$username'";
  $found = mysql_query($find, $con);
  $foundarray = mysql_fetch_array($found);
  
  mysql_close($con);
  
  $w = $foundarray["localTimezone"];
  
  if ($w == "")
  	echo "None";
  else
  	echo $w;
  
?>