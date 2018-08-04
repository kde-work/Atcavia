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
 * COMPONENT IMPLEMENTATION: Обучение
 *
 */

global $Mammen;
?>

<div class="services__content--mobile">
    <div id="1">
        <div class="main services__items--mobile">
            <div class="center">
                <div class="services__m-content services__m-content--1" data-id="1">
                    <div class="container__left">
                        <div class="container__title">
                        </div>
                    </div>
                    <div class="container__right services__slider services__slider--text">
                        <h2><?php echo $Mammen->get_field( 'Заголовок О школе' ); ?></h2>
                        <p><?php echo $Mammen->get_field( 'Описание О школе' ); ?></p>
                    </div>
                </div>
                <h3 class="services__title services__title--1" data-id="1">
                    <span class="services__title-num">01</span>
                    <span class="services__title-text">О школе и<br>О тай массаже</span>
                </h3>
                <div class="services__m-content services__m-content--2" data-id="2">
                    <div class="container__left">
                        <div class="container__title">
                        </div>
                    </div>
                    <div class="container__right services__slider services__slider--text">
                        <h2><?php echo $Mammen->get_field( 'Заголовок О преподавателях' ); ?></h2>
                        <p><?php echo $Mammen->get_field( 'Описание О преподавателях' ); ?></p>
                    </div>
                </div>
                <h3 class="services__title services__title--1" data-id="2">
                    <span class="services__title-num">02</span>
                    <span class="services__title-text">О<br>преподах и</span>
                </h3>


                <div class="services__m-content services__m-content--3" data-id="3">
                    <div class="container__left">
                        <div class="container__title">
                        </div>
                    </div>
                    <script>
                        (function ($) {
                            $(function () {
                                mySlider('.services__slider--<?php echo $j; ?>', 'service');
                            });
                        }($ || window.jQuery));
                    </script>
                    <div class="container__right services__slider services__slider--<?php echo $j; ?>">

                        <ul class="slider">
                            <li>
			                    <?php
			                    $events = $Mammen->get_fields( 'Мероприятия' );
			                    $j = 0;
			                    $q = 0;
			                    foreach ($events as $event) {
				                    ++ $j;
				                    ++ $q;
				                    if ( ($j % 4) == 0 AND $j ) {
					                    $q = 0;
					                    echo '</li>';
					                    echo '<li>';
				                    }
				                    ?>
                                    <div class="schedule__block schedule__block--<?php echo $q; ?>">
                                        <div class="schedule__block__left">
                                            <p class="schedule__date"><span><?php echo $event->get_field('Дата мероприятия'); ?><br> <span class="month <?php
								                    if (mb_strlen($event->get_field('Месяц мероприятия')) > 5) echo 'month--long';
								                    ?>"><?php echo $event->get_field('Месяц мероприятия'); ?></span></span></p>
                                            <p><?php echo $event->get_field('Название мероприятия'); ?></p>
                                        </div>
                                        <hr>
                                        <div class="schedule__block__right">
                                            <p><?php echo $event->get_field('Краткое описание мероприятия'); ?></p>
                                        </div>
                                    </div>
				                    <?php
			                    }
			                    ?>
                            </li>
                        </ul>
                        <div class="wrap slider-left"></div>
                        <div class="unslider">
                            <a class="unslider-arrow prev"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
                            <a class="unslider-arrow next"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
                        </div>
                    </div>
                </div>
                <h3 class="services__title services__title--3" data-id="3">
                    <span class="services__title-num">03</span>
                    <span class="services__title-text">Информация <br>О курсах</span>
                </h3>

                <div class="services__m-content services__m-content--4" data-id="4">
                    <div class="container__left">
                        <div class="container__title">
                        </div>
                    </div>
                    <div class="main second application">
                        <div class="center">
                            <div class="container cta__block cta__block--none-style">
                                <form action="#" class="cta__form">
                                    <input type="text" name="cta__last-name" placeholder="Фамилия" required pattern="[A-Za-zА-Яа-яЁё]{2,}">
                                    <input type="text" name="cta__name" placeholder="Имя" required pattern="[A-Za-zА-Яа-яЁё]{2,}">
                                    <input type="email" name="cta__email" placeholder="Email" required>
                                    <input type="text" name="cta__phone" placeholder="Телефон" required>
                                    <button type="submit" class="btn" onclick="form_strong_submit(this);">Подать заявку</button>

                                    <div class="cta__status cta__status--loading">
                                        <div class="cta__status-body">
                                            <span class="cta__status-title">Идет отправка...</span>
                                            <div class="spinner">
                                                <div class="rect1"></div>
                                                <div class="rect2"></div>
                                                <div class="rect3"></div>
                                                <div class="rect4"></div>
                                                <div class="rect5"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="cta__status cta__status--success">
                                        <div class="cta__status-body">
                                            <span class="cta__status-title"><b>Заявка успешно отправлена!</b><br>В ближайшее время Вам позвонят</span>
                                        </div>
                                    </div>

                                    <div class="cta__status cta__status--error">
                                        <div class="cta__status-body">
                                            <span class="cta__status-title"><b>Произошла ошибка!</b><br>Заявка не отправлена</span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="url" value="<?php echo get_the_permalink(); ?>">
                                    <input type="hidden" name="description" value="Заявка на обучение">
                                    <input type="hidden" name="type" value="default">
                                    <input type="hidden" name="cat" value="заявка-на-обучение">
                                    <input type="hidden" name="action" value="tbs_form">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="services__title services__title--4" data-id="4">
                    <span class="services__title-num">04</span>
                    <span class="services__title-text">Подать<br>заявку</span>
                </h3>
            </div>
        </div>
    </div>
