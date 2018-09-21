jQuery(function($){
	$(window).scroll(function(){
		var $text_news__pagination = $('.text-news__pagination');

		if ($text_news__pagination.length) {
            var $body = $('body'),
                scrollTop = $(document).scrollTop(),
                count = $text_news__pagination.data('count'),
                current = $text_news__pagination.data('current'),
				data = {
					'action': 'atc_loadmore',
					'count_of_pagination': count,
					'page': current
				};

            if( scrollTop > ($text_news__pagination.scrollTop() - $(document).height()) && !$body.hasClass('loading')){
                $.ajax({
                    url: ajaxurl.url,
                    data: data,
                    type: 'POST',
                    beforeSend: function( xhr){
                        $body.addClass('loading');
                    },
                    success: function(data){
                        if( data ) {
                            $text_news__pagination.before(data);
                            $body.removeClass('loading');
                            $text_news__pagination.data('current', current*1 + count*1);
                        }
                    }
                });
            }
		}
	});
});