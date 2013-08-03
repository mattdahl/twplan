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

	private $id;
	private $username;
	private $default_world;
	private $default_timezone;

	public function username () {
		return $this->$username;
	}

	public function id () {
		return $this->$id;
	}

	public function default_world () {
		return $this->$default_world;
	}

	public function set_default_world ($default_world) {
		$this->default_world = $default_world;
	}

	public function default_timezone () {
		return $this->$default_timezone;
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

	public function plans ($id = NULL) {
		if ($id) {
			return $this->Plan->findById($id);
		}
		else {
			return $this->Plan->find('all');
		}
	}

}

?>