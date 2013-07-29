<?php
	$this->Html->script(array(
			'//ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js',
			'//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js',
			'controllers/plan',
			'services/plan_objects',
			'marriage3'
		), array(
			'block' => 'plan_scripts'
		)
	);
?>

<div ng-app='PlanModule'>

	<!-- Dynamic content loaded by $routeProvider using the appropriate partials for each step -->
	<div ng-view></div>

</div>


<?php
/*
if (!isset($_SESSION["username"])) {
	echo "You must <a href=\"login.php\">login</a> to use TWplan's planning feature!<span id=\"dontload\" style=\"display:none\"></span>";
	return false;
}

$username = urlencode(rawurldecode($_SESSION["username"]));
$world = $_SESSION["world"];

$con = mysql_connect("db2.modwest.com", "syntexgrid", "goldispow3r/mysql") or die('Error: ' . mysql_error());

mysql_select_db("players", $con);
$query = "SELECT `playerid` FROM `players`.`en" . $world . "` WHERE `username` = '$username'";
$result = mysql_query($query, $con);

if (!$result || !mysql_fetch_array($result)) {
	echo "Are you sure you have an account on W" . $world . "? The database cannot find your username.<span id=\"dontload\" style=\"display:none\"></span>";
	return false;
} */
?>