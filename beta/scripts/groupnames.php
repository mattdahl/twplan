<?php
$username = $_SESSION["username"];

mysql_select_db("users", $con);
$find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
$found = mysql_query($find, $con);
$foundarray = mysql_fetch_array($found);
$savedGroupData = json_decode($foundarray["savedGroupData"], true);

$groupnames = $savedGroupData[0];

echo json_encode($savedGroupData);

mysql_close($con);
?>