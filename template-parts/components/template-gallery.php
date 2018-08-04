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
 * COMPONENT IMPLEMENTATION: Галерея
 *
 */

global $Mammen;
?>

<?php
tbs_video_style_js_init ();
?>

<div class="main">
	<div class="center">
		<div class="m"><img src="<?php echo get_template_directory_uri(); ?>/img/G.png" alt=""></div>
		<span class="s">S</span>
		<span class="t">T</span>
		<span class="b">B</span>
		<div class="container__wrap"><img src="<?php echo get_template_directory_uri(); ?>/img/border-5.png" alt=""></div>
		<div class="container__top">
            <div class="border-line border-line--30"></div>
			<h2>Галлерея</h2>
            <div class="border-line"></div>
			<div class="container__top__btns">
				<button class="gallery__btn gallery__btn--active btn" data-target="b1">Фото</button>
				<button class="gallery__btn btn" data-target="b2">Видео</button>
			</div>
		</div>
		<div class="container__bottom1">
			<div class="gallery__content__block" id="b1">

				<div class="container__bottom">
					<div class="gallery__image" style='background-image: url("<?php echo $Mammen->get_img( 'Картинки', 'large' )[0]['src'] ?>");'></div>
					<ul class="gallery__preview slider">
						<li>
							<?php
							$images = $Mammen->get_img( 'Картинки', 'large' );
							$k = 0;
							foreach ( $images as $image ) :
								++$k;
								if ( ($k % 5) == 0 AND $k ) {
									echo '</li>';
									echo '<li>';
								}
								?>
                                <div class="gallery__thumb" style='background-image: url("<?php echo $image['src'] ?>");' data-src="<?php echo $image['src'] ?>"></div>
							<?php endforeach; ?>
						</li>
					</ul>
					<div class="unslider">
						<a class="unslider-arrow prev"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
						<a class="unslider-arrow next"><img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" alt="" /></a>
					</div>
				</div>
			</div>
			<div class="gallery__content__block" id="b2">
				<div class="container__bottom1">
					<div class="container__video">
						<ul id="youtubelist">
							<?php
							$videos = $Mammen->get_fields( 'Видео' );
							if ( count( $videos ) ) {
								foreach ( $videos as $video ) {
									?>
									<li><a href="<?php echo $video->get_field('Ссылка на Youtube видео'); ?>"
									       data-url="<?php echo $video->get_field('Ссылка на Youtube видео'); ?>"><?php echo $video->get_field('Название видео'); ?></a></li>
									<?php
								}
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--<div class="gallery__content">-->
<!--	-->
<!--</div>-->