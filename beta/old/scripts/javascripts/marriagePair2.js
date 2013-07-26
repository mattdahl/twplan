var villages = [];
var targets = [];
var speeds = [];

var time, early, late;

unitSpeeds = {"spear":18, "sword":22, "axe":18, "archer":18, "scout":9, "lc":10, "marcher":10, "hc":11, "ram":30, "cat":30, "pally":10, "noble":35};

function Coordinate(name) {

    var candidateIndex = 0;

    this.name = name;
    this.fiance = null;
    this.candidates = [];

    this.rank = function(p) {
        for (i = 0; i < this.candidates.length; i++)
            if (this.candidates[i] === p) return i;
        return this.candidates.length + 1;
    }

    this.prefers = function(p) {
        return this.rank(p) < this.rank(this.fiance);
    }

    this.nextCandidate = function() {
        if (candidateIndex >= this.candidates.length) return null;
        return this.candidates[candidateIndex++];
    }

    this.engageTo = function(p) {
        if (p.fiance) p.fiance.fiance = null;
        p.fiance = this;
        if (this.fiance) this.fiance.fiance = null;
        this.fiance = p;
    }
}

function isStable(guys, gals) {
    for (var i = 0; i < guys.length; i++)
        for (var j = 0; j < gals.length; j++)
            if (guys[i].prefers(gals[j]) && gals[j].prefers(guys[i]))
                return false;
    return true;
}

function engageEveryone(vs) {
    var done;
    do {
        done = true;
        for (var i = 0; i < vs.length; i++) {
            var village = vs[i];
            if (!village.fiance) {
                done = false;
                var target = village.nextCandidate();
                if (!target.fiance || target.prefers(village))
                    village.engageTo(target);
            }
        }
    } while (!done);
}

function makeRankings() {
	for (var i = 0; i < villges.length; i++) {
		var a = villages[i].split("|");

        for (var j = 0; j < targets.length; j++) {
              var b = targets[j].split("|");
			  var distance = (Math.sqrt(Math.pow(a[0]-b[0],2)+Math.pow(a[1]-b[1],2))*unitSpeeds[speeds[i]]+0.5>>0)*60000; // to ms
         	  var diff = (new Date(time-distance)).getHours();
       
	          villages[i].candidates.push(targets[j]);
			  villages[i].diff.push(diff);

			  targets[j].candidates.push(villages[i]);
			  targets[j].diff.push(diff);    
      	}
	}
}

function doMarriage(v, t, s) {
	speeds = s;
	time = new Date($('#landingdate').val() + " " + $('#landingtime').val()).getTime(); // in ms
	early = ($('#earlybound').val()).substring(0,1);
	late = ($('#latebound').val()).substring(0,2);

	for (var i = 0; i < v.length; i++)
		villages.push(new Coordinate(v[i]));
	for (var j = 0; j < t.length; j++)
		targets.push(new Coordinate(t[i]));

	makeRankings();

	function sortByDiff(a, b) { // the coordinates with the least good matches should be first
		return b.goodMatches - a.goodMatches;
	}

	villages.sort(sortByGoodMatches);
	targets.sort(sortByGoodMatches);

    engageEveryone(villages);

    for (var i = 0; i < villages.length; i++)
        console.log("%s is engaged to %s", villages[i].name, villages[i].fiance.name);

    console.log("Stable = %s", isStable(villages, targets) ? "Yes" : "No");
}

doMarriage();// JavaScript Document