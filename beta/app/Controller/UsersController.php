<?php

App::import('Controller', 'Worlds');

/**
* A controller for the users
*/
class UsersController extends AppController {

    public $components = array(
        'Villages'
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login');
        $this->Auth->allow('validate_login');
    }

    /**
     * JSON endpoint for loading the villages for the current user
     * Used in the VillagesRequest.js service
     * @return [string]
     */
    public function villages () {
        $this->autoRender = false;
        return json_encode($this->Villages->villages_for_world());
    }

    /**
     * Redirects the user to the TW external auth page, passing the session id and the client name
     */
    public function login () {
        $this->redirect('http://www.tribalwars.net/external_auth.php?sid=' . $this->Session->id() . '&client=twplan');
    }

    /**
     * Checks if the hash returned from TW is valid
     * @return [boolean]
     */
    private function validate_hash () {
        return ($this->request->query['hash'] == md5($this->request->query['sid'] . $this->request->query['username'] . 'APP_SECRET'));
    }

    /**
     * Performs validation on the data returned from TW, logs in the user in, and, if necessary, creates a new account
     * @return [type] [description]
     */
    public function validate_login () {
        session_id($this->request->query['sid']);
        $this->autoRender = false;

        $username = $this->request->query['username'];

        if ($this->validate_hash()) {
            $user = $this->User->findByUsername($username);

            if (!$user || !count($user)) {
                $user = $this->create_user($username);
            }

            $user = array(
                'id' => $user->id,
                'username' => $user->username,
                'default_world' => $user->default_world,
                'local_timezone' => $user->local_timezone
            );

            if ($this->Auth->login($user)) {
                $current_world = $this->Auth->user('default_world');
                $this->Session->write('current_world', $current_world);

                // Grabs the last updated data for the new world
                $Worlds = new WorldsController;
                $Worlds->constructClasses();
                $this->Session->write('last_updated', $Worlds->last_updated());

                return 'http://twplan.com/?sid=' . $this->Session->id();
            }
        }
    }

    /**
     * Creates a new user in the database
     * @param  [string] $username
     * @return [boolean] - was successful?
     */
    private function create_user ($username) {
        $this->User->create();

        $new_user = array(
            'User' => array(
                'username' => $username,
                'default_world' => 72,
                'local_timezone' => 0
            )
        );

        $this->User->save($new_user);

        return $this->User->findByUsername($username);
    }

    /**
     * Logs the user out
     */
    public function logout () {
        $this->Session->setFlash('You are logged out!');
        $this->redirect($this->Auth->logout());
    }
}


?>