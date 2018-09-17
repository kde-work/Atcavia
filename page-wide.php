<?php
/*
Template Name: Wide
*/
?>
<?php get_header(); ?>
<?php the_post(); ?>
<?php
if ( function_exists( 'get_field' ) AND atc_is_en() AND get_field( 'description_in_english', get_the_ID() ) ) {
	echo get_field( 'description_in_english', get_the_ID() );
} else {
	the_content();
}
?>
<?php edit_post_link( 'Edit' ); ?>
<?php
get_footer();

