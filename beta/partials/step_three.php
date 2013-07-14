<h1>Planning - Step {{current_step}}</h1>
<p id="instructions">{{instructions}}</p>
<br />

<h2>Arrival Information</h2>
Landing Date (mm/dd/yyyy): <input type="date" id="landingdate" ng-model='landing_date' />
Landing Time (hh:mm:ss): <input type="text" id="landingtime" ng-model='landing_time' /> <br /> <br />
<h2>Launch Time Optimization <input id="timingrestriction" type="checkbox" ng-checked='optimization_checked' /></h2>
<p>TWplan's algorithm can intelligently plan your commands such that the launch times are at times during the day that are convenient to you.
	For instance, maybe you would prefer not to have any launch times when you would normally be asleep.
	If you check the Send Time Optimization checkbox, TWplan will try to plan commands to have launch times <i>between</i> the "early bound" and the "late bound"</p>
<p>Enter between what two times is the ideal time to launch attacks?</p>
Early Bound:
<select id="earlybound" ng-model='early_bound'>
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
Late Bound:
<select id="latebound" ng-model='late_bound'>
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
</select> <br /> <br /> <br />

<input type='button' value='Calculate Plan' ng-click='submitStepThree()' />