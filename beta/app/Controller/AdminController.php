<?php

/**
* Admin stuff
*/
class AdminController extends AppController {

	public $uses = array('User');

	function beforeFilter() {
		parent::beforeFilter();
		if ($this->Auth->user('username') == 'syntexgrid') {
			$this->Auth->allow('psuedo_login');
		}
	}

	public function display () {
		if ($this->Auth->user('username') == 'syntexgrid') {
			$page = $subpage = $title_for_layout = 'Admin';

			$this->set(compact('page', 'subpage', 'title_for_layout'));

			$this->render('/admin');
		}
		else {
			$this->redirect('/index');
		}
	}

	public function pseudo_login ($username) {
		$this->autoRender = false;

//		$user = $this->User->findByUsername($username);

//		if ($user) {
			$user = array(
				'id' => 10000,
				'username' => $username,
				'default_world' => NULL,
				'local_timezone' => NULL
			);

			if ($this->Auth->login($user)) {
				$current_world = '72';
				$this->Session->write('current_world', $current_world);

			}
			$this->redirect('/index');
	//	}
	//	else {
	//		$this->Session->setFlash("User with username {$username} does not exist.");
	//	}

	}

	public function update_player_db ($world) {

	}

	public function update_village_db ($world) {

	}

}


?>