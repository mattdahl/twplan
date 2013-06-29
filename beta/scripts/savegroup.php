<?php
  
session_start();

$username = $_SESSION["username"];

$world = $_SESSION["world"];
$name = $_POST["groupname"];
$group = $_POST["group"];
$grouparray = json_decode($group, true);

set_time_limit(600); // in seconds; 10min should be ample

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
mysql_select_db("groups", $con);

$hashname = hash("crc32b", $username . $name . $_SESSION["world"]);
  
$creategroup =  "CREATE TABLE `" . $hashname . "` (
        			`villageName` VARCHAR(100) NOT NULL,
        			`coords` VARCHAR(7) NOT NULL,
        			`continent` VARCHAR(3) NOT NULL,
        			`id` VARCHAR(10) NOT NULL
				)";
mysql_query($creategroup, $con);

foreach($grouparray as $r) {
	   $insert = "INSERT INTO `groups`.`" . $hashname . "` (
                    `villageName`,
                    `coords`,
                    `continent`,
                    `id`
                    )
                    VALUES (
                    '$r[villageName]', '$r[coords]', '$r[continent]', '$r[id]'
                    )";
        mysql_query($insert, $con);
}
    
$find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
$found = mysql_query($find, $con);
$foundarray = mysql_fetch_array($found);
$savedGroupData = json_decode($foundarray["savedGroupData"], true);
  
if ($savedGroupData == null || $foundarray["savedGroupData"] == null)
  $savedGroupData = array(array(), array(), array()); // group name, groupID, world

array_push($savedGroupData[0], $name);
array_push($savedGroupData[1], $hashname);
array_push($savedGroupData[2], $_SESSION["world"]);
    
$updated = json_encode($savedGroupData);

mysql_select_db("users", $con);
$replace = "UPDATE `users`.`userinfo` SET savedGroupData='$updated' WHERE `username` = '$username'";
mysql_query($replace, $con);

mysql_close($con);

return true;

?>