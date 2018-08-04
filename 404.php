<?php get_header(); ?>


		<div class="content">
			<div class="cnt__catalog content-block">
			
                        <h2 class="cnt__h2"><?php _e( 'Станица не найдена.', 'foghorn' ); ?></h2>
              
                        <p><?php _e( 'Попробуйте воспользоваться поиском', 'foghorn' ); ?></p>
    
				<div class="cnt__ctlg__layout black-link__a">
                        <?php get_search_form(); ?>
				</div>
	
			</div><!-- .cnt__news-social -->
		</div><!-- .content -->
<?php get_footer(); ?>