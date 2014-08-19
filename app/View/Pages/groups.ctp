<div ng-controller="GroupsController">
	<div id="instructions" ng-show="should_show_instructions">
		<h1>Groups</h1>
		<p>Create groups of your villages for easy use in planning. For instance, consider making a group for all your offensive villages to load with one click on the step one planning page.</p>
		<p>You can manually configure your groups here, or you can automatically import your existing Tribalwars groups using the quickbar script found on the <?php echo $this->Html->link('scripts', '/user_scripts'); ?> page.</p>

		<b>New Group:</b> <input type="text" ng-model="new_group_name" /> <input type="button" ng-click="create_group()" value="Create" />
		<br />
		<div ng-show="groups.length > 1">
			<b>Edit Group:</b> <select ng-model="current_group" ng-options="g.name for g in groups" ng-change="load_group()"></select>
		</div>
	</div>

	<div id="current_group_display" ng-hide="current_group == groups[0]">
		<h1>Groups</h1>
		<table id="current_group_details">
			<th colspan=2>
				Group: <input type="text" ng-model="current_group.name" />
			</th>
			<tr>
				<td><b>Date Created</b></td>
				<td>{{current_group.date_created}}</td>
			</tr>
			<tr>
				<td><b>Last Updated</b></td>
				<td>{{current_group.date_last_updated}}</td>
			</tr>
			<tr>
				<td><b>Delete Group</b></td>
				<td><input type="button" value="Delete" ng-click="delete_group(current_group)" /></td>
			</tr>
			<tr>
				<td><b>Save Group</b></td>
				<td><input type="button" value="Save" ng-click="update_group(current_group)" ></td>
			</tr>
		</table>

		<table>
			<tr>
				<th>Village Name</th>
				<th>Coordinates</th>
				<th>Continent</th>
				<th>Remove Village from Plan</th>
			</tr>
			<tr ng-repeat="village in current_group.villages">
				<td>{{village.name}}</td>
				<td>{{village.coordinates}}</td>
				<td>{{village.continent}}</td>
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
			<input type="text" id="group_search_box" placeholder="Search villages..." ng-model="search_term" ng-change="search_villages()" />
			<div>
				<ul id="group_page_marker" ng-repeat="pages in paginated_available_villages" ng-hide="paginated_available_villages.length < 2">
					<li ng-class="{selected_page_marker: ($index == current_page)}"><a href="javascript:void(0);" ng-click="switch_page($index)">[{{$index + 1}}]</a></li>
				</ul>
			</div>
			<table>
				<tr>
					<th>Village Name</th>
					<th>Coordinates</th>
					<th>Continent</th>
					<th>Add to Group</th>
				</tr>
				<tr ng-repeat="village in page_available_villages">
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