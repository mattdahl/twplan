<?php

  $page = $_POST["page"];
  $errormsg = $_POST["errormsg"];
  $bugnature = $_POST["bugnature"];
  $browser = $_POST["browser"];
  $replicate = $_POST["replicate"];
  $username = $_POST["user"];
  $world = $_POST["world"];
  $skype = $_POST["skype"];
  $auto = $_POST["auto"];
  
  if (!$username || !$world) {
	  if ($auto == "true")
	  	throw new Exception("Username or world not set");
	  else
      	header("Location: http://www.twplan.com/submittedreport.php?success=false");
	  return false;
  }

  $message = "
    Page of error: " . $page . "\n
    Error message: " . $errormsg . "\n
    Nature of bug: " . $bugnature . "\n
    Browser/version: " . $browser . "\n
    Replicatable? " . $replicate . "\n \n
    Submitted by: " . $username . "\n
    World: " . $world . "\n
	Skype: " . $skype;
  
  if (mail("support@twplan.com", "TWplan Bug Report", $message)) {
	  if ($auto == "true")
	  	return true;
	  else
    	header("Location: http://www.twplan.com/submittedreport.php?success=true");
  }
  else {
  	  if ($auto == "true")
  	  	throw new Exception("Error sending error email.");
	  else
	    header("Location: http://www.twplan.com/submittedreport.php?success=false");
  }
  
?>