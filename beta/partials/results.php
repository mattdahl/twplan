<div id="results">
	<a href="#" onClick="backToStep2a();return true;"><img src="images/backarrow.png" class="backarrow" /></a>
	<h2 id="attackplantitle">Attack Plan</h2>
	<table id="resulttable" class="tablesorter">
		<tr><th>Village</th><th>Target</th><th>Slowest Unit</th><th>Attack Type</th><th>Traveling Time</th><th>ST Launch Time</th><th>Local Launch Time</th><th>Time Remaining</th><th>Launch Link</th></tr>
	</table>

	<!--<div id="collectplan">
	  <b>Help Debug TWplan!</b> <br />
	  <p>You can send your plan results to Syntex (Matt) to help with the identification of bugs. This is optional, but I have no interest in using your plan maliciously! Thanks for your help :)</p>
		<button onClick="collectPlan();">Send Plan Data</button>
	</div>-->

	<div style="height: 200px; margin-right: 2%; position: relative; float: left">
		<p class="resultsubtitle">Export as Table</p>
		<textarea id="export1"></textarea>
	</div>
	<div style="height: 200px; margin-right: 2%; position: relative; float: left;">
		<p class="resultsubtitle">Export as Text</p>
		<textarea id="export2"></textarea>
	</div>
	<div style="height: 200px; width: 350px; margin-right: 2%; position: relative; float: left;">
		<p class="resultsubtitle">Save Plan</p>
		<label id="plannamelabel" for="planname">Plan Name:</label> <input type="text" id="planname" /><button id="save" onClick="doesPlanExist()">Save</button>
		<img id="loadingcircle" src="http://static-twplan.appspot.com/images/loadingcircle.gif" />
		<div id="saveresults"></div>
	</div>

	<div id="redoplan">
		<b>Recalculate Plan With Different Landing Information</b> <br /> <br />
		<form>
			Landing Date (mm/dd/yyyy): <input type="date" id="newlandingdate" />
			Landing Time (hh:mm:ss): <input type="text" id="newlandingtime" /> <br /> <br />
			<input type="submit" value="Recalculate Plan" onClick="reSubmitHungarian(); return false;" />
		</form>
	</div>
</div>