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
                    "adaptiveHeight": true
                });
                $page_content.on('afterChange', function(){atc_set_height_sliders_fix(500)});
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
                $body = $('body');

            $body.removeClass('theme--dark').removeClass('theme--light');
            $body.addClass('theme--'+$this.data('theme'));
            $page_content.slick('slickGoTo', this_id);

            $btn_active.removeClass('page-mobile-pagination__item--active');
            $this.addClass('page-mobile-pagination__item--active');

            var $slick_list = $('.page-content.slick-slider > .slick-list');
            $slick_list.data('height', 0);
        })
    });

}($ || window.jQuery));
// end of file