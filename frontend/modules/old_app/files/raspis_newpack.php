<?php 

include('mysql_fuction.php');
$ThisVU="administrator";
$this->title="Создание нового пакета рсписаний"; 
//include("header.php");
include("raspis_funct.php");
//                                Пошаговое создание расписаний
if (isset($_POST['next']))
{
$id=$_POST['PackID'];
$day=$_POST['step'];
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$query = "select surname,name,otch from `sotr` where id='".$_POST['vrach']."'" ;
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$s=$row['surname']." ".$row['name']." ".$row['otch']; 
if ($day==0)
{
//    Проверка есть ли у врача ПР
	$query = "select id,DateD from `raspis_pack` where vrachID='".$_POST['vrach']."'" ;
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	//////echo $query."<br>";
	if ($count>0)
	{
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$dt=explode("-",$row['DateD']);
			$dt[0]=(Integer)$dt[0];
			$dt[1]=(Integer)$dt[1];
			$dt[2]=(Integer)$dt[2];
			$dt=mktime(0,0,0,$dt[1],$dt[2],$dt[0]);
			$dt1=mktime(0,0,0,$_POST['DateDM'],$_POST['DateDD'],$_POST['DateDY']);
			echo date("d-m-Y",$dt)." ".$row['DateD']."<br>";
			echo date("d-m-Y",$dt1)." ".$_POST['DateDD']."-".$_POST['DateDM']."-".$_POST['DateDY']."<br>";
			if (($dt1<$dt) or ($dt1==$dt))
			{
				echo "Для врача ".$s." уже существует пакет расписаний, действуюший с ".date("d-m-Y",$dt);			
				ShowForm2();	
				echo "<form method='post' action='raspis.php'>";
				echo "<br />  
				<input name='next' type='submit' value='Назад'>
				</form>";
                 //include("footer.php");
				exit;
			}
		}
	}
//   Создание пакета расписаний
	$DateD=$_POST['DateDY']."-".$_POST['DateDM']."-".$_POST['DateDD'];
	$query="INSERT INTO `raspis_pack` ( `id` ,`DateD` , `vrachID` , `prodpr`)
VALUES (
NULL , '".$DateD."','".$_POST['vrach']."','".$_POST['ProdPr']."')"; 
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$query="select `id` from`raspis_pack` where `DateD`='".$DateD."' and `vrachID`='".$_POST['vrach']."' and`prodpr`='".$_POST['ProdPr']."'"; 
//////echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row= mysqli_fetch_array($result);
$id=$row['id'];
}
else
{
//Создание дней в пакетах
	$query = "select nachPr,okonchPr FROM `raspis_day` where dayN='".$day."' and rabmestoID='".$_POST['rabmesto']."' and vih=0";
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	if ($count>1)
	{
		for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				//
				$nach1=explode(":",$row['nachPr']);
				$nach1[0]=(Integer)$nach1[0];
				$nach1[1]=(Integer)$nach1[1];
				$nach1[2]=(Integer)$nach1[2];
				$nach1=mktime($nach1[0],$nach1[2],0,date("d"),date("m"),date("Y"));
				//
				$okonch1=explode(":",$row['okonchPr']);
				$okonch1[0]=(Integer)$okonch1[0];
				$okonch1[1]=(Integer)$okonch1[1];
				$okonch1[2]=(Integer)$okonch1[2];
				$okonch1=mktime($okonch1[0],$okonch1[2],0,date("d"),date("m"),date("Y"));
				//
				$nach=mktime($_POST['nachH'],$_POST['nachM'],0,date("d"),date("m"),date("Y"));
				$okonch=mktime($_POST['okonchH'],$_POST['okonchM'],0,date("d"),date("m"),date("Y"));
				//if ((($nach>$nach1) and ($nach<$okonch1)) or (($okonch>$nach1) and ($okonch<$okonch1)))
				//{
				//	echo "В это время кабинет занят ";
				//	echo "<form method='post' action='raspis_newpack.php'>";
				//	echo "<br />  
				//		<input name='next' type='submit' value='назад'>
				//		</form>";
				//	exit;
				//}
			}
    }
	$vh=$_POST['vih'];
	$nach=$_POST['nachH'].":".$_POST['nachM'].":00";
	$okonch=$_POST['okonchH'].":".$_POST['okonchM'].":00";
	$query="INSERT INTO `raspis_day` ( `id` ,`raspis_pack` , `dayN` ,`rabmestoID`, `vih` , `nachPr`, `okonchPr`) VALUES (NULL , '".$id."','".$day."','".$_POST['rabmesto']."','".$vh."','".$nach."','".$okonch."')"; 
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result); 
}
// Последний день
If ($day==7) 
{
	echo "<form method='post' action='raspis.php'>";
	echo "<h4>Пакет расписания для врача ".$s." успешно создан</h4>";
	echo "<hr />";
	echo "<br /> <input name='vvvv' type='submit' value='OK'>
	</form>";
	exit;
}
echo "<h4>Заполнете данные для врача ".$s.".<br>День недели: ".$dn[$day]."</h4>";
echo "<hr />";
//Заполнение формы
// Выходной
echo "<form method='post' action='raspis_newpack.php'>";
echo "Выходной<br><select name='vih'>";
if ($day<5) echo "<option value='1'>Да</option><option value='0' selected='selected'>Нет</option>";
else echo "<option value='1'  selected='selected'>Да</option><option value='0'>Нет</option>";
echo "        </select><br>";
//Рабочее место
echo "Рабочее место<br>
  		<label>
  		<select name='rabmesto'>";
