
LCMS.Modules.MainPanel = function() {

	var self = this;
	var panel;
	var dyn_content;
	var main_links;
	var body;

	var panel_orig_width = 300;
	var panel_open_width = 600;

	this.init = function()
	{
		panel = $('#lcms_main_panel');
		body = $('body');

<<<<<<< HEAD
		replaceTokens();

		loadPanel(function()
		{
			main_links = panel.find('nav > ul > li > a').not('.noajax');
=======
		loadPanel(function()
		{
			main_links = panel.find('nav > ul > li > a').not('.noajax');
			doListeners();
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

			var panel_state = localStorage.getItem('lcms_panel_state');
			if(panel_state === 'panel_open') {
				openPanel();
			}

			// We don't want to animate the initial state
			setTimeout(function(){
				$(body).addClass('animate');
				$('#lcms_container').addClass('animate');
			}, 200);


			panel.find('.handle').click(function(e){
				e.preventDefault();

				if($(body).hasClass('panel_open')){
					closePanel();
				} else {
					openPanel();
				}
			});

			dyn_content = $(panel).find('.dyn_content');
			panelSizeReset();
<<<<<<< HEAD
			doListeners();
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

			LCMS.Modules.Events.addEventListener(self, 'openInMainPanel', function(e){
				loadContent(e.href);
			});
		});
	};

	var openPanel = function() {
		$(body).addClass('panel_open');
		localStorage.setItem('lcms_panel_state', 'panel_open');
	};

	var closePanel = function() {
		removeDynamicContent();
		$(body).removeClass('panel_open');
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
<<<<<<< HEAD
		var add_these = dyn_content.find('a').not('.noajax, .close_dyn_content');
		main_links = main_links.add(add_these);

		main_links.off('click');
		main_links.on('click', function(e)
		{
			e.preventDefault();
			loadContent($(e.target).attr('href'));
		});

		var confirms = $('.lcms_confirm');
		confirms.off('click');
=======
		main_links.click(function(e){
			e.preventDefault();

			loadContent($(e.target).attr('href'));
		});

		var confirms = panel.find('.confirm');
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		confirms.on('click', function(e)
		{
			if( ! window.confirm('Are you sure?'))
			{
				e.preventDefault();
			}
		});

		doFlashEditableAreasListener();
	};

	var loadContent = function(url) {
<<<<<<< HEAD
		NProgress.start();

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		$.ajax({
			url: url,
		})
		.done(function( data ) {
			addDynamicContent(data);
<<<<<<< HEAD
			NProgress.done();
			doListeners();
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		});
	};

	var addDynamicContent = function(content) {
		openPanel();
		removeDynamicContent();
		dyn_content.hide();
		dyn_content.append(content);
		dyn_content.fadeIn(350);
		dyn_content.prepend('<a class="close_dyn_content" href="#">X</a>');
		dyn_content.find('.close_dyn_content').click(function(e){
			e.preventDefault();
			removeDynamicContent();
		});
		panelSizeWide();
		onPanelContentChange();
	};

	var removeDynamicContent = function() {
		dyn_content.html('');
		panelSizeReset();
	};

	var panelSizeReset = function() {
		if(!body.hasClass('panel_orig_width')) {
			body.addClass('panel_orig_width');
		}

		if(body.hasClass('panel_wide')) {
			body.removeClass('panel_wide');
		}
	};

	var panelSizeWide = function() {
		if(!body.hasClass('panel_wide')) {
			body.addClass('panel_wide');
		}

		if(!body.hasClass('panel_orig_width')) {
			body.removeClass('panel_orig_width');
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

	var onPanelContentChange = function()
	{
		var newpageform = new LCMS.Modules.NewPageForm();
		newpageform.init();

		$('.datepicker').datetimepicker({
			format: 'Y-m-d H:i:s'
		});
	};

	var doFlashEditableAreasListener = function()
	{
		$('.icon_flash_editables').on('click', flashEditableAreas);
	};

	var flashEditableAreas = function(e)
	{
		e.preventDefault();

		var flasher = new LCMS.Modules.EditablesFlasher();
		flasher.init();
	};

<<<<<<< HEAD
	var replaceTokens = function()
	{
		var page_id = getCurrentPageId();

		$('a').each(function()
		{
			if( ! $(this).attr('href'))
			{
				return true;
			}

			$(this).attr('href', $(this).attr('href').replace('[LCMS_PAGE_ID]', page_id));
		});
	};

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
};
