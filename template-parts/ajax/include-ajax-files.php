<?php

include ('ajax-mammen-promotions.php');
include ('ajax-mammen-events.php');
include ('ajax-mammen-local-hotels.php');
include ('ajax-mammen-gallery-winners.php');
include ('ajax-mammen-list.php');
include ('ajax-mammen-our-hotel.php');
include ('ajax-mammen-blog.php');


function mammen_post_ajaxurl_scripts () {
//	wp_enqueue_script('jquery-ui');
//	wp_enqueue_script('jquery-ui-datepicker');

	wp_register_script( 'mammen_promotions', get_template_directory_uri() . '/js/riverwalk/mammen_promotions.js' );
	wp_enqueue_script( 'mammen_promotions' );

	wp_register_script( 'mammen_local_hotels', get_template_directory_uri() . '/js/riverwalk/mammen_local_hotels.js' );
	wp_enqueue_script( 'mammen_local_hotels' );

	wp_register_script( 'mammen_gallery_winners', get_template_directory_uri() . '/js/riverwalk/mammen_gallery_winners.js' );
	wp_enqueue_script( 'mammen_gallery_winners' );

	wp_register_script( 'mammen_list', get_template_directory_uri() . '/js/riverwalk/mammen_list.js' );
	wp_enqueue_script( 'mammen_list' );

	wp_register_script( 'mammen_activity', get_template_directory_uri() . '/js/riverwalk/mammen_activity.js' );
	wp_enqueue_script( 'mammen_activity' );

	wp_register_script( 'mammen_hero_booking', get_template_directory_uri() . '/js/riverwalk/mammen_hero_booking.js', array( 'jquery', 'jquery-ui-datepicker' ) );
	wp_enqueue_script( 'mammen_hero_booking' );

	wp_localize_script( 'mammen_promotions', 'mammen_ajax',
		array(
			'url' => admin_url('admin-ajax.php')
		));
}
add_action('wp_enqueue_scripts', 'mammen_post_ajaxurl_scripts', 40);