
<div class='lcms_modal create_new_page'>

    <h1>Manage page order</h1>

    <div class="dd">
        <ol class="dd-list">
            <li class="dd-item" data-id="1">
                <div class="dd-handle">Item 1</div>
            </li>
            <li class="dd-item" data-id="2">
                <div class="dd-handle">Item 2</div>
            </li>
            <li class="dd-item" data-id="3">
                <div class="dd-handle">Item 3</div>
                <ol class="dd-list">
                    <li class="dd-item" data-id="4">
                        <div class="dd-handle">Item 4</div>
                    </li>
                    <li class="dd-item" data-id="5">
                        <div class="dd-handle">Item 5</div>
                    </li>
                </ol>
            </li>
        </ol>
    </div>

    <div class='nested-sortable'>
        {{ $data['pages'] }}
    </div><!-- nested-sortable -->

</div><!-- lcms_modal -->

<script>
//$('.dd').nestable({ /* config options */ });
var sortablesitemap = new LCMS.Modules.SortableSitemap();
	sortablesitemap.init();
	window.LCMS.globalInstances.sortablesitemap = sortablesitemap;

</script>
