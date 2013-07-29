<?php

class Plan extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = 'Command';

	private $name;
	private $landing_datetime;
	private $world;

	public function name () {
		return $this->$name;
	}

	public function landing_datetime () {
		return $this->$landing_datetime;
	}

	public function world () {
		return $this->$world;
	}
}

?>