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

	public function get () {
		$this->autoRender = false;

		$groups = $this->Group->findAllByUserIdAndWorld($this->Auth->user('id'), $this->Session->read('current_world'));

		if (is_array($groups)) {
			return json_encode($groups);
		}
		else {
			return json_encode([$groups]);
		}
	}

	public function update ($group_id) {
		$this->autoRender = false;

		$data = $this->request->input('json_decode', 'true');

		$existing_group = $this->Group->findById($group_id);

		$updated_group = array(
			'Group' => array(
				'id' => $group_id,
				'user_id' => $existing_group->user_id,
			    'name' => $data['name'],
			    'world' => $existing_group->world,
			    'villages' => json_encode($data['villages']),
			    'date_created' => $existing_group->date_created,
			    'date_last_updated' => date("Y-m-d H:i:s", time())
		    )
		);

		$this->Group->save($updated_group);

		return json_encode($updated_group['Group']['name']);
	}

	// TODO: Add check to make sure the group being deleted is owned by the current user
	public function delete ($group_id) {
		$this->autoRender = false;

		$this->Group->delete($group_id);
	}
}

?>