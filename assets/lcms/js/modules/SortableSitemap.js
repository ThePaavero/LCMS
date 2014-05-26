
LCMS.Modules.SortableSitemap = function() {

	var ul;

	this.init = function()
	{
		ul = $('.cms_navigation > ul');
		makeSortable();
	};

	var makeSortable = function()
	{
		// @todo This isn't working for some reason :/
		ul.sortable({
			'tolerance'  :'intersect',
			'cursor'     :'pointer',
			'items'      :'li',
			'placeholder':'placeholder',
			'nested'     :'ul'
		});
	};

};
