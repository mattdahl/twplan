/**
 * The controller for the Step One page of /plan
 */
TWP.twplan.Controllers.controller('StepOneController', ['$scope', 'VillagesRequest', 'GroupNames', 'Units', function ($scope, VillagesRequest, GroupNames, Units) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

	$scope.current_step = 1;

	$scope.village_paste_in_interface = new VillagePasteInInterface($scope);
	$scope.village_group_interface = new VillageGroupInterface($scope);

	$scope.group_names = [];

	$scope.Units = Units;

	$scope.search_term = '';

	$scope.paginated_villages = []; // Holds the villages paginated into arrays of length 20
	$scope.page_villages = []; // Holds the villages to be displayed on the current page

	$scope.search_villages = function () {
		if ($scope.search_term.length < 2) { // Need at least two characters to search (to minimize performance issues)
			return;
		}

		var search_results = [];

		for (var v in villages) {
			if (v.name.indexOf($scope.search_term) || (v.x_coord + '|' + v.y_coord).indexOf($scope.search_term) || v.continent.indexOf($scope.search_term)) {
				search_results.push(v);
			}
		}

		$scope.paginate_villages(search_results);
		$scope.switch_page(1);
	};

	$scope.paginate_villages = function (villages) {
		for (var v in villages) {
			var index = parseInt(villages.length / 20, 10);
			if ($scope.paginated_villages[index]) {
				$scope.paginated_villages[index].push(v);
			} else {
				$scope.paginated_villages[index] = [v];
			}
		}
	};

	$scope.switch_page = function (index) {
		$scope.page_villages = $scope.paginate_villages[index - 1];
	};

	$scope.submitStepOne = function () {
		if ($scope.villages_in_plan.nukes.length + $scope.villages_in_plan.nobles.length + $scope.villages_in_plan.supports.length === 0) {
			alert("You haven't added any villages! Please choose at least one.");
			return false;
		}

		window.location.href = 'plan#/step_two';
	};

	// Checks if villages have already been loaded (i.e. returning from step two or three)
	if ($scope.villages.length === 0) {
		VillagesRequest.query() // Returns a promise object
		.then(function (data) { // Success
			$.each(data, function (index, element) {
				$scope.villages.push(new Village(
					$scope,
					element.village_id,
					element.village_name.replace(/\+/g, ' '),
					element.x_coord,
					element.y_coord,
					'K' + element.y_coord.substring(0, 1) + element.x_coord.substring(0, 1),
					null,
					null));

				debugger;

				$scope.paginate_villages($scope.villages);
				$scope.page_villages = $scope.paginated_villages[0];
			});
		}, function (data) { // Error
			debugger;
		});
	}

	// Checks if group name have already been loaded (i.e. returning from step two or three)
	if (!$scope.group_names) {
		GroupNames.getGroupNames() // Returns a promise object
			.then(function (data) { // Success
				$scope.group_names = data;
				debugger;
			}, function (data) { // Error
				debugger;
			});
	}

}]);

/**
 * The controller for the Step Two page
 */
TWP.twplan.Controllers.controller('StepTwoController', ['$scope', function ($scope) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

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

		window.location.href = 'plan#/step_three';
	};
}]);

/**
 * The controller for the Step Three page
 */
