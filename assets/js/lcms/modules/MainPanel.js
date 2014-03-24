
LCMS.Modules.MainPanel = function() {

	var panel;

	this.init = function()
	{
		panel = $('#lcms_main_panel');

		loadPanel(function()
		{
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
		//
	};

	var createMainPanelContainer = function()
	{
		$('body').prepend('<div id="lcms_main_panel"></div>');
		panel = $('#lcms_main_panel');
	};

};
