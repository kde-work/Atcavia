<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * MM_Component class
 *
 * @class       MM_Component_Builder
 * @version     0.0.3
 * @package     Mammen/Classes
 * @category    Class
 * @author      Mammen
 */
class MM_Component_Builder {

	/**
	 * The full path of files with components.
	 *
	 * @var array
	 */
	protected static $files_with_components = array();

	/** @var object MM_Parser class */
	private static $mm_parser;

	/**
	 * Init Mammen Components
	 *
	 * Init Components from files in the directory
	 */
	public static function init() {

		self::search_of_file_names();

		$current_components = self::list_of_components();

		foreach ( self::$files_with_components as $file ) {
			$file = str_replace( '\\', '/', $file );
			$f = fopen( $file, 'r' ) or die( "Can not open file $file" );
			$file_content = fread( $f, filesize( $file ) );

			// declaration of components
			$component_position = self::position_component_content( $file_content );
			if ( ( $component_position[0] !== false ) AND ( $component_position[1] !== false ) ) {
				$content = substr( $file_content, $component_position[0], $component_position[1] - $component_position[0] );
				$content = str_replace( array( "\n", "\r" ), '', $content );
				$content = explode( '*', $content );

				self::$mm_parser = new MM_Component( $file );
				$component = self::$mm_parser->init( $content );
				$current_components = self::checking_component_in_the_list( $current_components, $component->get_name() );
				self::component_to_database( $component );
			}

			// template of components
			$component_template_name = self::component_template_name( $file_content );
			if ( $component_template_name !== false ) {
				$component_id = self::get_component_id_by_name( $component_template_name );
				if ( $component_id ) {
					update_post_meta( $component_id, 'template_file', $file, 0 );
				}
			}
		}
		self::delete_none_exist_components( $current_components );

		do_action( 'MM_Component_init' );
	}

	/**
	 * Delete none-exists component from DB
	 *
	 * @param  array $component_list
	 * @return void
	 */
	protected static function delete_none_exist_components( $component_list ) {
		foreach ( $component_list as $item ) {
			if ( !isset( $item['exist'] ) OR !$item['exist'] ) {
				self::delete_post( $item['ID'] );
			}
		}
	}

	/**
	 * Returns names list of components
	 *
	 * @return array
	 */
	protected static function list_of_components() {
		global $wpdb;

		return $wpdb->get_results(
			"SELECT `post_title` as name, `ID` FROM `$wpdb->posts` 
			 WHERE 
			    `post_type`='component'
		        AND `post_status`='publish'
	        ",
			ARRAY_A
		);
	}

	/**
	 * Added flag in the array, if component exist
	 *
	 * @param  array $component_list
	 * @param  string $name
	 * @return array
	 */
	protected static function checking_component_in_the_list( $component_list, $name ) {
		foreach ( $component_list as $key => $item ) {
			if ( $item['name'] == $name ) {
				$component_list[$key]['exist'] = 1;
			}
		}
		return $component_list;
	}

	/**
	 * Init Mammen Components
	 *
	 * Init Components from files in the directory
	 */
	protected static function search_of_file_names() {
		$mammen_components_dir = apply_filters( 'mammen_components_dir', array( MM_COMPONENT_DIR . '/', MM_TEMPLATE_COMPONENT_DIR . '/' ) );
		foreach ( $mammen_components_dir as $dir ) {
			$files = scandir( $dir );
			foreach ( $files as $file ) {
				if ( preg_match( '/(\.php$)/i', $file, $matches ) ) {
					array_push( self::$files_with_components, $dir . $file );
				}
			}
		}
	}

	/**
	 * Return array of positions of service comment block
	 *
	 * @param  string $content
	 * @return array
	 */
	protected static function position_component_content( $content ) {
		$pos = array();
		$pos[0] = strpos( $content, '* COMPONENT BEGIN' );
		$pos[1] = strpos( $content, '* COMPONENT END' );
		return $pos;
	}

	/**
	 * Return array of files
	 *
	 * @param  string $content
	 * @return integer
	 */
	protected static function component_template_name( $content ) {
		if ( strpos( $content, '* COMPONENT IMPLEMENTATION' ) !== false ) {
			if ( ( preg_match( '/\*\s+COMPONENT\sIMPLEMENTATION\s*:\s*(.+)[\s]*/ui', $content, $matches ) ) ) {
				return str_replace( array( "\n", "\r" ), '', $matches[1] );
			}
		}
		return false;
	}

