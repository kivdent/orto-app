<?php 
session_start();
include('mysql_fuction.php');
function ShowAdd($sm,$id)
{			
$query = "SELECT * FROM sotr WHERE id='".$id."'";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row2= mysqli_fetch_array($result);
echo "<form action='spr_sotr.php' method='post'><table border='0' cellpadding='0'>
<input name='id' type='hidden' value=".$id.">
  <tr>
    <td width='115' nowrap='nowrap'>Фамилия</td>
    <td width='238' nowrap='nowrap'><input name='surname' type='text' id='surname' value='".$row2['surname']."'/></td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Имя</td>
    <td width='238' nowrap='nowrap'><input name='name' type='text' id='name' value='".$row2['name']."'/></td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Отчество</td>
    <td width='238' nowrap='nowrap'><input name='otch' type='text' id='otch' value='".$row2['otch']."'/></td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Дата рождения </td>
    <td width='238' nowrap='nowrap'><select name='drD' id='drD'>";
	$drarray=explode("-",$row2['dr']);
	$drarray[0]=(Integer)$drarray[0];
	$drarray[1]=(Integer)$drarray[1];
	$drarray[2]=(Integer)$drarray[2];
	$s="";
for ($i=1; $i<32; $i++)
{
if ($i<10)
{
        if ($i==$drarray[2]) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
        else echo "<option value='0".$i."'>".$i."</option>";
}
else
        {
        if ($i==$drarray[2]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
        else echo "<option value='".$i."'>".$i."</option>";
        }
}
    echo "</select>
    /
    <select name='drM' id='drM'>";
	$s="";
for ($i=1; $i<13; $i++)
{
switch ($i)
	{
	case "1":
		$s="'>Январь</option>";
		break;
	case "2":
		$s="'>Февраль</option>";
		break;
	case "3":
		$s="'>Март</option>";
		break;
	case "4":
		$s="'>Апрель</option>";
		break;
	case "5":
		$s="'>Май</option>";
		break;
	case "6":
		$s="'>Июнь</option>";
		break;
	case "7":
		$s="'>Июль</option>";
		break;
	case "8":
		$s="'>Август</option>";
		break;
	case"9":
		$s="'>Сентябрь</option>";
		break;
	case "10":
		$s="'>Октябрь</option>";
		break;
	case "11":
		$s="'>Ноябрь</option>";
		break;
	case "12":
		$s="'>Декабрь</option>";
		break;
}
if ($i<10)
{
if ($i==$drarray[1])
        if ($i==$drarray[1]) echo "<option value='0".$i."' selected='selected".$s."</option>";
        if (!($i==$drarray[1])) echo "<option value='0".$i.$s."</option>";
}
else
        {
        if ($i==$drarray[1]) echo "<option value='".$i."' selected='selected".$s."</option>";
        if (!($i==$drarray[1])) echo "<option value='".$i.$s."</option>";
        }
}

echo "    </select>
    /
    <select name='drY' id='drY'>";
	$s="";
	for ($i=1910; $i<2008; $i++)
	{
	if ($i==$drarray[0]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
	else echo "<option value='".$i."'>".$i."</option>";
	}
echo "    </select>    </td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Дом телефон </td>
    <td width='238' nowrap='nowrap'><input name='dtel' type='text' id='dtel' value='".$row2['dtel']."'/></td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Моб телефон </td>
    <td width='238' nowrap='nowrap'><input name='mtel' type='text' id='mtel' value='".$row2['mtel']."'/></td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Адрес</td>
    <td width='238' nowrap='nowrap'><input name='adres' type='text' id='adres' value='".$row2['adres']."'/></td>
  </tr>
  <tr>
    <td width='115' nowrap='nowrap'>Должность</td>
    <td width='238' nowrap='nowrap'><select name='dolzh' id='dolzh'>
";
		$query = "SELECT `dolzh`.* FROM dolzh";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			if ($row['id']==$row2['dolzh']) echo "<option value='".$row['id']."' selected='selected'>".$row['dolzh']."</option>";
			else echo "<option value='".$row['id']."'>".$row['dolzh']."</option>";
		}
			echo "    </select>    </td>
	  </tr>
	</table>
	<input name='".$sm."' type='submit'  value='OK'/>
	</form>";
}
function ShowSotr()
{
	echo " <form  method='post'  action='spr_sotr.php'>
	<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#000000' >
	  <tr>
		<td width='20'>&nbsp;</td>
		<td width='24%'><div align='center' class='feature3'>Фамлия</div></td>
		<td width='24%'><div align='center' class='feature3'>Имя</div></td>
		<td width='24%'><div align='center' class='feature3'>Отчество</div></td>
		<td width='24%' ><div align='center' class='feature3'>Должность</div></td>
	  </tr>";
	$query = "SELECT dolzh.*, sotr.*
	FROM dolzh, sotr
	WHERE (dolzh.id=sotr.dolzh)
	ORDER BY sotr.surname ASC";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		echo "<tr>
		<td><input name='id' type='radio' value=".$row['id']."></td>
		<td class='alltext'>".$row['surname']."</td>
		<td class='alltext'>".$row['name']."</td>
		<td class='alltext'>".$row['otch']."</td>
		<td class='alltext'>".$row[1]."</td>
	  </tr>";
	}
	echo "
	</table>
	<input name='add' type='submit' value='Добавить'>
	<input name='change' type='submit' value='Изменить'>
	<input name='del' type='submit' value='Удалить'>
	</form>";
}
$ThisVU="all";
$ModName="&laquo;Сотрудники&raquo;"; 
include("header.php");
// Добавление пациента
if (isset($_POST['add']) or isset($_POST['add2']))
{
	if (!(isset($_POST['add2'])))
	{
		$sm="add2";
		ShowAdd($sm,"0");
		include("footer.php");
		exit;		
	}
	else
	{
		$dr=$_POST['drY']."-".$_POST['drM']."-".$_POST['drD'];
		$query="INSERT INTO `sotr` ( `id` , `surname` , `name` , `otch` , `dr` , `DTel`,`MTel` ,`adres`,`dolzh`) 
		VALUES (
		NULL , '".$_POST['surname']."','".$_POST['name']."','".$_POST['otch']."','".$dr."','".$_POST['dtel']."','".$_POST['mtel']."','".$_POST['adres']."','".$_POST['dolzh']."')"; 
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	}
}
//удаление
if (isset($_POST['del'])) 
{
	if (!isset($_POST['id'])) 
	{
		echo "<div class='head1'>Выбирите запись!</div>";
	}
	else
	{
		$query="delete from sotr where id='".$_POST['id']."'";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	}
}
//Изменение
if (isset($_POST['change']) or (isset($_POST['change2'])) )
{
	if (!isset($_POST['change2']))
	{	
	if (!isset($_POST['id'])) 
		{
			echo "<div class='head1'>Выбирите запись!</div>";
		}
		else
		{	
			//$_SESSION['id']=$_POST['id'];
			$sm="change2";
			ShowAdd($sm,$_POST['id']);
			include("footer.php");
			exit;	
		}	
	}
	else
	{
		$dr=$_POST['drY']."-".$_POST['drM']."-".$_POST['drD'];
		$query = "UPDATE `sotr` 
		SET
		`surname`='".$_POST['surname']."', 
		`name`='".$_POST['name']."', 
		`otch`='".$_POST['otch']."', 
		`dr`='".$dr."', 
		`dtel`='".$_POST['dtel']."', 
		`mtel`='".$_POST['mtel']."', 
		`adres`='".$_POST['adres']."', 
		`dolzh`='".$_POST['dolzh']."'
		WHERE `id`=".$_POST['id'] ;
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	}
}

if (!(isset($_POST['add']))) 
ShowSotr();
include("footer.php");
?>
