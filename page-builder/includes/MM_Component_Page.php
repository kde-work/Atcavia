<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * MM_Component class
 *
 * @class       MM_Component_Page
 * @version     0.0.3
 * @package     Mammen/Classes
 * @category    Admin
 * @author      Mammen
 */
class MM_Component_Page {

	/** @var integer $html_id */
	private $html_id = 0;

	/** @var string */
	private $class__field = 'mm-single-com__field';

	/** @var integer Current component ID */
	private $id;

	/** @var array Array of fields of Component */
	private $array_of_fields = array();

	/** @var array of Flags of Repeating Groups */
	private $repeating_group = array();

	/** @var integer id of Tab Group */
	private $ajax_tab = false;

	/** @var integer id of Group ID */
	private $group_name = false;

	/**
	 * Setup class
     *
	 * @param integer $id
	 */
	public function __construct( $id ) {
		$this->id = $id;
	}

	/**
	 * Returned $this->array_of_fields
	 *
	 * @return array
	 */
	public function get_array_of_fields() {
	    return $this->array_of_fields;
	}

	/**
	 * Display Tab (Repeating Group)
	 *
	 * @param object $component
	 * @param integer $group_id
	 * @param integer $id_tab
	 * @param array $register_fields
	 * @param array $group_tab
	 * @return string
	 */
	public function get_tab( $component, $group_id, $id_tab, $register_fields, $group_tab ) {
		ob_start();
		$this->array_of_fields = array_merge($register_fields, $this->array_of_fields);
		$contents = unserialize( $component->post_content );
        $contents_tab = array();
        $count_of_groups = 0;
        $this->ajax_tab = $id_tab;
        $is_correct = false;
        $first_touch = false;
        $is_last = false;
        $group_name = '';
		for ( $i = 0; $i < count( $contents ); ++$i ) {
			if ( strtolower( $contents[$i]['val'] ) == 'group begin' AND strtolower( $contents[$i]['options']['type'] ) == 'repeating group' ) {
                $parent = $this->current_group();
			    $count_of_groups++;

                if ( $count_of_groups == $group_id ) {
                    array_push(
                        $this->repeating_group,
                        array(
                            'parent' => $parent,
                            'name' => $contents[$i]['name'],
                            'tab' => $id_tab,
                            'flag' => true
                        )
                    );
                    $this->group_name = $contents[$i]['name'];
                    $group_name = $contents[$i]['name'];
                    $is_correct = true;
                    $first_touch = true;
                } else {
                    if ( $is_correct ) {
			            array_push( $contents_tab, $contents[$i] );
                    } else {
                        if (!$is_last) {
                            array_push(
                                $this->repeating_group,
                                array(
                                    'parent' => $parent,
                                    'name' => $contents[$i]['name'],
                                    'tab' => $group_tab[$count_of_groups],
                                    'flag' => true
                                )
                            );
                        }
                    }
                }
			} elseif ( strtolower( $contents[$i]['val'] ) == 'group end' ) {
			    if ( $group_name == $contents[$i]['name'] ) {
                    $is_correct = false;
                    $is_last = true;
			    } else {
			        $repeating_group = $this->is_repeating_group( $contents[$i]['name'] );
                    if ( $repeating_group !== false AND ( $is_correct AND !$first_touch ) ) {
                        $this->repeating_group[$repeating_group]['flag'] = false;
                    }

                    $this->group_end_field( $contents[$i], true );
                    if ( $is_correct ) {
			            array_push( $contents_tab, $contents[$i] );
                    }
			    }
			} elseif ( $is_correct ) {
                array_push( $contents_tab, $contents[$i] );
			}
		}

		// setup 'flag' in true for parents of main tab
//		TB::m($this->repeating_group);
//        print_r($this->repeating_group);
        $link = $group_id-1;
//		TB::m($this->repeating_group[$link]['parent']);
		while ($this->repeating_group[$link]['parent']) {
		    $link = $this->repeating_group[$link]['parent'];
            $this->repeating_group[$link]['flag'] = true;
		}
//		TB::m($this->repeating_group);
        echo $this->get_fields( $contents_tab, true );
		return ob_get_clean();
	}

