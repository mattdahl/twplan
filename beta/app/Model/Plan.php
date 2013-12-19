<?php

class Plan extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = 'Command';

	public $plan_id;
	public $name;
	public $landing_datetime;
	public $world;

}

?>