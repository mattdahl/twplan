<?php
/**
 * Routes configuration
 */

	Router::connect('/',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'index'
		)
	);

	Router::connect('/index',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'index'
		)
	);

	# REST architecture
	# /plans is the page
	# /plans/plan is the resource (e.g. /plans/plan/123)
	Router::connect('/plans',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'plans'
		)
	);

	Router::connect('/plans/plan',
		array(
			'controller' => 'plans',
			'action' => 'add',
			'[method]' => 'POST'
		)
	);

	Router::connect('/plans/plan',
		array(
			'controller' => 'plans',
			'action' => 'get',
			'[method]' => 'GET'
		)
	);

	Router::connect('/plans/plan/*',
		array(
			'controller' => 'plans',
			'action' => 'delete',
			'[method]' => 'DELETE'
		)
	);

	Router::connect('/plans/plan/*',
		array(
			'controller' => 'plans',
			'action' => 'update',
			'[method]' => 'PUT'
		)
	);

	Router::connect('/public/plans/*',
		array(
			'controller' => 'plans',
			'action' => 'public_display'
		)
	);

	Router::connect('/news',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'news'
		)
	);

	Router::connect('/plan',
		array(
			'controller' => 'planPages',
			'action' => 'display',
			'plan'
		)
	);

	Router::connect('/plan/step_one',
		array(
			'controller' => 'planPages',
			'action' => 'display',
			'step_one'
		)
	);

	Router::connect('/plan/step_two',
		array(
			'controller' => 'planPages',
			'action' => 'display',
			'step_two'
		)
	);

	Router::connect('/plan/step_three',
		array(
			'controller' => 'planPages',
			'action' => 'display',
			'step_three'
		)
	);

	Router::connect('/plan/results',
		array(
			'controller' => 'planPages',
			'action' => 'display',
			'results'
		)
	);

	Router::connect('/bug_report',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'bug_report'
		)
	);

	Router::connect('/settings',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'settings'
		)
	);

	# REST architecture
	# /groups is the page
	# /groups/group is the resource (e.g. /groups/group/123)
	Router::connect('/groups',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'groups'
		)
	);

	Router::connect('/groups/group',
		array(
			'controller' => 'groups',
			'action' => 'add',
			'[method]' => 'POST'
		)
	);

	Router::connect('/groups/group',
		array(
			'controller' => 'groups',
			'action' => 'get',
			'[method]' => 'GET'
		)
	);

	Router::connect('/groups/group/*',
		array(
			'controller' => 'groups',
			'action' => 'delete',
			'[method]' => 'DELETE'
		)
	);

	Router::connect('/groups/group/*',
		array(
			'controller' => 'groups',
			'action' => 'update',
			'[method]' => 'PUT'
		)
	);

	Router::redirect('/groups/group/*',
		'groups',
		array('status' => 302)
	);

	Router::redirect('/groups/new_group',
		'groups',
		array('status' => 302)
	);

	Router::connect('/about',
		array(
			'controller' => 'pages',
			'action' => 'display',
			'about'
		)
	);

	Router::connect('/login',
		array(
			'controller' => 'users',
			'action' => 'login'
		)
	);

	Router::connect('/logout',
		array(
			'controller' => 'users',
			'action' => 'logout'
		)
	);

	Router::redirect('/help',
		'http://forum.tribalwars.net/showthread.php?260468-TWplan-The-mass-attack-planner-you-ve-been-waiting-for',
		array('status' => 302)
	);

	Router::connect('/validation.php',
		array(
			'controller' => 'users',
			'action' => 'validate_login'
		)
	);

	Router::connect('/admin',
		array(
			'controller' => 'admin',
			'action' => 'display'
		)
	);

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
