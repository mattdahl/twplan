/*
Manual target workflow:
- $rootScope.targets holds every single target that the user has inputted
- $rootScope.targets_in_plan holds every target minus the ones that have been manually assigned
- Initially both arrays contain the same objects (though note that they contain different pointers)
- When a user clicks on the manual target <input> field, he is presented with a list of targets that match the attack type,
  which is populated from the $rootScope.targets_in_plan.nukes array (or whatever attack type)
- When a target is selected from the dropdown, the target is excised from the $rootScope.targets_in_plan.nukes array, but
  left in the $rootScope.targets array
- When planning occurs, the algorithm marries village and target objects from the $rootScope.villages_in_plan array and the
  $rootScope.targets_in_plan respectively
- Manually assigned villages are added to the final output too, though no algorithm is invoked (obviously)

When a target is selected from the dropdown...
- The target is excised from the $rootScope.targets_in_plan.nukes array, but left in the $rootScope.targets array
- A reference to the target is kept on the scope of the <input> element

When the <input> div is selected again... and a different target is selected to replace the old one
- The old target on the scope is readded to the $rootScope.targets_in_plan array
- The target is excised from the $rootScope.targets_in_plan.nukes array, but left in the $rootScope.targets array
- A reference to the new target is kept on the scope of the <input> element

When the <input> div is selected again... and no new target is used to replace
- The old target on the scope is readded to the $rootScope.targets_in_plan array
- The scope is cleared

**Events**
(1) A target is selected from the dropdown in a pristine state
(2) A target is manually entered in a pristine state
(3) A target is selected from the dropdown in a dirty state
(4) A target is manually entered in a dirty state

For (2) and (4), the change() callback triggers restore_manual_target() to deal with incorrect targets being entered
For (1) the select() callback causes the target to be removed from the targets_in_plan array and stored in scope.manual_target
For (3) the select() callback causes the the (1) behavior but also adds the old manual target stored in
  scope.old_manual_target back into the targets_in_plan array

 */



TWP.twplan.Directives.directive('manualNobleTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			scope.manual_target = null; // A Target object

			// Initialize the autocomplete widget
			AutocompleteBuilder.noble_autocomplete(elm);

			// The autocomplete widget mangles our custom Target object, so it is necessary to check the coords to determine equality
			scope.index_of_target = function (target) {
				if (!target) {
					return Infinity;
				}
				for (var i = 0; i < scope.targets_in_plan.nobles.length; i++) {
					if (scope.targets_in_plan.nobles[i].x_coord === target.x_coord && scope.targets_in_plan.nobles[i].y_coord === target.y_coord) {
						return i;
					}
				}
				return Infinity;
			};

			scope.update_manual_target = function (target) {
				// If this update is replacing an existing manual target, put the existing one back in the scope.targets_in_plan array
				if (scope.manual_target.scope) { // Checks to see if the manual_target variable holds a Target object and not merely a string
					scope.targets_in_plan.nobles.push(new Target(
						scope.manual_target.scope,
						scope.manual_target.x_coord,
						scope.manual_target.y_coord,
						scope.manual_target.continent,
						scope.manual_target.attack_type
					));
				}

				// Remove the manual target from the scope.targets_in_plan.nobles array
				scope.targets_in_plan.nobles.splice(scope.index_of_target(target), 1);
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