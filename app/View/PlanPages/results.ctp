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
		<th>TW Link <span class="tooltip" title="Click the link and then run the attack quickbar script from the scripts page to automatically launch the attack." />(?)</span></th>
	</tr>
	<tr ng-repeat='command in plan.commands'>
		<td>{{command.village.name}} ({{command.village.x_coord}}|{{command.village.y_coord}})</td>
		<td>{{command.target.x_coord}}|{{command.target.y_coord}}</td>
		<td><img src='http://static-twplan.appspot.com/images/units/{{command.village.slowest_unit.url}}' /></td>
		<td>{{AttackTypes.toString[command.village.attack_type]}}</td>
		<td>{{format_seconds(command.traveling_time.getTime() / 1000)}}</td>
		<td>{{command.launch_datetime.toString().slice(0, 24)}}</td>
		<td>{{format_local_launchtime(command.launch_datetime)}}</td>
		<td>{{format_seconds(command.time_remaining)}}</td>
		<td><a href='{{command.launch_url}}'>Launch</a></td>
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
	<label id="plannamelabel" for="planname">Plan Name:</label>
	<input type="text" id="planname" ng-model="saved_plan_name" />
	<button id="save" ng-click="save_plan()">Save</button>
	<img id="loadingcircle" src="http://static-twplan.appspot.com/images/loadingcircle.gif" />
</div>

<div id="recalculate_plan">
	<b>Recalculate Plan With Different Landing Information</b> <br /> <br />
		Landing Date: <input type="date" ng-model="new_landing_date" placeholder="mm/dd/yyyy" />
		Landing Time: <input type="text" ng-model="new_landing_time" placeholder="hh:mm:ss" /> <br />
		Launch Time Optimization <input type="checkbox" ng-model="optimization_checked" /> <br />
		<div ng-show="optimization_checked">
			Early Bound:
			<select ng-model="early_bound">
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
			<select ng-model="late_bound">
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
		</div>
	<input type="button" value="Recalculate Plan" ng-click="recalculate_plan()" />
</div>