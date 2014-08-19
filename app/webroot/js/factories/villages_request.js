/**
 * A service that queries the database for the current user's villages on the current world
 * @param{AngularObject} $http - An AngularHTTP object that automates AJAX queries
 * @param{AngularObject} $q - An AngularPromise object
 * @return {AngularPromise} - A promise of completion of the lookup query
 */
TWP.twplan.Factories.factory('VillagesRequest', ['$http', '$q', function ($http, $q) {
	return {
		query: function () {
			var deferred = $q.defer();

			$http.get('users/villages')
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