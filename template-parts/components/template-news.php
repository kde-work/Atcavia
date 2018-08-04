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
 * COMPONENT IMPLEMENTATION: News
 *
 */

global $Mammen;
?>

<div class="layout text-news">
	<div class="layout__box">
		<?php
		if ( $Mammen->get_field( ___( 'Title' ) ) ) {
			?>
			<div class="text-news"><?php echo $Mammen->get_field( ___( 'Title' ) ); ?></div>
			<?php
		}
		?>
		<div class="text-news__grid">
			<?php echo tob_news_html( 4, 0 ); ?>
			<div class="text-news__pagination" data-count="" data-current="0"></div>
		</div>
		<?php
		if ( $Mammen->get_field( 'Button Link' ) ) {
			?>
			<div class="text-news__all-news">
				<a href="<?php echo $Mammen->get_field( 'Button Link' ); ?>"><?php echo $Mammen->get_field( ___( 'Button Text' ) ); ?></a>
			</div>
			<?php
		}
		?>
	</div>
</div>
