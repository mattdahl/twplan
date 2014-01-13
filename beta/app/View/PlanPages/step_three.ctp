<h1>Planning - Step 3</h1>
<p id="instructions">Choose the landing date and time for your attack. All times are in <b>TW Server Time</b> (see bottom of page)!</p>

<h2>Arrival Information</h2>
Landing Date: <input type="date" id="landingdate" placeholder="mm/dd/yyyy" ng-model="landing_date" />
Landing Time: <input type="text" id="landingtime" placeholder="hh:mm:ss" ng-model="landing_time" /> <br /> <br />
<h2>Launch Time Optimization <input type="checkbox" ng-model="optimization_checked" /></h2>
<div ng-show="optimization_checked">
	<p>TWplan"s algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you. For instance, maybe you would prefer not to have any launch times when you would normally be asleep. If you enable this feature, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound"</p>
	<p>Enter the range of times when it is best launch attacks.</p>
	Early Bound:
	<select ng-model="early_bound">
		<option>00:00</option>
		<option>01:00</option>
		<option>02:00</option>
		<option>03:00</option>
		<option>04:00</option>
		<option>05:00</option>
		<option>06:00</option>
		<option>07:00</option>
		<option>08:00</option>
		<option>09:00</option>
		<option>10:00</option>
		<option>11:00</option>
		<option>12:00</option>
		<option>13:00</option>
		<option>14:00</option>
		<option>15:00</option>
		<option>16:00</option>
		<option>17:00</option>
		<option>18:00</option>
		<option>19:00</option>
		<option>20:00</option>
		<option>21:00</option>
		<option>22:00</option>
		<option>23:00</option>
	</select>
	<br />
	Late Bound:
	<select ng-model="late_bound">
		<option>00:00</option>
		<option>01:00</option>
		<option>02:00</option>
		<option>03:00</option>
		<option>04:00</option>
		<option>05:00</option>
		<option>06:00</option>
		<option>07:00</option>
		<option>08:00</option>
		<option>09:00</option>
		<option>10:00</option>
		<option>11:00</option>
		<option>12:00</option>
		<option>13:00</option>
		<option>14:00</option>
		<option>15:00</option>
		<option>16:00</option>
		<option>17:00</option>
		<option>18:00</option>
		<option>19:00</option>
		<option>20:00</option>
		<option>21:00</option>
		<option>22:00</option>
		<option>23:00</option>
	</select>
</div>

<br />

<input type="button" value="Calculate Plan" ng-click="submitStepThree()" />