<?php

/**
 * Provides an interface to retrieve data from the players database
 */
class PlayersComponent extends Component {

	public $components = array(
	    'Session',
	    'Auth'
	);

	private $Player;

	/**
	 * Registers a Player model for the component, and dynamically assigns the appropriate table based on the current world
	 * @return boolean
	 */
	public function startup (Controller $controller) {
	    $this->Player = ClassRegistry::init('Player');
	    $this->Player->use_table($this->Session->read('current_world'));
	}

	/**
	 * Checks if the current user is active on the current world
	 */
	public function is_active_world () {
		return ($this->Player->findByUsername($this->Auth->user('username')));
	}

	/**
	 * Looks up the player_id for a given username
	 * @return integer
	 */
	public function player_id_for_username () {
		$player = $this->Player->findByUsername($this->Auth->user('username'));
		return $player->player_id;
	}

}

?>