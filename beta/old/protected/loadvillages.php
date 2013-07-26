<?php
  
mail("site@twplan.com", "TWplan Village Database Updated", "LoadVillages Opened");
  
session_start();

if ($_SESSION["username"] != "syntexgrid")
  return false;

  $world = $_GET["world"];
  
$filename = "http://en" . $world. ".tribalwars.net/map/village.txt";
$file = fopen($filename,"r");

set_time_limit(600); // in seconds; 10min should be ample

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());

mysql_select_db("villages", $con);

$create = "CREATE TABLE IF NOT EXISTS `villages`.`en" . $world . "` (`villageid` INT NOT NULL, `name` VARCHAR(100) NOT NULL, `xcoord` INT NOT NULL, `ycoord` INT NOT NULL, `playerid` INT NOT NULL, INDEX (`xcoord`, `ycoord`, `playerid`), UNIQUE (`villageid`)) ENGINE = MyISAM;";
mysql_query($create, $con);

$delete = "TRUNCATE en" . $world;
mysql_query($delete, $con);

$line;
$insert;
$i = 0;

while(!feof($file)) {
  $line = fgets($file);
  $tokens = explode(",", $line);
  
  $insert = "INSERT INTO  `villages`.`en" . $world . "` (
    `villageid` ,
    `name` ,
    `xcoord` ,
    `ycoord` ,
    `playerid`
  )
  VALUES (
    '$tokens[0]',  '$tokens[1]',  $tokens[2], $tokens[3], '$tokens[4]'
  )";

  mysql_query($insert, $con);
  $i++;
}

fclose($file);

  //$sort = "SELECT `villageid`, `name`, `xcoord`, `ycoord`, `playerid` FROM villages ORDER BY `playerid`";
  //mysql_query($sort, $con);  

date_default_timezone_set("Europe/London");  
$currenttime = date("Y-m-d H:i:s");
$message = "W" . $world . " village database updated successfully at " . $currenttime . " with " . $i . " records";
mail("site@twplan.com", "TWplan Village Database Updated", $message);


mysql_select_db("analytics", $con);
  
$updatetime = "UPDATE `analytics`.`lastUpdated` SET dateTime='$currenttime' WHERE `world` = '$world'";
mysql_query($updatetime, $con);

mysql_close($con);  
  
?>