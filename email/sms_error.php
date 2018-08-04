<?php

if ($_POST) { // если передан массив POST
//    $email = "levasheva.tatiana@mail.ru";
    $email = "omigos99@yandex.ru";
    $from_email = "from-site@ballroom-rostov.ru";
    
    $message = htmlspecialchars($_POST["message"]);
    $type = htmlspecialchars($_POST["type"]);
    $status = htmlspecialchars($_POST["status"]);
    if (!$message) { // если хоть одно поле оказалось пустым
        echo "0";
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

    $CodeTranstale = array(
        'send'    =>  array(
            '100'    =>  'Сообщение принято к отправке',
            '200'    =>  'Неправильный api_id',
            '201'    =>  'Не хватает средств на лицевом счету',
            '202'    =>  'Неправильно указан получатель',
            '203'    =>  'Нет текста сообщения',
            '204'    =>  'Имя отправителя не согласовано с администрацией',
            '205'    =>  'Сообщение слишком длинное (превышает 5 СМС)',
            '206'    =>  'Превышен дневной лимит на отправку сообщений',
            '207'    =>  'На этот номер нельзя отправлять сообщения',
            '208'    =>  'Параметр time указан неправильно',
            '210'    =>  'Используется GET, где необходимо использовать POST',
            '211'    =>  'Метод не найден',
            '220'    =>  'Сервис временно недоступен, попробуйте чуть позже.',
        ),
        'status'  =>  array(
            '-1'     =>  'Сообщение не найдено',
            '100'    =>  'Сообщение находится в очереди',
            '101'    =>  'Сообщение передается оператору',
            '102'    =>  'Сообщение отправлено (в пути)',
            '103'    =>  'Сообщение доставлено',
            '104'    =>  'Не может быть доставлено: время жизни истекло',
            '105'    =>  'Не может быть доставлено: удалено оператором',
            '106'    =>  'Не может быть доставлено: сбой в телефоне',
            '107'    =>  'Не может быть доставлено: неизвестная причина',
            '108'    =>  'Не может быть доставлено: отклонено',
            '200'    =>  'Неправильный api_id',
            '210'    =>  'Используется GET, где необходимо использовать POST',
            '211'    =>  'Метод не найден',
            '220'    =>  'Сервис временно недоступен, попробуйте чуть позже',
        ),
        'custom'  =>  array(
            '1'      =>  'Превышено время ожидания отправки сообщения, т. е. sms долго не приходила на телефон',
        )
    );

    sms_send_mime_mail(
        $from_email, // Ваш электронный адрес
        $email, // Ваш уникальный адрес в системе SMS.RU
        "UTF-8", // кодировка, в которой находятся передаваемые строки
        "UTF-8", // кодировка, в которой будет отправлено письмо
        "Ошибка отправки сообщения с Ballroom-Rostov.ru", // заголовок письма (здесь указываются параметры)
        "Произошел сбой в отправки SMS<br>".
        "Код статуса: «<b>$status</b>»<br>".
        "Ошибка в случае: «<b>$type</b>»<br>".
        "Расшифровка кода: «<b>".$CodeTranstale[$type][$status]."</b>»<br>".
        "Текст сообщения: «<b>$message</b>»<br>".
        ""
    );

    echo $CodeTranstale[$type][$status];

} else { // если массив POST не был передан
    echo 'GET LOST!'; // высылаем
}
