<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="js/slider.js"></script>
	<script src="js/onload.js"></script>
	<script src="js/script.js"></script>
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
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.6/angular.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>
		<script src="js/controllers/plan.js"></script>
		<script src="js/services/plan_objects.js"></script>
		<script src="js/marriage3.js"></script>
	<?php endif ?>

	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<meta name="description" content="TWplan is a dynamic and intelligent mass attack planner for the popular online game Tribalwars." />
</head>
<body>
	<?php echo $this->element('header'); ?>

	<noscript>It looks like you have Javascript turned off! TWplan requires Javascript functionality to work. Please turn it on :)</noscript>

	<div id="container">
		<?php echo $this->fetch('content'); ?>
	</div>

	<?php
		if ($this->Session->read('Auth.User.username') == 'syntexgrid') {
			echo $this->element('admin');
		}
	?>

	<?php echo $this->element('footer'); ?>
</body>
</html>