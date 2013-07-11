<h1>Planning - Step {{current_step}}</h1>
<p id="instructions">{{instructions}}</p>
<br />

<h2>Add Villages by Paste-In <a href=" javascript:void(0)" class="collapsebutton" onClick="handleCollapse(this, 'mass');">[collapse]</a></h2>
<div>
	<p>Paste in a list of coordinates, copied from a TW overview screen or otherwise; coordinates will be parsed out.</p>
	<textarea id="villages_paste_in" style="float:left" ng-model='villages_paste_in_coords'></textarea>
	<table style="float:left">
		<tr>
			<th colspan="12">Slowest Unit</th>
			<th>Type of Attack</th>
		</tr>
		<tr>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Spear)}' ng-click='paste_in_row.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Sword)}' ng-click='paste_in_row.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Axe)}' ng-click='paste_in_row.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Archer)}' ng-click='paste_in_row.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Scout)}' ng-click='paste_in_row.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Lc)}' ng-click='paste_in_row.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Hc)}' ng-click='paste_in_row.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Marcher)}' ng-click='paste_in_row.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Ram)}' ng-click='paste_in_row.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Cat)}' ng-click='paste_in_row.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Pally)}' ng-click='paste_in_row.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
			<td ng-class='{slowestUnit: (paste_in_row.slowest_unit == Units.Noble)}' ng-click='paste_in_row.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
			<td class='attacktype'>
				<form>
					<label for='paste_in_nuke'>Nuke</label><input type='radio' name='attacktype' id='paste_in_nuke' value='{{AttackTypes.Nuke}}' ng-click='paste_in_row.setAttackType(AttackTypes.Nuke)' ng-model='paste_in_row.attack_type' />
					<label for='paste_in_noble'>Noble</label><input type='radio' name='attacktype' id='paste_in_noble' value='{{AttackTypes.Noble}}' ng-click='paste_in_row.setAttackType(AttackTypes.Noble)' ng-model='paste_in_row.attack_type' />
					<label for='paste_in_support'>Support</label><input type='radio' name='attacktype' id='paste_in_support' value='{{AttackTypes.Support}}' ng-click='paste_in_row.setAttackType(AttackTypes.Support)' ng-model='paste_in_row.attack_type' />
				</form>
			</td>
		</tr>
	</table>
	<button ng-click="paste_in_row.addToPlan()" style="margin-left:2%;">Add Villages to Plan</button>
</div>
<h2 style="clear:left"><br />Add Villages from Group</h2>
<p ng-hide='(group_names.length > 0)'>You have no groups configured. Go to the <a href=\"/groups.php\">groups</a> tab to create village groups.</p>
<div id='group_dropdown' ng-show='(group_names.length > 0)'>
	<select id='choosegroup' style='float:left;width:315px;'>
		<option>Choose a group to use in plan...</option>
		<option ng-repeat='group in groups'>{{this.group.name}}</option>
	</select>

	<table style="float:left">
		<tr>
			<th colspan="12">Slowest Unit</th>
			<th>Type of Attack</th>
		</tr>
		<tr>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Spear)}' ng-click='group_row.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Sword)}' ng-click='group_row.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Axe)}' ng-click='group_row.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Archer)}' ng-click='group_row.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Scout)}' ng-click='group_row.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Lc)}' ng-click='group_row.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Hc)}' ng-click='group_row.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Marcher)}' ng-click='group_row.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Ram)}' ng-click='group_row.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Cat)}' ng-click='group_row.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Pally)}' ng-click='group_row.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
			<td ng-class='{slowestUnit: (group_row.slowest_unit == Units.Noble)}' ng-click='group_row.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
			<td class='attacktype'>
				<form>
					<label for='group_nuke'>Nuke</label><input type='radio' name='attacktype' id='group_nuke' value='{{AttackTypes.Nuke}}' ng-click='group_row.setAttackType(AttackTypes.Nuke)' ng-model='group_row.attack_type' />
					<label for='group_noble'>Noble</label><input type='radio' name='attacktype' id='group_noble' value='{{AttackTypes.Noble}}' ng-click='group_row.setAttackType(AttackTypes.Noble)' ng-model='group_row.attack_type' />
					<label for='group_support'>Support</label><input type='radio' name='attacktype' id='group_support' value='{{AttackTypes.Support}}' ng-click='group_row.setAttackType(AttackTypes.Support)' ng-model='group_row.attack_type' />
				</form>
			</td>
		</tr>
	</table>
	<button onClick="group_row.addToPlan();" style="float:left;margin-left:2%;">Add Group to Plan</button>
