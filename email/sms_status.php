<?php
if ($_POST) { // если передан массив POST
    $api_id = '611C0124-00DC-44B4-2F64-12D94C7E4F68';
    $to = '79085112145';
    
	$id = htmlspecialchars($_POST["id"]); // пишем данные в переменные и экранируем спецсимволы
	if (!$id) { // если хоть одно поле оказалось пустым
		echo '0';
		die(); // умираем
	}

    $body = file_get_contents("http://sms.ru/sms/status?api_id={$api_id}&id=$id");

	echo $body;

} else { // если массив POST не был передан
	echo 'GET LOST!'; // высылаем
}