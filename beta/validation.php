<?php
  
  $sid = $_GET["sid"];
  $username = $_GET["username"]; // username is returned in plaintext
  $hash = $_GET["hash"];

  if ($username != "syntexgrid")
    return false;
  
  session_id($sid);
  session_start();
  
  if ($hash == md5($sid . $username . "***REMOVED***")) {
	$username = rawurlencode($username);
    
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
    
    $_SESSION["username"] = $username;
      
    $find = "SELECT `defaultWorld` FROM `users`.`userinfo` WHERE `username` = '$username'";
    $found = mysql_query($find, $con);
    $foundarray = mysql_fetch_array($found);
  
    mysql_close($con);
  
    $w = $foundarray["defaultWorld"];
    if (!$w || $w == "")
      $_SESSION["world"] = "62";
    else
      $_SESSION["world"] = substr($w, 1);
    
    echo "http://www.twplan.com/index.php?id=" . $sid . "&world=" . $_SESSION["world"];
  }
  

?>