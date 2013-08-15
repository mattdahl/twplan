<?php

/**
 * A model of a world object
 */
class World extends AppModel {

	private $world_number;
	private $last_updated;
	private $plans;

	public function world_number () {
		return $this->world_number;
	}

	public function last_updated () {
		return $this->last_updated;
	}

	public function set_last_updated () {
		$this->last_updated = date("Y-m-d H:i:s");
	}

	public function plans () {
		return $this->plans;
	}

}

?>