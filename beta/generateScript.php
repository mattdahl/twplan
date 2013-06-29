<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  	<link rel="stylesheet" type="text/css" href="style.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="scripts/onload.js"></script>
	<title>Launch Script Generator</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
    
    <script type="application/javascript">
		function generateScript() {
			var $s = "javascript: var troops = {support: [";
			var $inputs = $("#supportscripttroops").find("input");
			$inputs.each(function(index, element) {
					if (!$(element).val())
						$s += "0";
					else
                    	$s += $(element).val();
					if (index != 11)
						$s += ",";
			});
			$s += "], nuke: [";
			$inputs = $("#nukescripttroops").find("input");
			$inputs.each(function(index, element) {
					if (!$(element).val())
						$s += "0";
					else
                    	$s += $(element).val();
					if (index != 11)
						$s += ",";
                });
			$s += "], noble: [";
			$inputs = $("#noblescripttroops").find("input");
			$inputs.each(function(index, element) {
				if (!$(element).val())
						$s += "0";
					else
                    	$s += $(element).val();
					if (index != 11)
						$s += ",";
                });
			$s += "]}; var archer=";
			if ($("no#archer").prop("checked", "true"))
				$s += "false; ";
			else
				$s += "true; ";
			
			$s += "$.getScript(\"http://twplan.com/launchScript.js\"); void(0);";			
			
			$("#generatedscript").html($s);
		}
	</script>
</head>

<body>
  <?php include "header.php" ?>
  
  <div id="container">
  	<h1>Generate Launch Script</h1>
    <p>Use this interface to create a Javascript script that makes launching from TWplan-created plans easy. Install the script in your Tribalwars quickbar or in a bookmark that you link to a macro (a premium account is not required).</p>
    <p>Once you create a plan on TWplan, a series of links appears in the rightmost column. When it's time to send an attack, click on the appropriate link and it will take you to the rally point of one of your villages. Then, run this script and the rally point will populate itself with the coordinates of your target along with any preset troop combinations you define below. For instance, if your nukes typically consist of 6000 axes, 3000 lc, and 300 rams, put those values in below and any time you need to send a nuke attack from a TWplan plan it will be automatically set for you.</p>
    
    <b>Noble Troop Amounts</b>
    <table id="noblescripttroops">
    	<tr>
        	<td><img src="http://static-twplan.appspot.com/images/units/spear.png" /></td>
            <td><img src="http://static-twplan.appspot.com/images/units/sword.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/axe.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/archer.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/scout.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/lc.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/hc.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/marcher.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/ram.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/cat.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/pally.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/noble.png" /></td>
        </tr>
        <tr>
        	<td><input type="number" /></td>
            <td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        </tr>
    </table>
    <br />
    <b>Nuke Troop Amounts</b>
    <table id="nukescripttroops">
    	<tr>
        	<td><img src="http://static-twplan.appspot.com/images/units/spear.png" /></td>
            <td><img src="http://static-twplan.appspot.com/images/units/sword.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/axe.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/archer.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/scout.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/lc.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/hc.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/marcher.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/ram.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/cat.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/pally.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/noble.png" /></td>
        </tr>
        <tr>
        	<td><input type="number" /></td>
            <td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        </tr>
    </table>
    <br />
    <b>Support Troop Amounts</b>
    <table id="supportscripttroops">
    	<tr>
        	<td><img src="http://static-twplan.appspot.com/images/units/spear.png" /></td>
            <td><img src="http://static-twplan.appspot.com/images/units/sword.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/axe.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/archer.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/scout.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/lc.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/hc.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/marcher.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/ram.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/cat.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/pally.png" /></td>
        	<td><img src="http://static-twplan.appspot.com/images/units/noble.png" /></td>
        </tr>
        <tr>
        	<td><input type="number" /></td>
            <td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        	<td><input type="number" /></td>
        </tr>
    </table>
    
    <br />
    <input type="checkbox" id="noarcher" /> Non-Archer world? <br />
    <button onclick="generateScript()">Generate Script</button> <br />
    
    <h2>Generated Script</h2>
    <textarea id="generatedscript" onfocus="$(this).select()" onmouseup="return false" readonly="readonly"></textarea>
    
  </div>
  
  <?php include "footer.php" ?>
</body>
</html>