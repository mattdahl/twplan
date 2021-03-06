/**
 * A service that interfaces with the database to provide and send group information
 * @param{AngularObject} $http - An AngularHTTP object that automates AJAX queries
 * @param{AngularObject} $q - An AngularPromise object
 * @return {AngularPromise} - A promise of completion of the query
 */
TWP.twplan.Factories.factory('GroupRequest', ['$http', '$q', function ($http, $q) {
	return {
		save: function (group) {
			var deferred = $q.defer();

			$http.post('group', group) // relative URL is different because the pushState/popState mechanism mangles the base URL
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

			$http.get('groups/group')
			.success(function (data, status, headers, config) {
				debugger;
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		},
		update: function (group_id, new_group) {
			var deferred = $q.defer();

			$http.put(group_id, new_group) // relative URL is different because the pushState/popState mechanism mangles the base URL
			.success(function (data, status, headers, config) {
				debugger;
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		},
		destroy: function (group_id) {
			var deferred = $q.defer();

			$http.delete(group_id) // relative URL is different because the pushState/popState mechanism mangles the base URL
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