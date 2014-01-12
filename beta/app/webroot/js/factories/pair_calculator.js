TWP.twplan.Factories.factory('PairCalculator', ['Units', function (Units) {
	return {
		pair: function (villages, targets, landing_datetime, early_bound, late_bound) {
			var grooms = []; // holds villages wrapped in a MarriageWrapper object
			var brides = []; // holds targets wrapped in a MarriageWrapper object

			if (!early_bound || !late_bound) {
				early_bound = '00:00';
				late_bound = '23:00';
			}

			Candidate = (function () {
				function Candidate(groom_or_bride, distance) {
					this.groom_or_bride = groom_or_bride;
					this.distance = distance;
				}

				return Candidate;
			})();

			MarriageWrapper = (function () {
				function MarriageWrapper(village_or_target) {
					this.village_or_target = village_or_target;
					this.fiance = null;
					this.candidates = [];
					this.candidate_index = 0;
				}

				MarriageWrapper.prototype = {
					rank: function (candidate) {
						for (i = 0; i < this.candidates.length; i++) {
							if (this.candidates[i].groom_or_bride === candidate) {
								return i;
							}
						}

						return this.candidates.length + 1;
					},
					prefers: function (candidate) {
						return (this.rank(candidate) < this.rank(this.fiance));
					},
					next_candidate: function () {
						if (this.candidate_index >= this.candidates.length) {
							return null;
						}

						return this.candidates[this.candidate_index++].groom_or_bride;
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
							var bride = groom.next_candidate();
							if (!bride.fiance || bride.prefers(groom)) {
								groom.engage_to(bride);
							}
						}
					}
				} while (!done);
			};

			var make_rankings = function () {
				var early = parseInt(early_bound.substring(0, 2), 10);
				var late = parseInt(late_bound.substring(0, 2), 10);

				var sort_by_distance = function (a, b) {
					return a.distance - b.distance;
				};

				for (var i = 0; i < grooms.length; i++) {
					var a = [grooms[i].village_or_target.x_coord, grooms[i].village_or_target.y_coord];

					for (var j = 0; j < brides.length; j++) {
						var b = [brides[j].village_or_target.x_coord, brides[j].village_or_target.y_coord];
						var distance = (Math.sqrt(Math.pow((a[0] - b[0]) * (a[0] - b[0]), 2) + Math.pow((a[1] - b[1]) * (a[1] - b[1]), 2)) * grooms[i].village_or_target.slowest_unit.speed + 0.5 >> 0) * 60000; // To ms

						var launch_hour = (new Date(landing_datetime - distance)).getHours();

						// First condition is normal
						// Second condiiton is if the time restriction "wraps around the night" (i.e. early - late > 0)
						console.log((launch_hour >= early && launch_hour <= late) || (early - late > 0 && (launch_hour >= late && launch_hour <= early)));
						if ((launch_hour >= early && launch_hour <= late) || (early - late > 0 && (launch_hour >= late && launch_hour <= early))) {
							grooms[i].candidates.push(new Candidate(brides[j], distance));
							brides[j].candidates.push(new Candidate(grooms[i], distance));
						}
						else {
							grooms[i].candidates.push(new Candidate(brides[j], Number.MAX_VALUE));
							brides[j].candidates.push(new Candidate(grooms[i], Number.MAX_VALUE));
						}
					}
				}

				for (var i = 0; i < grooms.length; i++) {
					grooms[i].candidates.sort(sort_by_distance);

					if (grooms[i].candidates.length > grooms[i].length) { // Removes the worst targets if there are more targets than villages
						var difference = grooms[i].candidates.length - grooms[i].length;
						grooms[i].candidates.splice(-difference, difference);
					}
				}

				for (var i = 0; i < brides.length; i++) {
					brides[i].candidates.sort(sort_by_distance);

					if (brides[i].candidates.length > brides[i].length) { // Removes the worst targets if there are more targets than villages
						var difference = brides[i].candidates.length - brides[i].length;
						brides[i].candidates.splice(-difference, difference);
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

				engage(grooms);

				for (var i = 0; i < grooms.length; i++) {
					var groom = grooms[i];
					var bride = grooms[i].fiance;

					var a = [groom.village_or_target.x_coord, groom.village_or_target.y_coord];
					var b = [bride.village_or_target.x_coord, bride.village_or_target.y_coord];
					var distance = (Math.sqrt(Math.pow((a[0] - b[0]) * (a[0] - b[0]), 2) + Math.pow((a[1] - b[1]) * (a[1] - b[1]), 2)) * grooms[i].village_or_target.slowest_unit.speed + 0.5 >> 0) * 60000; // To ms
					var launch_hour = (new Date(landing_datetime - distance)).getHours();

					console.log("%s is engaged to %s. LH: %d", grooms[i].village_or_target.name, grooms[i].fiance.village_or_target.x_coord + '|' + grooms[i].fiance.village_or_target.y_coord, launch_hour);
				}

				console.log(PairCalculator.is_stable(grooms, brides));

				var return_array = [];

				for (var i = 0; i < grooms.length; i++) {
					//	return_array[villages.indexOf(grooms[i].village_or_target)] = targets.indexOf(grooms[i].fiance.village_or_target);
					return_array[i] = [grooms[i].village_or_target, grooms[i].fiance.village_or_target];
				}

				return return_array;
			};

			marry();
		},
		is_stable: function (grooms, brides) {
			for (var i = 0; i < grooms.length; i++) {
				for (var j = 0; j < brides.length; j++) {
					if (grooms[i].prefers(brides[j]) && brides[j].prefers(grooms[i])) {
						return false;
					}
				}
			}
			return true;
		}
	};
}]);