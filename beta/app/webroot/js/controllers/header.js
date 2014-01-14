/**
 * The controller for the header
 */
TWP.twplan.controller('HeaderController', ['$scope', '$http', function ($scope, $http) {
	$scope.worlds = [
		19,
		58,
		60,
		64,
		65,
		66,
		67,
		68,
		69,
		70,
		71,
		72
	];

	$scope.change_world = function () {
		$http.post(
			'settings/set_current_world',
			{world: $scope.current_world}
		).success(function (data, status, headers, config) {
			debugger;
			location.reload();
		}).error(function (data, status, headers, config) {
			alert(data + '\n' + status + '\n' + headers + '\n' + config);
		});
	};
}]);