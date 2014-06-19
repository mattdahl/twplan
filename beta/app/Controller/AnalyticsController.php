<?php

/**
* A controller for the analytics data
*/
class AnalyticsController extends AppController {

	public $components = array(
		'Session',
		'RequestHandler'
	);

	public $uses = array('World', 'BugReport');

	function beforeFilter() {
		parent::beforeFilter();
		$this->RequestHandler->setContent('json', 'application/json');
		$this->Auth->allowedActions = array('add_bug_report');
	}

	public function set_last_updated () {
		$world = $this->World->findByWorld($this->Session->read('current_world'));
		$world->set_last_updated();
	}

	public function set_number_plans () {

	}

	public function add_bug_report () {
		if ($this->request->is('post')) {
			$this->autoRender = false;

			$data = $this->request->input('json_decode', 'true');
			$this->request->header('User-Agent');

			$new_bug_report = array(
				'BugReport' => array(
				    'description' => $data['description'],
				    'page' => $data['page'],
				    'error_message' => $data['error_message'],
				    'browser' => $this->request->header('User-Agent'),
				    'is_replicable' => $data['is_replicable'],
				    'contact_information' => $data['contact_information'],
				    'user_id' => $this->Auth->user('id'),
				    'date_submitted' => date("Y-m-d H:i:s", time()),
				    'is_js' => $data['is_js'],
				    'is_suppressed' => $data['is_suppressed']
			    )
			);

			$this->BugReport->save($new_bug_report);

			$bug_report_message = "Bug Report ID #" . $this->BugReport->getLastInsertID() . "\n";
			$bug_report_message .= "Description: {$new_bug_report['BugReport']['description']} \n";
			$bug_report_message .= "Page: {$new_bug_report['BugReport']['page']} \n";
			$bug_report_message .= "Error Message: {$new_bug_report['BugReport']['error_message']} \n";
			$bug_report_message .= "Browser: {$new_bug_report['BugReport']['browser']} \n";
			$bug_report_message .= "Is Replicable: {$new_bug_report['BugReport']['is_replicable']} \n";
			$bug_report_message .= "Contact Information: {$new_bug_report['BugReport']['contact_information']} \n";
			$bug_report_message .= "User ID: {$new_bug_report['BugReport']['user_id']}";

			if ($new_bug_report['BugReport']['is_suppressed'] === true || $new_bug_report['BugReport']['is_suppressed'] == 'true') {
				return;
			}
			else if ($new_bug_report['BugReport']['is_js'] === true || $new_bug_report['BugReport']['is_js'] == 'true') {
				mail("support@twplan.com", "TWplan JS ERROR", $bug_report_message);
			}
			else {
				mail("support@twplan.com", "TWplan Bug Report", $bug_report_message);
			}

			return json_encode($new_bug_report['BugReport']);
		}
		else {
			// Sets the status code to Method Not Allowed
			$this->response->statusCode(405);
		}
	}
}


?>