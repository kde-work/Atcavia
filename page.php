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
            <div class="sub-content">
                <div class="sub-content__cont sister-of-scroll-content">
                    <?php
                    if ( function_exists( 'get_field' ) AND atc_is_en() AND get_field( 'description_in_english', get_the_ID() ) ) {
                        echo get_field( 'description_in_english', get_the_ID() );
                    } else {
	                    the_content();
                    }
                    ?>
	                <?php edit_post_link( 'Edit' ); ?>
                </div>
                <div class="sub-content__sidebar sidebar scroll-content">
                    <div class="sub-content__btn btn btn--big-alpha btn-target btn--shadow btn-target--1 btn--scroll-btn-on-page" onclick="popup_c({'cat':'connect-with-us', 'title':'<?php echo nbsp( __t( 'Связаться с нами', 'Get in touch' )); ?>', 'service': 1, 'description': '<?php echo nbsp( __t( 'Связаться с нами (Рукав побочной страницы)', 'Get in touch (Sidebar on sub-page)' )); ?>'}, this);"><?php echo nbsp( __t( 'Связаться с нами', 'Get&nbsp;in&nbsp;touch' )); ?></div>
                    <?php
                    if ( function_exists( 'get_field' ) AND get_field( 'our_specialists_block', get_the_ID() ) ) {
	                    ?>
                        <div class="sidebar__our_specialists">
		                    <?php
                            $solution = get_field( 'default_service', get_the_ID() );
                            echo do_shortcode( "[atc-contact-form solution='$solution']" );
                            ?>
                        </div>
	                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ( function_exists( 'get_field' ) ) {
        if ( get_field( 'enable_other_solutions', get_the_ID() ) ) {
            $solutions = get_field( 'solutions', get_the_ID() );
            if ( !empty( $solutions ) ) {
                ?>
                <div class="layout other-solutions">
                    <div class="layout__box">
                        <?php
                        $ids = '';
                        foreach ( $solutions as $solution ) {
                            $ids .= "{$solution->ID},";
                        }
                        if ( strlen( $ids ) > 2 ) {
                            $ids = substr( $ids, 0, -1 );
                            echo do_shortcode("[atc_solutions title=\"Другие решения\" title_en=\"Other Solutions\" ids=\"$ids\"]");
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
        }
    }
    ?>
<?php get_footer(); ?>