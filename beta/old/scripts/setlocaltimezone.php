<?php
  
  session_start();
  
  if (!isset($_SESSION["username"]))
    return;
  
  $username = urldecode($_SESSION["username"]);
  $t = $_GET["timezone"];
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
  mysql_select_db("users", $con);
  
  $updatetimezone = "UPDATE `users`.`userinfo` SET localTimezone='$t' WHERE `username` = '$username'";
  
  mysql_query($updatetimezone, $con);
  
  header("Location: http://beta.twplan.com/settings.php");

?>