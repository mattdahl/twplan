PlanModule.factory('AttackTypes', function () {
	return {
		Nuke: 0,
		Noble: 1,
		Support: 2,
		toString: ["Nuke", "Noble", "Support"]
	};
});

PlanModule.factory('Units', function () {
	return {
		Spear: {
			id: 0,
			speed: 18,
			url: 'spear.png'
		},
		Sword: {
			id: 1,
			speed: 22,
			url: 'sword.png'
		},
		Axe: {
			id: 2,
			speed: 18,
			url: 'axe.png'
		},
		Archer: {
			id: 3,
			speed: 18,
			url: 'archer.png'
		},
		Scout: {
			id: 4,
			speed: 9,
			url: 'scout.png'
		},
		Lc: {
			id: 5,
			speed: 10,
			url: 'lc.png'
		},
		Hc: {
			id: 6,
			speed: 11,
			url: 'hc.png'
		},
		Marcher: {
			id: 7,
			speed: 10,
			url: 'marcher.png'
		},
		Ram: {
			id: 8,
			speed: 30,
			url: 'ram.png'
		},
		Cat: {
			id: 9,
			speed: 30,
			url: 'cat.png'
		},
		Pally: {
			id: 10,
			speed: 10,
			url: 'pally.png'
		},
		Noble: {
			id: 11,
			speed: 35,
			url: 'noble.png'
		}
	};
});

/**
 * A service that queries the database for the current user's villages on the current world
 * @param{AngularObject} $http - An AngularHTTP object that automates AJAX queries
 * @param{AngularObject} $q - An AngularPromise object
 * @return {AngularPromise} - A promise of completion of the lookup query
 */
PlanModule.factory('Villages', ['$http', '$q', function ($http, $q) {
	return {
		getUserVillages: function () {
			var deferred = $q.defer();

			$http.post('scripts/loadvillagesforplan.php')
			.success(function (data, status, headers, config) {
				deferred.resolve(data);
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		}
	};
}]);

PlanModule.factory('GroupNames', ['$http', '$q', function ($http, $q) {
	return {
		getGroupNames: function () {
			var deferred = $q.defer();

			$http.post('scripts/groupnames.php')
			.success(function (data, status, headers, config) {
				if (data == "null") {
					deferred.resolve(null);
				}
				else {
					deferred.resolve(data);
				}
			}).error(function (data, status, headers, config) {
				debugger;
				deferred.reject(data);
			});
			return deferred.promise;
		}
	};
}]);