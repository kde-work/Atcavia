<?php

// Shortcode mammen_promotions
function mammen_blog ( $atts ) {
	extract( shortcode_atts( array(
			'category'       => '',
			'year'           => '',
			'offset'         => 0,
			'posts_per_page' => 12,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'device'         => 'desktop'
		), $atts )
	);
	ob_start();

	$args = array(
		'post_type' => 'post',
		'posts_per_page' => $posts_per_page,
		'post_status' => 'publish',
		'orderby'  => $orderby,
		'order' => $order,
		'offset' => $offset,
		'year' => $year,
		'category_name' => $category
	);

	$args_all = array(
		'post_type' => 'post',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'offset' => $offset,
		'year' => $year,
		'category_name' => $category
	);

	$the_query = new WP_Query( $args );
	$the_query_all = new WP_Query( $args_all );
	$is_max = 0;
	if ( count( $the_query_all->posts ) <= ( $posts_per_page + $offset ) ) {
		$is_max = 1;
	}
    if ( $the_query->have_posts() ) {
        ?>
        <div class="row m-btm-40 w-row">
        <?php

        $the_query->the_post();
        $j = 0;
        foreach ($the_query->posts as $posts) {
            if ( $device == 'desktop' ) {
                if ( ($j % 3) == 0 AND $j ) {
                    echo '</div>';
                    echo '<div class="row m-btm-40 w-row">';
                }
                $j++;
                ?>
                <div class="col w-col w-col-4">
                <?php
            } else {
                if ( ($j % 2) == 0 AND $j ) {
                    echo '</div>';
                    echo '<div class="row m-btm-40 w-row">';
                }
                $j++;
                ?>
                <div class="col w-col w-col-6">
                <?php
            }
            ?>
                    <div class="card-wrap" data-count="<?php echo $is_max; ?>">
                        <a href="<?php echo get_the_permalink( $posts->ID ); ?>" class="card-img-link-block w-inline-block">
                            <div style="background-image: url(<?php echo wp_get_attachment_image_src( get_post_thumbnail_id( $posts->ID ), 'middle', true )[0]; ?>);" class="card-img blog__thumbnail"></div>
                        </a>
                        <div class="card-title-block">
                            <h3 class="card-title"><?php echo get_the_title( $posts->ID ); ?></h3>
                            <p class="card-text sub"><?php echo get_the_date( 'F j ', $posts->ID ); ?>, <a href="/news/?m_year=<?php echo get_the_date( 'Y', $posts->ID ); ?>" class="blog-archive-link"><?php echo get_the_date( 'Y', $posts->ID ); ?></a> | <?php
                                foreach( get_the_category( $posts->ID ) as $category1 ){
                                    echo "<a href='/news/?m_cat={$category1->cat_name}' class=\"category-link\">{$category1->cat_name}</a> ";
                                }

                                ?></p>
                            <p class="card-text"><?php echo wp_trim_words( get_post( $posts->ID )->post_content, 18, '…' ); ?></p>
                            <div class="card-action-block"><a href="<?php echo get_the_permalink( $posts->ID ); ?>" class="card-secondary-btn w-button">Read More</a></div>
                        </div>
                    </div>
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
add_shortcode( 'mammen_blog', 'mammen_blog' );