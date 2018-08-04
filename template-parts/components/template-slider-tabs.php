<?php
/**
 * An example implementation of the component in code
 *
 * Using content of component in a custom implementation of the html
 *
 * @author Dmitry
 * @version 0.01
 * @package component
 *
 * COMPONENT IMPLEMENTATION: Слайдер с Табами
 *
 */

global $Mammen;
?>

<div class="services__content--mobile">
    <div id="1">
        <div class="main services__items--mobile">
            <div class="center">
				<?php
				$j = 0; // итерация для рубрик
				$p = 0; // итерация для постов
				$more_html = ''; // Раздел "Подробнее"
				$services_category = $Mammen->get_fields( 'Таб' );
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
								$posts = $cat->get_fields( 'Слайд' );
								if ( count( $posts ) ) {
									foreach ( $posts as $tab ) {
										$title              = $tab->get_field('Заголовок слайда');
										$sub_title          = $tab->get_field('Подзаголовок слайда');
										$image_url          = $tab->get_img( 'Картинка Мобильная', 'large' )[0]['src'];
										$short_text         = $tab->get_field('Описание слайда');
										?>
                                        <li class="services__reach-slider">
                                            <div class="services__first">
                                                <div class="container__img container__img--desc"
                                                     style="background-image: url('<?php echo $image_url; ?>');">
                                                </div>
                                                <h3 class="slider-up"><?php echo $title; ?></h3>
                                                <hr>
                                                <p class="text--italic slider-up"><?php echo htmlspecialchars_decode($sub_title); ?></p>
                                                <p>
		                                            <?php echo htmlspecialchars_decode($short_text); ?>
                                                </p>
                                                <div class="wrap slider-left"><!--<div class="btn btn--zap">Записаться</div>--></div>
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
                        <span class="services__title-text"><?php echo tbs_replace_str_with_star($cat->get_field('Заголовок')); ?></span>
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
	    $tabs = $Mammen->get_fields( 'Таб' );
	    $k = 0;
	    if ( count( $tabs ) ) {
		    foreach ( $tabs as $tab ) {
			    ++$k;
			    ?>
                <div id="<?php echo $k; ?>">
                    <div class="main second">
                        <div class="center">
                            <div class="container">

                                <div class="unslider">
                                    <a class="unslider-arrow prev"><img
                                            src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt=""/></a>
                                    <a class="unslider-arrow next"><img
                                            src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt=""/></a>
                                </div>
                                <div class="container__wrap"><img
                                        src="<?php echo get_template_directory_uri(); ?>/img/border-6.png" alt=""></div>

                                <div class="container__left">
                                    <div class="container__title">
<!--                                        <h2>О нас <br></h2>-->
                                    </div>
                                </div>
                                <div class="container__right">
                                    <ul class="slider">
	                                    <?php
	                                    $slides = $tab->get_fields( 'Слайд' );
	                                    if ( count( $slides ) ) {
		                                    foreach ( $slides as $slide ) {
			                                    ?>
                                                <li class="service__slick-li">
                                                    <h3 class="slider-up"><?php echo $slide->get_field('Заголовок слайда'); ?></h3>
                                                    <hr>
                                                    <p class="text--italic slider-up"><?php echo $slide->get_field('Подзаголовок слайда'); ?></p>
                                                    <div class="service__slick">
		                                                <?php tbs_text_slider(htmlspecialchars_decode($slide->get_field( 'Описание слайда' )), 47, 'service__slick-item'); ?>
                                                    </div>
                                                    <div class="hide-text"><?php echo htmlspecialchars_decode($slide->get_field( 'Описание слайда' )); ?></div>
                                                    <div class="container__img container__img--desc block--back-image" style="background-image: url('<?php echo $slide->get_img( 'Картинка Большая', 'large' )[0]['src']; ?>');"></div>
                                                </li>
			                                    <?php
		                                    }
	                                    }
                                        ?>
                                    </ul>
                                    <div class="<?php echo get_template_directory_uri(); ?>/img__tmp"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			    <?php
		    }
	    }
        ?>
    </div>
</div>

<div class="services__main ">
    <div class="services__main__left">
	    <?php
	    $tabs = $Mammen->get_fields( 'Таб' );
        $k = 0;
	    if ( count( $tabs ) ) {
		    foreach ( $tabs as $tab ) {
			    ++$k;
			    $img_id = $tab->get_img( 'Изображение hover-эффект', 'large' )[0]['id'];
			    $img = $tab->get_img( 'Изображение hover-эффект', 'large' )[0]['src'];
			    if (!$img_id) {
				    $img = get_template_directory_uri() . '/img/services-main.png';
			    }
			    if ($k == 1) {
				    $img_first = $img;
			    }
			    ?>
                <img src="<?php echo $img; ?>" alt="" class="img--hidden">
                <a href="#" class="services__link" data-target="services__blocks <?php echo $k; ?>" data-img="<?php echo $img; ?>">
                    <span><?php echo tbs_get_number_with_zero($k); ?></span>
                    <span><?php echo $tab->get_field('Заголовок'); ?></span>
                </a>
			    <?php
		    }
	    }
        ?>
    </div>
    <div class="services__main__right block--back-image hover-target-image" style="background-image: url('<?php echo $img_first; ?>');"></div>
</div>

<div class="sections">

    <div class="section" id="section1">
    </div>

    <div class="section" id="section2">
    </div>

    <div class="section" id="section3">
    </div>
</div>