<?php
add_filter('body_class','services_body_class');
function services_body_class( $classes ) {
	$classes[] = 'services';
	return $classes;
}

get_header();

$id = get_the_ID();
$title              = get_the_title($id);
$image_id           = get_post_meta( $id, 'cdiservices-meta-image', true );
$image_url          = wp_get_attachment_image_src( $image_id, 'large' )[0];
$short_text         = get_post_meta( $id, 'cdiservices-meta-text-short', true );
$main_text          = get_post_meta( $id, 'cdiservices-meta-textarea', true );
$ext_text           = get_post_meta( $id, 'cdiservices_wysiwyg_meta_field', true );
$time1              = get_post_meta( $id, 'cdiservices-meta-text-time-1', true );
$cost1              = get_post_meta( $id, 'cdiservices-meta-text-cost-1', true );
$time2              = get_post_meta( $id, 'cdiservices-meta-text-time-2', true );
$cost2              = get_post_meta( $id, 'cdiservices-meta-text-cost-2', true );
$time3              = get_post_meta( $id, 'cdiservices-meta-text-time-3', true );
$cost3              = get_post_meta( $id, 'cdiservices-meta-text-cost-3', true );
?>
    <div class="y"><img src="<?php echo get_template_directory_uri(); ?>/img/y.png" alt=""></div>
    <div class="s">S</div>
    <div class="t">T</div>
    <div class="b">B</div>
    <div id="fullpage">
        <div id="first" class="section fp-section fp-completely active services__content" style="display: block;">
            <div id="services__enroll">
                <div id="1">
                    <div class="main enroll">
                        <div class="center">
                            <div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-7.png" alt=""></div>
                            <a href="/услуги/" class="btn btn__back">« УСЛУГИ</a>
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
                                    <div class="like-hide-text" style="position: relative;">
                                        <?php tbs_text_slider(tbs_auto_paragraph(htmlspecialchars_decode($main_text)), 49); ?>
                                    </div>
                                    <div class="hide-text"><?php echo htmlspecialchars_decode($main_text); ?></div>
                                    <?php //echo tbs_auto_paragraph(htmlspecialchars_decode($ext_text)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="services__content--mobile">
                <div id="1">
                    <div class="main services__items--mobile">
                        <div class="center">
                            <ul class="services__list--mobile">
                                <li>
                                    <div class="services__items__block">
                                        <div class="services__item__left--mobile"
                                             style="background-image: url('<?php echo $image_url; ?>');">
                                        </div>
                                        <div class="services__item__right__text">
                                            <h3 class="slider-up"><?php echo $title; ?></h3>
                                            <hr>
                                            <p class="text--italic"><?php echo $short_text; ?></p>
											<?php echo htmlspecialchars_decode($ext_text); ?>
                                        </div>
                                        <div class="enroll">
                                            <div class="center">
                                                <div class="enroll__bottom">
                                                    <div class="enroll__bottom__left">
                                                        <div class="enroll__bottom__price">
                                                            <div class="enroll__price__circle">
                                                                <p class="service__time"><?php echo $time1; ?></p>
                                                                <hr>
                                                                <p class="service__min">мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost1; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                        <div class="enroll__bottom__price">
                                                            <div class="enroll__price__circle">
                                                                <p class="service__time"><?php echo $time2; ?></p>
                                                                <hr>
                                                                <p class="service__min">мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost2; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                        <div class="enroll__bottom__price">
                                                            <div class="enroll__price__circle">
                                                                <p class="service__time"><?php echo $time3; ?></p>
                                                                <hr>
                                                                <p class="service__min">мин</p>
                                                            </div>
                                                            <p class="text--price"><?php echo $cost3; ?> <sup>РУБ</sup></p>
                                                        </div>
                                                    </div>

                                                    <div class="enroll__bottom__right">
                                                        <p><?php echo htmlspecialchars_decode($main_text); ?></p>
														<?php echo htmlspecialchars_decode($ext_text); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();