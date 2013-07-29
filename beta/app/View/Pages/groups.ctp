<?php session_start();  ?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="scripts/onload.js"></script>
<title>Groups</title>
<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />
<script type="text/javascript" src="scripts/script.js"></script>
<script type="text/javascript"> /* Google Analytics */

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-34224555-1']);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();

</script>
</head>

<body>
<?php include "header.php" ?>
<div id="container">
	<h1>Groups</h1>

	<div id="instructions">
    <p>You can configure groups of preset lists of villages to automatically use in a plan (i.e. a group of your defense or offense villages). Select a group you want to modify, or choose to create a new group. Groups are world-specific.</p>
      <?php
            $username = $_SESSION["username"];
  
            $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
            mysql_select_db("users", $con);
            $find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
            $found = mysql_query($find, $con);
            $foundarray = mysql_fetch_array($found);
            $savedGroupData = json_decode($foundarray["savedGroupData"], true);
            
            if ($savedGroupData[0] == null) {
                echo "<select id=\"choosegroup\"><option>No groups yet</option></select>";
            }
            else {
                $groupnames = $savedGroupData[0];
				$worlds = $savedGroupData[2];
              	$s = "<select id=\"choosegroup\" onChange=\"displayGroup(this.value)\"> <option>Choose a group...</option>";
				$found = false;
                for ($i = 0; $i < count($groupnames); $i++) {
					if ($worlds[$i] == $_SESSION["world"]) {
                    	$s .= "<option>" . $groupnames[$i] . "</option>";
						$found = true;
					}
				}
                $s .= "</select>";
				if ($found)
                	echo $s;
				else
					echo "<select id=\"choosegroup\"><option>No groups yet</option></select>";
            }
			
        ?>
        <button onClick="createGroup();">Create Group</button>
  </div>
  <span id="loading" style="display:none"><img src="images/loading.gif" /></span>
  <div id="groupdisplay"></div>
  <div id="creategroupdisplay"></div>

</div>
<?php include "footer.php" ?>
</body>
</html>