window.onload = function doOnLoad() {
	displayVersion();
};

function displayVersion() {
	$("#version").html("v19");
}

/* ===== Dropdown Topnavbar Menu ====== */

$(document).ready(function(){

	if ($("#welcome").length == 0)
		return;

	var $leftBound;
	var $rightbound;
	var $topBound;
	var $bottomBound;

	$("#plannavbaritem").hover(
		function (e) {
			var $positionX = $(this).position().left;
			var $positionY = $(this).height() + 15;

			$("#dropdownmenu").css("visibility", "visible");
			$("#dropdownmenu").css("top", $positionY);
			$("#dropdownmenu").css("left", $positionX);

			$leftBound = $(this).offset().left;
			$rightBound = $leftBound + $(this).width();
			$topBound = $(this).offset().top;
			$bottomBound = $topBound + $(this).height() + $("#dropdownmenu").height();
		},
		function (e) {
			if (e.pageX > $leftBound && e.pageX < $rightBound && e.pageY > $topBound)
				return;
			else
				$("#dropdownmenu").css("visibility", "hidden");
		}
		);

	$("#dropdownmenu").mouseout(function(e) {
		if (e.pageX > $leftBound && e.pageX < $rightBound && e.pageY < $bottomBound)
			return;
		else
			$("#dropdownmenu").css("visibility", "hidden");
	});
});