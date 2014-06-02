<?php

/**
* A controller for the plans
*/
class PlansController extends AppController {

	public $uses = array('Plan', 'User');

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('public_display');
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

		$plans = $this->Plan->findAllByUserIdAndWorld($this->Auth->user('id'), $this->Session->read('current_world'));

		if ($plans === true) { // Returns true if nothing is found
			return json_encode([]);
		}
		else {
			// Now find each plans's commands
			foreach ($plans as &$p) { // '&' passes the element by reference
				$plan_id = $p->id;
				$commands = $this->Plan->Command->findAllByPlanId($plan_id); // This returns true even if nothing is found... Not a breaking change, but weird
				$p->commands = $commands;
			}

			return json_encode($plans);
		}
	}

	public function update ($plan_id) {
		$this->autoRender = false;

		$data = $this->request->input('json_decode', 'true');

		$this->Plan->id = $plan_id;

		$was_published = $this->Plan->findById($plan_id)->is_published;

		if ($data['is_published'] == 'Yes' && $was_published == 'No') { // Setup the published_hash
			$this->Plan->saveField('is_published', 'Yes');

			$published_hash = md5(time() . $this->Auth->user('id'));

			$this->Plan->saveField('published_hash', $published_hash);
		}
		else if ($data['is_published'] == 'No' && $was_published == 'Yes') {
			$this->Plan->saveField('is_published', 'No');
			$this->Plan->saveField('published_hash', NULL);
		}

		// Refresh the plan's commands
		$this->Plan->Command->deleteAll(array('Command.plan_id' => $plan_id), false);

		$updated_plan = array(
			'Plan' => array(
				'id' => $plan_id,
				'user_id' => $this->Auth->user('id'),
			    'name' => $data['name'],
			    'landing_datetime' => $data['landing_datetime'],
			    'world' => $data['world']
		    ),
		    'Command' => $data['commands']
		);

		$this->Plan->saveAssociated($updated_plan, array('deep' => true));

		$updated_plan = $this->Plan->findById($plan_id);
		$updated_plan->commands = $this->Plan->Command->findAllByPlanId($plan_id);
		return json_encode($updated_plan);
	}

	public function delete ($plan_id) {
		$this->autoRender = false;

		$this->Plan->delete($plan_id, true); // Deletes all associated commands also
	}

	public function public_display ($published_hash) {
		// Find the appropriate plan
		$plan = $this->Plan->findByPublishedHash($published_hash);

		if (!count($plan) || $plan->is_published != 'Yes') {
			$this->Session->setFlash('<h1>Public Plan</h1> There is no published plan for this url indentifier.', 'plain_flash_message');
			$this->set(compact('page', 'title_for_layout'));
		}
		else {
			// Find the plans's commands
			$commands = $this->Plan->Command->findAllByPlanId($plan->id);

			$plan->commands = $commands;

			// Find the username of the plan owner
			$user_id = $plan->user_id;
			$user = $this->User->findById($user_id);
			$plan->owner = $user->username;

			$this->set(compact('page', 'title_for_layout', 'plan'));
		}

		$title_for_layout = "Public Plan";
		$page = $path = 'public_plans';

		$this->set(compact('page', 'title_for_layout', 'plan'));

		$this->render('../Pages/' . $path);
	}
}

?>