	/**
	 * Display html code
	 *
	 * @param object $component
	 * @param object $settings
	 * @return string
	 */
	public function content( $component, $settings ) {
		ob_start();
		?>
		<div class="mm-modal mm-modal--component mm-modal--<?php echo $component->ID; ?> mm-modal--<?php echo self::clear_name( $component->post_title ); ?>" data-edit="-1" data-id="<?php echo $component->ID; ?>">
			<div class="mm-modal__content">
				<div class="mm-single-com mm-single-com--<?php echo $component->ID; ?>" data-id="<?php echo $component->ID; ?>" data-slug="<?php echo self::clear_name( $component->post_title ); ?>" data-name="<?php echo $component->post_title; ?>">
					<div class="mm-modal__header">
						<div class="mm-modal__title"><?php echo $component->post_title; ?></div>
						<div class="mm-modal__close close_modal">
							<img src="<?php echo MM_ASSETS_REL_DIR; ?>/img/cross.svg" alt="x" class="close-icon">
						</div>
					</div>
					<div class="mm-modal__body">
						<div class="mm-modal__body-inner mm-single-com">
                            <?php
                            if ( get_post_meta( $component->ID, 'global_component_rules', 1 ) ) :
                            ?>
							<div class="mm-single-com__section mm-single-com__section--settings">
								<div class="mm-single-com__title">
									<div class="mm-single-com__icon">
										<img class="modal-icon" src="<?php echo MM_ASSETS_REL_DIR; ?>/img/settings.svg">
									</div>
									<div class="mm-single-com__label">Settings</div>
								</div>
								<div class="mm-single-com__form">
									<?php
                                    echo $this->get_fields( $settings );
									?>
								</div>
							</div>
                            <?php
                            endif;
                            ?>
							<div class="mm-single-com__section mm-single-com__section--content">
								<div class="mm-single-com__title">
									<div class="mm-single-com__icon">
										<img class="modal-icon" src="<?php echo MM_ASSETS_REL_DIR; ?>/img/content.svg">
									</div>
									<div class="mm-single-com__label">content</div>
								</div>
								<div class="mm-single-com__form">
									<?php
									echo $this->get_fields( $component );
									?>
								</div>
							</div>
						</div>
					</div>
					<div class="mm-modal__footer">
                        <input type="hidden" class="mm-register_fields mm-register_fields--<?php echo $component->ID; ?>" name="register_fields" value='<?php echo json_encode( $this->array_of_fields ); ?>'>
                        <div class="mm-modal__button mm-modal__delete"><span>Remove</span></div>
						<div class="mm-modal__button mm-modal__cancel close_modal"><span>Cancel</span></div>
						<div class="mm-modal__button mm-modal__duplicate" data-id="<?php echo $component->ID; ?>" data-name="<?php echo $component->post_title; ?>"><span>Duplicate</span></div>
						<div class="mm-modal__button mm-modal__save" data-id="<?php echo $component->ID; ?>" data-name="<?php echo $component->post_title; ?>"><span>Save</span></div>
					</div>
				</div>
			</div>
			<div class="mm-modal__back"></div>
		</div>
		<style>
			.open.open--<?php echo $component->ID; ?> .mm-modal--<?php echo $component->ID; ?> {
				display: flex;
			}
			.modal-load.open--<?php echo $component->ID; ?> .mm-modal--<?php echo $component->ID; ?> .mm-modal__content {
				display: none;
			}
		</style>
		<?php
		return ob_get_clean();
	}

