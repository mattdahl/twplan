TWP.twplan.Factories.factory('MetaData', [function () {
	return {
		username: $('meta[name=username]').attr('content'),
		user_id: $('meta[name=user_id]').attr('content'),
		current_world: parseInt($('meta[name=current_world]').attr('content'), 10),
		last_updated: $('meta[name=last_updated]').attr('content'),
		default_world: $('meta[name=default_world]').attr('content'),
		local_timezone: $('meta[name=local_timezone]').attr('content')
	};
}]);