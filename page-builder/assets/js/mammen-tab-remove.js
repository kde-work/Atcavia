(function($) {

    // Remove Tab
    function mm_remove_tab(elem) {
        var $this = $(elem),
            group_id = $this.data('group-id'),
            id_tab = $this.data('tab-id'),
            $mm_tabs = $this.closest('.mm-tabs'),
            $tab__new = $('.mm-tabs__tab--'+id_tab+'.mm-tabs-group--'+group_id+' ~ .mm-tabs__tab--new', $mm_tabs),
            max_tab_id = $tab__new.data('max-tab-id'),
            $tab__head = $('.mm-tabs__tab--'+id_tab+'.mm-tabs-group--'+group_id, $mm_tabs),
            $tab__body = $('.mm-tabs__content--'+id_tab+'.mm-tabs-group--'+group_id, $mm_tabs),
            $all_tab__head = $('.mm-tabs__tab.mm-tabs-group--'+group_id, $mm_tabs),
            $next_tab__head = $('.mm-tabs__tab--'+(id_tab+1)+'.mm-tabs-group--'+group_id, $mm_tabs),
            $prev_tab__head = $('.mm-tabs__tab--'+(id_tab-1)+'.mm-tabs-group--'+group_id, $mm_tabs);

        if ($prev_tab__head.length || $next_tab__head.length) {

            if (!$next_tab__head.length) {
                $tab__head.remove();
                $tab__body.remove();
                $prev_tab__head.trigger('click');
            } else {
                $all_tab__head.map(function () {
                    var $this_tab = $(this),
                        current_id_tab = $this_tab.data('tab-id');

                    if (current_id_tab > id_tab) {
                        var html_tab__body = '',
                            html_tab__tab = '',
                            $next_iter_tab__body = $('.mm-tabs__content--'+(current_id_tab+1)+'.mm-tabs-group--'+group_id, $mm_tabs),
                            $next_iter_tab__head = $('.mm-tabs__tab--'+(current_id_tab+1)+'.mm-tabs-group--'+group_id, $mm_tabs);

                        if ($next_iter_tab__head.length) {
                            html_tab__body = $('.mm-tabs__content--'+(current_id_tab)+'.mm-tabs-group--'+group_id, $mm_tabs).clone();
                            html_tab__tab = $('.mm-tabs__tab--'+(current_id_tab)+'.mm-tabs-group--'+group_id, $mm_tabs).clone();
                        }

                        mm_rename_tab($mm_tabs, group_id, current_id_tab*1 - 1, current_id_tab);

                        if (html_tab__body) {
                            $next_iter_tab__body.before(html_tab__body);
                            $next_iter_tab__head.before(html_tab__tab);
                        }
                    }
                });
            }

            var $new_tab__head = $('.mm-tabs__tab--'+id_tab+'.mm-tabs-group--'+group_id, $mm_tabs);

            if ($new_tab__head.length) {
                $new_tab__head.trigger('click');
            } else {
                $prev_tab__head.trigger('click');
            }

            mm_clear_mm_tabs($mm_tabs, max_tab_id - 1);
            $tab__new.data('max-tab-id', max_tab_id - 1);
        }
    }

    // Rename Tab
    function mm_rename_tab($mm_tabs, group_id, id_tab, new_id_tab) {
        var $new_tab__head = $('.mm-tabs__tab--'+new_id_tab+'.mm-tabs-group--'+group_id, $mm_tabs),
            $new_tab__body = $('.mm-tabs__content--'+new_id_tab+'.mm-tabs-group--'+group_id, $mm_tabs),
            $old_tab__head = $('.mm-tabs__tab--'+id_tab+'.mm-tabs-group--'+group_id, $mm_tabs),
            $old_tab__body = $('.mm-tabs__content--'+id_tab+'.mm-tabs-group--'+group_id, $mm_tabs),
            $new_mm__name = $('.mm__name', $new_tab__body),
            re = new RegExp('__' + group_id + '\-' + new_id_tab + '', 'gi');

        $new_mm__name.map(function () {
            var $this = $(this),
                old_el_id = $this.attr('id'),
                $label = $('[for="'+old_el_id+'"]', $new_tab__body),
                old_el_name = $this.attr('name'),
                new_el_name = old_el_name.replace(re, '__' + group_id + '-' + id_tab),
                new_el_id = old_el_id.replace(re, '__' + group_id + '-' + id_tab);

            $this.attr('name', new_el_name);
            $this.attr('id', new_el_id);
            $label.attr('for', new_el_id);
        });

        $new_tab__head.html(id_tab);

        $old_tab__head.remove();
        $old_tab__body.remove();

        $new_tab__body.removeClass('mm-tabs__content--'+new_id_tab).addClass('mm-tabs__content--'+id_tab);
        $new_tab__body.data('tab-id', id_tab);

        $new_tab__head.removeClass('mm-tabs__tab--'+new_id_tab).addClass('mm-tabs__tab--'+id_tab);
        $new_tab__head.data('tab-id', id_tab);
    }

    window.mm_remove_tab = mm_remove_tab;

})($ || window.jQuery);