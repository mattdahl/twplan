TWP.Header.Factories.factory('MetaData', [function () {
	return {
		username: $('meta[name=username]').attr('content'),
		user_id: $('meta[name=user_id]').attr('content'),
		current_world: parseInt($('meta[name=current_world]').attr('content')),
		last_updated: $('meta[name=last_updated]').attr('content')
	};
}]);