</div>


<div class="services__content">
	<div id="services__blocks">
		<div id="1">
			<div class="main second info">
				<div class="center">
					<div class="container info__container">
						<div class="education_info">
							<h2><?php echo $Mammen->get_field( 'Заголовок О школе' ); ?></h2>
							<p><?php echo $Mammen->get_field( 'Описание О школе' ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="2">

			<div class="main second info">
				<div class="center">
					<div class="container info__container">
						<div class="education_info">
                            <h2><?php echo $Mammen->get_field( 'Заголовок О преподавателях' ); ?></h2>
                            <p><?php // echo $Mammen->get_field( 'Описание О преподавателях' ); ?></p>
                            <div class="service__slick">
								<?php tbs_text_slider(htmlspecialchars_decode($Mammen->get_field( 'Описание О преподавателях' )), 100, 'service__slick-item'); ?>
                            </div>
                            <div class="hide-text"><?php echo htmlspecialchars_decode($Mammen->get_field( 'Описание О преподавателях' )); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="3">
			<div class="main second schedule">

				<div class="center">
					<div class="container border-cont">
						<div class="unslider">
							<a class="unslider-arrow prev"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
							<a class="unslider-arrow next"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
						</div>

						<div class="container__left border-cont__title">
                            <div class="border-line border-line--desc border-line--30"></div>
							<div class="container__title">
								<h2 class="schedule__title"><?php echo $Mammen->get_field( 'Заголовок О курсах' ); ?></h2>
							</div>
                            <div class="border-line border-line--desc"></div>
						</div>
						<div class="container__right">
							<ul class="slider">
								<li>
									<?php
									$events = $Mammen->get_fields( 'Мероприятия' );
									$j = 0;
									$q = 0;
									foreach ($events as $event) {
										++ $j;
										++ $q;
										if ( ($j % 4) == 0 AND $j ) {
											$q = 0;
											echo '</li>';
											echo '<li>';
										}
										?>
                                        <div class="schedule__block schedule__block--<?php echo $q; ?>">
                                            <div class="schedule__block__left">
                                                <p class="schedule__date"><span><?php echo $event->get_field('Дата мероприятия'); ?><br> <span class="month <?php
                                                        if (mb_strlen($event->get_field('Месяц мероприятия')) > 5) echo 'month--long';
                                                        ?>"><?php echo $event->get_field('Месяц мероприятия'); ?></span></span></p>
                                                <p><?php echo $event->get_field('Название мероприятия'); ?></p>
                                            </div>
                                            <hr>
                                            <div class="schedule__block__right">
                                                <p><?php echo $event->get_field('Краткое описание мероприятия'); ?></p>
                                            </div>
                                        </div>
										<?php
									}
                                    ?>
								</li>
							</ul>
						</div>
					</div>

				</div>
			</div>
		</div>

        <div id="4">
            <div class="main second application">
                <div class="center">
                    <div class="container cta__block cta__block--none-style">
                        <form action="#" class="cta__form">
                            <input type="text" name="cta__last-name" placeholder="Фамилия" required pattern="[A-Za-zА-Яа-яЁё]{2,}">
                            <input type="text" name="cta__name" placeholder="Имя" required pattern="[A-Za-zА-Яа-яЁё]{2,}">
                            <input type="email" name="cta__email" placeholder="Email" required>
                            <input type="text" name="cta__phone" placeholder="Телефон" required>
                            <button type="submit" class="btn" onclick="form_strong_submit(this);">Подать заявку</button>

                            <div class="cta__status cta__status--loading">
                                <div class="cta__status-body">
                                    <span class="cta__status-title">Идет отправка...</span>
                                    <div class="spinner">
                                        <div class="rect1"></div>
                                        <div class="rect2"></div>
                                        <div class="rect3"></div>
                                        <div class="rect4"></div>
                                        <div class="rect5"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="cta__status cta__status--success">
                                <div class="cta__status-body">
                                    <span class="cta__status-title"><b>Заявка успешно отправлена!</b><br>В ближайшее время Вам позвонят</span>
                                </div>
                            </div>

                            <div class="cta__status cta__status--error">
                                <div class="cta__status-body">
                                    <span class="cta__status-title"><b>Произошла ошибка!</b><br>Заявка не отправлена</span>
                                </div>
                            </div>

                            <input type="hidden" name="url" value="<?php echo get_the_permalink(); ?>">
                            <input type="hidden" name="description" value="Заявка на обучение">
                            <input type="hidden" name="type" value="default">
                            <input type="hidden" name="cat" value="заявка-на-обучение">
                            <input type="hidden" name="action" value="tbs_form">
                        </form>
                    </div>
                </div>
            </div>
        </div>

	</div>
</div>

<div class="services__main ">
	<div class="services__main__left">
        <?php
        $img_id = $Mammen->get_img( 'Изображение hover-эффект О школе', 'large' )[0]['id'];
        $img = $Mammen->get_img( 'Изображение hover-эффект О школе', 'large' )[0]['src'];
        if (!$img_id) {
	        $img = get_template_directory_uri() . '/img/services-main.png';
        }
        $img_first = $img;
        ?>
        <img src="<?php echo $img; ?>" alt="" class="img--hidden">
		<a href="#" class="services__link" data-target="services__blocks 1" data-img="<?php echo $img; ?>">
			<span>01</span>
			<span>О школе и<br>О тай массаже</span>
		</a>
		<?php
		$img_id = $Mammen->get_img( 'Изображение hover-эффект О преподавателях', 'large' )[0]['id'];
		$img = $Mammen->get_img( 'Изображение hover-эффект О преподавателях', 'large' )[0]['src'];
		if (!$img_id) {
			$img = get_template_directory_uri() . '/img/services-main.png';
		}
		?>
        <img src="<?php echo $img; ?>" alt="" class="img--hidden">
		<a href="#" class="services__link" data-target="services__blocks 2" data-img="<?php echo $img; ?>">
			<span>02</span>
			<span>О<br>преподах и</span>
		</a>
		<?php
		$img_id = $Mammen->get_img( 'Изображение hover-эффект О курсах', 'large' )[0]['id'];
		$img = $Mammen->get_img( 'Изображение hover-эффект О курсах', 'large' )[0]['src'];
		if (!$img_id) {
			$img = get_template_directory_uri() . '/img/services-main.png';
		}
		?>
        <img src="<?php echo $img; ?>" alt="" class="img--hidden">
		<a href="#" class="services__link" data-target="services__blocks 3" data-img="<?php echo $img; ?>">
			<span>03</span>
			<span>Информация <br>О курсах</span>
		</a>
		<?php
		$img_id = $Mammen->get_img( 'Изображение hover-эффект Заявка', 'large' )[0]['id'];
		$img = $Mammen->get_img( 'Изображение hover-эффект Заявка', 'large' )[0]['src'];
		if (!$img_id) {
			$img = get_template_directory_uri() . '/img/services-main.png';
		}
		?>
        <img src="<?php echo $img; ?>" alt="" class="img--hidden">
		<a href="#" class="services__link" data-target="services__blocks 4" data-img="<?php echo $img; ?>">
			<span>04</span>
			<span>Подать<br>заявку</span>
		</a>
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