<?php
  
session_start();

$landingdate = $_POST["landingDate"];
$landingtime = $_POST["landingTime"];
$name = $_POST["planname"];
$username = $_SESSION["username"];
$world = $_SESSION["world"];
$plan = $_POST["plan"];
$overwrite = $_POST["overwrite"];
$planarray = json_decode($plan, true);
$ow = false;

set_time_limit(600); // in seconds; 10min should be ample

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
mysql_select_db("users", $con);

$hashname = hash("crc32b", $username . $name);
  
  if ($overwrite == "false") {
$createplan = "CREATE TABLE `" . $hashname . "` (
                           `village` VARCHAR(7) NOT NULL,
                           `target` VARCHAR(7) NOT NULL,
                           `slowUnit` VARCHAR(10) NOT NULL,
                           `attackType` VARCHAR(10) NOT NULL,
                           `travelTime` VARCHAR(9) NOT NULL, 
                           `launchTime` VARCHAR(50) NOT NULL,
                           `ltms` INT NOT NULL
                )";
mysql_query($createplan, $con);
  }
  else { // overwrites existing plan under this name
      $delete = "TRUNCATE `" . $hashname . "`";
      mysql_query($delete, $con);
    
      $ow = true;
    }
    
    foreach($planarray as $o) {
        $insert = "INSERT INTO `users`.`" . $hashname . "` (
                    `village` ,
                    `target` ,
                    `slowUnit` ,
                    `attackType` ,
                    `travelTime` ,
                    `launchTime` ,
                    `ltms`
                    )
                    VALUES (
                    '$o[v]', '$o[t]', '$o[slow]', '$o[at]', '$o[tt]', '$o[lt]', '$o[ltms]'
                    )";
        mysql_query($insert, $con);
    }
    
$find = "SELECT `savedData` FROM `users`.`userinfo` WHERE `username` = '$username'";
$found = mysql_query($find, $con);
$foundarray = mysql_fetch_array($found);
$savedData = json_decode($foundarray["savedData"], true);
  
if ($savedData == null)
  $savedData = array(array(), array(), array(), array()); // landingdate, landingtime, plan name, planID

  if (!$ow) {
  
array_push($savedData[0], $landingdate);
array_push($savedData[1], $landingtime);
array_push($savedData[2], $name);
array_push($savedData[3], $hashname);  
  }
  else {
    for ($i = 0; $i < count($savedData[2]); $i++) {
        if ($savedData[2][$i] == $name) {
          $savedData[0][$i] = $landingdate;
          $savedData[1][$i] = $landingtime;
          break;
        }
     }
  }
    
$updated = json_encode($savedData);
$replace = "UPDATE `users`.`userinfo` SET savedData='$updated' WHERE `username` = '$username'";
mysql_query($replace, $con);

mysql_close($con);

return true;

?>