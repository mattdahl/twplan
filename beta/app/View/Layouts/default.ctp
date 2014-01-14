<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?php
		echo $this->Html->script('slider');
		echo $this->Html->script('dropdown_navbar');
		echo $this->Html->script('twplan_app_bootstrap');
		echo $this->Html->script('controllers/header');
		echo $this->Html->script('factories/meta_data');
		echo $this->Html->script('factories/attack_types');
		echo $this->Html->script('error_handler');
	?>

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

	<?php
		if ($page == 'plan') {
			echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js');
			echo $this->Html->script('controllers/plan');
			echo $this->Html->script('plan_objects');
			echo $this->Html->script('factories/pair_calculator');
			echo $this->Html->script('factories/plan_calculator');
			echo $this->Html->script('factories/units');
			echo $this->Html->script('factories/villages_request');
			echo $this->Html->script('factories/plan_request');
			echo $this->Html->script('factories/group_request');
			echo $this->Html->script('factories/world_info');
			echo $this->Html->script('factories/autocomplete_builder');
			echo $this->Html->script('directives/manual_noble_target_input');
			echo $this->Html->script('directives/manual_nuke_target_input');
			echo $this->Html->script('directives/manual_support_target_input');
			echo $this->Html->css('jqueryui');
		}
		else if ($page == 'plans') {
			echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js');
			echo $this->Html->script('controllers/plans');
			echo $this->Html->script('factories/plan_request');
			echo $this->Html->script('factories/units');
			echo $this->Html->css('jqueryui');
		}
		else if ($page == 'public_plans') {
			echo $this->Html->script('//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js');
			echo $this->Html->script('controllers/public_plans');
			echo $this->Html->script('plan_objects');
			echo $this->Html->script('factories/units');
			echo $this->Html->css('jqueryui');

			echo "<script>TWP.public_plan = " . json_encode($plan) . ";</script>";
		}
		else if ($page == 'groups') {
			echo $this->Html->script('controllers/groups');
			echo $this->Html->script('factories/group_request');
			echo $this->Html->script('factories/villages_request');
		}
		else if ($page == 'settings') {
			echo $this->Html->script('controllers/settings');
		}
		else if ($page == 'user_scripts') {
			echo $this->Html->script('controllers/user_scripts');
		}
		else if ($page == 'bug_report') {
			echo $this->Html->script('controllers/bug_report');
		}

		echo $this->Html->css('style');

	?>


	<link rel="icon" href="http://static-twplan.appspot.com/images/favicon.ico" type="image/x-icon" />
	<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />
	<?php
		echo $this->Html->meta(array('name' => 'username', 'content' => $this->Session->read('Auth.User.username') ? $this->Session->read('Auth.User.username') : ''));
		echo $this->Html->meta(array('name' => 'user_id', 'content' => $this->Session->read('Auth.User.id') ? $this->Session->read('Auth.User.id') : ''));
		echo $this->Html->meta(array('name' => 'current_world', 'content' => $this->Session->read('current_world') ? $this->Session->read('current_world') : ''));
		echo $this->Html->meta(array('name' => 'last_updated', 'content' => $this->Session->read('last_updated') ? $this->Session->read('last_updated') : 0));
		echo $this->Html->meta(array('name' => 'default_world', 'content' => $this->Session->read('Auth.User.default_world') ? $this->Session->read('Auth.User.default_world') : ''));
		echo $this->Html->meta(array('name' => 'local_timezone', 'content' => $this->Session->read('Auth.User.local_timezone') ? $this->Session->read('Auth.User.local_timezone') : 0));
	?>

</head>
<body ng-app="twplan_app">
	<?php echo $this->element('header'); ?>

	<noscript>It looks like you have Javascript turned off! TWplan requires Javascript functionality to work. Please turn it on :)</noscript>

	<div id="container">
		<?php
			if ($this->Session->check('Message.flash')) {
				echo $this->Session->flash();
			}
			else {
				echo $this->fetch('content');
			}
		?>
	</div>

	<?php echo $this->element('footer'); ?>
</body>
</html>