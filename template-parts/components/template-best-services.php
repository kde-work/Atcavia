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
 * COMPONENT IMPLEMENTATION: Лучшие программы
 *
 */

global $Mammen;
?>

<div class="section active" id="second">

	<div class="main second slide">
		<div class="center startPosition">
			<div class="plus"></div>
			<span class="s">S</span>
			<span class="t">T</span>
			<span class="b"><img src="<?php echo get_template_directory_uri(); ?>/img/B.png" alt=""></span>
			<div class="flower"><img src="<?php echo get_template_directory_uri(); ?>/img/flower.png" alt=""></div>
			<div class="container border-box">
				<!-- <div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-10.png" alt=""></div> -->
				<div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border.png" alt=""></div>
				<div class="container__left">
					<div class="container__title">
						<?php $title = $Mammen->get_field( 'Заголовок' )?>
						<h2 class="mobile"><?php echo str_replace(' ', '&nbsp;', $title); ?></h2>
						<h2 class="desktop"><?php echo $title; ?></h2>
					</div>
				</div>
				<div class="container__right">
					<div class="container__slider__number">
						<span>01</span><span>/00</span>
					</div>
					<ul class="slider">
						<?php
						$posts = tbs_get_best_services();
						if ( count( $posts ) ) {
							$j = 0;
							foreach ( $posts as $post ) {
								$title              = get_the_title( $post['ID'] );
								$image_id           = get_post_meta( $post['ID'], 'cdiservices-meta-image-best', true );
								$image_url          = wp_get_attachment_image_src( $image_id, 'large' )[0];
								$image_oil_id           = get_post_meta( $post['ID'], 'cdiservices-meta-image-oil', true );
								$image_oil_url          = wp_get_attachment_image_src( $image_oil_id, 'full' )[0];
								$short_text         = get_post_meta( $post['ID'], 'cdiservices-meta-text-short', true );
								$best_text          = get_post_meta( $post['ID'], 'cdiservices-meta-textarea-best', true );
                                if (!$best_text) {
	                                $best_text      = get_post_meta( $post['ID'], 'cdiservices-meta-textarea', true );
                                }
								?>
                                <li>
                                    <div class="container__img container__img--desc"
                                         style="background-image: url('<?php echo $image_url; ?>');">
                                    </div>
                                    <h3 class="slider-up"><?php echo $title; ?></h3>
                                    <p class="text--italic slider-up"><?php echo $short_text; ?></p>
                                    <hr>
                                    <p class="slider-up"><?php echo $best_text; ?></p>
                                    <div class="wrap slider-left"><a href="<?php echo get_the_permalink($post['ID']); ?>" class="btn">Подробнее</a></div>
                                    <div class="container__slide__img slider-left"><img
                                            src="<?php 
											if (!$image_oil_id || !$image_oil_url) {
												echo get_template_directory_uri() . '/img/bottle.png';
											} else {
												echo $image_oil_url;
											}
											?>" alt="">
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
					<div class="img__tmp"></div>
				</div>
			</div>

		</div>
	</div>
</div>