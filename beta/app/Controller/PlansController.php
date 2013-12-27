<?php

/**
* A controller for the plans
*/
class PlansController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
		$this->Auth->fields = array(
            'username' => 'username'
		);
	}

	/**
	 * Endpoint for saving a new plan
	 * Used in the PlanRequest.js service
	 * @return [string] The saved plan's name
	 */
	public function add () {
		$this->autoRender = false;

		$data = $this->request->input('json_decode', 'true');

		// Reformat the date strings in the commands array
		foreach ($data['commands'] as &$command) { // '&' passes the element by reference
			$command['launch_datetime'] = date("Y-m-d H:i:s", $command['launch_datetime']);
			$command['travel_time'] = date("d H:i:s", $command['travel_time']);
		}

		$new_plan = array(
			'Plan' => array(
				'user_id' => $this->Auth->user('id'),
			    'name' => $data['name'],
			    'landing_datetime' => date("Y-m-d H:i:s", $data['landing_datetime']), // Reformats the date string so mySQL will accept it
			    'world' => $data['world']
		    ),
		    'Command' => $data['commands']
		);

		$this->Plan->saveAssociated($new_plan, array('deep' => true));

		return json_encode($new_plan['Plan']['name']);
	}

	public function get () {
		$this->autoRender = false;

		$user_id = $this->Auth->user('id');

		$plans = $this->Plan->findAllByUserId($user_id);

		// Now find each plans's commands
		foreach ($plans as &$p) { // '&' passes the element by reference
			$plan_id = $p->id;
			$commands = $this->Plan->Command->findAllByPlanId($plan_id);
			$p->commands = $commands;
		}

		return json_encode($plans);
	}

	public function update ($plan_id) {
		$this->autoRender = false;

		$data = $this->request->input('json_decode', 'true');

		$this->Plan->id = $plan_id;

		$was_published = $this->Plan->findById($plan_id)->is_published;

		if ($data['is_published'] == 'true' && !$was_published) { // Setup the published_hash
			$this->Plan->saveField('is_published', true);

			$published_hash = md5(time() . $this->Auth->user('id'));

			$this->Plan->saveField('published_hash', $published_hash);
		}
		else if ($data['is_published'] == 'false' && $was_published) {
			$this->Plan->saveField('is_published', false);
			$this->Plan->saveField('published_hash', NULL);
		}

		return json_encode($this->Plan->findById($plan_id));
	}

	public function delete ($plan_id) {
		$this->autoRender = false;

		$this->Plan->delete($plan_id, true); // Deletes all associated commands also
	}

	public function public_display ($published_hash) {
		// Find the appropriate plan
		$plan = $this->Plan->findByPublishedHash($published_hash);

		if (!count($plan) || !$plan->is_published) {
			$this->Session->setFlash('<h1>Public Plan</h1> There is no published plan for this url indentifier.', 'plain_flash_message');
			$this->set(compact('page', 'title_for_layout'));
		}
		else {
			// Find the plans's commands
			$commands = $this->Plan->Command->findAllByPlanId($plan->id);

			$plan->commands = $commands;

			// Find the username of the plan owner
			$user_id = $plan->user_id;
			$user = $this->Plan->query("SELECT * FROM `twp_users`.`users` WHERE `id` = $user_id");
			$plan->owner = $user[0]['users']['username'];

			$this->set(compact('page', 'title_for_layout', 'plan'));
		}

		$title_for_layout = "Public Plan";
		$page = $path = 'public_plans';

		$this->set(compact('page', 'title_for_layout', 'plan'));

		$this->render('../Pages/' . $path);
	}
}

?>