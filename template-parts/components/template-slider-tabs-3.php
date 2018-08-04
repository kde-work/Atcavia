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
 * COMPONENT IMPLEMENTATION: Слайдер в 3 строки с Табами
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
										$title              = $cat->get_field('Заголовок');
										$image_url          = $tab->get_img( 'Картинка Мобильная', 'large' )[0]['src'];
										$short_text         = $tab->get_field('Описание слайда');
										$main_text          = $tab->get_field('Описание справа окна');
										$ext_text           = $tab->get_field('Описание слева окна');
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
                                                <div class="wrap slider-left"><button class="btn btn--zap" onclick="popup_c({'cat':'<?php echo get_the_title(); ?>', 'title':'<?php echo $cat->get_field('Текст кнопки окна Подробнее'); ?>', 'email': 1, 'time': 0, 'gender': 0, 'description': 'Услуга: <?php echo str_replace(array('<br>', '<br />'), ' ', $tab->get_field('Заголовок окна')); ?>. /<?php echo str_replace(array('<br>', '<br />'), ' ', $cat->get_field( 'Заголовок')); ?>/'}, this);"><?php echo $cat->get_field('Текст кнопки окна Подробнее'); ?></button></div>

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
                    <div class="main services__items">
                        <div class="center">
                            <div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-6.png" alt=""></div>
                                <ul class="slider">
                                    <li>
                                    <?php
                                    $slides = $tab->get_fields( 'Слайд' );
                                    if ( count( $slides ) ) {
                                        $y = 0;
                                        foreach ( $slides as $slide ) {
                                            if ( ( $y % 3 ) == 0 AND $y ) {
                                                echo '</li>';
                                                echo '<li>';
                                            }
                                            ++ $y;
                                            ++ $p;
                                            if ($Mammen->get_field( 'Шаблон' ) == 'Бизнес Линч') :
                                            ?>
                                                <div class="services__items__block">
                                                    <div class="services__item__left container__img--desc block--back-image" style="background-image: url('<?php echo $slide->get_img( 'Картинка Большая', 'large' )[0]['src']; ?>'); <?php if ($tab->get_field('background-size')) echo 'background-size: cover;' ?> <?php if (intval($tab->get_field('min-height'))) echo 'min-height: '. intval($tab->get_field('min-height')) .'px;' ?>"></div>
                                                    <div class="services__item__right">
                                                        <div class="services__item__right__text">
                                                            <h3><?php echo $slide->get_field('Заголовок слайда'); ?></h3>
                                                            <hr>
                                                            <p class="text--italic"><?php echo $slide->get_field('Описание слайда'); ?></p>
                                                        </div>
                                                        <div class="services__item__right__btn"><button class="btn" data-target="services__enroll <?php echo $p; ?>">Подробнее</button></div>
                                                    </div>
                                                </div>
                                            <?php else : ?>
                                                <div class="services__items__block">
                                                    <div class="services__item__left container__img--desc block--back-image" style="background-image: url('<?php echo $slide->get_img( 'Картинка Большая', 'large' )[0]['src']; ?>'); <?php if ($tab->get_field('CONTAIN')) echo 'background-size: contain;' ?> <?php if (intval($tab->get_field('min-height'))) echo 'min-height: '. intval($tab->get_field('min-height')) .'px;' ?>"></div>
                                                    <div class="services__item__right">
                                                        <h3><?php echo $slide->get_field('Заголовок слайда'); ?></h3>
                                                        <div class="services__item__right__bottom">
                                                            <div class="services__item__bottom__left">
                                                                <hr>
                                                                <p class="text--italic"><?php echo $slide->get_field('Описание слайда'); ?></p>
                                                            </div>
                                                            <div class="services__item__bottom__right"><button class="btn" data-target="services__enroll <?php echo $p; ?>">Подробнее</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            endif;

                                            // Формирование "Подробнее"
                                            ob_start();
                                            ?>
                                            <div id="<?php echo $p; ?>">
                                                <div class="main enroll">
                                                    <div class="center">
                                                        <div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-8.png" alt=""></div>
                                                        <button class="btn btn__back">НАЗАД</button>
                                                        <?php
                                                        $class_name = MM_Component_Page::clear_name($tab->get_field('Текст кнопки окна Подробнее'));
                                                        ?>
                                                        <style type="text/css">
                                                            #fullpage .<?php echo $class_name; ?>::after, #fullpage .<?php echo $class_name; ?>::before {
                                                                content: '<?php echo $tab->get_field('Текст кнопки окна Подробнее'); ?>' !important;
                                                            }
                                                        </style>
                                                        <button class="btn btn__enroll <?php echo $class_name; ?>" onclick="popup_c({'cat':'<?php echo get_the_title(); ?>', 'title':'<?php echo $tab->get_field('Текст кнопки окна Подробнее'); ?>', 'email': 1, 'time': 0, 'gender': 0, 'description': 'Услуга: <?php echo str_replace(array('<br>', '<br />'), ' ', $slide->get_field('Заголовок окна')); ?>. /<?php echo str_replace(array('<br>', '<br />'), ' ', $tab->get_field( 'Заголовок')); ?>/'}, this);"><?php echo $tab->get_field('Текст кнопки окна Подробнее'); ?></button>

                                                        <div class="enroll__top">
                                                            <div class="enroll__top__left">
                                                                <h3><?php echo $slide->get_field('Заголовок окна'); ?></h3>
                                                                <hr>
                                                                <p class="text--italic"><?php echo $slide->get_field('Подзаголовок окна'); ?></p>
                                                            </div>
                                                            <div class="enroll__top__right block--back-image" style="background-image: url('<?php echo $slide->get_img( 'Картинка Большая', 'large' )[0]['src']; ?>'); <?php if ($tab->get_field('CONTAIN')) echo 'background-size: contain;' ?>">
<!--                                                                <img src="--><?php //echo $slide->get_img( 'Картинка Большая', 'large' )[0]['src']; ?><!--" alt="">-->
                                                            </div>
                                                        </div>
                                                        <div class="enroll__bottom">
                                                            <div class="enroll__bottom__left">
                                                                <div class="align--left">
                                                                    <?php echo $slide->get_field('Описание слева окна'); ?>
                                                                </div>
                                                            </div>

                                                            <div class="enroll__bottom__right">
                                                                <div class="service__slick">
	                                                                <?php tbs_text_slider(htmlspecialchars_decode($slide->get_field('Описание справа окна')), 57, 'service__slick-item'); ?>
<!--                                                                <p>--><?php //echo $slide->get_field('Описание справа окна'); ?><!--</p>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $more_html .= ob_get_contents();
                                            ob_end_clean(); // втихую отбрасывает содержимое буфера
                                        }
                                    }
                                    ?>
                                    </li>
                                </ul>
                            <div class="unslider">
                                <a class="unslider-arrow prev"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
                                <a class="unslider-arrow next"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
			}
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