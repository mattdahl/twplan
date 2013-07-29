<?php

class Command extends AppModel {

	public $belongsTo = 'Plan';
	public $hasOne = array(
		'Village' => array(
			'className' => 'Village'
		),
		'Target' => array(
			'className' => 'Target'
		)
	);

	private $slowest_unit;
	private $attack_type;
	private $travel_time;
	private $launch_datetime;

	public function village () {
		return $this->$village;
	}

	public function target () {
		return $this->$target;
	}

	public function slowest_unit () {
		return $this->$slowest_unit;
	}

	public function travel_time () {
		return $this->$travel_time;
	}

	public function launch_datetime () {
		return $this->$launch_time;
	}
}

?>