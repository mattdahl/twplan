/**
 * The controller for the header
 */
TWP.Header.controller('WelcomeController', ['$scope', '$http', 'MetaData', function ($scope, $http, MetaData) {
	$scope.username = MetaData.username;
	$scope.current_world = MetaData.current_world;
	$scope.last_updated = MetaData.last_updated;

	$scope.worlds = [
		19,
		30,
		38,
		42,
		46,
		48,
		56,
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
			'/settings/set_current_world',
			{world: $scope.current_world}
		).success(function (data, status, headers, config) {
			debugger;
			location.reload();
		}).error(function (data, status, headers, config) {
			alert(data + '\n' + status + '\n' + headers + '\n' + config);
		});
	};
}]);