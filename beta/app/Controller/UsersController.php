<?php

/**
* A controller for the users
*/
class UsersController extends AppController {

	public function index () {
	     $this->set('users', $this->User->find('all'));
	}

	public function create () {
	    if ($this->request->is('post')) {
	        $this->User->create();
	        if ($this->User->save($this->request->data)) {
	            $this->Session->setFlash(__('Your post has been saved.'));
	            $this->redirect(array('action' => 'index'));
	        } else {
	            $this->Session->setFlash(__('Unable to add your post.'));
	        }
	    }
	}

	public function delete ($id = null) {
	    if (!$id) {
	        throw new NotFoundException('Invalid user');
	    }

	    $user = $this->User->findById($id);

	    if (!$user) {
	        throw new NotFoundException('Invalid user');
	    }

	    if ($this->request->is('delete')) {
	        $this->User->delete($id);
	    }
	}

	public function update ($id = null, $params) {
		if (!$id) {
		    throw new NotFoundException('Invalid user');
		}

		$user = $this->User->findById($id);

		if (!$user) {
		    throw new NotFoundException('Invalid user');
		}

	    if ($this->request->is('put')) {
	        $this->User->id = $id;
	        if ($this->Post->save($this->request->data)) {
	            $this->Session->setFlash(__('Your post has been updated.'));
	            $this->redirect(array('action' => 'index'));
	        } else {
	            $this->Session->setFlash(__('Unable to update your post.'));
	        }
	    }

	    if (!$this->request->data) {
	        $this->request->data = $post;
	    }
	}

}


?>