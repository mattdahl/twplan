<?php  

session_start(); 
  
if ($_SESSION["username"] != "syntexgrid")
  return false;

$world = $_GET["world"];
$filename = "http://en" . $world . ".tribalwars.net/map/player.txt/";
$file = fopen($filename, "r");

set_time_limit(600); // in seconds; 10min should be ample

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());

mysql_select_db("players", $con);

$create = "CREATE TABLE IF NOT EXISTS `players`.`en" . $world. "` (`playerid` INT NOT NULL, `username` VARCHAR(200) NOT NULL, `tribeid` INT NOT NULL, `numvillages` INT NOT NULL, PRIMARY KEY (`playerid`), UNIQUE (`username`)) ENGINE = MyISAM;";
mysql_query($create, $con);

$delete = "TRUNCATE en" . $world;
mysql_query($delete, $con);

$line;
$insert;

while(!feof($file)) {
  $line = fgets($file);
  $tokens = explode(",", $line);
  
  $insert = "INSERT INTO  `players`.`en" . $world . "` (
    `playerid` ,
    `username` ,
    `tribeid` ,
    `numvillages`
  )
  VALUES (
    '$tokens[0]',  '$tokens[1]',  $tokens[2], $tokens[3]
  )";

  mysql_query($insert, $con);
}

  //$sort = "SELECT `playerid`, `username`, `tribeid`, `numvillage` FROM players ORDER BY `playerid`";
  //mysql_query($sort, $con);

fclose($file);

mysql_close($con);

?>