
<<<<<<< HEAD
window.LCMS                 = {};
window.LCMS.globalInstances = {};
window.LCMS.EditableTypes   = {};
window.LCMS.Modules         = {};
=======
window.LCMS               = {};
window.LCMS.EditableTypes = {};
window.LCMS.Modules       = {};
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f

$(function()
{
	var mainpanel = new LCMS.Modules.MainPanel();
	mainpanel.init();
<<<<<<< HEAD
	window.LCMS.globalInstances.mainpanel = mainpanel;

	var editables = new LCMS.Modules.Editables();
	editables.init();
	window.LCMS.globalInstances.editables = editables;

	var sortablesitemap = new LCMS.Modules.SortableSitemap();
	sortablesitemap.init();
	window.LCMS.globalInstances.sortablesitemap = sortablesitemap;
=======

	var editables = new LCMS.Modules.Editables();
	editables.init();

	var sortablesitemap = new LCMS.Modules.SortableSitemap();
	sortablesitemap.init();
>>>>>>> 369acc76ddfcffd9f3a374c208ac186999d6134f
});
