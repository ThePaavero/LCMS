
<div class='lcms_modal create_new_page'>

    <h1>Manage page order</h1>

    <div class='nested-sortable dd'>
        {{ $data['pages'] }}
    </div><!-- nested-sortable -->

</div><!-- lcms_modal -->

<script>
$('.dd').nestable({ /* config options */ });
var sortablesitemap = new LCMS.Modules.SortableSitemap();
	sortablesitemap.init();
	window.LCMS.globalInstances.sortablesitemap = sortablesitemap;

</script>
