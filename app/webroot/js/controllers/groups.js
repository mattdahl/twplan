/**
 * The controller for the /groups page
 */
TWP.twplan.Controllers.controller('GroupsController', ['$scope', 'GroupRequest', 'VillagesRequest', function ($scope, GroupRequest, VillagesRequest) {
	$scope.villages = [];
	$scope.available_villages = [];
	$scope.search_term = '';
	$scope.paginated_available_villages = []; // Holds the villages paginated into arrays of length 20
	$scope.page_available_villages = []; // Holds the villages to be displayed on the current page
	$scope.current_page = 0;

	$scope.groups = [{name: 'Choose a group...'}];
	$scope.current_group = $scope.groups[0];
	$scope.new_group_name = '';
	$scope.new_group = null;
	$scope.should_show_instructions = true;

	GroupRequest.query() // Returns a promise object
	.then(function (data) { // Success
		$.each(data, function (index, element) {
			delete element._name_;
			element.villages = JSON.parse(element.villages);
			element.remove_village = function (village) {
				this.villages.splice(this.villages.indexOf(village), 1);
			};
			$scope.groups.push(element);
			debugger;
		});
	}, function (data) { // Error
		debugger;
	});

	VillagesRequest.query() // Returns a promise object
	.then(function (data) { // Success
		$.each(data, function (index, element) {
			$scope.villages.push({
				name: element.village_name.replace(/\+/g, ' '),
				village_id: element.village_id,
				coordinates: element.x_coord + '|' + element.y_coord,
				continent: 'K' + element.y_coord.substring(0, 1) + element.x_coord.substring(0, 1),
				add_to_group: function () {
					$scope.new_group.villages.push(this);
					$scope.available_villages.splice($scope.available_villages.indexOf(this), 1);
					$scope.paginate_villages($scope.available_villages);
					$scope.page_available_villages = $scope.paginated_available_villages[$scope.current_page];
				},
				remove_from_group: function () {
					$scope.available_villages.push(this);
					$scope.new_group.villages.splice($scope.new_group.villages.indexOf(this), 1);
					$scope.sort_villages($scope.available_villages);
					$scope.paginate_villages($scope.available_villages);
					$scope.page_available_villages = $scope.paginated_available_villages[$scope.current_page];
				}
			});
		});
		$scope.sort_villages($scope.villages);
		$scope.available_villages = $scope.villages;
		$scope.paginate_villages($scope.available_villages);
		$scope.page_available_villages = $scope.paginated_available_villages[$scope.current_page];
	}, function (data) { // Error
		debugger;
	});

	$scope.sort_villages = function (villages) {
		villages.sort(function (a, b) {
			return a.name.localeCompare(b.name);
		});
	};

	$scope.load_group = function () {
		$scope.should_show_instructions = false;
		history.pushState(null, null, 'groups/group/' + $scope.current_group.id);
	};

	$scope.return_to_instructions = function () {
		$scope.current_group = $scope.groups[0];
		$scope.should_show_instructions = true;
	};

	$(window).on('popstate', function (e) {
		if ($scope.new_group && confirm('You haven\'t saved your new group! Are you sure you want to navigate away?')) {
			$scope.new_group = null;
			$scope.$apply(function () {
				$scope.return_to_instructions();
			});
		}
		else if ($scope.new_group) {
			history.pushState(null, null, 'groups/new_group');
		}
		else {
			$scope.$apply(function () {
				$scope.return_to_instructions();
			});
		}
	});

	$(window).on('beforeunload', function (e) {
		if ($scope.new_group) {
			return 'You haven\'t saved your new group! Are you sure you want to nagivate away?';
		}
		else if ($scope.current_group != $scope.groups[0]) {
			return 'You haven\'t saved your changes! Are you sure you want to nagivate away?';
		}
	});

	$scope.delete_group = function (group) {
		GroupRequest.destroy(group.id) // Returns a promise object
		.then(function (data) { // Success
			$scope.groups.splice($scope.groups.indexOf(group), 1);
			$scope.return_to_instructions();
			debugger;
		}, function (data) { // Error
			debugger;
		});
	};

	$scope.create_group = function () {
		$scope.should_show_instructions = false;
		$scope.new_group = {
			name: $scope.new_group_name,
			villages: []
		};
		history.pushState(null, null, 'groups/new_group');
	};

	$scope.save_group = function (group) {
		GroupRequest.save(group) // Returns a promise object
		.then(function (data) { // Success
			$scope.new_group.date_created = (new Date()).toString().slice(0, 24);
			$scope.new_group.date_last_updated = (new Date()).toString().slice(0, 24);
			$scope.groups.push($scope.new_group);
			$scope.new_group = null;
			$scope.new_group_name = '';
			$scope.return_to_instructions();
			debugger;
		}, function (data) { // Error
			debugger;
		});
	};

	$scope.update_group = function (group) {
		GroupRequest.update(group.id, group) // Returns a promise object
		.then(function (data) { // Success
			$scope.current_group.date_last_updated = new Date();
			$scope.return_to_instructions();
			debugger;
		}, function (data) { // Error
			debugger;
		});
	};

	$scope.search_villages = function () {
		if ($scope.search_term.length === 0) { // Reset the display when the search box has been cleared
			$scope.paginate_villages($scope.available_villages);
			$scope.page_available_villages = $scope.paginated_available_villages[0];
		}
		else if ($scope.search_term.length < 2) { // Need at least two characters to search (to minimize performance issues)
			return;
		}

		var search_results = [];

		for (var i = 0; i < $scope.available_villages.length; i++) {
			if ($scope.available_villages[i].name.indexOf($scope.search_term) >= 0 || ($scope.available_villages[i].x_coord + '|' + $scope.available_villages[i].y_coord).indexOf($scope.search_term) >= 0 || $scope.available_villages[i].continent.indexOf($scope.search_term) >= 0) {
				search_results.push($scope.available_villages[i]);
			}
		}

		$scope.paginate_villages(search_results);
		$scope.switch_page(0);
	};

	$scope.switch_page = function (index) {
		$scope.current_page = index;
		$scope.page_available_villages = $scope.paginated_available_villages[$scope.current_page];
	};

	$scope.paginate_villages = function (villages) {
		$scope.paginated_available_villages = [];

		if (!villages.length) {
			$scope.paginated_available_villages[0] = [{name: 'No search results.'}];
		}

		for (var i = 0; i < villages.length; i++) {
			var index = parseInt(i / 20, 10);
			if ($scope.paginated_available_villages[index]) {
				$scope.paginated_available_villages[index].push(villages[i]);
			} else {
				$scope.paginated_available_villages[index] = [villages[i]];
			}
		}
	};
}]);