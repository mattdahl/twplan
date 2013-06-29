<?php
  
    session_start();

    $name = $_POST["groupname"];
    $username = $_SESSION["username"];
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("groups", $con);
    
    $hashname = hash("crc32b", $username . $name . $_SESSION["world"]);
	
    $find = "SELECT * FROM `groups`.`$hashname`";
    $found = mysql_query($find, $con);
 
  	$s = "";    

    while ($foundarray = mysql_fetch_array($found))
      $s .= $foundarray["coords"] . " ";
        
    echo $s;
?>