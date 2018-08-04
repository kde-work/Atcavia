<?php
/*
Template Name: Услуги
*/
add_filter('body_class','services_body_class');
function services_body_class( $classes ) {
	$classes[] = 'services';
	return $classes;
}
get_header();
the_post();

// Категории услуг
$services_category = tbs_list_of_cat('cdiservices-category');

?>
    <div class="y"><img src="<?php echo get_template_directory_uri(); ?>/img/y.png" alt=""></div>
    <div class="s">S</div>
    <div class="t">T</div>
    <div class="b">B</div>

    <div class="services__content--mobile">
        <div id="1">
            <div class="main services__items--mobile">
                <div class="center">
                    <?php
                    $j = 0; // итерация для рубрик
                    $p = 0; // итерация для постов
                    $more_html = ''; // Раздел "Подробнее"
                    foreach ($services_category as $cat) {
	                    ++ $j;
	                    ?>
                        <div class="services__m-content services__m-content--<?php echo $j; ?>" data-id="<?php echo $j; ?>">
                            <div class="container__left">
                                <div class="container__title">
                                </div>
                            </div>
                            <script>
                                (function ($) {
                                    $(function () {
                                        mySlider('.services__slider--<?php echo $j; ?>', 'irregular');
                                    });
                                }($ || window.jQuery));
                            </script>
                            <div class="container__right services__slider services__slider--<?php echo $j; ?>">
                                <ul class="slider">
				                    <?php
				                    $posts = tbs_list_post_by_post_type( 'services', $cat['term_id'] );
				                    if ( count( $posts ) ) {
					                    foreach ( $posts as $post ) {
						                    $title              = get_the_title($post['ID']);
						                    $image_id           = get_post_meta( $post['ID'], 'cdiservices-meta-image', true );
						                    $image_url          = wp_get_attachment_image_src( $image_id, 'large' )[0];
						                    $short_text         = get_post_meta( $post['ID'], 'cdiservices-meta-text-short', true );
						                    $main_text          = get_post_meta( $post['ID'], 'cdiservices-meta-textarea', true );
						                    $ext_text           = get_post_meta( $post['ID'], 'cdiservices_wysiwyg_meta_field', true );
						                    $time1              = get_post_meta( $post['ID'], 'cdiservices-meta-text-time-1', true );
						                    $cost1              = get_post_meta( $post['ID'], 'cdiservices-meta-text-cost-1', true );
						                    $time2              = get_post_meta( $post['ID'], 'cdiservices-meta-text-time-2', true );
						                    $cost2              = get_post_meta( $post['ID'], 'cdiservices-meta-text-cost-2', true );
						                    $time3              = get_post_meta( $post['ID'], 'cdiservices-meta-text-time-3', true );
						                    $cost3              = get_post_meta( $post['ID'], 'cdiservices-meta-text-cost-3', true );
						                    ?>
                                            <li class="services__reach-slider">
                                                <div class="services__first">
                                                    <div class="container__img container__img--desc"
                                                         style="background-image: url('<?php echo $image_url; ?>');">
                                                    </div>
                                                    <h3 class="slider-up"><?php echo $title; ?></h3>
                                                    <hr>
                                                    <p class="text--italic slider-up"><?php echo htmlspecialchars_decode($short_text); ?></p>
                                                    <div class="wrap slider-left"><div class="btn services__more">Подробнее</div></div>
                                                </div>
                                                <div class="services__second">
                                                    <div class="container__img container__img--desc"
                                                         style="background-image: url('<?php echo $image_url; ?>');">
                                                    </div>
                                                    <div class="text-slide-box">
                                                        <?php tbs_text_slider(htmlspecialchars_decode($main_text), 57); ?>
                                                    </div>
                                                    <p class="text--italic slider-up"><?php echo htmlspecialchars_decode($ext_text); ?></p>
                                                    <div class="circle-price">
						                                <?php if ($time1 AND $cost1) : ?>
                                                        <div class="circle-price__item">
                                                            <div class="circle-price__circle">
                                                                <p class="service__time"><?php echo $time1; ?></p>
                                                                <hr>
                                                                <p class="service__min">мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost1; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php if ($time2 AND $cost2) : ?>
                                                        <div class="circle-price__item">
                                                            <div class="circle-price__circle">
                                                                <p class="service__time"><?php echo $time2; ?></p>
                                                                <hr>
                                                                <p class="service__min">мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost2; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php if ($time3 AND $cost3) : ?>
                                                        <div class="circle-price__item">
                                                            <div class="circle-price__circle">
                                                                <p class="service__time"><?php echo $time3; ?></p>
                                                                <hr>
                                                                <p class="service__min">мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost3; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="wrap slider-left"><div class="btn btn--zap" onclick="popup_c({'cat':'услуги', 'title':'Заказ услуги', 'email': 1, 'time': 1, 'gender': 1, 'description': 'Услуга: <?php echo $title; ?>'}, this);">Записаться</div></div>
                                                    <button class="btn btn__back btn--back">НАЗАД</button>
                                                </div>
                                            </li>
						                    <?php
					                    }
				                    }
				                    ?>
                                </ul>
                                <div class="unslider">
                                    <a class="unslider-arrow prev"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
                                    <a class="unslider-arrow next"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
                                </div>
                            </div>
                        </div>
                        <h3 class="services__title services__title--<?php echo $j; ?>" data-id="<?php echo $j; ?>">
                            <span class="services__title-num"><?php echo tbs_get_number_with_zero($j); ?></span>
                            <span class="services__title-text"><?php echo tbs_replace_str_with_star($cat['name']); ?></span>
                        </h3>
	                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

	<div class="services__content">
		<div id="services__blocks">
        <?php
        $j = 0; // итерация для рубрик
        $p = 0; // итерация для постов
        $more_html = ''; // Раздел "Подробнее"
        foreach ($services_category as $cat) {
        ++ $j;
        ?>
            <div id="<?php echo $j; ?>">
                <div class="main services__items">
                    <div class="center">
                        <div class="container__wrap"><img
                                src="<?php echo get_template_directory_uri(); ?>/img/border-6.png" alt=""></div>
                        <ul class="slider">
                            <li>
								<?php
								$posts = tbs_list_post_by_post_type( 'services', $cat['term_id'] );
//								print_r( $posts );
								$k = 0;
								foreach ( $posts as $post ) {
									if ( ($k % 3) == 0 AND $k ) {
										echo '</li>';
										echo '<li>';
									}
									++$k;
									++$p;

									$title              = get_the_title($post['ID']);
									$image_id           = get_post_meta( $post['ID'], 'cdiservices-meta-image', true );
									$image_url          = wp_get_attachment_image_src( $image_id, 'large' )[0];
									$short_text         = get_post_meta( $post['ID'], 'cdiservices-meta-text-short', true );
									$main_text          = get_post_meta( $post['ID'], 'cdiservices-meta-textarea', true );
									$ext_text           = get_post_meta( $post['ID'], 'cdiservices_wysiwyg_meta_field', true );
									$time1              = get_post_meta( $post['ID'], 'cdiservices-meta-text-time-1', true );
									$cost1              = get_post_meta( $post['ID'], 'cdiservices-meta-text-cost-1', true );
									$time2              = get_post_meta( $post['ID'], 'cdiservices-meta-text-time-2', true );
									$cost2              = get_post_meta( $post['ID'], 'cdiservices-meta-text-cost-2', true );
									$time3              = get_post_meta( $post['ID'], 'cdiservices-meta-text-time-3', true );
									$cost3              = get_post_meta( $post['ID'], 'cdiservices-meta-text-cost-3', true );
                                    ?>
                                    <div class="services__items__block">
                                        <div class="services__item__left block--back-image" style="background-image: url('<?php echo $image_url; ?>');">
                                        </div>
                                        <div class="services__item__right">
                                            <h3><?php echo $title; ?></h3>
                                            <div class="services__item__right__bottom">
                                                <div class="services__item__bottom__left">
                                                    <hr>
                                                    <p class="text--italic"><?php echo $short_text; ?></p>
                                                </div>
                                                <div class="services__item__bottom__right">
                                                    <button class="btn" data-target="services__enroll <?php echo $p; ?>">Подробнее</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    // Формирование "Подробнее"
									ob_start();
									?>
                                    <div id="<?php echo $p; ?>">
                                        <div class="main enroll">
                                            <div class="center">
                                                <div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-7.png" alt=""></div>
                                                <button class="btn btn__back">НАЗАД</button>
                                                <button class="btn btn__enroll" onclick="popup_c({'cat':'услуги', 'title':'Заказ услуги', 'email': 1, 'time': 1, 'gender': 1, 'description': 'Услуга: <?php echo $title; ?>'}, this);">ЗАПИСАТЬСЯ</button>

                                                <div class="enroll__top">
                                                    <div class="enroll__top__left">
                                                        <h3><?php echo $title; ?></h3>
                                                        <hr>
                                                        <p class="text--italic"><?php echo $short_text; ?></p>
                                                    </div>
                                                    <div class="enroll__top__right block--back-image" style="background-image: url('<?php echo $image_url; ?>');">
                                                    </div>
                                                </div>
                                                <div class="enroll__bottom">
                                                    <div class="enroll__bottom__left">
                                                        <?php if ($time1 AND $cost1) : ?>
                                                        <div class="enroll__bottom__price">
                                                            <div class="enroll__price__circle">
                                                                <p><?php echo $time1; ?></p>
                                                                <hr>
                                                                <p>мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost1; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                        <?php endif; ?>
									                    <?php if ($time2 AND $cost2) : ?>
                                                        <div class="enroll__bottom__price">
                                                            <div class="enroll__price__circle">
                                                                <p><?php echo $time2; ?></p>
                                                                <hr>
                                                                <p>мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost2; ?> <sup>РУБ</sup></p>
                                                        </div>
									                    <?php endif; ?>
										                <?php if ($time3 AND $cost3) : ?>
                                                        <div class="enroll__bottom__price">
                                                            <div class="enroll__price__circle">
                                                                <p><?php echo $time3; ?></p>
                                                                <hr>
                                                                <p>мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost3; ?> <sup>РУБ</sup></p>
                                                        </div>
										                <?php endif; ?>
                                                    </div>

                                                    <div class="enroll__bottom__right">
                                                        <div class="service__slick">
		                                                    <?php tbs_text_slider(htmlspecialchars_decode($main_text), 50, 'service__slick-item'); ?>
                                                        </div>
	                                                    <?php echo htmlspecialchars_decode($ext_text); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
									$more_html .= ob_get_contents();
									ob_end_clean(); // втихую отбрасывает содержимое буфера
								}
                                ?>
                            </li>
                        </ul>
                        <div class="unslider">
                            <a class="unslider-arrow prev"><img
                                    src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt=""/></a>
                            <a class="unslider-arrow next"><img
                                    src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt=""/></a>
                        </div>
                    </div>
                </div>
            </div>
	        <?php
        }
        ?>
		</div>

		<div id="services__enroll">
            <?php
            echo $more_html;
            ?>
		</div>
	</div>

	<div class="services__main ">
		<div class="services__main__left">
            <?php
            $j = 0;
            foreach ($services_category as $cat) {
                ++$j;
	            $img = get_field('изображение', "cdiservices-category_{$cat['term_id']}");
                if (!$img) {
	                $img = get_template_directory_uri() . '/img/services-main.png';
                } else {
	                $img = wp_get_attachment_image_src($img, 'large', true )[0];
                }
                if ($j == 1) {
	                $img_first = $img;
                }
	            ?>
                <img src="<?php echo $img; ?>" alt="" class="img--hidden">
                <a href="#" class="services__link" data-target="services__blocks <?php echo $j; ?>" data-img="<?php echo $img; ?>">
                    <span><?php echo tbs_get_number_with_zero($j); ?></span>
                    <span><?php echo tbs_replace_str_with_star($cat['name']); ?></span>
                </a>
	            <?php
            }
            ?>
		</div>
		<div class="services__main__right block--back-image hover-target-image" style="background-image: url('<?php echo $img_first; ?>');">
		</div>
	</div>

	<div class="sections">

		<div class="section" id="section1">
		</div>

		<div class="section" id="section2">
		</div>

		<div class="section" id="section3">
		</div>
	</div>

<?php
wp_reset_postdata();
get_footer();
