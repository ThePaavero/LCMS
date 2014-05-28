
LCMS.Modules.NewPageForm = function() {

	var form;
	var url_field;
	var url_field_original_value;

	this.init = function()
	{
		form = $('.lcms_page_form_wrapper > form');
		url_field = form.find('input[name=url]');
		url_field_original_value = url_field.val();

		doListeners();
	};

	var doListeners = function()
	{
		form.on('keyup', cloneTitleToUrl);
	};

	var cloneTitleToUrl = function()
	{
		var base_url = url_field.val(); // todo... updating? this won't work

		var title = form.find('input[name=title]').val();
		var slugified = url_field_original_value + convertToSlug(title);

		url_field.val(slugified);
	};

	var convertToSlug = function(Text)
	{
		return Text
		.toLowerCase()
		.replace(/ä/g,'a')
		.replace(/ö/g,'o')
		.replace(/å/g,'a')
		.replace(/ /g,'-')
		.replace(/[^\w-]+/g,'');
	};

};
