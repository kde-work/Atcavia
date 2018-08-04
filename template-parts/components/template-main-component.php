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
 * COMPONENT IMPLEMENTATION: Главный слайд
 *
 */

global $Mammen;
?>

<div class="section active" data-menuanchor="firstPage" id='first'>
	<div class="main first slide">
		<div class="flower"><img src="<?php echo get_template_directory_uri(); ?>/img/leaf.png" alt=""></div>
		<div class="t"><img src="<?php echo get_template_directory_uri(); ?>/img/T.png" alt=""></div>
		<div class="plus"></div>
		<span class="b">B</span>
		<span class="s">S</span>
		<div class="wrap--img"></div>

		<div class="bag"><img src="<?php echo get_template_directory_uri(); ?>/img/bag.png" alt=""></div>

		<div class="center desktop">
			<div class="center__left">
				<div class="center__info">
					<h3><?php echo $Mammen->get_field( 'Заголовок Контакты' )?></h3>
					<p class="phones--big"><?php echo $Mammen->get_field( 'Описание Контакты' )?></p>
                    <button class="btn btn--transparent" onclick="popup_c({'cat':'обратный-звонок', 'title':'Обратный звонок', 'email': 1, 'time': 0, 'gender': 0, 'description': 'Заказ обратного звонка'}, this);">Обратный звонок</button>
				</div>
			</div>
			<div class="center__right">
				<div class="center__info">
				</div>
                <div class="slick--slider center__info">
                    <div class="slider-cont">
                        <h3><?php echo $Mammen->get_field( 'Заголовок 1' )?></h3>
                        <p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок 1' )?></p>
                        <hr>
                        <div class="center_info__grey"></div>
                        <p><?php echo $Mammen->get_field( 'Описание 1' )?></p>
                    </div>
                    <div class="slider-cont" style="display: none;">
                        <h3><?php echo $Mammen->get_field( 'Заголовок 2' )?></h3>
                        <p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок 2' )?></p>
                        <hr>
                        <div class="center_info__grey"></div>
                        <p><?php echo $Mammen->get_field( 'Описание 2' )?></p>
                    </div>
                    <div class="slider-cont" style="display: none;">
                        <h3><?php echo $Mammen->get_field( 'Заголовок 3' )?></h3>
                        <p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок 3' )?></p>
                        <hr>
                        <div class="center_info__grey"></div>
                        <p><?php echo $Mammen->get_field( 'Описание 3' )?></p>
                    </div>
                </div>
			</div>
		</div>
		<div class="mobile first__slider">
			<div class="slick--slider">
				<div class="center__info">
					<div class="slider-cont">
						<h3><?php echo $Mammen->get_field( 'Заголовок 1' )?></h3>
						<p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок 1' )?></p>
						<div class="slider-cont__body">
							<hr>
							<div class="center_info__grey"></div>
							<p><?php echo $Mammen->get_field( 'Описание 1' )?></p>
						</div>
					</div>
				</div>
				<div class="center__info">
					<div class="slider-cont">
						<h3><?php echo $Mammen->get_field( 'Заголовок 2' )?></h3>
						<p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок 2' )?></p>
						<div class="slider-cont__body">
							<hr>
							<div class="center_info__grey"></div>
							<p><?php echo $Mammen->get_field( 'Описание 2' )?></p>
						</div>
					</div>
				</div>
				<div class="center__info">
                    <div class="slider-cont">
                        <h3><?php echo $Mammen->get_field( 'Заголовок 3' )?></h3>
                        <p class="text--italic"><?php echo $Mammen->get_field( 'Подзаголовок 3' )?></p>
                        <div class="slider-cont__body">
                            <hr>
                            <div class="center_info__grey"></div>
                            <p><?php echo $Mammen->get_field( 'Описание 3' )?></p>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>