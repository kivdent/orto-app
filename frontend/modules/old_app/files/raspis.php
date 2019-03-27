<?php include("header.php");
$ThisVU="administrator";
$ModName="Работа с рсписанием"; 
include("validuser.php");
echo "<h4>Выбирите продолжение</h4>";
echo "<hr />"; 
echo "<a href='raspis_newpack.php'>Создание нового пакета расписаний</a><br>";
echo "<a href='raspis_show.php'>Ежедневник<br></a>";
echo "<a href='raspis_change.php'>Изменить расписание<br></a>";
echo "<a href='naznach_pat.php'>Назначение пациентов<br></a>";
include("footer.php");
?>
