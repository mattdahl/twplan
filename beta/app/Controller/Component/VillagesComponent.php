<?php

/**
 * Provides an interface to retrieve data from the villages database
 */
class VillagesComponent extends Component {

	public $components = array(
		'Session',
		'Players'
	);

	private $Village;

	/**
	 * Registers a Village model for the component, and dynamically assigns the appropriate table based on the current world
	 * @return boolean
	 */
	public function startup (Controller $controller) {
	    $this->Village = ClassRegistry::init('Village');
	    $this->Village->use_table($this->Session->read('current_world'));
	}

	/**
	 * Returns an array of villages for the current world for the current user
	 * @return An array of objects of type Village
	 */
	public function villages_for_world () {
		$player_id = $this->Players->player_id_for_username();
		return $this->Village->findByPlayerId($player_id);
	}
}

?>