<?php

/**
* A controller for the users
*/
class UsersController extends AppController {

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

	public function login () {
		$this->redirect('http://www.tribalwars.net/external_auth.php?sid=' . $this->Session->id() . '&client=twplan');
	}

	private function validate_hash () {
		return ($this->data['hash'] == md5($this->Session->$id() . $this->request->params['username'] . '***REMOVED***'));
	}

	public function validate_login () {
		if ($this->request->is('post')) {
			$username = $this->request->params['username'];

			if ($this->validate_hash()) {
				$user = $this->User->findByUsername($username) || create_user($username);

				if ($this->Auth->login($user)) {
					$current_world = $this->Auth->user('default_world') || '69';
					$this->set_current_world($current_world);

					$this->redirect($this->Auth->redirectUrl());
				}
			}
		}
	}

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

	public function logout () {
		$this->Session->setFlash('You are logged out!');
		$this->redirect($this->Auth->logout());
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
		$this->response = new CakeResponse();

		if ($this->request->is('post')) {
			$world = $this->request->params['world'];
			$this->Session->write('current_world', $world);
			$this->response->statusCode(200);
		}
		else {
			$this->response->statusCode(405);
		}

		$this->response->send();
	}
}


?>