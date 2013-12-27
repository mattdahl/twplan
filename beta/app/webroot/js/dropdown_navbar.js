$(document).ready(function () {

	// If the user is not logged in, there will be no dropdown elements to display
	if (!$('meta[name=user_id]').attr('content').length) {
		return;
	}

	var leftBound;
	var rightbound;
	var topBound;
	var bottomBound;

	$("#plannavbaritem").hover(
		function (e) {
			var positionX = $(this).position().left;
			var positionY = $(this).height() + 15;

			$("#dropdownmenu").css("visibility", "visible");
			$("#dropdownmenu").css("top", positionY);
			$("#dropdownmenu").css("left", positionX);

			leftBound = $(this).offset().left;
			rightBound = leftBound + $(this).width();
			topBound = $(this).offset().top;
			bottomBound = topBound + $(this).height() + $("#dropdownmenu").height();
		},
		function (e) {
			if (e.pageX > leftBound && e.pageX < rightBound && e.pageY > topBound) {
				return;
			}
			else {
				$("#dropdownmenu").css("visibility", "hidden");
			}
		}
	);

	$("#dropdownmenu").mouseout(function (e) {
		if (e.pageX > leftBound && e.pageX < rightBound + 25 && e.pageY < bottomBound) {
			return;
		}
		else {
			$("#dropdownmenu").css("visibility", "hidden");
		}
	});
});