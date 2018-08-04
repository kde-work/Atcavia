<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */

get_header(); ?>

		<div class="content">
			<div class="cnt__catalog content-block">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h2 class="cnt__h2"><?php printf( __( '%s', 'foghorn' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				</header>
				<div class="cnt__ctlg__layout blue-link__a">

				<?php foghorn_content_nav( 'nav-above' ); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', 'index' );
					?>

				<?php endwhile; ?>

				<?php foghorn_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Ничего не нашлось', 'foghorn' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Попробуйте поискать оп другим словам. Либо свяжитесь с нами по телефонам.', 'foghorn' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

				</div>
			</div><!-- .cnt__news-social -->
		</div><!-- .content -->

<?php get_footer(); ?>