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
 * COMPONENT IMPLEMENTATION: Контакты
 *
 */

global $Mammen;
?>

<div class="main">
	<div class="center">
		<div class="k"><img src="<?php echo get_template_directory_uri(); ?>/img/K.png" alt=""></div>
		<span class="s">S</span>
		<span class="t">T</span>
		<span class="b">B</span>
		<div class="center__left">
			<div class="center__left__time">
				<p>Время работы</p>
				<p class="text--bold"><?php echo $Mammen->get_field('Время работы'); ?></p>
			</div>
			<div class="center__left__map"><a target="_blank" href="<?php echo $Mammen->get_field('Ссылка на карты'); ?>"><img src="<?php echo $Mammen->get_img( 'Картинка Карты', 'full' )[0]['src']; ?>" alt="map"></a></div>
		</div>
		<div class="center__right">
			<div class="center__right__block">
				<p>Наши телефоны</p>
				<?php
				$phones = $Mammen->get_fields( 'Наши телефоны' );
				if ( count( $phones ) ) {
					foreach ( $phones as $phone ) {
						?>
						<p class="text--bold"><a href="tel:<?php echo tbs_clear_phone($phone->get_field('Телефон')); ?>"><?php echo $phone->get_field('Телефон'); ?></a></p>
						<?php
					}
				}
				?>
			</div>
			<div class="center__right__block">
				<p>Наш адрес</p>
				<p class="text--bold"><?php echo $Mammen->get_field('Адрес'); ?></p>
			</div>
			<div class="center__right__block">
				<p>Email</p>
				<p class="text--italic contact__email"><a href="mailto:<?php echo $Mammen->get_field('Email'); ?>"><?php echo $Mammen->get_field('Email'); ?></a></p>
			</div>
            <div class="contact__map">
	            <?php echo $Mammen->get_field('Код карты'); ?>
            </div>
		</div>
	</div>
</div>