window.Project            = {};
window.Project.App        = {};
window.Project.Helpers    = {};
window.Project.Components = {};

$(function()
{
	var app = new Project.App();
	app.init();

	window.appInstance = app;
});
