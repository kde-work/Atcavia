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
			<h1 class=""><?php echo $Mammen->get_field( ___( 'Title' ) ); ?></h1>
			<?php
		}
		$count_of_pagination = $Mammen->get_field( 'Count of posts in the part' );
		?>
		<div class="text-news__grid">
			<?php echo tob_news_html( ( $count_of_pagination ) ? $count_of_pagination : 4, 0 ); ?>
            <?php
            if ( $count_of_pagination ) {
	            ?>
                <div class="text-news__pagination" data-count="<?php echo $count_of_pagination; ?>" data-current="<?php echo $count_of_pagination; ?>"></div>
	            <?php
            }
            ?>
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
