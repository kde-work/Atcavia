(function($) {

    function mm_image_upload_universal($parent) {
        var $mm__upload_image_button = $('.mm__upload_image_button', $parent);

        $mm__upload_image_button.on('click', function() {
            var $this = $(this),
                $mm_single_com__field = $this.closest('.mm-single-com__field'),
                item_type = $mm_single_com__field.data('type');

            if (item_type == 'media upload') {
                mm_uploader($mm_single_com__field, false);
            } else if (item_type == 'multiple media upload') {
                mm_uploader($mm_single_com__field, true);
            }
            return false;
        });
    }

    function mm_uploader($mm_single_com__field, multiple) {
        var element_name = $('.mm-single-com__field-label', $mm_single_com__field).html().replace(/<[^>]+>.*<\/[^>]+>/g,''),
            $mm_single_com__images = $('.mm-single-com__images', $mm_single_com__field), // image preview
            $mm_single_com__media_upload = $('.mm-single-com__media-upload', $mm_single_com__field), // input with ID
            wp_media_post_id = wp.media.model.settings.post.id, // Store the old id
            custom_uploader = null,
            set_to_post_id = $mm_single_com__media_upload.val();

        wp.media.model.settings.post.id = set_to_post_id;

        //TODO select pictures in wp.media if they were before
        // If the media frame already exists, reopen it.
        if ( custom_uploader ) {
            // Set the post ID to what we want
            custom_uploader.uploader.uploader.param( 'post_id', set_to_post_id );
            // Open frame
            custom_uploader.open();
            return;
        } else {
            // Set the wp.media post id so the uploader grabs the ID we want when initialised
            wp.media.model.settings.post.id = set_to_post_id;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image for ' + element_name,
            button: {
                text: 'Choose Image'
            },
            library : {
                type: 'image'
            },
            multiple: multiple
        });

        custom_uploader.on('select', function () {
            var selection = custom_uploader.state().get('selection'),
                ids = '';

            $mm_single_com__images.html('');

            selection.map(function (attachment) {
                attachment = attachment.toJSON();
                var image = mm_get_img(attachment.id);

                ids += attachment.id + ',';
                $mm_single_com__images.append('<div class="mm-single-com__single-image"><i class="mm-single-com__delete-img" onclick="mm_delete_img(this)"></i><div class="mm-single-com__upload-image" style="background-image: url('+image.url+'" data-id="'+attachment.id+'" onclick="mm_thumbnail_contain(this)" data-img="'+image.url+'"></div></div>');
            });

            $mm_single_com__media_upload.val(ids.slice(0, -1));
            console.log(wp.media.model.settings.post.id);

            wp.media.model.settings.post.id = wp_media_post_id;
        });
        custom_uploader.open();
    }

    function mm_delete_img(el) {
        var $this = $(el),
            $img_container = $this.closest('.mm-single-com__single-image'),
            $img = $('.mm-single-com__upload-image', $img_container),
            image_id = $img.data('id'),
            $mm_single_com__field = $this.closest('.mm-single-com__field'),
            $mm_single_com__media_upload = $('.mm-single-com__media-upload', $mm_single_com__field), // input with ID
            ids = $mm_single_com__media_upload.val(),
            $mm_single_com__images = $('.mm-single-com__images', $mm_single_com__field);

        ids = ids.replace(image_id, '').replace(/\,{2,}/g, ',').replace(/[&#44;]{2,}/g, '&#44;').replace(/^&#44;|&#44;$/g, '').replace(/^,|,$/g, '');
        $mm_single_com__media_upload.val(ids);

        $img_container.remove();

        if (!$mm_single_com__images.children('.mm-single-com__single-image').length) {
            $mm_single_com__images.html('');
            $mm_single_com__images.append('<div class="mm-single-com__single-image"><div class="mm-single-com__upload-image" style="background-image: url('+$mm_single_com__images.data('src')+'"></div></div>');
        }

        return false;
    }

    function mm_get_img(id) {
        var data_sent = {
                'action': 'mammen_page_builder',
                'query': 'img_url_by_ID',
                'id': id,
                'size': 'large'
            };
        
        window.img = [];

        $.ajax({
            url: mm_ajaxurl.url,
            data: data_sent,
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            async: false,
            success: function(data){
                window.img = data;
            },
            error: function (xhr, ajaxOptions, thrownError) { // в случае неудачного завершения запроса к серверу
                console.error('gag-rating-@11: '+xhr.status); // покажем ответ сервера
                console.error('gag-rating-@12: '+thrownError); // и текст ошибки
            }
        });
        return window.img;
    }

    window.mm_image_upload_universal = mm_image_upload_universal;
    window.mm_uploader = mm_uploader;
    window.mm_delete_img = mm_delete_img;
    window.mm_get_img = mm_get_img;

})($ || window.jQuery);