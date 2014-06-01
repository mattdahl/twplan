/**
 * The controller for the Step One page of /plan
 */
TWP.twplan.Controllers.controller('StepOneController', ['$scope', '$location', 'VillagesRequest', 'GroupRequest', 'Units', function ($scope, $location, VillagesRequest, GroupRequest, Units) {
	$scope.current_step = 1;

	$scope.village_paste_in_interface = new VillagePasteInInterface($scope);
	$scope.village_group_interface = new VillageGroupInterface($scope);

	$scope.groups = [{name: 'Choose a group to add to your plan...'}];
	$scope.village_group_interface.selected_group = $scope.groups[0];

	$scope.Units = Units;

	$scope.search_term = '';

	$scope.paginated_villages = []; // Holds the villages paginated into arrays of length 20
	$scope.page_villages = []; // Holds the villages to be displayed on the current page
	$scope.current_page = 0;

	$scope.search_villages = function () {
		if ($scope.search_term.length === 0) { // Reset the display when the search box has been cleared
			$scope.paginate_villages($scope.villages);
			$scope.page_villages = $scope.paginated_villages[0];
		}
		else if ($scope.search_term.length < 2) { // Need at least two characters to search (to minimize performance issues)
			return;
		}

		var search_results = [];

		for (var i = 0; i < $scope.villages.length; i++) {
			if ($scope.villages[i].name.indexOf($scope.search_term) >= 0 || ($scope.villages[i].x_coord + '|' + $scope.villages[i].y_coord).indexOf($scope.search_term) >= 0 || $scope.villages[i].continent.indexOf($scope.search_term) >= 0) {
				search_results.push($scope.villages[i]);
			}
		}

		$scope.paginate_villages(search_results);
		$scope.switch_page(0);
	};

	$scope.paginate_villages = function (villages) {
		$scope.paginated_villages = [];

		if (!villages.length) {
			$scope.paginated_villages[0] = [{name: 'No search results.'}];
		}

		for (var i = 0; i < villages.length; i++) {
			var index = parseInt(i / 20, 10);
			if ($scope.paginated_villages[index]) {
				$scope.paginated_villages[index].push(villages[i]);
			} else {
				$scope.paginated_villages[index] = [villages[i]];
			}
		}
	};

	$scope.switch_page = function (index) {
		$scope.current_page = index;
		$scope.page_villages = $scope.paginated_villages[$scope.current_page];
	};

	$scope.sort_villages = function (villages) {
		villages.sort(function (a, b) {
			return a.name.localeCompare(b.name);
		});
	};

	$scope.submitStepOne = function () {
		if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length === 0) {
			alert("You haven't added any villages! Please choose at least one.");
			return false;
		}

		$location.path('/step_two');
	};

	// Checks if villages have already been loaded (i.e. returning from step two or three)
	if ($scope.villages.length === 0) {
		VillagesRequest.query() // Returns a promise object
		.then(function (data) { // Success
			if (!data.length) {
				alert('You don\'t have any villages on this world!');
				return false;
			}

			$.each(data, function (index, element) {
				$scope.villages.push(new Village(
					$scope,
					element.village_id,
					element.village_name.replace(/\+/g, ' '),
					element.x_coord,
					element.y_coord,
					'K' + element.y_coord.substring(0, 1) + element.x_coord.substring(0, 1),
					null,
					null
				));
			});
			$scope.sort_villages($scope.villages);
			$scope.paginate_villages($scope.villages);
			$scope.page_villages = $scope.paginated_villages[$scope.current_page];
		}, function (data) { // Error
			debugger;
		});
	}

	// Checks if group name have already been loaded (i.e. returning from step two or three)
	if ($scope.groups.length === 1) {
		GroupRequest.query() // Returns a promise object
			.then(function (data) { // Success
				$.each(data, function (index, element) {
					delete element._name_;
					element.villages = JSON.parse(element.villages);
					element.name = element.name + ' (' + element.villages.length + ' villages)';
					$scope.groups.push(element);
				});
				debugger;
			}, function (data) { // Error
				debugger;
			});
	}

}]);

/**
 * The controller for the Step Two page
 */
TWP.twplan.Controllers.controller('StepTwoController', ['$scope', '$location', function ($scope, $location) {
	$scope.current_step = 2;

	$scope.target_paste_in_interface = new TargetPasteInInterface($scope);

	/**
	 * Initialize all the tooltips on the page
	 */
	$('.tooltip').tooltip({
		show: false
	});

	$scope.submitStepTwo = function () {
		if ($scope.targets.nukes.length + $scope.targets.nobles.length + $scope.targets.supports.length === 0) {
			alert("You haven't added any targets! Please enter at least one.");
			return false;
		}
		else if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length < $scope.targets.nukes.length + $scope.targets.nobles.length + $scope.targets.supports.length) {
			alert("You've added more targets than you selected villages in Step One. Please remove some targets or go back and add more villages.");
			return false;
		}
		else if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length > $scope.targets.nukes.length + $scope.targets.nobles.length + $scope.targets.supports.length) {
			if (!confirm("You have more villages than targets! Is this okay?")) {
				return false;
			}
		}

		$location.path('/step_three');
	};
}]);

