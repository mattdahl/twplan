TWP.twplan.Factories.factory('PairCalculator', ['Units', 'WorldInfo', 'MetaData', function (Units, WorldInfo, MetaData) {
	return {
		pair: function (villages, targets, landing_datetime, early_bound, late_bound) {
			var grooms = []; // holds villages wrapped in a MarriageWrapper object
			var brides = []; // holds targets wrapped in a MarriageWrapper object

			if (!early_bound || !late_bound) {
				early_bound = '00:00';
				late_bound = '23:00';
			}

			Candidate = (function () {
				function Candidate(groom_or_bride, traveling_time) {
					this.groom_or_bride = groom_or_bride;
					this.traveling_time = traveling_time;
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

			var calculate_traveling_time = function (village, target) {
				var distance = Math.sqrt(Math.pow(village.x_coord - target.x_coord, 2) + Math.pow(village.y_coord - target.y_coord, 2));

				return new Date(((distance * village.slowest_unit.speed) / (WorldInfo[MetaData.current_world].speed * WorldInfo[MetaData.current_world].unitSpeed)) * 60 * 1000);
			};

			var calculate_launch_time = function (landing_datetime, traveling_time) {
				var n = new Date();
				var offset;

				if (n.isDST()) {
					offset = (n.getTimezoneOffset() / 60) + 1;
				}
				else {
					offset = n.getTimezoneOffset() / 60;
				}
				// Gets difference; positive if west of UTC, negative if east
				// +1 when daylight savings is active!

				var before_offset = new Date(landing_datetime - traveling_time);

				return new Date(before_offset.setHours(before_offset.getHours() + offset));
			};

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

				var sort_by_traveling_time = function (a, b) {
					return a.traveling_time - b.traveling_time;
				};

				for (var i = 0; i < grooms.length; i++) {
					for (var j = 0; j < brides.length; j++) {
						var traveling_time = calculate_traveling_time(grooms[i].village_or_target, brides[j].village_or_target);

						var launch_hour = calculate_launch_time(landing_datetime, traveling_time).getHours();

						// First condition is normal
						// Second condiiton is if the time restriction "wraps around the night" (i.e. early - late > 0)
						console.log((launch_hour >= early && launch_hour <= late) || (early - late > 0 && (launch_hour >= early || launch_hour <= late)));
						if ((launch_hour >= early && launch_hour <= late) || (early - late > 0 && (launch_hour >= late && launch_hour <= early))) {
							grooms[i].candidates.push(new Candidate(brides[j], traveling_time));
							brides[j].candidates.push(new Candidate(grooms[i], traveling_time));
						}
						else {
							// The finesse of this could be improved by calculating the MAX_VALUE relative to how far off the
							// launch hour is from the restriction range
							grooms[i].candidates.push(new Candidate(brides[j], Number.MAX_VALUE));
							brides[j].candidates.push(new Candidate(grooms[i], Number.MAX_VALUE));
						}
					}
				}

				for (var i = 0; i < grooms.length; i++) {
					grooms[i].candidates.sort(sort_by_traveling_time);

					if (grooms[i].candidates.length > grooms[i].length) { // Removes the worst targets if there are more targets than villages
						var difference = grooms[i].candidates.length - grooms[i].length;
						grooms[i].candidates.splice(-difference, difference);
					}
				}

				for (var i = 0; i < brides.length; i++) {
					brides[i].candidates.sort(sort_by_traveling_time);

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

					var traveling_time = calculate_traveling_time(groom.village_or_target, bride.village_or_target);
					var launch_hour = calculate_launch_time(landing_datetime, traveling_time).getHours();

					console.log("%s is engaged to %s. LH: %d", groom.village_or_target.x_coord + '|' + groom.village_or_target.y_coord, groom.fiance.village_or_target.x_coord + '|' + groom.fiance.village_or_target.y_coord, launch_hour);
				}

				var return_array = [];

				for (var i = 0; i < grooms.length; i++) {
					//	return_array[villages.indexOf(grooms[i].village_or_target)] = targets.indexOf(grooms[i].fiance.village_or_target);
					return_array[i] = [grooms[i].village_or_target, grooms[i].fiance.village_or_target];
				}

				return return_array;
			};

			return marry();
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