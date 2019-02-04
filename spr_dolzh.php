<?php
$ThisVU="administrator";
$ModName="Справочник &laquo;Должности&raquo;"; 
include("header.php");
if (isset($_POST['del']))
{
	if (isset($_POST['id']))
	{
		$query="delete from dolzh  where id='".$_POST['id']."'";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		echo "<div class='head1'>Запись удалена<br>
		<a href='spr_dolzh.php'>назад</a></div>";
	}
	else
	{
		echo "<div class='head1'>Запись не выбрана.<br>
		<a href='spr_dolzh.php'>назад</a></div>";
	}
}
if (isset($_POST['add']))
{
	if (isset($_POST['dolzh']))
	{
		$query = "INSERT INTO `dolzh` ( `id` , `dolzh` ) 
		VALUES (
		NULL , '".$_POST['dolzh']."'
		)";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		echo "<div class='head1'>Доложность '".$_POST['dolzh']."' успешно добавлена<br>
		<a href='spr_dolzh.php'>Назад</a></div>";
	}
	else
	{
		echo "<form method='post' action='spr_dolzh.php'>  
					Новая должность: <input type='text' name='dolzh' /><br />
					<input name='add' type='submit'  value='Добавить'/>
					</form>";
	}
	include("footer.php");
	exit;
}
$query = "SELECT * FROM dolzh";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<form action='spr_dolzh.php' method='post'>
<table width='40%' border='0' cellpadding='0' bgcolor='#ffffff' cellspacing='0' bordercolor='#000000'>";
for ($i=0; $i <$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "  <tr>";
	echo "<td width='15'><input name='id' type='radio' value='".$row['id']."' /></td>";
	echo "<td>".$row['dolzh']."</td>";
	echo "  </tr>";
}
echo "</table>";
echo "<br>";
echo "<input name='add' type='submit' value='Добавить'/>";
echo "<input name='del' type='submit' value='Удалить'/><br>";
echo "</form>";
include("footer.php");
?>