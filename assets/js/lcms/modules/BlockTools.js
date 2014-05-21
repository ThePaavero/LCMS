
LCMS.Modules.BlockTools = function(_block) {

	var block = _block;
	var box;
	var block_id;

	var self = this;

	this.init = function()
	{
		block_id = block.attr('data-id');
		removePossibleOldBox();
		createBox();
	};

	var removePossibleOldBox = function()
	{
		$('.cms_block_tools[data-block_id=' + block_id + ']').remove();
	};

	var createBox = function()
	{
		box = document.createElement('div');
		box.className = 'cms_block_tools';
		$(box).attr('data-block_id', block_id);

		var html = '';
		html += '<a href="#save">Save</a>';
		html += '<a href="#cancel">Cancel</a>';
		html += '<a href="#history">History</a>';
		html += '</div>';

		box.innerHTML = html;
		$('body').prepend(box);

		var top = block.offset().top - $(box).outerHeight();
		var left = block.offset().left;

		$(box).css({
			'top' : top,
			'left': left
		});

		doListenersForBox();
	};

	var doListenersForBox = function()
	{
		var links = $(box).find('a');

		links.on('click', doOnToolLinkClick);
	};

	var doOnToolLinkClick = function(e)
	{
		e.preventDefault();
		var action = $(this).attr('href').split('#')[1];
		self[action]();
	};

	this.save = function()
	{
		console.log('Saving');
	};

	this.cancel = function()
	{
		console.log('Canceling');
	};

	this.history = function()
	{
		console.log('History');
	};

};
