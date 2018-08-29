<?php

function atc_is_en() {
	if ( !isset( $_SESSION['lang'] ) ) {
		session_start();
	}

	if ( empty( $_SESSION['lang'] ) ) {
		$_SESSION['lang'] = 'ru';
	}

	if ( $_SESSION['lang'] == 'en' ) {
		return true;
	}
	return false;
}
function atc_is_ru() {
	return !atc_is_en();
}
function ___( $text ) {
	if ( atc_is_en() ) {
		return "$text en";
	}
	return $text;
}
function nbsp( $text ) {
	$text = str_replace( ' ', '&nbsp', $text );
	return $text;
}
function __t( $ru, $en ) {
	if ( atc_is_en() AND $en ) {
		return $en;
	}
	return $ru;
}
function __cat_name( $cat_ID, $cat_name_ru ) {
	if ( atc_is_en() && function_exists( 'get_field' ) ) {
		$cat_name = get_field( 'category_name_en', "category_{$cat_ID}" );
		return $cat_name;
	} else {
		return $cat_name_ru;
	}
}

add_action( 'wp_ajax_change_language', 'atc_change_language' );
add_action( 'wp_ajax_nopriv_change_language', 'atc_change_language' );
function atc_change_language() {
	$lang = addslashes( $_POST['value'] );
	session_start();

	$_SESSION['lang'] = $lang;
	die;
}