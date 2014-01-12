Units = {
	Spear: {
		id: 0,
		name: 'Spear',
		speed: 18,
		url: 'spear.png'
	},
	Sword: {
		id: 1,
		name: 'Sword',
		speed: 22,
		url: 'sword.png'
	},
	Axe: {
		id: 2,
		name: 'Axe',
		speed: 18,
		url: 'axe.png'
	},
	Archer: {
		id: 3,
		name: 'Archer',
		speed: 18,
		url: 'archer.png'
	},
	Scout: {
		id: 4,
		name: 'Scout',
		speed: 9,
		url: 'scout.png'
	},
	Lc: {
		id: 5,
		name: 'Lc',
		speed: 10,
		url: 'lc.png'
	},
	Hc: {
		id: 6,
		name: 'Hc',
		speed: 11,
		url: 'hc.png'
	},
	Marcher: {
		id: 7,
		name: 'Marcher',
		speed: 10,
		url: 'marcher.png'
	},
	Ram: {
		id: 8,
		name: 'Ram',
		speed: 30,
		url: 'ram.png'
	},
	Cat: {
		id: 9,
		name: 'Cat',
		speed: 30,
		url: 'cat.png'
	},
	Pally: {
		id: 10,
		name: 'Pally',
		speed: 10,
		url: 'pally.png'
	},
	Noble: {
		id: 11,
		name: 'Noble',
		speed: 35,
		url: 'noble.png'
	}
};

PairCalculator = {
	pair: function (villages, targets, landing_datetime, early_bound, late_bound) {
		var grooms = []; // holds villages wrapped in a MarriageWrapper object
		var brides = []; // holds targets wrapped in a MarriageWrapper object

		if (!early_bound || !late_bound) {
			early_bound = '00:00';
			late_bound = '23:00';
		}

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
						if (this.candidates[i].village_or_target.x_coord === candidate.village_or_target.x_coord && this.candidates[i].village_or_target.y_coord === candidate.village_or_target.y_coord) { // Can't test for object equality because in the ranking function the objects are copied, not passed by reference
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

					return this.candidates[this.candidate_index++];
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
						var candidate = new MarriageWrapper(brides[j].village_or_target);
						candidate.distance = distance;
						grooms[i].candidates.push(candidate);

						candidate = new MarriageWrapper(grooms[i].village_or_target);
						candidate.distance = distance;
						brides[j].candidates.push(candidate);
					}
					else {
						// Copy the MarriageWrapper object so the unique distance is preserved
						// Problem if pass by reference is that the distance will just get recalculated on the next loop, before the sorting happens
						var candidate = new MarriageWrapper(brides[j].village_or_target);
						candidate.distance = Number.MAX_VALUE;
						grooms[i].candidates.push(candidate);

						candidate = new MarriageWrapper(grooms[i].village_or_target);
						candidate.distance = Number.MAX_VALUE;
						brides[j].candidates.push(candidate);
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
				console.log("%s is engaged to %s", grooms[i].village_or_target.name, grooms[i].fiance.village_or_target.x_coord + '|' + grooms[i].fiance.village_or_target.y_coord);
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

Test = (function () {
	var targets = [];
	var villages = [];

	for (var i = 1; i < 9; i++) {
		villages.push(new Village(
			null,
			null,
			i,
			'' + i + i + i,
			'' + i + i + i,
			parseInt('K' + i + i, 10),
			Units.Spear,
			null
		));
		targets.push(new Target(
			null,
			'' + (9 - i) + (9 - i) + ((9 - i) - 1),
			'' + (9 - i) + (9 - i) + (9 - i),
			parseInt('K' + (9 - i) + (9 - i), 9),
			null
		));
	}

	PairCalculator.pair(villages, targets, new Date(), '10:00', '11:00');
})();

/*
 * When the time optimization feature is turned off, make_rankings() should rank based on proximity in order to ensure
 * the most efficient launching combination.
 *
 * However, when the time optimization feature is turned off, make_rankings() should rank based on "good matches" - i.e.
 * matches whose launch times fall between the restriction endpoints.
 */