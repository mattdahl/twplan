/**
 * The controller for the /public/plan page
 */
TWP.twplan.Controllers.controller('PublicPlansController', ['$scope', 'Units', '$window', function ($scope, Units, $window) {
	$scope.countdown_timeout = null;

	$scope.public_plan = $window.TWP.public_plan;

	$scope.countdown = function () {
		if ($scope.countdown_timeout) {
			clearInterval($scope.countdown_timeout);
		}

		$scope.countdown_timeout = setInterval(function () {
			$scope.$apply(function () {
				for (var i = 0; i < $scope.public_plan.commands.length; i++) {
					$scope.public_plan.commands[i].decrement_time_remaining();
				}
			});
		},
		1000);
	};

	$scope.format_seconds = function (secs) {
		if (secs == 'Expired!') {
			return 'Expired';
		}

		var pad = function (n) {
			return (n < 10 ? "0" + n : n);
		};

		var h = Math.floor(secs / 3600);
		var m = Math.floor((secs / 3600) % 1 * 60);
		var s = Math.floor((secs / 60) % 1 * 60);

		return pad(h) + ":" + pad(m) + ":" + pad(s);
	};

	$scope.slowest_unit_url_lookup = function (unit_id) {
		for (var unit in Units) {
			if (Units[unit].id == unit_id) {
				return Units[unit].url;
			}
		}
	};

	// Startup the countdown
	$.each($scope.public_plan.commands, function (index, command) {
		command.time_remaining = new Date(new Date(command.launch_datetime) - new Date()).getTime() / 1000; // Seconds
		command.decrement_time_remaining = function () {
			if (this.time_remaining > 0) {
				this.time_remaining--;
			}
			else {
				this.time_remaining = 'Expired!';
			}
		};
	});

	$scope.countdown();
}]);