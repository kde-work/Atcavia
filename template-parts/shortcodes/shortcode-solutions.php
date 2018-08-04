<?php

// Shortcode mammen_promotions
function atc_solutions ( $atts ) {
	$post_type = $cat_id = $title = $title_en = '';
	extract( shortcode_atts( array(
			'post_type' => 'solutions',
			'cat_id'    => false,
			'orderby'   => 'date',
			'title'     => '',
			'title_en'  => '',
			'order'     => 'DESC'
		), $atts )
	);
	ob_start();

	$posts = tbs_list_post_by_post_type( $post_type, $cat_id );
	$j = 0;
	if ( ! empty( $posts ) ) {
		?>
		<div class="solutions-box">
		<?php
		if ( $title ) {
			echo "<div class=\"solutions-box__title\">". __t( $title, $title_en ) ."</div>";
		}
		foreach ( $posts as $post ) {
			$j ++;
			?>
			<div class="solution-box solution-box--<?php echo $post['ID']; ?>">
				<div class="solution-box__layout">
					<div class="solution-box__title"><span><?php echo tob_get_title( $post['ID'], $post['post_title'] ); ?></span></div>
					<div class="solution-box__btn"><a href="<?php echo get_the_permalink( $post['ID'] ); ?>" class="btn btn--small-white service-box__btn"><?php
							echo __t( 'Узнать больше', 'Learn More' );
							?></a></div>
				</div>
				<div class="solution-box__bg solution-box__bg--black"></div>
				<div class="solution-box__bg solution-box__bg--img" style="background-image: url('<?php echo wp_get_attachment_image_src(get_post_thumbnail_id( $post['ID'] ), 'large', true )[0]; ?>');"></div>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
add_shortcode( 'atc_solutions', 'atc_solutions' );