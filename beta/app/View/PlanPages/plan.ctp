<?php
	$flash_message = $this->Session->flash();
?>

<?php if ($flash_message) : ?>

<h1>Plan</h1>

<?php echo $flash_message; ?>

<?php else : ?>

<div ng-app='PlanModule'>

	<!-- Dynamic content loaded by $routeProvider using the appropriate partials for each step -->
	<div ng-view></div>

</div>

<?php endif; ?>