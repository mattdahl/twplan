<?php

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());

mysql_select_db("users", $con);
$query = "SELECT `savedGroupData`, `username` FROM `users`.`userinfo`";
$result = mysql_query($query, $con);

$i = 0;

$newData = array(array(), array());

while ($foundarray = mysql_fetch_array($result)) {
  $newData[$i][0] = $foundarray["savedGroupData"];
  $newData[$i][1] = $foundarray["username"];
  $i++;
}

for ($j = 0; $j < count($newData); $j++) {
  $query = "UPDATE `users`.`userinfo` SET `savedGroupData2`='" . $newData[$j][0] . "' WHERE `username`='" . $newData[$j][1] ."'";
  $result = mysql_query($query, $con);

  echo $query . "<br />";
}

mysql_close($con);
?>