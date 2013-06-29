<?php
  
    session_start();

    $name = $_POST["groupname"];
    $username = $_SESSION["username"];
    
    $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
    
    mysql_select_db("groups", $con);
	
    $hashname = hash("crc32b", $username . $name.  $_SESSION["world"]);

    $find = "SELECT * FROM `groups`.`$hashname`";
    $found = mysql_query($find, $con);
 
  	$s = "<h2>Group " . $name . "</h2><table><tr><th>Village Name</th><th>Coordinates</th><th>Continent</th><th>Delete</th></tr>";    

    while ($foundarray = mysql_fetch_array($found)) {
      $s .= "<tr id=\"" . $foundarray["villageName"] . "\">
                <td>" . $foundarray["villageName"] . "</td>
                <td>" . $foundarray["coords"] . "</td>
                <td>" . $foundarray["continent"] . "</td>
                <td><a href=\"#\"><img onClick=\"deleteVillageFromGroup('" . $name . "', '" . $foundarray["id"] . "')\" src=\"images/delete.png\" /></a></td>
        ";
    }
    
  $s .= "</table><br /><h2>Delete This Group</h2>Delete <a href=\"#\"><img onClick=\"deleteGroup();\" src=\"images/delete.png\" /></a>";
    
    echo $s;
?>