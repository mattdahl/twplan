var PlanModule = angular.module('PlanModule', []);

PlanModule.run(['$rootScope', function ($rootScope) {
	$rootScope.villages = [];
	$rootScope.villages_in_plan = {
			villages: [],
			nukes: 0,
			nobles: 0,
			supports: 0
		};

	$rootScope.targets = [];
	$rootScope.targets_in_plan = {
		targets: [],
		nukes: [],
		nobles: [],
		supports: []
	};

	$rootScope.instructions = 'Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!\n\nTWplan\'s algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound".';
}]);

PlanModule.config(['$routeProvider', function ($routeProvider) {
	$routeProvider
		.when('/step_one',
		{
			templateUrl: 'partials/step_one.php',
			controller: 'StepOneController'
		})
		.when('/step_two',
		{
			templateUrl: 'partials/step_two.php',
			controller: 'StepTwoController'
		})
		.when('/step_three',
		{
			templateUrl: 'partials/step_three.php',
			controller: 'StepThreeController'
		})
		.when('/results',
		{
			templateUrl: 'partials/results.php',
			controller: 'ResultsController'
		})
		.otherwise({redirectTo: '/step_one'});
}]);

PlanModule.factory('AttackTypes', function () {
	return {
		Nuke: 0,
		Noble: 1,
		Support: 2,
		toString: ["Nuke", "Noble", "Support"]
	};
});

PlanModule.factory('Units', function () {
	return {
		Spear: {
			id: 0,
			speed: 18,
			url: 'spear.png'
		},
		Sword: {
			id: 1,
			speed: 22,
			url: 'sword.png'
		},
		Axe: {
			id: 2,
			speed: 18,
			url: 'axe.png'
		},
		Archer: {
			id: 3,
			speed: 18,
			url: 'archer.png'
		},
		Scout: {
			id: 4,
			speed: 9,
			url: 'scout.png'
		},
		Lc: {
			id: 5,
			speed: 10,
			url: 'lc.png'
		},
		Hc: {
			id: 6,
			speed: 11,
			url: 'hc.png'
		},
		Marcher: {
			id: 7,
			speed: 10,
			url: 'marcher.png'
		},
		Ram: {
			id: 8,
			speed: 30,
			url: 'ram.png'
		},
		Cat: {
			id: 9,
			speed: 30,
			url: 'cat.png'
		},
		Pally: {
			id: 10,
			speed: 10,
			url: 'pally.png'
		},
		Noble: {
			id: 11,
			speed: 35,
			url: 'noble.png'
		}
	};
});

/**
 * A service that queries the database for the current user's villages on the current world
 * @param{AngularObject} $http - An AngularHTTP object that automates AJAX queries
 * @param{AngularObject} $q - An AngularPromise object
 * @return {AngularPromise} - A promise of completion of the lookup query
 */
