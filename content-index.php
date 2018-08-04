<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Foghorn
 * @since Foghorn 0.1
 */
?>

	<div class="content-wrap">

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<table class="table-statyi">
		<tr> 
		<td width="40%" >
    	<?php if( has_post_thumbnail() ) { ?>
    	<div class="post-thumbnail">
    		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('Permanent Link to', 'foghorn'); ?> <?php the_title_attribute(); ?>"><?php the_post_thumbnail('multiple-thumb'); ?></a>
            <?php if ( is_sticky() ) { ?>
				<span class="entry-format"><?php _e( 'Featured', 'foghorn' ); ?></span>
			<?php } ?>
        </div>
        <?php } ?>
        
        </td>
		<td>
        <div<?php if( has_post_thumbnail() ) { ?> class="post-wrap"<?php } ?>>
		<header class="entry-header ">
        	<h1 class="entry-title h1-statyi"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foghorn' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<div class="entry-meta">
				<?php
				printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a>', 'foghorn' ),
                    esc_url( get_permalink() ),
                    esc_attr( get_the_time() ),
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() )
                );
				
                ?>
				<?php edit_post_link( 'Редактировать' ); ?>
            </div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-summary">
			<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'foghorn' ) ); ?>
		</div><!-- .entry-summary -->

		</td>
		</tr>
		</table>
        </div>
	</article><!-- #post-<?php the_ID(); ?> -->
    </div>