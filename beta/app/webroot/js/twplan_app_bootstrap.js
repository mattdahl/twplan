// TWP is the twplan.com namespace
// twplan is an object representing an Angular module
// Propeties on the twplan object are its controllers, factories, directives, etc. modulated for dependency injection

var TWP = TWP || {};

TWP.twplan = angular.module('twplan_app', ['twplan_app.controllers']);
TWP.twplan.Controllers = angular.module('twplan_app.controllers', ['twplan_app.factories', 'twplan_app.directives']);
TWP.twplan.Factories = angular.module('twplan_app.factories', []);
TWP.twplan.Directives = angular.module('twplan_app.directives', []);

/**
 * Provides configuration for the PlanModule, namely setting up route forwarding using $routeProvider for a single-page app experience
 */
TWP.twplan.config(['$routeProvider', function ($routeProvider) {
	$routeProvider
		.when('/step_one',
		{
			templateUrl: 'plan/step_one',
			controller: 'StepOneController'
		})
		.when('/step_two',
		{
			templateUrl: 'plan/step_two',
			controller: 'StepTwoController'
		})
		.when('/step_three',
		{
			templateUrl: 'plan/step_three',
			controller: 'StepThreeController'
		})
		.when('/results',
		{
			templateUrl: 'plan/results',
			controller: 'ResultsController'
		})
		.otherwise({
			redirectTo: '/step_one'
		});
}]);

/**
 * Once the twplan module has been initialized and the DOM has loaded, sets up the $rootScope variables
 */
TWP.twplan.run(['$rootScope', 'MetaData', 'AttackTypes', function ($rootScope, MetaData, AttackTypes) {
	$rootScope.$on('$locationChangeStart', function (event, next, current) {
		// Fixes annoying bug in Opera 12
		// Should be fixed in latest version of Angular: https://github.com/angular/angular.js/commit/dca23173e25a32cb740245ca7f7b01a84805f43f
		// This forces the location.href to be read, and therefore update synchronously when the .otherwise redirectTo triggers location.replace()
		setTimeout(function () {
			window.location.href === window.location.href;
		}, 50);
	});

	$rootScope.villages = [];
	$rootScope.villages_in_plan = {
			nukes: [],
			nobles: [],
			supports: []
		};

	$rootScope.targets = { // EVERY target that the user has added
		nukes: [],
		nobles: [],
		supports: []
	};
	$rootScope.targets_in_plan = { // Excludes targets that have been manually assigned
		nukes: [],
		nobles: [],
		supports: []
	};

	$rootScope.AttackTypes = AttackTypes;
	$rootScope.MetaData = MetaData;
	$rootScope.plan = null;

	$rootScope.username = MetaData.username;
	$rootScope.user_id = MetaData.user_id;
	$rootScope.last_updated = MetaData.last_updated;
}]);
