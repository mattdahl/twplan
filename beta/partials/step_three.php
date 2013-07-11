<h1>Planning - Step {{current_step}}</h1>
<p id="instructions">{{instructions}}</p>
<br />


<h2>Arrival Information</h2>
Landing Date (mm/dd/yyyy): <input type="date" id="landingdate" />
Landing Time (hh:mm:ss): <input type="text" id="landingtime" /> <br /> <br />
<h2>Launch Time Optimization <input id="timingrestriction" type="checkbox" /></h2>
<p>Between what two times is the best time to launch attacks?</p>
Early Bound:
<select id="earlybound">
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
<select id="latebound">
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

<input type='button' value='Calculate Plan' ng-click='submutHungarian()' />