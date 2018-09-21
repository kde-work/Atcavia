<?php

require 'inc/translate.php';
require 'inc/services.php';
require 'inc/breadcrumbs.php';
require 'inc/tinymce-extend.php';
require 'template-parts/shortcodes/include-shortcode-files.php';
require 'inc/form.php';
require 'inc/ajax-pagination.php';

// Initial Mammen Page Builder Setup
require get_template_directory() . '/page-builder/page-builder.php';

// session init
atc_is_en();

add_image_size( 'large-2000', 2000, 800 );

// Переменная для ajax и js/css файлы
function ajaxurl_scripts () {
    wp_localize_script( 'jquery', 'ajaxurl',
                       array(
                           'url' => admin_url('admin-ajax.php')
                       ));

	$v = '0.013';

    wp_enqueue_script( "jquery" );

    wp_register_script( 'fix', get_template_directory_uri() . '/js/fix.js' );
    wp_enqueue_script( 'fix' );

    wp_register_script( 'slick', get_template_directory_uri() . '/js/slick.js' );
    wp_enqueue_script( 'slick' );
    
    wp_register_script( 'plugins', get_template_directory_uri() . '/js/plugins.js' );
    wp_enqueue_script( 'plugins' );

	wp_register_script( 'slick-mobile-page', get_template_directory_uri() . '/js/slick-mobile-page.js', array(), $v );
	wp_enqueue_script( 'slick-mobile-page' );

    wp_register_script( 'ajax-pagination', get_template_directory_uri() . '/js/ajax-pagination.js', array(), $v );
    wp_enqueue_script( 'ajax-pagination' );

    wp_register_script( 'main', get_template_directory_uri() . '/js/main.js', array(), $v );
    wp_enqueue_script( 'main' );

    wp_register_script( 'mobile-fixes', get_template_directory_uri() . '/js/mobile-fixes.js', array(), $v );
    wp_enqueue_script( 'mobile-fixes' );
    
//    wp_register_script('form', get_template_directory_uri() . '/js/form.js');
//    wp_enqueue_script('form');


    wp_register_style( 'normalize',  get_template_directory_uri() . '/css/normalize.css' );
    wp_enqueue_style( 'normalize' );

    wp_register_style( 'slick',  get_template_directory_uri() . '/css/slick.css' );
    wp_enqueue_style( 'slick' );

    wp_register_style( 'main',  get_template_directory_uri() . '/css/main.css', array(), $v );
    wp_enqueue_style( 'main' );

    wp_register_style( 'media-t',  get_template_directory_uri() . '/css/media.css', array(), $v );
    wp_enqueue_style( 'media-t' );

    wp_register_style( 'fonts',  get_template_directory_uri() . '/css/fonts.css' );
    wp_enqueue_style( 'fonts' );
}
add_action( 'wp_enqueue_scripts', 'ajaxurl_scripts', 40 );


// убрать непонятные ссылки для Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'rsd_link');

// отключить вывод мета тэга "generator"
remove_action( 'wp_head', 'wp_generator' );

// скрыть версию WordPress
function gb_hide_wp_ver()
{
    return '';
}
add_filter( 'the_generator','gb_hide_wp_ver ');

function foghorn_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'foghorn' ),
		'id' => 'sidebar',
		'description' => __( 'The right sidebar for posts and pages.', 'foghorn' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="widget-title">',
		'after_title' => '</div>',
	) );
}
add_action( 'widgets_init', 'foghorn_widgets_init' );

add_action( 'after_setup_theme', 'foghorn_setup' );
function foghorn_setup() {
	// Styles the visual editor with editor-style.css to match the theme style
	add_editor_style();

	add_theme_support( 'custom-logo', array(
		'height'      => 64,
		'width'       => 345,
		'flex-height' => true,
		'flex-width'  => true
	) );

	// Adds theme support for thumbnails
	add_theme_support( 'post-thumbnails' );
}