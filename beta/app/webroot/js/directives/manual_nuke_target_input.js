TWP.twplan.Directives.directive('manualNukeTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			// Initialize the autocomplete widget
			AutocompleteBuilder.nuke_autocomplete(elm);

			// The autocomplete widget mangles our custom Target object, so it is necessary to check the _hash_id to determine equality
			scope.index_of_target = function (target, array) {
				if (!target) {
					return Infinity;
				}
				for (var i = 0; i < array.length; i++) {
					if (array[i]._hash_id === target._hash_id) {
						return i;
					}
				}
				return Infinity;
			};

			scope.toggle_manually_assigned_state = function (target) {
				for (var i = 0; i < scope.targets.nukes.length; i++) {
					if (scope.targets.nukes[i]._hash_id === target._hash_id) {
						scope.targets.nukes[i].is_manually_assigned = !scope.targets.nukes[i].is_manually_assigned;
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
						scope.village.manual_target.attack_type,
						scope.village.manual_target._hash_id
					);

					// If the target to be relinquished has been deleted from the plan altogether, don't push it back onto the array!
					if (scope.index_of_target(relinquished_target, scope.targets.nukes) != Infinity) {
						scope.targets_in_plan.nukes.push(relinquished_target);

						// Toggle the state flag on both the relinquished target object and the new target object
						scope.$apply(function () {
							scope.toggle_manually_assigned_state(relinquished_target); // Relinquished target
							if (target) { // Make sure the relinquished target isn't merely being replaced
								scope.toggle_manually_assigned_state(target); // New target
							}
						});
					}
				}
				else { // If this update is just adding a new target to a pristine state
					// Toggle the state flag on both the relinquished target object
					scope.$apply(function () {
						scope.toggle_manually_assigned_state(target); // New target
					});
				}

				// Remove the manual target from the scope.targets_in_plan.nukes array
				scope.targets_in_plan.nukes.splice(scope.index_of_target(target, scope.targets_in_plan.nukes), 1);
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