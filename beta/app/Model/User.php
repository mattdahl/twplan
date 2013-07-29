<?php

/**
 * A model of a User
 */
class User extends AppModel {

	public static $id_counter = 0;

	public $hasMany = array(
		'Group' => array(
			'className' => 'Group'
		),
		'Plan' => array(
			'className' => 'Plan'
		)
	);

	private $username;
	private $id;
	private $default_world;
	private $default_timezone;

	public function __construct ($username, $default_world = NULL, $default_timezone = NULL) {
		$this->$username = $username;
		$this->$id = $id_counter;
		$this->$default_world = $default_world;
		$this->$default_timezone = $default_timezone;

		$id_counter++;
	}

	public function username () {
		return $this->$username;
	}

	public function id () {
		return $this->$id;
	}

	public function default_world () {
		return $this->$default_world;
	}

	public function default_timezone () {
		return $this->$default_timezone;
	}

}

?>