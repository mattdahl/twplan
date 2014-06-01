<?php

class Plan extends AppModel {

	// Having trouble setting up association
	public $belongsTo = 'User';
	public $hasMany = array(
	    'Command' => array(
	        'className' => 'Command',
	        'foreignKey' => 'plan_id',
	        'dependent' => true
	    )
	);

	public $plan_id;
	public $name;
	public $landing_datetime;
	public $world;
	public $is_published;
	public $published_hash;

}

?>