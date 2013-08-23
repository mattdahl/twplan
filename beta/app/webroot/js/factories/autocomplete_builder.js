TWP.Plan.Factories.factory('AutocompleteBuilder', [function () {
	var nuke_input_select_callback = function () {
		for (var j = 0; j < $scope.targets.nukes.length; j++) {
			if ($scope.targets.nukes[j].x_coord === coord_components[0] && $scope.targets.nukes[j].y_coord === coord_components[1]) {
				target = $scope.targets.nukes[j];
				$scope.targets_in_plan.nukes.splice($scope.targets_in_plan.nukes.indexOf(target), 1);
				element.scope().manual_target = target;
				break;
			}
		}
		this.nuke_source = $scope.targets_in_plan.nukes;
		this.nuke_autocomplete();
	};

	var noble_input_select_callback = function () {
		for (var j = 0; j < $scope.targets.nobles.length; j++) {
			if ($scope.targets.nobles[j].x_coord === coord_components[0] && $scope.targets.nobles[j].y_coord === coord_components[1]) {
				target = $scope.targets.nobles[j];
				$scope.targets_in_plan.nobles.splice($scope.targets_in_plan.nobles.indexOf(target), 1);
				break;
			}
		}
		$scope.update_autocomplete_fields($('.noble_target_autocomplete'), $scope.targets_in_plan.nobles);
	};

	var support_input_select_callback = function () {
		for (var j = 0; j < $scope.targets.supports.length; j++) {
			if ($scope.targets.supports[j].x_coord === coord_components[0] && $scope.targets.supports[j].y_coord === coord_components[1]) {
				target = $scope.targets.supports[j];
				$scope.targets_in_plan.supports.splice($scope.targets_in_plan.supports.indexOf(target), 1);
				break;
			}
		}
		$scope.update_autocomplete_fields($('.support_target_autocomplete'), $scope.targets_in_plan.supports);
	};

	var nuke_source = [];
	var noble_source = [];
	var support_source = [];

	return {
		nuke_autocomplete: function (element) {
			var scope = element.$parent.scope();

			element.autocomplete({
				source: nuke_source,
				select: function () {
					for (var j = 0; j < scope.targets.nukes.length; j++) {
						if (scope.targets.nukes[j].x_coord === coord_components[0] && scope.targets.nukes[j].y_coord === coord_components[1]) {
							target = scope.targets.nukes[j];
							scope.targets_in_plan.nukes.splice(scope.targets_in_plan.nukes.indexOf(target), 1);
							element.scope().manual_target = target;
							break;
						}
					}
					this.nuke_source = scope.targets_in_plan.nukes;
					this.nuke_autocomplete(element);
				}
			});
		},
		noble_autocomplete: function (element) {
			element.autocomplete({
				source: noble_source,
				select: noble_input_select_callback
			});
		},
		support_autocomplete: function (element) {
			element.autocomplete({
				source: support_source,
				select: support_input_select_callback
			});
		},
		update_source: function () {

		}
	};
});