	/**
	 * Printed field by component
	 *
	 * @param object|array $component
	 * @param boolean $is_array
	 * @return string
	 */
	public function get_fields( $component, $is_array = false ) {
		ob_start();
		if ( !$is_array ) {
		    $contents = unserialize( $component->post_content );
		} else {
		    $contents = $component;
		}
		foreach ( $contents as $content ) {
			if ( strtolower( $content['val'] ) == 'text' ) {
				echo $this->text_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'textarea' ) {
				echo $this->textarea_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'notes' ) {
				echo $this->notes_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'wysiwyg' ) {
				echo $this->wysiwyg_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'graphic radio' ) {
				echo $this->graphic_radio_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'radio' ) {
				echo $this->radio_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'checkbox' ) {
				echo $this->checkbox_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'select' ) {
				echo $this->select_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'multiple select' ) {
				echo $this->select_field( $content, '', true );
			} elseif ( strtolower( $content['val'] ) == 'media upload' ) {
				echo $this->media_field( $content, '', false );
			} elseif ( strtolower( $content['val'] ) == 'multiple media upload' ) {
				echo $this->media_field( $content, '', true );
			} elseif ( strtolower( $content['val'] ) == 'file upload' ) {
				echo $this->file_field( $content, '' );
			} elseif ( strtolower( $content['val'] ) == 'group begin' ) {
				echo $this->group_begin_field( $content, $this->id );
			} elseif ( strtolower( $content['val'] ) == 'group end' ) {
				echo $this->group_end_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'ooto begin' ) {
                 echo '';
			} elseif ( strtolower( $content['val'] ) == 'ooto tab' ) {
				echo $this->ooto_begin_field( $content );
			} elseif ( strtolower( $content['val'] ) == 'ooto end' ) {
				echo $this->ooto_end_field( $content );
			}
		}
		return ob_get_clean();
	}

	/**
	 * Returned Begin of OOTO Group section
	 *
	 * @param array $component
	 * @return string
	 */
	public function ooto_begin_field( $component ) {
		$content = $component;
		ob_start();
		if ( isset( $content['options'] ) AND isset( $content['options']['group'] ) AND $content['options']['group'] ) {
		    $group_id = self::clear_name( $content['options']['group'] );
		    $tab_id = self::clear_name( $content['options']['i'] );
		    if ( $tab_id == 1 ) {
                $fields = $content['options']['fields'];
                ?>
                <div class='mm-group mm-group--repeating mm-group--ooto'>
                    <div class="mm-tabs mm-tabs--<?php echo $group_id; ?>" data-group-id="<?php echo $group_id; ?>" data-current-tab="1">
                        <div class="mm-tabs__header">
                            <div class='mm-group__title'><?php echo $content['options']['group']; ?></div>
                            <?php
                            for ( $i = 0; $i < count( $fields ); ++$i ) {
                                $ii = $i + 1;
                                ?><div class="mm-tabs__tab mm-tabs-group--<?php echo $group_id; ?> mm-tabs__tab--ooto mm-tabs__tab--<?php echo $ii;  if ( $i == 0 ) echo ' mm-tabs__tab--current'; ?>" data-tab-id="<?php echo $ii; ?>" onclick="mm_tab_click(this, '<?php echo $group_id; ?>')"><?php echo $fields[$i]; ?></div><?php
                            }
                            ?>
                        </div>
                        <div class="mm-tabs__body mm-tabs__body--<?php echo $group_id; ?>">
                <?php
            } else {
		        echo '</div>';
            }
            ?>
                            <div class="mm-tabs__content mm-tabs-group--<?php echo $group_id; ?> mm-tabs__content--ooto mm-tabs__content--<?php echo $tab_id; if ( $tab_id == 1 ) echo ' mm-tabs__content--current'; else echo ' mm-tabs__content--not-current-ooto'; ?>" data-tab-id="<?php echo $tab_id; ?>" data-group-id="<?php echo $group_id; ?>">
                <?php
		}
		return ob_get_clean();
	}

	/**
	 * Returned End of OOTO Group section
	 *
	 * @param array $component
	 * @return string
	 */
	public function ooto_end_field( $component ) {
		ob_start();
		    echo "</div></div></div></div>";
		return ob_get_clean();
	}

