
LCMS.EditableTypes.Default = function() {

	var self = this;
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
<<<<<<< HEAD
		NProgress.start();

=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		console.log('Saving...');
		tinymce.remove('#' + block.attr('id'));
		var new_content = block.html();
		updateContent(new_content, function()
		{
			stopEditing();
<<<<<<< HEAD
			NProgress.done();
=======
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
		});
	};

	var actionCancel = function()
	{
		restoreContent();
		stopEditing();
	};

	var actionToRich = function()
	{
		tinymce.init({
			plugins: ['link', 'image', 'code', 'table'],
			selector: '#' + block.attr('id'),
			file_browser_callback : elFinderBrowser,
			toolbar: [
				'undo redo | styleselect | bold italic | link image | alignleft aligncenter alignright | inserttable'
			]
		});
	};

	var actionHistory = function()
	{
		LCMS.Modules.Events.dispatchEvent('openInMainPanel', {href: _root + 'lcms/get_history_for_block/' + block_id});
	};

	var restoreContent = function()
	{
		block.html(revert_content_to);
	};

	var stopEditing = function()
	{
		undoEditable();
		tools.destroy();
		tinymce.remove('#' + block.attr('id'));
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

	var elFinderBrowser = function(field_name, url, type, win)
	{
		tinymce.activeEditor.windowManager.open({
			file: _root + 'elfinder/tinymce', // use an absolute path!
			title: 'elFinder 2.0',
			width: 900,
			height: 450,
			resizable: 'yes'
		}, {
			setUrl: function (url) {
				console.log(url);
				win.document.getElementById(field_name).value = url;
			}
		});
		return false;
	};

};
