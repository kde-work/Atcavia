<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * MM_Component class
 *
 * @class       MM_Mammen_Shortcode
 * @version     0.0.3
 * @package     Mammen/Classes
 * @category    Class
 * @author      Mammen
 */
class MM_Shortcodes {

	/**
	 * Handler of Mammen Shortcode
	 *
	 * @param  array $params
	 * @return void
	 */
	public static function Mammen( $params ) {
		$params['component_id'] = MM_Component_Builder::get_component_id_by_name( $params['component'] );
		if ( $params['component_id'] ) {
			global $Mammen;

			$Mammen = new Mammen( $params );

			$path = get_post_meta( $Mammen->get_id(), 'template_file', 1 );
			if ( file_exists( $path ) ) {
				include( $path );
			}
		}
	}
}