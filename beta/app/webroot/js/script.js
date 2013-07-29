/* ====== Global ====== */

var units = new Array("spear", "sword", "axe", "archer", "scout", "lc", "hc", "marcher", "ram", "cat", "pally", "noble");
var worldInfo = {
	11: {
		speed: 1,
		unitSpeed: 1
	},
	19: {
		speed: 1.5,
		unitSpeed: 1
	},
	30: {
		speed: 1,
		unitSpeed: 1
	},
	38: {
		speed: 2,
		unitSpeed: 0.5
	},
	42: {
		speed: 1.25,
		unitSpeed: 0.8
	},
	46: {
		speed: 1.2,
		unitSpeed: 1
	},
	48: {
		speed: 1,
		unitSpeed: 1
	},
	50: {
		speed: 2,
		unitSpeed: 0.6
	},
	54: {
		speed: 1,
		unitSpeed: 1
	},
	55: {
		speed: 1.1,
		unitSpeed: 1.3
	},
	56: {
		speed: 2,
		unitSpeed: 0.6
	},
	57: {
		speed: 1.25,
		unitSpeed: 1
	},
	58: {
		speed: 1.5,
		unitSpeed: 0.8
	},
	59: {
		speed: 1,
		unitSpeed: 1
	},
	60: {
		speed: 1.25,
		unitSpeed: 0.8
	},
	61: {
		speed: 1.5,
		unitSpeed: 0.8
	},
	62: {
		speed: 1.75,
		unitSpeed: 0.75
	},
	63: {
		speed: 1,
		unitSpeed: 1
	},
	64: {
		speed: 1.5,
		unitSpeed: 0.75
	},
	65: {
		speed: 2,
		unitSpeed: 0.65
	},
	66: {
		speed: 1,
		unitSpeed: 1
	},
	67: {
		speed: 1.5,
		unitSpeed: 0.75
	},
	68: {
		spped: 1,
		unitSpeed: 1
	},
	69: {
		speed: 1.5,
		unitSpeed: 0.8
	}
};

tableLength = 0;
notEnough = false;
localOffset = 0;

stepOneAvailable = {"nobles": 0, "nukes": 0, "supports": 0};
stepTwoAvailable = {"nobles": 0, "nukes": 0, "supports": 0};

window.onerror = function (msg, url, linenumber) {
	reportThis = confirm('Error: ' + msg + '\n\nWould you like to report the error to improve TWplan?');
	if (reportThis) {
		debugger;
		$bMsg = 'Error message: ' + msg + '\nURL: ' + url + '\nLine Number: ' + linenumber;
		$dataToSend = {"page": $("h1").html(), "errormsg": $bMsg, "bugnature": prompt("Enter any deatils about the bug here."), "user": $("#username").html(), "world": sessionStorage.currentWorld, "skype": prompt("Please leave your Skype name if you are okay with being contacted."), "auto": "true"};

		$.ajax({
			type: 'POST',
			url: ('storebugreport.php'),
			data: $dataToSend,
			timeout: 5000, // 5 secs
			success: function (data) {
				debugger;
				alert("Thanks for your help. Sorry for any inconvenience.");
			},
			error: function (data) {
				debugger;
				alert("Please use manual report. Submission error:" + t + " " + e);
			}
		});
	}
	return true;
};

/* ====== Back Functions ====== */
/*
function backToStep1() {
	$('#step2container').fadeOut('fast');
	$('#step1container').show('fast');
	$("#instructions").html("Below is a list of your villages. Select the ones you wish to include in the plan and choose the slowest traveling times, respectively. Choose how you want to classify each attack (noble, nuke, support). Common defaults are in place, but change them accordingly if needed (i.e. sending HC as an attack instead of support).<br /><br />At the bottom of the page is a table with all the villages you add to your plan.");
	$($("h1")[0]).html("Planning - Step 1");
	// sessionStorage will be overwritten when the villages are submitted again on step 1
}

function backToStep2() {
	$('#step3container').fadeOut('fast');
	$('#step2container').show('fast');
	$('#instructions').html("Next, enter the coordinates of your targets. Choose how many of each command (noble, nuke, and support) you want to send to each village - the commands available are determined by your village selections in Step 1. Use the Mass Input to set the same information for groups of targets.");
	$($("h1")[0]).html("Planning - Step 2");
	// sessionStorage will be overwritten when the villages are submitted again on step 2
}

function backToStep2a() {
	$('#results').fadeOut('fast');
	$('#step3container').show('fast');
	var s = '<tr><th>Village</th><th>Target</th><th>Slowest Unit</th><th>Attack Type</th><th>Traveling Time</th><th>ST Launch Time</th><th>Local Launch Time</th><th>Time Remaining</th><th>Launch Link</th></tr>';
	$("#resulttable").html(s); // clears results table
	$('#instructions').html("Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!<br /><br />TWplan's algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the \"early bound\" and the \"late bound\".");
	$($("h1")[0]).html("Planning - Step 3");
	// sessionStorage will be overwritten when the villages are submitted again on step 2
}
*/
/* ====== Group Functions ====== */

function createGroup() {
	$("#loading").show("fast");

	$.ajax({
		type:'GET',
		url:('scripts/loadvillagesforgroup.php'),
		   timeout: 6000, // 6 secs
		   success: function(data){
		   	debugger;
		   	$("#instructions").hide();
		   	$("#groupdisplay").hide();
		   	$("#creategroupdisplay").html(data);
		   },
		   error: function(jqXHR, t, e) {
		   	$('#step1container').html("Error loading villages:" + t + " " + e);
		   }
		});

	$("#loading").hide();
	$("#creategroupdisplay").show("fast");
}

