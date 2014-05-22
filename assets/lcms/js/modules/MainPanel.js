
LCMS.Modules.MainPanel = function() {

	var panel;
	var main_links;

	this.init = function()
	{
		panel = $('#lcms_main_panel');

		loadPanel(function()
		{
			main_links = panel.find('nav > ul > li > a').not('.noajax');
			doListeners();
		});
	};

	var loadPanel = function(callback)
	{
		if(panel.length < 1)
		{
			createMainPanelContainer();
		}

		var url = _root + 'lcms/get_main_panel';

		panel.load(url, callback);
	};

	var doListeners = function()
	{
		main_links.colorbox();
		/*main_links.on('click', function(e)
		{
			e.preventDefault();
			console.log(':D');
			return false;
		});*/
	};

	var createMainPanelContainer = function()
	{
		$('body').prepend('<div id="lcms_main_panel"></div>');
		panel = $('#lcms_main_panel');
	};

};
