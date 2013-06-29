<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
<script src="scripts/onload.js"></script>
<title>Plan</title>
<link rel="icon" href="http://static-twplan.appspot.com/images/favicon.ico" type="image/x-icon" />
<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />

<script type="text/javascript" src="scripts/script.js"></script>
<script type="text/javascript" src="scripts/hungarian6.js"></script>
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
<noscript>It looks like you have Javascript turned off! TWplan requires Javascript functionality to work. Please turn it on :)</noscript>
<h1>Planning - Step 1</h1>
<?php
  if (!isset($_SESSION["username"])) {
    echo "You must <a href=\"login.php\">login</a> to use TWplan's planning feature!<span id=\"dontload\" style=\"display:none\"></span>";
    return false;
  }
  
  $username = urlencode(rawurldecode($_SESSION["username"]));
  $world = $_SESSION["world"];
  
  $con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());
  
  mysql_select_db("players", $con);
  $query = "SELECT `playerid` FROM `players`.`en" . $world . "` WHERE `username` = '$username'";
  $result = mysql_query($query, $con);
  
  if (!$result || !mysql_fetch_array($result)) {
    echo "Are you sure you have an account on W" . $world . "? The database cannot find your username.<span id=\"dontload\" style=\"display:none\"></span>";
    return false;
  }
?>  
  
<p id="instructions">Below is a list of your villages. Select the ones you wish to include in the plan and choose the slowest traveling times, respectively. Choose how you want to classify each attack (noble, nuke, support). Common defaults are in place, but change them accordingly if needed (i.e. sending HC as an attack instead of support).<br /><br />At the bottom of the page is a table with all the villages you add to your plan.</p>
<br />
<div id="step1container">
<h2>Add Villages by Paste-In <a href=" javascript:void(0)" class="collapsebutton" onClick="handleCollapse(this, 'mass');">[collapse]</a></h2>
<div id="massinput">
      <p>Paste in a list of coordinates, copied from a TW overview screen or otherwise; coordinates will be parsed out.</p>
      <textarea id="villagecoordsbulk" style="float:left"></textarea>
      <table style="float:left">
        <tr>
          <th style="display:none"><!--Hidden Checkbox--></th><th colspan="12">Slowest Unit</th><th>Type of Attack</th>
        </tr>
        <tr>
          <td style="display:none"><input type="checkbox" id="bulkvillages" /></td>
          <td><img id="bulkvillages_0" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/spear.png" /></td>
          <td><img id="bulkvillages_1" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/sword.png" /></td>
          <td><img id="bulkvillages_2" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/axe.png" /></td>
          <td><img id="bulkvillages_3" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/archer.png" /></td>
          <td><img id="bulkvillages_4" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/scout.png" /></td>
          <td><img id="bulkvillages_5" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/lc.png" /></td>
          <td><img id="bulkvillages_6" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/hc.png" /></td>
          <td><img id="bulkvillages_7" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/marcher.png" /></td>
          <td><img id="bulkvillages_8" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/ram.png" /></td>
          <td><img id="bulkvillages_9" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/cat.png" /></td>
          <td><img id="bulkvillages_10" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/pally.png" /></td>
          <td><img id="bulkvillages_11" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/noble.png" /></td>
          <td class="attacktype">
            <form>
              <label for="bulkvillages_noble">Noble</label><input type="radio" name="attacktype" id="bulkvillages_noble" onClick="handleRadioClick(this.id)" />
              <label for="bulkvillages_nuke">Nuke</label><input type="radio" name="attacktype" id="bulkvillages_nuke" onClick="handleRadioClick(this.id)" />
              <label for="bulkvillages_support">Support</label><input type="radio" name="attacktype" id="bulkvillages_support" onClick="handleRadioClick(this.id)" />
            </form>
          </td>
        </tr>
       </table>
       <button onClick="addVillagesToPlanBulk()" style="margin-left:2%;">Add Villages to Plan</button>
