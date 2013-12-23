/**
 * The controller for the /groups page
 */
TWP.twplan.Controllers.controller('GroupsController', ['$scope', 'GroupRequest', function ($scope, GroupRequest) {
	$scope.groups = [];
	$scope.current_group = null;

	GroupRequest.query() // Returns a promise object
	.then(function (data) { // Success
		$.each(data, function (index, element) {
			$scope.plans.push(element);
			debugger;
		});
	}, function (data) { // Error
		debugger;
	});

	$scope.load_group = function (group) {
		$scope.current_group = group;
	};

	$scope.delete_group = function (group) {
		GroupRequest.destroy(group) // Returns a promise object
		.then(function (data) { // Success
			$scope.groups.slice($scope.groups.indexOf(group), 1);
			debugger;
		}, function (data) { // Error
			debugger;
		});
	};

	$scope.create_group = function () {

	};

}]);