function addVillagesToGroupBulk(id) {
	var $coords = $('#villagecoordsbulk').val().match(/[0-9]{3}\|[0-9]{3}/g);

	if ($coords == null) {
		alert("Please enter at least one valid coordinate in the form xxx|yyy to use the mass village select.");
		return false;
	}

	var $row;

	var $search = $('.coordsearch');
	for (var $i = 0; $i < $search.length; $i++) {
		for (var $j = $coords.length-1; $j >= 0; $j--) {
			if ($coords[$j] == $search[$i].innerHTML) {
				var $id = ($search[$i].getAttribute('id')).slice(0, -1); // removes "_c" off end, leaving just the village id (id for checkbox)
				addVillageToGroup($id + "b");
				$coords.splice($j, 1); // removes coord from array
			}
		}
	}
	$('#villagecoordsbulk').val("");
}

function addVillageToGroup(id) {
	var $vid = id.slice(0,-1) + "r";
	var $p = id.slice(0,-1); // pure id

	$("#" + $p).val($("#" + $p + "n").html() + "~" + $("#" + $p + "c").html() + "~" + $("#" + $p + "k").html() + "~" + $p); // sets checkbox i.e. name~555|555~continent~id
	$("#" + $p).prop("checked", true);

	var $copy = $('#' + $vid).clone();

	$copy[0].id += "f";

	var $tds = $copy.children("td");

	$.each($tds, function(index, element) {
		if ($(element).attr("style") == "display:none") { // looking for hidden checkbox
			$(element).children("input").attr("id", $(element).children("input").attr("id") + "f");

			return true; // continue
		}

		if ($(element).children("button").length != 0) { // looking for add button
			$(element).children("button").attr("id", $(element).children("button").attr("id") + "f");
			$(element).children("button").attr("onclick", "removeVillageFromGroup(this.id); return false;");
			$(element).children("button").html("Remove Village");
			debugger;
			$("#" + $(element).children("button").attr("id").slice(0,-1)).prop("disabled", true); // disable original button
		}

	}
	)

	$("#" + $p + "r").fadeOut("slow");

	$("#villagesingroup > tbody:last").last().append($copy);
}

function removeVillageFromGroup(id) {
	$("#" + id.slice(0,-2) + "rf").remove();
	$("#" + id.slice(0,-1)).prop("disabled", false); // enable original button
	$("#" + id.slice(0,-2) + "r").fadeIn("fast");
}

function saveGroup() {
	if ($("#groupname").val() == "") {
		alert("Please enter a name for the group.");
		return false;
	}

	$dataString = $("#sendgroupinfo").serializeArray();

	$group = new Array(); // array of villagename, coords, continent, id

	$.each($dataString, function(i, value) {
		$values = value.value.split("~");
		$group.push({"villageName": $values[0], "coords": $values[1], "continent": $values[2], "id": $values[3]});
	});

	$dataToSend = {"groupname": $("#groupname").val(), "group": JSON.stringify($group)};

	$.ajax({
		type:'POST',
		url:('scripts/savegroup.php'),
		data: $dataToSend,
		timeout: 10000,
		success: function(data) {
			debugger;
			window.location.reload(true);
		},
		error: function(jqXHR, t, e) {
			debugger;
		}
	});
}

function displayGroup(name) {
	if (name == "Choose a group...")
		return;

	var $dataToSend = {"groupname": name};

	$.ajax({
		type:'POST',
		url:('scripts/loadgroup.php'),
		data: $dataToSend,
		timeout: 10000,
		success: function(data) {
			$('#groupdisplay').html(data);
			debugger;
		},
		error: function(jqXHR, t, e) {
			debugger;
		}
	});
}

function deleteVillageFromGroup(name, id) {
	var $dataToSend = {"groupname": name, "villageid": id};
	debugger;

	$.ajax({
		type:'POST',
		url:('scripts/deletevillagefromgroup.php'),
		data: $dataToSend,
		timeout: 10000,
		success: function(data) {
			debugger;
			displayGroup(name);
			debugger;
		},
		error: function(jqXHR, t, e) {
			debugger;
		}
	});
}

function deleteGroup() {
	var $groupname = {"groupname": $('#choosegroup').val()};

	$.ajax({
		type:'POST',
		url:('scripts/deletegroup.php'),
		data: $groupname,
		timeout: 10000,
		success: function(data) {
			debugger;
			 document.location.reload(true); // refresh
			},
			error: function(jqXHR, t, e) {
				debugger;
			}
		});
}

function doesGroupExist() {
	$.ajax({
		type:'GET',
		url:('scripts/doesgroupexist.php?groupname=' + $('#groupname').val()),
		timeout: 6000,
		async: false,
		success: function(data) {
			if (data) {
				var s = 'You already have a group created with name "' + $('#groupname').val() + '" on this world! Please choose another name for this group or delete the other one first.';
				alert(s);
				return false;
			}
			else
				saveGroup();
		},
		error: function(jqXHR, t, e) {
			debugger;
			return false;
		}
	});
}

/* ====== Saved Functions ====== */

function deleteCommand(name, village, target) {
	var $dataToSend = {"planname": name, "village": village, "target": target};

	$.ajax({
		type:'POST',
		url:('scripts/deletecommand.php'),
		data: $dataToSend,
		timeout: 10000,
		success: function(data) {
			debugger;
			displayPlan(name);
			debugger;
		},
		error: function(jqXHR, t, e) {
			debugger;
		}
	});
}

