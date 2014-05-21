
LCMS.EditableTypes.Default = function() {

	var block;
	var tools;
	var block_id;

	this.init = function(_block)
	{
		block    = _block;
		block_id = block.attr('data-id');

		doEditableListener();
		doOnBlurListener();
	};

	var doEditableListener = function()
	{
		block.on('dblclick', makeEditable);
	};

	var makeEditable = function()
	{
		tools = new LCMS.Modules.BlockTools(block, [
			{
				fn   : actionSave,
				slug : 'save',
				title: 'Save'
			},
			{
				fn   : actionCancel,
				slug : 'cancel',
				title: 'Cancel'
			}
		]);
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

	var actionSave = function()
	{
		console.log('Saving...');
		var new_content = block.html();
		updateContent(new_content, function()
		{
			undoEditable();
			tools.destroy();
		});
	};

	var actionCancel = function()
	{
		undoEditable();
		tools.destroy();
	};

	var updateContent = function(content, callback)
	{
		var data = JSON.stringify({
			'content': content,
			'block_id': block_id
		});

		$.ajax({
			url         : _root + 'lcms/update_content',
			type        : 'POST',
			contentType : 'application/json',
			data        : data,
			dataType    : 'json',
			success     : function(response)
			{
				if(response.success)
				{
					block.html(response.content_received);
					callback();
					return;
				}

				console.error('Failed to update content on server for some reason.');
			}
		});
	};

};
