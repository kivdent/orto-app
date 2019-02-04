<?php 
session_start();
if (((!($_SESSION['valid_user']==$ThisVU)) and (!($ThisVU=="all"))) or (!isset($_SESSION['UserName'])))
{
echo "<title>Ошибка авторизации</title></head><body>";
echo "<h4>Ошибка авторизации</h4>";
echo "<hr />";
echo "<a href=index.php>Ввести имя пользователя и пароль</a>";
exit;
}
echo "<title>".$ModName." - Пользователь: ".$_SESSION['UserName']."</title></head><body>";
?>
