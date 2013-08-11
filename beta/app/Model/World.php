<?php

/**
 * A model of a world object in the analytics database
 */
class World extends AppModel {

	public $useDbConfig = 'analytics';
	public $useTable = 'worlds';

	private $world;
	private $last_updated;
	private $plans;

	public function world () {
		return $this->world;
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