/**
 * The controller for the /plans page
 */
TWP.twplan.Controllers.controller('PlansController', ['$scope', 'PlanRequest', 'Units', function ($scope, PlanRequest, Units) {
	$scope.plans = [{name: 'Choose a plan...'}];
	$scope.current_plan = $scope.plans[0];
	$scope.countdown_timeout = null;

	PlanRequest.query() // Returns a promise object
	.then(function (data) { // Success
		$.each(data, function (index, plan) {
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

			plan.remove_command = function (command) {
				this.commands.splice(this.commands.indexOf(command), 1);
				$scope.update_plan(this);
			};

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

	$scope.delete_plan = function () {
		PlanRequest.destroy($scope.current_plan.id) // Returns a promise object
		.then(function (data) { // Success
			debugger;
			alert('Plan "' + $scope.current_plan.name + '" deleted!');
			$scope.plans.splice($scope.plans.indexOf($scope.current_plan), 1);
		}, function (data) { // Error
			debugger;
		});
	};

	$scope.publish_plan = function () {
		PlanRequest.update($scope.current_plan.id, $scope.current_plan) // Returns a promise object
		.then(function (data) { // Success
			debugger;
			$scope.current_plan.published_hash = data.published_hash;
		}, function (data) { // Error
			debugger;
		});
	};

	$scope.update_plan = function (plan) {
		PlanRequest.update(plan.id, plan) // Returns a promise object
		.then(function (data) { // Success
			debugger;
		}, function (data) { // Error
			debugger;
		});
	};

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