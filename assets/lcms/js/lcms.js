
window.LCMS                 = {};
window.LCMS.globalInstances = {};
window.LCMS.EditableTypes   = {};
window.LCMS.Modules         = {};

$(function()
{
	var mainpanel = new LCMS.Modules.MainPanel();
	mainpanel.init();
	window.LCMS.globalInstances.mainpanel = mainpanel;

	var editables = new LCMS.Modules.Editables();
	editables.init();
	window.LCMS.globalInstances.editables = editables;

	//var sortablesitemap = new LCMS.Modules.SortableSitemap();
	//sortablesitemap.init();
	//window.LCMS.globalInstadata-ytta-idnces.sortablesitemap = sortablesitemap;
});
