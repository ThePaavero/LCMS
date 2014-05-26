
LCMS.Modules.MainPanel = function() {

	var panel;
	var dyn_content;
	var main_links;

	var panel_orig_width = 300;
	var panel_open_width = 600;

	this.init = function()
	{
		panel = $('#lcms_main_panel');

		loadPanel(function()
		{
			main_links = panel.find('nav > ul > li > a').not('.noajax');
			doListeners();

			var panel_state = localStorage.getItem('lcms_panel_state');
			if(panel_state === 'open') {
				openPanel();
			}

			// We don't want to animate the initial state
			setTimeout(function(){
				$(panel).addClass('animate');
				$('#container').addClass('animate');
			}, 200);


			panel.find('.handle').click(function(e){
				e.preventDefault();

				if($(panel).hasClass('open')){
					closePanel();
				} else {
					openPanel();
				}
			});

			dyn_content = $(panel).find('.dyn_content');
			panelSizeReset();
		});
	};

	var openPanel = function() {
		$('#container').addClass('open');
		$(panel).addClass('open');
		localStorage.setItem('lcms_panel_state', 'open');
	};

	var closePanel = function() {
		$(panel).removeClass('open');
		$('#container').removeClass('open');
		localStorage.setItem('lcms_panel_state', 'closed');
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
		//main_links.colorbox();
		main_links.click(function(e){
			e.preventDefault();

			loadContent(e.currentTarget);
		});

		var confirms = panel.find('.confirm');
		confirms.on('click', function(e)
		{
			if( ! window.confirm('Are you sure?'))
			{
				e.preventDefault();
			}
		});
	};

	var loadContent = function(target) {
		var url = $(target).attr('href');

		$.ajax({
			url: url,
		})
		.done(function( data ) {
			addDynamicContent(data);
		});
	};

	var addDynamicContent = function(content) {
		dyn_content.append(content);
		dyn_content.prepend('<a class="close_dyn_content" href="#">X</a>');
		dyn_content.find('.close_dyn_content').click(function(e){
			e.preventDefault();
			removeDynamicContent();
		});
		panelSizeWide();
	};

	var removeDynamicContent = function() {
		dyn_content.html('');
		panelSizeReset();
	};

	var panelSizeReset = function() {
		if(!panel.hasClass('orig')) {
			panel.addClass('orig');
		}

		if(panel.hasClass('wide')) {
			panel.removeClass('wide');
		}
	};

	var panelSizeWide = function() {
		if(!panel.hasClass('wide')) {
			panel.addClass('wide');
		}

		if(!panel.hasClass('orig')) {
			panel.removeClass('orig');
		}
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
