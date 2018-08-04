<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Mammen class
 *
 * @class       Mammen
 * @version     0.0.3
 * @package     Mammen/Classes
 * @category    Class
 * @author      Mammen
 */
class Mammen {

	/**
	 * Content of Component
	 *
	 * @var array
	 */
	protected $data;

	/**
	 * Fields of Component
	 *
	 * @var array
	 */
	protected $component;

	/**
	 * Mammen Constructor
	 */
	public function __construct( $data ) {
		$this->data = $data;
		$this->component_init();
	}

	/**
	 * Returns object
	 *
	 * @param string $name
	 * @return array
	 */
	public function get_fields( $name ) {
		$group_id = false;
		$gr = 0;
		for ( $i = 0; $i < count( $this->component ); ++$i ) {
			if ( ( strtolower( $this->component[$i]['val'] ) == 'group begin' ) AND isset( $this->component[$i]['options'] ) AND isset( $this->component[$i]['options']['type'] ) AND ( strtolower( $this->component[$i]['options']['type'] ) == 'repeating group' OR strtolower( $this->component[$i]['options']['type'] ) == 'repeating meta group' ) ) {
				$gr++;
				if ( $this->component[$i]['name'] == $name ) {
					$group_id = $gr;
				}
			}
		}

		$group = array();
		if ( $group_id !== false ) {
			foreach ( $this->data as $key => $val ) {
				if ( ( preg_match( '/.*(__'.$group_id.'-(\d)).*/ui', $key, $matches ) ) ) {
					$new_key = str_replace( $matches['1'], '', $key );
					if ( !isset( $group[$matches['2']] ) OR !is_array( $group[$matches['2']] ) ) {
						$group[$matches['2']] = array();
					}
					$group[$matches['2']][$new_key] = $val;
				}
			}
			$objects = array();
			foreach ( $group as $i => $val ) {
				if ( count( $group[$i] ) ) {
					$group[$i]['component'] = $this->data['component'];
					$group[$i]['component_id'] = $this->data['component_id'];
					$objects[$i] = new Mammen( $group[$i] );
				}
			}
			return $objects;
		} else {
			return array( 0 => new Mammen( array() ) );
		}
	}

	/**
	 * Returns value of field
	 *
	 * @param string $name
	 * @return string
	 */
	public function get_field( $name ) {
		$name_ = strtolower( $name );
		if ( isset( $this->data[$name_] ) ) {
			return $this->clear_html( $this->data[$name_] );
		}

		$clear_name = MM_Component_Page::clear_name( $name );
		if ( isset( $this->data[$clear_name] ) ) {
			return $this->clear_html( $this->data[$clear_name] );
		}

		return false;
	}

	/**
	 * Returns clear html code
	 *
	 * @param string $val
	 * @return string
	 */
	public function clear_html( $val ) {
//		return $val;
		return str_replace( array( '&#44;', '&#34;', '&#91;', '&#93;', '&#39;' ), array( ',', '"', '[', ']', "'" ), $val);
	}

	/**
	 * Returns array of images
	 *
	 * @param string $name
	 * @param string $size
	 * @return array
	 */
	public function get_img( $name, $size = 'full' ) {
		$ids = str_replace( '&#44;', ',', $this->get_field( $name ) );
		$ids = explode( ',', $ids );
		$imgs = array();
		foreach ( $ids as $id ) {
			array_push(
				$imgs,
				array(
					'id' => $id,
					'src' => wp_get_attachment_image_src( $id, $size, true )[0]
				)
			);

		}
		return $imgs;
	}

	/**
	 * Returns component Name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->data['component'];
	}

	/**
	 * Returns component Slug
	 *
	 * @return string
	 */
	public function get_slug() {
		return MM_Component_Page::clear_name( $this->data['component'] );
	}

	/**
	 * Returns component Name
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->data['component_id'];
	}

	/**
	 * Initial component
	 *
	 * @return void
	 */
	protected function component_init() {
		if ( $this->get_id() > 1 ) {
			$this->component = unserialize( get_post( $this->get_id() )->post_content );
		}
	}
}