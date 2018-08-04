<?php

add_action( 'wp_ajax_mammen_events', 'ajax_mammen_events' );
add_action( 'wp_ajax_nopriv_mammen_events', 'ajax_mammen_events' );
function ajax_mammen_events() {
	if ( $_POST['promotion_name'] == 'category' ) {
		$category = addslashes( $_POST['promotion_val'] );
		$date = addslashes( $_POST['promotion_friend_val'] );
	} else {
		$date = addslashes( $_POST['promotion_val'] );
		$category = addslashes( $_POST['promotion_friend_val'] );
	}
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$shortcode = "[mammen_events posts_per_page='$posts_per_page' offset='$offset'";

	if ( $category != 'All' ) {
		$shortcode .= " category='$category'";
	}

	if ( $date == 'Newest First' ) {
		$shortcode .= " orderby='date' order='ASC'";
	} elseif ( $date == 'Oldest First' ) {
		$shortcode .= " orderby='date' order='DESC'";
	} else {
		$shortcode .= " orderby='title' order='ASC'";
	}

	$return = array(
		'status' => 'ok',
		'html_desktop' => do_shortcode( $shortcode . "]" ),
		'html_tablet' => do_shortcode( $shortcode . " device='tablet']" )
	);
	echo json_encode( $return );
	die;
}