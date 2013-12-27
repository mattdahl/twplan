/**
 * The controller for the header
 */
TWP.twplan.controller('HeaderController', ['$rootScope', '$scope', '$http', function ($rootScope, $scope, $http) {
	$scope.worlds = [
		19,
		30,
		58,
		59,
		60,
		61,
		63,
		64,
		65,
		66,
		67,
		68,
		69,
		70
	];

	$scope.change_world = function () {
		$http.post(
			'settings/set_current_world',
			{world: $rootScope.current_world}
		).success(function (data, status, headers, config) {
			debugger;
			location.reload();
		}).error(function (data, status, headers, config) {
			alert(data + '\n' + status + '\n' + headers + '\n' + config);
		});
	};
}]);