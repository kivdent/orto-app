<?php
session_start();
include('mysql_fuction.php');
$ThisVU="administrator";
$ModName="Назначение прав пользователей";
include("header.php");
//                                           Добавление новой записи Действие
if (isset($_POST['addOK']))
{
$query="INSERT INTO usersprava (id,Nazv,alias) VALUES (NULL, '".$_POST['Nazv']."', '".$_POST['alias']."')";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<h4>Запись добавлена</h4>";
echo "<hr />"; 
}
//                                           Добавление новой записи Форма
if (isset($_POST['add']))
{
echo "<form action='prpolz.php' method='post'>";
echo "Название (на латинице) <input name='Nazv' type='text' /><br>";
echo "Русская транскрипция <input name='alias' type='text' /><br>";
echo "<input name='addOK' type='submit' />";
echo "<input type='reset'  value='Сбросить'/>";
echo "</form>";
exit;
}
//                                           Удаление  записи Действие
if (isset($_POST['del']))
{
$query="delete from usersprava where id='".$_POST['id']."'";
////echo $query;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<h4>Запись удалена</h4>";
echo "<hr />"; 
}
//                                           Вывод основной таблицы

echo "<h4>Выбирите действие</h4>";
echo "<hr />";
$query="select * from usersprava";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result); 
echo "<form action='prpolz.php' method='post'>
<table width='40%' border='1' cellpadding='0' bgcolor='#ffffff' cellspacing='0' bordercolor='#000000'>";
for ($i=0; $i <$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "  <tr>";
	echo "<td width='15'><input name='id' type='radio' value='".$row['id']."' /></td>";
	echo "<td>".$row['alias']."</td>";
	echo "  </tr>";
}
echo "</table>";
echo "<br>";
echo "<input name='add' type='submit' value='Добавить'/>";
echo "<input name='del' type='submit' value='Удалить'/><br>";
echo "</form>";
include("footer.php");
?>