(function ($) {
    if (!$) {
        console.error('Объекты jQuery и $ отсутствуют');
        return;
    }
    window.mobile_width = 1020;

    // Open/Close menu
    $(function () {
        var $hamburger = $('.hamburger');

        $hamburger.on('click', function () {
            var $this = $(this),
                this_id = $this.data('id'),
                $top_menu = $('.top-menu'),
                $body = $('body');

            if (this_id === 'open') {
                $top_menu.addClass('top-menu--open');
                $body.addClass('no-scroll');
            } else {
                $top_menu.removeClass('top-menu--open');
                $body.removeClass('no-scroll');
            }
        });
    });

    // Remove bad <p>
    $(function () {
        var $p = $('body > p, .page-content > p');

        $p.remove();
    });

    // Left Right buttons on Reach News
    $(function () {
        var $reach_news = $('.reach-news');

        $reach_news.on('click', '.reach-box__arrow', function () {
            var $this = $(this),
                this_id = $this.data('id'),
                $slick_slider = $this.closest('.slick-slider'),
                $btn_target = $('.slider__'+this_id, $slick_slider);

            $btn_target.trigger('click');
        });
    });

    // Btn Title linked
    $(function () {
        var $btn__linked = $('.btn--linked'),
            linked__id = $btn__linked.data('linked'),
            $btn__target = $('.btn-target--'+linked__id);

        if ($btn__linked.length && $btn__target.length) {
            $btn__linked.outerWidth($btn__target.outerWidth());
            $btn__linked.html($btn__target.html());
        }
    });

    // change language
    $(function () {
        var $language__item = $('.language__item');

        $language__item.on('click', function () {
            var $this = $(this),
                this_id = $this.data('id');

            $.ajax({
                type: 'POST',
                url: ajaxurl.url,
                dataType: 'text', // ответ ждем в text-формате
                data: {
                    action: 'change_language',
                    value: this_id
                }, // данные для отправки
                success: function () { // событие после удачного обращения к серверу и получения ответа
                    location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) { // в случае неудачного завершения запроса к серверу
                    console.error('submit-error-@11: '+xhr.status); // покажем ответ сервера
                    console.error('submit-error-@12: '+thrownError); // и текст ошибки
                }
            });
        });
    });

    // work with fixing on scroll
    $(function () {
        var $window = $(window),
            $top_menu = $('.top-menu'),
            $header = $('.header'),
            top_menu_height = $top_menu.outerHeight(),
            header_height = $header.outerHeight(),
            $next_elem = $('.top-menu + *').first();

        // Variables of scroll btn
        var $page_btn = $('.btn--scroll-btn-on-page'), // btn on page
            $scroll_btn = $('.scroll-btn .btn'),
            scroll_btn__hide_px = $scroll_btn.data('top'),
            wpadminbar_height = $('#wpadminbar').outerHeight(),
            const_h = top_menu_height + wpadminbar_height;

        var $cont = $('.video-start-on-scroll'),
            cont_h = $cont.outerHeight();

        var $scroll_content = $('.scroll-content').first(),
            $scrollable_in_cont = $('.scrollable-in-cont', $scroll_content).first(),
            $sister_of_scroll_content = $('.sister-of-scroll-content').first();

        if ($scrollable_in_cont.length) {
            var scroll_content_top = $scroll_content.offset().top,
                scroll_content_bottom = scroll_content_top + $scroll_content.innerHeight(),
                scrollable_in_cont_top = $scrollable_in_cont.offset().top,
                scrollableHeight = 0,
                sisterHeight = 0,
                no_scrollable = 0;

            $scroll_content.children().each(function(){
                scrollableHeight = scrollableHeight + $(this).outerHeight(true);
            });
            $sister_of_scroll_content.children().each(function(){
                sisterHeight = sisterHeight + $(this).outerHeight(true);
            });
            if (scrollableHeight > sisterHeight) {
                no_scrollable = 1;
            }

            window.scrollable_in_cont_h = $scrollable_in_cont.outerHeight();
        }

        function atc_scroll_header () {
            var scrollTop = $window.scrollTop();

            if (scrollTop > header_height && $window.width() > mobile_width) {
                if (!$top_menu.hasClass('top-menu--fixed')) {
                    $top_menu.addClass('top-menu--fixed');
                    $next_elem.css({
                        'padding-top': top_menu_height+'px'
                    });
                }
            } else {
                if ($top_menu.hasClass('top-menu--fixed')) {
                    $top_menu.removeClass('top-menu--fixed');
                    $next_elem.css({
                        'padding-top': '0'
                    });
                }
            }

            // Variables of scroll btn
            if ($page_btn.length) {
                var sc = scrollTop + const_h,
                    page_btn__top = $page_btn.offset().top;

                if ((sc > (page_btn__top + 2)) && $window.width() > mobile_width) {
                    var s = scroll_btn__hide_px - (scrollTop + const_h - page_btn__top - 2);

                    if (s < 0) s = 0;
                    if (s >= 0) {
                        $scroll_btn.css({
                            'top': s + 'px'
                        });
                    }
                    $scroll_btn.removeClass('btn--scroll-hide');
                } else {
                    if (!$scroll_btn.hasClass('btn--scroll-hide')) {
                        $scroll_btn.css({
                            'top': scroll_btn__hide_px + 'px'
                        });
                        $scroll_btn.addClass('btn--scroll-hide');
                    }
                }
            }

            // Video Start on scroll
            if ($cont.length) {
                var cont_top = $cont.offset().top,
                    $active_tab = $('.service-box__item--active', $cont),
                    $video = $('video', $active_tab),
                    windowHeight = window.innerHeight;

                if ($video.length && !is_mobile()) {
                    if (((scrollTop + windowHeight - cont_h*0.3) > cont_top) && (sc < (cont_top + cont_h - cont_h*0.2))) {
                        if (!$video.hasClass('video--start')) {
                            $video.get(0).play();
                            $video.addClass('video--start');
                        }
                    } else {
                        if ($video.hasClass('video--start')) {
                            $video.get(0).pause();
                            $video.removeClass('video--start');
                        }
                    }
                }
            }

            // Scroll ATC Form
            if ($scrollable_in_cont.length) {
                if (!no_scrollable) {
                    if ((sc > (scrollable_in_cont_top - 4)) && $window.width() > mobile_width) {
                        if ((sc + window.scrollable_in_cont_h + 4) >= scroll_content_bottom) {
                            $scrollable_in_cont.addClass('scrollable-in-cont--bottom');
                            $scrollable_in_cont.removeClass('scrollable-in-cont--fixed');
                        } else {
                            if (!$scrollable_in_cont.hasClass('scrollable-in-cont--fixed')) {
                                $scrollable_in_cont.css({
                                    'top': const_h + 5 + 'px'
                                });
                                $scrollable_in_cont.addClass('scrollable-in-cont--fixed');
                                $scrollable_in_cont.removeClass('scrollable-in-cont--bottom');
                            }
                        }
                    } else {
                        if ($scrollable_in_cont.hasClass('scrollable-in-cont--fixed')) {
                            $scrollable_in_cont.removeClass('scrollable-in-cont--fixed');
                            $scrollable_in_cont.removeClass('scrollable-in-cont--bottom');
                            $scrollable_in_cont.css({
                                'top': 'initial'
                            });
                        }
                    }
                }
            }
        }

        $window.on('scroll', atc_scroll_header); //Событие скролла вешаем на viewport
        atc_scroll_header(); //Если страница при загрузке уже с прокруткой
    });

    function atc_scrollable_in_cont_refresh() {
        var $scroll_content = $('.scroll-content').first(),
            $scrollable_in_cont = $('.scrollable-in-cont', $scroll_content).first();

        window.scrollable_in_cont_h = $scrollable_in_cont.outerHeight();
    }
    window.atc_scrollable_in_cont_refresh = atc_scrollable_in_cont_refresh;

    // Width of right part of Service Tab
    $(function () {
        atc_right_part_service_width();
        setTimeout(atc_right_part_service_width, 2000);
    });
    $(window).on('resize', function () {
        atc_right_part_service_width();
    });
    function atc_right_part_service_width () {
        var body_width = $('body').width(),
            services__box_width = $('.services__box').first().width(),
            $services__right = $('.services__right'),
            $service_box__bg = $('.service-box__bg'),
            $video = $('video', $service_box__bg);

        if ($service_box__bg.length) {
            if ((body_width - 200) > services__box_width) {
                $service_box__bg.width((body_width - services__box_width) / 4 + $services__right.width());

                if (true || $video.width() < $service_box__bg.width()) {
                    $video.css({
                        'width' : $service_box__bg.width() + 'px',
                        'height' : 'auto'
                    });
                }
            } else {
                $service_box__bg.css('width', '100%');
            }
        }
    }
    window.atc_right_part_service_width = atc_right_part_service_width;

    // Service Tabs
    $(function () {
        var $services = $('.services'),
            $service_tabs__item = $('.service-tabs__item', $services);

        if ($service_tabs__item.length && !is_mobile()) {
            $service_tabs__item.on('click', function () {
                var $this = $(this),
                    this_id = $this.data('id'),
                    $service_tabs__item = $('.service-tabs__item', $services),
                    $service_box__item = $('.service-box__item', $services),
                    $service_box__item_target = $('.service-box__item--'+this_id, $services),
                    $videos = $('video', $service_box__item),
                    $video_target = $('video', $service_box__item_target);

                $service_tabs__item.removeClass('service-tabs__item--active');
                $this.addClass('service-tabs__item--active');
                $service_box__item.removeClass('service-box__item--active');
                $service_box__item_target.addClass('service-box__item--active');

                if ($video_target.length) {
                    $videos.each(function () {
                        $(this).get(0).pause();
                    });
                    $video_target.get(0).play();
                }
            });
        }
    });
    
    $(function () {
        var $slider = $('.slider-slick'),
            $slick__single_news = $('.slick--single-news'),
            $slick__reach_news = $('.slick--reach-news');

        if ($slider.length) {
            $slider.slick({
                "prevArrow": false,
                "nextArrow": false,
                "slidesToShow": 1,
                "slidesToScroll": 1,
                "autoplay": 1,
                "speed": 1200,
                "pauseOnHover": 0,
                "autoplaySpeed": 6500,
                "dots": false
            });
            $slider.on('afterChange', function(){atc_slick_animate($(this))});

            function atc_slick_animate ($this) {
                var $current = $('.slick-active', $this),
                    $slick_slide = $('.slick-slide', $this),
                    $bg_image = $('.slide-slick__bg--image', $this),
                    $bg_image__current = $('.slide-slick__bg--image', $current);

                $slick_slide.removeClass('slick-slide--active');
                $current.addClass('slick-slide--active');
                $bg_image.css({
                    'transition': 'none',
                    'transform': 'scale(1, 1)'
                });
                $bg_image__current.css({
                    'transition': 'all 14s ease 0s',
                    'transform': 'scale(1.26, 1.26)'
                });
            }
            setTimeout(function () {
                atc_slick_animate($slider);
            }, 500);
            window.atc_slick_animate = atc_slick_animate;
        }

        if ($slick__single_news.length) {
            $slick__single_news.slick({
                "prevArrow": false,
                "nextArrow": false,
                "autoplay": 1,
                "speed": 800,
                "autoplaySpeed": 3800,
                "pauseOnHover": 1
            });
        }

        if ($slick__reach_news.length) {
            $slick__reach_news.slick({
                "prevArrow": '<div class="slider__prev"></div>',
                "nextArrow": '<div class="slider__next"></div>',
                "autoplay": 0,
                "speed": 800,
                "autoplaySpeed": 3800,
                "pauseOnHover": 1
            });
        }
    });

}($ || window.jQuery));
// end of file