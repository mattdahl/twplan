<?php

    session_start();
    
    $name = $_POST["planname"];
    $username = $_SESSION["username"];
    $village = $_POST["village"];
    $target = $_POST["target"];
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("users", $con);
    
    $hashname = hash("crc32b", $username . $name);
 
    $delete = "DELETE FROM `" . $hashname . "` WHERE `village` = '$village' AND `target` = '$target'";
    mysql_query($delete, $con);
    
    mysql_close($con);

    return true;    

?>