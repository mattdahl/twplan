<div ng-controller="PublicPlansController">
	<h1>Public Plan</h1>
	<p><b>Plan:</b> {{public_plan.name}}</p>
	<p><b>World:</b> {{public_plan.world}}</p>
	<p><b>Owner:</b> {{public_plan.owner}}</p>

	<table id="current_plan_table">
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
		<tr ng-repeat="command in public_plan.commands">
			<td>{{command.village}}</td>
			<td>{{command.target}}</td>
			<td><img src='http://static-twplan.appspot.com/images/units/{{slowest_unit_url_lookup(command.slowest_unit)}}' /></td>
			<td>{{AttackTypes.toString[command.attack_type]}}</td>
			<td>{{command.travel_time}}</td>
			<td>{{command.launch_datetime.toString().slice(0, 24)}}</td>
			<td>Local Launch Time</td>
			<td>{{format_seconds(command.time_remaining)}}</td>
			<td><a href="{{command.launch_url}}">Launch</a></td>
		</tr>
	</table>
</div>