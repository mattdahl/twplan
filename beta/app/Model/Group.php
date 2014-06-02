<?php

App::uses('AppModel', 'Model');

class Group extends AppModel {

	// Defining this causes find() calls not to work... something wrong with the User model?
	//public $belongsTo = 'User';

	public $name;
	public $world;
	public $villages;
	public $date_created;
	public $date_last_updated;
	public $user_id;
}

?>