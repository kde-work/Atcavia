(function ($) {
    if (!$) {
        console.error('Объекты jQuery и $ отсутствуют');
        return;
    }

    // Fix Mobile width of slides of Main Slider
    $(window).on('resize', function () {
        if (is_mobile()) {
            var $slick_slide = $('.layout.slider .slick-slide, .page-content > .slick-list > .slick-track > .slick-slide, .reach-news__items .slick-slide'),
                $slick_track = $('.layout.slider .slick-list > .slick-track, .page-content > .slick-list > .slick-track, .reach-news__items .slick-list > .slick-track'),
                $navigation_btn_active = $('.page-mobile-pagination__item--active'),
                $body = $('body');

            if ($slick_slide.length) {
                $slick_slide.width($body.width());
                $slick_track.css({
                    'transform': 'translate3d(-'+$body.width()+'px, 0px, 0px)'
                });
                $navigation_btn_active.trigger('click');
            }
        }
    });

    $(function () {
        var $page_content = $('.home .page-content');

        if ($page_content.length) {
            $page_content.data('mobile', is_mobile());
        }
    });
    $(window).on('resize', function () {
        var $page_content = $('.home .page-content');

        if ($page_content.length) {
            console.log($page_content.data('mobile'), is_mobile(), $page_content.data('mobile') !== is_mobile());
            if ($page_content.data('mobile') !== is_mobile()) {
                setTimeout(function () {
                    window.location.reload(false);
                }, 1);
            }
        }
    });

    function is_mobile() {
        return (jQuery(window).outerWidth() <= mobile_width);
    }
    window.is_mobile = is_mobile;
}($ || window.jQuery));
// end of file