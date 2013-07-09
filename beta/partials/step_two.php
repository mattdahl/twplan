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