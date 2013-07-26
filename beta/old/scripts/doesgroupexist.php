<?php
    session_start();
  
    $name = $_GET["groupname"];
    
    $username = $_SESSION["username"]; 
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("users", $con);
    
    $find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
    $found = mysql_query($find, $con);
    $foundarray = mysql_fetch_array($found);
    $savedGroupData = json_decode($foundarray["savedGroupData"], true);
    
    for ($i = 0; $i < count($savedGroupData[0]); $i++) {
		if ($savedGroupData[0][$i] == $name && $savedGroupData[2][$i] == $_SESSION["world"]) {
            echo "true";
            break;
        }
    }

?>