<?php
function atc_load_posts(){
	$count_of_pagination = stripslashes($_POST['count_of_pagination']);
	$page = stripslashes($_POST['page']);
	echo tob_news_html( ( $count_of_pagination ) ? $count_of_pagination : 4, $page );
	die;
}

add_action('wp_ajax_atc_loadmore', 'atc_load_posts');
add_action('wp_ajax_nopriv_atc_loadmore', 'atc_load_posts');