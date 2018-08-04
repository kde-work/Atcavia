(function($) {

    // Button Edit Component
    function mm_component_duplicate() {
        var $mm_icon__duplicate = $('.mm-modal__duplicate');

        $mm_icon__duplicate.on('click', function () {
            var $this = $(this),
                $modal = $this.closest('.mm-modal--now-editing'),
                cid = $modal.data('edit'),
                id = $modal.data('id'),
                new_cid;

            if (cid != -1) {
                var tmp = {
                    elements: []
                };

                for (var key in window.mammen.elements) {
                    var component = window.mammen.elements[key * 1];

                    tmp.elements.push(component);
                    if (component && key == cid) {
                        tmp.elements.push(component);
                        new_cid = cid;
                    }
                }
                window.mammen = tmp;

                // filling Page Builder box
                mm_page_builder();

                // filling WYSIWYG
                mm_contain_WYSIWYG();

                // close current window
                mm_close_window();

                // open new modal window
                // mm_open_window(id);
                // $modal.addClass('mm-modal--now-editing');
                // mm_open_component_edit(id, new_cid);
            }
        });
    }

    window.mm_component_duplicate = mm_component_duplicate;

})($ || window.jQuery);