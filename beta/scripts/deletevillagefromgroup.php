<?php

    session_start();
    
    $name = $_POST["groupname"];
    $username = $_SESSION["username"];
	$vid = $_POST["villageid"];
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("groups", $con);
    
    $hashname = hash("crc32b", $username . $name . $_SESSION["world"]);
 
    $delete = "DELETE FROM `" . $hashname . "` WHERE `id` = '$vid'";
    mysql_query($delete, $con);
    
    mysql_close($con);

    return true;    

?>