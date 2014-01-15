/**
 * The controller for the /settings page
 */
TWP.twplan.Controllers.controller('SettingsController', ['$scope', '$http', function ($scope, $http) {
	$scope.worlds = [
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

	$scope.timezones = [
		{name: 'GMT', offset: 0},
		{name: 'GMT+1 (CET)', offset: 1},
		{name: 'GMT+2 (EET)', offset: 2},
		{name: 'GMT+3 (BT)', offset: 3},
		{name: 'GMT+4 (ZP4)', offset: 4},
		{name: 'GMT+5 (ZP5)', offset: 5},
		{name: 'GMT+5:30 (IST)', offset: 5.5},
		{name: 'GMT+6 (ZP6)', offset: 6},
		{name: 'GMT+7 (CXT)', offset: 7},
		{name: 'GMT+8 (AWST)', offset: 8},
		{name: 'GMT+9 (JSP)', offset: 9},
		{name: 'GMT+10 (EAST)', offset: 10},
		{name: 'GMT+11', offset: 11},
		{name: 'GMT+12 (NZST)', offset: 12},
		{name: 'GMT-1 (WAT)', offset: -1},
		{name: 'GMT-2 (AT)', offset: -2},
		{name: 'GMT-3', offset: -3},
		{name: 'GMT-4 (AST)', offset: -4},
		{name: 'GMT-5 (EST)', offset: -5},
		{name: 'GMT-6 (CST)', offset: -6},
		{name: 'GMT-7 (MST)', offset: -7},
		{name: 'GMT-8 (PST)', offset: -8},
		{name: 'GMT-9 (AKST)', offset: -9},
		{name: 'GMT-10 (HST)', offset: -10},
		{name: 'GMT-11 (NT)', offset: -11},
	];

	$scope.timezone_in_array = function (timezone) {
		for (var i = 0; i < $scope.timezones.length; i++) {
			if ($scope.timezones[i].offset == timezone.offset) {
				return $scope.timezones[i];
			}
		}
		return null;
	};

	$scope.default_world = $scope.MetaData.default_world;
	$scope.local_timezone = $scope.timezone_in_array({offset: $scope.MetaData.local_timezone});

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