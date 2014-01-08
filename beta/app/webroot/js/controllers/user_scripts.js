/**
 * The controller for the /user_scripts page
 */
TWP.twplan.Controllers.controller('UserScriptsController', ['$scope', function ($scope) {
	$scope.is_archer = false;

	$scope.launch_script = {
		nuke_troops: {
			spear: 0,
			sword: 0,
			axe: 0,
			archer: 0,
			scout: 0,
			lc: 0,
			hc: 0,
			marcher: 0,
			ram: 0,
			cat: 0,
			pally: 0,
			noble: 0
		},
		noble_troops: {
			spear: 0,
			sword: 0,
			axe: 0,
			archer: 0,
			scout: 0,
			lc: 0,
			hc: 0,
			marcher: 0,
			ram: 0,
			cat: 0,
			pally: 0,
			noble: 0
		},
		support_troops: {
			spear: 0,
			sword: 0,
			axe: 0,
			archer: 0,
			scout: 0,
			lc: 0,
			hc: 0,
			marcher: 0,
			ram: 0,
			cat: 0,
			pally: 0,
			noble: 0
		},
		external_url: 'http://twplan.com/public/launch_script.js'
	};
	$scope.group_import_script = {
		external_url: 'http://twplan.com/public/group_import_script.js'
	};

	$scope.select_all = function (element) {
		if (document.selection) {
		    var range = document.body.createTextRange();
		    range.moveToElementText(element);
		    range.select();
		} else if (window.getSelection) {
		    var range = document.createRange();
		    range.selectNode(element);
		    window.getSelection().addRange(range);
		}
	};
}]);