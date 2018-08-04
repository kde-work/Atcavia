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
 * COMPONENT IMPLEMENTATION: Main Slider
 *
 */

global $Mammen;
?>

<div class="layout slider" data-mobile-pagination="<?php echo __t( 'Решения', 'Solutions' ); ?>" data-theme="light">
	<div class="slider-slick">
		<?php
		$j = 0; // итерация для слайдов
		$slides = $Mammen->get_fields( 'Slide' );
		if ( count( $slides ) ) {
			foreach ( $slides as $slide ) {
				?>
				<div class="slider-slick__item slider-slick__item--<?php echo $j; ?> slide-slick mobile__set-height">
					<div class="slide-slick__layout">
						<div class="slide-slick__cont">
							<div class="slide-slick__left">
								<div class="slide-slick__title animate animate--opacity animate--small-top">
									<div>
										<div class="slide-slick__title-line slide-slick__title-line--1 animate animate--top"><div><?php echo nbsp( $slide->get_field( ___( 'Title line 1' ) ) ); ?></div></div>
										<div class="slide-slick__title-line slide-slick__title-line--2 animate animate--top"><div><?php echo nbsp( $slide->get_field( ___( 'Title line 2' ) ) ); ?></div></div>
										<div class="slide-slick__title-line slide-slick__title-line--3 animate animate--bottom animate--delay"><div><?php echo nbsp( $slide->get_field( ___( 'Title line 3' ) ) ); ?></div></div>
									</div>
								</div>
							</div>
							<div class="slide-slick__center animate animate--opacity"></div>
							<div class="slide-slick__right">
								<div class="slide-slick__desc-animate animate animate--opacity animate--small-bottom">
									<div class="slide-slick__desc"><?php echo $slide->get_field( ___( 'Description' ) ); ?></div>
								</div>
								<div class="slide-slick__btn animate animate--opacity">
									<a href="<?php echo $slide->get_field( 'Button URL' ); ?>" class="btn btn--light-blue"><?php echo $slide->get_field( ___( 'Button' ) ); ?></a>
								</div>
							</div>
						</div>
					</div>
					<div class="slide-slick__bg slide-slick__bg--black" style="<?php $bo = $slide->get_field( 'Black Overlay in percent' ); $bo = ( $bo ) ? $bo : 20; echo ( $bo !== '' ) ? 'background:rgba(0,0,0,' . ( $bo / 100 ) . ');'  : ''; ?>"></div>
					<div class="slide-slick__bg slide-slick__bg--image"
					     style="background-image: url('<?php echo $slide->get_img( 'Image', 'large' )[0]['src']; ?>');"></div>
				</div>
				<?php
				++ $j;
			}
		}
		?>
	</div>
</div>