</div>
	  <h2 style="clear:left"><br />Add Villages from Group
      <?php
	  $username = $_SESSION["username"];
      mysql_select_db("users", $con);
	  $find = "SELECT `savedGroupData` FROM `users`.`userinfo` WHERE `username` = '$username'";
	  $found = mysql_query($find, $con);
	  $foundarray = mysql_fetch_array($found);
	  $savedGroupData = json_decode($foundarray["savedGroupData"], true);
	  
	  if ($savedGroupData[0] != null) {
		  $groupnames = $savedGroupData[0];
		  $s = "<a href=\" javascript:void(0)\" class=\"collapsebutton\" onClick=\"handleCollapse(this, 'group');\">[collapse]</a></h2><div id=\"groupinput\"><select id=\"choosegroup\" style=\"float:left;width:315px;\"> <option>Choose a group to use in plan...</option>";
		  for ($i = 0; $i < count($groupnames); $i++)
			  $s .= "<option>" . $groupnames[$i] . "</option>";
		  $s .= "</select>";
	
		  echo $s;
	  }
	  else
			echo "</h2><p>You have no groups configured. Go to the <a href=\"/groups.php\">groups</a> tab to create village groups.</p>
			<div id=\"groupinput\" style=\"display:none\">";
	  ?>      
      	  	<table style="float:left;margin-left:2%;">
        	<tr>
          		<th style="display:none"><!--Hidden Checkbox--></th><th colspan="12">Slowest Unit</th><th>Type of Attack</th>
        	</tr>
        	<tr>
			  <td style="display:none"><input type="checkbox" id="groupvillages" /></td>
			  <td><img id="groupvillages_0" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/spear.png" /></td>
			  <td><img id="groupvillages_1" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/sword.png" /></td>
			  <td><img id="groupvillages_2" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/axe.png" /></td>
			  <td><img id="groupvillages_3" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/archer.png" /></td>
			  <td><img id="groupvillages_4" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/scout.png" /></td>
			  <td><img id="groupvillages_5" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/lc.png" /></td>
			  <td><img id="groupvillages_6" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/hc.png" /></td>
			  <td><img id="groupvillages_7" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/marcher.png" /></td>
			  <td><img id="groupvillages_8" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/ram.png" /></td>
			  <td><img id="groupvillages_9" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/cat.png" /></td>
			  <td><img id="groupvillages_10" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/pally.png" /></td>
			  <td><img id="groupvillages_11" onClick="handleUnitClick(this.id)" src="http://static-twplan.appspot.com/images/units/noble.png" /></td>
			  <td class="attacktype">
				<form>
				  <label for="groupvillages_noble">Noble</label><input type="radio" name="attacktype" id="groupvillages_noble" onClick="handleRadioClick(this.id)" />
				  <label for="groupvillages_nuke">Nuke</label><input type="radio" name="attacktype" id="groupvillages_nuke" onClick="handleRadioClick(this.id)" />
				  <label for="groupvillages_support">Support</label><input type="radio" name="attacktype" id="groupvillages_support" onClick="handleRadioClick(this.id)" />
				</form>
			  </td>
        </tr>
       </table>
       <button onClick="addGroupToPlan();" style="float:left;margin-left:2%;">Add Group to Plan</button>
      
</div>
       
       <h2 style="clear:left"><br />Add Villages from List <a href=" javascript:void(0)" class="collapsebutton" onClick="handleCollapse(this, 'single');">[collapse]</a></h2>
       <table id="villages">
       	<tr><th style="display:none"><!--Checkbox--></th><th>Village Name</th><th>Coordinates</th><th>Continent</th><th colspan="12">Slowest Unit</th><th>Type of Attack</th><th>Add Village to Plan</th></tr>
        <tr id="loading"><td colspan="17"><img src="http://static-twplan.appspot.com/images/loading.gif" /></td></tr>
        </table>
        <br />
        <h2>Villages in Plan</h2>
	<form id="sendvillageinfo" action="" method="post"><table id="villagesinplan"><tr><th style="display:none"><!--Hidden Checkbox--></th><th>Village Name</th><th>Coordinates</th><th>Continent</th><th>Slowest Unit</th><th>Type of Attack</th><th>Remove Village from Plan</th></tr></table>
	<span style="font-family:Arial;font-size:12px"><span id="selectednobles">0</span> nobles, <span id="selectednukes">0</span> nukes, and <span id="selectedsupports">0</span> supports added.</span>
	<br /><br />
	<input id="submitvillageinfo" type="submit" onClick="return submitVillages()" /></form>
</div>
<div id="step2container">
  <a href="#" onClick="backToStep1();return true;"><img src="images/backarrow.png" class="backarrow" /></a>

<div id="step2containerleft">
<h2>Add Many Targets</h2>
<p>Paste in a list of target coordinates.</p>
<textarea id="targetcoordsbulk"></textarea>
  <table style="float:left; margin-left: 40px; width:350px; clear:right;">
    <tbody style="display:table-row-group"><tr>
      <th colspan="3">Quanity Commands to Send to These Villages</th>
    </tr>
    <tr>
      <td>Nobles <input type='number' min='0' id='bulktargetnobles' /></td>
      <td>Nukes <input type='number' min='0' id='bulktargetnukes' /></td>
      <td>Support <input type='number' min='0' id='bulktargetsupports' /></td>
    </tr></tbody>
  </table>
  <div style="clear:both"></div>
  <br />
  <button type="button" onClick="addVillagesToTable(targetcoordsbulk.value)">Add Villages</button>  
<br />
<br />  
<h2>Add Single Target</h2>
<p>Type in a single coordinate in the form xxx|yyy.</p>
<input id="targetcoords" type="text" name="targetinfo" onKeyUp="addVillageToTable(this.value, 0, 0, 0);" />
</div>

