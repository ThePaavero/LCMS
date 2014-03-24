/**
 * Component for server side messages that use the Alert class
 *
 * @package Laravel CMS
 * @author Pekka Siiriäinen
 */
Project.Components.Alerts = function() {

	var boxes;

	/**
	 * Initialize
	 *
	 * @return void
	 */
	this.init = function()
	{
		boxes = $('#alerts .alert');

		createClosers();
		bindClosers();
	};

	/**
	 * Create closer links
	 *
	 * @return void
	 */
	var createClosers = function()
	{
		// Do closers
		boxes.each(function()
		{
			$(this).prepend('<a href="#" class="closer">×</a>');
		});

		// Closers' click event listener
		boxes.find('.closer').on('click', function()
		{
			return false;
		});
	};

	/**
	 * Do click listeners for closer links
	 *
	 * @return void
	 */
	var bindClosers = function()
	{
		var closers = boxes.find('.closer');

		closers.on('click', function()
		{
			var my_box = $(this).parent();
			my_box.fadeOut(150, function()
			{
				my_box.remove();
			});

			return false;
		});
	};

};
