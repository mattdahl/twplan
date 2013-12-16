<?php

class Plan extends AppModel {

	public $belongsTo = 'User';
	public $hasMany = 'Command';

	public $name;
	public $landing_datetime;
	public $world;

}

?>