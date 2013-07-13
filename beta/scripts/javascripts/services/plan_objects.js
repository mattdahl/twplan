/**
 * A village object
 * @return {Village} An instance of a Village
 */
Village = (function () {
	function Village(scope, village_id, name, x_coord, y_coord, continent, slowest_unit, attack_type) {
		this.scope = scope;

		this.village_id = village_id;
		this.name = name;
		this.x_coord = x_coord;
		this.y_coord = y_coord;
		this.continent = continent;
		this.slowest_unit = slowest_unit;
		this.attack_type = attack_type;
	}

	Village.prototype = {
		setSlowestUnit: function (slowest_unit) {
			this.slowest_unit = slowest_unit;
			switch (this.slowest_unit) {
				case this.scope.Units.Axe:
				case this.scope.Units.Scout:
				case this.scope.Units.Lc:
				case this.scope.Units.Marcher:
				case this.scope.Units.Ram:
				case this.scope.Units.Cat:
					this.attack_type = this.scope.AttackTypes.Nuke;
					break;
				case this.scope.Units.Noble:
					this.attack_type = this.scope.AttackTypes.Noble;
					break;
				case this.scope.Units.Spear:
				case this.scope.Units.Sword:
				case this.scope.Units.Archer:
				case this.scope.Units.Hc:
				case this.scope.Units.Pally:
					this.attack_type = this.scope.AttackTypes.Support;
					break;
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		setAttackType: function (attack_type) {
			this.attack_type = attack_type;
			if (!this.slowest_unit) {
				switch (this.attack_type) {
					case this.scope.AttackTypes.Nuke:
						this.slowest_unit = this.scope.Units.Axe;
						break;
					case this.scope.AttackTypes.Noble:
						this.slowest_unit = this.scope.Units.Noble;
						break;
					case this.scope.AttackTypes.Support:
						this.slowest_unit = this.scope.Units.Spear;
						break;
				}
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		addToPlan: function () {
			switch (this.attack_type) {
				case this.scope.AttackTypes.Nuke:
					this.scope.villages_in_plan.nukes.push(new Village(
						this.scope,
						this.village_id,
						this.name,
						this.x_coord,
						this.y_coord,
						this.continent,
						this.slowest_unit,
						this.attack_type));
					break;
				case this.scope.AttackTypes.Noble:
					this.scope.villages_in_plan.nobles.push(new Village(
						this.scope,
						this.village_id,
						this.name,
						this.x_coord,
						this.y_coord,
						this.continent,
						this.slowest_unit,
						this.attack_type));
					break;
				case this.scope.AttackTypes.Support:
					this.scope.villages_in_plan.supports.push(new Village(
						this.scope,
						this.village_id,
						this.name,
						this.x_coord,
						this.y_coord,
						this.continent,
						this.slowest_unit,
						this.attack_type));
					break;
			}

			$("#" + this.village_id + '_row').effect("highlight", {color: "#a9a96f"}, 2000);
			$('#' + this.village_id + '_add_button').blur();

			this.slowest_unit = null;
			this.attack_type = null;
		},
		removeFromPlan: function () {
			switch (this.attack_type) {
				case this.scope.AttackTypes.Nuke:
					this.scope.villages_in_plan.nukes.splice(this.scope.villages_in_plan.nukes.indexOf(this), 1);
					break;
				case this.scope.AttackTypes.Noble:
					this.scope.villages_in_plan.nobles.splice(this.scope.villages_in_plan.nobles.indexOf(this), 1);
					break;
				case this.scope.AttackTypes.Support:
					this.scope.villages_in_plan.supports.splice(this.scope.villages_in_plan.supports.indexOf(this), 1);
					break;
			}
		}
	};

	return Village;
})();


/**
 * A target object
 * @return {Target} An instance of a target
 */
Target = (function () {
	function Target(scope, x_coord, y_coord, continent, attack_type) {
		this.scope = scope;

		this.x_coord = x_coord;
		this.y_coord = y_coord;
		this.continent = continent;
		this.attack_type = attack_type;
	}

	Target.prototype = {
		removeFromPlan: function () {
			switch (this.attack_type) {
				case this.scope.AttackTypes.Nuke:
					this.scope.targets_in_plan.nukes.splice(this.scope.targets_in_plan.nukes.indexOf(this), 1);
					break;
				case this.scope.AttackTypes.Noble:
					this.scope.targets_in_plan.nobles.splice(this.scope.targets_in_plan.supports.indexOf(this), 1);
					break;
				case this.scope.AttackTypes.Support:
					this.scope.targets_in_plan.supports.splice(this.scope.targets_in_plan.supports.indexOf(this), 1);
					break;
			}
		}
	};

	return Target;
})();

VillagePasteInInterface = (function () {
	function VillagePasteInInterface(scope) {
		this.scope = scope;

		this.coords = '';

		this.slowest_unit = null;
		this.attack_type = null;
	}

	VillagePasteInInterface.prototype = {
		setSlowestUnit: function (slowest_unit) {
			this.slowest_unit = slowest_unit;
			switch (this.slowest_unit) {
				case this.scope.Units.Axe:
				case this.scope.Units.Scout:
				case this.scope.Units.Lc:
				case this.scope.Units.Marcher:
				case this.scope.Units.Ram:
				case this.scope.Units.Cat:
					this.attack_type = this.scope.AttackTypes.Nuke;
					break;
				case this.scope.Units.Noble:
					this.attack_type = this.scope.AttackTypes.Noble;
					break;
				case this.scope.Units.Spear:
				case this.scope.Units.Sword:
				case this.scope.Units.Archer:
				case this.scope.Units.Hc:
				case this.scope.Units.Pally:
					this.attack_type = this.scope.AttackTypes.Support;
					break;
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		setAttackType: function (attack_type) {
			this.attack_type = attack_type;
			if (!this.slowest_unit) {
				switch (this.attack_type) {
					case this.scope.AttackTypes.Nuke:
						this.slowest_unit = this.scope.Units.Axe;
						break;
					case this.scope.AttackTypes.Noble:
						this.slowest_unit = this.scope.Units.Noble;
						break;
					case this.scope.AttackTypes.Support:
						this.slowest_unit = this.scope.Units.Spear;
						break;
				}
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		addToPlan: function () {
			if (this.coords == '') {
				alert("You haven't entered any coordinates in the box yet.");
				return false;
			}

			var coords = this.coords.match(/[0-9]{3}\|[0-9]{3}/g);

			for (var i = 0; i < this.scope.villages.length; i++) {
				for (var j = 0; j < coords.length; j++) {
					var coord_components = coords[j].split('|');

					if (this.scope.villages[i].x_coord == coord_components[0] && this.scope.villages[i].y_coord == coord_components[1]) {
						switch (this.attack_type) {
							case this.scope.AttackTypes.Nuke:
								this.scope.villages_in_plan.nukes.push(new Village(
									this.scope,
									this.scope.villages[i].village_id,
									this.scope.villages[i].name,
									this.scope.villages[i].x_coord,
									this.scope.villages[i].y_coord,
									this.scope.villages[i].continent,
									this.slowest_unit,
									this.attack_type));
								break;
							case this.scope.AttackTypes.Noble:
								this.scope.villages_in_plan.nobles.push(new Village(
									this.scope,
									this.scope.villages[i].village_id,
									this.scope.villages[i].name,
									this.scope.villages[i].x_coord,
									this.scope.villages[i].y_coord,
									this.scope.villages[i].continent,
									this.slowest_unit,
									this.attack_type));
								break;
							case this.scope.AttackTypes.Support:
								this.scope.villages_in_plan.supports.push(new Village(
									this.scope,
									this.scope.villages[i].village_id,
									this.scope.villages[i].name,
									this.scope.villages[i].x_coord,
									this.scope.villages[i].y_coord,
									this.scope.villages[i].continent,
									this.slowest_unit,
									this.attack_type));
								break;
						}

						break;
					}
				}
			}

			this.coords = '';
			this.slowest_unit = null;
			this.attack_type = null;
		}
	};

	return VillagePasteInInterface;
})();

VillageGroupInterface = (function () {
	function VillageGroupInterface(scope) {
		this.scope = scope;

		this.selected_group = '';

		this.slowest_unit = null;
		this.attack_type = null;
	}

	VillageGroupInterface.prototype = {
		setSlowestUnit: function (slowest_unit) {
			this.slowest_unit = slowest_unit;
			switch (this.slowest_unit) {
				case this.scope.Units.Axe:
				case this.scope.Units.Scout:
				case this.scope.Units.Lc:
				case this.scope.Units.Marcher:
				case this.scope.Units.Ram:
				case this.scope.Units.Cat:
					this.attack_type = this.scope.AttackTypes.Nuke;
					break;
				case this.scope.Units.Noble:
					this.attack_type = this.scope.AttackTypes.Noble;
					break;
				case this.scope.Units.Spear:
				case this.scope.Units.Sword:
				case this.scope.Units.Archer:
				case this.scope.Units.Hc:
				case this.scope.Units.Pally:
					this.attack_type = this.scope.AttackTypes.Support;
					break;
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		setAttackType: function (attack_type) {
			this.attack_type = attack_type;
			if (!this.slowest_unit) {
				switch (this.attack_type) {
					case this.scope.AttackTypes.Nuke:
						this.slowest_unit = this.scope.Units.Axe;
						break;
					case this.scope.AttackTypes.Noble:
						this.slowest_unit = this.scope.Units.Noble;
						break;
					case this.scope.AttackTypes.Support:
						this.slowest_unit = this.scope.Units.Spear;
						break;
				}
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		addToPlan: function () {
			if (this.selected_group == '') {
				alert("Please select the group in the dropdown menu you want to add!");
				return false;
			}

			var coords; // lookup group coords from server

			for (var i = 0; i < this.scope.villages.length; i++) {
				for (var j = 0; j < coords.length; j++) {
					var coord_components = coords[j].split('|');

					if (this.scope.villages[i].x_coord == coord_components[0] && this.scope.villages[i].y_coord == coord_components[1]) {
						switch (this.attack_type) {
							case this.scope.AttackTypes.Nuke:
								this.scope.villages_in_plan.nukes.push(new Village(
									this.scope,
									this.scope.villages[i].village_id,
									this.scope.villages[i].name,
									this.scope.villages[i].x_coord,
									this.scope.villages[i].y_coord,
									this.scope.villages[i].continent,
									this.slowest_unit,
									this.attack_type));
								break;
							case this.scope.AttackTypes.Noble:
								this.scope.villages_in_plan.nobles.push(new Village(
									this.scope,
									this.scope.villages[i].village_id,
									this.scope.villages[i].name,
									this.scope.villages[i].x_coord,
									this.scope.villages[i].y_coord,
									this.scope.villages[i].continent,
									this.slowest_unit,
									this.attack_type));
								break;
							case this.scope.AttackTypes.Support:
								this.scope.villages_in_plan.supports.push(new Village(
									this.scope,
									this.scope.villages[i].village_id,
									this.scope.villages[i].name,
									this.scope.villages[i].x_coord,
									this.scope.villages[i].y_coord,
									this.scope.villages[i].continent,
									this.slowest_unit,
									this.attack_type));
								break;
						}

						break;
					}
				}
			}

			this.coords = '';
			this.slowest_unit = null;
			this.attack_type = null;
		}
	};

	return VillageGroupInterface;
})();

TargetPasteInInterface = (function () {
	function TargetPasteInInterface(scope) {
		this.scope = scope;

		this.coords = '';

		this.nukes_quantity = 0;
		this.nobles_quantity = 0;
		this.supports_quantity = 0;
	}

	TargetPasteInInterface.prototype = {
		addToPlan: function () {
			if (this.coords == '') {
				alert("You haven't entered any coordinates in the box yet.");
				return false;
			}

			var coords = this.coords.match(/[0-9]{3}\|[0-9]{3}/g);

			for (var i = 0; i < coords.length; i++) {
				var coord_components = coords[i].split('|');

				for (var j = 0; j < this.nukes_quantity; j++) {
					debugger;
					this.scope.targets_in_plan.nukes.push(new Target(
						this.scope,
						coord_components[0],
						coord_components[1],
						'K' + coord_components[1].substring(0, 1) + coord_components[0].substring(0, 1),
						this.scope.AttackTypes.Nuke
						));
				}
				for (var j = 0; j < this.nobles_quantity; j++) {
					this.scope.targets_in_plan.nobles.push(new Target(
						this.scope,
						coord_components[0],
						coord_components[1],
						'K' + coord_components[1].substring(0, 1) + coord_components[0].substring(0, 1),
						this.scope.AttackTypes.Noble
						));
				}
				for (var j = 0; j < this.supports_quantity; j++) {
					this.scope.targets_in_plan.supports.push(new Target(
						this.scope,
						coord_components[0],
						coord_components[1],
						'K' + coord_components[1].substring(0, 1) + coord_components[0].substring(0, 1),
						this.scope.AttackTypes.Support
						));
				}
			}

			this.coords = '';
			this.nukes_quantity = 0;
			this.nobles_quantity = 0;
			this.supports_quantity = 0;
		}
	};

	return TargetPasteInInterface;
})();