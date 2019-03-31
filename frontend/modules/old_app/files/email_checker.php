<?php
$ThisVU="all";
$this->title="Проверка Емайлов по имап"; 
//include("header.php");
echo "<div class='head1'>Проверка емайлов</div>";
phpinfo();
// email с которого слушать команды
$controlEmail = "ipatovsoft@gmail.com";
// логин
$email = "reg@orto-premier.ru";
// пароль
$password = "!445223reg";
// соединяемся с почтовым сервером, в случае ошибки выведем ее на экран
$connectImap = imap_open("{imap.orto-premier.ru:143}INBOX", $email, $password) OR die("Error:" . imap_last_error());
// проверим ящик на наличие новых писем
$mails = imap_search($connectImap, 'NEW');
// если есть новые письма

if($mails){
    
    // открываем каждое новое письмо
    $i=0;
    foreach($mails as $oneMail){
        $i++;
        // получаем заголовок
        $header = imap_header($connectImap, $oneMail);
        // достаем ящик отправителя письма
        $mailSender = $header->sender[0]->mailbox . "@" . $header->sender[0]->host;
        // проверяем, тот ли ящик прислал письмо
        echo $i." Отправитель: ".$mailSender." </br>";
        $subject = $header->subject;
        echo "Тема: ".$subject." </br>";
        $text= imap_fetchbody($connectImap, $oneMail, 1); 
        echo "Текст: ".$text." </br>";
    }
}
else {
    echo "Новых писем нет";
}
// закрываем соединение
imap_close($connectImap);


?>