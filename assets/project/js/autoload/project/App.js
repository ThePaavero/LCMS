Project.App = function() {

	this.init = function()
	{
		console.log('Application initializing...');

		var alerts = new Project.Components.Alerts();
		alerts.init();
	};

};
