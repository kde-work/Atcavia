(function($) {

    // Added components in Page Builder from @var mammen
    function mm_add_components () {
        var $page_builder__component_list = $('.page-builder__component-list'),
            i = 0;

        for (var key in window.mammen.elements) {
            var component = window.mammen.elements[key*1],
                thumb = $('.mm-modal--new-component .mm-component--'+component.slug+' .mm-component__thumb').data('img');

            if (component) {
                // if (key == 0) {
                //     $page_builder__component_list.append(
                //         '<div class="ui-state-highlight"></div>'
                //     );
                // }
                $page_builder__component_list.append(
                    '<div class="mm-line-container mm-line-container--' + component.id
                    +' mm-line-container--' + key
                    +'" data-id="' + component.id
                    +'" data-cid="' + key
                    + '">'
                    // +'<div class="mm-component-line__droppable mm-component-line__droppable--top"></div>'
                    +'<div class="mm-component-line mm-component-line--' + component.id
                    +' mm-component-line--' + component.slug
                    +'" data-id="' + component.id
                    +'" data-cid="' + key
                    +'"><span class="mm-component-line__name">'
                    + component.name.replace(/\</g, '&lt').replace(/\>/g, '&gt')
                    +'</span><div class="mm-component-line__controls"><div class="mm-icon mm-icon--big mm-icon__setting" data-id="'+ component.id
                    +'" data-cid="'+ key
                    +'" data-slug="'+ component.slug
                    +'"></div>'
                    +'<div class="mm-icon mm-icon--big mm-icon__thumb mm__open-thumb" data-img="'+thumb+'"></div>'
                    +'<div class="mm-icon mm-icon__up" data-id="'+ component.id
                    +'" data-cid="'+ key
                    +'"></div><div class="mm-icon mm-icon__down" data-id="'+ component.id
                    +'" data-cid="'+ key
                    +'"></div></div></div>'
                    // +'<div class="mm-component-line__droppable mm-component-line__droppable--bot"></div>'
                    +'</div>'
                );
            }
        }
    }

    // Button Save
    function mm_modal__save () {
        var $mm_modal__save = $('.mm-modal__save'); // modal forms

        $mm_modal__save.on('click', function () {
            var $this = $(this),
                component_id = $this.data('id'),
                $modal = $('.mm-modal--' + component_id),
                $component_form = $('.mm-single-com--' + component_id),
                $switch_html = $('.switch-html'); // Text mode buttons

            $switch_html.trigger('click'); // switch WYSIWYG editors to the Text mode

            if (!mm_required_check($modal)) {
                mm_add_new_component($component_form, component_id);
            }
        });
    }

    function mm_validation (str) {
        if (!str) {
            return '';
        }
        if (Array.isArray(str)) {
            for (var key in str) {
                str[key*1] = mm_validation(str[key*1]);
            }
            return str;
        }
        return str.replace(/\"/g, '&#34;')
                  .replace(/\,/g, '&#44;')
                  .replace(/\[/g, '&#91;')
                  .replace(/\]/g, '&#93;')
                  .replace(/\'/g, '&#39;');
    }

    // Add new component (shortcode + window.mammen)
    function mm_add_new_component ($mm_single_com, component_id) {
        var $this = $mm_single_com,
            $modal = $('.mm-modal--' + component_id);

        // console.log($('.mm-register_fields', $modal).val());

        var register_fields = JSON.parse($('.mm-register_fields', $modal).val()),
            component_name = $this.data('name'),
            component_slug = $this.data('slug'),
            shortcode = '[mammen component="'+ component_name +'"',
            $switch_html = $('.switch-html'), // Text mode buttons
            $switch_tmce = $('.switch-tmce'); // Visual mode buttons

        $switch_html.trigger('click'); // switch WYSIWYG editors to the Text mode
        // $switch_tmce.trigger('click'); // switch WYSIWYG editors to the Visual mode

        register_fields.forEach(function (entry) {
            var $field = $(entry.selector, $this),
                $ooto_par = $field.parents('.mm-tabs__content--not-current-ooto'),
                field_value = $field.val();

            if (!$ooto_par.length && $field.length) {
                field_value = field_value.replace(/\n<br>|\r<br>|\r|\n/g, '<br>');
                field_value = mm_validation(field_value);
                if (field_value !== void 0 && field_value !== '') {
                    shortcode += ' ' + entry.slug + '="' + field_value + '"';
                }
            }
        });
        shortcode += ']';

        // Filling by preset data from WYSIWYG
        var data_component = {
            'type': 'mammen',
            'shortcode': shortcode,
            'name': component_name,
            'slug': component_slug,
            'id': component_id
        };

        // new component
        if ($modal.data('edit') === -1) {
            window.mammen.elements.push(data_component);
        } else {
            window.mammen.elements[$modal.data('edit')] = data_component;
        }

        $modal.data('edit', -1);

        // filling Page Builder box
        mm_page_builder();

        // filling WYSIWYG
        mm_contain_WYSIWYG();

        // close current window
        mm_close_window();
    }

    // Button Add new blank component
    function mm_open_blank_component() {
        var $open_button = $('[data-open]');

        $open_button.on('click', function () {
            var $this = $(this),
                modal_id = $this.data('open');

            mm_open_window(modal_id, true);
        });
    }

    // Close modal
    function mm_close_modal() {
        var $close_modal = $('.close_modal');

        $close_modal.on('click', function () {
            mm_close_window();
        });
    }

    // Open some window
    function mm_open_window(modal_id, clear) {
        var $body = $('body'),
            $opened_window = $('.mm-modal--' + modal_id),
            $fields_required = $('.mm-single-com__field--required'),
            $switch_html = $('.switch-html', $opened_window);

        mm_close_window();
        $body.addClass('open').addClass('open--' + modal_id);
        $body.data('current-modal', modal_id);

        $switch_html.trigger('click'); // switch WYSIWYG editors to the Text mode
        if (clear) {
            mm_clear_from($opened_window);
        }

        mm_open_card_grid(modal_id);

        mm_adaptive_window($opened_window);
        $fields_required.removeClass('error--empty-field');
    }

    // Change max id of tab
    function mm_clear_mm_tabs($mm_tabs, id) {
        if ($mm_tabs.length) {
            $mm_tabs.map(function () {
                var $this = $(this),
                    mm_tabs__class = $this.attr('class');

                $this.attr('class', mm_tabs__class.replace(/(mm\-tabs\_\_max\-\-\d)/g, 'mm-tabs__max--' + id));
            });
        }
    }

    // Clear form. Set default value
    function mm_clear_from($window) {
        var $inputs = $('[type="text"],[type="number"],.mm-single-com__media-upload,textarea', $window),
            $radio = $('[type="radio"], input[type="checkbox"]', $window),
            $images = $('.mm-single-com__images', $window),
            $select = $('select', $window),
            $mm_tabs = $('.mm-tabs', $window),
            $mm_tabs__tab = $('.mm-tabs__tab', $window),
            $tabs = $('.mm-tabs__tab:not(".mm-tabs__tab--1"):not(".mm-tabs__tab--new"):not(".mm-tabs__tab--ooto"), .mm-tabs__content:not(".mm-tabs__content--1"):not(".mm-tabs__content--ooto")', $window),
            $tabs_ooto = $('.mm-tabs__content--ooto, .mm-tabs__content--ooto', $window),
            $tabs_h_1 = $('.mm-tabs__tab--1', $window),
            $tabs_h_new = $('.mm-tabs__tab--new', $window),
            $tabs__content_1 = $('.mm-tabs__content--1', $window);

        mm_clear_mm_tabs($mm_tabs, 1);
        $mm_tabs__tab.removeClass('mm-tabs__tab--error');
        $tabs.remove();
        $tabs_ooto.removeClass('mm-tabs__tab--current').removeClass('mm-tabs__content--current');
        $tabs_h_1.addClass('mm-tabs__tab--current');
        $tabs__content_1.addClass('mm-tabs__content--current');
        $tabs_h_new.data('max-tab-id', 1);

        $images.html('<div class="mm-single-com__single-image"><div class="mm-single-com__upload-image" style="background-image: url('+$images.data('src')+'"></div></div>');

        $select.val('default');
        if ($select.val() != 'default') {
            $select.val($select.find(':first-child').val()); // Set default by first element
        }
        $inputs.val('');
        $radio.prop('checked', false);
    }

    // Close current window
    function mm_close_window() {
        var $body = $('body'),
            $modal = $('.mm-modal--now-editing'),
            component_id = $modal.data('id'),
            $mm_register_fields = $('.mm-register_fields--'+component_id),
            current_modal = $body.data('current-modal'),
            $current_modal = $('.mm-modal--' + current_modal),
            $switch_html = $('.switch-html', $current_modal);

        $body.removeClass('open').removeClass('open--' + current_modal);
        $modal.removeClass('mm-modal--now-editing');
        $modal.data('edit', -1);

        if ($mm_register_fields.data('tmp')) {
            $mm_register_fields.val($mm_register_fields.data('tmp'));
        }
        $switch_html.trigger('click'); // switch WYSIWYG editors to the Text mode
    }


    var $window = $(window);

    $window.resize(function() {
        mm_adaptive_window_resize(false);
    });

    // Adaptive modal window
    function mm_adaptive_window_resize(modal_id) {
        var $body = $('body'),
            current_modal_id = $body.data('current-modal'),
            $current_modal = $('.mm-modal--' + current_modal_id),
            $modal_by_param = $('.mm-modal--' + modal_id); // new modal

        if (current_modal_id === void 0 && modal_id === false) {
            return;
        }

        if (modal_id !== false) {
            $current_modal = $modal_by_param;
        }

        mm_adaptive_window($current_modal);
    }

    function mm_adaptive_window ($modal) {
        var mm_modal__header_height = $('.mm-modal__header', $modal).height(),
            $mm_modal__content = $('.mm-modal__content', $modal),
            $mm_modal__body = $('.mm-modal__body', $modal),
            mm_modal__footer_height = $('.mm-modal__footer', $modal).height(),
            $mm_modal__section_content = $('.mm-single-com__section--content', $modal),
            mm_modal__settings_height = $('.mm-single-com__section--settings', $mm_modal__body).height(),
            windowHeight = window.innerHeight,
            windowWidth = window.innerWidth,
            modal__body_height = windowHeight*0.9 - mm_modal__header_height - mm_modal__footer_height;

        $mm_modal__body.css({
            "height": modal__body_height + "px"
        });

        if (modal__body_height > (mm_modal__settings_height + $mm_modal__section_content.height())) {
            $mm_modal__section_content.css({
                "height": modal__body_height - mm_modal__settings_height + "px"
            });
        } else {
            $mm_modal__section_content.css({
                "height": "auto"
            });
        }

        $mm_modal__content.css({
            "margin": (windowHeight*0.1)/2 + "px 0 0 " + (windowWidth*0.2)/2 +"px",
            "width": windowWidth*0.8 + "px"
        });
    }

    window.mm_clear_mm_tabs = mm_clear_mm_tabs;
    window.mm_modal__save = mm_modal__save;
    window.mm_close_modal = mm_close_modal;
    window.mm_open_blank_component = mm_open_blank_component;
    window.mm_validation = mm_validation;
    window.mm_close_window = mm_close_window;
    window.mm_clear_from = mm_clear_from;
    window.mm_add_components = mm_add_components;
    window.mm_open_window = mm_open_window;
    window.mm_adaptive_window_resize = mm_adaptive_window_resize;
    window.mm_adaptive_window = mm_adaptive_window;
    window.mm_add_new_component = mm_add_new_component;

})($ || window.jQuery);
