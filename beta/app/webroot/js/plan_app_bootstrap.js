var TWP = TWP || {};

TWP.Plan = angular.module('plan_app', ['plan_app.controllers']);
TWP.Plan.Controllers = angular.module('plan_app.controllers', ['plan_app.factories'], ['plan_app.directives']);

TWP.Plan.Factories = angular.module('plan_app.factories', ['header_app.factories']);
TWP.Plan.Directives = angular.module('plan_app.directives');

/**
 * Provides configuration for the PlanModule, namely setting up route forwarding using $routeProvider for a single-page app experience
 */
TWP.Plan.config(['$routeProvider', function ($routeProvider) {
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
 * Once the PlanModule has been initialized and the DOM has loaded, sets up the $rootScope variables
 */
TWP.Plan.run(['$rootScope', 'AttackTypes', function ($rootScope, AttackTypes) {
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
	$rootScope.plan = null;
	$rootScope.instructions = 'Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!\n\nTWplan\'s algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound".';
	$rootScope.current_world = sessionStorage.currentWorld;
}]);

// Bootstraps the plan module (necessary because the header module is already on the page)
angular.element(document).ready(function () {
	angular.bootstrap($('#plan_module'), ['plan_app']);
});