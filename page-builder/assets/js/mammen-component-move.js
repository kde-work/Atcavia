(function($) {

    // Arrows Up/Down
    function mm_click_arrows() {
        var $arrows = $('.mm-icon__down, .mm-icon__up');

        $arrows.on('click', function () {
            var $this = $(this),
                cid = $this.data('cid');

            if ($this.hasClass('mm-icon__down')) {
                mm_component_move(cid, 'down');
            }
            if ($this.hasClass('mm-icon__up')) {
                mm_component_move(cid, 'up');
            }

            mm_contain_WYSIWYG();
            mm_page_builder();
        });
    }

    // Move component to Up/Down
    function mm_component_move (id, arrow) {
        var component = window.mammen.elements[id];

        if (arrow == 'up') {
            if (id > 0) {
                var tmp_up = window.mammen.elements[id*1-1];

                window.mammen.elements[id*1-1] = component;
                window.mammen.elements[id] = tmp_up;
            }
        } else if (arrow == 'down') {
            if (id < window.mammen.elements.length) {
                var tmp_down = window.mammen.elements[id*1+1];

                window.mammen.elements[id*1+1] = component;
                window.mammen.elements[id] = tmp_down;
            }
        }
    }

    window.mm_click_arrows = mm_click_arrows;
    window.mm_component_move = mm_component_move;

})($ || window.jQuery);
