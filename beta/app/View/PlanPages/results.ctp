<h1>Results</h1>
<p id="instructions">Below are the results of your attack plan. You can export the information to copy into your TW notebook, and/or save the data for later access.</p>
<br />

<h2 id="attackplantitle">{{plan.name}}</h2>
<table id="resulttable" class="tablesorter">
	<tr>
		<th>Village</th>
		<th>Target</th>
		<th>Slowest Unit</th>
		<th>Attack Type</th>
		<th>Traveling Time</th>
		<th>ST Launch Time</th>
		<th>Local Launch Time</th>
		<th>Time Remaining</th>
		<th>TW Link</th>
	</tr>
	<tr ng-repeat='command in plan.commands'>
		<td>{{command.village.name}} ({{command.village.x_coord}}|{{command.village.y_coord}})</td>
		<td>{{command.target.x_coord}}|{{command.target.y_coord}}</td>
		<td><img src='http://static-twplan.appspot.com/images/units/{{command.village.slowest_unit.url}}' /></td>
		<td>{{AttackTypes.toString[command.village.attack_type]}}</td>
		<td>{{format_seconds(command.traveling_time.getTime() / 1000)}}</td>
		<td>{{command.launch_datetime.toString().slice(0, 24)}}</td>
		<td>Local Launch Time</td>
		<td>{{format_seconds(command.time_remaining)}}</td>
		<td><a href='{{command.url}}'>Launch</a></td>
	</tr>
</table>

<div style="height: 200px; margin-right: 2%; position: relative; float: left">
	<p class="resultsubtitle">Export as Table</p>
	<textarea id="export1" ng-model='table_export'></textarea>
</div>
<div style="height: 200px; margin-right: 2%; position: relative; float: left;">
	<p class="resultsubtitle">Export as Text</p>
	<textarea id="export2" ng-model='text_export'></textarea>
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