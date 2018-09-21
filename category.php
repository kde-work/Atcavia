<?php get_header(); ?>
<?php
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
?>
    <div class="layout single-title">
        <div class="layout__box">
            <h1><?php echo __t( 'Категория: ', 'Category: ' ); ?><?php echo __cat_name( $category_id, single_cat_title( '', false ) ); ?></h1>
        </div>
    </div>
    <div class="layout single-content single-content--wide">
        <div class="layout__box">
            <div class="sub-content">
                <div class="sub-content__cont">
                    <div class="text-news__grid">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="text-news__item text-news__item--<?php echo get_the_ID(); ?>">
                                <div class="text-news__categories"><?php echo tob_get_cat_list( get_the_ID() ); ?></div>
                                <div class="text-news__title"><a href="<?php echo get_the_permalink(); ?>"><?php echo tob_get_title( get_the_ID(), get_the_title() ); ?></a></div>
                                <div class="text-news__date f--grey"><?php echo tob_get_date( get_the_date() ); ?></div>
                                <a href="<?php echo get_the_permalink(); ?>" class="text-news__more"><?php
                                    echo __t( 'Подробнее', 'Learn More' );
                                    ?></a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layout page-numbers">
        <div class="layout__box">
	        <?php if( function_exists( 'wp_page_numbers' ) ) : wp_page_numbers(); endif; ?>
        </div>
    </div>
<?php get_footer(); ?>