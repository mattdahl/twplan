<div ng-controller="PlansController">
	<h1>Saved Plans</h1>
	<p>Plans that you have created and saved can be viewed here.</p>
	<p ng-hide="plans.length > 1">You haven't saved any plans yet! Go to the <?php echo $this->Html->link('plan', '/plan'); ?> page to create a plan, and then save it.</p>

	<div ng-show="plans.length > 1">
		<b>Plan:</b> <select ng-model="current_plan" ng-options="p.name for p in plans" ng-change="countdown()"></select>
		<div ng-show="current_plan != plans[0]">
			<table id="current_plan_options">
				<tr>
					<th colspan=2>
						Options
					</th>
				</tr>
				<tr>
					<td>
						Publish <span class="tooltip" title="Published plans are only available to those who have the link." />(?)</span>
					</td>
					<td>
						<select ng-model="current_plan.is_published" ng-change="publish_plan()" ng-options="o for o in ['Yes', 'No']"></select>
						<span ng-show="current_plan.is_published">
							(<a href="http://twplan.com/public/plans/{{current_plan.published_hash}}">http://twplan.com/public/plans/{{current_plan.published_hash}}</a>)
						</span>
					</td>
				</tr>
				<tr>
					<td>
						Delete
					</td>
					<td>
						<input type="button" value="Delete" ng-click="delete_plan()" />
					</td>
				</tr>
			</table>

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
					<th>TW Link <span class="tooltip" title="Click the link and then run the attack quickbar script from the scripts page to automatically launch the attack." />(?)</span></th>
					<th>Delete Command</th>
				</tr>
				<tr ng-repeat="command in current_plan.commands">
					<td>{{command.village}}</td>
					<td>{{command.target}}</td>
					<td><img src='http://static-twplan.appspot.com/images/units/{{slowest_unit_url_lookup(command.slowest_unit)}}' /></td>
					<td>{{AttackTypes.toString[command.attack_type]}}</td>
					<td>{{command.travel_time}}</td>
					<td>{{command.launch_datetime.toString().slice(0, 24)}}</td>
					<td>{{format_local_launchtime(command.launch_datetime)}}</td>
					<td>{{format_seconds(command.time_remaining)}}</td>
					<td><a href="{{command.launch_url}}">Launch</a></td>
					<td><input type="button" value="Delete" ng-click="current_plan.remove_command(command)"></td>
				</tr>
			</table>
		</div>
	</div>
</div>