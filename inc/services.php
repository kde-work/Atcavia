<?php
function tob_under_slide_news() {
	global $wpdb;

	return $wpdb->get_results(
		"SELECT * FROM `$wpdb->posts` as posts INNER JOIN
			 `$wpdb->postmeta` as postmeta ON
			 postmeta.`post_id` = posts.`ID`
			 WHERE 
			    posts.`post_type` = 'post'
		        AND posts.`post_status` = 'publish'
		           AND postmeta.`meta_key` = 'show_on_the_main_page'
		           	  AND postmeta.`meta_value` = '1'
		     ORDER BY posts.`post_date` DESC
	        ",
		ARRAY_A
	);
}
function tob_news( $count, $current_position ) {
	global $wpdb;

	return $wpdb->get_results(
		"SELECT * FROM `$wpdb->posts` as posts
			 WHERE 
			    posts.`post_type` = 'post'
		        AND posts.`post_status` = 'publish'
		     ORDER BY posts.`post_date` DESC
		     LIMIT $current_position, $count
	        ",
		ARRAY_A
	);
}
function tob_news_html( $count, $current_position ) {
	$posts = tob_news( $count, $current_position );

	ob_start();
	foreach ( $posts as $news ) {
		?>
		<div class="text-news__item text-news__item--<?php echo $news['ID']; ?>">
			<div class="text-news__categories"><?php echo tob_get_cat_list( $news['ID'] ); ?></div>
			<div class="text-news__title"><a href="<?php echo $news['guid']; ?>"><?php echo tob_get_title( $news['ID'], $news['post_title'] ); ?></a></div>
			<div class="text-news__date f--grey"><?php echo tob_get_date( $news['post_date_gmt'] ); ?></div>
			<a href="<?php echo $news['guid']; ?>" class="text-news__more"><?php
				echo __t( 'Подробнее', 'Learn More' );
				?></a>
		</div>
		<?php
	}
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}
function tob_get_cat_list( $post_id ) {
	$categories = get_the_category( $post_id );
	$cat_html = '';

	foreach ( $categories as $category ) {
		$cat_name = __cat_name( $category->cat_ID, $category->cat_name );
		$cat_link = get_category_link( $category->cat_ID );
		$cat_html .= "<a href=\"{$cat_link}\">{$cat_name}</a>, ";
	}
	return substr( $cat_html, 0, - 2 );
}
function tob_get_title( $post_id, $title_ru, $prefix = '' ) {
	if ( atc_is_en() AND function_exists( 'get_field' ) ) {
		$post_title = get_field( 'title_in_english', $prefix . $post_id );
	}
	if ( atc_is_ru() OR !$post_title ) {
		$post_title = $title_ru;
	}
	return $post_title;
}
function tob_get_content( $post_id, $trim_words = 0 ) {
	$post = get_post( $post_id );
	if ( !$post ) return '';
	$cont = do_shortcode( $post->post_content );

	$post_cont = '';
	if ( atc_is_en() AND function_exists( 'get_field' ) ) {
		$post_cont = get_field( 'description_in_english', $post_id );
	}
	if ( atc_is_ru() OR !$post_cont ) {
		$post_cont = $cont;
	}

	if ( $trim_words > 0 ) {
		return wp_trim_words( $post_cont, $trim_words );
    } else {
		return $post_cont;
    }
}
function tob_get_date( $post_date_gmt ) {
	$time = strtotime( $post_date_gmt );
	return __t( ru_date( '%d %bg %Y', $time ), date( 'Y/m/d', $time ) );
}
function ru_date($format, $date = false) {
	setlocale(LC_ALL, 'ru_RU.cp1251');
	if ($date === false) {
		$date = time();
	}
	if ($format === '') {
		$format = '%e&nbsp;%bg&nbsp;%Y&nbsp;г.';
	}
	$months = explode("|", '|января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря');
	$format = preg_replace("~\%bg~", $months[date('n', $date)], $format);
	$res = strftime($format, $date);
	return $res;
}

