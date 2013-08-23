TWP.Plan.Directives.directive('manualNobleTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			scope.manual_target = null; // A Target object
			scope.manual_target_coords = ''; // Bound to the ng-model on the input

			// Initialize the autocomplete widget
			AutocompleteBuilder.noble_autocomplete(elm);

			// When focused, if there is currently a manual_target, keep a reference to the old coord value
			elm.bind('focus', function () {
				if (scope.manual_target) {
					old_value = scope.manual_target_coords;
				}
			});

			// When blurred, if the input is now empty, clear the manual_target and refresh the autocomplete source
			elm.bind('blur', function () {
				if (scope.manual_target.length !== 7) {
					alert('This is not a valid target!');
					elm.trigger('focus');
				}
				else if (scope.manual_target !== old_value) {
					scope.targets_in_plan.nobles.push(scope.manual_target);
					scope.manual_target = null;
					AutocompleteBuilder.noble_autocomplete(elm);
				}
			});
		}
	};
}]);