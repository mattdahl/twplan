<?php

/**
* A controller for the worlds data
*/
class WorldsController extends AppController {

	public $components = array(
		'Session',
		'RequestHandler'
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->RequestHandler->setContent('json', 'application/json');
	}

	/**
	 * Gets the last updated time in hours from the current timestamp for the current world
	 * @return [int]
	 */
	public function last_updated () {
		$world = $this->World->findByWorldNumber($this->Session->read('current_world'));
		$last_updated = $world->last_updated ? $world->last_updated : 0;

		date_default_timezone_set("Europe/London");
		$now = date('Y-m-d H:i:s', time());
		$diff = strtotime($now) - strtotime($last_updated);
		return round(($diff/60)/60); // Returns the difference in hours
	}
}


?>