	/**
	 * The entry component into the database
	 *
	 * @param  MM_Component $component
	 * @return void
	 */
	protected static function component_to_database( $component ) {
		$component_MD5 = $component->get_file_md5();
		$post_id = self::get_component_id_by_name( $component->get_name() );

		if ( get_post_meta( $post_id, 'virtual_component', 1 ) != 1 ) {
			if ( $post_id ) {
				$db_MD5 = get_post_meta( $post_id, 'file_MD5', 1 );
				if ( $db_MD5 AND ( $db_MD5 == $component_MD5 ) ) {
					return;
				} else {
					self::delete_post( $post_id );
					$post_id = self::create_post( $component );
					update_post_meta( $post_id, 'file_MD5', $component_MD5, 1 );
				}
			} else {
				$post_id = self::create_post( $component );
				update_post_meta( $post_id, 'file_MD5', $component_MD5, 1 );
			}
		}
	}

	/**
	 * Create post
	 *
	 * @param  MM_Component $component
	 * @return integer
	 */
	protected static function create_post( $component ) {
		$post = array(
			'post_title' => $component->get_name(),
			'post_content' => serialize( $component->get_content() ),
			'post_status' => "publish",
			'comment_status' => 'closed',
			'post_type' => 'Component'
		);
		$wp_error = '';
		$post_id = wp_insert_post( $post, $wp_error );

		if ( !$post_id ) {
			return false;
		}

		update_post_meta( $post_id, 'name_options', serialize( $component->get_name_option() ), 1 );
		update_post_meta( $post_id, 'file_name', $component->get_file_name(), 1 );
		update_post_meta( $post_id, 'picture_thumbnail', $component->get_thumbnail(), 1 );
		update_post_meta( $post_id, 'picture_preview', $component->get_preview(), 1 );
		update_post_meta( $post_id, 'global_component_rules', $component->get_global_component_rules(), 1 );
		update_post_meta( $post_id, 'virtual_component', 0, 1 );

//		self::adding_thumbnail( ABSPATH . $component->get_thumbnail(), $component->get_name(), $post_id );

		return $post_id;
	}

	/**
	 * Delete post by id
	 *
	 * @param  integer $id_post
	 * @return void
	 */
	protected static function delete_post( $id_post ) {
		wp_delete_post( $id_post, 1 );
	}

	/**
	 * Return array of files
	 *
	 * @param $name string
	 * @return integer - ID of component in `wp_posts`.
	 */
	public static function get_component_id_by_name( $name ) {
		global $wpdb;

		$name = addslashes( $name );
		return $wpdb->get_var(
			"SELECT `ID` FROM `$wpdb->posts` 
			 WHERE 
			    `post_title`='$name' 
		         AND `post_type`='component'
		            AND `post_status`='publish'
	        "
		);
	}

	/**
	 * Return array of files
	 *
	 * @return array - Main instance.
	 */
	public static function get_files() {
		if ( count( self::$files_with_components ) ) {
			return self::$files_with_components;
		} else {
			return null;
		}
	}

	/**
	 * Adding post thumbnail
	 *
	 * @param  string $img_path
	 * @param  string $post_name
	 * @param  integer $post_id
	 * @return void
	 */
	public static function adding_thumbnail( $img_path, $post_name, $post_id ) {
		if ( !empty( $img_path ) AND file_exists( $img_path ) ) {
			require_once( ABSPATH .'wp-admin/includes/image.php' );
			require_once( ABSPATH .'wp-admin/includes/file.php' );
			require_once( ABSPATH .'wp-admin/includes/media.php' );

			$tmp_dir = MM_PLUGIN_DIR . '/tmp/';
			@mkdir( $tmp_dir );
			copy( $img_path, $tmp_dir . 'tmp' );

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
			$rep = Array ( ' ','/','.',',','+','*' );

			$title = substr( strtr( $post_name, $iso9_table ), 0, 40 );
			$title = str_replace( $rep,'-',$title );

			$file_array['name'] = strtolower( rawurlencode( $title ).'.jpg' );
			$file_array['tmp_name'] = $tmp_dir . 'tmp';
			$thumbnail_id = media_handle_sideload( $file_array, $post_id, $file_array['name'] );
			if ( !is_wp_error( $thumbnail_id ) ) {
				set_post_thumbnail( $post_id, $thumbnail_id );
			}

			update_post_meta( $thumbnail_id, '_wp_attachment_image_alt', $post_name, true );
			$thumbnail = array();
			$thumbnail['ID'] = $thumbnail_id;
			$thumbnail['post_content'] = $post_name;
			$thumbnail['post_title'] = $post_name;
			wp_update_post( $thumbnail );

			rmdir( $tmp_dir );
		}
	}
}