<?php
  
  session_start();
  
  if (!isset($_SESSION["username"]))
    return;
  
  $username = urldecode($_SESSION["username"]);
  $w = $_GET["world"];
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
  mysql_select_db("users", $con);
  
  $updateworld = "UPDATE `users`.`userinfo` SET defaultWorld='$w' WHERE `username` = '$username'";
  
  mysql_query($updateworld, $con);
  
  header("Location: http://beta.twplan.com/settings.php");

?>