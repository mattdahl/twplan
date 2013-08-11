<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="js/slider.js"></script>
	<script src="js/onload.js"></script>
	<script src="js/script.js"></script>
	<script src="js/header_app_bootstrap.js"></script>
	<script src="js/controllers/header.js"></script>
	<script src="js/factories/meta_data.js"></script>
	<script type="text/javascript"> /* Google Analytics */

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-34224555-1']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	  })();

	</script>

	<?php if ($page == 'plan') : ?>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
		<script src="js/plan_app_bootstrap.js"></script>
		<script src="js/controllers/plan.js"></script>
		<script src="js/plan_objects.js"></script>
		<script src="js/factories/attack_types.js"></script>
		<script src="js/factories/group_names.js"></script>
		<script src="js/factories/pair_calculator.js"></script>
		<script src="js/factories/units.js"></script>
		<script src="js/factories/villages_request.js"></script>
		<script src="js/factories/world_info.js"></script>
	<?php endif ?>

	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />
	<?php
		echo $this->Html->meta(array('name' => 'username', 'content' => $this->Session->read('Auth.User.username') ? $this->Session->read('Auth.User.username') : ''));
		echo $this->Html->meta(array('name' => 'current_world', 'content' => $this->Session->read('current_world') ? $this->Session->read('current_world') : ''));
		echo $this->Html->meta(array('name' => 'last_updated', 'content' => $this->Session->read('last_updated') ? $this->Session->read('last_updated') : ''));
	?>

</head>
<body>
	<?php echo $this->element('header'); ?>

	<noscript>It looks like you have Javascript turned off! TWplan requires Javascript functionality to work. Please turn it on :)</noscript>

	<div id="container">
		<?php echo $this->fetch('content'); ?>
	</div>

	<?php echo $this->element('footer'); ?>
</body>
</html>