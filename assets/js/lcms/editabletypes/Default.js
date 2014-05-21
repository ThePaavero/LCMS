
LCMS.EditableTypes.Default = function() {

	var block;
	var tools;

	this.init = function(_block)
	{
		block = _block;

		doEditableListener();
		doOnBlurListener();
	};

	var doEditableListener = function()
	{
		block.on('dblclick', makeEditable);
	};

	var makeEditable = function()
	{
		tools = new LCMS.Modules.BlockTools(block);
		tools.init();

		block.addClass('contenteditable');
		block.attr('contenteditable', true);
	};

	var doOnBlurListener = function()
	{
		block.on('blur', undoEditable);
	};

	var undoEditable = function()
	{
		block.removeClass('contenteditable');
		block.attr('contenteditable', false);
	};

};
