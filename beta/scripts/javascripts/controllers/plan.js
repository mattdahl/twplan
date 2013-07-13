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
PlanModule.run(['$rootScope', function ($rootScope) {
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

	$rootScope.instructions = 'Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!\n\nTWplan\'s algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound".';
}]);

// BEGIN DUPLICATE SERVICES

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

// END DUPLICATE

/**
 * The controller for the Step One page of plan.php
 */
PlanModule.controller('StepOneController', ['$rootScope', '$scope', 'Villages', 'GroupNames', 'Units', 'AttackTypes', function ($rootScope, $scope, Villages, GroupNames, Units, AttackTypes) {
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
	if ($rootScope.villages.length == 0) {
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

PlanModule.controller('StepTwoController', ['$rootScope', '$scope', 'AttackTypes', function ($rootScope, $scope, AttackTypes) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

	$scope.instructions = 'Next, enter the coordinates of your targets. Choose how many of each command (noble, nuke, and support) you want to send to each village - the commands available are determined by your village selections in Step 1. Use the Add Many Targets feature to set the same information for many targets at once.';
	$scope.current_step = 2;

	$scope.target_paste_in_interface = new TargetPasteInInterface($scope);

	$scope.AttackTypes = AttackTypes;

	$scope.submitStepTwo = function () {
		if ($scope.targets_in_plan.nukes.length + $scope.targets_in_plan.nobles.length + $scope.targets_in_plan.supports.length == 0) {
			alert("You haven't added any targets! Please enter at least one.");
			return false;
		}
		else if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length > $scope.targets_in_plan.nukes.length + $scope.targets_in_plan.nobles.length + $scope.targets_in_plan.supports.length) {
			alert("You've added more targets than you selected villages in Step One. Please remove some targets or go back and add more villages.");
			return false;
		}
		else if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length < $scope.targets_in_plan.nukes.length + $scope.targets_in_plan.nobles.length + $scope.targets_in_plan.supports.length) {
			if (!confirm("You have more villages than targets! Is this okay?")) {
				return false;
			}
		}

		window.location.href = 'plan.php#/step_three';
	};
}]);