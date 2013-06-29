<?php

    session_start();
    
    $name = $_POST["groupname"];
    $username = $_SESSION["username"];
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("groups", $con);
    
    $find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
    $found = mysql_query($find, $con);
    $foundarray = mysql_fetch_array($found);
    $savedGroupData = json_decode($foundarray["savedGroupData"], true);
    
    for ($i = 0; $i < count($savedGroupData[0]); $i++) {
      if ($name == $savedGroupData[0][$i]) {
            array_splice($savedGroupData[0], $i, 1); // name
            array_splice($savedGroupData[1], $i, 1); // id
       }
        break;
    }
	
    $hashname = hash("crc32b", $username . $name);
    
    $delete = "DROP TABLE `" . $hashname . "`";
    mysql_query($delete, $con);
  
    $updated = json_encode($savedGroupData);   
    $replace = "UPDATE `users`.`userinfo` SET savedGroupData='$updated' WHERE `username` = '$username'";
    mysql_query($replace, $con);
    
    mysql_close($con);
    
    return true;   
    
?>