function deletePlan() {
	var planname = {"planname": $('#chooseplan').val()};

	$.ajax({
		type:'POST',
		url:('scripts/deleteplan.php'),
		data: planname,
		timeout: 10000,
		success: function(data) {
			debugger;
			 document.location.reload(true); // refresh
			},
			error: function(jqXHR, t, e) {
				debugger;
			}
		});
}

function displayPlan(name) {
	if (name == "Choose a plan...")
		return;

	var $dataToSend = {"planname": name};

	$.ajax({
		type:'POST',
		url:('scripts/loadplan.php'),
		data: $dataToSend,
		timeout: 10000,
		success: function(data) {
			$('#savedplandisplay').html(data);
			debugger;
		},
		error: function(jqXHR, t, e) {
			debugger;
		}
	});

	countdown();
}

function doesPlanExist() {
	$.ajax({
		type:'GET',
		url:('scripts/doesplanexist.php?planname=' + $('#planname').val()),
		timeout: 6000,
		async: false,
		success: function(data) {
			if (data) {
				var s = 'You already have a plan saved with name "' + $('#planname').val() + '"! Do you want to overwrite it?';
				y = confirm(s);
				if (!y) {
					debugger;
					return false;
					debugger;
				}
				else
					storePlan(true);
			}
			else
				storePlan(false);
			debugger;
		},
		error: function(jqXHR, t, e) {
			debugger;
		}
	});
}

function storePlan(y) {
	debugger;
	$('#loadingcircle').show();
	var $dataToSend = {"planname": $('#planname').val(), "landingDate": $('#landingdate').val(), "landingTime": $('#landingtime').val(), "plan": localStorage["currentPlan"], "overwrite": y};
	debugger;
	$.ajax({
		type:'POST',
		url:('scripts/saveplan.php'),
		data: $dataToSend,
		   timeout: 10000, // 10 seconds
		   success: function(data) {
		   	$('#planname').hide();
		   	$('#plannamelabel').hide();
		   	$('#save').hide();
		   	$('#saveresults').html("Plan successfully saved as " + $('#planname').val() + ".<br /> You can view it in the <a href='saved.php'>Saved</a> tab.");
		   	$('#saveresults').show();
		   	$('#loadingcircle').hide();
		   	debugger;
		   },
		   error: function(jqXHR, t, e) {
		   	$('#planname').hide();
		   	$('#plannamelabel').hide();
		   	$('#save').html("Try Save Again");
		   	$('#saveresults').html("Error saving plan:" + e + "\n\n If this was a timeout error, click \"Try Save Again\" :)");
		   	$('#saveresults').show();
		   	$('#loadingcircle').hide();
		   	debugger;
		   }
		});
}

function collectPlan() {
	var n = new Date();
	var world = sessionStorage["currentWorld"];
	var $dataToSend = {"plan": localStorage["currentPlan"], "landingDate": $('#landingdate').val(), "landingTime": $('#landingtime').val(), "timeZone": (((n.getTimezoneOffset())/60) + 1), "worldSpeed":worldInfo[world].speed, "unitSpeed":worldInfo[world].unitSpeed};

	$.ajax({
		type:'POST',
		url:('scripts/collectplan.php'),
		data: $dataToSend,
		   timeout: 10000, // 10 seconds
		   success: function(data) {
		   	debugger;
		   	$('#collectplan').html("Plan sent successfully! I appreciate your help - hope you're enjoying TWplan.").delay(3000).fadeOut('slow');
		   },
		   error: function(jqXHR, t, e) {
		   	debugger;
		   }
		});
}

/* ====== Countdown ====== */

var countdownTimer = null; // prevents creation of a multiple countdown effect

function countdown() {
	if (countdownTimer == null) {
		countdownTimer = setInterval(function() {doCountdown();}, 1000);
		debugger;
	}
	else {
		clearInterval(countdownTimer);
		debugger;
		countdownTimer = setInterval(function() {doCountdown();}, 1000);
	}
}

function doCountdown() {
	$('.countdown').each(function() {
		if (this.abbr >= 0) {
			$(this).html(formatSeconds(this.abbr));
			this.abbr--;
		}
		else
			$(this).html("Expired!");
	});
}

function formatSeconds(secs) {
	var pad = function(n) {
		return (n < 10 ? "0" + n : n);
	};

	var h = Math.floor(secs / 3600);
	var m = Math.floor((secs / 3600) % 1 * 60);
	var s = Math.floor((secs / 60) % 1 * 60);
	return pad(h) + ":" + pad(m) + ":" + pad(s);
};

/* ====== Planning Step 3 ====== */

function hungarianAnalytics() {
	if ($("#timingrestriction").prop("checked") == false)
		return false;

	var tried = 0;
	var accurate = 0;

	var time = new Date($('#landingdate').val() + " " + $('#landingtime').val()).getTime(); // in ms
	var early = ($('#earlybound').val()).substring(0,1);
	var late = ($('#latebound').val()).substring(0,2);

	$('.countdown').each(function() {
		var sendHour = new Date(time - this.abbr).getHours();
		if (sendHour >= early && sendHour < late)
			accurate++;
		tried++;
	});

	$.ajax({
		type:'GET',
		url:('scripts/analytics.php?tried=' + tried + '&accurate=' + accurate),
		   timeout: 6000, // 6 secs
		   success: function(data){
		   	debugger;
		   },
		   error: function(jqXHR, t, e) {
		   	debugger;
		   }
		});
}