/**
 * The controller for the Step Three page
 */
TWP.twplan.Controllers.controller('StepThreeController', ['$rootScope', '$scope', '$location', 'PlanCalculator', function ($rootScope, $scope, $location, PlanCalculator) {
	$scope.current_step = 3;

	$scope.landing_date = '';
	$scope.landing_time = '';
	$scope.optimization_checked = false;
	$scope.early_bound = null;
	$scope.late_bound = null;

	$scope.submitStepThree = function () {
		if ($scope.landing_date === '') {
			alert("Please enter landing date information.");
			return false;
		}
		else if (!$scope.landing_time.match(/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/)) {
			alert("TWplan doesn't recognize the time you submitted. Please use hh:mm:ss format.");
			return false;
		}

		var landing_datetime = new Date($scope.landing_date + ' ' + $scope.landing_time);
		$rootScope.plan = new Plan(
			$rootScope,
			"Attack Plan Landing on " + $scope.landing_date + " at " + $scope.landing_time + " (ST)",
			landing_datetime
		);

		PlanCalculator.calculate_plan($scope, landing_datetime);
		$rootScope.plan.sort();

		$location.path('/results');
	};

	$scope.format_seconds = function (secs) {
		var pad = function (n) {
			return (n < 10 ? "0" + n : n);
		};

		var h = Math.floor(secs / 3600);
		var m = Math.floor((secs / 3600) % 1 * 60);
		var s = Math.floor((secs / 60) % 1 * 60);

		return pad(h) + ":" + pad(m) + ":" + pad(s);
	};
}]);

/**
 * The controller for the Results page
 */
TWP.twplan.Controllers.controller('ResultsController', ['$rootScope', '$scope', 'PlanRequest', 'PlanCalculator', function ($rootScope, $scope, PlanRequest, PlanCalculator) {
	$scope.current_step = 4;

	$scope.new_landing_date = '';
	$scope.new_landing_time = '';
	$scope.optimization_checked = false;
	$scope.early_bound = null;
	$scope.late_bound = null;

	$scope.countdown_timeout = null;

	$scope.table_export = $scope.plan.export_as_table();
	$scope.text_export = $scope.plan.export_as_text();

	$scope.saved_plan_name = '';

	/**
	 * Initialize all the tooltips on the page
	 */
	$('.tooltip').tooltip({
		show: false
	});

	$scope.format_local_launchtime = function (date) {
		var launchtime = new Date(date);
		var local_launchtime = new Date(launchtime.setHours(launchtime.getHours() + $scope.MetaData.local_timezone));
		return local_launchtime.toString().slice(0, 24);
	};

	$scope.recalculate_plan = function () {
		var landing_datetime = new Date($scope.new_landing_date + ' ' + $scope.new_landing_time);

		$rootScope.plan = new Plan(
			$rootScope,
			"Attack Plan Landing on " + $scope.new_landing_date + " at " + $scope.new_landing_time + " (ST)",
			landing_datetime
		);

		PlanCalculator.calculate_plan($scope, landing_datetime);
		$rootScope.plan.sort();
	};

	$scope.save_plan = function () {
		$('#loadingcircle').show();

		PlanRequest.save($scope.saved_plan_name, $scope.plan) // Returns a promise object
		.then(function (data) { // Success
			alert('Success! Your plan ' + data + ' has been saved. Go to the saved tab to view it.');
			$scope.saved_plan_name = '';
			$('#loadingcircle').hide();
		}, function (jqXHR, t, e) { // Error
			alert('Something went wrong! Error:\n' + (jqXHR.responseText || e));
			$('#loadingcircle').hide();
		});
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

	$scope.countdown = function () {
		$scope.countdown_timeout = setInterval(function () {
			$scope.$apply(function () {
				for (var i = 0; i < $scope.plan.commands.length; i++) {
					$scope.plan.commands[i].decrement_time_remaining();
				}
			});
		},
		1000);
	};

	$scope.$on('$locationChangeStart', function (event) {
		clearInterval($scope.countdown_timeout);
	});

	if ($scope.countdown_timeout) {
		clearInterval($scope.countdown_timeout);
	}

	$scope.countdown();
}]);