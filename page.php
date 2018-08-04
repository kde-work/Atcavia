<?php get_header(); ?>
<? the_post(); ?>

    <div class="layout breadcrumbs-layout">
        <div class="layout__box">
			<?php
			if(function_exists('atc_breadcrumbs'))
			{
				echo atc_breadcrumbs( get_the_ID() );
			}
			?>
        </div>
    </div>
    <div class="layout single-title">
        <div class="layout__box">
            <h1><?php echo tob_get_title( get_the_ID(), get_the_title() ); ?></h1>
        </div>
    </div>
    <div class="layout single-content">
        <div class="layout__box">
			<?php the_content(); ?>
			<?php edit_post_link( 'Edit' ); ?>
        </div>
    </div>

<?php get_footer(); ?>