LCMS.Modules.SortableSitemap = function () {

    var wrapper;

    this.init = function () {

        wrapper = $('.nested-sortable');
        wrapper.addClass('dd');
        wrapper.find('ul').addClass('dd-list');

        var listItems = wrapper.find('li');
        listItems.addClass('dd-item');
        listItems.prepend('<div class="dd-handle"></div>');
        listItems.find('.dd-handle').each(function(){
            var me = $(this);
            me.css({
                width : me.siblings('a').width,
                height : me.siblings('a').height,
            });
        });

        makeSortable();
        listenForChanges();
    };

    var makeSortable = function () {
        $('.dd').nestable();
        wrapper.find('ul').nestable({});
        console.log('Made list sortable');
    };

    var listenForChanges = function () {

        wrapper.on('change', function () {

            var data = wrapper.nestable('serialize');
            console.log(data);
        });
    };

};
