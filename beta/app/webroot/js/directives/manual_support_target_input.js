TWP.Plan.Directives.directive('manualSupportTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			scope.$on('manual_target_added', function () {
				AutocompleteBuilder.support_autocomplete();
			});
			scope.$on('manual_target_removed', update_autocomplete_source);
		}
	};
}]);