<div ng-controller="GroupsController">
	<div id="instructions" ng-show="should_show_instructions">
		<h1>Groups</h1>
		<p>Create groups of your villages for easy use in planning. For instance, consider making a group for all your offensive villages to load with one click on the step one planning page.</p>
		<p>You can manually configure your groups here, or automatically import your existing Tribalwars groups using the quickbar script found on the <?php echo $this->Html->link('scripts', '/user_scripts'); ?> page.</p>

		<b>New Group:</b> <input type="text" ng-model="new_group_name" /> <input type="button" ng-click="create_group()" value="Create" />
		<br />
		<div ng-show="groups.length > 1">
			<b>Edit Group:</b> <select ng-model="current_group" ng-options="g.name for g in groups" ng-change="load_group()"></select>
		</div>
	</div>

	<div id="current_group_display" ng-hide="current_group == groups[0]">
		<h1>Groups</h1>
		<p><b>Group Name:</b> {{current_group.name}}</p>
		<p><b>Date Created:</b> {{current_group.date_created}}</p>
		<p><b>Last Updated:</b> {{current_group.date_last_updated}}</p>
		<p><b>Delete Group:</b> <input type="button" value="Delete" ng-click="delete_group(current_group)" /></p>
		<p><b>Save Group:</b> <input type="button" value="Save" ng-click="save_group(current_group)" ></p>

		<table>
			<tr>
				<th>Village Name</th>
				<th>Coordinates</th>
				<th>Continent</th>
				<th>Slowest Unit</th>
				<th>Type of Attack</th>
				<th>Remove Village from Plan</th>
			</tr>
			<tr ng-repeat="village in current_group.villages">
				<td>{{village.name}}</td>
				<td>{{village.x_coord}}|{{village.y_coord}}</td>
				<td>{{village.continent}}</td>
				<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
				<td>{{AttackTypes.toString[village.attack_type]}}</td>
				<td><input type="button" ng-click="current_group.remove_village(this)" value="Remove Village" /></td>
			</tr>
		</table>
	</div>

	<div id="new_group_display" ng-show="new_group">
		<h1>New Group</h1>
		<b>Group Name:</b> <input type="text" ng-model="new_group.name" /> <br />
		<b>Save Group:</b> <input type="button" value="Save" ng-click="save_group(new_group)" > <br />
		<div id="available_villages">
			<h2>Your Villages</h2>
			<table>
				<tr>
					<th>Village Name</th>
					<th>Coordinates</th>
					<th>Continent</th>
					<th>Add to Group</th>
				</tr>
				<tr ng-repeat="village in available_villages">
					<td>{{village.name}}</td>
					<td>{{village.coordinates}}</td>
					<td>{{village.continent}}</td>
					<td><input type="button" value="Add" ng-click="village.add_to_group()" /></td>
				</tr>
			</table>
		</div>
		<div id="villages_in_group">
			<h2>Villages in Group</h2>
			<table>
				<tr>
					<th>Village Name</th>
					<th>Coordinates</th>
					<th>Continent</th>
					<th>Remove from Group</th>
				</tr>
				<tr ng-repeat="village in new_group.villages">
					<td>{{village.name}}</td>
					<td>{{village.coordinates}}</td>
					<td>{{village.continent}}</td>
					<td><input type="button" value="Remove" ng-click="village.remove_from_group()" /></td>
				</tr>
			</table>
		</div>
	</div>
</div>