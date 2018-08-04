<?php
if ($_POST) { // если передан массив POST
    $email = "omigos99@yandex.ru";
    $from_email = "from-site@ballroom-rostov.ru";
    
	$json = ''; // подготовим массив ответа
	$number = htmlspecialchars($_POST["number"]); // пишем данные в переменные и экранируем спецсимволы
	$name = htmlspecialchars($_POST["name"]); // пишем данные в переменные и экранируем спецсимволы
	$form = htmlspecialchars($_POST["form"]); // пишем данные в переменные и экранируем спецсимволы
	if (!$number || !$name) { // если хоть одно поле оказалось пустым
		$json = 'Заполните, пожалуйста, все поля'; // пишем ошибку в массив
		echo $json;
		//echo json_encode($json); // выводим массив ответа 
		die(); // умираем
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

	sms_send_mime_mail(
            $from_email, // Ваш электронный адрес
			$email, // Ваш уникальный адрес в системе SMS.RU
			"UTF-8",  // кодировка, в которой находятся передаваемые строки
            "UTF-8", // кодировка, в которой будет отправлено письмо
			"Заказ с ballroom-rostov.ru", // заголовок письма (здесь указываются параметры)
			'Пользователь с именем <b>' . $name . '</b> и телефоном <a href="tel:' . $clear_number . '"><b>' . $number . '</b></a> заказал звонок с сайта http://ballroom-rostov.ru/ с целью <b>' . $form . '</b>'
	);
	
	$json = 0;
	
	echo $json;
	
} else { // если массив POST не был передан
	echo 'GET LOST!'; // высылаем
}

?>