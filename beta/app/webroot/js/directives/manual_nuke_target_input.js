TWP.Plan.Directives.directive('manualNukeTargetInput', ['AutocompleteBuilder', function (AutocompleteBuilder) {
	return {
		scope: true,
		require: 'ngModel',
		link: function (scope, elm, attrs, ctrl) {
			scope.$on('manual_target_added', function () {
				AutocompleteBuilder.nuke_autocomplete();
			});
			scope.$on('manual_target_removed', update_autocomplete_source);
		}
	};
}]);