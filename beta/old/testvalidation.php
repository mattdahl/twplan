<?php
  
  $sid = $_GET["sid"];
  $username = $_GET["username"];

  session_id($sid);
  session_start();
  
  if ($username != null) {
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("users", $con);
    $query = "INSERT INTO  `users`.`userinfo` (
      `username`
    )
    VALUES (
      '$username'
    )
    ON DUPLICATE KEY UPDATE username=username;";
    mysql_query($query, $con);
    
    $_SESSION["username"] = urlencode($username);
    $_SESSION["world"] = "us6";
    $_SESSION["isTest"] = true;
    
    header("Location: http://test.twplan.com/index.php?id=" . $sid);
  }
  

?>