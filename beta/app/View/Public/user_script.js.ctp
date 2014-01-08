// TWplan launchScript.js
// Instructions for use can be found at http://twplan.com/user_scripts
// Contact: matt@twplan.com

if (document.URL.match("screen=place") == "screen=place") {

	var url = document.URL;
	var xCoord = url.replace(/.*&x=([^&]*)\&.*/,'$1');
	var yCoord = url.replace(/.*&y=([^&]*)\&.*/,'$1');
	var type = url.replace(/.*&attacktype=([^&]*).*/,'$1');

	if (!xCoord || !yCoord || !type) {
		alert("Check the URL - are you following a TWplan link? The x-coord, y-coord, or attacktype is not set.");
		void(0);
	}

	$(document.units.x).val(parseInt(xCoord));
	$(document.units.y).val(parseInt(yCoord));

	var $form = $("#units_form")[0];
	var $setValue;

	if (archer) {
		for (var i = 0, j = 2; i < 12; i++, j++) { // j keeps track of form count
			$setValue = troops[type][i];
			if ($setValue == -1) {
				var maxVal = parseInt($($($form[j]).parent().children()[2]).html().match(/\d+/));
				$($form[j]).val(maxVal);
			}
			else
				$($form[j]).val($setValue);
		}
	}
	else {
		for (var i = 0, j = 2; i < 12; i++, j++) { // j keeps track of form count
			$setValue = troops[type][i];
			if (i == 3 || i == 7) { // (archer or marcher)
				j--; // keeps the pointer on the correct form for a skipped over index in the array
				continue;
			}
			if ($setValue == -1) {
				var maxVal = parseInt($($($form[j]).parent().children()[2]).html().match(/\d+/));
				$($form[j]).val(maxVal);
			}
			else
				$($form[j]).val($setValue);
		}
	}
}
else {
	alert("This script must be run from the rally point! Follow a TWplan plan link and then run this script.");
	void(0);
}

void(0);