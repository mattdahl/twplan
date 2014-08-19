<h1>Planning - Step 1</h1>
<p id="instructions">
	Add your villages to your plan. Choose the slowest traveling time for each villages' attack, and how each attack should be classified (nuke, noble, or support). Villages can be added more than once!
</p>
<br />

<h2>Add Villages by Copy/Paste</h2>
<div>
	<p>Paste in a chunk of text containing coordinates, i.e. copied from a TW overview screen. Coordinates will be parsed out.</p>
	<textarea id="villages_paste_in" style="float:left" ng-model='village_paste_in_interface.coords'></textarea>
	<table style="float:left">
		<tr>
			<th colspan="12">Slowest Unit</th>
			<th>Type of Attack</th>
		</tr>
		<tr>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Spear)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Sword)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Axe)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Archer)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Scout)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Lc)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Hc)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Marcher)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Ram)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Cat)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Pally)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
			<td ng-class='{slowestUnit: (village_paste_in_interface.slowest_unit == Units.Noble)}' ng-click='village_paste_in_interface.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
			<td class='attacktype'>
				<form>
					<label for='paste_in_nuke'>Nuke</label><input type='radio' name='attacktype' id='paste_in_nuke' value='{{AttackTypes.Nuke}}' ng-click='village_paste_in_interface.setAttackType(AttackTypes.Nuke)' ng-model='village_paste_in_interface.attack_type' />
					<label for='paste_in_noble'>Noble</label><input type='radio' name='attacktype' id='paste_in_noble' value='{{AttackTypes.Noble}}' ng-click='village_paste_in_interface.setAttackType(AttackTypes.Noble)' ng-model='village_paste_in_interface.attack_type' />
					<label for='paste_in_support'>Support</label><input type='radio' name='attacktype' id='paste_in_support' value='{{AttackTypes.Support}}' ng-click='village_paste_in_interface.setAttackType(AttackTypes.Support)' ng-model='village_paste_in_interface.attack_type' />
				</form>
			</td>
		</tr>
	</table>
	<button ng-click="village_paste_in_interface.addToPlan()" style="margin-left:2%;">Add Villages to Plan</button>
</div>
<h2 style="clear:left"><br />Add Villages from Group</h2>
<p ng-hide="groups.length > 1">You have no groups configured. Go to the <a href="groups">groups</a> page to create village groups.</p>
<div id="group_dropdown" ng-show="groups.length > 1">
	<select id="choosegroup" style="float:left;width:315px;margin-right:20px;" ng-model="village_group_interface.selected_group" ng-options="g.name for g in groups"></select>

	<table style="float:left">
		<tr>
			<th colspan="12">Slowest Unit</th>
			<th>Type of Attack</th>
		</tr>
		<tr>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Spear)}' ng-click='village_group_interface.setSlowestUnit(Units.Spear)'><img src='http://static-twplan.appspot.com/images/units/spear.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Sword)}' ng-click='village_group_interface.setSlowestUnit(Units.Sword)'><img src='http://static-twplan.appspot.com/images/units/sword.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Axe)}' ng-click='village_group_interface.setSlowestUnit(Units.Axe)'><img src='http://static-twplan.appspot.com/images/units/axe.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Archer)}' ng-click='village_group_interface.setSlowestUnit(Units.Archer)'><img src='http://static-twplan.appspot.com/images/units/archer.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Scout)}' ng-click='village_group_interface.setSlowestUnit(Units.Scout)'><img src='http://static-twplan.appspot.com/images/units/scout.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Lc)}' ng-click='village_group_interface.setSlowestUnit(Units.Lc)'><img src='http://static-twplan.appspot.com/images/units/lc.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Hc)}' ng-click='village_group_interface.setSlowestUnit(Units.Hc)'><img src='http://static-twplan.appspot.com/images/units/hc.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Marcher)}' ng-click='village_group_interface.setSlowestUnit(Units.Marcher)'><img src='http://static-twplan.appspot.com/images/units/marcher.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Ram)}' ng-click='village_group_interface.setSlowestUnit(Units.Ram)'><img src='http://static-twplan.appspot.com/images/units/ram.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Cat)}' ng-click='village_group_interface.setSlowestUnit(Units.Cat)'><img src='http://static-twplan.appspot.com/images/units/cat.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Pally)}' ng-click='village_group_interface.setSlowestUnit(Units.Pally)'><img src='http://static-twplan.appspot.com/images/units/pally.png' /></td>
			<td ng-class='{slowestUnit: (village_group_interface.slowest_unit == Units.Noble)}' ng-click='village_group_interface.setSlowestUnit(Units.Noble)'><img src='http://static-twplan.appspot.com/images/units/noble.png' /></td>
			<td class='attacktype'>
				<form>
					<label for='group_nuke'>Nuke</label><input type='radio' name='attacktype' id='group_nuke' value='{{AttackTypes.Nuke}}' ng-click='village_group_interface.setAttackType(AttackTypes.Nuke)' ng-model='village_group_interface.attack_type' />
					<label for='group_noble'>Noble</label><input type='radio' name='attacktype' id='group_noble' value='{{AttackTypes.Noble}}' ng-click='village_group_interface.setAttackType(AttackTypes.Noble)' ng-model='village_group_interface.attack_type' />
					<label for='group_support'>Support</label><input type='radio' name='attacktype' id='group_support' value='{{AttackTypes.Support}}' ng-click='village_group_interface.setAttackType(AttackTypes.Support)' ng-model='village_group_interface.attack_type' />
				</form>
			</td>
		</tr>
	</table>
	<button ng-click="village_group_interface.addToPlan();" style="float:left;margin-left:2%;">Add Group to Plan</button>