function dist(village, target, speed) {
	if (village && target && speed) {
		var a = village.split("|");
		var b = target.split("|");
		var d = Math.sqrt(Math.pow(a[0]-b[0], 2) + Math.pow(a[1]-b[1], 2));

		var world = sessionStorage["currentWorld"];

		return (d*(unitSpeeds[speed])/((worldInfo[world].speed)*(worldInfo[world].unitSpeed)))*60000;
	}
}


function reSubmitHungarian() {
	if ($('#newlandingtime').val().match(/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/) == null) {
		alert("Sorry, TWplan doesn't recognize the time you submitted. Use hh:mm:ss format please.");
		return false;
	}

	var s = '<tr><th>Village</th><th>Target</th><th>Slowest Unit</th><th>Attack Type</th><th>Traveling Time</th><th>ST Launch Time</th><th>Local Launch Time</th><th>Time Remaining</th><th>Launch Link</th></tr>';

	$('#resulttable').html(s);

	$('#landingdate').val($('#newlandingdate').val());
	$('#landingtime').val($('#newlandingtime').val());

	submitHungarian();

	$('#newlandingdate').val("");
	$('#newlandingtime').val("");

	$('#planname').show();
	$('#planname').val("");
	$('#plannamelabel').show();
	$('#save').show();
	$('#saveresults').hide();

	return false;
}

function submitHungarian() { // step 3 submit
	if ($('#landingtime').val().match(/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/) == null) {
		alert("Sorry, TWplan doesn't recognize the time you submitted. Use hh:mm:ss format please.");
		return false;
	}

	if ($('#landingdate').val() == "") {
		alert("Please enter landing date information.");
		return false;
	}

	Date.prototype.stdTimezoneOffset = function() {
		var jan = new Date(this.getFullYear(), 0, 1);
		var jul = new Date(this.getFullYear(), 6, 1);
		return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
	}

	Date.prototype.dst = function() {
		return this.getTimezoneOffset() < this.stdTimezoneOffset();
	}

	var n = new Date();

	if (n.dst())
		var offset = ((n.getTimezoneOffset())/60)+1;
	else
		var offset = ((n.getTimezoneOffset())/60);
	// gets difference; positive if west of UTC, negative if east
	// +1 when daylight savings is active!

	var dateOffsetted = new Date (n.getTime() + offset*3600000);
	debugger;

	var land = new Date($('#landingdate').val() + " " + $('#landingtime').val()).getTime(); // given in server time

	var hold = new Array("Nobles", "Nukes", "Supports");

	var s = "";
	var e1 = "Attack Plan Landing on " + $('#landingdate').val() + " (ST) at " + $('#landingtime').val() + "\n \n";
	var e2 = "Attack Plan Landing on " + $('#landingdate').val() + " (ST) at " + $('#landingtime').val() + "\n \n [table][**]Village[||]Target[||]Slowest Unit[||]Attack Type[||]Launch Time[/**]";

	var info = new Array(); // Array of [village, target, slowestunit, attacktype, travelingtime, launchtime, ab]

	for (var i = 0; i < hold.length; i++) {
		var v = JSON.parse(sessionStorage["village" + hold[i]]); // array (coords, type, id)
		var t = JSON.parse(sessionStorage["target" + hold[i]]);

		var result = hungarian(v[0], t, v[1]); // array where index=village location and value=target location

		for (var k = result.length-1; k >= 0; k--) {
			debugger;
			if (t[result[k]] == "000|000") { // removes the dummy cells
				result.splice(k, 1);
				debugger;
			}
		}

		for (var j = 0; j < result.length; j++) {
			var at = hold[i].slice(0, -1); // attack type
			var d = dist(v[0][j], t[result[j]], v[1][j]); // traveling time
			var d2 = d/1000;
			var lt = (new Date(land-d)); // launch time
			var ltFormated = lt.toString().slice(0, 24);
			var slow = v[1][j].toLowerCase().replace(/\b[a-z]/g, function(letter) {
				return letter.toUpperCase();
												   }); // troop type, capitalized
			var ab = ((new Date(lt - dateOffsetted)).getTime())/1000; // secs until launch
			var ltms = (new Date(lt - offset*3600000).getTime())/1000; // launch time in ms

			info.push({"v": v[0][j], "t": t[result[j]], "slow": slow, "at": at, "tt": formatSeconds(d2), "lt": ltFormated, "ab": ab, "ltms": ltms, "id": v[2][j]});
		 // alert("offset: " + offset + "\nvillage: " + v[j] + "\ntarget: " + t[j] + "\nformatSeconds: " + formatSeconds(d2) + "\nlt: " + ltFormated);
		}
	}

	info.sort(function(a, b) {
		return (a.ab - b.ab);
	});

	for (var k = 0; k < info.length; k++) {
		var v = info[k].v;
		var coords = v.split("|");
		var t = info[k].t;
		var slow = info[k].slow;
		var at = info[k].at;
		var tt = info[k].tt;
		var lt = info[k].lt;
		var ab = info[k].ab;
		var url = "http://en" + sessionStorage["currentWorld"] + ".tribalwars.net/game.php?village=" + info[k].id + "&screen=place&x=" + coords[0] + "&y=" + coords[1] + "&attacktype=" + at.toLowerCase();

		var ltDateObj = new Date(lt);
		var localLt = new Date(ltDateObj.setTime(ltDateObj.getTime() + (localOffset*60*60*1000)));
		var localLtFormated = localLt.toString().slice(0, 24);

		s += "<tr><td>" + v + "</td><td>" + t + "</td><td>" + slow + "</td><td>" + at + "</td><td>" + tt + "</td><td>" + lt + "</td><td>" + localLtFormated + "</td><td class=\"countdown\" abbr=\"" + ab  + "\"></td><td><a target=\"_blank\" href=\"" + url + "\">Link</a></td></tr>";
		e1 += "Send " + slow + " (" + at + ") from [village]" + v + "[/village] to [village]" + t + "[/village] at [b]" + lt + "[/b] \n";
		e2 += "[*][village]" + v + "[/village][|][village]" + t + "[/village][|]" + slow + "[|]" + at + "[|]" + lt;
	}

	e2 += "[/table]";

	$("#resulttable > tbody:last").last().append(s);

	localStorage["currentPlan"] = JSON.stringify(info);

	$('#step3container').fadeOut('slow');
	$('#results').height(info.length*50+400); debugger;
	$('#results').show('fast');
	$('html, body').animate({scrollTop:0}, 100);
	$('h1').html("Results");
	$('#instructions').html("Below are the results of your attack plan. You can export the information to copy into your TW notebook, and/or save the data for later access.");
	$('#attackplantitle').html("Attack Plan Landing on " + $('#landingdate').val() + " at " + $('#landingtime').val() + " (ST)");

	countdown();

	$('#export1').val(e2);
	$('#export2').val(e1);

	hungarianAnalytics();
}

