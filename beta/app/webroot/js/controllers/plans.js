/**
 * The controller for the /plans page
 */
TWP.twplan.Controllers.controller('PlansController', ['$scope', 'PlanRequest', function ($scope, PlanRequest) {
	$scope.plans = [{name: 'Choose a plan...'}];
	$scope.current_plan = $scope.plans[0];

	PlanRequest.query() // Returns a promise object
		.then(function (data) { // Success
			$.each(data, function (index, element) {
				$scope.plans.push(element.Plan);
				debugger;
			});
		}, function (data) { // Error
			debugger;
		});
}]);