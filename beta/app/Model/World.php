<?php

/**
 * A model of a world object
 */
class World extends AppModel {

	public $useDbConfig = 'analytics';

	public $world_number;
	public $villages_last_updated;
	public $players_last_updated;
	public $plans;

}

?>