<div id="step2containerright">
      <h2>Targets in Plan</h2>
<table id="targetvillages">
<tr><th>Village</th><th colspan="3">Quantity Commands to Send</th><th>Delete</th></tr>
</table>
    <button style="position:relative; top:20px;" onClick="submitTargets()">Submit</button>

  </div>
  
<div id="availablevillages">
<center><b>Available Villages</b></center>
<table id="availablevillagestable">
	<tr><th>Nobles</th><th>Nukes</th><th>Supports</th></tr>
    <tr><td><span id="availablenobles"></span></td><td><span id="availablenukes"></span></td><td><span id="availablesupports"></span></td></tr>
</table>
</div>
  
<div id="placeholder"></div>

  
</div>
<div id="step3container">
  <a href="#" onClick="backToStep2();return true;"><img src="images/backarrow.png" class="backarrow" /></a>
  
<h2>Arrival Information</h2>
Landing Date (mm/dd/yyyy): <input type="date" id="landingdate" />
Landing Time (hh:mm:ss): <input type="text" id="landingtime" /> <br /> <br />
<h2>Launch Time Optimization <input id="timingrestriction" type="checkbox" /></h2>
<p>Between what two times is the best time to launch attacks?</p>
Early Bound:
<select id="earlybound">
<option>00:00</option>
<option>01:00</option>
<option>02:00</option>
<option>03:00</option>
<option>04:00</option>
<option>05:00</option>
<option>06:00</option>
<option>07:00</option>
<option>08:00</option>
<option>09:00</option>
<option>10:00</option>
<option>11:00</option>
<option>12:00</option>
<option>13:00</option>
<option>14:00</option>
<option>15:00</option>
<option>16:00</option>
<option>17:00</option>
<option>18:00</option>
<option>19:00</option>
<option>20:00</option>
<option>21:00</option>
<option>22:00</option>
<option>23:00</option>
</select>
Late Bound:
<select id="latebound">
<option>00:00</option>
<option>01:00</option>
<option>02:00</option>
<option>03:00</option>
<option>04:00</option>
<option>05:00</option>
<option>06:00</option>
<option>07:00</option>
<option>08:00</option>
<option>09:00</option>
<option>10:00</option>
<option>11:00</option>
<option>12:00</option>
<option>13:00</option>
<option>14:00</option>
<option>15:00</option>
<option>16:00</option>
<option>17:00</option>
<option>18:00</option>
<option>19:00</option>
<option>20:00</option>
<option>21:00</option>
<option>22:00</option>
<option>23:00</option>
</select> <br /> <br /> <br />
<button onClick="submitHungarian();">Calculate Plan</button>
</div>
<div id="results">
  <a href="#" onClick="backToStep2a();return true;"><img src="images/backarrow.png" class="backarrow" /></a>
<h2 id="attackplantitle">Attack Plan</h2>
<table id="resulttable" class="tablesorter">
  <tr><th>Village</th><th>Target</th><th>Slowest Unit</th><th>Attack Type</th><th>Traveling Time</th><th>ST Launch Time</th><th>Local Launch Time</th><th>Time Remaining</th><th>Launch Link</th></tr>
</table>
  
<!--<div id="collectplan">
  <b>Help Debug TWplan!</b> <br />
  <p>You can send your plan results to Syntex (Matt) to help with the identification of bugs. This is optional, but I have no interest in using your plan maliciously! Thanks for your help :)</p>
    <button onClick="collectPlan();">Send Plan Data</button>  
</div>-->
  
<div style="height: 200px; margin-right: 2%; position: relative; float: left">
<p class="resultsubtitle">Export as Table</p>
<textarea id="export1"></textarea>
</div>
<div style="height: 200px; margin-right: 2%; position: relative; float: left;">
<p class="resultsubtitle">Export as Text</p>
<textarea id="export2"></textarea>
</div>
  <div style="height: 200px; width: 350px; margin-right: 2%; position: relative; float: left;">
  <p class="resultsubtitle">Save Plan</p>
    <label id="plannamelabel" for="planname">Plan Name:</label> <input type="text" id="planname" /><button id="save" onClick="doesPlanExist()">Save</button>
    <img id="loadingcircle" src="http://static-twplan.appspot.com/images/loadingcircle.gif" />
    <div id="saveresults"></div>
</div>

<div id="redoplan">
<b>Recalculate Plan With Different Landing Information</b> <br /> <br />
<form>
Landing Date (mm/dd/yyyy): <input type="date" id="newlandingdate" />
Landing Time (hh:mm:ss): <input type="text" id="newlandingtime" /> <br /> <br />
<input type="submit" value="Recalculate Plan" onClick="reSubmitHungarian(); return false;" />
</form>
</div>

</div>
</div>  
  
</body>

<?php include "footer.php" ?>

</html>