PlanModule.factory('Villages', ['$http', '$q', function ($http, $q) {
	return {
		getUserVillages: function () {
			var deferred = $q.defer();

			$http.post('scripts/loadvillagesforplan.php')
			.success(function (data, status, headers, config) {
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		}
	};
}]);

PlanModule.factory('GroupNames', ['$http', '$q', function ($http, $q) {
	return {
		getGroupNames: function () {
			var deferred = $q.defer();

			$http.post('scripts/groupnames.php')
			.success(function (data, status, headers, config) {
				if (data == "null") {
					deferred.resolve(null);
				}
				else {
					deferred.resolve(data);
				}
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		}
	};
}]);


/**
 * A village object
 * @return {Village} An instance of a Village
 */
Village = (function () {
	function Village($scope, village_id, name, x_coord, y_coord, continent, slowest_unit, attack_type) {
		this.$scope = $scope;

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
				case this.$scope.Units.Axe:
				case this.$scope.Units.Scout:
				case this.$scope.Units.Lc:
				case this.$scope.Units.Marcher:
				case this.$scope.Units.Ram:
				case this.$scope.Units.Cat:
					this.attack_type = this.$scope.AttackTypes.Nuke;
					break;
				case this.$scope.Units.Noble:
					this.attack_type = this.$scope.AttackTypes.Noble;
					break;
				case this.$scope.Units.Spear:
				case this.$scope.Units.Sword:
				case this.$scope.Units.Archer:
				case this.$scope.Units.Hc:
				case this.$scope.Units.Pally:
					this.attack_type = this.$scope.AttackTypes.Support;
					break;
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		setAttackType: function (attack_type) {
			this.attack_type = attack_type;
			if (!this.slowest_unit) {
				switch (this.attack_type) {
					case this.$scope.AttackTypes.Nuke:
						this.slowest_unit = this.$scope.Units.Axe;
						break;
					case this.$scope.AttackTypes.Noble:
						this.slowest_unit = this.$scope.Units.Noble;
						break;
					case this.$scope.AttackTypes.Support:
						this.slowest_unit = this.$scope.Units.Spear;
						break;
				}
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		addToPlan: function () {
			this.$scope.villages_in_plan.villages.push(new Village(this.$scope,
				this.village_id,
				this.name,
				this.x_coord,
				this.y_coord,
				this.continent,
				this.slowest_unit,
				this.attack_type));

			switch (this.attack_type) {
				case this.$scope.AttackTypes.Nuke:
					this.$scope.villages_in_plan.nukes++;
					break;
				case this.$scope.AttackTypes.Noble:
					this.$scope.villages_in_plan.nobles++;
					break;
				case this.$scope.AttackTypes.Support:
					this.$scope.villages_in_plan.supports++;
					break;
			}

			$("#" + this.village_id + '_row').effect("highlight", {color: "#a9a96f"}, 2000);
			$('#' + this.village_id + '_add_button').blur();

			this.slowest_unit = null;
			this.attack_type = null;
		},
		removeFromPlan: function () {
			this.$scope.villages_in_plan.villages.splice(this.$scope.villages_in_plan.villages.indexOf(this), 1);

			switch (this.attack_type) {
				case this.$scope.AttackTypes.Nuke:
					this.$scope.villages_in_plan.nukes--;
					break;
				case this.$scope.AttackTypes.Noble:
					this.$scope.villages_in_plan.nobles--;
					break;
				case this.$scope.AttackTypes.Support:
					this.$scope.villages_in_plan.supports--;
					break;
			}
		}
	};

	return Village;
})();

Target = (function () {
	function Target($scope, x_coord, y_coord, continent, attack_type) {
		this.$scope = $scope;

		this.x_coord = x_coord;
		this.y_coord = y_coord;
		this.continent = continent;
		this.attack_type = attack_type;
	}

	Target.prototype = {
		removeFromPlan: function () {
			this.$scope.villages_in_plan.villages.splice(this.$scope.villages_in_plan.villages.indexOf(this), 1);

			switch (this.attack_type) {
				case this.$scope.AttackTypes.Nuke:
					this.$scope.villages_in_plan.nukes--;
					break;
				case this.$scope.AttackTypes.Noble:
					this.$scope.villages_in_plan.nobles--;
					break;
				case this.$scope.AttackTypes.Support:
					this.$scope.villages_in_plan.supports--;
					break;
			}
		}
	};

	return Village;
})();

Row = (function () {
	function Row($scope, slowest_unit, attack_type) {
		this.$scope = $scope;

		this.slowest_unit = slowest_unit;
		this.attack_type = attack_type;
	}

	Row.prototype = {
		setSlowestUnit: function (slowest_unit) {
			this.slowest_unit = slowest_unit;
			switch (this.slowest_unit) {
				case this.$scope.Units.Axe:
				case this.$scope.Units.Scout:
				case this.$scope.Units.Lc:
				case this.$scope.Units.Marcher:
				case this.$scope.Units.Ram:
				case this.$scope.Units.Cat:
					this.attack_type = this.$scope.AttackTypes.Nuke;
					break;
				case this.$scope.Units.Noble:
					this.attack_type = this.$scope.AttackTypes.Noble;
					break;
				case this.$scope.Units.Spear:
				case this.$scope.Units.Sword:
				case this.$scope.Units.Archer:
				case this.$scope.Units.Hc:
				case this.$scope.Units.Pally:
					this.attack_type = this.$scope.AttackTypes.Support;
					break;
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		setAttackType: function (attack_type) {
			this.attack_type = attack_type;
			if (!this.slowest_unit) {
				switch (this.attack_type) {
					case this.$scope.AttackTypes.Nuke:
						this.slowest_unit = this.$scope.Units.Axe;
						break;
					case this.$scope.AttackTypes.Noble:
						this.slowest_unit = this.$scope.Units.Noble;
						break;
					case this.$scope.AttackTypes.Support:
						this.slowest_unit = this.$scope.Units.Spear;
						break;
				}
			}
			$('#' + this.village_id + '_add_button').focus();
		},
		addToPlan: function () {
			if (this.$scope.villages_paste_in_coords == '') {
				alert("You haven't entered any coordinates in the box yet.");
				return false;
			}

			var coords = this.$scope.villages_paste_in_coords.match(/[0-9]{3}\|[0-9]{3}/g);

			for (var i = 0; i < this.$scope.villages.length; i++) {
				for (var j = 0; j < coords.length; j++) {
					var coord_components = coords[j].split('|');

					if (this.$scope.villages[i].x_coord == coord_components[0] && this.$scope.villages[i].y_coord == coord_components[1]) {
						this.$scope.villages_in_plan.villages.push(new Village(this.$scope,
							this.$scope.villages[i].village_id,
							this.$scope.villages[i].name,
							this.$scope.villages[i].x_coord,
							this.$scope.villages[i].y_coord,
							this.$scope.villages[i].continent,
							this.slowest_unit,
							this.attack_type));

						switch (this.attack_type) {
							case this.$scope.AttackTypes.Nuke:
								this.$scope.villages_in_plan.nukes++;
								break;
							case this.$scope.AttackTypes.Noble:
								this.$scope.villages_in_plan.nobles++;
								break;
							case this.$scope.AttackTypes.Support:
								this.$scope.villages_in_plan.supports++;
								break;
						}
					}
				}
			}

			this.$scope.villages_paste_in_coords = "";
			this.slowest_unit = null;
			this.attack_type = null;
		}
	};

	return Row;
})();

/**
 * The controller for the Step One page of plan.php
 */
PlanModule.controller('StepOneController', ['$rootScope', '$scope', 'Villages', 'GroupNames', 'Units', 'AttackTypes', function ($rootScope, $scope, Villages, GroupNames, Units, AttackTypes) {
	$scope.instructions = 'Below is a list of your villages. Select the ones you wish to include in the plan and choose the slowest traveling times, respectively. Choose how you want to classify each attack (noble, nuke, support). Common defaults are in place, but change them accordingly if needed (i.e. sending HC as an attack instead of support).\n\nAt the bottom of the page is a table with all the villages you add to your plan.';
	$scope.current_step = 1;

	$scope.paste_in_row = new Row($scope, null, null);
	$scope.group_row = new Row($scope, null, null);

	$scope.villages_paste_in_coords = "";
	$scope.group_names = [];

	$scope.Units = Units;
	$scope.AttackTypes = AttackTypes;

	$scope.submitStepOne = function () {
		if ($scope.villages_in_plan.villages.length == 0) {
			alert("You haven't selected any villages! Please choose at least one.");
			return false;
		}
		else {
			window.location.href = 'plan.php#/step_two';
		}
	};

	if ($rootScope.villages.length == 0) {
		Villages.getUserVillages() // Returns a promise object
		.then(function (data) { // Success
			$.each(data, function (index, element) {
				$scope.villages.push(new Village($scope,
					element.villageid,
					element.name.replace(/\+/g, ' '),
					element.xcoord,
					element.ycoord,
					'K' + element.ycoord.substring(0, 1) + element.xcoord.substring(0, 1),
					null,
					null));

				$scope.$watch(function () {
					return $('#' + element.villageid + '_add_button').attr('disabled');
				},
				function () {
					$('#' + element.villageid + '_add_button').focus();
				});

				debugger;
			});
		}, function (data) { // Error
			debugger;
		});
	}

	GroupNames.getGroupNames() // Returns a promise object
		.then(function (data) { // Success
			$scope.group_names = data;
			debugger;
		}, function (data) { // Error
			debugger;
		});

}]);

PlanModule.controller('StepTwoController', ['$rootScope', '$scope', 'AttackTypes', function ($rootScope, $scope, AttackTypes) {
	$scope.instructions = 'Next, enter the coordinates of your targets. Choose how many of each command (noble, nuke, and support) you want to send to each village - the commands available are determined by your village selections in Step 1. Use the Add Many Targets feature to set the same information for many targets at once.';
	$scope.current_step = 2;

	$scope.paste_in_targets_obj = {
		paste_in_coords: '',
		nukes_quantity: 0,
		nobles_quantity: 0,
		supports_quantity: 0,
		addToPlan = function () {
			if (this.paste_in_coords == '') {
				alert("You haven't entered any coordinates in the box yet.");
				return false;
			}

			var coords = this.paste_in_coords.match(/[0-9]{3}\|[0-9]{3}/g);

			for (var i = 0; i < coords.length; i++)
				$rootScope.targets_in_plan.targets.push(new Target());

				for (var j = 0; j < coords.length; j++) {
					var coord_components = coords[j].split('|');

					if (this.$scope.villages[i].x_coord == coord_components[0] && this.$scope.villages[i].y_coord == coord_components[1]) {
						this.$scope.villages_in_plan.villages.push(new Village(this.$scope,
							this.$scope.villages[i].village_id,
							this.$scope.villages[i].name,
							this.$scope.villages[i].x_coord,
							this.$scope.villages[i].y_coord,
							this.$scope.villages[i].continent,
							this.slowest_unit,
							this.attack_type));

						switch (this.attack_type) {
							case this.$scope.AttackTypes.Nuke:
								this.$scope.villages_in_plan.nukes++;
								break;
							case this.$scope.AttackTypes.Noble:
								this.$scope.villages_in_plan.nobles++;
								break;
							case this.$scope.AttackTypes.Support:
								this.$scope.villages_in_plan.supports++;
								break;
						}
					}
				}
			}

			this.$scope.villages_paste_in_coords = "";
			this.slowest_unit = null;
			this.attack_type = null;
		}
	};


	(function () {
		function Row($scope, slowest_unit, attack_type) {
			this.$scope = $scope;

			this.slowest_unit = slowest_unit;
			this.attack_type = attack_type;
		}

		Row.prototype = {
			setSlowestUnit: function (slowest_unit) {
				this.slowest_unit = slowest_unit;
				switch (this.slowest_unit) {
					case this.$scope.Units.Axe:
					case this.$scope.Units.Scout:
					case this.$scope.Units.Lc:
					case this.$scope.Units.Marcher:
					case this.$scope.Units.Ram:
					case this.$scope.Units.Cat:
						this.attack_type = this.$scope.AttackTypes.Nuke;
						break;
					case this.$scope.Units.Noble:
						this.attack_type = this.$scope.AttackTypes.Noble;
						break;
					case this.$scope.Units.Spear:
					case this.$scope.Units.Sword:
					case this.$scope.Units.Archer:
					case this.$scope.Units.Hc:
					case this.$scope.Units.Pally:
						this.attack_type = this.$scope.AttackTypes.Support;
						break;
				}
				$('#' + this.village_id + '_add_button').focus();
			},
			setAttackType: function (attack_type) {
				this.attack_type = attack_type;
				if (!this.slowest_unit) {
					switch (this.attack_type) {
						case this.$scope.AttackTypes.Nuke:
							this.slowest_unit = this.$scope.Units.Axe;
							break;
						case this.$scope.AttackTypes.Noble:
							this.slowest_unit = this.$scope.Units.Noble;
							break;
						case this.$scope.AttackTypes.Support:
							this.slowest_unit = this.$scope.Units.Spear;
							break;
					}
				}
				$('#' + this.village_id + '_add_button').focus();
			},
			addToPlan: function () {
				if (this.$scope.villages_paste_in_coords == '') {
					alert("You haven't entered any coordinates in the box yet.");
					return false;
				}

				var coords = this.$scope.villages_paste_in_coords.match(/[0-9]{3}\|[0-9]{3}/g);

				for (var i = 0; i < this.$scope.villages.length; i++) {
					for (var j = 0; j < coords.length; j++) {
						var coord_components = coords[j].split('|');

						if (this.$scope.villages[i].x_coord == coord_components[0] && this.$scope.villages[i].y_coord == coord_components[1]) {
							this.$scope.villages_in_plan.villages.push(new Village(this.$scope,
								this.$scope.villages[i].village_id,
								this.$scope.villages[i].name,
								this.$scope.villages[i].x_coord,
								this.$scope.villages[i].y_coord,
								this.$scope.villages[i].continent,
								this.slowest_unit,
								this.attack_type));

							switch (this.attack_type) {
								case this.$scope.AttackTypes.Nuke:
									this.$scope.villages_in_plan.nukes++;
									break;
								case this.$scope.AttackTypes.Noble:
									this.$scope.villages_in_plan.nobles++;
									break;
								case this.$scope.AttackTypes.Support:
									this.$scope.villages_in_plan.supports++;
									break;
							}
						}
					}
				}

				this.$scope.villages_paste_in_coords = "";
				this.slowest_unit = null;
				this.attack_type = null;
			}
		};

		return Row;
	})();

	$scope.AttackTypes = AttackTypes;

}]);