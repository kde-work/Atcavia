(function($) {

    // Button Edit Component
    function mm_component_drag() {
        var $mm_line_container = $('.page-builder__component-list');

        $mm_line_container.sortable({
            scope: "component-line",
            placeholder:"ui-state-highlight",
            start: function(event, ui) {
                ui.helper.addClass("mm-component-line--drag");
            },
            stop: function(event, ui) {
                var $this = $(this),
                    $mm_component_line__drag = $('.mm-component-line--drag');

                $mm_component_line__drag.removeClass("mm-component-line--drag");
                mm_component_migration_find_new_id ($this, $mm_component_line__drag.data('cid'));
            }
        }).disableSelection();
    }

    // Move component to another location
    function mm_component_migration_find_new_id ($parent, old_id) {
        var $mm_component_line = $('.mm-line-container', $parent),
            i = 0;

        $mm_component_line.map(function () {
            var $this_tab = $(this),
                id = $this_tab.data('cid');

            if (id == old_id) {
                mm_component_migration (old_id, i);
            }
            i += 1;
        });
    }

    // Move component to another location
    function mm_component_migration (id, new_id) {
        if (id >= 0 && new_id >= 0 && id != new_id) {
            var tmp = {
                elements: []
            };
            var component_current = window.mammen.elements[id * 1];

            for (var key in window.mammen.elements) {
                var component = window.mammen.elements[key * 1];

                if (component && key == new_id && id > new_id) {
                    tmp.elements.push(component_current);
                }

                if (component && key != id) {
                    tmp.elements.push(component);
                }

                if (component && key == new_id && id < new_id) {
                    tmp.elements.push(component_current);
                }
            }
            window.mammen = tmp;
        }

        // filling Page Builder box
        mm_page_builder();

        // filling WYSIWYG
        mm_contain_WYSIWYG();
    }

    window.mm_component_drag = mm_component_drag;
    window.mm_component_migration = mm_component_migration;

})($ || window.jQuery);