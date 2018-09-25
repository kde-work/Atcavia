<?php
	
//создание шорткода, который выводит что-угодно 
add_shortcode( 'my_content', 'get_my_content' ); 
function get_my_content( $atts ){
	// Извлекаем параметры из шорткода
	extract( shortcode_atts( array(
			'page_id' => '0'
		), $atts )
	);
	$slide_page = get_post($page_id);
	ob_start(); 

	echo do_shortcode($slide_page->post_content); 
	
	if( current_user_can( 'edit_posts' ) ) {
			echo '<a href="'. get_edit_post_link($page_id) .'">Изменить</a>';
		}

	wp_reset_postdata(); 
	
	$output = ob_get_contents(); // $output == "blabla"
	ob_end_clean(); // втихую отбрасывает содержимое буфера
	return $output;
}