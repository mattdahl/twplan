<?php

App::import('Controller', 'Worlds');
App::import('Controller', 'Users');

/**
* A controller for the settings
* Some data is backed by ActiveRecord and persisted, other data is merely stored in the Session
*/
class SettingsController extends AppController {

	public $components = array('RequestHandler');

	public $uses = array();

	function beforeFilter() {
		parent::beforeFilter();
		$this->RequestHandler->setContent('json', 'application/json');
	}

	public function set_default_world () {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$data = $this->request->input('json_decode', 'true');

			$Users = new UsersController;
			$Users->constructClasses();

			$Users->User->id = $this->Auth->user('id');
			$Users->User->saveField('default_world', $data['default_world']);

			// Relogin the user to update the Auth component
			$this->Auth->login(array(
				'id' => $this->Auth->user('id'),
				'username' => $this->Auth->user('username'),
				'default_world' => $data['default_world'],
				'local_timezone' => $this->Auth->user('local_timezone')
			));

			return json_encode($Users->User->findById($this->Auth->user('id'))->local_timezone);
		}
	}

	public function set_local_timezone () {
		$this->autoRender = false;

		if ($this->request->is('post')) {
			$data = $this->request->input('json_decode', 'true');

			$Users = new UsersController;
			$Users->constructClasses();

			$Users->User->id = $this->Auth->user('id');
			$Users->User->saveField('local_timezone', $data['local_timezone']['name']);

			// Relogin the user to update the Auth component
			$this->Auth->login(array(
				'id' => $this->Auth->user('id'),
				'username' => $this->Auth->user('username'),
				'default_world' => $this->Auth->user('default_world'),
				'local_timezone' => $data['local_timezone']['name']
			));

			return json_encode($this->Session->read('Auth.User'));

			return json_encode($Users->User->findById($this->Auth->user('id'))->local_timezone);
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