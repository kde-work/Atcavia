<?php
function atc_mce_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter('mce_buttons', 'atc_mce_buttons');


// Функция вызова фильтра для настроек MCE
function atc_mce_before_init_insert_formats( $init_array ) {
	$style_formats = array(
		// Каждый дочерний элемент  - формат со своими собственными настройками
		array(
			'title' => 'Regular Text',
			'block' => 'span',
			'classes' => 'regular-text',
			'wrapper' => true,
		),
		array(
			'title' => 'Big Text Thin',
			'block' => 'span',
			'classes' => 'big-text-thin',
			'wrapper' => true,
		),
		array(
			'title' => 'Big Text Bold',
			'block' => 'span',
			'classes' => 'big-text-bold',
			'wrapper' => true,
		),
		array(
			'title' => 'Big Text Bolder',
			'block' => 'span',
			'classes' => 'big-text-bolder',
			'wrapper' => true,
		),
		array(
			'title' => 'Title small',
			'block' => 'span',
			'classes' => 'title-small',
			'wrapper' => true,
		),
		array(
			'title' => 'Very Big',
			'block' => 'span',
			'classes' => 'very-big',
			'wrapper' => true,
		),
		array(
			'title' => 'Clear floating',
			'block' => 'span',
			'classes' => 'clear',
			'wrapper' => true,
		)
	);
	// Вставляем массив, JSON ENCODED, в 'style_formats'
	$init_array['style_formats'] = json_encode( $style_formats );
	return $init_array;
}
add_filter( 'tiny_mce_before_init', 'atc_mce_before_init_insert_formats' );

function atc_theme_add_editor_styles() {
	add_editor_style( 'css/fonts.css' );
	wp_enqueue_style( "fonts-admin", get_bloginfo('stylesheet_directory')."/css/fonts.css" );
}
add_action( 'current_screen', 'atc_theme_add_editor_styles' );
add_action( 'wp_enqueue_scripts', 'atc_theme_add_editor_styles' );