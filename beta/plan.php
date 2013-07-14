<?php
session_start();
?>
<!DOCTYPE html>
<html ng-app='PlanModule'>
<head>
	<title>Plan</title>
	<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />

	<link rel="icon" href="http://static-twplan.appspot.com/images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="style.css" />

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
	<script src="scripts/javascripts/controllers/plan.js"></script>
	<script src="scripts/javascripts/services/plan_objects.js"></script>
<!--	<script src="scripts/javascripts/services/plan_services.js"></script> -->
	<script src="scripts/onload.js"></script>
	<script type="text/javascript" src="scripts/script.js"></script>
	<script type="text/javascript" src="scripts/javascripts/hungarian6_unmini.js"></script>
	<script type="text/javascript"> /* Google Analytics */

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-34224555-1']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

	</script>
</head>
<body>
	<?php include "header.php" ?>
	<div id="container">
		<noscript>It looks like you have Javascript turned off! TWplan requires Javascript functionality to work. Please turn it on :)</noscript>
		<?php
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
		}
		?>

		<!-- Dynamic content loaded by $routeProvider using the appropriate partials for each step -->
		<div ng-view></div>

	</div>

</body>

<?php include "footer.php" ?>

</html>