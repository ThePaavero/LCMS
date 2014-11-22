
LCMS.Modules.EditablesFlasher = function() {

	var blocks;

	this.init = function()
	{
		blocks = $('.cms_editable');
		flashBlocks();
	};

	var flashBlocks = function()
	{
		blocks.addClass('flashing');

		setTimeout(function()
		{
			blocks.removeClass('flashing');
		}, 400);
	};

};