/* ======= Planning Step 2 ======= */

/*
function submitTargets() {  // step 2 submit
	stepTwoUpdateAvailable();

	if (notEnough) {
		alert("You have selected more nobles, nukes, or supports than you have available. Please correct this by making sure no value in the \"Troops Remaining\" box is in the negative (red).\n\n" + $('#availablenukes').html() + "\n" + $('#availablenobles').html() + "\n" + $('#availablesupports').html());
		notEnough = false;
		return false;
	}

	var ignore = false;
	var $table = $('#targetvillages');

	if ((($table.children())[0].children.length) == 1) {
		alert("You haven't selected any targets! Please choose at least one. Why else would you be using this planner? :)");
		return false;
	}

	var $nobles = new Array();
	var $nukes = new Array();
	var $supports = new Array();

	for (var $i = 1; $i <= tableLength; $i++) {
		var $row = $table.children().find('tr:eq(' + $i + ')');
		var $c = $row.find('td:eq(0)').html();
		var $no = $row.find('td:eq(1)').find('input').val();
		var $nu = $row.find('td:eq(2)').find('input').val();
		var $s = $row.find('td:eq(3)').find('input').val();

		if (($no + $nu + $s) <= 0) {
			if (ignore)
				continue;
			var err = confirm("Not all targets have command information set! Do you want to proceed?");
			if (err) {
				ignore = true;
				continue;
			}
			else {
				$('html, body').animate({scrollTop:0}, 100);
				return false;
			}
		}


		for (var $j = 0; $j < $no; $j++)
			($nobles).push($c);
		for (var $j = 0; $j < $nu; $j++)
			($nukes).push($c);
		for (var $j = 0; $j < $s; $j++)
			($supports).push($c);
	}

	if (($nobles).length < sessionStorage["villageNoblesLength"]) {
		while (($nobles).length < sessionStorage["villageNoblesLength"])
			($nobles).push("000|000");
	}


	if (($nukes).length < sessionStorage["villageNukesLength"]) {
		while (($nukes).length < sessionStorage["villageNukesLength"])
			($nukes).push("000|000");
	}

	if (($supports).length < sessionStorage["villageSupportsLength"]) {
		while (($supports).length < sessionStorage["villageSupportsLength"])
			($supports).push("000|000");
	}

	sessionStorage["targetNobles"] = JSON.stringify($nobles);
	sessionStorage["targetNukes"] = JSON.stringify($nukes);
	sessionStorage["targetSupports"] = JSON.stringify($supports);

	$('html, body').animate({scrollTop:0}, 100);
	$('h1').html("Planning - Step 3");
	$('#instructions').html("Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!<br /><br />TWplan's algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you check the Send Time Optimization box below, TWplan will try to plan commands to have launch times <i>between</i> the \"early bound\" and the \"late bound\".");
	$('#step2container').fadeOut('fast');
	$('#step3container').show('fast');

	// gets the local timezone offset
	$.ajax({
		url:('scripts/localtimezone.php'),
		   timeout: 6000, // 6 secs
		   success: function(data){
		   	debugger;
		   	if (data != "None")
		   		localOffset = parseInt(data.split("")[3] + data.match(/\d+/));
		   },
		   error: function(jqXHR, t, e) {
		   	throw "Error loading local timezone data.";
		   }
		});
}

function removeVillageFromTable(trId) {
	var $inputs = $("#" + trId).find("input");

	if (!isNaN(parseInt($inputs[0].value)))
		stepTwoAvailable["nobles"] = parseInt($inputs[0].value) + parseInt(stepTwoAvailable["nobles"]);
	if (!isNaN(parseInt($inputs[1].value)))
		stepTwoAvailable["nukes"] = parseInt($inputs[1].value) + parseInt(stepTwoAvailable["nukes"]);
	if (!isNaN(parseInt($inputs[2].value)))
		stepTwoAvailable["supports"] = parseInt($inputs[2].value) + parseInt(stepTwoAvailable["supports"]);

	$('#' + trId).remove();

	stepTwoUpdateAvailable(); // updates
}

function handleCommandQuantityChange(obj, attacktype) {
	debugger;
	var $diff = obj.value - obj.oldValue;

	switch (attacktype) { // attacktypes are numbers because of issues with escaping strings
		case 0: stepTwoAvailable["nobles"] = parseInt(stepTwoAvailable["nobles"]) - $diff; break;
		case 1: stepTwoAvailable["nukes"] = parseInt(stepTwoAvailable["nukes"]) - $diff; break;
		case 2: stepTwoAvailable["supports"] = parseInt(stepTwoAvailable["supports"]) - $diff; break;
		default: return false;
	}

	stepTwoUpdateAvailable();
}

function stepTwoUpdateAvailable() {
	$('#availablenobles').html(stepTwoAvailable["nobles"]);
	$('#availablenukes').html(stepTwoAvailable["nukes"]);
	$('#availablesupports').html(stepTwoAvailable["supports"]);

	if (stepTwoAvailable["nobles"] < 0) {
		$('#availablenobles').css('color', 'red');
		notEnough = true;
	}
	else
		$('#availablenobles').css('color', 'black');

	if (stepTwoAvailable["nukes"] < 0) {
		$('#availablenukes').css('color', 'red');
		notEnough = true;
	}
	else
		$('#availablenukes').css('color', 'black');

	if (stepTwoAvailable["supports"] < 0) {
		$('#availablesupports').css('color', 'red');
		notEnough = true;
	}
	else
		$('#availablesupports').css('color', 'black');
}

function addVillageToTable(coords, nov, nuv, sv) {
	if (coords.match(/^[0-9]{3}\|[0-9]{3}/)) {
		var splitCoords = coords.split("|");
		$("#targetvillages > tbody:last").last().append("<tr id='c" + splitCoords[0] + splitCoords[1] + "'><td>" + coords + "</td><td>Nobles <input type='number' min='0' value='" + nov + "' class='nobles' onFocus='this.oldValue = this.value' onChange='handleCommandQuantityChange(this, 0);this.oldValue = this.value' /><td>Nukes <input type='number' min='0' value='" + nuv + "' class='nukes' onFocus='this.oldValue = this.value' onChange='handleCommandQuantityChange(this, 1);this.oldValue = this.value' /></td></td><td>Support <input type='number' min='0' value='" + sv + "' class='supports' onFocus='this.oldValue = this.value' onChange='handleCommandQuantityChange(this, 2);this.oldValue = this.value' /><td><a href='#' onClick=\"removeVillageFromTable('c" + splitCoords[0] + splitCoords[1] + "')\"><img src='/images/delete.png' /></a></td></tr>").hide().fadeIn('fast');
		$("#targetcoords").val("");
		tableLength++;
		return true;
	}
}

function addVillagesToTable(pastein) {
	var coords = pastein.match(/[0-9]{3}\|[0-9]{3}/g);
	for (var i = 0; i < coords.length; i++)
		addVillageToTable(coords[i], $('#bulktargetnobles').val(), $('#bulktargetnukes').val(), $('#bulktargetsupports').val());

	stepTwoAvailable["nobles"] -= ($('#bulktargetnobles').val()*coords.length);
	stepTwoAvailable["nukes"] -= ($('#bulktargetnukes').val()*coords.length);
	stepTwoAvailable["supports"] -= ($('#bulktargetsupports').val()*coords.length);

	debugger;

	$('#targetcoordsbulk').val("");
	$('#bulktargetnobles').val("");
	$('#bulktargetnukes').val("");
	$('#bulktargetsupports').val("");

	stepTwoUpdateAvailable();
	return false;
}
*/
/* ======= Planning Step 1 ======= */

