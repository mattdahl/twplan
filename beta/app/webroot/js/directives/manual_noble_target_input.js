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
			scope.old_manual_target = null; // A Target object

			// Initialize the autocomplete widget
			AutocompleteBuilder.noble_autocomplete(elm);

			// When focused, if there is currently a manual_target, keep a reference to the old coord value
			elm.bind('focus', function () {
				if (scope.manual_target) {
					scope.old_manual_target = scope.manual_target;
				}
			});

			scope.update_manual_target = function (target) {
				// Remove the manual target from the scope.targets_in_plan.nobles array
				scope.targets_in_plan.nobles.splice(scope.targets_in_plan.nobles.indexOf(target), 1);
				scope.manual_target = target;

				// If this update is replacing an old manual target, put the old one back in the scope.targets_in_plan array
				if (scope.old_manual_target) {
					scope.targets_in_plan.nobles.push(scope.old_manual_target);
					scope.old_manual_target = null;
				}
			};

			scope.restore_manual_target = function () {
				scope.manual_target = scope.old_manual_target;
				scope.manual_target.label = scope.manual_target.x_coord + '|' + scope.manual_target.y_coord; // In case erased by ng-model update
				scope.old_manual_target = null;
			};
		}
	};
}]);