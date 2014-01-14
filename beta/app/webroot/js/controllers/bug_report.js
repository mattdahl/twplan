/**
 * The controller for the /bug_report page
 */
TWP.twplan.Controllers.controller('BugReportController', ['$scope', '$http', function ($scope, $http) {
	$scope.bug_report = {
		description: '',
		page: '',
		error_message: '',
		is_replicable: '',
		contact_information: ''
	};

	$scope.submit_bug_report = function () {
		$http.post(
			'analytics/add_bug_report',
			$scope.bug_report
		).success(function (data, status, headers, config) {
			debugger;
			alert('Thank you, your bug report has been received!');
			$scope.bug_report.description = '';
			$scope.bug_report.page = '';
			$scope.bug_report.error_message = '';
			$scope.bug_report.is_replicable = '';
			$scope.bug_report.contact_information = '';
		}).error(function (data, status, headers, config) {
			alert(data + '\n' + status + '\n' + headers + '\n' + config);
		});
	};

}]);