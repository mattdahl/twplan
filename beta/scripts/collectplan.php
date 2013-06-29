<?php

session_start();
  
$worldSpeed = $_POST["worldSpeed"];
$unitSpeed = $_POST["unitSpeed"];

$username = $_SESSION["username"];
$timezone = $_POST["timeZone"];
$landingdate = $_POST["landingDate"];
$landingtime = $_POST["landingTime"];
$plan = $_POST["plan"];
$planarray = json_decode($plan, true);

set_time_limit(600); // in seconds; 10min should be ample

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
mysql_select_db("users", $con);
  
$unitSpeeds = array (
  "spear"=>18,
  "sword"=>22,
  "axe"=>18,
  "archer"=>18,
  "scout"=>9,
  "lc"=>10,
  "marcher"=>10,
  "hc"=>11,
  "ram"=>30,
  "cat"=>30,
  "pally"=>10,
  "noble"=>35,
);
 
  
function dist($village, $target, $speed) {
    if ($village && $target && $speed) {
        $a = explode("|", $village);
        $b = explode("|", $target);
        $d = sqrt(($a[0]-$b[0])*($a[0]-$b[0])+($a[1]-$b[1])*($a[1]-$b[1]));
        
        return (($d*$speed)/($worldSpeed*$unitSpeed))*60000;
    }
}
  
function pad($n) {
  return ($n < 10 ? "0" + $n : $n);
};
  
function formatSeconds($secs) {
    $h = floor($secs / 3600);
    $m = floor(($secs / 3600) % 1 * 60);
    $s = floor(($secs / 60) % 1 * 60);
    return pad($h). ":" . pad($m) . ":" . pad($s);
};
  
$c1 = 0;
$c2 = "";
    
foreach($planarray as $o) {
  $speed = $unitSpeeds[strtolower($o['slow'])];
  $c1 = dist($o['t'], $o['v'], $speed)/1000;
  $c2 = formatSeconds($c1);
  
        $insert = "INSERT INTO `users`.`collected` (
                    `username` ,
                    `timeZone` ,
                    `landingDate` ,
                    `landingTime` ,
                    `village` ,
                    `target` ,
                    `slowUnit` ,
                    `attackType` ,
                    `travelTime` ,
                    `realTT` ,
                    `launchTime` ,
                    `ltms`
                    )
                    VALUES (
                    '$username', '$timezone', '$landingdate', '$landingtime', '$o[v]', '$o[t]', '$o[slow]', '$o[at]', '$o[tt]', '$c2', '$o[lt]', '$o[ltms]'
                    )";
        mysql_query($insert, $con);
}

mysql_close($con);

return true;

?>