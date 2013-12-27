/**
 * The controller for the /groups page
 */
TWP.twplan.Controllers.controller('GroupsController', ['$scope', 'GroupRequest', 'VillagesRequest', function ($scope, GroupRequest, VillagesRequest) {
	$scope.villages = [];
	$scope.available_villages = [];
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
				},
				remove_from_group: function () {
					$scope.available_villages.push(this);
					$scope.new_group.villages.splice($scope.available_villages.indexOf(this), 1);
				}
			});
		});
		$scope.sort_villages($scope.villages);
		$scope.available_villages = $scope.villages;
	}, function (data) { // Error
		debugger;
	});

	$scope.sort_villages = function (villages) {
		villages.sort(function (a, b) {
			return a.name.localeCompare(b.name);
		});
	};

	$scope.load_group = function (group) {
		$scope.should_show_instructions = false;
	};

	$scope.delete_group = function (group) {
		GroupRequest.destroy(group.id) // Returns a promise object
		.then(function (data) { // Success
			$scope.groups.splice($scope.groups.indexOf(group), 1);
			$scope.current_group = $scope.groups[0];
			$scope.should_show_instructions = true;
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
	};

	$scope.save_group = function (group) {
		GroupRequest.save(group) // Returns a promise object
		.then(function (data) { // Success
			$scope.new_group.date_created = new Date();
			$scope.new_group.date_last_updated = new Date();
			$scope.groups.push($scope.new_group);
			$scope.new_group = null;
			$scope.new_group_name = '';
			$scope.should_show_instructions = true;
			debugger;
		}, function (data) { // Error
			debugger;
		});
	};

}]);