
window.LCMS               = {};
window.LCMS.EditableTypes = {};
window.LCMS.Modules       = {};

$(function()
{
	var mainpanel = new LCMS.Modules.MainPanel();
	mainpanel.init();

	var editables = new LCMS.Modules.Editables();
	editables.init();

	var sortablesitemap = new LCMS.Modules.SortableSitemap();
	sortablesitemap.init();
});