	/**
	 * Returned Begin of Group section
	 *
	 * @param array $component
	 * @param int $component_id
	 * @return string
	 */
	public function group_begin_field( $component, $component_id ) {
		$content = $component;
		ob_start();
		if ( isset( $content['options'] ) AND isset( $content['options']['type'] ) AND $content['options']['type'] ) {
			if ( strtolower( $content['options']['type'] ) == 'repeating group' OR strtolower( $content['options']['type'] ) == 'repeating meta group' ) {
                $parent = $this->current_group();
//                if ( !$this->ajax_tab OR $this->group_name == $content['name'] ) {
                    array_push(
                        $this->repeating_group,
                        array(
                            'parent' => $parent,
                            'name' => $content['name'],
                            'tab' => 1,
                            'flag' => true
                        )
                    );
//                }
                $group_id = count( $this->repeating_group );
//                print_r($this->repeating_group);

				// if 'Card Grid' with fixed tabs count
                $grid = 1;
				if ( isset( $content['options']['grid'] ) AND $content['options']['grid'] > 1 ) {
				    $grid = $content['options']['grid'];
				}
				?>
				<div class='mm-group mm-group--repeating'>
                    <div class="mm-tabs mm-tabs--<?php echo $group_id; ?> <?php echo ( $grid > 1 ) ? 'mm-tabs--grid' : ''; ?> mm-tabs__max--1" data-group-id="<?php echo $group_id; ?>" <?php echo ( $grid > 1 ) ? "data-grid='$grid'" : ''; ?>>
                        <div class="mm-tabs__header">
                            <div class='mm-group__title'><?php echo $content['name']; ?></div>
                            <div class="mm-tabs__tab mm-tabs-group--<?php echo $group_id; ?> mm-tabs__tab--1 mm-tabs__tab--current" data-tab-id="1" onclick="mm_tab_click(this, <?php echo $group_id; ?>)">1</div><!--
                            --><div class="mm-tabs__tab mm-tabs__tab--new" data-component-id="<?php echo $component_id; ?>" data-group-id="<?php echo $group_id; ?>" data-max-tab-id="1">+ Add new</div>
                        </div>
                        <div class="mm-tabs__body mm-tabs__body--<?php echo $group_id; ?>">
                            <div class="mm-tabs__remove-tab mm-tabs__remove-tab--<?php echo $group_id; ?>" data-component-id="<?php echo $component_id; ?>" onclick="mm_remove_tab(this);" data-group-id="<?php echo $group_id; ?>" data-tab-id="1">✕ Remove tab #<span class="mm-tabs__tab-id">1</span></div>
                            <div class="mm-tabs__content mm-tabs-group--<?php echo $group_id; ?> mm-tabs__content--1 mm-tabs__content--current" data-tab-id="1" data-group-id="<?php echo $group_id; ?>">
				<?php
			} else {
				echo "<div class='mm-group mm-group--other'>";
				echo "<div class='mm-group__title'>{$content['name']}</div>";
			}
		} else {
			echo "<div class='mm-group'>";
			echo "<div class='mm-group__title'>{$content['name']}</div>";
		}
		return ob_get_clean();
	}

	/**
	 * Returned End of Group section
	 *
	 * @param array $component
	 * @param boolean $is_tab
	 * @return string
	 */
	public function group_end_field( $component, $is_tab = false ) {
		$content = $component;
		ob_start();
		$repeating_group = $this->is_repeating_group( $content['name'] );
		if ( $repeating_group !== false ) {
            if (!$is_tab) {
			    $this->repeating_group[$repeating_group]['flag'] = false;
            }
		    echo "</div></div></div>";
		}
		echo "</div>";
		return ob_get_clean();
	}

