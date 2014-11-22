
LCMS.Modules.HistoryList = function(_block_id, _ul) {

	var ul       = _ul;
	var block_id = _block_id;

	this.init = function()
	{
		doListeners();
	};

	var doListeners = function()
	{
		var links = ul.find('a');
		links.on('click', activateHistory);
	};

	var activateHistory = function(e)
	{
		e.preventDefault();
		var id = parseInt($(this).attr('href').split('#')[1], 10);

		$.ajax({
			url     : _root + 'lcms/get_version_of_block/' + id,
			dataType: 'JSON',
			success : function(response)
			{
				var inject_to = $('span[data-id=' + block_id + ']');
				inject_to.html(response.contents);
			}
		});
	};

};
