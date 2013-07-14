unitSpeeds = {"spear":18, "sword":22, "axe":18, "archer":18, "scout":9, "lc":10, "marcher":10, "hc":11, "ram":30, "cat":30, "pally":10, "noble":35};

/**
* /**
* Calculates plan pairing using the Hungarian algorithm
* @param  {Village} villages - An array of villages
* @param  {Target} targets - An array of targets
* @param  {Date} landing_datetime - The landing datetime info
* @param  {String} early_bound - The early bound for optimization
* @param  {String} late_bound - The late bound for optimization
* @return {String} An array where index = village location and value = target location in their respective arrays
*/
function hungarian (villages, targets, landing_datetime, early_bound, late_bound) {
	if (!villages || !targets || villages.length > targets.length) {
		return;
	}

	var h = villages.length;
	var w = targets.length;

	var costs = [];
	var rowsCovered = new Array(h);
	var colsCovered = new Array(w);
	var zeros = [];
	var stars = new Array(h);
	var primes = new Array(h);
	var mathMin = Math.min;

var time = landing_datetime.getTime(); // in ms

if (early_bound && late_bound) { // optimizes check so it's only done once
	var early = early_bound.substring(0, 2);
	var late = late_bound.substring(0, 2);

	for (var i = h; i--;) {
		for (var j = w; j;) {
			var a = [villages[i].x_coord, villages[i].y_coord];
			var b = [targets[--j].y_coord, targets[j].y_coord];
var distance = (Math.sqrt((a[0]-b[0])*(a[0]-b[0])+(a[1]-b[1])*(a[1]-b[1]))*villages[i].slowest_unit.speed+0.5>>0)*60000; // to ms
var diff = (new Date(time-distance)).getHours();

if (a[0] == 0 && a[b] == 0) { // inserts a dummy value for blank coords (highest value, theoretically)
	costs[i*w+j] = Math.pow((24*3), 4);
	continue;
}

if ((late-early) < 0) { // allows the restriction to "wrap around" the night
	if (diff >= early || diff < late)
		costs[i*w+j] = 0;
	else
		costs[i*w+j] = Math.pow(Math.abs(diff-((early+late)/2))*3, 4);
}
else {
	if (diff >= early && diff < late)
		costs[i*w+j] = 0;
	else
		costs[i*w+j] = Math.pow(Math.abs(diff-((early+late)/2))*3, 4);
}
}
}
}
else {
	debugger;
	for (var i = h; i--;) {
		for (var j = w; j;) {
			var a = [villages[i].x_coord, villages[i].y_coord];
			var b = [targets[--j].y_coord, targets[j].y_coord];
var distance = (Math.sqrt((a[0]-b[0])*(a[0]-b[0])+(a[1]-b[1])*(a[1]-b[1]))*villages[i].slowest_unit.speed+0.5>>0)*60000; // to ms
var diff = (new Date(time-distance)).getHours();

if (a[0] == 0 && a[b] == 0) { // inserts a dummy value for blank coords (highest value, theoretically)
	costs[i*w+j] = Math.pow((24*3), 4);
	continue;
}

costs[i*w+j] = diff;
}
}
}

for (var i = h; i--;)
{
	var min = Number.MAX_VALUE;
	for (var j = w; j;)
		min = mathMin(min,costs[i*w+(--j)]);
	for (var j = w; j;)
	{
		if((costs[i*w+(--j)] -= min) == 0)
			zeros.push(i*w+j);
	}
}

var done = 0;
for (var i = zeros.length; i;)
{
	var holdC = zeros[--i]%w;
	var holdR = (zeros[i]-holdC)/w;
	if (!rowsCovered[holdR]&&!colsCovered[holdC])
	{
		done++;
		stars[holdR] = holdC;
		rowsCovered[holdR] = true;
		colsCovered[holdC] = true;

	}
}
rowsCovered = new Array(h);
if (done == w)
	return stars;
fullLoop:
while(true)
{
	var lenz = zeros.length;
	var r  = lenz-1;
	var j = r;
	do{
		var holdC = zeros[r]%w;
		var holdR = (zeros[r]-holdC)/w;
		if (!rowsCovered[holdR]&&!colsCovered[holdC])
		{
			primes[holdR] = holdC;
			if (stars[holdR] !== undefined)
			{
				rowsCovered[holdR] = true;
				colsCovered[stars[holdR]] = false;
				j = r;
			}
			else
			{
				while (true)
				{
					var index = stars.indexOf(primes[holdR]);
					stars[holdR] = primes[holdR];
					if (index == -1)
						break;
					var holdR = index;
				}
				rowsCovered = new Array(h);
				colsCovered = new Array(w);
				primes = new Array(h);
				var done = 0;
				for (var i = h; i;)
				{
					if(stars[--i] !== undefined)
					{
						colsCovered[stars[i]] = true;
						done++;
					}
				}
				if (done == w)
					return stars;
				continue fullLoop;
			}
		}
		if(!r--)r=lenz-1;
	}while(r != j);
	var minValue = Number.MAX_VALUE;
	for (var j = w; j;)
	{
		if (!colsCovered[--j])
		{
			for (var i = h; i;)
			{
				if (!rowsCovered[--i])
					minValue = mathMin(minValue, costs[i*w+j]);
			}
		}
	}

	for (var i = h; i;)
	{
		if (rowsCovered[--i])
		{
			for (var j = w; j;)
			{
				if (colsCovered[--j])
				{
					if ((costs[i*w+j] += minValue) == minValue)
					{
						zeros.splice(zeros.indexOf(i*w+j),1);
					}
				}
			}
		}
		else
		{
			for (var j = w; j;)
			{
				if (!colsCovered[--j])
				{
					if ((costs[i*w+j] -= minValue) == 0)
					{
						zeros.push(i*w+j);
					}
				}
			}
		}
	}
}
}