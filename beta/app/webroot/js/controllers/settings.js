/**
 * The controller for the /settings page
 */
TWP.twplan.Controllers.controller('SettingsController', ['$scope', '$http', 'MetaData', function ($scope, $http, MetaData) {
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

	$scope.timezones = [
		{name: 'GMT'},
		{name: 'GMT+1 (CET)'},
		{name: 'GMT+2 (EET)'},
		{name: 'GMT+3 (BT)'},
		{name: 'GMT+4 (ZP4)'},
		{name: 'GMT+5 (ZP5)'},
		{name: 'GMT+5:30 (IST)'},
		{name: 'GMT+6 (ZP6)'},
		{name: 'GMT+7 (CXT)'},
		{name: 'GMT+8 (AWST)'},
		{name: 'GMT+9 (JSP)'},
		{name: 'GMT+10 (EAST)'},
		{name: 'GMT+11'},
		{name: 'GMT+12 (NZST)'},
		{name: 'GMT-1 (WAT)'},
		{name: 'GMT-2 (AT)'},
		{name: 'GMT-3'},
		{name: 'GMT-4 (AST)'},
		{name: 'GMT-5 (EST)'},
		{name: 'GMT-6 (CST)'},
		{name: 'GMT-7 (MST)'},
		{name: 'GMT-8 (PST)'},
		{name: 'GMT-9 (AKST)'},
		{name: 'GMT-10 (HST)'},
		{name: 'GMT-11 (NT)'},
	];

	$scope.timezone_in_array = function (timezone) {
		for (var i = 0; i < $scope.timezones.length; i++) {
			if ($scope.timezones[i].name == timezone.name) {
				return $scope.timezones[i];
			}
		}
		return null;
	};

	$scope.default_world = parseInt(MetaData.default_world, 10);
	$scope.local_timezone = $scope.timezone_in_array({name: MetaData.local_timezone});

	$scope.change_local_timezone = function () {
		$http.post(
			'settings/set_local_timezone',
			{local_timezone: $scope.local_timezone}
		).success(function (data, status, headers, config) {
			debugger;
		}).error(function (data, status, headers, config) {
			debugger;
		});
	};

	$scope.change_default_world = function () {
		$http.post(
			'settings/set_default_world',
			{default_world: $scope.default_world}
		).success(function (data, status, headers, config) {
			debugger;
		}).error(function (data, status, headers, config) {
			debugger;
		});
	};
}]);