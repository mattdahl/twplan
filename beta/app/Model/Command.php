<?php

class Command extends AppModel {

	public $belongsTo = 'Plan';

	private $village;
	private $target;
	private $slowest_unit;
	private $attack_type;
	private $travel_time;
	private $launch_datetime;
	private $launch_url;

	public function village () {
		return $this->village;
	}

	public function target () {
		return $this->target;
	}

	public function slowest_unit () {
		return $this->slowest_unit;
	}

	public function attack_type () {
		return $this->attack_type;
	}

	public function travel_time () {
		return $this->travel_time;
	}

	public function launch_datetime () {
		return $this->launch_time;
	}

	public function launch_url () {
		return $this->launch_url;
	}
}

?>