<?php
    session_start();
  
    $name = $_GET["planname"];
    
    $username = $_SESSION["username"]; 
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("users", $con);
    
    $find = "SELECT `savedData` FROM `users`.`userinfo` WHERE `username` = '$username'";
    $found = mysql_query($find, $con);
    $foundarray = mysql_fetch_array($found);
    $savedData = json_decode($foundarray["savedData"], true);
    
    for ($i = 0; $i < count($savedData[2]); $i++) {
        if ($savedData[2][$i] == $name) {
            echo "true";
            break;
        }
    }

?>