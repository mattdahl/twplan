<div ng-controller="PlansController">
	<h1>Saved Plan</h1>

	<select ng-model="current_plan" ng-options="p.name for p in plans"></select>

	<table>
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
		<tr ng-repeat="command in current_plan.commands">
			<td>{{command.village}}</td>
			<td>{{command.target}}</td>
			<td><img src='http://static-twplan.appspot.com/images/units/{{command.village.slowest_unit.url}}' /></td>
			<td>{{AttackTypes.toString[command.village.attack_type]}}</td>
			<td>{{format_seconds(command.traveling_time.getTime() / 1000)}}</td>
			<td>{{command.launch_datetime.toString().slice(0, 24)}}</td>
			<td>Local Launch Time</td>
			<td>{{format_seconds(command.time_remaining)}}</td>
			<td><a href='{{command.launch_url}}'>Launch</a></td>
		</tr>
	</table>
</div>