(function($) {

    function mm_file_upload_universal($parent) {
        var $mm__upload_file_button = $('.mm__upload_file_button', $parent);

        $mm__upload_file_button.on('click', function() {
            var $this = $(this),
                $mm_single_com__field = $this.closest('.mm-single-com__field'),
                element_name = $('.mm-single-com__field-label', $mm_single_com__field).html().replace(/<[^>]+>.*<\/[^>]+>/g,''),
                $mm_single_com__file_upload = $('.mm-single-com__file-upload', $mm_single_com__field), // input with ID
                accepted_mime_types = $mm_single_com__file_upload.data('mime'), // accepted mime types. Default ''
                custom_uploader = null;

            $mm_single_com__field.removeClass('error--empty-field');

            if (!accepted_mime_types) {
                accepted_mime_types = '';
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose File for ' + element_name,
                button: {
                    text: 'Choose File'
                },
                library : {
                    type: accepted_mime_types
                },
                multiple: false
            });
            custom_uploader.on('select', function () {
                var selection = custom_uploader.state().get('selection');

                selection.map(function (attachment) {
                    attachment = attachment.toJSON();

                    $mm_single_com__file_upload.val(attachment.url);
                });
            });
            custom_uploader.open();
            return false;
        });
    }

    window.mm_file_upload_universal = mm_file_upload_universal;

})($ || window.jQuery);