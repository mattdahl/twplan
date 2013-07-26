<?php

    session_start();
    
    $name = $_POST["planname"];
    $username = $_SESSION["username"];
    
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("users", $con);
    
    
    $find = "SELECT `savedData` FROM `users`.`userinfo` WHERE `username` = '$username'";
    $found = mysql_query($find, $con);
    $foundarray = mysql_fetch_array($found);
    $savedData = json_decode($foundarray["savedData"], true);
    
    for ($i = 0; $i < count($savedData[2]); $i++) {
      if ($name == $savedData[2][$i]) {
            array_splice($savedData[0], $i, 1);
            array_splice($savedData[1], $i, 1);
            array_splice($savedData[2], $i, 1);
            array_splice($savedData[3], $i, 1);
       }
        break;
    }
    $hashname = hash("crc32b", $username . $name);
    
    $delete = "DROP TABLE `" . $hashname . "`";
    mysql_query($delete, $con);
  
    $updated = json_encode($savedData);   
    $replace = "UPDATE `users`.`userinfo` SET savedData='$updated' WHERE `username` = '$username'";
    mysql_query($replace, $con);
    
    mysql_close($con);
    
    return true;   
    
?>