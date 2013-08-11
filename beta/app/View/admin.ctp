<h2>Admin Tools</h2>

<b>Psuedo Login</b>
<form action="admin/psuedo_login" method="GET">
	<input type="text" name="username" />
	<input type="submit" value="Login!" />
</form>
<br />

<b>Update Player Database</b>
<form action="admin/update_player_db" method="GET">
	<label for="world">World</label>
	<input type="text" name="world" />
	<input type="submit" value="Update players!" />
</form>
<br />

<b>Update Village Database</b>
<form action="admin/update_village_db" method="GET">
	<label for="world">World</label>
	<input type="text" name="world" />
	<input type="submit" value="Update villages!" />
</form>