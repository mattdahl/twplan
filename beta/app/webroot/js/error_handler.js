var TWP = TWP || {};

TWP.error_handler = function (message, url, line_number) {
	var suppressed = false;

	if (line_number == 88 && message.indexOf('10 $digest()')) {
		var suppressed = true;
	}
	else {
		alert('Sorry, something went wrong. This error has been logged and we will try to resolve it. You may be able to continue using TWplan - try again!');
	}

	$.ajax({
		url: 'analytics/add_bug_report',
		type: 'POST',
		contentType: 'application/json; chareset=utf-8',
		data: JSON.stringify({
			description: line_number,
			page: url + ' (on: ' + document.URL + ')',
			error_message: suppressed ? message + ' (suppressed)' : message,
			is_js: true,
			is_replicable: null,
			contact_information: null
		}),
		success: function (data) {
			debugger;
		},
		error: function (data) {
			alert('Please file a bug report! Something is really wrong.\nError_message: ' + data);
		},
	});

	return false;
};

window.onerror = TWP.error_handler;