
LCMS.EditableTypes.Default = function() {

	var block;
	var tools;
	var block_id;
	var revert_content_to;

	this.init = function(_block)
	{
		block    = _block;
		block_id = block.attr('data-id');

		revert_content_to = block.html();

		doEditableListener();
		doOnBlurListener();
	};

	var doEditableListener = function()
	{
		block.on('dblclick', makeEditable);
	};

	var makeEditable = function()
	{
		if( ! block.attr('id'))
		{
			block.attr('id', 'u_' +  Date.now());
		}

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
			},
			{
				fn   : actionToRich,
				slug : 'rich',
				title: 'Rich Editor'
			},
			{
				fn   : actionHistory,
				slug : 'history',
				title: 'History'
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
		restoreContent();
		undoEditable();
		tools.destroy();
	};

	var actionToRich = function()
	{
		tinymce.init({
			selector: '#' + block.attr('id')
		});
	};

	var actionHistory = function()
	{
		$.colorbox({href: _root + 'lcms/get_history_for_block/' + block_id});
	};

	var restoreContent = function()
	{
		block.html(revert_content_to);
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
					revert_content_to = response.content_received;
					callback();
					return;
				}

				console.error('Failed to update content on server for some reason.');
			}
		});
	};

};
