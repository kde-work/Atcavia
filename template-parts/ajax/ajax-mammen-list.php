<?php

add_action( 'wp_ajax_mammen_list', 'ajax_mammen_list' );
add_action( 'wp_ajax_nopriv_mammen_list', 'ajax_mammen_list' );
function ajax_mammen_list() {
	if ( $_POST['mammen_name'] == 'category' ) {
		$category = addslashes( $_POST['mammen_val'] );
		$date = addslashes( $_POST['mammen_friend_val'] );
	} else {
		$date = addslashes( $_POST['mammen_val'] );
		$category = addslashes( $_POST['mammen_friend_val'] );
	}
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$type = htmlspecialchars( $_POST['mammen_type'] );
	$shortcode = "[mammen_list type='$type' posts_per_page='$posts_per_page' offset='$offset'";

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
		'html_tablet' => do_shortcode( $shortcode . " device='tablet']" ),
		'shortcode' => $shortcode . "]"
	);
	echo json_encode( $return );
	die;
}