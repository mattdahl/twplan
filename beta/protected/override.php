<?php

  $username = $_GET["fake"];
  
session_start();

if ($_SESSION["username"] == "syntexgrid")
  $_SESSION["username"] = rawurlencode($username);
  
  header("Location: /plan.php");

return true;
?>