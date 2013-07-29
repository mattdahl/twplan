<div id="admin_tools">
	Admin Tools:
	<input type="text" id="alias" />
	<br />
	<input type="submit" value="Pseudo Login" onClick="window.location = 'protected/override.php?fake=' + $('#alias').val() + '&world=62'" />
	<form action="protected/loadvillages.php" method="get">
	<input name="world" type="text" />
	<input value="Load Villages" type="submit" />
	</form>

	<form action="protected/loadplayers.php" method="get">
	<input name="world" type="text" />
	<input value="Load Players" type="submit" />
	</form>
</div>