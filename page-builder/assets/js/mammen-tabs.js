(function($) {

    // Add new Tab
    function mm_new_tab($parent) {
        var $mm_tabs__tab__new = $('.mm-tabs__tab--new', $parent);

        $mm_tabs__tab__new.on('click', function() {
            var $this = $(this),
                component_id = $this.data('component-id'),
                group_id = $this.data('group-id'),
                id_tab = $this.data('max-tab-id') + 1,
                group_tab = [],
                $mm_tabs = $this.closest('.mm-tabs'),
                $mm_register_fields = $('.mm-register_fields--'+component_id),
                $mm_tabs_group = $('.mm-tabs-group--'+group_id, $mm_tabs);

            $this.parents('.mm-tabs__content')
                .map(function() {
                    var $this = $(this);

                    group_tab[$this.data('group-id')] = $this.data('tab-id');
                });
            // console.log(group_tab);
            
            var content = mm_get_tab(component_id, group_id, id_tab, group_tab);
            // console.log(content.array_of_fields);

            if (content.html) {
                if (content.array_of_fields) {
                    $mm_register_fields.data('tmp', $mm_register_fields.val());
                    // console.log(JSON.stringify(content.array_of_fields));
                    $mm_register_fields.val(JSON.stringify(content.array_of_fields));
                }

                $mm_tabs_group.removeClass('mm-tabs__tab--current').removeClass('mm-tabs__content--current');

                mm_add_head_tab(this, id_tab, group_id);
                mm_add_body_tab(this, id_tab, group_id, content.html);
                mm_change_remove_button($mm_tabs, id_tab, group_id);

                $this.data('max-tab-id', id_tab);
                mm_clear_mm_tabs($mm_tabs, id_tab);

                var $mm_tabs__content = $('.mm-tabs__content.mm-tabs-group--'+group_id+'.mm-tabs__content--'+id_tab, $mm_tabs);
                mm_init_tinymce_editors($mm_tabs__content);
                mm_error_clear($mm_tabs__content);
                mm_image_upload_universal($mm_tabs__content);
                mm_file_upload_universal($mm_tabs__content);
                mm_new_tab($mm_tabs__content);

                mm_open_card_grid_by_parent($('.mm-tabs__content.mm-tabs-group--'+group_id+'.mm-tabs__content--'+id_tab+''), $mm_tabs);
            }
            return false;
        });
    }

    // Enable wysiwyg by Tab label click
    function mm_init_tinymce_editors($container) {
        var $editors = $('.mm-single-com__field--wysiwyg textarea', $container),
            $first_elem = $('input', $container).first();

        $editors.each(function () {
            var $this = $(this),
                this_id = $this.attr('id'),
                $text_mode = $('#'+this_id+'-html');

            My_New_Global_Settings = tinyMCEPreInit.mceInit.content;
            tinymce.init(My_New_Global_Settings);
            tinyMCE.execCommand('mceAddEditor', false, this_id);
            quicktags({id : this_id});

            setTimeout(function () {
                $text_mode.trigger('click');
                $first_elem.trigger('focus');
            }, 500);
        });
    }

    // Tab label click
    function mm_tab_click(elem, group_id) {
        var $this = $(elem),
            tab_id = $this.data('tab-id'),
            $mm_group = $this.closest('.mm-group--repeating'),
            $mm_tabs = $this.closest('.mm-tabs'),
            $tabs_tab__ooto = $('.mm-tabs__tab--ooto.mm-tabs-group--'+group_id, $mm_group),
            $tabs_body__ooto = $('.mm-tabs__content--ooto.mm-tabs-group--'+group_id, $mm_group),
            $tab_body = $('.mm-tabs-group--'+group_id+'.mm-tabs__content--'+tab_id, $mm_group),
            $mm_tabs_group = $('.mm-tabs-group--'+group_id, $mm_group);

        $tabs_tab__ooto.removeClass('mm-tabs__tab--error');
        $tabs_body__ooto.addClass('mm-tabs__content--not-current-ooto');

        $mm_tabs_group.removeClass('mm-tabs__tab--current').removeClass('mm-tabs__content--current');

        $this.addClass('mm-tabs__tab--current');
        $tab_body.addClass('mm-tabs__content--current');
        $tab_body.removeClass('mm-tabs__content--not-current-ooto');

        $mm_tabs.data('current-tab', tab_id);

        mm_change_remove_button($mm_group, tab_id, group_id);

        if ($this.hasClass('mm-tabs__tab--ooto')) {
            mm_tab_trigger($this, true, true);
        }
    }

    // Enable wysiwyg by Tab label click
    function mm_change_remove_button($mm_tabs, id_tab, group_id) {
        var $delete_button = $('.mm-tabs__remove-tab--'+group_id, $mm_tabs),
            $delete_button_label = $('.mm-tabs__tab-id', $delete_button);

        $delete_button.data('tab-id', id_tab);
        $delete_button_label.html(id_tab);
    }

    function mm_add_head_tab(elem, id_tab, group_id) {
        var $this = $(elem);

        $this.before('<div class="mm-tabs__tab mm-tabs__tab--'+id_tab+' mm-tabs-group--'+group_id+' mm-tabs__tab--current" data-tab-id="'+id_tab+'" onclick="mm_tab_click(this, '+group_id+')">'+id_tab+'</div>');
    }

    // Add Tab content
    function mm_add_body_tab(elem, id_tab, group_id, content) {
        var $this = $(elem),
            $mm_tabs = $this.closest('.mm-tabs'),
            $mm_tabs__body = $('.mm-tabs__body--'+group_id, $mm_tabs);

        $mm_tabs__body.append('<div class="mm-tabs__content mm-tabs-group--'+group_id+' mm-tabs__content--'+id_tab+' mm-tabs__content--current" data-tab-id="'+id_tab+'" data-group-id="'+group_id+'">'+content+'</div>');
    }

    // Ajax request
    function mm_get_tab(component_id, group_id, id_tab, group_tab) {
        var $mm_register_fields = $('.mm-register_fields--'+component_id),
            data_sent = {
                'action': 'mammen_page_builder',
                'query': 'tab',
                'register_fields': $mm_register_fields.val(),
                'component_id': component_id,
                'group_tab': group_tab,
                'group_id': group_id,
                'id_tab': id_tab
            };

        window.tab = [];

        $.ajax({
            url: mm_ajaxurl.url,
            data: data_sent,
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function(data){
                window.tab = data;
            },
            error: function (xhr, ajaxOptions, thrownError) { // в случае неудачного завершения запроса к серверу
                console.error('mm_get_tab-@11: '+xhr.status); // покажем ответ сервера
                console.error('mm_get_tab-@12: '+thrownError); // и текст ошибки
            }
        });
        return window.tab;
    }

    window.mm_new_tab = mm_new_tab;
    window.mm_get_tab = mm_get_tab;
    window.mm_tab_click = mm_tab_click;
    window.mm_change_remove_button = mm_change_remove_button;

})($ || window.jQuery);