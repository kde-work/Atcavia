<?php get_header(); ?>

<div class="layout--static single">

    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->
        <div class="entry-content">
            <?php the_content(); ?>
            <?php edit_post_link( 'Редактировать' ); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( '<span>Pages:</span>', 'foghorn' ), 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->
        <div class="post-date"><span class="sep">Размещено: </span><time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" pubdate><span class="month"><?php echo get_the_date('M'); ?> </span><span class="day"><?php echo get_the_date('d'); ?><span class="sep">, </span></span><span class="year"><?php echo get_the_date('Y'); ?></span></time></div>
        <div id="author-info">
            <div id="author-avatar">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ), 68 ); ?>
            </div><!-- #author-avatar -->
            <div id="author-description">
                 Автором: <?php the_author(); ?>
            </div><!-- #author-description -->
        </div><!-- #entry-author-info -->
    </article><!-- #post-<?php the_ID(); ?> -->

    <footer class="entry-meta">
        
        <?php $categories_list = get_the_category_list( __( ', ', 'foghorn' ) );
if ( '' != $categories_list ) { ?>
        <div class="categories">
            <span>Категория:</span> <?php echo $categories_list; ?>
        </div>
        <?php } ?>
        <?php $tag_list = get_the_tag_list( '', ', ' );
if ( '' != $tag_list ) { ?>
        <div class="tags">
            <span>Tagged:</span> <?php echo $tag_list; ?>
        </div>
        <?php } ?>
    </footer><!-- .entry-meta -->

        <?php comments_template( '', true ); ?>

    <?php endwhile; // end of the loop. ?>
                
</div>
<?php get_footer(); ?>