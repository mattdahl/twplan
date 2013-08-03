<?php

App::uses('AppController', 'Controller');

class PlanPagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'PlanPages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display () {
		$page = $path = implode('/', func_get_args());
		$title_for_layout = Inflector::humanize($path);
		$this->set(compact('page', 'title_for_layout'));

		if (!$this->Auth->user()) {
			$this->Session->setFlash('You must <a href="login">login</a> to use TWplan\'s planning feature. No registration is required - log in directly with your Tribalwars account!', 'plain_flash_message');
		}
		else if (!$this->Players->is_active_world()) {
			$this->Session->setFlash('Are you sure you have an account on W' . $this->Session->read('current_world') . '? The database cannot find your username.', 'plain_flash_message');
		}

		if ($path != 'plan') {
			// Only render partials for the individual steps (routing is handled client-side by Angular for the plan page)
			$this->autoLayout = false;
		}

		$this->render($path);
	}
}
