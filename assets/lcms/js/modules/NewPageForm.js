
LCMS.Modules.NewPageForm = function() {

	var form;
	var url_field;
	var url_field_original_value;
	var updating = false;

	this.init = function()
	{
		form = $('.lcms_page_form_wrapper > form');

		if(form.length < 1)
		{
			return;
		}

		url_field = form.find('input[name=url]');
		url_field_original_value = url_field.val();

		// Are we creating a new page or updating an old one?
		if(form.attr('action').indexOf('update_page') > -1)
		{
			updating = true;
		}

		doListeners();
		doFocus();
	};

	var doListeners = function()
	{
		form.on('keyup', cloneTitleToUrl);
	};

	var cloneTitleToUrl = function()
	{
		var base_url = url_field_original_value;

		// If we're updating an old page, it's a bit of a different logic
		if(updating)
		{
			var old_segments = url_field_original_value.split('/');
			old_segments.pop();
			base_url = old_segments.join('/');
		}

		var title = form.find('input[name=title]').val();
		var slugified = base_url + (base_url !== '' ? '/' : '') + convertToSlug(title);
		slugified = slugified.replace(/\/\//g, '/');

		url_field.val(slugified);
	};

	var convertToSlug = function(Text)
	{
		return Text
		.toLowerCase()
		.replace(/ä/g,'a')
		.replace(/ö/g,'o')
		.replace(/å/g,'a')
		.replace(/ /g,'_')
		.replace(/[^\w-]+/g,'');
	};

	var doFocus = function()
	{
		form.find('input[name=title]').focus();
	};

};
