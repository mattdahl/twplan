<?php

class Command extends AppModel {

	// Having trouble setting up association
	public $belongsTo = 'Plan';

	public $village;
	public $target;
	public $slowest_unit;
	public $attack_type;
	public $travel_time;
	public $launch_datetime;
	public $launch_url;
	public $plan_id;
}

?>