</div>

<h2 style="clear:left"><br />Add Villages from List <a href=" javascript:void(0)" class="collapsebutton" onClick="handleCollapse(this, 'single');">[collapse]</a></h2>

<table>
	<tr>
		<th>Village Name</th>
		<th>Coordinates</th>
		<th>Continent</th>
		<th colspan="12">Slowest Unit</th>
		<th>Type of Attack</th>
		<th>Add Village to Plan</th>
	</tr>
	<tr ng-hide='(villages.length > 0)'>
		<td colspan="16"><img src="http://static-twplan.appspot.com/images/loading.gif" /></td>
	</tr>
	<tr ng-repeat='village in villages' id='{{village.village_id}}_row'>
		<td style='display:none'><input type='checkbox' id='{{village.village_id}}' name='selectedVillages[]' /></td>
		<td class='villagename'>{{village.name}}</td>
		<td class='coordsearch' id='{{village.village_id}}c'>{{village.x_coord}}|{{village.y_coord}}</td>
		<td>{{village.continent}}</td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Spear)}' ng-click='this.village.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Sword)}' ng-click='this.village.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Axe)}' ng-click='this.village.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Archer)}' ng-click='this.village.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Scout)}' ng-click='this.village.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Lc)}' ng-click='this.village.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Hc)}' ng-click='this.village.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Marcher)}' ng-click='this.village.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Ram)}' ng-click='this.village.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Cat)}' ng-click='this.village.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Pally)}' ng-click='this.village.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
		<td ng-class='{slowestUnit: (this.village.slowest_unit == Units.Noble)}' ng-click='this.village.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
		<td class='attacktype'>
			<form>
				<label for='{{$index}}_nuke'>Nuke</label><input type='radio' name='attacktype' id='{{$index}}_nuke' value='{{AttackTypes.Nuke}}' ng-click='this.village.setAttackType(AttackTypes.Nuke)' ng-model='this.village.attack_type' />
				<label for='{{$index}}_noble'>Noble</label><input type='radio' name='attacktype' id='{{$index}}_noble' value='{{AttackTypes.Noble}}' ng-click='this.village.setAttackType(AttackTypes.Noble)' ng-model='this.village.attack_type' />
				<label for='{{$index}}_support'>Support</label><input type='radio' name='attacktype' id='{{$index}}_support' value='{{AttackTypes.Support}}' ng-click='this.village.setAttackType(AttackTypes.Support)' ng-model='this.village.attack_type' />
			</form>
		</td>
		<td><button id='{{village.village_id}}_add_button' ng-click='this.village.addToPlan()' ng-disabled='(!this.village.slowest_unit && !this.village.attack_type)'>Add Village</button></td>
	</tr>
</table>

<br />
<h2>Villages in Plan</h2>
<table>
	<tr>
		<th>Village Name</th>
		<th>Coordinates</th>
		<th>Continent</th>
		<th>Slowest Unit</th>
		<th>Type of Attack</th>
		<th>Remove Village from Plan</th>
	</tr>
	<tr ng-repeat='village in villages_in_plan.villages'>
		<td>{{village.name}}</td>
		<td>{{village.x_coord}}|{{village.y_coord}}</td>
		<td>{{village.continent}}</td>
		<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
		<td>{{AttackTypes.toString[village.attack_type]}}</td>
		<td><button ng-click='this.village.removeFromPlan()'>Remove Village</button></td>
	</tr>
</table>
<span style="font-family:Arial;font-size:12px">
	{{villages_in_plan.nukes}} nukes,
	{{villages_in_plan.nobles}} nobles, and
	{{villages_in_plan.supports}} supports added.
</span>
<br /><br />
<input type='button' value='Submit Villages' ng-click='submitStepOne()' />