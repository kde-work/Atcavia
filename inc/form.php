<?php
function tbs_create_post ($title, $content, $phone, $email, $name, $post_type, $term_name, $term_id) {
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

	return $post_id;
}

add_action('wp_ajax_tbs_form', 'tbs_form_callback');
add_action('wp_ajax_nopriv_tbs_form', 'tbs_form_callback');
function tbs_form_callback() {
	if ($_POST) { // если передан массив POST
		$email_to = "omigos99@yandex.ru";
//		$email = "vash.stroi@yandex.ru";
		$from_email = "from-site@thaibeautyspa.ru";

		ob_start();
		print_r($_POST);
		$output = ob_get_contents();
		ob_end_clean();

		$number = htmlspecialchars($_POST["cta__phone"]);
		$email = htmlspecialchars($_POST["cta__email"]);
		$name = htmlspecialchars($_POST["cta__name"]) .' '. htmlspecialchars($_POST["cta__last-name"]);
		$description = htmlspecialchars($_POST["description"]);
		$cat = htmlspecialchars($_POST["cat"]);
		$url = htmlspecialchars($_POST["url"]);
		if ((!$number AND $cat != 'отзывы') || !htmlspecialchars($_POST["cta__name"])) { // если хоть одно поле оказалось пустым
			echo json_encode(
				array(
					'status' => 0,
					'content' => $output,
					'error' => 'Заполните, пожалуйста, все обязательные поля'
				)
			);
			die();
		}

		$email_html = '';
		if ($email) {
			$email_html = 'и email <a href="mailto:' . $email . '"><b>' . $email . '</b></a>';
		}

		$extra = '';
		if ($cat == 'услуги') {
			$cta__time = htmlspecialchars($_POST["cta__min"]);
			$cta__gender = htmlspecialchars($_POST["cta__gender"]);

			$extra = "Продолжительность: <b>$cta__time</b>. Пол: <b>$cta__gender</b>";
		}
		if ($cat == 'отзывы') {
			$cta__text = htmlspecialchars($_POST["cta__text"]);

			$extra = "<br>Отзыв: <p style='color: #050;'>$cta__text</p>";
		}

		function sms_send_mime_mail(
			$email_from, // email отправителя
			$email_to, // email получателя
			$data_charset, // кодировка переданных данных
			$send_charset, // кодировка письма
			$subject, // тема письма
			$body // текст письма
		) {
			$to = $email_to;
			$from =  $email_from;
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

		$title = "Заказ с сайта ". get_bloginfo('name', 0) ." от $name. " . get_term_by('slug', $cat, 'cdimails-category')->name;

		$body = 'Пользователь с именем <b>' . $name . '</b>, телефоном <a href="tel:' . $clear_number . '"><b>' . $number . '</b></a> '.$email_html.' заполнил форму с сайта <a href="'. get_site_url() .'">' . get_bloginfo('name', 0) . '</a>. <br><br>Основная информация: <b>' . $description . '</b>. '. $extra;
		$body .= '<br><br><br><div style="color: #999;">' . $_SERVER['HTTP_USER_AGENT'].'<br><br>Отправлено <a href="'.$url.'">с этой страницы</a></div>';

		// Создаём пост
		tbs_create_post ($title, $body, $clear_number, $email, $name, 'mails', 'cdimails-category', $cat);

//		sms_send_mime_mail(
//			$from_email, // Ваш электронный адрес
//			$email_to, // Ваш уникальный адрес в системе SMS.RU
//			"UTF-8",  // кодировка, в которой находятся передаваемые строки
//			"UTF-8", // кодировка, в которой будет отправлено письмо
//			$title, // заголовок письма (здесь указываются параметры)
//			$body
//		);

		echo json_encode(
			array(
				'status' => 1,
				'content' => $body
			)
		);

		die;
	}
}