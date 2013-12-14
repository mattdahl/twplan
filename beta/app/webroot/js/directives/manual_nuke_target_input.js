TWP.twplan.Directives.directive('manualNukeTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			scope.manual_target = null; // A Target object

			// Initialize the autocomplete widget
			AutocompleteBuilder.nuke_autocomplete(elm);

			// The autocomplete widget mangles our custom Target object, so it is necessary to check the coords to determine equality
			index_of_target = function (target) {
				if (!target) {
					return Infinity;
				}
				for (var i = 0; i < scope.targets_in_plan.nukes.length; i++) {
					if (scope.targets_in_plan.nukes[i].x_coord === target.x_coord && scope.targets_in_plan.nukes[i].y_coord === target.y_coord) {
						return i;
					}
				}
				return Infinity;
			};

			scope.update_manual_target = function (target) {
				// If this update is replacing an existing manual target, put the existing one back in the scope.targets_in_plan array
				if (scope.manual_target.scope) { // Checks to see if the manual_target variable holds a Target object and not merely a string
					scope.targets_in_plan.nukes.push(new Target(
						scope.manual_target.scope,
						scope.manual_target.x_coord,
						scope.manual_target.y_coord,
						scope.manual_target.continent,
						scope.manual_target.attack_type
					));
				}

				// Remove the manual target from the scope.targets_in_plan.nukes array
				scope.targets_in_plan.nukes.splice(index_of_target(target), 1);
				scope.manual_target = target;
			};

			scope.restore_manual_target = function () {
				// Foces the input to revert to the old target coords
				scope.$apply(function () {
					if (scope.manual_target.scope) {
						scope.manual_target.label = scope.manual_target.x_coord + '|' + scope.manual_target.y_coord;
					}
					else {
						scope.manual_target.label = '';
					}
				});
			};
		}
	};
}]);