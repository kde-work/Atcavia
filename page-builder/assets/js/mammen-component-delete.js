(function($) {

    // Button Edit Component
    function mm_component_delete() {
        var $mm_icon__delete = $('.mm-modal__delete');

        $mm_icon__delete.on('click', function () {
            var $this = $(this),
                $modal = $this.closest('.mm-modal--now-editing'),
                cid = $modal.data('edit'),
                id = $modal.data('id');

            if (cid != -1) {
                var tmp = {
                    elements: []
                };

                for (var key in window.mammen.elements) {
                    var component = window.mammen.elements[key * 1];

                    if (component && key != cid) {
                        tmp.elements.push(component); 
                    }
                }
                window.mammen = tmp;

                // filling Page Builder box
                mm_page_builder();

                // filling WYSIWYG
                mm_contain_WYSIWYG();

                // close current window
                mm_close_window();
            }
        });
    }

    window.mm_component_delete = mm_component_delete;

})($ || window.jQuery);