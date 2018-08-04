<?php
/**
 * An example implementation of the component in code
 *
 * Using content of component in a custom implementation of the html
 *
 * @author Dmitry
 * @version 0.01
 * @package component
 *
 * COMPONENT IMPLEMENTATION: Reach News
 *
 */

global $Mammen;
?>

<div class="layout reach-news" data-mobile-pagination="<?php echo __t( 'Новости', 'News' ); ?>" data-theme="light">
	<div class="reach-news__abs">
		<div class="layout__box">
			<div class="reach-news__title">
				<?php echo $Mammen->get_field( ___( 'Title' ) ); ?>
			</div>
			<div class="reach-news__title-line"></div>
		</div>
	</div>
	<div class="reach-news__items slick--reach-news">
		<?php
		$posts = tob_news ( $Mammen->get_field( 'Count of news' ), 0 );
		if ( !empty($posts) ) {
			foreach ( $posts as $news ) {
				?>
                <div class="mobile__set-height">
                    <div class="reach-news__item reach-news__item--0">
                        <div class="layout__box">
                            <div class="reach-box">
                                <div class="reach-box__header"><?php echo tob_get_date( $news['post_date_gmt'] ); ?></div>
                                <div class="reach-box__body">
                                    <div class="reach-box__categories"><?php echo tob_get_cat_list( $news['ID'] ); ?></div>
                                    <div class="reach-box__title"><?php echo tob_get_title( $news['ID'], $news['post_title'] ); ?></div>
                                    <div class="reach-box__desc"><?php echo tob_get_content( $news['ID'], __t( 20, 30 ) ); ?></div>
                                    <a href="<?php echo get_the_permalink( $news['ID'] ); ?>" class="reach-box__more link--arrow-black"><?php
                                        echo __t( 'Подробнее', 'Learn More' );
                                        ?></a>
                                    <div class="reach-box__arrows">
                                        <div class="reach-box__arrow reach-box__arrow--left" data-id="prev"></div>
                                        <div class="reach-box__arrow-border"></div>
                                        <div class="reach-box__arrow reach-box__arrow--right" data-id="next"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reach-news__bg reach-news__bg--black"></div>
                        <div class="reach-news__bg reach-news__bg--img"
                             style="background-image: url('<?php
					     $thumb =  wp_get_attachment_image_src( get_post_thumbnail_id( $news['ID'] ), 'large', true )[0];
					     if ( strpos( $thumb, 'default.png' ) === false ) {
					     	echo $thumb;
					     } else {
					     	echo '/wp-content/uploads/2018/06/aircraft.jpg';
					     }
					     ?>');"></div>
				    </div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>