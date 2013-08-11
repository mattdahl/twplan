<?php

/**
* Admin stuff
*/
class AdminController extends AppController {

	public $uses = array();

	function beforeFilter() {
		parent::beforeFilter();
		if ($this->Auth->user('username') == 'syntexgrid') {
			$this->Auth->allow('psuedo_login');
		}
		$this->Auth->fields = array(
            'username' => 'username'
            );
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

	public function puesdo_login ($username) {
		$user = $this->User->findByUsername($username);

		if ($user) {
			if ($this->Auth->login($user)) {
				$current_world = '69';
				$this->Session->write('current_world', $current_world);

				$this->redirect($this->Auth->redirectUrl());
			}
		}
		else {
			$this->Session->setFlash("User with username {$username} does not exist.");
		}

	}

	public function update_player_db ($world) {

	}

	public function update_village_db ($world) {

	}

}


?>