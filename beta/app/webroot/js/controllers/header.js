/**
 * The controller for the header
 */
TWP.twplan.controller('HeaderController', ['$scope', '$http', function ($scope, $http) {
	$scope.worlds = [
		{world: 1, server: 'casual'},
		{world: 2, server: 'casual'},
		{world: 60, server: 'en'},
		{world: 64, server: 'en'},
		{world: 65, server: 'en'},
		{world: 66, server: 'en'},
		{world: 67, server: 'en'},
		{world: 68, server: 'en'},
		{world: 69, server: 'en'},
		{world: 70, server: 'en'},
		{world: 71, server: 'en'},
		{world: 72, server: 'en'},
		{world: 73, server: 'en'},
		{world: 74, server: 'en'},
		{world: 75, server: 'en'}
	];

	// #CASUALWORLDHACK
	(function () {
		for (var i = 0; i < $scope.worlds.length; i++) {
			if ($scope.worlds[i].world === $scope.MetaData.current_world) {
				$scope.current_world = $scope.worlds[i];
				break;
			}
		}
	})();

	$scope.change_world = function () {
		$http.post(
			'settings/set_current_world',
			{world: $scope.current_world.world} // #CASUALWORLDHACK the backend doesn't know anything about the server property
		).success(function (data, status, headers, config) {
			debugger;
			location.reload();
		}).error(function (data, status, headers, config) {
			alert(data + '\n' + status + '\n' + headers + '\n' + config);
		});
	};
}]);