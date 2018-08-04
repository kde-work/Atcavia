<?php

add_action( 'wp_ajax_mammen_blog', 'ajax_mammen_blog' );
add_action( 'wp_ajax_nopriv_mammen_blog', 'ajax_mammen_blog' );
function ajax_mammen_blog() {
	if ( $_POST['mammen_name'] == 'category' ) {
		$category = addslashes( $_POST['mammen_val'] );
		$year = addslashes( $_POST['mammen_friend_val'] );
	} else {
		$year = addslashes( $_POST['mammen_val'] );
		$category = addslashes( $_POST['mammen_friend_val'] );
	}
	$offset = intval( $_POST['offset'] );
	$posts_per_page = intval( $_POST['posts_per_page'] );
	$shortcode = "[mammen_blog posts_per_page='$posts_per_page' offset='$offset'";

	if ( $category != 'All Articles' ) {
		$shortcode .= " category='$category'";
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