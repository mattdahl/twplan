<?php

/**
 * A model of a User
 */
class User extends AppModel {

	public $hasMany = array(
		'Group' => array(
			'className' => 'Group'
		),
		'Plan' => array(
			'className' => 'Plan'
		)
	);

	public $username;
	public $default_world;
	public $default_timezone;
}

?>