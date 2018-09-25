(function ($) {
    if (!$) {
        console.error('Объекты jQuery и $ отсутствуют');
        return;
    }

    // Prepare to Slick Page
    $(function () {
        var $elems = $('.home .page-content > *'),
            $page_mobile_pagination__items = $('.page-mobile-pagination__items'),
            theme = 0,
            $body = $('body');

        if ($page_mobile_pagination__items.length) {
            $body.addClass('mmp-slider');
        }

        $elems.each(function (index) {
            var $this = $(this),
                this_theme = $this.data('theme'),
                mobile_pagination = $this.attr('data-mobile-pagination'),
                addition = '';

            $this.data('index', index);

            if (!theme) {
                $body.addClass('theme--'+this_theme);
                theme = 1;
                addition = 'page-mobile-pagination__item--active';
            }

            if (mobile_pagination) {
                $page_mobile_pagination__items.append('<div class="page-mobile-pagination__item '+addition+'" data-id="'+index+'" data-theme="'+this_theme+'"><span>'+mobile_pagination+'</span></div>');
            }
        });
    });

    // Slick Page for mobile (slider navigation)
    function atc_mobile_slick_page() {
        var $page_content = $('.home .page-content');

        if ($page_content.length) {
            if (!$page_content.hasClass('.slick-initialized') && is_mobile()) {
                $page_content.slick({
                    "prevArrow": false,
                    "nextArrow": false,
                    "autoplay": 0,
                    "draggable": false,
                    "speed": 800,
                    "swipe": false,
                    "respondTo": 'slider',
                    "adaptiveHeight": true
                });
                $page_content.on('afterChange', function(){
                    atc_set_height_sliders_fix(500);

                    setTimeout(function () {
                        var $header = $('.layout.header');
                        $header.css({
                            'z-index' : $header.css('z-index')*1 + 1
                        });
                    }, 1500);
                });

                atc_set_height_sliders_cont($('.slide-slick__cont'), 30); // setup height for content slides
            }
        }
    }
    $(function () {
        atc_mobile_slick_page();
    });
    $(window).on('resize', function () {
        atc_mobile_slick_page();
    });
    window.atc_mobile_slick_page = atc_mobile_slick_page;

    // Navigation on Slick Mobile Page / BTN CLICK
    $(function () {
        var $page_mobile_pagination__items = $('.page-mobile-pagination__items');

        $page_mobile_pagination__items.on('click', '.page-mobile-pagination__item', function () {
            var $this = $(this),
                this_id = $this.data('id'),
                $page_content = $('.home .page-content'),
                $btn_active = $('.page-mobile-pagination__item--active'),
                $body = $('body'),
                $slider_first = $('.layout.slider > .slider-slick');

            $body.removeClass('theme--dark').removeClass('theme--light');
            $body.addClass('theme--'+$this.data('theme'));
            $page_content.slick('slickGoTo', this_id);

            $btn_active.removeClass('page-mobile-pagination__item--active');
            $this.addClass('page-mobile-pagination__item--active');

            var $slick_list = $('.page-content.slick-slider > .slick-list');
            $slick_list.data('height', 0);

            // fix for first tab
            atc_set_height_rich_news(100);

            if (this_id !== 0) {
                $slider_first.slick('slickPause');
            } else {
                $slider_first.slick('slickPlay');
                $slider_first.slick('slickNext');
            }
        })
    });

}($ || window.jQuery));
// end of file