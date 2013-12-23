<?php

class Plan extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = 'Command';

<<<<<<< HEAD
	public $plan_id;
=======
>>>>>>> e3bdbd9c75b4cc2ac4d26cbb9c021862441d86f4
	public $name;
	public $landing_datetime;
	public $world;

}

?>