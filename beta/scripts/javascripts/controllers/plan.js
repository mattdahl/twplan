/**
 * Creates a module that acts as the ng-app on plan.php
 */
var PlanModule = angular.module('PlanModule', []);

/**
 * Provides configuration for the PlanModule, namely setting up route forwarding using $routeProvider for a single-page app experience
 */
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

/**
 * Once the PlanModule has been initialized and the DOM has loaded, sets up the $rootScope variables
 */
PlanModule.run(['$rootScope', 'AttackTypes', function ($rootScope, AttackTypes) {
	$rootScope.villages = [];
	$rootScope.villages_in_plan = {
			nukes: [],
			nobles: [],
			supports: []
		};

	$rootScope.targets_in_plan = {
		nukes: [],
		nobles: [],
		supports: []
	};

	$rootScope.AttackTypes = AttackTypes;

	$rootScope.plan = null;

	$rootScope.instructions = 'Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!\n\nTWplan\'s algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound".';

	$rootScope.current_world = sessionStorage.currentWorld;
}]);

// BEGIN DUPLICATE SERVICES

PlanModule.factory('WorldInfo', function () {
	return {
		11: {
			speed: 1,
			unitSpeed: 1
		},
		19: {
			speed: 1.5,
			unitSpeed: 1
		},
		30: {
			speed: 1,
			unitSpeed: 1
		},
		38: {
			speed: 2,
			unitSpeed: 0.5
		},
		42: {
			speed: 1.25,
			unitSpeed: 0.8
		},
		46: {
			speed: 1.2,
			unitSpeed: 1
		},
		48: {
			speed: 1,
			unitSpeed: 1
		},
		50: {
			speed: 2,
			unitSpeed: 0.6
		},
		54: {
			speed: 1,
			unitSpeed: 1
		},
		55: {
			speed: 1.1,
			unitSpeed: 1.3
		},
		56: {
			speed: 2,
			unitSpeed: 0.6
		},
		57: {
			speed: 1.25,
			unitSpeed: 1
		},
		58: {
			speed: 1.5,
			unitSpeed: 0.8
		},
		59: {
			speed: 1,
			unitSpeed: 1
		},
		60: {
			speed: 1.25,
			unitSpeed: 0.8
		},
		61: {
			speed: 1.5,
			unitSpeed: 0.8
		},
		62: {
			speed: 1.75,
			unitSpeed: 0.75
		},
		63: {
			speed: 1,
			unitSpeed: 1
		},
		64: {
			speed: 1.5,
			unitSpeed: 0.75
		},
		65: {
			speed: 2,
			unitSpeed: 0.65
		},
		66: {
			speed: 1,
			unitSpeed: 1
		},
		67: {
			speed: 1.5,
			unitSpeed: 0.75
		},
		68: {
			spped: 1,
			unitSpeed: 1
		},
		69: {
			speed: 1.5,
			unitSpeed: 0.8
		}
	};
});

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
			name: 'Spear',
			speed: 18,
			url: 'spear.png'
		},
		Sword: {
			id: 1,
			name: 'Sword',
			speed: 22,
			url: 'sword.png'
		},
		Axe: {
			id: 2,
			name: 'Axe',
			speed: 18,
			url: 'axe.png'
		},
		Archer: {
			id: 3,
			name: 'Archer',
			speed: 18,
			url: 'archer.png'
		},
		Scout: {
			id: 4,
			name: 'Scout',
			speed: 9,
			url: 'scout.png'
		},
		Lc: {
			id: 5,
			name: 'Lc',
			speed: 10,
			url: 'lc.png'
		},
		Hc: {
			id: 6,
			name: 'Hc',
			speed: 11,
			url: 'hc.png'
		},
		Marcher: {
			id: 7,
			name: 'Marcher',
			speed: 10,
			url: 'marcher.png'
		},
		Ram: {
			id: 8,
			name: 'Ram',
			speed: 30,
			url: 'ram.png'
		},
		Cat: {
			id: 9,
			name: 'Cat',
			speed: 30,
			url: 'cat.png'
		},
		Pally: {
			id: 10,
			name: 'Pally',
			speed: 10,
			url: 'pally.png'
		},
		Noble: {
			id: 11,
			name: 'Noble',
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

// END DUPLICATE

/**
 * The controller for the Step One page of plan.php
 */
PlanModule.controller('StepOneController', ['$scope', 'Villages', 'GroupNames', 'Units', 'AttackTypes', function ($scope, Villages, GroupNames, Units, AttackTypes) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

	$scope.instructions = 'Below is a list of your villages. Select the ones you wish to include in the plan and choose the slowest traveling times, respectively. Choose how you want to classify each attack (noble, nuke, support). Common defaults are in place, but change them accordingly if needed (i.e. sending HC as an attack instead of support).\n\nAt the bottom of the page is a table with all the villages you add to your plan.';
	$scope.current_step = 1;

	$scope.village_paste_in_interface = new VillagePasteInInterface($scope);
	$scope.village_group_interface = new VillageGroupInterface($scope);

	$scope.group_names = [];

	$scope.Units = Units;
	$scope.AttackTypes = AttackTypes;

	$scope.submitStepOne = function () {
		debugger;
		if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length == 0) {
			alert("You haven't added any villages! Please choose at least one.");
			return false;
		}

		debugger;

		window.location.href = 'plan.php#/step_two';
	};

	// Checks if villages have already been loaded (i.e. returning from step two or three)
	if ($scope.villages.length == 0) {
		Villages.getUserVillages() // Returns a promise object
		.then(function (data) { // Success
			$.each(data, function (index, element) {
				$scope.villages.push(new Village(
					$scope,
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

	// Checks if group name have already been loaded (i.e. returning from step two or three)
	if (!$scope.group_names) {
		GroupNames.getGroupNames() // Returns a promise object
			.then(function (data) { // Success
				$scope.group_names = data;
				debugger;
			}, function (data) { // Error
				debugger;
			});
	}

}]);

PlanModule.controller('StepTwoController', ['$scope', 'AttackTypes', function ($scope, AttackTypes) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

	$scope.instructions = 'Next, enter the coordinates of your targets. Choose how many of each command (noble, nuke, and support) you want to send to each village - the commands available are determined by your village selections in Step 1.';
	$scope.current_step = 2;

	$scope.target_paste_in_interface = new TargetPasteInInterface($scope);

	$scope.AttackTypes = AttackTypes;

	$scope.submitStepTwo = function () {
		if ($scope.targets_in_plan.nukes.length + $scope.targets_in_plan.nobles.length + $scope.targets_in_plan.supports.length == 0) {
			alert("You haven't added any targets! Please enter at least one.");
			return false;
		}
		else if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length < $scope.targets_in_plan.nukes.length + $scope.targets_in_plan.nobles.length + $scope.targets_in_plan.supports.length) {
			alert("You've added more targets than you selected villages in Step One. Please remove some targets or go back and add more villages.");
			return false;
		}
		else if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length > $scope.targets_in_plan.nukes.length + $scope.targets_in_plan.nobles.length + $scope.targets_in_plan.supports.length) {
			if (!confirm("You have more villages than targets! Is this okay?")) {
				return false;
			}
		}

		window.location.href = 'plan.php#/step_three';
	};
}]);

PlanModule.controller('StepThreeController', ['$rootScope', '$scope', 'WorldInfo', function ($rootScope, $scope, WorldInfo) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

	$scope.instructions = 'Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!';
	$scope.current_step = 3;

	$scope.landing_date = '';
	$scope.landing_time = '';
	$scope.optimization_checked = false;
	$scope.early_bound;
	$scope.late_bound;

	$scope.submitStepThree = function () {
		if ($scope.landing_date == '') {
			alert("Please enter landing date information.");
			return false;
		}
		else if (!$scope.landing_time.match(/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/)) {
			alert("TWplan doesn't recognize the time you submitted. Please use hh:mm:ss format.");
			return false;
		}

		$scope.calculate_plan();

		window.location.href = 'plan.php#/results';
	};

	$scope.calculate_plan = function () {
		$scope.configure_dst_lookup();

		var landing_datetime = new Date($scope.landing_date + ' ' + $scope.landing_time);

		if ($scope.optimization_checked) {
			// Returns an array where index=village location and value=target location
			var paired_nukes = hungarian($scope.villages_in_plan.nukes, $scope.targets_in_plan.nukes, landing_datetime, $scope.early_bound, $scope.late_bound);
			var paired_nobles = hungarian($scope.villages_in_plan.nobles, $scope.targets_in_plan.nobles, landing_datetime, $scope.early_bound, $scope.late_bound);
			var paired_supports = hungarian($scope.villages_in_plan.supports, $scope.targets_in_plan.supports, landing_datetime, $scope.early_bound, $scope.late_bound);
		}
		else {
			// Returns an array where index=village location and value=target location
			var paired_nukes = hungarian($scope.villages_in_plan.nukes, $scope.targets_in_plan.nukes, landing_datetime);
			var paired_nobles = hungarian($scope.villages_in_plan.nobles, $scope.targets_in_plan.nobles, landing_datetime);
			var paired_supports = hungarian($scope.villages_in_plan.supports, $scope.targets_in_plan.supports, landing_datetime);

		}

		$rootScope.plan = new Plan(
			$rootScope,
			"Attack Plan Landing on " + $scope.landing_date + " at " + $scope.landing_time + " (ST)",
			landing_datetime);

		for (var i = 0; i < paired_nukes.length; i++) {
			var traveling_time = $scope.calculate_traveling_time($scope.villages_in_plan.nukes[i], $scope.targets_in_plan.nukes[paired_nukes[i]]);
			debugger;
			$rootScope.plan.commands.push(new Command(
				$scope,
				$scope.villages_in_plan.nukes[i],
				$scope.targets_in_plan.nukes[paired_nukes[i]],
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				));
		}

		for (var i = 0; i < paired_nobles.length; i++) {
			var traveling_time = $scope.calculate_traveling_time($scope.villages_in_plan.nobles[i], $scope.targets_in_plan.nobles[paired_nobles[i]]);

			$rootScope.plan.commands.push(new Command(
				$scope,
				$scope.villages_in_plan.nobles[i],
				$scope.targets_in_plan.nobles[paired_nobles[i]],
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				));
		}

		for (var i = 0; i < paired_supports.length; i++) {
			var traveling_time = $scope.calculate_traveling_time($scope.villages_in_plan.supports[i], $scope.targets_in_plan.supports[paired_supports[i]]);

			$rootScope.plan.commands.push(new Command(
				$scope,
				$scope.villages_in_plan.supports[i],
				$scope.targets_in_plan.supports[paired_supports[i]],
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				));
		}

		$rootScope.plan.sort();
	};

	$scope.calculate_launch_time = function (landing_datetime, traveling_time) {
		var n = new Date();
		var offset;

		if (n.isDST()) {
			offset = (n.getTimezoneOffset() / 60) + 1;
		}
		else {
			offset = n.getTimezoneOffset() / 60;
		}
		// Gets difference; positive if west of UTC, negative if east
		// +1 when daylight savings is active!

		debugger;
		var before_offset = new Date(landing_datetime - traveling_time);

		return new Date(before_offset.setHours(before_offset.getHours() + offset));
	};

	$scope.calculate_traveling_time = function (village, target) {
		var distance = Math.sqrt(Math.pow(village.x_coord - target.x_coord, 2) + Math.pow(village.y_coord - target.y_coord, 2));

		return new Date(((distance * village.slowest_unit.speed) / (WorldInfo[$scope.current_world].speed * WorldInfo[$scope.current_world].unitSpeed)) * 60 * 1000);
	};

	$scope.format_seconds = function (secs) {
		var pad = function (n) {
			return (n < 10 ? "0" + n : n);
		};

		var h = Math.floor(secs / 3600);
		var m = Math.floor((secs / 3600) % 1 * 60);
		var s = Math.floor((secs / 60) % 1 * 60);

		return pad(h) + ":" + pad(m) + ":" + pad(s);
	};

	$scope.configure_dst_lookup = function () {
		Date.prototype.stdTimezoneOffset = function () {
			var jan = new Date(this.getFullYear(), 0, 1);
			var jul = new Date(this.getFullYear(), 6, 1);
			return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
		};

		Date.prototype.isDST = function () {
			return this.getTimezoneOffset() < this.stdTimezoneOffset();
		};
	};
}]);

PlanModule.controller('ResultsController', ['$scope', 'AttackTypes', function ($scope, AttackTypes) {
	$scope.$watch(function () { console.log("A digest was executed!"); });

	$scope.instructions = 'Below are the results of your attack plan. You can export the information to copy into your TW notebook, and/or save the data for later access.';
	$scope.current_step = 4;

	$scope.countdown_timeout = null;

	$scope.AttackTypes = AttackTypes;

	$scope.table_export = $scope.plan.export_as_table();
	$scope.text_export = $scope.plan.export_as_text();

	$scope.format_seconds = function (secs) {
		if (secs == 'Expired!') {
			return 'Expired';
		}

		var pad = function (n) {
			return (n < 10 ? "0" + n : n);
		};

		var h = Math.floor(secs / 3600);
		var m = Math.floor((secs / 3600) % 1 * 60);
		var s = Math.floor((secs / 60) % 1 * 60);

		return pad(h) + ":" + pad(m) + ":" + pad(s);
	};

	$scope.countdown = function () {
		$scope.countdown_timeout = setInterval(function () {
			$scope.$apply(function () {
				for (var i = 0; i < $scope.plan.commands.length; i++) {
					$scope.plan.commands[i].decrement_time_remaining();
				}
			});
		},
		1000);
	};

	if ($scope.countdown_timeout) {
		$timeout.cancel($scope.countdown_timeout);
	}

	$scope.countdown();
}]);