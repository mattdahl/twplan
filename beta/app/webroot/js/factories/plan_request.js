/**
 * A service that saves a plan to the database
 * @param{AngularObject} $http - An AngularHTTP object that automates AJAX queries
 * @param{AngularObject} $q - An AngularPromise object
 * @return {AngularPromise} - A promise of completion of the query
 */
TWP.twplan.Factories.factory('PlanRequest', ['$http', '$q', function ($http, $q) {
	return {
		save: function (plan_name, plan) {
			debugger;
			var deferred = $q.defer();

			var commands = [];
			for (var i = 0; i < plan.commands.length; i++) {
				commands.push({
					village: plan.commands[i].village.x_coord + '|' + plan.commands[i].village.y_coord,
					target: plan.commands[i].target.x_coord + '|' + plan.commands[i].target.y_coord,
					slowest_unit: plan.commands[i].slowest_unit.id,
					attack_type: plan.commands[i].attack_type,
					travel_time: plan.commands[i].traveling_time.getTime() / 1000,
					launch_datetime: plan.commands[i].launch_datetime.getTime() / 1000,
					launch_url: plan.commands[i].launch_url
				});
			}

			$http.post('plans', {
				name: plan_name,
				landing_datetime: plan.landing_datetime.getTime() / 1000,
				world: plan.scope.current_world,
				commands: commands
			})
			.success(function (data, status, headers, config) {
				debugger;
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		},
		query: function () {
			var deferred = $q.defer();

			$http.get('plans')
			.success(function (data, status, headers, config) {
				debugger;
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		},
		update: function (plan_id, new_plan) {
			var deferred = $q.defer();

			$http.post('plans/' + plan_id, new_plan)
			.success(function (data, status, headers, config) {
				debugger;
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		}
	};
}]);