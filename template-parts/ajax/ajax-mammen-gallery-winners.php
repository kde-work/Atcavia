<?php

add_action( 'wp_ajax_mammen_gallery_winners', 'ajax_mammen_gallery_winners' );
add_action( 'wp_ajax_nopriv_mammen_gallery_winners', 'ajax_mammen_gallery_winners' );
function ajax_mammen_gallery_winners() {
	$month = addslashes( $_POST['month'] );
	$year = addslashes( $_POST['year'] );
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$shortcode = "[mammen_gallery_winners posts_per_page='$posts_per_page' offset='$offset'";

	if ( $month != 'All' ) {
		$shortcode .= " month='$month'";
	}

	if ( $year != 'All' ) {
		$shortcode .= " year='$year'";
	}

	$return = array(
		'status' => 'ok',
		'html_desktop' => do_shortcode( $shortcode . "]" ),
		'html_tablet' => do_shortcode( $shortcode . " device='tablet']" ),
		'shortcode' => $shortcode . "]"
	);
	echo json_encode( $return );
	die;
}