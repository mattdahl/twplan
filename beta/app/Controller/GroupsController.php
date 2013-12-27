<?php

/**
* A controller for the groups
*/
class GroupsController extends AppController {

	function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
		$this->Auth->fields = array(
            'username' => 'username'
		);
	}

	/**
	 * Endpoint for saving a new group
	 * Used in the GroupRequest.js service
	 * @return [string] The saved group's name
	 */
	public function add () {
		$this->autoRender = false;

		$data = $this->request->input('json_decode', 'true');

		$new_group = array(
			'Group' => array(
				'user_id' => $this->Auth->user('id'),
			    'name' => $data['name'],
			    'world' => $this->Session->read('current_world'),
			    'villages' => json_encode($data['villages']),
			    'date_created' => date("Y-m-d H:i:s", time()),
			    'date_last_updated' => date("Y-m-d H:i:s", time())
		    )
		);

		$this->Group->save($new_group);

		return json_encode($new_group['Group']['name']);
	}
}

?>