<?php

/**
 * A village in a given world
 * This is an unorthodox model since it tacitly violates the ActiveRecord paradigm:
 * the ORM table is dyanmically linked based on the current world.
 */
class Village extends AppModel {

	public $useDbConfig = 'villages';
	//public $tablePrefix = 'en'; #CASUALWORLDHACK removed

	public $village_id;
	public $village_name;
	public $x_coord;
	public $y_coord;
	public $player_id;

	/**
	 * Switches table given a world; i.e. use table en69, or en70
	 * @param int $world
	 */
	public function use_table ($world) {
		if ($world == '1' || $world == '2') { #CASUALWORLDHACK
			$this->tablePrefix = 'enp';
		}
		else {
			$this->tablePrefix = 'en';
		}

		$this->useTable = $world;
	}
}

?>