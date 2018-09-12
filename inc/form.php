<?php
function tbs_create_post ($title, $content, $phone, $email, $name, $post_type, $term_name, $term_id, $service = '', $country = '', $email_to = '') {
	$post = array(
		'post_title' => $title,
		'post_content' => $content,
		'post_status' => "publish",
		'comment_status' => 'closed',
		'post_type' => $post_type
	);
	$wp_error = '';
	$post_id = wp_insert_post($post, $wp_error);
	wp_set_object_terms($post_id, $term_id, $term_name);
	update_post_meta($post_id, 'name', $name);
	update_post_meta($post_id, 'phone', $phone);
	update_post_meta($post_id, 'email', $email);
	if ($service)
		update_post_meta($post_id, 'service', $service);
	if ($country)
		update_post_meta($post_id, 'country', $country);
	if ($email_to)
		update_post_meta($post_id, 'email_to', $email_to);

	return $post_id;
}
function tbs_get_email_from_AtcForm ( $data_i ) {
	if ( $data_i ) {
		$data = json_decode( AtcModalForm\Generator::get_cache( __t( '', '_en' ) ) );

		$ii = explode( ",", $data_i );
		if ( !isset( $ii[1] ) ) {
			$ii[1] = 0;
		}
		$email = $data[$ii[0]]->val[$ii[1]]->email;
		if ( $data[$ii[0]]->val[$ii[1]]->email2 ) {
			$email .= ",".$data[$ii[0]]->val[$ii[1]]->email2;
		}
		return $email;
	} else {
		return false;
	}
}

add_action('wp_ajax_tbs_form', 'tbs_form_callback');
add_action('wp_ajax_nopriv_tbs_form', 'tbs_form_callback');
function tbs_form_callback() {
	if ($_POST) { // если передан массив POST
		$email_to = "omigos99@yandex.ru";
//		$email = "vash.stroi@yandex.ru";
		$from_email = "from-site@atcavia.com";

		ob_start();
		print_r($_POST);
		$output = ob_get_contents();
		ob_end_clean();

		$number = htmlspecialchars($_POST["cta__phone"]);
		$email = htmlspecialchars($_POST["cta__email"]);
		$name = htmlspecialchars($_POST["cta__name"]);
		$description = htmlspecialchars($_POST["description"]);
		$service = htmlspecialchars($_POST["service"]);
		$country = htmlspecialchars($_POST["country"]);
		$i = htmlspecialchars($_POST["i"]);
		$cat = htmlspecialchars($_POST["cat"]);
		$url = htmlspecialchars($_POST["url"]);
		$message = htmlspecialchars($_POST["message"]);
		if (!$number ||!$email || !$name) { // если хоть одно поле оказалось пустым
			echo json_encode(
				array(
					'status' => 0,
					'content' => $output,
					'error' => 'Заполните, пожалуйста, все обязательные поля'
				)
			);
			die();
		}

		if ( !$message ) {
			$message = '<i>Без сообщения</i>';
		}

		$additional = '';
		if ( $service ) {
			$additional = "Выбраны поля:<br>Услуга:<strong>$service</strong> ";
			if ( $country ) {
				$additional .= "<br>Второй выбор:<strong>$country</strong> ";
			}
		}

		$email_html = '';
		if ($email) {
			$email_html = 'и email <a href="mailto:' . $email . '"><strong>' . $email . '</strong></a>';
		}

		$email_to = tbs_get_email_from_AtcForm( $i );

		function sms_send_mime_mail(
			$email_from, // email отправителя
			$email_to, // email получателя
			$data_charset, // кодировка переданных данных
			$send_charset, // кодировка письма
			$subject, // тема письма
			$body // текст письма
		) {
			$to = $email_to;
			$from = $email_from;
			$subject = sms_mime_header_encode($subject, $data_charset, $send_charset);
			if ($data_charset != $send_charset) {
				$body = iconv($data_charset, $send_charset, $body);
			}
			$headers = "From: $from\r\n";
			$headers .= "Content-type: text/html; charset=$send_charset\r\n";
			return mail($to, $subject, $body, $headers);
		}

		function sms_mime_header_encode($str, $data_charset, $send_charset) {
			if ($data_charset != $send_charset) {
				$str = iconv($data_charset, $send_charset, $str);
			}
			return "=?" . $send_charset . "?B?" . base64_encode($str) . "?=";
		}

		$clear_number = str_replace("(", "", $number);
		$clear_number = str_replace(")", "", $clear_number);
		$clear_number = str_replace("-", "", $clear_number);
		$clear_number = str_replace(" ", "", $clear_number);

		$title = "Заказ с сайта ". get_bloginfo('name', 0) ." от $name. "/* . get_term_by('slug', $cat, 'cdimails-category')->name*/;

		$body = 'Пользователь с именем <strong>' . $name . '</strong>, телефоном <a href="tel:' . $clear_number . '"><strong>' . $number . '</strong></a> '.$email_html.' заполнил форму с сайта <a href="'. get_site_url() .'">' . get_bloginfo('name', 0) . '</a>.<br>'.$additional.'<br>Сообщение: <div style="color: #333;">'.$message.'</div> <br><br>Основная информация: <strong>' . $description . '</strong>. ';
		$body .= '<br><br><br><div style="color: #999;">' . $_SERVER['HTTP_USER_AGENT'].'<br><br>Отправлено <a href="'.$url.'">с этой страницы</a></div>';

		// Создаём пост
		tbs_create_post ($title, $body, $clear_number, $email, $name, 'mails', 'cdimails-category', $cat, $service, $country, $email_to);

		sms_send_mime_mail(
			$from_email, // Ваш электронный адрес
			$email_to, // Ваш уникальный адрес в системе SMS.RU
			"UTF-8",  // кодировка, в которой находятся передаваемые строки
			"UTF-8", // кодировка, в которой будет отправлено письмо
			$title, // заголовок письма (здесь указываются параметры)
			$body
		);

		echo json_encode(
			array(
				'status' => 1,
//				'content' => $body,
//				'email_to' => $email_to,
			)
		);

		die;
	}
}