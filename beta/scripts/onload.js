window.onload = function doOnLoad() {
  
  if (window.location.pathname == "/plan.php")
    loadPlayerVillages();
  else if (window.location.pathname == "/settings.php")
    loadSettings();
  
  if ($("#worldselect") == null || $("#worldselect") == undefined)
    return;
  
  displayCurrentWorld();
  
  displayVersion();
}

function displayVersion(){
  $("#version").html("v19");
}

function displayCurrentWorld() {
    var currentWorld = "";

    if (sessionStorage["currentWorld"] == undefined || sessionStorage["currentWorld"] == "" || sessionStorage["currentWorld"] == 0) {
       $.ajax({
           url:('scripts/currentworld.php'),
           timeout: 10000,
           success: function(data) {
             debugger;
             sessionStorage["currentWorld"] = data;
			 doDisplay();
           },
           error: function(jqXHR, t, e) {
             debugger;
           }
        });
    }
	else
		doDisplay();
	
	function doDisplay() {
		currentWorld = "W" + sessionStorage["currentWorld"];
	  
		var x = $("#worldselect")[0];
		if (x == null)
		  return false;
	
		var i = 0;
		while (x.options[i]) {
			debugger;
		  if (currentWorld === x.options[i].value) {
			x.selectedIndex = i;
			break;
		  }
		  i++;
		}
	}
}

function changeWorld() {
      var x = $("#worldselect")[0];
      var world = (x.options[x.selectedIndex].value);
      world = world.substring(1); // removes the 'W' in front
  
      debugger;
      $.ajax({
           url:('scripts/updateworld.php?world=' + world),
           timeout: 10000,
           async: false,
           success: function(data) {
             debugger;
             sessionStorage["currentWorld"] = world;
           },
           error: function(jqXHR, t, e) {
             debugger;
           }
       });
            
      window.location = "plan.php";
}

function loadPlayerVillages() {
	 if ($("#dontload").length != 0)
	 	return false;
	 getVillages();
	  
	 function getVillages() {
		debugger;

	    $.ajax({
           url:('scripts/loadvillagesforplan.php'),
           timeout: 5000, // 5 secs
           success: function(data){
					debugger;
					parseVillages(data);
					$("#loading").remove();
           },
           error: function(jqXHR, t, e) {
           		$('#step1container').html("PHP Error thrown!<br />error message: AJAX loadPlayerVillages() " + e + " " + t + "<br />If this was a timeout error, try refreshing the page. It's just taking awhile to send the data from the server to you.<br />Please fill out a <a href=\"twplan.com/bugreport\">bug report</a> :)");
           }
      	});
	  }
	  
	  function parseVillages(data) { // should be in JSON
	  		var $data = JSON.parse(data);
			var $s = "";
			var $vid;
			$.each($data, function(index, element) {
				$vid = element["villageid"];
				$s += "<tr id='" + $vid + "r' style='height:10px;'><td style='display:none'><input type='checkbox' id='" + $vid + "' name='selectedVillages[]' /></td><td class='villagename'>" + unescape(element["name"].replace(/\+/g, " ")) + "</td><td class='coordsearch' id='" + $vid + "c'>" + element["xcoord"] + "|" + element["ycoord"] + "</td><td>K" + element["ycoord"].substring(0, 1) + element["xcoord"].substring(0, 1) + "</td><td class='unitoff'><img id='" + $vid + "_0' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/spear.png' /></td><td class='unitoff'><img id='" + $vid + "_1' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/sword.png' /></td><td class='unitoff'><img id='" + $vid + "_2' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/axe.png' /></td><td class='unitoff'><img id='" + $vid + "_3' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/archer.png' /></td><td class='unitoff'><img id='" + $vid + "_4' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/scout.png' /></td><td class='unitoff'><img id='" + $vid + "_5' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/lc.png' /></td><td class='unitoff'><img id='" + $vid + "_6' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/hc.png' /></td><td class='unitoff'><img id='" + $vid + "_7' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/marcher.png' /></td><td class='unitoff'><img id='" + $vid + "_8' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/ram.png' /></td><td class='unitoff'><img id='" + $vid + "_9' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/cat.png' /></td><td class='unitoff'><img id='" + $vid + "_10' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/pally.png' /></td><td class='unitoff'><img id='" + $vid + "_11' onClick='handleUnitClick(this.id)' src='http://static-twplan.appspot.com/images/units/noble.png' /></td><td class='attacktype'><form><label for='" + $vid + "_noble'>Noble</label><input type='radio' name='attacktype' id='" + $vid + "_noble' onClick='handleRadioClick(this.id)' /><label for='" + $vid + "_nuke'>Nuke</label><input type='radio' name='attacktype' id='" + $vid + "_nuke' onClick='handleRadioClick(this.id)' /><label for='" + $vid + "_support'>Support</label><input type='radio' name='attacktype' id='" + $vid + "_support' onClick='handleRadioClick(this.id)' /></form></td><td><button id='" + $vid + "b' onClick='addVillageToPlan(this.id); return false;' disabled>Add Village</button></td></tr>";
			});
	  		$("#villages > tbody:last").last().append($s);
	  }
}

/* ===== Dropdown Topnavbar Menu ====== */

$(document).ready(function(){
	
	if ($("#welcome").length == 0)
		return;
	
	var $leftBound;
	var $rightbound;
	var $topBound
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