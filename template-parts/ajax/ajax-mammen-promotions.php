<?php

add_action( 'wp_ajax_mammen_promotions', 'ajax_mammen_promotions' );
add_action( 'wp_ajax_nopriv_mammen_promotions', 'ajax_mammen_promotions' );
function ajax_mammen_promotions() {
	if ( $_POST['promotion_name'] == 'category' ) {
		$category = addslashes( $_POST['promotion_val'] );
		$date = addslashes( $_POST['promotion_friend_val'] );
	} else {
		$date = addslashes( $_POST['promotion_val'] );
		$category = addslashes( $_POST['promotion_friend_val'] );
	}
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$mammen_featured = intval( $_POST['mammen_featured'] );
	$shortcode = "[mammen_promotions posts_per_page='$posts_per_page' offset='$offset'";

	if ( $category != 'All' ) {
		$shortcode .= " category='$category'";
	}

	if ( $mammen_featured ) {
		$shortcode .= " is_featured='1'";
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