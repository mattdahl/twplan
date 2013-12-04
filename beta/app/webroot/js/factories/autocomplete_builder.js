TWP.twplan.Factories.factory('AutocompleteBuilder', [function () {
	return {
		nuke_autocomplete: function (element) {
			var scope = element.scope(); // Prototypically inherits from the StepTwoController $scope

			$(element).autocomplete({
				source: function (request, response) {
					var nuke_source = [];

					for (var i = 0; i < scope.targets_in_plan.nukes.length; i++) {
						var target = scope.targets_in_plan.nukes[i];
						target.label = target.x_coord + '|' + target.y_coord;
						if (target.label.indexOf(request.term) !== -1) { // If the target contains the coords being suggested by the user
							nuke_source.push(target); // Then add it the source array of suggestions to display to the user
						}
					}

					debugger;
					response(nuke_source);
				},
				select: function (event, ui) {
					debugger;
					element.scope().update_manual_target(ui.item); // When a new manual target is selected, pass it to the element's scope
					this._trigger('change', event, ui);
				},
				change: function (event, ui) {
					debugger;
					// Prevents the user from inputting an invalid target
					if (element.val().length && !ui.item) {
						alert('You must make a valid target selection from the dropdown!');
						element.scope().restore_manual_target();
					}
				}
			});
		},
		noble_autocomplete: function (element) {
			var scope = element.scope();

			$(element).autocomplete({
				source: function (request, response) {
					var noble_source = [];

					for (var i = 0; i < scope.targets_in_plan.nobles.length; i++) {
						var target = scope.targets_in_plan.nobles[i];
						target.label = target.x_coord + '|' + target.y_coord;
						if (target.label.indexOf(request.term)) { // If the target contains the coords being suggested by the user
							noble_source.push(target); // Then add it the source array of suggestions to display to the user
						}
					}

					response(noble_source);
				},
				select: function (event, ui) {
					element.scope().update_manual_target(ui.item); // When a new manual target is selected, pass it to the element's scope
				},
				change: function (event, ui) {
					// Prevents the user from inputting an invalid target
					if (element.val().length && !ui.item) {
						alert('You must make a valid target selection from the dropdown!');
						element.scope().restore_manual_target();
					}
				}
			});
		},
		support_autocomplete: function (element) {
			var scope = element.scope();

			$(element).autocomplete({
				source: function (request, response) {
					var support_source = [];

					for (var i = 0; i < scope.targets_in_plan.supports.length; i++) {
						var target = scope.targets_in_plan.supports[i];
						target.label = target.x_coord + '|' + target.y_coord;
						if (target.label.indexOf(request.term)) { // If the target contains the coords being suggested by the user
							support_source.push(target); // Then add it the source array of suggestions to display to the user
						}
					}

					response(support_source);
				},
				select: function (event, ui) {
					element.scope().update_manual_target(ui.item); // When a new manual target is selected, pass it to the element's scope
				},
				change: function (event, ui) {
					// Prevents the user from inputting an invalid target
					if (element.val().length && !ui.item) {
						alert('You must make a valid target selection from the dropdown!');
						element.scope().restore_manual_target();
					}
				}
			});
		}
	};
}]);