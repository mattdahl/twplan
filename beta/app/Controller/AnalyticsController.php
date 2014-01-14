<?php

/**
* A controller for the analytics data
*/
class AnalyticsController extends AppController {

	public $components = array(
		'Session',
		'RequestHandler'
	);

	public $uses = array('World');

	function beforeFilter() {
		parent::beforeFilter();
		$this->RequestHandler->setContent('json', 'application/json');
	}

	public function set_last_updated () {
		$world = $this->World->findByWorld($this->Session->read('current_world'));
		$world->set_last_updated();
	}
}


?>