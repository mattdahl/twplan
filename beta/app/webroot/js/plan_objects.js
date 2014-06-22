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
		this.manual_target = null;
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
			//this.scope.$apply(function (argument) {
			//});
			var self = this;
			setTimeout(function () {
				self.scope.$apply(function () {
					$('#' + self.village_id + '_add_button').trigger('focus');
				});
			}, 50);
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

			// Workaround to focus the appropriate add button since angular quashes the trigger() for some reason
			var self = this;
			setTimeout(function () {
				self.scope.$apply(function () {
					$('#' + self.village_id + '_add_button').trigger('focus');
				});
			}, 50);
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
	function Target(scope, x_coord, y_coord, continent, attack_type, _hash_id) {
		this.scope = scope;

		this.x_coord = x_coord;
		this.y_coord = y_coord;
		this.continent = continent;
		this.attack_type = attack_type;
		this._hash_id = _hash_id || Math.floor((1 + Math.random()) * 0x1000000).toString(16).substring(1);
	}

	Target.prototype = {
		removeFromPlan: function () {
			switch (this.attack_type) {
				case this.scope.AttackTypes.Nuke:
					this.scope.targets.nukes.splice(this.scope.targets.nukes.indexOf(this), 1);

					// This is so ugly! Is there a more Angular way to do this?
					// Problem is that we don't have a reference to the target-assigning scope, so we have to traverse the DOM to find and check them all
					if (this.is_manually_assigned) {
						var nuke_inputs = $('input[manual-nuke-target-input]');
						var self = this;
						nuke_inputs.each(function (index, element) {
							var manual_target = angular.element(element).scope().village.manual_target;
							if (manual_target && manual_target._hash_id === self._hash_id) {
								angular.element(element).scope().update_manual_target(null);
								return false; // equivalent to break for jQuery loops
							}
						});
					}
					else { // If the target hasn't been manually assigned, that means it's still in the targets_in_plan array, and so it needs to be removed from there too
						this.scope.targets_in_plan.nukes.splice(this.scope.targets_in_plan.nukes.indexOf(this), 1);
					}
					break;
				case this.scope.AttackTypes.Noble:
					this.scope.targets.nobles.splice(this.scope.targets.nobles.indexOf(this), 1);

					// This is so ugly! Is there a more Angular way to do this?
					// Problem is that we don't have a reference to the target-assigning scope, so we have to traverse the DOM to find and check them all
					if (this.is_manually_assigned) {
						var noble_inputs = $('input[manual-noble-target-input]');
						var self = this;
						noble_inputs.each(function (index, element) {
							var manual_target = angular.element(element).scope().village.manual_target;
							if (manual_target && manual_target._hash_id === self._hash_id) {
								angular.element(element).scope().update_manual_target(null);
								return false; // equivalent to break for jQuery loops
							}
						});
					}
					else { // If the target hasn't been manually assigned, that means it's still in the targets_in_plan array, and so it needs to be removed from there too
						this.scope.targets_in_plan.nobles.splice(this.scope.targets_in_plan.nobles.indexOf(this), 1);
					}
					break;
				case this.scope.AttackTypes.Support:
					this.scope.targets.supports.splice(this.scope.targets.supports.indexOf(this), 1);

					// This is so ugly! Is there a more Angular way to do this?
					// Problem is that we don't have a reference to the target-assigning scope, so we have to traverse the DOM to find and check them all
					if (this.is_manually_assigned) {
						var support_inputs = $('input[manual-support-target-input]');
						var self = this;
						support_inputs.each(function (index, element) {
							var manual_target = angular.element(element).scope().village.manual_target;
							if (manual_target && manual_target._hash_id === self._hash_id) {
								angular.element(element).scope().update_manual_target(null);
								return false; // equivalent to break for jQuery loops
							}
						});
					}
					else { // If the target hasn't been manually assigned, that means it's still in the targets_in_plan array, and so it needs to be removed from there too
						this.scope.targets_in_plan.supports.splice(this.scope.targets_in_plan.supports.indexOf(this), 1);
					}
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
			if (this.coords === '') {
				alert('You haven\'t entered any coordinates in the box yet.');
				return false;
			}

			var coords = this.coords.match(/[0-9]{3}\|[0-9]{3}/g);

			if (!coords || coords.length === '') {
				alert('None of the coordinates you entered are valid! Use the format xxx|yyy, separated by spaces.');
				return false;
			}

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

		this.selected_group = null;
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
			if (this.selected_group == this.scope.groups[0]) {
				alert("Please select the group in the dropdown menu you want to add!");
				return false;
			}

			var coords = this.selected_group.villages;

			for (var i = 0; i < this.scope.villages.length; i++) {
				for (var j = 0; j < coords.length; j++) {
					var coord_components = coords[j].coordinates.split('|');

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
			else if (this.nukes_quantity + this.nobles_quantity + this.supports_quantity <= 0) {
				alert('Please enter numbers greater than zero in the Number of Attacks to Send box.');
				return false;
			}

			var coords = this.coords.match(/[0-9]{3}\|[0-9]{3}/g);

			if (!coords || coords.length === '') {
				alert('None of the coordinates you entered are valid! Use the format xxx|yyy, separated by spaces.');
				return false;
			}

			for (var i = 0; i < coords.length; i++) {
				var coord_components = coords[i].split('|');

				for (var j = 0; j < this.nukes_quantity; j++) {
					var new_target = new Target(
						this.scope,
						coord_components[0],
						coord_components[1],
						'K' + coord_components[1].substring(0, 1) + coord_components[0].substring(0, 1),
						this.scope.AttackTypes.Nuke
					);

					this.scope.targets.nukes.push(new_target);
					this.scope.targets_in_plan.nukes.push(new_target);
				}
				for (var j = 0; j < this.nobles_quantity; j++) {
					var new_target = new Target(
						this.scope,
						coord_components[0],
						coord_components[1],
						'K' + coord_components[1].substring(0, 1) + coord_components[0].substring(0, 1),
						this.scope.AttackTypes.Noble
					);

					this.scope.targets.nobles.push(new_target);
					this.scope.targets_in_plan.nobles.push(new_target);
				}
				for (var j = 0; j < this.supports_quantity; j++) {
					var new_target = new Target(
						this.scope,
						coord_components[0],
						coord_components[1],
						'K' + coord_components[1].substring(0, 1) + coord_components[0].substring(0, 1),
						this.scope.AttackTypes.Support
					);

					this.scope.targets.supports.push(new_target);
					this.scope.targets_in_plan.supports.push(new_target);
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

/**
 * A command object
 * @return {Command} An instance of a Command
 */
Command = (function () {
	function Command(scope, village, target, traveling_time, launch_datetime) {
		this.scope = scope;

		this.village = village;
		this.target = target;
		this.slowest_unit = village.slowest_unit;
		this.attack_type = village.attack_type;
		this.traveling_time = traveling_time;
		this.launch_datetime = launch_datetime;
		this.time_remaining = (new Date(this.launch_datetime - new Date())).getTime() / 1000; // Seconds

		// #CASUALWORLDHACK make sure the world prefix is correct
		if (this.scope.MetaData.current_world === 1 || this.scope.MetaData.current_world === 2) { // casual world
			this.launch_url = "http://enp" + this.scope.MetaData.current_world + ".tribalwars.net/game.php?village=" + this.village.village_id + "&screen=place&x=" + this.target.x_coord + "&y=" + this.target.y_coord + "&attacktype=" + this.attack_type;
		}
		else {
			this.launch_url = "http://en" + this.scope.MetaData.current_world + ".tribalwars.net/game.php?village=" + this.village.village_id + "&screen=place&x=" + this.target.x_coord + "&y=" + this.target.y_coord + "&attacktype=" + this.attack_type;
		}
	}

	Command.prototype = {
		decrement_time_remaining: function () {
			if (this.time_remaining > 0) {
				this.time_remaining--;
			}
			else {
				this.time_remaining = 'Expired!';
			}
		},
		alarm: function () {

		},
		delete: function () {
			this.scope.plan.commands.splice(this.scope.plan.commands.indexOf(this), 1);
		}
	};

	return Command;
})();

/**
 * A plan object
 * @return {Plan} An instance of a Plan
 */
Plan = (function () {
	function Plan(scope, name, landing_datetime, commands) {
		this.scope = scope;

		this.name = name;
		this.landing_datetime = landing_datetime;
		this.commands = commands || [];
	}

	Plan.prototype = {
		sort: function () {
			this.commands.sort(function (a, b) {
				return b.launchtime - a.launch_datetime;
			});
		},
		export_as_text: function () {
			var s = this.name + "\n\n";

			for (var i = 0; i < this.commands.length; i++) {
				s += "Send "
				+ this.commands[i].slowest_unit.name
				+ " ("
				+ this.scope.AttackTypes.toString[this.commands[i].attack_type]
				+ ") from [village]"
				+ this.commands[i].village.x_coord
				+ "|"
				+ this.commands[i].village.y_coord
				+ "[/village] to [village]"
				+ this.commands[i].target.x_coord
				+ "|"
				+ this.commands[i].target.y_coord
				+ "[/village] at [b]"
				+ this.commands[i].launch_datetime
				+ "[/b]\n";
			}

			return s;
		},
		export_as_table: function () {
			var s = this.name + "\n\n[table][**]Village[||]Target[||]Slowest Unit[||]Attack Type[||]Launch Time[/**]";

			for (var i = 0; i < this.commands.length; i++) {
				s += "[*][village]"
				+ this.commands[i].village.x_coord
				+ "|"
				+ this.commands[i].village.y_coord
				+ "[/village][|][village]"
				+ this.commands[i].target.x_coord
				+ "|"
				+ this.commands[i].target.y_coord
				+ "[/village][|]"
				+ this.commands[i].slowest_unit.name
				+ "[|]"
				+ this.scope.AttackTypes.toString[this.commands[i].attack_type]
				+ "[|]"
				+ this.commands[i].launch_datetime
				+ "\n";
			}

			return s;
		}
	};

	return Plan;
})();