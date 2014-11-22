
LCMS.Modules.NewPageForm = function() {

	var form;
	var url_field;
	var url_field_original_value;
	var updating = false;

	this.init = function()
	{
<<<<<<< HEAD
		form = $('.lcms_form_wrapper > form');
=======
		form = $('.lcms_page_form_wrapper > form');
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

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
<<<<<<< HEAD
		doFocus();
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
	};

	var doListeners = function()
	{
		form.on('keyup', cloneTitleToUrl);
	};

	var cloneTitleToUrl = function()
	{
<<<<<<< HEAD
		var base_url = url_field_original_value;
=======
		var base_url = url_field.val();
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

		// If we're updating an old page, it's a bit of a different logic
		if(updating)
		{
			var old_segments = url_field_original_value.split('/');
			old_segments.pop();
			base_url = old_segments.join('/');
		}

		var title = form.find('input[name=title]').val();
		var slugified = base_url + (base_url !== '' ? '/' : '') + convertToSlug(title);
<<<<<<< HEAD
		slugified = slugified.replace(/\/\//g, '/');
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

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

<<<<<<< HEAD
	var doFocus = function()
	{
		form.find('input[name=title]').focus();
	};

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
};
