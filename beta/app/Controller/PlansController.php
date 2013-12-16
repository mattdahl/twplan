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
}


?>