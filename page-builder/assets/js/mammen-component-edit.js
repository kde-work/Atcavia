(function($) {

    // Button Edit Component
    function mm_component_edit() {
        var $mm_icon__setting = $('.mm-icon__setting');

        $mm_icon__setting.on('click', function () {
            var $this = $(this),
                $body = $('body'),
                cid = $this.data('cid'),
                slug = $this.data('slug'),
                $modal = $('.mm-modal--' + slug),
                id = $modal.data('id'),
                $opened_window = $('.mm-modal--' + id),
                $switch_tmce = $('.switch-tmce', $modal); // Visual mode buttons

            $body.addClass('modal-load').addClass('open').addClass('open--' + id);
            mm_clear_from($opened_window);
            mm_open_component_edit(id, cid);
            $body.removeClass('modal-load');
            mm_open_window(id, false);
            $modal.addClass('mm-modal--now-editing');
            $switch_tmce.trigger('click'); // switch WYSIWYG editors to the Visual mode
        });
    }

    // Open window Edit Component
    function mm_open_component_edit (id, cid) {
        var $modal = $('.mm-modal--' + id),
            component = window.mammen.elements[cid],
            regex = /([a-zA-Z_0-9-_]+?)=\"(.*?)\"/ig,
            parsing_data;

        $modal.data('edit', ''+cid);

        while ((parsing_data = regex.exec(component.shortcode)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (parsing_data.index === regex.lastIndex) {
                regex.lastIndex++;
            }

            // Opening tabs
            mm_edit_tab(id, parsing_data[1]);

            if (parsing_data[2] && parsing_data[1] && parsing_data[1] != 'component' && parsing_data[1] != 'component_id') {
                var $container = $('[name="' + parsing_data[1] +'"]', $modal),
                    $ooto_par = $container.parents('.mm-tabs__content--ooto');

                parsing_data[2] = parsing_data[2]
                                    .replace(/<br>/g, '\n')
                                    .replace(/\&\#44\;/g, ',')
                                    .replace(/\&\#34\;/g, '"')
                                    .replace(/\&\#91\;/g, '[')
                                    .replace(/\&\#93\;/g, ']')
                                    .replace(/\&\#39\;/g, "'");

                if ($container.length) {
                    var tag = $container.get(0).tagName.toLowerCase();
                } else {
                    continue;
                }

                // Open OOTO Tab
                if ($ooto_par.length) {
                    $ooto_par.map(function() {
                        var $this = $(this),
                            tab_id = $this.data('tab-id'),
                            $mm_tabs = $this.parents('.mm-tabs').first(),
                            $mm_tabs__tab = $mm_tabs.find('.mm-tabs__tab--'+tab_id).first();

                        $mm_tabs__tab.trigger('click');
                    });
                }

                if (tag == 'textarea') {
                    $container.val(parsing_data[2]);
                    continue;
                }

                if (tag == 'select') {
                    if(!$container.prop('multiple')) {
                        $container.val(parsing_data[2]);
                    } else {
                        var data_arr = parsing_data[2].split(','),
                            $option = $('option', $container);

                        $option.each(function () {
                            var $this = $(this);

                            for (var i in data_arr) {
                                if(mm_validation($this.val()) == data_arr[i*1]) {
                                    $this.prop('selected', true);
                                }
                            }
                        });
                    }
                    continue;
                }
                if (tag == 'input') {
                    var input_type = $container.attr('type').toLowerCase();

                    if (input_type == 'checkbox') {
                        $container.prop('checked', true);
                        continue;
                    }
                    if (input_type == 'text' || input_type == 'number') {
                        $container.val(parsing_data[2]);
                        continue;
                    }
                    if (input_type == 'radio') {
                        $container.each(function () {
                            var $this = $(this);

                            if ($this.val() == parsing_data[2]) {
                                $this.prop('checked', true);
                            }
                        });
                        continue;
                    }
                    if (input_type == 'hidden') {
                        var $mm_single_com__field = $container.closest('.mm-single-com__field'),
                            $mm_single_com__images = $('.mm-single-com__images', $mm_single_com__field), // input with ID
                            ids = parsing_data[2].replace(/\&\#44\;/g, ',').split(',');

                        $mm_single_com__images.html('');

                        for (var i in ids) {
                            var attachment = mm_get_img(ids[i*1]);

                            if (attachment && attachment.url.indexOf('http') + 1) {
                                $mm_single_com__images.append('<div class="mm-single-com__single-image"><i class="mm-single-com__delete-img" onclick="mm_delete_img(this)"></i><div class="mm-single-com__upload-image" style="background-image: url('+attachment.url+'" data-id="'+ ids[i*1] +'" onclick="mm_thumbnail_contain(this)" data-img="'+attachment.url+'"></div></div>');
                            }
                        }
                        $container.val(parsing_data[2]);
                    }
                }
            }
        }
    }

    // Open window Edit Component
    function mm_edit_tab (id, element_name) {
        var $modal = $('.mm-modal--' + id),
            tab_regex = /__(\d+)-(\d+)+?/ig,
            parsing_data,
            iteration_tab_mass = [],
            query_string = '',
            new_tab_id;

        mm_open_card_grid(id);

        while ((parsing_data = tab_regex.exec(element_name)) !== null) {
            // This is necessary to avoid infinite loops with zero-width matches
            if (parsing_data.index === tab_regex.lastIndex) {
                tab_regex.lastIndex++;
            }

            iteration_tab_mass.push({
                'group-id': parsing_data[1],
                'tab-id': parsing_data[2]
            });
        }

        for (var j in iteration_tab_mass) {
            if (iteration_tab_mass[j]['group-id'] && iteration_tab_mass[j]['tab-id']) {
                new_tab_id = iteration_tab_mass[j]['tab-id'];
            }
        }

        for (var i = 0; i < iteration_tab_mass.length; ++i) {
            if ((iteration_tab_mass.length-1) != i) {
                if (iteration_tab_mass[i]['group-id'] && iteration_tab_mass[i]['tab-id']) {
                    query_string += ' .mm-tabs__content.mm-tabs-group--'+iteration_tab_mass[i]['group-id']+'.mm-tabs__content--'+iteration_tab_mass[i]['tab-id']+'';
                }
            } else {
                query_string += ' .mm-tabs--'+iteration_tab_mass[i]['group-id'];
                new_tab_id = iteration_tab_mass[i]['tab-id'];
            }
        }

        if (query_string && new_tab_id > 1) {
            var $mm_tabs = $(query_string, $modal),
                $mm_tabs__header = $mm_tabs.children('.mm-tabs__header'),
                $new_tab = $mm_tabs__header.find('.mm-tabs__tab--new'),
                $tab_first = $mm_tabs__header.find('.mm-tabs__tab--1'),
                $tab = $mm_tabs__header.find('.mm-tabs__tab--' + new_tab_id);

            if (!$tab.length) {
                $new_tab.trigger('click');
            }
            $tab_first.trigger('click');
        }
    }

    // Open CARD GRID Tab
    function mm_open_card_grid (modal_id) {
        var $modal = $('.mm-modal--' + modal_id),
            $mm_tabs = $('.mm-tabs', $modal);

        $mm_tabs.each(function () {
            var $this = $(this),
                group_id = $this.data('group-id'),
                tab_grid = $('.mm-tabs--'+group_id, $modal).data('grid'),
                $new_tab = $('.mm-tabs--'+group_id+'>div>.mm-tabs__tab--new', $modal),
                $tab_first = $('.mm-tabs--grid.mm-tabs--'+group_id+'>div>.mm-tabs__tab--1', $modal);

            if (tab_grid !== void 0 && tab_grid > 1) {
                for (var i=2; i<=tab_grid; i++) {
                    var $tab_i = $('.mm-tabs--'+group_id+'>div>.mm-tabs__tab--'+i, $modal);

                    if (!$tab_i.length) {
                        // console.log(i, tab_grid);
                        $new_tab.trigger('click');
                    }
                }
            }

            $tab_first.trigger('click');
        });
    }

    // Open CARD GRID Tab
    function mm_open_card_grid_by_parent ($parent) {
        var $modal = $parent,
            $mm_tabs = $('.mm-tabs.mm-tabs--grid', $parent);

        $mm_tabs.each(function () {
            var $this = $(this),
                group_id = $this.data('group-id'),
                tab_grid = $('.mm-tabs--'+group_id, $modal).data('grid'),
                $new_tab = $('.mm-tabs--'+group_id+'>div>.mm-tabs__tab--new', $modal),
                $tab_first = $('.mm-tabs--grid.mm-tabs--'+group_id+'>div>.mm-tabs__tab--1', $modal);

            if (tab_grid !== void 0 && tab_grid > 1) {
                for (var i=2; i<=tab_grid; i++) {
                    var $tab_i = $('.mm-tabs--'+group_id+'>div>.mm-tabs__tab--'+i, $modal);

                    if (!$tab_i.length) {
                        $new_tab.trigger('click');
                    }
                }
            }

            $tab_first.trigger('click');
        });
    }

    window.mm_component_edit = mm_component_edit;
    window.mm_edit_tab = mm_edit_tab;
    window.mm_open_component_edit = mm_open_component_edit;
    window.mm_open_card_grid = mm_open_card_grid;
    window.mm_open_card_grid_by_parent = mm_open_card_grid_by_parent;

})($ || window.jQuery);