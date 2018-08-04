<?php
/**
 * An example implementation of the component in code
 *
 * Using content of component in a custom implementation of the html
 *
 * @author Dmitry
 * @version 0.02
 * @package component
 *
 * COMPONENT IMPLEMENTATION: Test
 *
 */

global $Mammen;
?>

<div class="component component--<?php echo $Mammen->get_slug(); ?> component--<?php echo $Mammen->get_field( 'Upper gutter' ); ?>">
	<div class="component__slider">
		<?php
$slider = $Mammen->get_fields( 'Slider' );
if ( count( $slider ) ) {
	foreach ( $slider as $slide ) {
				?>
				<div class="slide">

					<div class="texts">
						<?php
						$group2 = $Mammen->get_fields( 'Group 2' );
						if ( count( $group2 ) ) {
							foreach ( $group2 as $group2_item ) :
								?>
								<p><?php echo $group2_item->get_field( 'Copy 2' ); ?></p>
							<?php
							endforeach;
						}
						?>
					</div>

					<div class="image">
						<img src="<?php echo $slide->get_img( 'Image', 'medium' )[0]['src']; ?>" alt="" class="image-id--<?php echo $slide->get_img( 'Image', 'medium' )[0]['id']; ?>">
					</div>

					<div>
						<?php
$images = $slide->get_img( 'Image Multiple', 'medium' );
foreach ( $images as $image ) :
	?>
	<img src="<?php echo $image['src']; ?>" alt="" class="image-id--<?php echo $image['id']; ?> align-<?php echo $slide->get_field( 'Image Alignment Option' ); ?>">
<?php endforeach; ?>
					</div>

					<div>
						<?php echo $slide->get_field( 'Copy wysiwyg' ); ?>
					</div>

					<?php
					if ( $slide->get_field( 'Another Checkbox' ) ) :
					?>
					<div>
						<?php echo $slide->get_field( 'Copy' ); ?>
					</div>
					<?php
					endif;
					?>

					<div>
						<?php echo $slide->get_field( 'My select' ); ?>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
	<div>
		<?php echo $Mammen->get_field( 'My first multiple select' ); ?>
	</div>
</div>