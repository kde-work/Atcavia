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
 * COMPONENT IMPLEMENTATION: Tabs Services
 *
 */

global $Mammen;
?>
<div class="layout services video-start-on-scroll" data-mobile-pagination="<?php echo __t( 'Услуги', 'Services' ); ?>" data-theme="dark">
	<div class="layout__box">
		<div class="services__box">
			<div class="services__left">
				<div class="services__title"><?php echo nbsp( $Mammen->get_field( ___( 'Title' ) ) ); ?></div>
				<div class="services__desc"><?php echo $Mammen->get_field( ___( 'Description' ) ); ?></div>
				<a class="services__link" href="<?php echo $Mammen->get_field( 'Button link' ); ?>"><?php echo nbsp( $Mammen->get_field( ___( 'Button' ) ) ); ?></a>
				<div class="services__tabs service-tabs">
					<?php
					$j = 0; // итерация для табов
					$tabs = $Mammen->get_fields( 'Tabs' );
					if ( count( $tabs ) ) {
						foreach ( $tabs as $tab ) {
							?>
							<div class="service-tabs__item service-tabs__item--<?php echo $j; ?> <?php echo ( $j === 0 ) ? 'service-tabs__item--active' : ''; ?>"
							     data-id="<?php echo $j; ?>">
								<div class="service-tabs__icon service-tabs__icon--def"
								     style="background-image: url('<?php echo $tab->get_img( 'Tab Icon Dark', 'large' )[0]['src']; ?>');"></div>
								<div class="service-tabs__icon service-tabs__icon--hover"
								     style="background-image: url('<?php echo $tab->get_img( 'Tab Icon Light', 'large' )[0]['src']; ?>');"></div>
								<img src="<?php echo $tab->get_img( 'Tab Icon Dark', 'large' )[0]['src']; ?>" class="preload">
								<img src="<?php echo $tab->get_img( 'Tab Icon Light', 'large' )[0]['src']; ?>" class="preload">
								<div class="service-tabs__title"><?php echo nbsp( $tab->get_field( ___( 'Tab Title' ) ) ); ?></div>
							</div>
							<?php
							$j++;
						}
					}
					?>
				</div>
			</div>
			<div class="services__right service-box">
				<?php
				$j = 0; // итерация для табов
				if ( count( $tabs ) ) {
					foreach ( $tabs as $tab ) {
						?>
						<div class="service-box__item service-box__item--<?php echo $j; ?> <?php echo ( $j === 0 ) ? 'service-box__item--active' : ''; ?>" data-id="<?php echo $j; ?>">
							<div class="service-box__cont">
								<div class="service-box__title desktop"><?php echo nbsp( $tab->get_field( ___( 'Right Title' ) ) ); ?></div>
								<div class="service-box__title mobile"><?php echo $tab->get_field( ___( 'Right Title' ) ); ?></div>
								<div class="service-box__desc"><?php echo $tab->get_field( ___( 'Right Description' ) ); ?></div>
								<a href="<?php echo $tab->get_field( ___( 'Right Button link' ) ); ?>" class="service-box__btn btn btn--small-white"><?php echo nbsp( $tab->get_field( ___( 'Right Button' ) ) ); ?></a>
							</div>
							<div class="service-box__bg service-box__bg--black" style="<?php $bo = $tab->get_field( 'Black Overlay in percent' ); $bo = ( $bo ) ? $bo : 20; echo ( $bo !== '' ) ? 'background:rgba(0,0,0,' . ( $bo / 100 ) . ');'  : ''; ?>"></div>
							<?php
							$video = $tab->get_field( 'Video' );
							if ( !$video ) {
								?>
			                    <div class="service-box__bg service-box__bg--img" style="background-image: url('<?php echo $tab->get_img( 'Image', 'large' )[0]['src']; ?>');"></div>
								<?php
							} else {
								?>
								<div class="service-box__bg service-box__bg--video">
                                    <div class="service-box__bg service-box__bg--img" style="background-image: url('<?php echo $tab->get_img( 'Image for Mobile', 'large' )[0]['src']; ?>');"></div>
									<video height="110%" loop>
										<source src="<?php echo $video; ?>"
										        type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
									</video>
								</div>
							<?php
							}
							?>
						</div>
						<?php
						$j++;
					}
				}
				?>
			</div>
		</div>
	</div>
</div>