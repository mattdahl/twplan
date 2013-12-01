// TWP is the twplan.com namespace
// twplan is an Angular object representing a module
// Propeties on the twplan object are its controllers, factories, directives, etc. modulated for dependency injection

var TWP = TWP || {};

TWP.twplan = angular.module('twplan_app', ['twplan_app.controllers']);
TWP.twplan.Controllers = angular.module('twplan_app.controllers', ['twplan_app.factories'], ['twplan_app.directives']);
TWP.twplan.Factories = angular.module('twplan_app.factories', []);
TWP.Plan.Directives = angular.module('twplan_app.directives');

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
		.otherwise({redirectTo: '/step_one'});
}]);

/**
 * Once the twplan module has been initialized and the DOM has loaded, sets up the $rootScope variables
 */
TWP.twplan.run(['$rootScope', 'MetaData', function ($rootScope, MetaData) {
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

	$rootScope.plan = null;
	$rootScope.instructions = 'Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!\n\nTWplan\'s algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound".';

	$rootScope.username = MetaData.username;
	$rootScope.user_id = MetaData.user_id;
	$rootScope.current_world = MetaData.current_world;
	$rootScope.last_updated = MetaData.last_updated;
}]);
