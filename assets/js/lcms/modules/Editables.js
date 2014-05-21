
LCMS.Modules.Editables = function() {

	var blocks;

	this.init = function()
	{
		blocks = $('.cms_editable');

		doListeners();
	};

	var doListeners = function()
	{
		blocks.on('dblclick', makeEditable);
	};

	var makeEditable = function(e)
	{
		e.preventDefault();
		var type = $(this).attr('data-type');

		var instance;

		try
		{
			var editabletype = LCMS.EditableTypes[type];
			instance = new editabletype();
		}
		catch(exception)
		{
			console.error('Does the EditableType "' + type + '" exist?');
			console.error(exception);
			return;
		}

		instance.init();
	};

};
