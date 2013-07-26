<?php

  session_start();
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  
  if ($_GET["tried"] != "ignore") {
  
    mysql_select_db("analytics", $con);
    $query = "SELECT * FROM `analytics`.`hungarian`";
    $result = mysql_query($query, $con);
    $resultarray = mysql_fetch_array($result);
    
    $tried = $resultarray["tried"] + $_GET["tried"];
    $accurate = $resultarray["accurate"] + $_GET["accurate"];
    
    $delete = "TRUNCATE hungarian";
    mysql_query($delete, $con);
    
    $insert = "INSERT INTO  `analytics`.`hungarian` (
    `tried` ,
    `accurate`
    )
    VALUES (
    '$tried',  '$accurate'
    )";
  
    mysql_query($insert, $con);
  
  }
  
  $username = $_SESSION["username"];
  
  mysql_select_db("users", $con);
  $query = "SELECT `plans` FROM `userinfo` WHERE `username` LIKE '$username'";
  $result = mysql_query($query, $con);
  $resultarray = mysql_fetch_array($result);
  $old = $resultarray["plans"];
  $new = $old + 1;
  
  $query = "UPDATE `userinfo` SET `plans` = '$new' WHERE `username` LIKE '$username'";
  mysql_query($query, $con);


  mysql_close($con);

?>