	/**
	 * Returned File upload section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @return string
	 */
	public function file_field( $component, $extra_class = '' ) {
		$id = ++$this->html_id;
		$clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$html_id = $this->html_id_filter( $clear_name . "-{$this->id}-{$id}" );
		$type_class = 'file_upload';
		$type = 'file upload';
		$this->register_field( $component, "#{$html_id}" );
        $mime = '';
        if ( isset( $component['options'] ) AND isset( $component['options']['mime'] ) AND $component['options']['mime'] ) {
            $mime = $component['options']['mime'];
        }

		ob_start();
		?>
        <div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--$type_class " . self::required( $component ); ?>" data-type="<?php echo $type; ?>">
            <label class="mm-single-com__field-label inline" for="<?php echo $html_id; ?>"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
            <div class="mm-single-com__upload-section">
                <input type="text" class="mm-single-com__file-upload w-input mm__name" name="<?php echo $clear_name; ?>" id="<?php echo $html_id; ?>" data-mime="<?php echo $mime; ?>" placeholder="Insert URL or Upload File">
                <div class="mm__upload_file_button button">Upload File</div>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned Media upload section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @param boolean $multiple
	 * @return string
	 */
	public function media_field( $component, $extra_class = '', $multiple = false ) {
		$id = ++$this->html_id;
		$clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$html_id = $this->html_id_filter( $clear_name . "-{$this->id}-{$id}" );
		$type_class = 'media_upload';
		$type = 'media upload';
		if ( $multiple ) {
			$type_class = 'multiple_media_upload';
			$type = 'multiple media upload';
		}
		$this->register_field( $component, "#{$html_id}" );
        $def_src = '/page-builder/assets/img/media-upload--thumb.png';

		ob_start();
		?>
        <div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--$type_class " . self::required( $component ); ?>" data-type="<?php echo $type; ?>">
            <label class="mm-single-com__field-label inline" for="<?php echo $html_id; ?>"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
            <div class="mm-single-com__upload-box">
                <div class="mm-single-com__images" data-src="<?php echo get_stylesheet_directory_uri() . $def_src; ?>">
                    <div class="mm-single-com__single-image">
                        <div class="mm-single-com__upload-image" style="background-image: url(<?php echo get_stylesheet_directory_uri() . $def_src; ?>)"></div>
                    </div>
                </div>
                <div class="mm-single-com__upload-buttons">
                    <input type="hidden" class="mm-single-com__media-upload w-input mm__name" name="<?php echo $clear_name; ?>" id="<?php echo $html_id; ?>">
                    <div class="mm__upload_image_button button">Upload image</div>
                </div>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned radio field section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @return string
	 */
	public function radio_field( $component, $extra_class = '' ) {
		if ( !isset( $component['options'] ) ) {
			return '';
		}
		$id = ++$this->html_id;
		$clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$this->register_field( $component, "[name=\"{$clear_name}\"]:checked" );
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--radio " . self::required( $component ); ?>" data-type="radio">
			<label class="mm-single-com__field-label inline"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
			<?php
			foreach ( $component['options'] as $input_name => $item ) {
				if ( !is_numeric ( $input_name ) ) {
					continue;
				}
		        $html_id = $this->html_id_filter( $this->name_filter( self::clear_name( $item['val'] ) ) . "-{$this->id}-{$id}" );
				?>
                <div class="inline w-radio">
                    <input id="<?php echo $html_id; ?>" name="<?php echo $clear_name; ?>" class="w-radio-input mm__name" type="radio" value="<?php echo $item['val']; ?>">
                    <label for="<?php echo $html_id; ?>" class="w-form-label"><?php echo $item['val']; ?></label>
                </div>
				<?php
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned Graphic radio field section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @return string
	 */
	public function graphic_radio_field( $component, $extra_class = '' ) {
		if ( !isset( $component['options'] ) ) {
			return '';
		}
		$id = ++$this->html_id;
        $clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$this->register_field( $component, "[name=\"{$clear_name}\"]:checked" );
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--graphic-radio " . self::required( $component ); ?>" data-type="graphic radio">
			<label class="mm-single-com__field-label inline"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
			<?php
			foreach ( $component['options'] as $input_name => $item ) {
				if ( !is_numeric ( $input_name ) ) {
					continue;
				}
				$input_id = self::clear_name( $item['val'] ) . "-{$this->id}-{$id}";
				if ( isset( $item['options'] ) AND isset( $item['options']['img'] ) AND $item['options']['img'] ) {
					$url = $item['options']['img'];
				} else {
					$url = '/page-builder/assets/img/media-upload--thumb.png';
                }
				?>
                <div class="inline w-radio">
                    <input id="<?php echo $input_id; ?>" name="<?php echo $clear_name; ?>" class="w-radio-input mm__name" type="radio" value="<?php echo $item['val']; ?>">
                    <label for="<?php echo $input_id; ?>" class="w-form-label mm-single-com__graphic-label <?php echo "{$input_id}-l"; ?>"><?php echo $item['val']; ?></label>
                </div>
                <style>
                    .<?php echo "{$input_id}-l"; ?> {
                        background-image: url(<?php echo get_stylesheet_directory_uri() . $url; ?>);
                    }
                    <?php echo "#{$input_id}:checked"; ?>  ~ .<?php echo "{$input_id}-l"; ?> {
                        outline-color: #f87d47;
                    }
                </style>
				<?php
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned Select field section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @param boolean $multiple
	 * @return string
	 */
	public function select_field( $component, $extra_class = '', $multiple = false ) {
		if ( !isset( $component['options'] ) ) {
			return '';
		}
		$id = ++$this->html_id;
        $clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$html_id = $this->html_id_filter( $clear_name . "-{$this->id}-{$id}" );
		$additional = '';
		$type_class = 'select';
		$type = 'select';
		if ( $multiple ) {
			$additional = 'multiple';
			$type_class = 'multiple_select';
			$type = 'multiple select';
        }
		$this->register_field( $component, "#{$html_id}" );
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--$type_class " . self::required( $component ); ?>" data-type="<?php echo $type; ?>">
			<label class="mm-single-com__field-label inline" for="<?php echo $html_id; ?>"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
            <select name="<?php echo $clear_name; ?>" id="<?php echo $html_id; ?>" class="mm__name" <?php echo $additional; ?>>
			<?php
		    if ( !( isset( $component['options'] ) AND isset( $component['options']['required'] ) AND $component['options']['required'] === '0' ) AND !$multiple ) {
		        echo "<option disabled selected value=\"default\">Make a choice</option>";
		    }
			foreach ( $component['options'] as $input_name => $item ) {
				if ( !is_numeric ( $input_name ) ) {
					continue;
				}
				?>
                <option value="<?php echo $item['val']; ?>"><?php echo $item['val']; ?></option>
				<?php
			}
			?>
            </select>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned checkbox field section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @return string
	 */
	public function checkbox_field( $component, $extra_class = '' ) {
		if ( !isset( $component['options'] ) ) {
			return '';
		}
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--checkbox "; ?>" data-type="checkbox">
			<label class="mm-single-com__field-label inline"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
			<?php
			foreach ( $component['options'] as $input_name => $item ) {
				if ( !is_numeric ( $input_name ) ) {
					continue;
				}
				$id = ++$this->html_id;
                $clear_name = $this->name_filter( self::clear_name( $item['val'] ) );
                $html_id = $this->html_id_filter( $clear_name . "-{$this->id}-{$id}" );
				$this->register_field( array( 'name' => $item['val'] ), "[name=\"{$clear_name}\"]:checked" );
				?>
                    <div class="inline w-radio <?php echo self::required( $item ); ?>" data-type="checkbox">
                        <input id="<?php echo $html_id; ?>" name="<?php echo $clear_name; ?>" class="w-checkbox-input mm__name" type="checkbox" value="1">
                        <label for="<?php echo $html_id; ?>" class="w-form-label"><?php echo $item['val']; ?></label>
                    </div>
				<?php
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned text field section
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @param string $extra_class_input
	 * @return string
	 */
	public function text_field( $component, $extra_class = '', $extra_class_input = '' ) {
		$id = ++$this->html_id;
		$clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$html_id = $this->html_id_filter( "{$clear_name}-{$this->id}-{$id}" );
		$this->register_field( $component, "#{$html_id}" );
		$additional_tag = '';
		if ( isset( $component['options'] ) AND isset( $component['options']['limited'] ) ) {
			$additional_tag .= "maxlength=\"{$component['options']['limited']}\"";
        }
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} {$extra_class} mm-single-com__field--text " . self::required( $component ); ?>" data-type="text">
			<label for="<?php echo $html_id; ?>" class="mm-single-com__field-label inline"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
			<input class="mm-single-com__text-field w-input <?php echo $extra_class_input; ?> mm__name" <?php echo $additional_tag; ?> name="<?php echo $clear_name; ?>" id="<?php echo $html_id; ?>" required="" type="text">
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned Notes
	 *
	 * @param array $component
	 * @return string
	 */
	public function notes_field( $component ) {
		if ( isset( $component['options'] ) AND isset( $component['options']['text'] ) ) {
			return $component['options']['text'];
        }
		return '';
	}

	/**
	 * Returned Textarea
	 *
	 * @param array $component
	 * @param string $extra_class
	 * @return string
	 */
	public function textarea_field( $component, $extra_class = '' ) {
		$id = ++$this->html_id;
		$clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$html_id = $this->html_id_filter( "{$clear_name}-{$this->id}-{$id}" );
		$this->register_field( $component, "#{$html_id}" );
		$additional_tag = '';
		if ( isset( $component['options'] ) AND isset( $component['options']['limited'] ) ) {
			$additional_tag .= "maxlength=\"{$component['options']['limited']}\"";
        }
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} mm-single-com__field--textarea {$extra_class} " . self::required( $component ); ?>" data-type="textarea">
			<label for="<?php echo $html_id; ?>" class="mm-single-com__field-label inline"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
            <textarea class="mm-single-com__text-field w-input mm__name" <?php echo $additional_tag; ?> name="<?php echo $clear_name; ?>" id="<?php echo $html_id; ?>"></textarea>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Returned wysiwyg
	 *
	 * @param array $component
	 * @return string
	 */
	public function wysiwyg_field( $component ) {
		$id = ++$this->html_id;
        $clear_name = $this->name_filter( self::clear_name( $component['name'] ) );
		$html_id = $this->html_id_filter( str_replace( array('-', '_'), '', $clear_name ) . "{$this->id}{$id}" );
		$this->register_field( $component, "#{$html_id}" );
		ob_start();
		?>
		<div class="<?php echo "{$this->class__field} mm-single-com__field--wysiwyg " . self::required( $component ); ?>" data-type="wysiwyg">
			<label for="<?php echo $html_id; ?>" class="mm-single-com__field-label inline"><?php echo $component['name']; ?><?php echo $this->help_text( $component ); ?></label>
            <?php
            wp_editor( '', $html_id , array(
	            'wpautop'       => 1,
	            'media_buttons' => 1,
	            'textarea_name' => $clear_name,
	            'editor_class'  => 'mm-single-com__wysiwyg mm__name',
	            'textarea_rows' => 8,
	            'teeny'         => 0,
	            'dfw'           => 0,
	            'tinymce'       => 1,
	            'quicktags'     => 1,
	            'drag_drop_upload' => true
            ) );
            ?>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Search name of Group in Repeating Group
	 *
	 * @param string $name
	 * @return integer
	 */
	protected function is_repeating_group( $name ) {
		$i = 0;
		foreach ( $this->repeating_group as $group ) {
			if ( $group['name'] == $name AND $group['flag'] == true ) {
				return $i;
			}
			++$i;
		}
		return false;
	}

	/**
	 * Search name of Group in Repeating Group
	 *
	 * @return integer
	 */
	protected function current_group() {
		for ($i = count( $this->repeating_group ) - 1; $i >= 0; --$i ) {
			if ( $this->repeating_group[$i]['flag'] == true ) {
				return $i;
			}
		}
		return false;
	}

	/**
	 * Changed component name for Repeating Group
	 *
	 * @param string $name
	 * @return string
	 */
	protected function name_filter( $name ) {
		for ($i = 0; $i < count( $this->repeating_group ); ++$i ) {
            $j = $i + 1;
			if ( $this->repeating_group[$i]['flag'] == true AND $j AND $this->repeating_group[$i]['tab'] ) {
				$name .= "__$j-{$this->repeating_group[$i]['tab']}";
			}
		}
		return $name;
	}

	/**
	 * Changed component html id for Ajax Tabs
	 *
	 * @param string $name
	 * @return string
	 */
	protected function html_id_filter( $name ) {
//        if ( $this->ajax_tab !== false ) {
//            $name = "{$this->ajax_tab}--{$name}";
//        }
		return $name;
	}

	/**
	 * Returned class for required (or none) fields
	 *
	 * @param array $component
	 * @return string
	 */
	public static function required( $component ) {
	    if ( isset( $component['options'] ) AND isset( $component['options']['required'] ) AND $component['options']['required'] === '1' ) {
	        return 'mm-single-com__field--required';
        } else {
		    return 'mm-single-com__field--no-required';
        }
	}

	/**
	 * Returned class for required (or none) fields (for checkbox)
	 *
	 * @param array $component
	 * @return string
	 */
	public static function required_level2( $component ) {
	    if ( isset( $component['options'] ) AND  isset( $component['options']['required'] ) AND $component['options']['required'] === '0' ) {
	        return 'mm-single-com__field--no-required';
        } else {
		    return 'mm-single-com__field--required';
        }
	}

	/**
	 * Returned clear string without bad charsets
	 *
	 * @param string $string
	 * @return string
	 */
	public static function clear_name( $string ) {
		$iso9_table = array(
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G`',
			'Ґ' => 'G`', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
			'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'Y',
			'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
			'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
			'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
			'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
			'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SH', 'Ъ' => '',
			'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
			'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
			'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'y',
			'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
			'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
			'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
			'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'sh', 'ь' => '',
			'ы' => 'y', 'ъ' => "", 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
		);
		$replace = array( ' ', '.', ',', ';', '%', '&', '<', '>', '*', '(', ')', '$', '^', '@', '!', '+', '-' , '|', '\\', '/' );
		$string = strtr( $string, $iso9_table );
		$string = strtolower( $string );
		$string = str_replace( $replace, '_', $string );
		return $string;
	}

	/**
	 * Register component in array $this->array_of_fields
	 *
	 * @param array $component
	 * @param string $selector
	 * @return void
	 */
	public function register_field( $component, $selector ) {
		array_push(
			$this->array_of_fields,
			array(
				'name' => $component['name'],
				'slug' => $this->name_filter( self::clear_name( $component['name'] ) ),
				'selector' => $selector
			)
		);
	}

	/**
	 * Array filter by unique values
	 *
	 * @param array $array
	 * @return array
	 */
	public static function filter_unique_values( $array ) {
        $new_array = array();
        for ( $i = 0; $i < count( $array ); ++$i) {
            $flag = true;
            for ( $j = 0; $j < count( $new_array ); ++$j) {
                if ( $new_array[$j]['selector'] == $array[$i]['selector'] ) {
                    $flag = false;
                    break;
                }
            }
            if ( $flag ) {
                array_push( $new_array, $array[$i] );
            }
        }
		return $new_array;
	}

	/**
	 * Returned help text for label
	 *
	 * @param array $component
	 * @return string
	 */
	public static function help_text( $component ) {
		if ( isset( $component['options'] ) AND isset( $component['options']['help'] ) AND $component['options']['help'] ) {
            return "<span class=\"help-text\">{$component['options']['help']}</span>";
		}
        return '';
	}
}