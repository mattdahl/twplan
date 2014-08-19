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

					response(nuke_source);
				},
				select: function (event, ui) {
					element.scope().update_manual_target(ui.item); // When a new manual target is selected, pass it to the element's scope
					element.scope().was_selected = true; // Sets a flag to prevent trigger of change() event when select() was
					$(element).trigger('blur.autocomplete'); // Causes the change() callback to always be fired (left alone, behavior is unpredicable)
				},
				change: function (event, ui) {
					if (element.scope().was_selected) {
						element.scope().was_selected = false;
						return;
					}
					if (element.val().length) { // If the change is one that writes a new target *without* selecting from the dropdown...
						// Check to see if the manual submission is valid
						for (var i = 0; i < scope.targets_in_plan.nukes.length; i++) {
							if (scope.targets_in_plan.nukes[i].x_coord + '|' + scope.targets_in_plan.nukes[i].y_coord === element.val()) {
								// If so, update the manual target like normal
								element.scope().update_manual_target(scope.targets_in_plan.nukes[i]);
								return;
							}
						}
						// If not, don't allow the manual submission
						alert('You must make a valid target selection from the dropdown!');
						element.scope().restore_manual_target();
					}
					else { // Otherwise, if the change is one that just deletes the current target, relinquish that manual target
						element.scope().update_manual_target(null);
					}
				}
			});
		},
		noble_autocomplete: function (element) {
			var scope = element.scope(); // Prototypically inherits from the StepTwoController $scope

			$(element).autocomplete({
				source: function (request, response) {
					var noble_source = [];

					for (var i = 0; i < scope.targets_in_plan.nobles.length; i++) {
						var target = scope.targets_in_plan.nobles[i];
						target.label = target.x_coord + '|' + target.y_coord;
						if (target.label.indexOf(request.term) !== -1) { // If the target contains the coords being suggested by the user
							noble_source.push(target); // Then add it the source array of suggestions to display to the user
						}
					}

					response(noble_source);
				},
				select: function (event, ui) {
					element.scope().update_manual_target(ui.item); // When a new manual target is selected, pass it to the element's scope
					element.scope().was_selected = true; // Sets a flag to prevent trigger of change() event when select() was
					$(element).trigger('blur.autocomplete'); // Causes the change() callback to always be fired (left alone, behavior is unpredicable)
				},
				change: function (event, ui) {
					if (element.scope().was_selected) {
						element.scope().was_selected = false;
						return;
					}
					if (element.val().length) { // If the change is one that writes a new target *without* selecting from the dropdown...
						// Check to see if the manual submission is valid
						for (var i = 0; i < scope.targets_in_plan.nobles.length; i++) {
							if (scope.targets_in_plan.nobles[i].x_coord + '|' + scope.targets_in_plan.nobles[i].y_coord === element.val()) {
								// If so, update the manual target like normal
								element.scope().update_manual_target(scope.targets_in_plan.nobles[i]);
								return;
							}
						}
						// If not, don't allow the manual submission
						alert('You must make a valid target selection from the dropdown!');
						element.scope().restore_manual_target();
					}
					else { // Otherwise, if the change is one that just deletes the current target, relinquish that manual target
						element.scope().update_manual_target(null);
					}
				}
			});
		},
		support_autocomplete: function (element) {
			var scope = element.scope(); // Prototypically inherits from the StepTwoController $scope

			$(element).autocomplete({
				source: function (request, response) {
					var support_source = [];

					for (var i = 0; i < scope.targets_in_plan.supports.length; i++) {
						var target = scope.targets_in_plan.supports[i];
						target.label = target.x_coord + '|' + target.y_coord;
						if (target.label.indexOf(request.term) !== -1) { // If the target contains the coords being suggested by the user
							support_source.push(target); // Then add it the source array of suggestions to display to the user
						}
					}

					response(support_source);
				},
				select: function (event, ui) {
					element.scope().update_manual_target(ui.item); // When a new manual target is selected, pass it to the element's scope
					element.scope().was_selected = true; // Sets a flag to prevent trigger of change() event when select() was
					$(element).trigger('blur.autocomplete'); // Causes the change() callback to always be fired (left alone, behavior is unpredicable)
				},
				change: function (event, ui) {
					if (element.scope().was_selected) {
						element.scope().was_selected = false;
						return;
					}
					if (element.val().length) { // If the change is one that writes a new target *without* selecting from the dropdown...
						// Check to see if the manual submission is valid
						for (var i = 0; i < scope.targets_in_plan.supports.length; i++) {
							if (scope.targets_in_plan.supports[i].x_coord + '|' + scope.targets_in_plan.supports[i].y_coord === element.val()) {
								// If so, update the manual target like normal
								element.scope().update_manual_target(scope.targets_in_plan.supports[i]);
								return;
							}
						}
						// If not, don't allow the manual submission
						alert('You must make a valid target selection from the dropdown!');
						element.scope().restore_manual_target();
					}
					else { // Otherwise, if the change is one that just deletes the current target, relinquish that manual target
						element.scope().update_manual_target(null);
					}
				}
			});
		}
	};
}]);