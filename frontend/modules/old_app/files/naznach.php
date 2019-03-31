<?php 

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Работа с рсписанием";
$js="ShowPat"; 

//include("header.php");

//Отмена
//if (($_SESSION['action']='naznezh') and (!(isset($_GET['IDN'])))) unset($_SESSION['action']);
switch ($_SESSION['action'])
{
	case "peren":
	switch ($_SESSION['step'])
				{
					case "2":
					
						$query = "SELECT `PatID` FROM `nazn` WHERE `Id`=".$_SESSION['IDN'];
						echo $query."<br /> peren";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
						$s="naznach.php?perv=10&vrach=".$_GET['vrach']."&nach=".$_GET['date']."&okonchS=".$_GET['okonchS']."&idDP=".$_GET['idDP']."&nachS=".$_GET['nachS']."&RMID=".RMID."&prodpr=".$_GET['prodpr']."&element=".$row[0];
						$query = "DELETE FROM `nazn` WHERE `Id`=".$_SESSION['IDN'];
						//echo $query."<br />";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						unset($_SESSION['IDN']);
						unset($_SESSION['step']);
						unset($_SESSION['action']);
						ret($s);
					break;
				}
	break;
	case "naznezh":
		switch ($_SESSION['step'])
				{
					case "2":
						if ($_SESSION['IDN']!='n')  
						{
						$query = "SELECT `PatID` FROM `nazn` WHERE `Id`=".$_SESSION['IDN'];
						//echo $query."<br /> naznezh";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
						}
						else $row[0]=$_SESSION['pat'];
						$s="naznach.php?perv=10&vrach=".$_GET['vrach']."&nach=".$_GET['date']."&okonchS=".$_GET['okonchS']."&idDP=".$_GET['idDP']."&nachS=".$_GET['nachS']."&RMID=".RMID."&prodpr=".$_GET['prodpr']."&element=".$row[0];
						//$query = "DELETE FROM `nazn` WHERE `Id`=".$_SESSION['IDN'];
						////echo $query."<br />";
						//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						unset($_SESSION['IDN']);
						unset($_SESSION['step']);
						unset($_SESSION['action']);
						unset($_SESSION['pat']);
						ret($s);
					break;
				}
	break;
}
if (isset($_GET['IDN']))
{
	switch ($_GET['action'])
	{
		case "del":
			$query = "DELETE FROM nazn WHERE (`nazn`.`Id` ='".$_GET['IDN']."')";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			if (isset($_GET['pred']))
			{
				$q=$_GET['pred'];
				unset($_GET['pred']);
				ret($q);
			}
			else
			{
				switch ($_SESSION['valid_user'])
				{
					case "terapevt":
						ret("pat_tooday.php");
					break;
					case "ortoped":
						ret("pat_tooday_orto.php");
					break;
					case "ortodont":
						ret("pat_tooday_orto.php");
					break;
					case "registrator":
						ret("pat_tooday_reg.php");
					break;
					case "gigienist":
						ret("pat_tooday_gig.php");
					break;
				}
			}	
		break;
		case "ctime":
			switch ($_GET['step'])
			{
				case "1":
				$query = "SELECT 
				`klinikpat`.`surname`, 
				`klinikpat`.`name`, 
				`klinikpat`.`otch`, 
				`daypr`.`Okonch`, 
				`nazn`.`NachNaz`,
				`daypr`.`date`
							FROM nazn, daypr, klinikpat
							WHERE ((`nazn`.`Id` =".$_GET['IDN'].") AND 
							(`daypr`.`id` =`nazn`.`dayPR`) AND 
							(`klinikpat`.`id` =`nazn`.`PatID`))";
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$dt=explode("-",$row[5]);
				$t=explode(":",$row[3]);
				echo "Пациент: ".$row[0]." ".$row[1]." ".$row[2];
				$PD=mktime($t[0],$t[1],$t[2],$dt[1],$dt[3],$dt[0]); 
				echo "<div class='bold2'>Дата ".$dt[2].".".$dt[1].".".$dt[0]."</div> 
					   <form action='naznach.php' method='get'>
					   <input name='action' type='hidden' value='ctime' />
					   <input name='step' type='hidden' value='2' />
					   <input name='IDN' type='hidden' value='".$_GET['IDN']."' />
					   <input name='pred' type='hidden' value='".$_GET['pred']."' />
					   <table width='300' border='0' cellspacing='1'>
					   <td>Прод приёма</td>
						<td><label>";
				$t=explode(":",$row[4]);
				echo "C <input name='' type='text' value='".$t[0].":".$t[1]."' maxlength='2'  size='2' />-<select name='okonchPr'>";
						//Продолжительность приёма
						$delta=15*60;
						$okonch=(mktime($t[0],$t[1],$t[2],$dt[1],$dt[3],$dt[0])+$delta);
						while ($okonch<=$PD)
						{
								$query = " SELECT `nazn`.`NachNaz`
											FROM nazn
											WHERE ((`nazn`.`dayPR` ='".$_GET['idDP']."') 
											   AND (`nazn`.`NachNaz` ='".date('H:i',$okonch)."'))";
											   //echo $query."<br />";
								$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
								if ($count>0)
								{
									$PD=$okonch;
								}
							echo "<option value='$okonch'>".date('G:i',$okonch)."</option>";
							$okonch=$okonch+$delta;
						}	
						echo"</select>";
						echo"  </label></td>
							</tr>
						  </table>
						  <center><input name='ok' type='submit' value='Дальше>>'/></center>
						  </form>";
				break;
				case "2":
					$query = "UPDATE `nazn` 
						SET `OkonchNaz`='".date('H:i',$_GET['okonchPr']).":00'
						WHERE `Id`=".$_GET['IDN'];
					//echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					ret($_GET['pred']);
				break;
			}
		break;
		case "peren":
			switch ($_GET['step'])
			{
				case "1":
					$_SESSION['step']=2;
					$_SESSION['action']=$_GET['action'];
					$_SESSION['pred']=$_GET['pred'];
					$_SESSION['IDN']=$_GET['IDN'];
					ret("naznach_pat.php");
				break;
			}	
		break;
		case "naznezh":
			switch ($_GET['step'])
			{

				case "1":
					$_SESSION['action']=$_GET['action'];
				   $_SESSION['step']=2;
					$_SESSION['pred']=$_GET['pred'];
					$_SESSION['IDN']=$_GET['IDN'];///111
					if (isset($_GET['pat'])) $_SESSION['pat']=$_GET['pat'];
					ret("naznach_pat_full.php?vrach=".$_GET['vrach']);
				break;
//				case "2":
//					$query = "SELECT `PatID` FROM `nazn` WHERE `Id`=".$_SESSION['IDN'];
//					//echo $query."<br />";
//					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//					$row = mysqli_fetch_array($result);
//					$s="naznach.php?perv=10&vrach=".$_GET['vrach']."&nach=".$_GET['date']."&okonchS=".$_GET['okonchS']."&idDP=".$_GET['idDP']."&nachS=".$_GET['nachS']."&RMID=".RMID."&prodpr=".$_GET['prodpr']."&element=".$row[0];
//					//echo $query."<br />";
//					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//					unset($_SESSION['IDN']);
//					unset($_SESSION['step']);
//					ret($s);
//				break;
			}	
		break;
	}
} 
if (isset($_GET['date'])) echo "<div class='head1'>Назначение на приём ".date('d.m.Y',$_GET['date'])."</div>";
else echo "<div class='head1'>Назначение на приём </div>";
if ((!isset($_GET['perv'])) and (!isset($_GET['IDN'])))
{ 
	echo "<hr width='100%' noshade='noshade' size='1'/>"; 
	if ((isset($_GET['pred'])) and (!isset($_SESSION['pred'])))
		{
			$_SESSION['pred']=$_GET['pred'];
		}
	echo "<a href='naznach.php?perv=1&date=".$_GET['date']."&prodpr=".$_GET['prodpr']."&vrach=".$_GET['vrach']."&okonchS=".$_GET['okonchS']."&idDP=".$_GET['idDP']."&nachS=".$_GET['nachS']."&RMID=".$_GET['RMID']."' class='menu2'>Первичный</a>   
<br />    
<a href='naznach.php?perv=0&date=".$_GET['date']."&prodpr=".$_GET['prodpr']."&vrach=".$_GET['vrach']."&okonchS=".$_GET['okonchS']."&idDP=".$_GET['idDP']."&nachS=".$_GET['nachS']."&RMID=".$_GET['RMID']."' class='menu2'>Повторный</a>";
}
// Назначение пациентов
switch ($_GET['perv'])
{
////////первичный
	case "1":
		echo "		<form id='form1' name='form1' method='get' action='naznach.php' >
					<input name='perv' type='hidden' value='11' />
					<input name='vrach' type='hidden' value='".$_GET['vrach']."' />
					<input name='nach' type='hidden' value='".$_GET['date']."' />
					<input name='okonchS' type='hidden' value='".$_GET['okonchS']."' />
					<input name='idDP' type='hidden' value='".$_GET['idDP']."' />
					<input name='nachS' type='hidden' value='".$_GET['nachS']."' />
					<input name='RMID' type='hidden' value='".$_GET['RMID']."' />
					<input name='prodpr' type='hidden' value='".$_GET['prodpr']."' />
					<div class='bold2'>Дата ".date('d.m.Y',$_GET['date'])."</div> 
					  <table width='300' border='0' cellspacing='1'>
						<tr>
						  <td width='40%'>Фамилия</td>
						  <td width='60%'><label>
							<input type='text' name='surname' onKeyUp='BIG(this)'/>
						  </label></td>
						</tr>
						<tr>
						  <td>Имя</td>
						  <td><label>
							<input type='text' name='name' onKeyUp='BIG(this)'/>
						  </label></td>
						</tr>
						<tr>
						  <td>Отчество</td>
						  <td><label>
						  <input type='text' name='otch' onKeyUp='BIG(this)'/>
						  </label></td>
						</tr>
						<tr>
						  <td>Дом телефон</td>
						  <td><label>
							<input type='text' name='DTel' />
						  </label></td>
						</tr>
						<tr>
						  <td>Моб телефон </td>
						  <td><label>
							<input type='text' name='MTel' />
						  </label></td>
						</tr>
						<tr>
						  <td>Раб телефон </td>
						  <td><label>
							<input type='text' name='RTel' />
						  </label></td>
						</tr>
						<tr>
						  <td>Прод приёма</td>
						    <td><label>
							C <input name='' type='text' value='".date('G:i',$_GET['date'])."' maxlength='2'  size='2'/>-<select name='okonchPr'>";
					
					//Продолжительность приёма
					$delta=15*60;
					$okonch=($_GET['date']+$delta);
					$PD=$_GET['okonchS'];
					while ($okonch<=$PD)
					{
						if (!($_GET['idDP']=="N"))
						{
							$query = " SELECT `nazn`.`NachNaz`
										FROM nazn
										WHERE ((`nazn`.`dayPR` ='".$_GET['idDP']."') 
										   AND (`nazn`.`NachNaz` ='".date('H:i',$okonch)."'))";
										   //echo $query."<br />";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							if ($count>0)
							{
								$PD=$okonch;
							}
						}
						echo "<option value='$okonch'>".date('G:i',$okonch)."</option>";
						$okonch=$okonch+$delta;
					}	
					echo"</select>
						  </label></td>
						</tr>
						<tr>
						  <td>Цель приёма</td>
						  <td><label>
							<select name='SoderzhNaz'>";
							$query = "SELECT `soderzhnaz`.* FROM soderzhnaz";
							//echo $query."<br />";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							
							for($i;$i<$count;$i++) 
							{
								$row = mysqli_fetch_array($result);
								echo "<option value='".$row['id']."'>".$row['SoderzhNaz']."</option>"; 							}
							echo"</select>
						  </label></td>
						</tr>
						<tr>
						  <td>Примечание</td>
						  <td><label>
							<input name='prim' type='text' />
						  </label></td>
						</tr>
					  </table>
					  <table width='300' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='center'><input name='OK' type='submit'  value='OK'/></td>
					  </tr>
					</table>
					
					</form>";	
	break;
//////////////////////ПОВТОРНЫЙ	
	case "0":
	echo "<h4>Выбирите пациента из списка</h4>";
	echo "<hr width='100%' noshade='noshade' size='1'/>";
	//////создание списка пациентов
		echo "<center><form action='naznach.php' method='get' name='fform' id='fform'>";
		echo "<input name='perv' type='hidden' value='0' />			
	<input name='vrach' type='hidden' value='".$_GET['vrach']."' />";
	if (isset($_GET['date']))echo "<input name='nach' type='hidden' value='".$_GET['date']."' />";
	if (isset($_GET['nach']))echo "<input name='nach' type='hidden' value='".$_GET['nach']."' />";
echo "	<input name='okonchS' type='hidden' value='".$_GET['okonchS']."' />
	<input name='idDP' type='hidden' value='".$_GET['idDP']."' />
	<input name='nachS' type='hidden' value='".$_GET['nachS']."' />
	<input name='RMID' type='hidden' value='".$_GET['RMID']."' />
	<input name='prodpr' type='hidden' value='".$_GET['prodpr']."' />";

	if ($_GET['FindFl']!='1')
	{
	$query = 'select id,surname,name,otch,dr from klinikpat order by surname';
	
	echo "<input name=\"find\" type=\"text\" onKeyUp='findP(this)' tabindex='1'/><br />
	<input name=\"FindFl\" type=\"hidden\" value=\"0\" />";
}
else
{
	$query = "select id,surname,name,otch,dr from klinikpat 
	where  surname like '".$_GET['find']."%'
	order by surname";
	echo "
	<input name=\"find\" type=\"text\" value='".$_GET['find']."' onKeyUp='findP(this)' tabindex='1'/><br />
	<input name=\"FindFl\" type=\"hidden\" value=\"0\" />";
}
echo "</form></center>";
	echo "<form action='naznach.php' method='get' name='fform1' id='fform1'>";
	echo "	<input name='perv' type='hidden' value='10' />";
	if (isset($_GET['date']))echo "<input name='nach' type='hidden' value='".$_GET['date']."' />";
	if (isset($_GET['nach']))echo "<input name='nach' type='hidden' value='".$_GET['nach']."' />";
					echo "<input name='vrach' type='hidden' value='".$_GET['vrach']."' />
					<input name='okonchS' type='hidden' value='".$_GET['okonchS']."' />
					<input name='idDP' type='hidden' value='".$_GET['idDP']."' />
					<input name='nachS' type='hidden' value='".$_GET['nachS']."' />
					<input name='RMID' type='hidden' value='".$_GET['RMID']."' />
					<input name='prodpr' type='hidden' value='".$_GET['prodpr']."' />
					<center>
          Список пациентов клиники:<br />";

	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			if ($count>25) echo "<select name='element' size='25' ondblclick='document.fform1.submit()'>";
			else  echo "<select name='element' size='".$count."' ondblclick='document.fform1.submit()'>";
			for ($i=0; $i <$count; $i++)
			{
				$row = mysqli_fetch_array($result);
				echo    "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
			}
	echo "</select>
      <br />
      <input type='submit' name='Submit2' value='Выбрать' />
    </center>
	</form>";
	break;
	/////Запись первичного
	case "11":
		
		$query = "SELECT `id` FROM `klinikpat` ORDER BY `id`";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$id=0;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (($i+1)!=$row['id']) 
	{
		$id=$i+1;
		$i=$count;
	}
	
}
	
   if ($id==0)
  {
		$query="INSERT INTO `klinikpat` ( `id` , `surname` , `name` , `otch` , `DTel` , `RTel` , `MTel`, `Prim`,`dr`) 
VALUES (
NULL , '".$_GET['surname']."','".$_GET['name']."','".$_GET['otch']."','".$_GET['DTel']."','".$_GET['RTel']."','".$_GET['MTel']."', '".$_GET['Prim']."', '1000-01-01')"; 
}
else
{
	$query="INSERT INTO `klinikpat` ( `id` , `surname` , `name` , `otch` , `DTel` , `RTel` , `MTel`, `Prim`,`dr`) 
VALUES (
'".$id."' , '".$_GET['surname']."','".$_GET['name']."','".$_GET['otch']."','".$_GET['DTel']."','".$_GET['RTel']."','".$_GET['MTel']."', '".$_GET['Prim']."', '1000-01-01')"; 
}
//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "SELECT `klinikpat`.*
FROM klinikpat
WHERE ((`klinikpat`.`surname` ='".$_GET['surname']."') AND (`klinikpat`.`name` ='".$_GET['name']."') AND (`klinikpat`.`otch` ='".$_GET['otch']."'))";
//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$patId=$row['id'];
		if ($_GET['idDP']=="N")
		{/////////////////Создание нгового дня расписания
			$query = "INSERT INTO `daypr` ( `id` , `date` , `vih` , `rabmestoID` , `Nach` , `Okonch` , `TimePat` , `vrachID` ) 
	VALUES (
	NULL , '".date('Y-m-d',$_GET['nach'])."', '0', '".$_GET['RMID']."', '".date('H:i',$_GET['nachS']).":00', '".date('H:i',$_GET['okonchS']).":00', '".$_GET['prodpr']."', '".$_GET['vrach']."')";
	//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$query = "SELECT *
FROM daypr
WHERE ((`daypr`.`date` ='".date('Y-m-d',$_GET['nach'])."') AND (`daypr`.`vrachID` ='".$_GET['vrach']."'))";
//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$dayPR=$row['id'];
		}
		else $dayPR=$_GET['idDP'];
		$query = "INSERT INTO `nazn` (`Id`, `Perv`, `PatID`, `dayPR`, `NachNaz`, `OkonchNaz`, `SoderzhNaz`,`NachPr`, `OkonchPr`) "
                        . "VALUES (NULL, '1', '".$patId."', '".$dayPR."', '".date('H:i',$_GET['nach']).":00',  '".date('H:i',$_GET['okonchPr']).":00','".$_GET['SoderzhNaz']."', '00:00:00', '00:00:00')";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if (isset($_SESSION['pred']))
		{
			$q=$_SESSION['pred'];
			unset($_SESSION['pred']);
			ret($q);
		}
		else
		{
			switch ($_SESSION['valid_user'])
			{
				case "terapevt":
					ret("pat_tooday.php");
				break;
				case "ortoped":
					ret("pat_tooday_orto.php");
				break;
				case "ortodont":
					ret("pat_tooday_orto.php");
				break;
				case "registrator":
					ret("pat_tooday_reg.php");
				break;
				case "gigienist":
					ret("pat_tooday_gig.php");
				break;
			}
		}
	break;
	case "10":
			if (!(isset($_GET['element'])))
			{
				msg('Выбирите пациента из списка');
				echo "<form method='get' action='naznach.php' name='f1' id='f1'>
					<input name='perv' type='hidden' value='0' />
					<input name='vrach' type='hidden' value='".$_GET['vrach']."' />
					<input name='date' type='hidden' value='".$_GET['nach']."' />
					<input name='okonchS' type='hidden' value='".$_GET['okonchS']."' />
					<input name='idDP' type='hidden' value='".$_GET['idDP']."' />
					<input name='nachS' type='hidden' value='".$_GET['nachS']."' />
					<input name='RMID' type='hidden' value='".$_GET['RMID']."' />
					<input name='prodpr' type='hidden' value='".$_GET['prodpr']."' />
					</form>
					<script language=\"JavaScript\" type=\"text/javascript\">
						document.f1.submit();
					</script>";
				
			}
			echo "	<form method='get' action='naznach.php' >
					<input name='perv' type='hidden' value='101' />";
					echo "<input name='vrach' type='hidden' value='".$_GET['vrach']."' />";
					echo "<input name='nach' type='hidden' value='".$_GET['nach']."' />";
					echo "<input name='okonchS' type='hidden' value='".$_GET['okonchS']."' />
					<input name='idDP' type='hidden' value='".$_GET['idDP']."' />
					<input name='nachS' type='hidden' value='".$_GET['nachS']."' />
					<input name='RMID' type='hidden' value='".$_GET['RMID']."' />
					<input name='prodpr' type='hidden' value='".$_GET['prodpr']."' />
					<input name='element' type='hidden' value='".$_GET['element']."' />";
					$query = "SELECT `klinikpat`.*
