
LCMS.Modules.BlockTools = function(_block, _actions) {

	var block   = _block;
	var actions = _actions;
	var box;
	var block_id;

	var self = this;

	this.init = function()
	{
		block_id = block.attr('data-id');
		removePossibleOldBox();
		createBox();
	};

	this.destroy = function()
	{
		$(box).remove();
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

		for(var i in actions)
		{
			var a     = actions[i];
			var slug  = a.slug;
			var title = a.title;
			html += '<a href="#' + slug + '">' + title + '</a>';
		}

		html += '</div>';

		box.innerHTML = html;
		$(block).parent().prepend(box);

		$(box).css({
			'margin-top' : $(box).outerHeight() * -1 + 'px',
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
		for(var i in actions)
		{
			if(actions[i].slug === action)
			{
				var fn = actions[i].fn;
				fn();
			}
		}
	};

};
