TWP.twplan.Factories.factory('PairCalculator', ['Units', function (Units) {
	return {
		pair: function (villages, targets, landing_datetime, early_bound, late_bound) {
			var grooms = []; // holds villages wrapped in a MarriageWrapper object
			var brides = []; // holds targets wrapped in a MarriageWrapper object
			var candidateIndex = 0;

			if (!early_bound || !late_bound) {
				early_bound = '00:00';
				late_bound = '23:00';
			}

			MarriageWrapper = (function () {
				function MarriageWrapper(village_or_target) {
					this.village_or_target = village_or_target;
					this.fiance = null;
					this.candidates = [];
					this.good_matches = 0;
				}

				MarriageWrapper.prototype = {
					rank: function (candidate) {
						for (i = 0; i < this.candidates.length; i++) {
							if (this.candidates[i] === candidate) {
								return i;
							}
						}

						return this.candidates.length + 1;
					},
					prefers: function (candidate) {
						return (this.rank(candidate) < this.rank(this.fiance));
					},
					next_candidate: function () {
						if (candidateIndex >= this.candidates.length) {
							return null;
						}

						return this.candidates[candidateIndex++];
					},
					engage_to: function (marriage_wrapper) {
						if (marriage_wrapper.fiance) {
							marriage_wrapper.fiance.fiance = null;
						}
						marriage_wrapper.fiance = this;

						if (this.fiance) {
							this.fiance.fiance = null;
						}
						this.fiance = marriage_wrapper;
					}
				};

				return MarriageWrapper;
			})();

			var engage = function (grooms) {
				var done;
				do {
					done = true;
					for (var i = 0; i < grooms.length; i++) {
						var groom = grooms[i];
						if (!groom.fiance) {
							done = false;
							var bride = groom.nextCandidate();
							if (!bride.fiance || bride.prefers(groom)) {
								groom.engageTo(bride);
							}
						}
					}
				} while (!done);
			};

			var make_rankings = function () {
				var early = early_bound.substring(0, 2);
				var late = late_bound.substring(0, 2);

				for (var i = 0; i < grooms.length; i++) {
					var a = [grooms[i].village_or_target.x_coord, grooms[i].village_or_target.y_coord];

					for (var j = 0; j < brides.length; j++) {
						var b = [brides[i].village_or_target.x_coord, brides[i].village_or_target.y_coord];
						var distance = (Math.sqrt((a[0]-b[0])*(a[0]-b[0])+(a[1]-b[1])*(a[1]-b[1]))*grooms[i].slowest_unit.speed+0.5>>0)*60000; // to ms

						var launch_hour = (new Date(landing_datetime - distance)).getHours();

						if (launch_hour > early && launch_hour < late) { // Prepends good matches to top of array
							grooms[i].candidates.shift(brides[j]);
							brides[j].candidates.shift(grooms[i]);

							grooms[i].good_matches++;
							brides[j].good_matches++;
						}
						else { // Appends bad matches to bottom of array
							grooms[i].candidates.push(brides[j]);
							brides[j].candidates.push(grooms[i]);
						}
					}
				}
			};

			var marry = function () {
				for (var i = 0; i < villages.length; i++) {
					grooms.push(new MarriageWrapper(villages[i]));
				}
				for (var i = 0; i < targets.length; i++) {
					brides.push(new MarriageWrapper(targets[i]));
				}

				make_rankings();

				function sort_by_good_matches(a, b) { // the coordinates with the least good matches should be first
					return b.good_matches - a.good_matches;
				}

				grooms.sort(sort_by_good_matches);
				brides.sort(sort_by_good_matches);

				engage(villages);

				for (var i = 0; i < villages.length; i++) {
					console.log("%s is engaged to %s", villages[i].name, villages[i].fiance.name);
				}

				var return_array = [];

				for (var i = 0; i < grooms.length; i++) {
				//	return_array[villages.indexOf(grooms[i].village_or_target)] = targets.indexOf(grooms[i].fiance.village_or_target);
					return_array[i] = [grooms[i].village_or_target, grooms[i].fiance.village_or_target];
				}

				return return_array;
			};

			marry();
		},
		is_stable: function (villages, targets) {
			for (var i = 0; i < villages.length; i++) {
				for (var j = 0; j < targets.length; j++) {
					if (villages[i].prefers(targets[j]) && targets[j].prefers(villages[i])) {
						return false;
					}
				}
			}
			return true;
		}
	};
}]);