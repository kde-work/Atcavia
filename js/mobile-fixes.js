(function ($) {
    if (!$) {
        console.error('Объекты jQuery и $ отсутствуют');
        return;
    }


    // Fix Height of slides of Mobile Page Slider
    $(function () {
        atc_set_height_sliders_fix(2000);
    });
    function atc_set_height_sliders_fix(delay) {
        var $slick_list = $('.theme--light .page-content.slick-slider > .slick-list'),
            $slick_slide = $('.layout.slider .slick-slide');

        if (is_mobile() && $slick_list.data('height') !== 1) {
            setTimeout(function () {
                var $slide_slick = $slick_list.children('.slick-track').children('.slick-active').children('div').children('.layout').find('.mobile__set-height'),
                    height_list = $slick_list.height();

                if ($slide_slick.length) {
                    var f = height_list-(height_list - $slide_slick.height()),
                        wiH = window.innerHeight;

                    if (f < wiH) {
                        // $slick_list.css({
                        //     'height' : '100vh'
                        // });
                        // $slick_slide.css({
                        //     'height' : '100vh'
                        // });
                        $slick_list.height(wiH);
                        $slick_slide.height(wiH);
                    } else {
                        $slick_list.height(f);
                    }
                    $slick_list.data('height', 1);
                }
            }, delay);
        }
    }
    window.atc_set_height_sliders_fix = atc_set_height_sliders_fix;

    function atc_set_height_sliders_cont($elem, delay) {
        if (is_mobile() && $elem.length) {
            var max_height = $elem.first().outerHeight()*1;

            setTimeout(function () {
                $elem.each(function () {
                    var $this = $(this),
                        this_height = $this.outerHeight();

                    // console.log(max_height, this_height);
                    if (max_height < this_height) {
                        max_height = this_height;
                    }
                });
                $elem.outerHeight(max_height);
            }, delay);
        }
    }
    window.atc_set_height_sliders_cont = atc_set_height_sliders_cont;

    // Fix Mobile Height of Rich News
    $(function () {
        atc_set_height_rich_news(100);
    });
    function atc_set_height_rich_news(delay) {
        var $reach_news__item = $('.reach-news__item');

        if (is_mobile() && $reach_news__item.length) {
            setTimeout(function () {
                var max_height = 0;

                $reach_news__item.each(function () {
                    var $this = $(this);

                    if ($this.outerHeight() > max_height) {
                        max_height = $this.outerHeight();
                    }
                });
                if (max_height < $(window).height()) {
                    max_height = $(window).height();
                }
                $reach_news__item.outerHeight(max_height);
            }, delay);
        }
    }
    $(window).on('resize', function () {
        atc_set_height_rich_news(1);
    });
    window.atc_set_height_rich_news = atc_set_height_rich_news;

}($ || window.jQuery));
// end of file