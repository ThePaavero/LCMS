
LCMS.Modules.NewPageForm = function() {

	var form;

	this.init = function()
	{
		form = $('.lcms_modal.create_new_page > form');

		doListeners();
	};

	var doListeners = function()
	{
		form.on('keyup', cloneTitleToUrl);
	};

	var cloneTitleToUrl = function()
	{
		var title = form.find('input[name=title]').val();
		var slugified = convertToSlug(title);
		form.find('input[name=url]').val(slugified);
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
