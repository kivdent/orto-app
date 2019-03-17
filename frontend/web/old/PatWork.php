<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Работа с пациентами"; 
$js="ShowPat";
include("header.php");
include("PatFunct.php");
//Изменение
if (isset($_POST['showcard']))
{
	echo "
	<script language=\"JavaScript\" type=\"text/javascript\">
		onclick='openPatWin(\"".$_POST['element']."\",\"0\")'
	</script>
	";
	ret("pat.php");
}
if (isset($_POST['Change']))
{
echo "<h4>Изменение данных о пациенте".$_POST['surname']." ".$_POST['name']." ".$_POST['otch']."</h4>";
echo "<hr />";
$dr=$_POST['dry']."-".$_POST['drm']."-".$_POST['drd'];
msg($_POST['adres']);
$query="UPDATE `klinikpat` SET 
`surname`='".$_POST['surname']."', 
`name`='".$_POST['name']."', 
`otch`='".$_POST['otch']."', 
`dr` ='".$dr."', 
`sex`='".$_POST['sex']."', 
`adres`='".$_POST['adres']."', 
`MestRab`='".$_POST['MestRab']."', 
`prof`='".$_POST['prof']."', 
`email`='".$_POST['email']."', 
`DTel`='".$_POST['DTel']."', 
`RTel` ='".$_POST['RTel']."', 
`MTel`='".$_POST['MTel']."', 
`FLech`='".$_POST['FLech']."',
`Skidka`='".$_POST['Skidka']."', 
`Prim` ='".$_POST['Prim']."' 
 where CONCAT( `id` )=".$_POST['id'];
 //echo $query;
$result=sql_query($query,'orto',0);     
//ret ("pat_card.php?id=".$_POST['id']);
}
//Удаление
if (isset($_POST['del'])) 
{
	if (!isset($_POST['element'])) 
	{
	echo "Выбирите запись!";
	ret("Pat.php");
	exit;
	}
echo "Удаление записи";
$query="delete from klinikpat where id='".$_POST['element']."'";
ret("Pat.php");
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
}
//Редактирование
if (isset($_POST['redact']))
{
	if (!isset($_POST['element'])) 
	{
	echo "Выбирите запись!";
	ShowPat();
	exit;
	}
$query="select * from klinikpat where id='".$_POST['element']."'";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$rowA = mysqli_fetch_array($result);
echo "<h4>Введите данные о пациенте ".$rowA['surname']." ".$rowA['name']." ".$rowA['otch']."</h4>";
echo "<hr />";
echo "<form method='post' action='PatWork.php'>";
echo "<input name='id' type='hidden' value='".$rowA['id']."' />";
echo "  <table width='600' border='0'>";
echo "    <tr>";
echo "      <td width='100'>&nbsp;</td>";
echo "      <td width='304'>&nbsp;</td>";
echo "      <td width='101'>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Фамилия</td>";
echo "      <td><label>";
echo "        <input type='text' name='surname' value='".$rowA['surname']."'/>";
echo "      </label></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Имя</td>";
echo "      <td><input type='text' name='name' value='".$rowA['name']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Отчество</td>";
echo "      <td><input type='text' name='otch' value='".$rowA['otch']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
$drarray=explode("-",$rowA['dr']);
$drarray[0]=(Integer)$drarray[0];
$drarray[1]=(Integer)$drarray[1];
$drarray[2]=(Integer)$drarray[2];
echo "      <td>Дата рождения</td>";
echo "      <td>День";
echo "       <select name='drd'>";
$s="";
for ($i=1; $i<32; $i++)
{
if ($i<10)
{
if ($i==$drarray[2])
        if ($i==$drarray[2]) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
        if (!($i==$drarray[2])) echo "<option value='0".$i."'>".$i."</option>";
}
else
        {
        if ($i==$drarray[2]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
        if (!($i==$drarray[2])) echo "<option value='".$i."'>".$i."</option>";
        }
}
echo "        </select>";
echo "       Месяц  ";
echo "       <label>";
echo "        <select name='drm' size='1'>";
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
echo "        </select>";
echo "      Год";
echo "      <select name='dry'>";
$s="";
for ($i=1910; $i<2008; $i++)
{
	if ($i==$drarray[0]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
	else echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select>";
echo "      </label></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Пол</td>";
echo "      <td>";
echo "        <select name='sex'>";
if ($rowA['sex']=='Муж')
{
	echo "          <option value='Муж' selected='selected'>Муж</option>";
	echo "          <option value='Жен'>Жен</option>";
}
else
{
	echo "          <option value='Муж'>Муж</option>";
	echo "          <option value='Жен' selected='selected'>Жен</option>";
}
echo "        </select></td>";

echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Адрес</td>";
echo "      <td>";
echo "        <textarea name='adres' cols='60' rows='4' value='".$rowA['adres']."'></textarea></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Место работы</td>";
echo "      <td><input type='text' name='MestRab' value='".$rowA['MastRab']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Профессия</td>";
echo "      <td><input type='text' name='prof' value='".$rowA['Prof']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>E-mail</td>";
echo "      <td><input type='text' name='email' value='".$rowA['email']."'/></td>";
echo "     <td>&nbsp;</td>";
echo "   </tr>";
echo "    <tr>";;
echo "      <td>Дом телефон </td>";
echo "      <td><input type='text' name='DTel' value='".$rowA['DTel']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "     <td>Раб. Телефон </td>";
echo "      <td><input type='text' name='RTel' value='".$rowA['RTel']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Мобильный телефон </td>";
echo "      <td><input type='text' name='MTel' value='".$rowA['MTel']."'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Скидка</td>";
echo "      <td><select name='Skidka'>";
$query = "SELECT *
FROM skidka" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if($row['id']==$rowA['Skidka']) echo "<option value='".$row['id']."' selected='selected'>".$row['naimenov']."</option>";
	else echo "<option value='".$row['id']."' >".$row['naimenov']."</option>";
}
echo "
</select>
</td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Примечание</td>";
echo "      <td><textarea name='Prim' cols='60' rows='4' value='".$rowA['Prim']."'></textarea></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "  </table>";
echo "<input name='Change' type='submit' value='Сохранить изменения' />";
echo "<input type='submit' name='Cancel' value='Отменить' />";
echo "<input value='Очистить'  type='reset'/>";
echo "</form>";
}
if (isset($_POST['Save'])) 
{


$query = "SELECT `id` FROM `klinikpat` ORDER BY `id`";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);

$id=1;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (($i+1)!=$row['id']) 
	{
		$id=$i+1;
		$i=$count;
	}
	
}
	
   if ($id==1)
   {
	$dr=$_POST['dry']."-".$_POST['drm']."-".$_POST['drd'];
	$query="INSERT INTO `klinikpat` ( `id` , `surname` , `name` , `otch` , `dr` , `sex` , `adres` , `MestRab` , `prof` , `email` , `DTel` , `RTel` , `MTel` , `FLech` , `Skidka` , `Prim` ) 
	VALUES (
	NULL , '".$_POST['surname']."','".$_POST['name']."','".$_POST['otch']."','".$dr."', '".$_POST['sex']."','".$_POST['adres']."','".$_POST['MestRab']."','".$_POST['prof']."','".$_POST['email']."','".$_POST['DTel']."','".$_POST['RTel']."','".$_POST['MTel']."','".$_POST['FLech']."','".$_POST['Skidka']."', '".$_POST['Prim']."')";
	 }
	 else
	    {
	$dr=$_POST['dry']."-".$_POST['drm']."-".$_POST['drd'];
	$query="INSERT INTO `klinikpat` ( `id` , `surname` , `name` , `otch` , `dr` , `sex` , `adres` , `MestRab` , `prof` , `email` , `DTel` , `RTel` , `MTel` , `FLech` , `Skidka` , `Prim` ) 
	VALUES (
	".$id." , '".$_POST['surname']."','".$_POST['name']."','".$_POST['otch']."','".$dr."', '".$_POST['sex']."','".$_POST['adres']."','".$_POST['MestRab']."','".$_POST['prof']."','".$_POST['email']."','".$_POST['DTel']."','".$_POST['RTel']."','".$_POST['MTel']."','".$_POST['FLech']."','".$_POST['Skidka']."', '".$_POST['Prim']."')";
	 }
	 msg($_POST['adres']);
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);    
                   $count=mysqli_num_rows($result);
	$query="SELECT  `id` 
	 FROM `klinikpat`
	 WHERE ((`surname`='".$_POST['surname']."') AND
	 (`name`='".$_POST['name']."') AND
	 ( `otch`= '".$_POST['otch']."') AND
	 (`dr`= '".$dr."') AND
	 (`sex`= '".$_POST['sex']."') AND
	 (`adres`='".$_POST['adres']."') AND
	 (`MestRab`= '".$_POST['MestRab']."') AND
	 (`prof`= '".$_POST['prof']."') AND
	 (`email`='".$_POST['email']."' ) AND
	 (`DTel`='".$_POST['DTel']."' ) AND
	 (`RTel`='".$_POST['RTel']."' ) AND
	 (`MTel`= '".$_POST['MTel']."') AND
	 (`FLech`= '".$_POST['FLech']."') AND
	 (`Skidka`='".$_POST['Skidka']."') AND
	 (`Prim`='".$_POST['Prim']."'))";
	 //echo $query."<br />"; 
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	
	$row = mysqli_fetch_array($result);
	msg("Добавлен пациент".$_POST['surname']." ".$_POST['name']." ".$_POST['otch'].". Карта №".$row['id']);		
	echo "<hr />";
	ShowPat();
}

if (isset($_POST['add']) or isset($_GET['add'])) 
{
PatForm();
}
include("footer.php");
?>