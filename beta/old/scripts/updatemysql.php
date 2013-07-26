<?php

  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  mysql_select_db("users", $con);
  
  $getusers = "SELECT `username` from `users`.`userinfo`";
  $users = mysql_query($getusers, $con);

   while ($r = mysql_fetch_array($users)) {
	  $username = $r["username"];
	  $replace = "UPDATE `users`.`userinfo` SET savedData='' WHERE `username` = '$username'";
   	  mysql_query($replace, $con);
  }

?>