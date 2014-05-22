
LCMS.Modules.Editables = function() {

	var blocks;

	this.init = function()
	{
		blocks = $('.cms_editable');
		blocks.each(render);
	};

	var render = function()
	{
		var type = $(this).attr('data-type');

		if(typeof LCMS.EditableTypes[type] === 'undefined')
		{
			type = 'Default';
		}

		var editabletype = LCMS.EditableTypes[type];
		var instance = new editabletype();

		instance.init($(this));
	};

};
