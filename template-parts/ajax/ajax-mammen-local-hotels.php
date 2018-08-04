<?php

add_action( 'wp_ajax_mammen_local_hotels', 'ajax_mammen_local_hotels' );
add_action( 'wp_ajax_nopriv_mammen_local_hotels', 'ajax_mammen_local_hotels' );
function ajax_mammen_local_hotels() {
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$shortcode = "[mammen_local_hotels posts_per_page='$posts_per_page' offset='$offset' orderby='date' order='DESC'";

	$return = array(
		'status' => 'ok',
		'html_desktop' => do_shortcode( $shortcode . "]" ),
		'html_tablet' => do_shortcode( $shortcode . " device='tablet']" )
	);
	echo json_encode( $return );
	die;
}