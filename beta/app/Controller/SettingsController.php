<?php

App::import('Controller', 'Worlds');

/**
* A controller for the settings
* Some data is backend by ActiveRecord and persisted, other data is merely stored in the Session
*/
class SettingsController extends AppController {

	public $components = array('RequestHandler');

	public $uses = array();

	function beforeFilter() {
		parent::beforeFilter();
		$this->RequestHandler->setContent('json', 'application/json');
	}

	public function index () {
		$page = $subpage = $title_for_layout = 'Settings';
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		$this->render('/settings');
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

			// Grabs the last updated data for the new world
			$Worlds = new WorldsController;
			$Worlds->constructClasses();
			$this->Session->write('last_updated', $Worlds->last_updated());

			// Sets the status code to OK
			$this->response->statusCode(200);
		}
		else {
			// Sets the status code to Method Not Allowed
			$this->response->statusCode(405);
		}
	}
}


?>