function tbs_auto_paragraph( $text ){
	if ( trim( $text ) !== '' ) {
		$text = preg_replace( '|<br[^>]*>\s*<br[^>]*>|i', "\n\n", $text . "\n" );
		$text = preg_replace( "/\n\n+/", "\n\n", str_replace( ["\r\n", "\r"], "\n", $text ) );
		$texts = preg_split( '/\n\s*\n/', $text, -1, PREG_SPLIT_NO_EMPTY );
		$text = '';
		foreach ( $texts as $txt ) {
			$text .= '<p>' . nl2br( trim( $txt, "\n" ) ) . "</p>\n";
		}
		$text = preg_replace( '|<p>\s*</p>|', '', $text );
	}

	return $text;
}
function tbs_clear_phone ( $phone ) {
	return str_replace( array( ' ', '(', ')', '-' ), '', str_replace( '+7', '8', $phone ) );
}
function tbs_rand_indexes ( $min, $max, $count_ ) {
	$count = $count_;
	$rand_mas = array( mt_rand( $min, $max ) );
	--$count;
	while ( $count > 0 ) {
		if ( count( $rand_mas ) > ( $max - $min ) ) {
			break;
		}
		$flag = false;
		$rand = mt_rand( $min, $max );
		foreach ( $rand_mas as $rand_ma ) {
			if ( $rand_ma === $rand ) {
				$flag = true;
				break;
			}
		}
		if ( !$flag ) {
			$rand_mas[] = $rand;
			--$count;
		}
	}
	return $rand_mas;
}
function tbs_list_of_cat ( $term_name ) {
	global $wpdb;
	$term_name = addslashes( $term_name );

	return $wpdb->get_results(
		"SELECT * FROM `$wpdb->term_taxonomy` as term_taxonomy INNER JOIN
			 `$wpdb->terms` as terms ON
			 term_taxonomy.`term_id` = terms.`term_id`
			 WHERE 
			    term_taxonomy.`taxonomy` = '$term_name'
		        AND term_taxonomy.`count` >= 1
		     ORDER BY terms.`term_id` DESC
	        ",
		ARRAY_A
	);
}
function tbs_list_post_by_post_type ( $post_type, $cat_id ) {
	global $wpdb;

	return $wpdb->get_results(
		"SELECT * FROM `$wpdb->posts` as posts INNER JOIN
			 `$wpdb->term_relationships` as term_relationships ON
			 term_relationships.`object_id` = posts.`ID`
			 WHERE 
			    posts.`post_type` = '$post_type'
		        AND posts.`post_status` = 'publish'
		           AND term_relationships.`term_taxonomy_id` = '$cat_id'
		     ORDER BY posts.`post_date` DESC
	        ",
		ARRAY_A
	);
}
function tbs_list_post_by_id_list ( $id_list ) {
	global $wpdb;

	$ids = explode( ',', $id_list );
	$str = '';
	foreach ( $ids as $id ) {
        if ( intval( $id ) ) {
	        if ( !$str ) {
		        $str = 'AND (';
	        } else {
		        $str .= 'OR ';
	        }
	        $str .= "posts.`ID` = '". intval( $id ) ."'";
        }
    }
	if ( $str ) {
		$str .= ')';
	}
	return $wpdb->get_results(
		"SELECT * FROM `$wpdb->posts` as posts
			 WHERE 
			    posts.`post_status` = 'publish'
		           $str
		     ORDER BY posts.`post_date` DESC
	        ",
		ARRAY_A
	);
}
function tbs_get_number_with_zero ($number) {
	if (is_integer($number)) {
		if ($number < 10) {
			return '0'.$number;
		}
	}
	return $number;
}
function tbs_replace_str_with_star ($str) {
	return str_replace('*', '<br>', $str);
}