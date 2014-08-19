<?php

/**
 * A model of a bug report object
 */
class BugReport extends AppModel {

	public $useDbConfig = 'default';
	var $useTable = 'bug_reports';

	public $description;
	public $page;
	public $error_message;
	public $browser;
	public $is_replicable;
	public $contact_information;

}

?>