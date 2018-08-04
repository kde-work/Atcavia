(function($) {

    // Checks whether required fields are filled
    function mm_required_check($modal) {
        var $this = $modal,
            $mm_single_com__field = $('div:not(.mm-tabs__content--not-current-ooto) > .mm-single-com__field--required', $this), // contain of fields
            $mm_tabs__tab__error = $('.mm-tabs__tab--error'),
            $error__empty_field = $('.error--empty-field'),
            error = false;

        $mm_tabs__tab__error.removeClass('mm-tabs__tab--error');
        $error__empty_field.removeClass('error--empty-field');

        $mm_single_com__field.each(function () {
            var $this = $(this),
                type = $this.data('type'); // type of fields (text, radio, etc.)

            if (type == 'graphic radio') {
                type = 'radio';
            }

            if (type == 'text' || type == 'number' || type == 'textarea' || type == 'wysiwyg' || type == 'file upload') {
                if (mm_check_text($this)) {
                    error = true;
                }
            }
            if (type == 'radio' || type == 'checkbox' || type == 'graphic radio') {
                if (mm_check_radio($this, type)) {
                    error = true;
                }
            }
            if (type == 'select') {
                if (mm_check_select($this, type)) {
                    error = true;
                }
            }
            if (type == 'multiple select') {
                if (mm_check_multiple_select($this, type)) {
                    error = true;
                }
            }
            if (type == 'media upload' || type == 'multiple media upload') {
                if (mm_check_media_upload($this, type)) {
                    error = true;
                }
            }
        });

        // true - if there are empty fields
        return error;
    }

    function mm_tab_trigger($elem, error, clean) {
        if (error) {
            $elem.parents('.mm-tabs__content').map(function() {
                var $this = $(this),
                    tab_id = $this.data('tab-id'),
                    $mm_tabs = $this.parents('.mm-tabs').first(),
                    $mm_tabs__tab = $mm_tabs.find('.mm-tabs__tab--'+tab_id).first();

                if (clean) {
                    $mm_tabs__tab.removeClass('mm-tabs__tab--error');
                } else {
                    $mm_tabs__tab.addClass('mm-tabs__tab--error');
                }
            });
        }
    }

    function mm_check_media_upload(container) {
        var $input = $('.mm-single-com__media-upload', container);

        if (!$input.val()) {
            container.addClass('error--empty-field');
            mm_tab_trigger($input, true, false);
            return true;
        } else {
            container.removeClass('error--empty-field');
        }
        return false;
    }

    function mm_check_multiple_select(container) {
        var $select = $('select[multiple]', container),
            $option = $('option:selected', $select);

        if (!$option.length) {
            container.addClass('error--empty-field');
            mm_tab_trigger($option, true, false);
            return true;
        } else {
            container.removeClass('error--empty-field');
        }
        return false;
    }

    function mm_check_select(container) {
        var $select = $('select', container);

        if ($select.val() == 'default' || !$select.val()) {
            container.addClass('error--empty-field');
            mm_tab_trigger($select, true, false);
            return true;
        } else {
            container.removeClass('error--empty-field');
        }
        return false;
    }

    function mm_check_text(container) {
        var $input = $('input[type="text"], input[type="number"], textarea', container);

        if (!$input.val()) {
            container.addClass('error--empty-field');
            mm_tab_trigger($input, true, false);
            return true;
        } else {
            container.removeClass('error--empty-field');
        }
        return false;
    }

    function mm_check_radio(container, type) {
        var $input = $('[type="'+type+'"]', container),
            is_empty = true;

        $input.each(function () {
            var $this = $(this);

            if ($this.prop('checked')) {
                is_empty = false;
            }
        });
        if (is_empty) {
            container.addClass('error--empty-field');
        } else {
            container.removeClass('error--empty-field');
        }

        mm_tab_trigger($input, is_empty, false);
        return is_empty;
    }

    function mm_error_clear($parent) {
        var $mm_modal;

        if ($parent !== false) {
            $mm_modal = $parent;
        } else {
            $mm_modal = $('.mm-modal');
        }
        var $click = $('input[type="text"], input[type="number"], textarea, select, .mm__upload_image_button', $mm_modal),
            $focus = $('input[type="radio"], input[type="checkbox"]', $mm_modal);

        $click.on('click', mm_delete_error_classes);
        $focus.on('focus', mm_delete_error_classes);
    }

    function mm_delete_error_classes() {
        var $this = $(this),
            $mm_single_com__field = $this.closest('.mm-single-com__field');

        if ($this.hasClass('error--empty-field') || $mm_single_com__field.hasClass('error--empty-field')) {
            mm_tab_trigger($this, true, true);
        }
        $this.removeClass('error--empty-field');
        $mm_single_com__field.removeClass('error--empty-field');
    }

    window.mm_required_check = mm_required_check;
    window.mm_tab_trigger = mm_tab_trigger;
    window.mm_error_clear = mm_error_clear;
    window.mm_check_radio = mm_check_radio;
    window.mm_delete_error_classes = mm_delete_error_classes;

})($ || window.jQuery);
