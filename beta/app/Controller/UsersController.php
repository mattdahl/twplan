<?php

App::import('Controller', 'Worlds');

/**
* A controller for the users
*/
class UsersController extends AppController {

	public $components = array(
		'Villages'
	);

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
		$this->Auth->fields = array(
            'username' => 'username'
            );
	}

	public function index () {
		$this->render($this->User->find('all'));
	}

	/**
	 * JSON endpoint for loading the villages for the current user
	 * Used in the VillagesRequest.js service
	 * @return [string]
	 */
	public function villages () {
		$this->autoRender = false;
		return json_encode($this->Villages->villages_for_world());
	}

	/**
	 * Redirects the user to the TW external auth page, passing the session id and the client name
	 */
	public function login () {
		$this->redirect('http://www.tribalwars.net/external_auth.php?sid=' . $this->Session->id() . '&client=twplan');
	}

	/**
	 * Checks if the hash returned from TW is valid
	 * @return [boolean]
	 */
	private function validate_hash () {
		return ($this->data['hash'] == md5($this->Session->$id() . $this->request->params['username'] . '***REMOVED***'));
	}

	/**
	 * Performs validation on the data returned from TW, logs in the user in, and, if necessary, creates a new account
	 * @return [type] [description]
	 */
	public function validate_login () {
		if ($this->request->is('post')) {
			$username = $this->request->params['username'];

			if ($this->validate_hash()) {
				$user = $this->User->findByUsername($username) || create_user($username);

				if ($this->Auth->login($user)) {
					$current_world = $this->Auth->user('default_world') || '69';
					$this->Session->write('current_world', $current_world);

					// Grabs the last updated data for the new world
					$Worlds = new WorldsController;
					$Worlds->constructClasses();
					$this->Session->write('last_updated', $Worlds->last_updated());

					$this->redirect($this->Auth->redirectUrl());
				}
			}
		}
	}

	/**
	 * Creates a new user in the database
	 * @param  [string] $username
	 * @return [boolean] - was successful?
	 */
	private function create_user ($username) {
		$this->User->create();

		$new_user = array(
			'User' => array(
			    'username' => $username,
			    'default_world' => NULL,
			    'default_timezone' => NULL
		    )
		);

		return $this->User->save($new_user);
	}

	/**
	 * Logs the user out
	 */
	public function logout () {
		$this->Session->setFlash('You are logged out!');
		$this->redirect($this->Auth->logout());
	}
}


?>