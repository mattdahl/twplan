<?php session_start(); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="scripts/onload.js"></script>
    <title>Submitted Bug Report</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
</head>
<body>
	<?php include "header.php" ?>
	<?php include "topnavbar.php" ?>
    
	<div id="container">
    	<h1>Submitted Bug Report</h1>
        <p>Thanks for submitting a report! The submission was
        	<?php
            	if ($_GET["success"])
					echo " successful.";
				else
					echo " not successful. Something really must be broken. How about you contact Syntex on Skype at <i>syntexgrid</i>? Thanks.";
			?>
        </p>
    </div>
    
    <?php include "footer.php" ?>
</body>
</html>