/*
function submitVillages() {  // step 1 submit
	var ignore = false;
	var form = $('#sendvillageinfo');

	var nobles = new Array(new Array(), new Array(), new Array()); // coords, type, id
	var nukes = new Array(new Array(), new Array(), new Array()); // coords, type, id
	var supports = new Array(new Array(), new Array(), new Array()); // coords, type, id

	var dataString = form.serializeArray();

	var l = 0;
	for (var i = 0; i < dataString.length; i++) {
		var p = dataString[i].value.split("~"); // 555|555~spear~support~id
		if ((dataString[i].value == "on" || dataString[i].value[0] == "on") && dataString[i].name != "attacktype") {
			if (ignore)
				continue;
			var err = confirm("Not all selected villages have attack information set! Do you want to proceed?");
			if (err) {
				ignore = true;
				continue;
			}
			else {
				$('html, body').animate({scrollTop:0}, 100);
				return false;
			}
		}
		else if (p[2] == "noble") {
			l = nobles[0].length;
			nobles[0][l] = p[0]; // coords
			nobles[1][l] = p[1]; // attack speed
			nobles[2][l] = p[3]; // id
		}
		else if (p[2] == "nuke") {
			l = nukes[0].length;
			nukes[0][l] = p[0]; // coords
			nukes[1][l] = p[1]; // attack speed
			nukes[2][l] = p[3]; // id
		}
		else if (p[2] == "support") {
			l = supports[0].length;
			supports[0][l] = p[0]; // coords
			supports[1][l] = p[1]; // attack speed
			supports[2][l] = p[3]; // id
		}
	}

	if ((nobles.length + nukes.length + supports.length) == 0) {
		alert("You haven't selected any villages! Please choose at least one. Why else would you be using this planner? :)");
		return false;
	}

	sessionStorage["villageNobles"] = JSON.stringify(nobles);
	sessionStorage["villageNukes"] = JSON.stringify(nukes);
	sessionStorage["villageSupports"] = JSON.stringify(supports);

	sessionStorage["villageNoblesLength"] = nobles[0].length;
	sessionStorage["villageNukesLength"] = nukes[0].length;
	sessionStorage["villageSupportsLength"] = supports[0].length;

	stepTwoAvailable["nobles"] = sessionStorage.villageNoblesLength;
	stepTwoAvailable["nukes"] = sessionStorage.villageNukesLength;
	stepTwoAvailable["supports"] = sessionStorage.villageSupportsLength;

	$('#step1container').fadeOut('slow');
	$('#step2container').show('fast');
	$('html, body').animate({scrollTop:0}, 100);
	$('h1').html("Planning - Step 2");
	$('#instructions').html("Next, enter the coordinates of your targets. Choose how many of each command (noble, nuke, and support) you want to send to each village - the commands available are determined by your village selections in Step 1. Use the Add Many Targets feature to set the same information for many targets at once.");
	stepTwoUpdateAvailable();

	$('#availablevillages').css("visibility", "visible");

	return false;
}

function addVillageToPlan(id) { // step 1 add to plan
	var $vid = id.slice(0,-1) + "r";
	var $copy = $('#' + $vid).clone();

	$copy[0].id += "f";

	var $tds = $copy.children("td");

	var $attacktype = "";

	$.each($tds, function(index, element) {
		debugger;

		if ($(element).attr("style") == "display:none") { // looking for hidden checkbox
			$(element).children("input").attr("id", $(element).children("input").attr("id") + "f");
			var $value = $(element).children("input").attr("value").split("~");
			$attacktype = $value[2]; // nuke, noble, or support

			return true; // continue
		}

		if ($(element).attr("class") == "unitoff") { // looking for slowest unit
			if ($(element).children("img").css("border") != "2px solid red")
				$(element).remove();
			else {
				$(element).children("img").css("border", "none");
				$(element).children("img").attr("onclick", "");

				debugger;
				$("#" + $(element).children("img").attr("id")).css("border", "none"); // clears border around original
			}

			return true; // continue
		}

		if ($(element).attr("class") == "attacktype") { // looking for attack type
			$(element).html($attacktype);
			$(element).css("text-transform", "capitalize");

			debugger;
			$("#" + id.slice(0,-1) + "_" + $attacktype).prop("checked", false); // unchecks original

			return true; // continue
		}

		if ($(element).children("button") != null) { // looking for add button
			$(element).children("button").attr("id", $(element).children("button").attr("id") + "f");
			$(element).children("button").attr("onclick", "removeVillageFromPlan(this.id); return false;");
			$(element).children("button").html("Remove Village");
		}

	$("#" + id.slice(0,-1) + "b").attr("disabled", true); // disables add village button
	$("#" + id.slice(0,-1) + "b").blur(); // removes focus
}
)

$("#" + id.slice(0,-1) + "r").effect("highlight", {color:"#a9a96f"}, 2000);

$("#villagesinplan > tbody:last").last().append($copy);

stepOneUpdateAvailable($attacktype, true);
}

function removeVillageFromPlan(id) { // step 1 remove from plan
	var $tr = $("#" + id.slice(0,-2) + "rf");
	var $tds = $tr.children("td");

	var $attacktype;

	$.each($tds, function(index, element) {
		if ($(element).attr("class") == "attacktype") // looking for attack type
			$attacktype = $(element).html().toLowerCase();
	});

	$tr.remove();

	stepOneUpdateAvailable($attacktype, false);
}

function stepOneUpdateAvailable(attacktype, add) {
	switch (attacktype) { // attacktypes are numbers because of issues with escaping strings
		case "noble": {
			if (add)
				stepOneAvailable["nobles"]++;
			else
				stepOneAvailable["nobles"]--;
			$('#selectednobles').html(stepOneAvailable["nobles"]);
			break;
		}
		case "nuke": {
			if (add)
				stepOneAvailable["nukes"]++;
			else
				stepOneAvailable["nukes"]--;
			$('#selectednukes').html(stepOneAvailable["nukes"]);
			break;
		}
		case "support": {
			if (add)
				stepOneAvailable["supports"]++;
			else
				stepOneAvailable["supports"]--;
			$('#selectedsupports').html(stepOneAvailable["supports"]);
			break;
		}
		default: return false;
	}
}

function handleRadioClick(villageid) {
	var parts = villageid.split("_");
	var id = parts[0];

	if ($('#' + parts[0]).val() == "on") {
		var n;
		if (parts[1] == "noble") {
			$("#" + id + "_11").css("border", "2px solid red");
			n = $('#' + parts[0] + "c").html() + "~noble~noble";
		}
		else if (parts[1] == "nuke") {
			$("#" + id + "_8").css("border", "2px solid red");
			n = $('#' + parts[0] + "c").html() + "~ram~nuke";
		}
		else if (parts[1] == "support") {
			$("#" + id + "_9").css("border", "2px solid red")
			n = $('#' + parts[0] + "c").html() + "~cat~support";
		}

		$("#" + id).prop("checked", true);
		$("#" + id).val(n);

		debugger;
	}
  else { // troop speed has already been set
  	var o = $("#" + parts[0]).val();
  	var tokens = o.split("~");
  	var n = tokens[0] + "~" + tokens[1] + "~" + parts[1];
	$("#" + id).val(n); // resets value to update
}

	$("#" + id + "b").attr("disabled", false); // enables add village button
	$("#" + id + "b").focus();
}

function handleUnitClick(villageid) {
	var parts = villageid.split("_");
	var e = $("#" + parts[0]);
	e.prop("checked", true);

	var attacktype;

	switch (units[parts[1]]) {
		case "spear":
		attacktype = "support";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "sword":
		attacktype = "support";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "axe":
		attacktype = "nuke";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "archer":
		attacktype = "support";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "scout":
		attacktype = "nuke";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "lc":
		attacktype = "nuke";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "hc":
		attacktype = "support";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "marcher":
		attacktype = "nuke";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "ram":
		attacktype = "nuke";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "cat":
		attacktype = "nuke";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "pally":
		attacktype = "support";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
		case "noble":
		attacktype = "noble";
		$("#" + parts[0] + "_" + attacktype).prop("checked", true);
		break;
	}

	for (var i = 0; i < 12; i++) { // erases old borders
		var combo = parts[0] + "_" + i;
		$("#" + combo).css("border", "none");
	}

	$("#" + villageid).css("border", "2px solid red");

	switch (parts[0]) {
		case "bulkvillages":
		e.val("undef" + "~" + units[parts[1]] + "~" + attacktype);
		break;
		case "groupvillages":
		e.val("undef" + "~" + units[parts[1]] + "~" + attacktype);
		break;
		default:
			e.val($("#" + parts[0] + "c").html() + "~" + units[parts[1]] + "~" + attacktype + "~" + parts[0]); // i.e value = 555|555~spear~support~id
			break;
		}

	$("#" + parts[0] + "b").attr("disabled", false); // enables add village button
	$("#" + parts[0] + "b").focus();
}

function addVillagesToPlanBulk() {
	var $v = $('#bulkvillages').val().split("~");
	if ($v[1] == null) {
		alert("You must select a slowest troop speed in the box for the villages you are trying to add by bulk.");
		return false;
	}

	var $coords = $('#villagecoordsbulk').val().match(/[0-9]{3}\|[0-9]{3}/g);

	if ($coords == null) {
		alert("Please enter at least one valid coordinate in the form xxx|yyy to use the mass village input.");
		return false;
	}

	var $search = $('.coordsearch');
	for (var $i = 0; $i < $search.length; $i++) {
		for (var $j = $coords.length-1; $j >= 0; $j--) {
			if ($coords[$j] == $search[$i].innerHTML) {
				var $id = ($search[$i].getAttribute('id')).slice(0, -1); // removes "_c" off end, leaving just the village id (id for checkbox)
				$("#" + $id).val($coords[$j] + "~" + $v[1] + "~" + $v[2] + "~" + $id); // i.e value = 555|555~spear~support~id
				$("#" + $id).prop("checked", true);
				$("#" + $id + "_" + units.indexOf($v[1])).css("border", "2px solid red");
				$("#" + $id + "_" + $v[2]).prop("checked", true);
				$("#" + $id + "b").attr("disabled", false); // enables add village button for clone
				addVillageToPlan($id + "b");
				$coords.splice($j, 1); // removes coord from array
			}
		}
	}
	$('#villagecoordsbulk').val("");
	$("#bulkvillages_" + units.indexOf($v[1])).css("border", "none"); // clears bulk villages border
	$("#bulkvillages_" + $v[2]).prop("checked", false); // unchecks attack type
}

function addGroupToPlan() {
	$groupname = {"groupname": $("#choosegroup").val()};
	if ($groupname["groupname"] == "Choose a group to use in plan...")
		return;
	debugger;
	$.ajax({
		type:'POST',
		url:('scripts/groupvillagesforplan.php'),
		data: $groupname,
		timeout: 10000,
		success: function(data) {
			debugger;
			var $v = $('#groupvillages').val().split("~");
			if ($v[1] == null) {
				alert("You must select a slowest troop speed in the box for the villages you are trying to add by group.");
				return false;
			}

			var $coords = data.match(/[0-9]{3}\|[0-9]{3}/g);

			if (!$coords) {
				alert("Error loading group villages. Successful lookup, but no villages in group.");
				return false;
			}

			var $search = $('.coordsearch');

			for (var $i = 0; $i < $search.length; $i++) {
				for (var $j = $coords.length-1; $j >= 0; $j--) {
					if ($coords[$j] == $search[$i].innerHTML) {
							var $id = ($search[$i].getAttribute('id')).slice(0, -1); // removes "_c" off end, leaving just the village id (id for checkbox)
							$("#" + $id).val($coords[$j] + "~" + $v[1] + "~" + $v[2] + "~" + $id); // i.e value = 555|555~spear~support~id
							$("#" + $id).prop("checked", true);
							$("#" + $id + "_" + units.indexOf($v[1])).css("border", "2px solid red");
							$("#" + $id + "_" + $v[2]).prop("checked", true);
							$("#" + $id + "b").attr("disabled", false); // enables add village button for clone
							addVillageToPlan($id + "b");
							$coords.splice($j, 1); // removes coord from array
						}
					}
				}

				$("#groupvillages_" + units.indexOf($v[1])).css("border", "none"); // clears group villages border
				$("#groupvillages_" + $v[2]).prop("checked", false); // unchecks attack type
			},
			error: function(jqXHR, t, e) {
				debugger;
			}
		});
}
*/
function handleCollapse(obj, id) {
	if ($(obj).html() == "[collapse]") {
		switch(id) {
			case "mass":
			$("#massinput").hide("slide", {direction: "up"}, 500);
			break;
			case "group":
			$("#groupinput").hide("slide", {direction: "up"}, 500);
			break;
			case "single":
			$("#villages").hide("slide", {direction: "up"}, 500);
			break;
		}
		$(obj).html("[expand]");
	}
	else if ($(obj).html() == "[expand]"){
		switch(id) {
			case "mass":
			$("#massinput").show("slide", {direction: "up"}, 500);
			break;
			case "group":
			$("#groupinput").show("slide", {direction: "up"}, 500);
			break;
			case "single":
			$("#villages").show("slide", {direction: "up"}, 500);
			break;
		}
		$(obj).html("[collapse]");
	}
}