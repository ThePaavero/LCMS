
LCMS.Modules.BlockTools = function(_block) {

	var block = _block;
	var box;

	this.init = function()
	{
		createBox();
	};

	var createBox = function()
	{
		box = document.createElement('div');
		box.className = 'cms_block_tools';

		var html = '';
		html += '<a href="#">Save</a>';
		html += '<a href="#">Cancel</a>';
		html += '<a href="#">History</a>';
		html += '</div>';

		box.innerHTML = html;
		$('body').prepend(box);

		var top = block.offset().top - $(box).outerHeight();
		var left = block.offset().left;

		$(box).css({
			'top' : top,
			'left': left
		});
	};

};