FROM klinikpat
WHERE `klinikpat`.`id` ='".$_GET['element']."'";
//echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row=mysqli_fetch_array($result);
					$PAT="<em>".$row['surname']." ".$row['name']." ".$row['otch']."</em>";
					echo "Пациент: ".$PAT; 
					 echo "<div class='bold2'>Дата ".date('d.m.Y',$_GET['nach'])."</div> 
					 <table width='300' border='0' cellspacing='1'>
						  <td>Прод приёма</td>
						    <td><label>
							C <input name='' type='text' value='".date('G:i',$_GET['nach'])."' maxlength='2'  size='2' />-<select name='okonchPr'>";
					//Продолжительность приёма
					$delta=15*60;
					$okonch=($_GET['nach']+$delta);
					$PD=$_GET['okonchS'];
					while ($okonch<=$PD)
					{
						if (!($_GET['idDP']=="N"))
						{
							$query = " SELECT `nazn`.`NachNaz`
										FROM nazn
										WHERE ((`nazn`.`dayPR` ='".$_GET['idDP']."') 
										   AND (`nazn`.`NachNaz` ='".date('H:i',$okonch)."'))";
										   //echo $query."<br />";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							if ($count>0)
							{
								$PD=$okonch;
							}
						}
						echo "<option value='$okonch'>".date('G:i',$okonch)."</option>";
						$okonch=$okonch+$delta;
					}	
					echo"</select>";
					echo"  </label></td>
						</tr>
						<tr>
						  <td>Цель приёма</td>
						  <td><label>
							<select name='SoderzhNaz'>";
							$query = "SELECT `soderzhnaz`.* FROM soderzhnaz";
