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
	 * Used in the SaveRequest.js service
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

		return(json_encode($new_plan['Plan']['name']));
	}

	public function get () {
		$this->autoRender = false;

		$user_id = $this->Auth->user('id');

		// This should work, can't figure out why it returns true instead of an array of the result...
		//$plans = $this->Plan->findByUserId($this->Auth->user('id'));
		// So run the manual query instead
		$plans = $this->Plan->query("
			SELECT * FROM `twp_users`.`plans` AS `Plan`
				LEFT JOIN `twp_users`.`users` AS `User` ON (`Plan`.`user_id` = `User`.`id`)
			WHERE `user_id` = $user_id
		");

		// Now find each plans's commands
		foreach ($plans as &$p) { // '&' passes the element by reference
			$plan_id = $p['Plan']['id'];
			$commands = $this->Plan->query("SELECT * FROM `twp_users`.`commands` WHERE `plan_id` = $plan_id");
			$commands_array = [];
			foreach ($commands as $c) {
				array_push($commands_array, $c['commands']);
			}
			$p['Plan']['commands'] = $commands_array;
		}

		return(json_encode($plans));
	}

	public function delete ($plan_id) {
		$this->autoRender = false;

		$this->Plan->query("
			DELETE FROM `twp_users`.`plans`
			WHERE `id` = $plan_id
		");

		$this->Plan->query("
			DELETE FROM `twp_users`.`commands`
			WHERE `plan_id` = $plan_id
		");
	}
}

?>