$query = "SELECT * FROM `rabmesto`" ;
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	if ($row['id']==$_POST['rabmesto']) echo 
	"<option value='".$row['id']." 'selected='selected'>".$row['nazv']."</option>";
	else echo "<option value='".$row['id']."'>".$row['nazv']."</option>";
}
echo "  </select>
  		</label>
  		<br />";
 //начало смены
echo "Начало смены<br><select name='nachH'>";
for ($i=8; $i<21; $i++)
{
	$s="";
	if ($i==8) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}		
echo "		</select>
        ч:
		<select name='nachM'>";
for ($i=0; $i<61; $i++)
{
	$s="";
	if ($i==0) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">0".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}			
echo "</select>
        м<br>";

//окончание смены
echo "Окончание смены<br><select name='okonchH'>";
for ($i=8; $i<21; $i++)
{
	$s="";
	if ($i==20) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}		
echo "		</select>
      ч:
	<select name='okonchM'>";
for ($i=0; $i<61; $i++)
{
	$s="";
	if ($i==00) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">0".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}		
echo "		</select>
      м";
//Скрытые элементы
echo "<input name='vrach' type='hidden' value='".$_POST['vrach']."' />";
$s=$_POST['step']+1;
echo "<input name='step' type='hidden' value='".$s."' />";
echo "<input name='PackID' type='hidden' value='".$id."' />";
// Выбор
echo "<br />  
	<input name='next' type='submit' value='Дальше>>'>
	</form>";
exit;
}
///                                         Работа с старой формой 
if (isset($_POST['save']))
{
	$query = "SELECT id FROM `raspis_pack` where rabmestoID='".$_POST['rabmesto']."'" ;
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$resultA=$result;
	$countA=$count;
	for ($m=0;$m<$countA;$m++)
	{
		$rowA = mysqli_fetch_array($resultA);
		for ($i=0;$i<7;$i++)
		{
			$query = "SELECT UNIX_TIMESTAMP(nachPr),UNIX_TIMESTAMP(okonchPr) FROM `raspis_day` where 				raspis_pack='".$rowA['id']."' and dayN='".$i."'";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);        
			$row = mysqli_fetch_array($result);
			$tsN= mktime($_POST['nachH["$i"]'],$_POST['nachM["$i"]'],0,date("m"),date("d"),date("Y"));
			$tsO= mktime($_POST['okonchH["$i"]'],$_POST['okonchM["$i"]'],0,date("m"),date("d"),date("Y"));
			$tsN1= $row['nachPr'];
			$tsO1= $row['okonchPr'];
			if (((tsN>tsN1) and (tsN<tsO1)) or((tsO>tsN1) and (tsO<tsO1)))
			{
			echo "Рабочее место занято";
			ShowForm();
			exit;
			}
		}
	}
$DateD=$_POST['DateDY']."-".$_POST['DateDM']."-".$_POST['DateDD'];
$query="INSERT INTO `raspis_pack` ( `id` ,`DateD` , `vrachID` , `rabmestoID` , `prodpr`)
VALUES (
NULL , '".$DateD."','".$_POST['vrach']."','".$_POST['rabmesto']."','".$_POST['ProdPr']."')"; 
//////echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$query="select `id` from`raspis_pack` where `DateD`='".$DateD."' and `vrachID`='".$_POST['vrach']."' and `rabmestoID`='".$_POST['rabmesto']."' and`prodpr`='".$_POST['ProdPr']."'"; 
//////echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$id=$row['id'];
for ($i=0;$i<7;$i++)
{
$nach=$_POST['nachH["$i"]'].":".$_POST['nachM["$i"]'];
$nach=$nach.":00";
$okonch=$_POST['okonchH["$i"]'].":".$_POST['okonchM["$i"]'];
$okonch=$okonch.":00";
$vh=$_POST["vih[".$i."]"];
$query="INSERT INTO `raspis_day` ( `id` ,`raspis_pack` , `dayN` , `vih` , `nachPr`, `okonchPr`) 
VALUES (
NULL , '".$id."','".$i."','".$vh."','".$nach."','".$okonch."')"; 
//////echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);	
}
}
echo "<h4>Введите необходимые данные</h4>";
echo "<hr />";
ShowForm2();
//include("footer.php");
?>
