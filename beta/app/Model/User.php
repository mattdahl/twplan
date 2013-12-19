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

	public $user_id;
	public $username;
	public $default_world;
	public $default_timezone;

	public function set_default_world ($default_world) {
		$this->default_world = $default_world;
	}

	public function set_default_timezone ($default_timezone) {
		$this->default_timezone = $default_timezone;
	}

	public function groups ($id = NULL) {
		if ($id) {
			return $this->Group->findById($id);
		}
		else {
			return $this->Group->find('all');
		}
	}

	public function plans ($id) {
		return $this->Plan->find('all');
	}

}

?>