TWP.twplan.Controllers.controller('StepThreeController', ['$rootScope', '$scope', 'WorldInfo', 'PairCalculator', function ($rootScope, $scope, WorldInfo, PairCalculator) {
	$scope.$watch(function() { console.log("A digest was executed!"); });

	$scope.current_step = 3;

	$scope.landing_date = '';
	$scope.landing_time = '';
	$scope.optimization_checked = false;
	$scope.early_bound;
	$scope.late_bound;

	$scope.toggle_launch_time_optimization_details = function () {
		$('#launch_time_optimization_details').toggle();
	};

	$scope.submitStepThree = function () {
		if ($scope.landing_date == '') {
			alert("Please enter landing date information.");
			return false;
		}
		else if (!$scope.landing_time.match(/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/)) {
			alert("TWplan doesn't recognize the time you submitted. Please use hh:mm:ss format.");
			return false;
		}

		$scope.calculate_plan();

		window.location.href = 'plan#/results';
	};

	$scope.calculate_plan = function () {
		$scope.configure_dst_lookup();

		var landing_datetime = new Date($scope.landing_date + ' ' + $scope.landing_time);

/*
		if ($scope.optimization_checked) {
			// Returns an array where index=village location and value=target location
			var paired_nukes = hungarian($scope.villages_in_plan.nukes, $scope.targets_in_plan.nukes, landing_datetime, $scope.early_bound, $scope.late_bound);
			var paired_nobles = hungarian($scope.villages_in_plan.nobles, $scope.targets_in_plan.nobles, landing_datetime, $scope.early_bound, $scope.late_bound);
			var paired_supports = hungarian($scope.villages_in_plan.supports, $scope.targets_in_plan.supports, landing_datetime, $scope.early_bound, $scope.late_bound);
		}
		else {
			// Returns an array where index=village location and value=target location
			var paired_nukes = hungarian($scope.villages_in_plan.nukes, $scope.targets_in_plan.nukes, landing_datetime);
			var paired_nobles = hungarian($scope.villages_in_plan.nobles, $scope.targets_in_plan.nobles, landing_datetime);
			var paired_supports = hungarian($scope.villages_in_plan.supports, $scope.targets_in_plan.supports, landing_datetime);

		}
		*/

		var assigned_nuke_villages = [], unassigned_nuke_villages = [];
		var assigned_noble_villages = [], unassigned_noble_villages = [];
		var assigned_support_villages = [], unassigned_support_villages = [];

		for (var i = 0; i < $scope.villages_in_plan.nukes.length; i++) {
			if ($scope.villages_in_plan.nukes[i].manual_target && $scope.villages_in_plan.nukes[i].manual_target.scope) {
				assigned_nuke_villages.push($scope.villages_in_plan.nukes[i]);
			}
			else {
				unassigned_nuke_villages.push($scope.villages_in_plan.nukes[i]);
			}
		}
		for (var i = 0; i < $scope.villages_in_plan.nobles.length; i++) {
			if ($scope.villages_in_plan.nobles[i].manual_target && $scope.villages_in_plan.nobles[i].manual_target.scope) {
				assigned_noble_villages.push($scope.villages_in_plan.nobles[i]);
			}
			else {
				unassigned_noble_villages.push($scope.villages_in_plan.nobles[i]);
			}
		}
		for (var i = 0; i < $scope.villages_in_plan.supports.length; i++) {
			if ($scope.villages_in_plan.supports[i].manual_target && $scope.villages_in_plan.supports[i].manual_target.scope) {
				assigned_support_villages.push($scope.villages_in_plan.supports[i]);
			}
			else {
				unassigned_support_villages.push($scope.villages_in_plan.supports[i]);
			}
		}

		/*

		var paired_nukes = [];
		var paired_nobles = [];
		var paired_supports = [];

		if ($scope.optimization_checked) {
			// Returns an array where index=village location and value=target location
			paired_nukes = PairCalculator.pair(unassigned_nuke_villages, $scope.targets_in_plan.nukes, landing_datetime, $scope.early_bound, $scope.late_bound);
			paired_nobles = PairCalculator.pair(unassigned_noble_villages, $scope.targets_in_plan.nobles, landing_datetime, $scope.early_bound, $scope.late_bound);
			paired_supports = PairCalculator.pair(unassigned_support_villages, $scope.targets_in_plan.supports, landing_datetime, $scope.early_bound, $scope.late_bound);
		}
		else {
			// Returns an array where index=village location and value=target location
			paired_nukes = PairCalculator.pair(unassigned_nuke_villages, $scope.targets_in_plan.nukes, landing_datetime);
			paired_nobles = PairCalculator.pair(unassigned_noble_villages, $scope.targets_in_plan.nobles, landing_datetime);
			paired_supports = PairCalculator.pair(unassigned_support_villages, $scope.targets_in_plan.supports, landing_datetime);

		}
		*/

		$rootScope.plan = new Plan(
			$rootScope,
			"Attack Plan Landing on " + $scope.landing_date + " at " + $scope.landing_time + " (ST)",
			landing_datetime
		);

		// Adds the paired commands to the plan
		/*
		for (var i = 0; i < paired_nukes.length; i++) {
			var traveling_time = $scope.calculate_traveling_time(paired_nukes[i][0], paired_nukes[i][1]);
			debugger;
			$rootScope.plan.commands.push(new Command(
				$scope,
				$scope.villages_in_plan.nukes[i],
				$scope.targets_in_plan.nukes[paired_nukes[i]],
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				)
			);
		}
		for (var i = 0; i < paired_nobles.length; i++) {
			var traveling_time = $scope.calculate_traveling_time(paired_nobles[i][0], paired_nobles[i][1]);

			$rootScope.plan.commands.push(new Command(
				$scope,
				$scope.villages_in_plan.nobles[i],
				$scope.targets_in_plan.nobles[paired_nobles[i]],
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				)
			);
		}
		for (var i = 0; i < paired_supports.length; i++) {
			var traveling_time = $scope.calculate_traveling_time(paired_supports[i][0], paired_supports[i][1]);

			$rootScope.plan.commands.push(new Command(
				$scope,
				$scope.villages_in_plan.supports[i],
				$scope.targets_in_plan.supports[paired_supports[i]],
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				)
			);
		}
		*/

		// Adds the manually assigned commands to the plan
		for (var i = 0; i < assigned_nuke_villages.length; i++) {
			var target = new Target(
				assigned_nuke_villages[i].manual_target.scope,
				assigned_nuke_villages[i].manual_target.x_coord,
				assigned_nuke_villages[i].manual_target.y_coord,
				assigned_nuke_villages[i].manual_target.continent,
				assigned_nuke_villages[i].manual_target.attack_type
			);

			var traveling_time = $scope.calculate_traveling_time(assigned_nuke_villages[i], target);

			$rootScope.plan.commands.push(new Command(
				$scope,
				assigned_nuke_villages[i],
				target,
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				)
			);
		}
		for (var i = 0; i < assigned_noble_villages.length; i++) {
			var target = new Target(
				assigned_noble_villages[i].manual_target.scope,
				assigned_noble_villages[i].manual_target.x_coord,
				assigned_noble_villages[i].manual_target.y_coord,
				assigned_noble_villages[i].manual_target.continent,
				assigned_noble_villages[i].manual_target.attack_type
			);

			var traveling_time = $scope.calculate_traveling_time(assigned_noble_villages[i], target);

			$rootScope.plan.commands.push(new Command(
				$scope,
				assigned_noble_villages[i],
				target,
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				)
			);
		}
		for (var i = 0; i < assigned_support_villages.length; i++) {
			var target = new Target(
				assigned_support_villages[i].manual_target.scope,
				assigned_support_villages[i].manual_target.x_coord,
				assigned_support_villages[i].manual_target.y_coord,
				assigned_support_villages[i].manual_target.continent,
				assigned_support_villages[i].manual_target.attack_type
			);

			var traveling_time = $scope.calculate_traveling_time(assigned_support_villages[i], target);

			$rootScope.plan.commands.push(new Command(
				$scope,
				assigned_support_villages[i],
				target,
				traveling_time,
				$scope.calculate_launch_time(landing_datetime, traveling_time)
				)
			);
		}

		$rootScope.plan.sort();
	};

	$scope.calculate_launch_time = function (landing_datetime, traveling_time) {
		var n = new Date();
		var offset;

		if (n.isDST()) {
			offset = (n.getTimezoneOffset() / 60) + 1;
		}
		else {
			offset = n.getTimezoneOffset() / 60;
		}
		// Gets difference; positive if west of UTC, negative if east
		// +1 when daylight savings is active!

		var before_offset = new Date(landing_datetime - traveling_time);

		return new Date(before_offset.setHours(before_offset.getHours() + offset));
	};

	$scope.calculate_traveling_time = function (village, target) {
		var distance = Math.sqrt(Math.pow(village.x_coord - target.x_coord, 2) + Math.pow(village.y_coord - target.y_coord, 2));

		return new Date(((distance * village.slowest_unit.speed) / (WorldInfo[$scope.current_world].speed * WorldInfo[$scope.current_world].unitSpeed)) * 60 * 1000);
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

	$scope.configure_dst_lookup = function () {
		Date.prototype.stdTimezoneOffset = function () {
			var jan = new Date(this.getFullYear(), 0, 1);
			var jul = new Date(this.getFullYear(), 6, 1);
			return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
		};

		Date.prototype.isDST = function () {
			return this.getTimezoneOffset() < this.stdTimezoneOffset();
		};
	};
}]);

/**
 * The controller for the Results page
 */
TWP.twplan.Controllers.controller('ResultsController', ['$scope', 'PlanRequest', function ($scope, PlanRequest) {
	$scope.$watch(function () { console.log("A digest was executed!"); });

	$scope.current_step = 4;

	$scope.countdown_timeout = null;

	$scope.table_export = $scope.plan.export_as_table();
	$scope.text_export = $scope.plan.export_as_text();

	$scope.saved_plan_name = '';
	$scope.save_status = '';

	$scope.recalculate_plan = function () {

	};

	$scope.save_plan = function () {
		$('#loadingcircle').show();

		PlanRequest.save($scope.saved_plan_name, $scope.plan) // Returns a promise object
		.then(function (data) { // Success
			$scope.save_status = 'Success! Your plan ' + data + ' has been saved. Go to the saved tab to view it.';
			$scope.saved_plan_name = '';
			$('#loadingcircle').hide();
			debugger;
		}, function (data) { // Error
			$('#loadingcircle').hide();
			debugger;
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

	if ($scope.countdown_timeout) {
		clearInterval($scope.countdown_timeout);
	}

	$scope.countdown();
}]);