</div>

<h2 style="clear:left; margin-bottom: 0;"><br />Add Villages from List</h2>

<input type="text" id="search_box" placeholder="Search villages..." ng-model="search_term" ng-change="search_villages()" />

<div style="float: right;">
	<ul id="page_marker" ng-repeat="pages in paginated_villages" ng-hide="paginated_villages.length < 2">
		<li ng-class="{selected_page_marker: ($index == current_page)}"><a href="javascript:void(0);" ng-click="switch_page($index)">[{{$index + 1}}]</a></li>
	</ul>
</div>

<table id="villages_list">
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
	<tr ng-repeat='village in page_villages' id='{{village.village_id}}_row'>
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
	<tr ng-repeat='village in villages_in_plan.nukes'>
		<td>{{village.name}}</td>
		<td>{{village.x_coord}}|{{village.y_coord}}</td>
		<td>{{village.continent}}</td>
		<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
		<td>{{AttackTypes.toString[village.attack_type]}}</td>
		<td><button ng-click='this.village.removeFromPlan()'>Remove Village</button></td>
	</tr>
	<tr ng-repeat='village in villages_in_plan.nobles'>
		<td>{{village.name}}</td>
		<td>{{village.x_coord}}|{{village.y_coord}}</td>
		<td>{{village.continent}}</td>
		<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
		<td>{{AttackTypes.toString[village.attack_type]}}</td>
		<td><button ng-click='this.village.removeFromPlan()'>Remove Village</button></td>
	</tr>
	<tr ng-repeat='village in villages_in_plan.supports'>
		<td>{{village.name}}</td>
		<td>{{village.x_coord}}|{{village.y_coord}}</td>
		<td>{{village.continent}}</td>
		<td><img src='http://static-twplan.appspot.com/images/units/{{village.slowest_unit.url}}' /></td>
		<td>{{AttackTypes.toString[village.attack_type]}}</td>
		<td><button ng-click='this.village.removeFromPlan()'>Remove Village</button></td>
	</tr>
</table>
<span style="font-family:Arial;font-size:12px">
	{{villages_in_plan.nukes.length}} nukes,
	{{villages_in_plan.nobles.length}} nobles, and
	{{villages_in_plan.supports.length}} supports added.
</span>
<br /><br />
<input type='button' value='Submit Villages' ng-click='submitStepOne()' />