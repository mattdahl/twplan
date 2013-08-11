/**
 * The controller for the header
 */
TWP.Header.controller('WelcomeController', ['$scope', '$http', function ($scope, $http) {
	$scope.username = $('meta[name=username]').attr('content');
	$scope.current_world = parseInt($('meta[name=current_world]').attr('content'));

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