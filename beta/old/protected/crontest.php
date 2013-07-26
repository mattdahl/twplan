<?php
    
date_default_timezone_set("Europe/London");  
$currenttime = date("Y-m-d H:i:s");
$message = "Cron test run successfully at " . $currenttime;
mail("site@twplan.com", "Cron Test Successful", $message);

?>