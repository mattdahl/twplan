<h1>Planning - Step 2</h1>
<p id="instructions">Next, enter the coordinates of your targets. Choose how many of each command (noble, nuke, and support) you want to send to each village - the commands available are determined by your village selections in Step 1.</p>
<br />

<h2>Add Targets</h2>
<p>Paste in a list of target coordinates.</p>
<textarea id="targets_paste_in" ng-model='target_paste_in_interface.coords'></textarea>
<table style="float:left; margin-left: 40px; width:auto; clear:right;">
	<tr>
		<th colspan="3">Quantity Commands to Send to These Villages</th>
	</tr>
	<tr>
		<td>Nukes <input type='number' min='0' id='bulktargetnobles' ng-model='target_paste_in_interface.nukes_quantity' /></td>
		<td>Nobles <input type='number' min='0' id='bulktargetnukes' ng-model='target_paste_in_interface.nobles_quantity' /></td>
		<td>Supports <input type='number' min='0' id='bulktargetsupports' ng-model='target_paste_in_interface.supports_quantity' /></td>
	</tr>
</table>
<input type="button" id="step_two_add_button" value='Add Targets' ng-click="target_paste_in_interface.addToPlan()" />
<span style="font-family:Arial;font-size:12px;float:left;clear:both;top:10px;position:relative;">
	<span ng-class='{red: (villages_in_plan.nukes.length < targets_in_plan.nukes.length), green: (villages_in_plan.nukes.length == targets_in_plan.nukes.length)}'>{{villages_in_plan.nukes.length - targets_in_plan.nukes.length}}</span> nukes,
	<span ng-class='{red: (villages_in_plan.nobles.length < targets_in_plan.nobles.length), green: (villages_in_plan.nobles.length == targets_in_plan.nobles.length)}'>{{villages_in_plan.nobles.length - targets_in_plan.nobles.length}}</span> nobles, and
	<span ng-class='{red: (villages_in_plan.supports.length < targets_in_plan.supports.length), green: (villages_in_plan.supports.length == targets_in_plan.supports.length)}'>{{villages_in_plan.supports.length - targets_in_plan.supports.length}}</span> supports available for assignment (from Step 1).
</span>

<div id="target_assginment">
	<div style="width: 55%; float:left;">
		<h2>Villages in Plan</h2>
		<table>
			<tr>
				<th>Village Name</th>
				<th>Coordinates</th>
				<th>Continent</th>
				<th>Slowest Unit</th>
				<th>Type of Attack</th>
				<th>Target <img class="tooltip" src="images/tooltip.png" title="If you want, you can assign specific targets to your villages. Anything left blank will be auto-assigned by TWplan!" /></th>
			</tr>
			<tr ng-repeat='village in villages_in_plan.nukes'>
				<td>{{village.name}}</td>
				<td>{{village.x_coord}}|{{village.y_coord}}</td>
				<td>{{village.continent}}</td>
				<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
				<td>{{AttackTypes.toString[village.attack_type]}}</td>
				<td><input class='nuke_target_autocomplete' /></td>
			</tr>
			<tr ng-repeat='village in villages_in_plan.nobles'>
				<td>{{village.name}}</td>
				<td>{{village.x_coord}}|{{village.y_coord}}</td>
				<td>{{village.continent}}</td>
				<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
				<td>{{AttackTypes.toString[village.attack_type]}}</td>
				<td><input class='noble_target_autocomplete' /></td>
			</tr>
			<tr ng-repeat='village in villages_in_plan.supports'>
				<td>{{village.name}}</td>
				<td>{{village.x_coord}}|{{village.y_coord}}</td>
				<td>{{village.continent}}</td>
				<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
				<td>{{AttackTypes.toString[village.attack_type]}}</td>
				<td><input class='support_target_autocomplete' /></td>
			</tr>
		</table>
	</div>
	<div style="width: 40%; float:left; margin-left: 5%;">
		<h2>Targets in Plan</h2>
		<table>
			<tr>
				<th>Coordinates</th>
				<th>Continent</th>
				<th>Type of Attack</th>
				<th>Delete</th>
			</tr>
			<tr ng-repeat='target in targets_in_plan.nukes'>
				<td>{{target.x_coord}}|{{target.y_coord}}</td>
				<td>{{target.continent}}</td>
				<td>{{AttackTypes.toString[target.attack_type]}}</td>
				<td><button ng-click='this.target.removeFromPlan()'>REMOVE</button></td>
			</tr>
			<tr ng-repeat='target in targets_in_plan.nobles'>
				<td>{{target.x_coord}}|{{target.y_coord}}</td>
				<td>{{target.continent}}</td>
				<td>{{AttackTypes.toString[target.attack_type]}}</td>
				<td><button ng-click='this.target.removeFromPlan()'>REMOVE</button></td>
			</tr>
			<tr ng-repeat='target in targets_in_plan.supports'>
				<td>{{target.x_coord}}|{{target.y_coord}}</td>
				<td>{{target.continent}}</td>
				<td>{{AttackTypes.toString[target.attack_type]}}</td>
				<td><button ng-click='this.target.removeFromPlan()'>REMOVE</button></td>
			</tr>
		</table>
	</div>
</div>

<input type='button' id='step_two_submit_button' value='Submit Targets' ng-click='submitStepTwo()' />