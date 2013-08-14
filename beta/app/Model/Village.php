<?php

/**
 * A village in a given world
 * This is an unorthodox model since it tacitly violates the ActiveRecord paradigm:
 * the ORM table is dyanmically linked based on the current world.
 */
class Village extends AppModel {

	public $useDbConfig = 'villages';
	public $tablePrefix = 'en';

	private $village_id;
	private $village_name;
	private $x_coord;
	private $y_coord;
	private $player_id;

	/**
	 * Switches table given a world; i.e. use table en69, or en70
	 * @param int $world
	 */
	public function use_table ($world) {
		$this->useTable = $world;
	}

	public function village_id () {
		return $this->village_id;
	}

	public function village_name () {
		return $this->name;
	}

	public function x_coord () {
		return $this->x_coord;
	}

	public function y_coord () {
		return $this->y_coord;
	}

	public function player_id () {
		return $this->player_id;
	}
}

?>