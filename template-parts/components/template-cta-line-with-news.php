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
 * COMPONENT IMPLEMENTATION: CTA Line with News
 *
 */

global $Mammen;
?>
<div class="layout under-slide">
	<div class="layout__box">
		<div class="under-slide__box">
			<div class="under-slide__our-offices our-offices">
				<div class="our-offices__map offices-map">
					<div class="offices-map__points">
						<div class="offices-map__point offices-map__point--1"></div>
						<div class="offices-map__point offices-map__point--2"></div>
						<div class="offices-map__point offices-map__point--3"></div>
						<div class="offices-map__point offices-map__point--4"></div>
						<div class="offices-map__point offices-map__point--5"></div>
						<div class="offices-map__point offices-map__point--6"></div>
						<div class="offices-map__point offices-map__point--7"></div>
						<div class="offices-map__point offices-map__point--8"></div>
						<div class="offices-map__point offices-map__point--9"></div>
						<div class="offices-map__point offices-map__point--10"></div>
						<div class="offices-map__point offices-map__point--11"></div>
						<div class="offices-map__point offices-map__point--12"></div>
						<div class="offices-map__point offices-map__point--13"></div>
						<div class="offices-map__point offices-map__point--14"></div>
					</div>
					<div class="offices-map__map"></div>
				</div>
				<div class="our-offices__cont">
					<div class="our-offices__title"><?php echo nbsp( $Mammen->get_field( ___( 'Title of Offices' ) ) ); ?></div>
					<div class="our-offices__text"><?php echo $Mammen->get_field( ___( 'Description of Offices' ) ); ?></div>
				</div>
			</div>
			<div class="under-slide__news single-news slick--single-news">
				<?php
				$news_with_mark = tob_under_slide_news();
				foreach ( $news_with_mark as $news ) {
					?>
					<div class="single-news__item single-news__item--<?php echo $news['ID']; ?>">
						<div class="single-news__categories"><?php echo tob_get_cat_list( $news['ID'] ); ?></div>
						<div class="single-news__title"><a href="<?php echo $news['guid']; ?>"><?php echo tob_get_title( $news['ID'], $news['post_title'] ); ?></a></div>
						<div class="single-news__date f--grey"><?php echo tob_get_date( $news['post_date_gmt'] ); ?></div>
					</div>
					<?php
				}
				?>
			</div>
			<div class="under-slide__cta">
				<div class="under-slide__btn btn btn--big-alpha btn-target btn-target--1 btn--scroll-btn-on-page"><?php echo nbsp( $Mammen->get_field( ___( 'Title Button' ) ) ); ?></div>
			</div>
		</div>
	</div>
</div>