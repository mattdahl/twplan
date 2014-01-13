TWP.twplan.Factories.factory('PlanCalculator', ['$rootScope', 'PairCalculator', 'WorldInfo', 'MetaData', function ($rootScope, PairCalculator, WorldInfo, MetaData) {
	return {
		calculate_plan: function (scope, landing_datetime) {
			this.configure_dst_lookup();

			var assigned_nuke_villages = [], unassigned_nuke_villages = [];
			var assigned_noble_villages = [], unassigned_noble_villages = [];
			var assigned_support_villages = [], unassigned_support_villages = [];

			for (var i = 0; i < scope.villages_in_plan.nukes.length; i++) {
				if (scope.villages_in_plan.nukes[i].manual_target && scope.villages_in_plan.nukes[i].manual_target.scope) {
					assigned_nuke_villages.push(scope.villages_in_plan.nukes[i]);
				}
				else {
					unassigned_nuke_villages.push(scope.villages_in_plan.nukes[i]);
				}
			}
			for (var i = 0; i < scope.villages_in_plan.nobles.length; i++) {
				if (scope.villages_in_plan.nobles[i].manual_target && scope.villages_in_plan.nobles[i].manual_target.scope) {
					assigned_noble_villages.push(scope.villages_in_plan.nobles[i]);
				}
				else {
					unassigned_noble_villages.push(scope.villages_in_plan.nobles[i]);
				}
			}
			for (var i = 0; i < scope.villages_in_plan.supports.length; i++) {
				if (scope.villages_in_plan.supports[i].manual_target && scope.villages_in_plan.supports[i].manual_target.scope) {
					assigned_support_villages.push(scope.villages_in_plan.supports[i]);
				}
				else {
					unassigned_support_villages.push(scope.villages_in_plan.supports[i]);
				}
			}

			var paired_nukes = [];
			var paired_nobles = [];
			var paired_supports = [];

			if (scope.optimization_checked) {
				paired_nukes = PairCalculator.pair(unassigned_nuke_villages, scope.targets_in_plan.nukes, landing_datetime, scope.early_bound, scope.late_bound);
				paired_nobles = PairCalculator.pair(unassigned_noble_villages, scope.targets_in_plan.nobles, landing_datetime, scope.early_bound, scope.late_bound);
				paired_supports = PairCalculator.pair(unassigned_support_villages, scope.targets_in_plan.supports, landing_datetime, scope.early_bound, scope.late_bound);
			}
			else {
				paired_nukes = PairCalculator.pair(unassigned_nuke_villages, scope.targets_in_plan.nukes, landing_datetime);
				paired_nobles = PairCalculator.pair(unassigned_noble_villages, scope.targets_in_plan.nobles, landing_datetime);
				paired_supports = PairCalculator.pair(unassigned_support_villages, scope.targets_in_plan.supports, landing_datetime);

			}

			// Adds the paired commands to the plan
			for (var i = 0; i < paired_nukes.length; i++) {
				var traveling_time = this.calculate_traveling_time(paired_nukes[i][0], paired_nukes[i][1]);
				debugger;
				$rootScope.plan.commands.push(new Command(
					scope,
					paired_nukes[i][0],
					paired_nukes[i][1],
					traveling_time,
					this.calculate_launch_time(landing_datetime, traveling_time)
					)
				);
			}
			for (var i = 0; i < paired_nobles.length; i++) {
				var traveling_time = this.calculate_traveling_time(paired_nobles[i][0], paired_nobles[i][1]);

				$rootScope.plan.commands.push(new Command(
					scope,
					paired_nobles[i][0],
					paired_nobles[i][1],
					traveling_time,
					this.calculate_launch_time(landing_datetime, traveling_time)
					)
				);
			}
			for (var i = 0; i < paired_supports.length; i++) {
				var traveling_time = this.calculate_traveling_time(paired_supports[i][0], paired_supports[i][1]);

				$rootScope.plan.commands.push(new Command(
					scope,
					paired_supports[i][0],
					paired_supports[i][1],
					traveling_time,
					this.calculate_launch_time(landing_datetime, traveling_time)
					)
				);
			}

			// Adds the manually assigned commands to the plan
			for (var i = 0; i < assigned_nuke_villages.length; i++) {
				var target = new Target(
					assigned_nuke_villages[i].manual_target.scope,
					assigned_nuke_villages[i].manual_target.x_coord,
					assigned_nuke_villages[i].manual_target.y_coord,
					assigned_nuke_villages[i].manual_target.continent,
					assigned_nuke_villages[i].manual_target.attack_type
				);

				var traveling_time = this.calculate_traveling_time(assigned_nuke_villages[i], target);

				$rootScope.plan.commands.push(new Command(
					scope,
					assigned_nuke_villages[i],
					target,
					traveling_time,
					this.calculate_launch_time(landing_datetime, traveling_time)
					)
				);
			}
			for (var i = 0; i < assigned_noble_villages.length; i++) {
				var target = new Target(
					assigned_noble_villages[i].manual_target.scope,
					assigned_noble_villages[i].manual_target.x_coord,
					assigned_noble_villages[i].manual_target.y_coord,
					assigned_noble_villages[i].manual_target.continent,
					assigned_noble_villages[i].manual_target.attack_type
				);

				var traveling_time = this.calculate_traveling_time(assigned_noble_villages[i], target);

				$rootScope.plan.commands.push(new Command(
					scope,
					assigned_noble_villages[i],
					target,
					traveling_time,
					this.calculate_launch_time(landing_datetime, traveling_time)
					)
				);
			}
			for (var i = 0; i < assigned_support_villages.length; i++) {
				var target = new Target(
					assigned_support_villages[i].manual_target.scope,
					assigned_support_villages[i].manual_target.x_coord,
					assigned_support_villages[i].manual_target.y_coord,
					assigned_support_villages[i].manual_target.continent,
					assigned_support_villages[i].manual_target.attack_type
				);

				var traveling_time = this.calculate_traveling_time(assigned_support_villages[i], target);

				$rootScope.plan.commands.push(new Command(
					scope,
					assigned_support_villages[i],
					target,
					traveling_time,
					this.calculate_launch_time(landing_datetime, traveling_time)
					)
				);
			}
		},
		calculate_traveling_time: function (village, target) {
			var distance = Math.sqrt(Math.pow(village.x_coord - target.x_coord, 2) + Math.pow(village.y_coord - target.y_coord, 2));

			return new Date(((distance * village.slowest_unit.speed) / (WorldInfo[MetaData.current_world].speed * WorldInfo[MetaData.current_world].unitSpeed)) * 60 * 1000);
		},
		calculate_launch_time: function (landing_datetime, traveling_time) {
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
		},
		configure_dst_lookup: function () {
			Date.prototype.stdTimezoneOffset = function () {
				var jan = new Date(this.getFullYear(), 0, 1);
				var jul = new Date(this.getFullYear(), 6, 1);
				return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
			};

			Date.prototype.isDST = function () {
				return this.getTimezoneOffset() < this.stdTimezoneOffset();
			};
		}
	};
}]);