//echo $query."<br />";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							
							for($i;$i<$count;$i++) 
							{
								$row = mysqli_fetch_array($result);
								echo "<option value='".$row['id']."'>".$row['SoderzhNaz']."</option>"; 							}
							echo"</select>
						  </label></td>
						</tr>
					  </table>
					  <table width='300' border='0' cellspacing='0' cellpadding='0'>
					  <tr>
						<td align='center'><input name='OK' type='submit'  value='OK'/></td>
					  </tr>
					</table>
					
					</form>";
	break;
	//Назначение повторног0o
	case "101":
		$patId=$_GET['element'];
		if ($_GET['idDP']=="N")
		{/////////////////Создание нгового дня расписания
			$query = "INSERT INTO `daypr` ( `id` , `date` , `vih` , `rabmestoID` , `Nach` , `Okonch` , `TimePat` , `vrachID` ) 
	VALUES (
	NULL , '".date('Y-m-d',$_GET['nach'])."', '0', '".$_GET['RMID']."', '".date('H:i',$_GET['nachS']).":00', '".date('H:i',$_GET['okonchS']).":00', '".$_GET['prodpr']."', '".$_GET['vrach']."')";
	//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$query = "SELECT *
FROM daypr
WHERE ((`daypr`.`date` ='".date('Y-m-d',$_GET['nach'])."') AND (`daypr`.`vrachID` ='".$_GET['vrach']."'))";
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			
			$row = mysqli_fetch_array($result);
			$dayPR=$row['id'];
		}
		else $dayPR=$_GET['idDP'];
		$query = "INSERT INTO `nazn` (`Id`, `Perv`, `PatID`, `dayPR`, `NachNaz`, `OkonchNaz`, `SoderzhNaz`, `NachPr`, `OkonchPr`) VALUES "
                        . "(NULL, '0', '".$patId."', '".$dayPR."', '".date('H:i',$_GET['nach']).":00',  '".date('H:i',$_GET['okonchPr']).":00','".$_GET['SoderzhNaz']."', '00:00:00', '00:00:00')";
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if (isset($_SESSION['pred']))
		{
			$q=$_SESSION['pred'];
			unset($_SESSION['pred']);
			ret($q);
		}
		else
		{
			switch ($_SESSION['valid_user'])
			{
				case "terapevt":
					ret("pat_tooday.php");
				break;
				case "ortoped":
					ret("pat_tooday_orto.php");
				break;
				case "ortodont":
					ret("pat_tooday_orto.php");
				break;
				case "registrator":
					ret("pat_tooday_reg.php");
				break;
				case "gigienist":
					ret("pat_tooday_gig.php");
				break;
			}
		}	
	break;
}

//include("footer.php");
?>
