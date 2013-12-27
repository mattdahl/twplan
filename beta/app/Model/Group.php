<?php

class Group extends AppModel {

	public $belongsTo = 'User';

	public $name;
	public $world;
	public $villages;
	public $date_created;
	public $date_last_updated;
	public $user_id;
}

?>