/**
 * The controller for the /plans page
 */
TWP.twplan.Controllers.controller('PlansController', ['$scope', 'PlanRequest', function ($scope, PlanRequest) {
	$scope.plans = [];
	$scope.current_plan = null;

	PlanRequest.query() // Returns a promise object
		.then(function (data) { // Success
			$.each(data, function (index, element) {
				$scope.plans.push(element);
				debugger;
			});
		}, function (data) { // Error
			debugger;
		});
}]);