<?php

add_action( 'wp_ajax_mammen_our_hotel', 'ajax_mammen_our_hotel' );
add_action( 'wp_ajax_nopriv_mammen_our_hotel', 'ajax_mammen_our_hotel' );
function ajax_mammen_our_hotel() {
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$shortcode = "[mammen_our_hotel posts_per_page='$posts_per_page' offset='$offset'";

	$return = array(
		'status' => 'ok',
		'html_desktop' => do_shortcode( $shortcode . "]" ),
		'html_tablet' => do_shortcode( $shortcode . " device='tablet']" )
	);
	echo json_encode( $return );
	die;
}