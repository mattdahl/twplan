<div ng-controller="GroupsController">
	<h1>Groups</h1>

	<input type="button" ng-click="create_group()" value="Create Group" />

	<div id="group_display" ng-visible="current_group">
		<table>
			<tr>
				<th>Group Name</th>
				<th>Number of Villages</th>
				<th>Date Created</th>
				<th>Modify</th>
				<th>Delete</th>
			</tr>
			<tr ng-repeat="group in groups">
				<td>{{group.name}}</td>
				<td>{{group.villages.length}}</td>
				<td>{{group.date_created}}</td>
				<td><input type="button" ng-click="load_group(group)" value="Modify Group" /></td>
				<td><input type="button" ng-click="delete_group(group)" value="Delete Group" /></td>
			</tr>
		</table>

		<h2 ng-bind="current_group.name"></h2>

		<table>
			<tr>
				<th>Village Name</th>
				<th>Coordinates</th>
				<th>Continent</th>
				<th>Slowest Unit</th>
				<th>Type of Attack</th>
				<th>Remove Village from Plan</th>
			</tr>
			<tr ng-repeat="village in group.villages">
				<td>{{village.name}}</td>
				<td>{{village.x_coord}}|{{village.y_coord}}</td>
				<td>{{village.continent}}</td>
				<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
				<td>{{AttackTypes.toString[village.attack_type]}}</td>
				<td><input type="button" ng-click="current_group.remove_village(this)" value="Remove Village" /></td>
			</tr>
		</table>
	</div>

	<div id="new_group_display">
	</div>
</div>