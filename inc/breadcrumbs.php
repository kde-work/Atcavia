<?php
function atc_breadcrumbs( $post_id, $s = ' / ' ) {
	ob_start();
	?>
	<div class="breadcrumbs">
		<?php
		echo atc_breadcrumbs_template( __t( 'Главная', 'Home Page' ), 'main', '/' );
		echo "<div class=\"breadcrumbs__separator\">$s</div>";
		echo atc_breadcrumbs_template( tob_get_title( $post_id, get_the_title( $post_id ) ), $post_id, get_the_permalink( $post_id ), true );
		?>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
function atc_breadcrumbs_template( $name, $id, $link = '', $no_link = false ) {
	ob_start();
	?>
	<div class="breadcrumb breadcrumb--<?php echo $id; ?> <?php echo ( !$link OR $no_link ) ? 'breadcrumb--no-link' : ''; ?>">
		<?php
		echo ( $link ) ? "<a href=\"$link\">" : '';
		echo $name;
		echo ( $link ) ? '</a>' : '';
		?>
	</div>
	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
