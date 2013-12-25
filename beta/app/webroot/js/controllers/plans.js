/**
 * The controller for the /plans page
 */
TWP.twplan.Controllers.controller('PlansController', ['$scope', 'PlanRequest', 'Units', function ($scope, PlanRequest, Units) {
	$scope.plans = [{name: 'Choose a plan...'}];
	$scope.current_plan = $scope.plans[0];
	$scope.countdown_timeout = null;

	PlanRequest.query() // Returns a promise object
	.then(function (data) { // Success
		$.each(data, function (index, element) {
			var plan = element.Plan;

			$.each(plan.commands, function (index, command) {
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

			$scope.plans.push(plan);
			debugger;
		});
	}, function (data) { // Error
		debugger;
	});

	/**
	 * Initialize all the tooltips on the page
	 */
	$('.tooltip').tooltip({
		show: false
	});

	$scope.countdown = function () {
		if ($scope.countdown_timeout) {
			clearInterval($scope.countdown_timeout);
		}

		$scope.countdown_timeout = setInterval(function () {
			$scope.$apply(function () {
				for (var i = 0; i < $scope.current_plan.commands.length; i++) {
					$scope.current_plan.commands[i].decrement_time_remaining();
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
}]);