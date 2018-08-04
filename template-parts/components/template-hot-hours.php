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
 * COMPONENT IMPLEMENTATION: Горячие часы
 *
 */

global $Mammen;
?>

<div class="section " id="third">

	<div class="main third slide active">
		<div class="rose"><img src="<?php echo get_template_directory_uri(); ?>/img/rose.png" alt="rose"></div>
		<div class="center">
			<span class="t">T</span>
			<span class="b">B</span>
			<div class="center__wrap__img"><img src="<?php echo get_template_directory_uri(); ?>/img/fourth.png" alt=""></div>
			<div class="center__left">
				<div class="center__left__service border-box">
					<div class="container__title">
						<h3 class="mobile">Горячие&nbsp;часы</h3>
						<h3 class="desktop">Горячие часы</h3>
					</div>
					<div class="service__data">
						<!-- <div class="service__data__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-11.png" alt=""></div> -->
						<div class="service__data__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-3.png" alt=""></div>
						<?php
						$places = tbs_list_of_cat('cdihothours-category');
						$k = 0;
						foreach ( $places as $place ) {
							++ $k;
							?>
                            <div class="slider__wraper hot-hours hot-hours--<?php echo $k; ?>">
                                <div class="unslider">
                                    <a class="unslider-arrow prev"><img
                                            src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt=""/></a>
                                    <a class="unslider-arrow next"><img
                                            src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt=""/></a>
                                </div>
                                <ul class="slider">
                                    <li>
										<?php
										$posts = tbs_list_post_by_post_type( 'hothours', $place['term_id'] );
										$k     = 0;
										foreach ( $posts as $post ) {
											if ( ( $k % 3 ) == 0 AND $k ) {
												echo '</li>';
												echo '<li>';
											}
											++ $k;

											$title     = get_the_title( $post['ID'] );
											$date      = strtotime( get_post_meta( $post['ID'], 'demo-meta-datepicker', true ) );
											$time      = get_post_meta( $post['ID'], 'demo-meta-time', true );
											$old_price = get_post_meta( $post['ID'], 'cdihothours-meta-text-old-price', true );
											$new_price = get_post_meta( $post['ID'], 'cdihothours-meta-text-new-price', true );
											?>
                                            <div class="service__data__item">
                                                <p><?php
	                                                echo date( 'd', $date ); ?>
                                                    <br><span><?php
                                                        $months = array( 1 => 'Янв' , 'Фев' , 'Март' , 'Апр' , 'Май' , 'Июнь' , 'Июль' , 'Авг' , 'Сен' , 'Окт' , 'Нояб' , 'Дек' );
                                                        $month = date( $months[date( 'n' )], $date );
		                                                echo $month;
		                                                ?></span></p>
                                                <p class="text--data"><?php echo $time; ?></p>
                                                <div class="data__item__price">
                                                    <p class="text--italic"><?php echo $title; ?></p>
                                                    <hr>
                                                    <div class="price__info">
                                                        <p class="prive__info--stock"><?php echo $old_price; ?>р</p>
                                                        <p><?php echo $new_price; ?>р</p>
                                                    </div>
                                                </div>
                                                <div class="wrap">
                                                    <?php
                                                    if (function_exists('get_fields')) {
                                                        $serv = get_fields($post['ID'], 'связанная_услуга')['связанная_услуга'];
                                                        $modal_text = str_replace(array("'", "\n", "\r", "\n\r"), ' ', strip_tags(get_post_meta( $serv->ID, 'cdiservices-meta-textarea', true )));
//                                                        print_r($serv);
                                                    }
                                                    ?>
                                                    <button class="btn" onclick="popup_c({'cat':'горячие-часы', 'title':'Записаться на горячие часы', 'subtitle':'<?php echo $title; ?>', 'modal_text':'<?php echo $modal_text; ?>', 'template': 'wide', 'email': 1, 'time': 0, 'gender': 0, 'description': 'Горячие часы. <?php echo date( 'd.m.Y', $date ) . " в $time. Название: $title. За $new_price руб. Салон: {$place['name']}"; ?>'}, this);">Записаться</button>
                                                </div>
                                            </div>
											<?php
										}
										?>
                                    </li>
                                </ul>
                            </div>
							<?php
						}
						?>

						<div class="service__salon">
							<select name="" id="" class="hot-hours__select">
                                <?php
                                $k = 0;
                                foreach ($places as $place) {
                                    ++$k;
	                                ?>
                                    <option value="<?php echo $k; ?>" <?php echo ($k == 1)?'selected':''; ?>><?php echo $place['name']; ?></option>
	                                <?php
                                }
                                ?>
							</select>
							<span class="select__button"></span>
							<p>Выбрать салон</p>
						</div>
					</div>
				</div>
			</div>
			<div class="center__right">
				<div class="center__info">
					<h3><?php echo $Mammen->get_field( 'Заголовок' ); ?></h3>
					<p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок' ); ?></p>
					<hr>
					<div class="center_info__grey"></div>
					<p><?php echo $Mammen->get_field( 'Описание' ); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>