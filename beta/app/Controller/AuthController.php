<?php

class AuthController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();



	public $components = array('Session');

	public $hasOne = 'User';

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	private function session_start ($sid) {
		session_start($sid);
	}

	private function session_destroy () {
		session_destroy();
	}

	public function session_id () {
		return session_id();
	}

	public function current_user () {
		return $this->Session->read('current_user');

	}

	public function set_current_user ($user) {
		$this->Session->write('current_user', $user);
	}

	public function current_world () {
		return $this->Session->read('current_world');
	}

	public function set_current_world ($world) {
		$this->Session->write('current_world', $world);
	}

	public function login () {
		// Redirect to TW external authentication, passing the sid by GET
		header("Location: http://www.tribalwars.net/external_auth.php?sid=" . session_id() . "&client=twplan");
	}

	public function logout () {
		$this->session_destroy();
	}

	public function validate_login () {
		$username = $this->request->query['username'];
		$sid = $this->request->query['sid'];
		$hash = $this->request->query['hash'];

		if ($hash == md5($sid . $username . "***REMOVED***")) {
			if (empty($this->User->findByUsername($username)) {
				$this->User->create();
				$this->User->$save(array(
					'username' => $username
					)
				);

				$this->set_current_user($this->User->findById($id));
				$this->set_current_world($this->User->$default_world);

				// TW requires us to output the URL of the page to redirect to
				echo "http://www.twplan.com/index.php?id=" . $sid . "&world=" . $this->current_user;
			}
		}
	}

?>