<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * MM_Component class
 *
 * @class       MM_Component
 * @version     0.0.3
 * @package     Mammen/Classes
 * @category    Class
 * @author      Mammen
 */
class MM_Component {

	/** @var array contain with declaration */
	protected $component = array(
		array( 'name' => 'Name', 'val' => '' ),
		array( 'name' => 'Thumbnail', 'val' => '/page-builder/assets/img/media-upload--thumb.png' ), // default picture
		array( 'name' => 'Preview', 'val' => '/page-builder/assets/img/media-upload--preview.jpg' ), // default picture preview
		array( 'name' => 'Global Component Rules', 'val' => '1' )
	);

	/** @var string */
	protected $file = '';

	/**
	 * Setup class
	 */
	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Init Mammen Parser
	 *
	 * Init Components from files in the directory
	 *
	 * @param  array $content
	 * @return MM_Component|false
	 */
	public function init( $content ) {
		foreach ( $content as $item ) {
			$this->str_to_component( $item );
		}
		if( $this->is_correct_component() ) {
			return $this;
		} else {
			return false;
		}
	}

	/**
	 * Builds an array with the description
	 *
	 * @param  string $content
	 * @return boolean
	 */
	protected function str_to_component( $content ) {
		if ( strpos( $content, ':' ) !== false ) {
			if ( ( preg_match( '/[\s]*(.+)[\s]*:[\s]*(.+)[\s]*/ui', $content, $matches ) ) ) {
				$matches[1] = trim( $matches[1] );
				$matches[2] = trim( $matches[2] );
				if ( $matches[1] AND $matches[2] !== '' ) {

					// Override default values
					$i = 0;
					$used = false;
					foreach ( $this->component as $component ) {
						if (
							( strtolower( $component['name'] ) == strtolower( $matches[1] ) ) AND
							( strpos( strtolower( $matches[2] ), 'group end' ) === false ) AND
							( strpos( strtolower( $matches[2] ), 'ooto end' ) === false )
						) {
							$this->component[$i]['val'] = $matches[2];
							$used = true;
						}
						++$i;
					}

					if ( !$used ) {
						if ( strpos( $matches[1], ' OPTION' ) !== false ) {

							// (Some Text) '(1)' OPTION '(name of option)'
							if ( ( preg_match( '/(.+)\s+\'(\d+)\'\s+OPTION\s+\'(.+)\'[\s]*/ui', $matches[1], $matches_option ) ) ) {
								$i = $this->position_of_param( $matches_option[1] );
								if ( $i !== false ) {
									if (
										!isset( $this->component[$i]['options'][$matches_option[2]]['options'] ) or
										!is_array( $this->component[$i]['options'][$matches_option[2]]['options'] )
									) {
										$this->component[$i]['options'][$matches_option[2]]['options'] = array();
									}
									$this->component[$i]['options'][$matches_option[2]]['options'][$matches_option[3]] = $matches[2];
								}

							// (Some Text) OPTION '(name of option)'
							} elseif ( ( preg_match( '/(.+)\s+OPTION\s+\'(.+)\'[\s]*/ui', $matches[1], $matches_option ) ) ) {
								$i = $this->position_of_param( $matches_option[1] );
								if ( $i !== false ) {
									if ( !isset( $this->component[$i]['options'] ) or !is_array( $this->component[$i]['options'] ) ) {
										$this->component[$i]['options'] = array();
									}

									$this->component[$i]['options'][$matches_option[2]] = $matches[2];

									if ( strtolower( $this->component[$i]['val'] ) == 'ooto tab' ) {
										$this->component[$i]['options']['i'] = $this->tab_position_in_ooto( $matches[2] );
										$this->tab_ooto( $matches[2], $matches_option[1] );
									}
								}
							}
						} else {

							// (Some Text) '(1)'
							if ( ( preg_match( '/(.+)\s+\'(\d+)\'/ui', $matches[1], $matches_option ) ) ) {
								$i = $this->position_of_param( $matches_option[1] );
								if ( $i !== false ) {
									if ( !isset( $this->component[$i]['options'] ) or !is_array( $this->component[$i]['options'] ) ) {
										$this->component[$i]['options'] = array();
									}
									if ( !isset( $this->component[$i]['options'][$matches_option[2]] ) or !is_array( $this->component[$i]['options'][$matches_option[2]] ) ) {
										$this->component[$i]['options'][$matches_option[2]] = array();
									}
									$this->component[$i]['options'][$matches_option[2]]['val'] = $matches[2];
								}
							} else {

								// (Some Text)
								array_push( $this->component, array( 'name' => $matches[1], 'val' => $matches[2] ) );
							}
						}
					}
				}
			}
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Fills the field names in the first tab of OOTO
	 *
	 * @param string $group
	 * @param string $name_of_field
	 * @return void
	 */
	public function tab_ooto( $group, $name_of_field ) {
		for ( $i = 0; $i < count( $this->component ); ++$i ) {
			if (
				strtolower( $this->component[$i]['val'] ) == 'ooto tab'
				AND isset( $this->component[$i]['options']['group'] )
				    AND $this->component[$i]['options']['group'] == $group
			) {
				if ( !isset( $this->component[$i]['options']['fields'] ) ) {
					$this->component[$i]['options']['fields'] = array();
				}
				array_push(
					$this->component[$i]['options']['fields'],
					$name_of_field
				);
				return;
			}
		}
	}

	/**
	 * Returned Tab position in OOTO
	 *
	 * @param string $name
	 * @return integer
	 */
	public function tab_position_in_ooto( $name ) {
		$count = 0;
		for ( $i = 0; $i < count( $this->component ); ++$i ) {
			if (
				strtolower( $this->component[$i]['val'] ) == 'ooto tab'
				AND isset( $this->component[$i]['options']['group'] )
				    AND $this->component[$i]['options']['group'] == $name ) {
				++$count;
			}
		}
		return $count;
	}

	/**
	 * Does an element contain the required fields
	 *
	 * @return boolean
	 */
	public function is_correct_component() {
		$name = false;
		$at_least_one_element = false;
		foreach ( $this->component as $item ) {
			if ( is_array( $item ) AND isset( $item['name'] ) AND isset( $item['val'] ) ) {
				if ( ( $item['name'] == 'Name' ) AND $item['val'] ) {
					$name = true;
				} elseif (
					$item['val'] !== ''
					AND $item['name'] != 'Name'
					    AND $item['name'] != 'Thumbnail'
					        AND $item['name'] != 'Preview'
					            AND $item['name'] != 'Global Component Rules'
					OR ( $item['name'] === 'Global Component Rules' AND $item['val'] != '0' )
				) {
					$at_least_one_element = true;
				}
			}
		}

		if ( $name AND $at_least_one_element ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Find parameter in $component
	 *
	 * @param  string $needle
	 * @return integer
	 */
	protected function position_of_param( $needle ) {
		$i = 0;
		foreach ( $this->component as $component ) {
			if ( strtolower( $component['name'] ) == strtolower( $needle ) ) {
				return $i;
			}
			++$i;
		}
		return false;
	}

	/**
	 * Returns component name
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->get_attr_by_name( 'Name' )['val'];
	}

	/**
	 * Returns Thumbnail link
	 *
	 * @return string
	 */
	public function get_thumbnail() {
		return $this->get_attr_by_name( 'Thumbnail' )['val'];
	}

	/**
	 * Returns Preview link
	 *
	 * @return string
	 */
	public function get_preview() {
		return $this->get_attr_by_name( 'Preview' )['val'];
	}

	/**
	 * Returns Global Component Rules 0/1
	 *
	 * @return string
	 */
	public function get_global_component_rules() {
		return $this->get_attr_by_name( 'Global Component Rules' )['val'];
	}

	/**
	 * Returns File name of component
	 *
	 * @return string
	 */
	public function get_file_name() {
		return $this->file;
	}

	/**
	 * Returns MD5 hash of file component
	 *
	 * @return string
	 */
	public function get_file_md5() {
		return md5_file( $this->file );
	}

	/**
	 * Returns component content like array
	 *
	 * @return array
	 */
	public function get_content() {
		$content = array();
		foreach ( $this->component as $item ) {
			if ( is_array( $item ) AND isset( $item['name'] ) AND isset( $item['val'] ) ) {
				if (
					$item['val'] !== ''
					AND $item['name'] != 'Name'
					    AND $item['name'] != 'Thumbnail'
					        AND $item['name'] != 'Preview'
					            AND $item['name'] != 'Global Component Rules'
				) {
					array_push( $content, $item );
				}
			}
		}
		return $content;
	}

	/**
	 * Returns name options like array
	 *
	 * @return array
	 */
	public function get_name_option() {
		foreach ( $this->component as $item ) {
			if ( is_array( $item ) AND isset( $item['name'] ) AND isset( $item['val'] ) ) {
				if (
					$item['name'] == 'Name'
				    AND isset( $item['options'] )
					    AND is_array( $item['options'] )
						    AND count( $item['options'] )
				) {
					return $item['options'];
				}
			}
		}
		return null;
	}

	/**
	 * Returns the component attribute by name
	 *
	 * @param  string $name
	 * @return array|false
	 */
	public function get_attr_by_name( $name ) {
		foreach ( $this->component as $item ) {
			if ( ( $item['name'] == $name ) ) {
				return $item;
			}
		}
		return false;
	}
}