<?php
session_start();
?>
<!DOCTYPE html>
<html ng-app='PlanModule'>
<head>
	<title>Plan</title>
	<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />

	<link rel="icon" href="http://static-twplan.appspot.com/images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="style.css" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
	<script src="scripts/javascripts/controllers/plan.js"></script>
	<script src="scripts/onload.js"></script>
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
		<h1>Planning - Step {{current_step + 1}}</h1>
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

		<p id="instructions">{{instructions[current_step]}}</p>
		<br />
		<div id="step_one_container" ng-controller='StepOneController'>
			<h2>Add Villages by Paste-In <a href=" javascript:void(0)" class="collapsebutton" onClick="handleCollapse(this, 'mass');">[collapse]</a></h2>
			<div>
				<p>Paste in a list of coordinates, copied from a TW overview screen or otherwise; coordinates will be parsed out.</p>
				<textarea id="villages_paste_in" style="float:left" ng-model='villages_paste_in_coords'></textarea>
				<table style="float:left">
					<tr>
						<th colspan="12">Slowest Unit</th>
						<th>Type of Attack</th>
					</tr>
					<tr>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Spear)}' ng-click='paste_in_row.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Sword)}' ng-click='paste_in_row.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Axe)}' ng-click='paste_in_row.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Archer)}' ng-click='paste_in_row.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Scout)}' ng-click='paste_in_row.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Lc)}' ng-click='paste_in_row.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Hc)}' ng-click='paste_in_row.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Marcher)}' ng-click='paste_in_row.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Ram)}' ng-click='paste_in_row.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Cat)}' ng-click='paste_in_row.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Pally)}' ng-click='paste_in_row.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
						<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Noble)}' ng-click='paste_in_row.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
						<td class='attacktype'>
							<form>
								<label for='paste_in_nuke'>Nuke</label><input type='radio' name='attacktype' id='paste_in_nuke' value='{{AttackTypes.Nuke}}' ng-click='paste_in_row.setAttackType(AttackTypes.Nuke)' ng-model='paste_in_row.attack_type' />
								<label for='paste_in_noble'>Noble</label><input type='radio' name='attacktype' id='paste_in_noble' value='{{AttackTypes.Noble}}' ng-click='paste_in_row.setAttackType(AttackTypes.Noble)' ng-model='paste_in_row.attack_type' />
								<label for='paste_in_support'>Support</label><input type='radio' name='attacktype' id='paste_in_support' value='{{AttackTypes.Support}}' ng-click='paste_in_row.setAttackType(AttackTypes.Support)' ng-model='paste_in_row.attack_type' />
							</form>
						</td>
					</tr>
				</table>
				<button ng-click="paste_in_row.addToPlan()" style="margin-left:2%;">Add Villages to Plan</button>
			</div>
			<h2 style="clear:left"><br />Add Villages from Group</h2>
				<p ng-hide='(group_names.length > 0)'>You have no groups configured. Go to the <a href=\"/groups.php\">groups</a> tab to create village groups.</p>
				<div id='group_dropdown' ng-show='(group_names.length > 0)'>
					<select id='choosegroup' style='float:left;width:315px;'>
						<option>Choose a group to use in plan...</option>
						<option ng-repeat='group in groups'>{{this.group.name}}</option>
					</select>

				<table style="float:left">
					<tr>
						<th colspan="12">Slowest Unit</th>
						<th>Type of Attack</th>
					</tr>
					<tr>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Spear)}' ng-click='group_row.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Sword)}' ng-click='group_row.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Axe)}' ng-click='group_row.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Archer)}' ng-click='group_row.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Scout)}' ng-click='group_row.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Lc)}' ng-click='group_row.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Hc)}' ng-click='group_row.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Marcher)}' ng-click='group_row.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Ram)}' ng-click='group_row.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Cat)}' ng-click='group_row.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Pally)}' ng-click='group_row.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
						<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Noble)}' ng-click='group_row.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
						<td class='attacktype'>
							<form>
								<label for='group_nuke'>Nuke</label><input type='radio' name='attacktype' id='group_nuke' value='{{AttackTypes.Nuke}}' ng-click='group_row.setAttackType(AttackTypes.Nuke)' ng-model='group_row.attack_type' />
								<label for='group_noble'>Noble</label><input type='radio' name='attacktype' id='group_noble' value='{{AttackTypes.Noble}}' ng-click='group_row.setAttackType(AttackTypes.Noble)' ng-model='group_row.attack_type' />
								<label for='group_support'>Support</label><input type='radio' name='attacktype' id='group_support' value='{{AttackTypes.Support}}' ng-click='group_row.setAttackType(AttackTypes.Support)' ng-model='group_row.attack_type' />
							</form>
						</td>
					</tr>
				</table>
				<button onClick="group_row.addToPlan();" style="float:left;margin-left:2%;">Add Group to Plan</button>
			</div>

			<h2 style="clear:left"><br />Add Villages from List <a href=" javascript:void(0)" class="collapsebutton" onClick="handleCollapse(this, 'single');">[collapse]</a></h2>

			<table>
				<tr>
					<th>Village Name</th>
					<th>Coordinates</th>
					<th>Continent</th>
					<th colspan="12">Slowest Unit</th>
					<th>Type of Attack</th>
					<th>Add Village to Plan</th>
				</tr>
				<tr ng-hide='(villages.length > 0)'>
					<td colspan="16"><img src="http://static-twplan.appspot.com/images/loading.gif" /></td>
				</tr>
				<tr ng-repeat='village in villages' id='{{village.village_id}}_row'>
					<td style='display:none'><input type='checkbox' id='{{village.village_id}}' name='selectedVillages[]' /></td>
					<td class='villagename'>{{village.name}}</td>
					<td class='coordsearch' id='{{village.village_id}}c'>{{village.x_coord}}|{{village.y_coord}}</td>
					<td>{{village.continent}}</td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Spear)}' ng-click='this.village.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Sword)}' ng-click='this.village.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Axe)}' ng-click='this.village.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Archer)}' ng-click='this.village.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Scout)}' ng-click='this.village.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Lc)}' ng-click='this.village.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Hc)}' ng-click='this.village.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Marcher)}' ng-click='this.village.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Ram)}' ng-click='this.village.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Cat)}' ng-click='this.village.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Pally)}' ng-click='this.village.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
					<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Noble)}' ng-click='this.village.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
					<td class='attacktype'>
						<form>
							<label for='{{$index}}_nuke'>Nuke</label><input type='radio' name='attacktype' id='{{$index}}_nuke' value='{{AttackTypes.Nuke}}' ng-click='this.village.setAttackType(AttackTypes.Nuke)' ng-model='this.village.attack_type' />
							<label for='{{$index}}_noble'>Noble</label><input type='radio' name='attacktype' id='{{$index}}_noble' value='{{AttackTypes.Noble}}' ng-click='this.village.setAttackType(AttackTypes.Noble)' ng-model='this.village.attack_type' />
							<label for='{{$index}}_support'>Support</label><input type='radio' name='attacktype' id='{{$index}}_support' value='{{AttackTypes.Support}}' ng-click='this.village.setAttackType(AttackTypes.Support)' ng-model='this.village.attack_type' />
						</form>
					</td>
					<td><button id='{{village.village_id}}_add_button' ng-click='this.village.addToPlan()' ng-disabled='(!this.village.slowest_unit && !this.village.attack_type)'>Add Village</button></td>
				</tr>
			</table>

			<br />
			<h2>Villages in Plan</h2>
			<table>
				<tr>
					<th>Village Name</th>
					<th>Coordinates</th>
					<th>Continent</th>
					<th>Slowest Unit</th>
					<th>Type of Attack</th>
					<th>Remove Village from Plan</th>
				</tr>
				<tr ng-repeat='village in villages_in_plan.villages'>
					<td>{{village.name}}</td>
					<td>{{village.x_coord}}|{{village.y_coord}}</td>
					<td>{{village.continent}}</td>
					<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
					<td>{{AttackTypes.toString[village.attack_type]}}</td>
					<td><button ng-click='this.village.removeFromPlan()'>Remove Village</button></td>
				</tr>
			</table>
				<span style="font-family:Arial;font-size:12px">
					{{villages_in_plan.nukes}} nukes,
					{{villages_in_plan.nobles}} nobles, and
					{{villages_in_plan.supports}} supports added.
				</span>
				<br /><br />
				<button ng-click='submitStepOne()'>Submit Villages</button>
			</div>
			<div id="step_two_container" ng-controller='StepTwoController' >
				<a href="#" onClick="backToStepOne();"><img src="images/backarrow.png" class="backarrow" /></a>

				<h2>Add Targets</h2>
				<p>Paste in a list of target coordinates.</p>
				<textarea id="targets_paste_in"></textarea>
				<table style="float:left; margin-left: 40px; width:350px; clear:right;">
					<tr>
						<th colspan="3">Quantity Commands to Send to These Villages</th>
					</tr>
					<tr>
						<td>Nobles <input type='number' min='0' id='bulktargetnobles' /></td>
						<td>Nukes <input type='number' min='0' id='bulktargetnukes' /></td>
						<td>Support <input type='number' min='0' id='bulktargetsupports' /></td>
					</tr>
				</table>
				<button type="button" onClick="addVillagesToTable(targetcoordsbulk.value)">Add Villages</button>
				<br />
				<br />

				<div id="target_assginment">
					<div style="width: 45%; float:left;">
						<h2>Villages in Plan</h2>
						<table>
							<tr>
								<th>Village Name</th>
								<th>Coordinates</th>
								<th>Continent</th>
								<th>Slowest Unit</th>
								<th>Type of Attack</th>
								<th>Target</th>
							</tr>
							<tr ng-repeat='village in villages'>
								<td>{{village.name}}</td>
								<td>{{village.x_coord}}|{{village.y_coord}}</td>
								<td>{{village.continent}}</td>
								<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
								<td>{{AttackTypes.toString[village.attack_type]}}</td>
								<td class='editable' contentEditable='true'></td>
							</tr>
						</table>
					</div>
					<div style="width: 40%; float:left; margin-left: 15%;">
						<h2>Targets in Plan</h2>
						<table>
							<tr>
								<th>Coordinates</th>
								<th>Continent</th>
								<th>Nukes</th>
								<th>Nobles</th>
								<th>Supports</th>
								<th>Delete</th>
							</tr>
							<tr ng-repeat='targets in targets_in_plan.targets'>
								<td>{{target.x_coord}}|{{target.y_coord}}</td>
								<td>{{target.continent}}</td>
								<td><input type='number' min='0'></input></td>
								<td><input type='number' min='0'></input></td>
								<td><input type='number' min='0'></input></td>
								<td><button ng-click='this.target.removeFromPlan()'>REMOVE</button></td>
							</tr>
						</table>
					</div>
				</div>

				<button style="position:relative; top:20px;" onClick="submitTargets()">Submit</button>

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