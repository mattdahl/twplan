TWP.twplan.Factories.factory('$exceptionHandler', function () {
	return function (exception, cause) {
		// Handle the error like regular JS errors (alert the user and POST to the server)
		window.onerror(exception.message, exception.stack, cause || null);
	};
});