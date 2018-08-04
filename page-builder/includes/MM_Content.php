<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * MM_Component class
 *
 * @class       MM_Content
 * @version     0.0.3
 * @package     Mammen/Classes
 * @category    Admin
 * @author      Mammen
 */
class MM_Content {

	/** @var object WP_Query posts */
	protected $components;

	/** @var object WP_Query posts */
	protected $settings;

	/**
	 * MM_Content Constructor.
	 */
	public function __construct() {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'component'
		);
		$this->components = get_posts($args);
	}

	/**
	 * Hook in tabs
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'scripts' ) );
		add_action( 'edit_form_after_title', array( __CLASS__, 'mammen_button' ), 10 );
		add_action( 'edit_form_after_title', array( __CLASS__, 'meta_box_content' ), 15 );
//		add_action( 'add_meta_boxes', array( __CLASS__, 'add_custom_box' ));
		add_action( 'in_admin_footer', array( __CLASS__, 'static_content_modals' ) );
		add_action( 'wp_ajax_mammen_page_builder', array( __CLASS__, 'ajax_content' ) );
		add_filter( 'admin_body_class', array( __CLASS__, 'add_body_class' ), 10 );
	}

	/**
	 * Added class to body
	 *
	 * @param  string $classes
	 * @return string
	 */
	public static function add_body_class( $classes ) {
		if ( self::is_allowed_page() ) {
            $classes .= 'page-builder-load';
		}
		return $classes;
	}

	/**
	 * Added custom meta box
	 *
	 * @return void
	 */
	public static function add_custom_box() {
		add_meta_box( 'page-builder', 'Mammen Page Builder', array( __CLASS__, 'meta_box_content' ), array( 'post', 'page' ), 'normal', 'high' );
	}

	/**
	 * Display Page Builder HTML
	 *
	 * @return void
	 */
	public static function meta_box_content() {
		$page_builder = new MM_Content();
		echo $page_builder->content();
	}

	/**
	 * Returned Modals HTML
	 *
	 * @return void
	 */
	public static function static_content_modals() {
		if (
            strpos( $_SERVER['REQUEST_URI'], 'post.php' ) !== false
            OR strpos( $_SERVER['REQUEST_URI'], 'post-new.php' ) !== false
        ) {
			$page_builder = new MM_Content();
			echo $page_builder->content_modals();
		}
	}

	/**
	 * Added admin styles and scripts
	 *
	 * @param  string $page
	 * @return void
	 */
	public static function scripts( $page ) {
		if ( self::is_allowed_page() ) {
            $ver = '1.050';

			wp_localize_script( 'jquery', 'mm_ajaxurl',
				array(
					'url' => admin_url('admin-ajax.php')
				));

			// WordPress library
			wp_enqueue_media();

			wp_enqueue_script( 'mammen-main', MM_ASSETS_REL_DIR . '/js/mammen-main.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-modal', MM_ASSETS_REL_DIR . '/js/mammen-component-modal.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-move', MM_ASSETS_REL_DIR . '/js/mammen-component-move.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-edit', MM_ASSETS_REL_DIR . '/js/mammen-component-edit.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-delete', MM_ASSETS_REL_DIR . '/js/mammen-component-delete.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-required-fields', MM_ASSETS_REL_DIR . '/js/mammen-required-fields.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-media-uploader', MM_ASSETS_REL_DIR . '/js/mammen-component-media-uploader.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-file-uploader', MM_ASSETS_REL_DIR . '/js/mammen-component-file-uploader.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-duplicate', MM_ASSETS_REL_DIR . '/js/mammen-component-duplicate.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-component-drag', MM_ASSETS_REL_DIR . '/js/mammen-component-drag.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-thumbnail', MM_ASSETS_REL_DIR . '/js/mammen-thumbnail.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-tabs', MM_ASSETS_REL_DIR . '/js/mammen-tabs.js', array( 'jquery' ), $ver );
			wp_enqueue_script( 'mammen-tab-remove', MM_ASSETS_REL_DIR . '/js/mammen-tab-remove.js', array( 'jquery' ), $ver );

			wp_register_style( 'page-builder', MM_ASSETS_REL_DIR . '/css/page-builder.css', array(), $ver );
			wp_enqueue_style( 'page-builder' );
			wp_register_style( 'mammen-tabs', MM_ASSETS_REL_DIR . '/css/tabs.css', array(), $ver );
			wp_enqueue_style( 'mammen-tabs' );
		}
	}

	/**
	 * Display Mammen Page Builder button
	 *
	 * @return void
	 */
	public static function mammen_button() {
        ob_start();
        if ( self::is_allowed_page() ) {
            ?>
            <div class="page-builder-btn" data-enable="0">
                <span class="mm-icon--mammen"></span>
                <span class="page-builder-btn__trigger">Enable</span> Mammen Page Builder
            </div>
            <?php
        }
        echo ob_get_clean();
    }

	/**
	 * Checks the permissions for a specific page type
	 *
	 * @return boolean
	 */
	public static function is_allowed_page() {
        // TODO: To create a settings page. Which pages to display it
		global $post;
		$templates = wp_get_theme()->get_page_templates( $post );
		if( is_object( $post )
            AND isset( $templates[$post->page_template] )
                AND $templates[$post->page_template] == 'Adlava Page Builder'
        ) {
			return true;
		} else {
			return false;
		}
    }

	/**
	 * Display Page Builder HTML
	 *
	 * @return void
	 */
	public static function ajax_content() {
        if ( count( $_POST ) ) {
	        $return = array();
            $query = $_POST['query'];

            if ( $query == 'img_url_by_ID' ) {
                $id = intval( $_POST['id'] );
                $size = addslashes( $_POST['size'] );
	            $return['url'] = wp_get_attachment_image_src( $id, $size, true )[0];
	            $return['size'] = $size;
	            $return['id'] = $id;
            } elseif ( $query == 'tab' ) {
	            $register_fields = json_decode( stripslashes( $_POST['register_fields'] ) );
	            $component_id = intval( $_POST['component_id'] );
	            $group_id = intval( $_POST['group_id'] );
	            $id_tab = intval( $_POST['id_tab'] );
	            $group_tab = $_POST['group_tab'];

	            $content = new MM_Content( $component_id );
	            $return = $content->get_tab( $component_id, $group_id, $id_tab, $register_fields, $group_tab );
	        }

            echo json_encode( $return );
            die;
        }
	}

	/**
	 * Display Tab (Repeating Group) by ID
	 *
     * @param integer $component_id
     * @param integer $group_id
     * @param integer $id_tab
     * @param array $register_fields
     * @param array $group_tab
	 * @return string
	 */
	public function get_tab( $component_id, $group_id, $id_tab, $register_fields, $group_tab ) {
		$return = array();
		foreach ( $this->components as $component ) {
			if ( $component->ID == $component_id ) {
				$component_modal_window = new MM_Component_Page( $component->ID );
				$return['html'] = $component_modal_window->get_tab( $component, $group_id, $id_tab, $register_fields, $group_tab );
				$return['array_of_fields'] = $component_modal_window->get_array_of_fields();
			}
		}
		return $return;
	}

	/**
	 * Display html code
	 *
	 * @return string
	 */
	public function content() {
		ob_start();
		if ( self::is_allowed_page() ) {
			?>
            <div class="mm-mammen">
                <div id="page-builder" class="pb page-builder page-builder--blank-page">
                    <div class="page-builder__content">
                        <table border="0" class="page-builder__blank">
                            <tr>
                                <td>
                                    <h1 class="large-heading">Start Designing Your Page</h1>
                                    <p class="welcome-intro">Build with components! Select 'Add New Component' below to add
                                        your first component.</p>
                                    <div class="div-steps">
                                        <div class="small-text"><b>STEPS:</b></div>
                                        <ul class="ul">
                                            <li class="li">Select 'Add New Component'</li>
                                            <li class="li">Choose your component</li>
                                            <li class="li">Configure your component's settings</li>
                                            <li class="li">Add content to your component</li>
                                        </ul>
                                    </div>
                                    <div class="page-builder__btn--orange pb--add-new" data-open="new-component"><span class="add">+</span>&nbsp;Add
                                        New Component
                                    </div>
                                </td>
                                <td>
                                    <img src="<?php echo MM_ASSETS_REL_DIR; ?>/img/blank-page-prev.jpg" class="welcome-img"
                                         width="340">
                                </td>
                            </tr>
                        </table>
                        <div class="page-builder__components">
                            <div class="page-builder__component-list"></div>
                            <div class="page-builder__add-new">
                                <div class="page-builder__btn--orange pb--add-new" data-open="new-component"><span class="add">+</span>&nbsp;Add
                                    New Component
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mm-modal mm-modal--new-component">
                <div class="mm-modal__content">
                    <div class="mm-modal__header">
                        <div class="mm-modal__title">Choose a component</div>
                        <div class="mm-modal__close close_modal">
                            <img src="<?php echo MM_ASSETS_REL_DIR; ?>/img/cross.svg" alt="x" class="close-icon">
                        </div>
                    </div>
                    <div class="mm-modal__body">
                        <div class="mm-modal__body-inner mm-modal__body-inner--padding">
                            <div class="mm-components">
								<?php
								foreach ( $this->components as $component ) {
									$name_options = unserialize( get_post_meta( $component->ID, 'name_options', 1 ) );
									if ( isset( $name_options['Component type'] ) AND $name_options['Component type'] != 'Component' ) {
										continue;
									}
									?>
                                    <div class="mm-component mm-component--<?php echo $component->ID; ?> mm-component--<?php echo MM_Component_Page::clear_name( $component->post_title ); ?>">
                                        <div class="mm-component__thumb mm__open-thumb"
                                             style="background-image: url(<?php echo get_stylesheet_directory_uri() . get_post_meta( $component->ID, 'picture_thumbnail', 1 ); ?>)" data-img="<?php echo get_stylesheet_directory_uri() . get_post_meta( $component->ID, 'picture_preview', 1 ); ?>">
                                        </div>
                                        <div class="mm-component__title"><?php echo $component->post_title; ?></div>
                                        <div class="mm-component__button"
                                             data-open="<?php echo $component->ID; ?>"><span>Choose</span></div>
                                    </div>
									<?php
								}
								?>
                            </div>
                        </div>
                    </div>
                    <div class="mm-modal__footer"></div>
                </div>
                <div class="mm-modal__back close_modal"></div>
            </div>

            <div class="mm-modal mm-modal--thumbnail">
                <div class="mm-modal__content">
                </div>
                <div class="mm-modal__thumb-close close_thumb_modal"></div>
                <div class="mm-modal__back close_thumb_modal"></div>
            </div>
			<?php
		}
		return ob_get_clean();
	}

	/**
	 * Display html code
	 *
	 * @return string
	 */
	public function content_modals() {
		ob_start();
		if ( self::is_allowed_page() ) {
			echo "<div class='mm-modals'>";
			foreach ( $this->components as $component ) {
				$name_options = unserialize( get_post_meta( $component->ID, 'name_options', 1 ) );
				if ( isset( $name_options['Component type'] ) AND strtolower( $name_options['Component type'] ) == 'settings' ) {
					$this->settings = $component;
					break;
				}
			}
			foreach ( $this->components as $component ) {
				$name_options = unserialize( get_post_meta( $component->ID, 'name_options', 1 ) );
				if ( isset( $name_options['Component type'] ) AND strtolower( $name_options['Component type'] ) != 'component' ) {
					continue;
				}
				$component_modal_window = new MM_Component_Page( $component->ID );
				echo $component_modal_window->content( $component, $this->settings );
			}
			echo "</div>";
		}
		return ob_get_clean();
	}
}

