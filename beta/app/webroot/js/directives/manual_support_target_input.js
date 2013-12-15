TWP.twplan.Directives.directive('manualSupportTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			// Initialize the autocomplete widget
			AutocompleteBuilder.support_autocomplete(elm);

			// The autocomplete widget mangles our custom Target object, so it is necessary to check the coords to determine equality
			scope.index_of_target = function (target) {
				if (!target) {
					return Infinity;
				}
				for (var i = 0; i < scope.targets_in_plan.supports.length; i++) {
					if (scope.targets_in_plan.supports[i].x_coord === target.x_coord && scope.targets_in_plan.supports[i].y_coord === target.y_coord) {
						return i;
					}
				}
				return Infinity;
			};

			scope.toggle_manually_assigned_state = function (target) {
				for (var i = 0; i < scope.targets.supports.length; i++) {
					if (scope.targets.supports[i].x_coord === target.x_coord && scope.targets.supports[i].y_coord === target.y_coord) {
						scope.targets.supports[i].is_manually_assigned = !scope.targets.supports[i].is_manually_assigned;
						break;
					}
				}
			};

			scope.update_manual_target = function (target) {
				// If this update is replacing an existing manual target, put the existing one back in the scope.targets_in_plan array
				if (scope.village.manual_target.scope) { // Checks to see if the manual_target variable holds a Target object and not merely a string
					var relinquished_target = new Target(
						scope.village.manual_target.scope,
						scope.village.manual_target.x_coord,
						scope.village.manual_target.y_coord,
						scope.village.manual_target.continent,
						scope.village.manual_target.attack_type
					);
					scope.targets_in_plan.supports.push(relinquished_target);

					// Toggle the state flag on both the relinquished target object and the new target object
					scope.$apply(function () {
						scope.toggle_manually_assigned_state(relinquished_target); // Relinquished target
						if (target) { // Make sure the relinquished target isn't merely being replaced
							scope.toggle_manually_assigned_state(target); // New target
						}
					});
				}
				else { // If this update is just adding a new target to a pristine state
					// Toggle the state flag on both the relinquished target object
					scope.$apply(function () {
						scope.toggle_manually_assigned_state(target); // New target
					});
				}

				// Remove the manual target from the scope.targets_in_plan.supports array
				scope.targets_in_plan.supports.splice(scope.index_of_target(target), 1);
				scope.village.manual_target = target;
			};

			scope.restore_manual_target = function () {
				// Foces the input to revert to the old target coords
				scope.$apply(function () {
					if (scope.village.manual_target.scope) {
						scope.village.manual_target.label = scope.village.manual_target.x_coord + '|' + scope.village.manual_target.y_coord;
					}
					else {
						scope.village.manual_target.label = '';
					}
				});
			};
		}
	};
}]);