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

	public function last_updated () {
		$world = $this->World->findByWorld($this->Session->read('current_world'));
		$world->last_updated();
	}

	public function set_last_updated () {
		$world = $this->World->findByWorld($this->Session->read('current_world'));
		$world->set_last_updated();
	}

	public function set_default_world () {
		if ($this->request->is('post')) {
			$this->Auth->user()->set_default_world($this->request->params['default_world']);
		}
	}

	public function set_default_timezone () {
		if ($this->request->is('post')) {
			$this->Auth->user()->set_default_timezone($this->request->params['default_timezone']);
		}
	}

	public function set_current_world () {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$world = $this->request->data['world'];
			$this->Session->write('current_world', $world);
			$this->response->statusCode(200);
		}
		else {
			$this->response->statusCode(405);
		}
	}
}


?>