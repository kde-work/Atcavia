<?php
if ($_POST) { // если передан массив POST
    $api_id = '611C0124-00DC-44B4-2F64-12D94C7E4F68';
    $to = '79085112145';
    
    $text = htmlspecialchars($_POST["text"]); // пишем данные в переменные и экранируем спецсимволы
    $number = htmlspecialchars($_POST["number"]); // пишем данные в переменные и экранируем спецсимволы
    $name = htmlspecialchars($_POST["name"]); // пишем данные в переменные и экранируем спецсимволы
    if (!$text || !$number) { // если хоть одно поле оказалось пустым
        echo '0';
        die(); // умираем
    }

    $iso9_table = array(
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G`',
        'Ґ' => 'G`', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Є' => 'Ye',
        'Ж' => 'Zh', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'Y',
        'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
        'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
        'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'Ts',
        'Ч' => 'Ch', 'Џ' => 'DH', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'YA',
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

    $clear_number = str_replace("(", "", $number);
    $clear_number = str_replace(")", "", $clear_number);
    $clear_number = str_replace("-", "", $clear_number);
    $clear_number = str_replace(" ", "", $clear_number);
    $clear_number_2 = str_replace("+", "", $clear_number);

    $text = "$clear_number $text. $name"; // добавляем номер телефона
    $text = strtr($text, $iso9_table); // транслитируем
    $text = preg_replace('#(?:&nbsp;)+#s', ' ', $text); // заменяем неразрывный пробел
    $text = substr($text, 0, 159); // укорачиваем до 160 символов
    $text = urlencode($text); // кодируем строку

    $body = file_get_contents( "http://sms.ru/sms/send?api_id={$api_id}&to={$to}&test=0&text=$text" );

    //    $user = file_get_contents( "http://sms.ru/sms/send?api_id=8aa58257-1a4c-bee4-6104-8d1bafac7ed4&to=$clear_number_2&test=0&text=".urlencode("Вы записались на прием") );

    echo $body;

} else { // если массив POST не был передан
    echo 'GET LOST!'; // высылаем
}