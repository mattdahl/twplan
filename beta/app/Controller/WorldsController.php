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

	public function last_updated () {
		$world = $this->World->findByWorldNumber($this->Session->read('current_world'))['World'];
		return $world['last_updated'];
	}

	public function set_last_updated () {
		$world = $this->World->findByWorld($this->Session->read('current_world'));
		$world->set_last_updated();
	}
}


?>