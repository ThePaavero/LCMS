
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

			var panel_state = localStorage.getItem('lcms_panel_state');
			if(panel_state === 'open') {
				$(panel).addClass('open');
			}

			// We don't want to animate the initial state
			setTimeout(function(){
				$(panel).addClass('animate');
			}, 200);

			panel.find('.handle').click(function(e){
				e.preventDefault();

				if($(panel).hasClass('open')){
					$(panel).removeClass('open');
					localStorage.setItem('lcms_panel_state', 'closed');
				} else {
					$(panel).addClass('open');
					localStorage.setItem('lcms_panel_state', 'open');
				}
			});
		});
	};

	var loadPanel = function(callback)
	{
		if(panel.length < 1)
		{
			createMainPanelContainer();
		}

		var page_id = getCurrentPageId();

		var url = _root + 'lcms/get_main_panel/' + page_id;

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

	var getCurrentPageId = function()
	{
		return $('meta[name=lcms_page_id]').attr('value');
	};

};
