
<?php
$ThisVU="all";
$this->title="Работа с расписанием"; 
//include("header.php");
switch ($_GET['action'])
{
	case "change":
		switch ($_GET['step'])
		{
			case "1":
				if ($_GET['idDP']=="N")
				{
					
					$query = "SELECT `raspis_pack`.*
								FROM  raspis_pack
								WHERE	((`raspis_pack`.`DateD` <= '".date('Y-m-d ',$_GET['DayPr'])."')AND
									   (`raspis_pack`.`vrachID` ='".$_GET['vrach']."'))
									   ORDER BY `raspis_pack`.`DateD` DESC
									   LIMIT 1";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);								   
	$dtn=explode("-",$row['DateD']);								   					
	$base_day= $dtn[2];	
	$base_mon= $dtn[1];
	$base_yr		= $dtn[0];
	$current_day		= date ("j");
	$current_mon		= date ("n");
	$current_yr		= date ("Y");
	$sd= mktime (0,0,0,$base_mon,$base_day,$base_yr);
	$qd= mktime (0,0,0,date ("n",$_GET['DayPr']),date ("j",$_GET['DayPr']),date ("Y",$_GET['DayPr']));
	$diff=($qd-$sd)/86400;
	//msg($diff."=".$qd."-".$sd);	
		if ($diff<=$row['ndays'])
	{
		$day=$diff;
	}
	else
	{
		$day=$diff-(floor($diff/9)*9)+1;
		//msg($day."=".$diff."-".(floor($diff/9)*9));
	}
	//msg($day);

						$query = "SELECT `raspis_day`.*, `raspis_pack`.*
								FROM raspis_day, raspis_pack
								WHERE ((`raspis_day`.`raspis_pack` =`raspis_pack`.`id`) AND 
									   (`raspis_day`.`dayN` ='".$day."') AND 
									   (`raspis_pack`.`DateD` <= '".date('Y-m-d ',$_GET['DayPr'])."')AND
									   (`raspis_pack`.`vrachID` ='".$_GET['vrach']."'))
									   ORDER BY `raspis_pack`.`DateD` DESC
									   LIMIT 1";
				}
				else
				{
					
				}
				echo "<form method='get' action='raspis_change2.php'>";
echo "Выходной<br><select name='vih'>";
echo "<option value='1'  selected='selected'>Да</option><option value='0'>Нет</option>";
echo "        </select><br>";
//Рабочее место
echo "Рабочее место<br>
  		<select name='rabmesto'>";
$query = "SELECT * FROM `rabmesto`" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	if (!(isset($_POST['rabmesto'])) and ($i==0))  echo "<option value='".$row['id']." 'selected='selected'>".$row['nazv']."</option>";	
	if ($row['id']==$_POST['rabmesto']) echo 
	"<option value='".$row['id']." 'selected='selected'>".$row['nazv']."</option>";
	else echo "<option value='".$row['id']."'>".$row['nazv']."</option>";
}
echo "  </select>
  		<br/>";
 //начало смены
echo "Начало смены<br><select name='nachH'>";
for ($i=8; $i<23; $i++)
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
echo "</select>м<br>";

//окончание смены
echo "Окончание смены<br><select name='okonchH'>";
for ($i=8; $i<23; $i++)
{
	$s="";
	if ($i==22) $s=" selected='selected'";
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
echo "</select>м";
//Скрытые элементы

echo "<input name='step' type='hidden' value='2' />";
echo "<input name='DayPr' type='hidden' value='".$_GET['DayPr']."' />";
echo "<input name='idDP' type='hidden' value='".$_GET['idDP']."' />";
echo "<input name='action' type='hidden' value='change' />";
// Выбор
echo "<br />  
	<input name='next' type='submit' value='Дальше>>'>
	</form>";
				//include("footer.php");
				exit;
			break;
		}
	break;
}
echo "<div class='head1'>Назначение пациентов</div>";
echo "<center><a href='naznach_pat_full.php' class='menu2'>Полное расписание</a></center>";
echo "<hr width='100%' noshade='noshade' size='1'/>";
			$StartD=mktime(0,0,0,date('m'),date('d'),date('Y'));
			if (isset($_GET[d]))
			{ 	
				$StartD=$_GET['StartD'];
				$StartD=$StartD+(($_GET[d])*(7*24*60*60));
				$DayPr=$StartD;
				$EndD=$StartD+(7*24*60*60);
				if (isset($_GET['vrach']))
				{
					$next="<a href='naznach_pat.php?vrach=".$_GET['vrach']."&d=1&StartD=".$StartD."'>Дальше<a>";
				}
				else
				{
					$next="<a href='naznach_pat.php?&d=1&StartD=".$StartD."'>Дальше<a>";
				}
				if ($StartD==$_GET['StartD']) 
				{
					$prev="";
				}
				else 
				{
					
					if (isset($_GET['vrach'])) $prev="<a href='naznach_pat.php?vrach=".$_GET['vrach']."&d=-1&StartD=".$StartD."'>Назад<a>";
					else $prev="<a href='naznach_pat.php?d=-1&StartD=".$StartD."'>Назад<a>";
				}
			}
			else 
			{
				$DayPr=$StartD;
				$EndD=$StartD+(7*24*60*60);
				if (isset($_GET['vrach'])) $next="<a href='naznach_pat.php?vrach=".$_GET['vrach']."&d=1&StartD=".$StartD."'>Дальше<a>";
				else $next="<a href='naznach_pat.php?d=1&StartD=".$StartD."'>Дальше<a>";
				$prev="";		
			}
			echo "<div align='center' class='feature3'>".$prev."|".$next."</div>";

			////Цикл по всем рачам
echo "<form name=\"form1\" id=\"form1\"><div>Выбирите врача: ";
			$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch` 
						FROM raspis_pack, sotr
						WHERE `raspis_pack`.`vrachID` = `sotr`.`id`
						GROUP BY `sotr`.`id`
						ORDER BY `sotr`.`surname` ASC
						";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);					
echo "<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='naznach_pat.php?vrach=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

  <select name=\"vrach\" onchange=\"MM_jumpMenu('parent',this,0)\">";
if ((!(isset($_GET['vrach']))) or ($_GET['vrach']=='all')) echo "<option value='all' selected='selected'>Все врачи</option>";
else echo "<option value='all'>Все врачи</option>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($_GET['vrach']==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	else echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
}
echo "  </select>
";
echo "</div></form>";
if ((!(isset($_GET['vrach']))) or ($_GET['vrach']=='all'))	$query = "SELECT `raspis_pack`. * , `sotr`. * , `sotr`.`id` 
FROM raspis_pack, sotr
WHERE `raspis_pack`.`vrachID` = `sotr`.`id`
GROUP BY `sotr`.`id`
ORDER BY `sotr`.`surname` ASC";
					else $query = "SELECT *
						FROM sotr
						WHERE id=".$_GET['vrach'];

			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);					
			$countZ=$count;
			$resultZ=$result;
			for ($z=0;$z<$countZ;$z++)
			{	$rowZ = mysqli_fetch_array($resultZ);
				$vrach=$rowZ['id'];
				$VR="Врач: ".$rowZ['surname']." ".$rowZ['name']." ".$rowZ['otch'];
				echo $VR;
				/////Начало строки в таблице
					echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#CCCCCC'><tr>";
				//////Цикл на неделю
				//$t=0;
				$DayPr=$StartD;
				while ($DayPr<$EndD)
				{ 
					//$t++;
					//msg(date("d.m.Y",$DayPr).'-'.date("d.m.Y",$EndD));
					$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
					
					if (date("w",$DayPr)==0) $day=7;
					else $day=date("w",$DayPr);
					//Начало столбца дня
					echo "<td valign='top' width='14%'><div class='feature2'>".date('d.m.y',$DayPr).",</br>".$dn[($day-1)]."</div>
					<hr noshade height='1'><table width='100%' border='0' cellpadding='0' cellspacing='0' bordercolor='#666666'>";
					$vih=1;
					if (date("w",$DayPr)==0) $day=7;
					else $day=date("w",$DayPr);
					$query = "SELECT `daypr`.*
					FROM daypr
					WHERE ((`daypr`.`date` ='".date('Y-m-d ',$DayPr)."') AND 
							(`daypr`.`vrachID` ='".$vrach."'))";
					//////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$countW=$count;
					$resultW=$result;
						///На этот день у этого врача есть день приёма
						if ($countW>0) 
						{
							//
						$rowW = mysqli_fetch_array($resultW);
						//Проверка есть ли назначения
						$query = "SELECT 
						`klinikpat`.`id`, 
						`nazn`.`Id`, 
						`klinikpat`.`surname`, 
						`klinikpat`.`name`, 
						`klinikpat`.`otch`, 
						`nazn`.`NachNaz`, 
						`nazn`.`OkonchNaz`
									FROM klinikpat, nazn
									WHERE ((`nazn`.`dayPR` ='".$rowW['id']."') AND 
									(`klinikpat`.`id` =`nazn`.`PatID`))
									ORDER BY `nazn`.`NachNaz` ASC" ;
						
						//////////echo $query."<br />";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$countD=$count;
						$resultD=$result;
						if ($countD>0)
							for ($i=0;$i<$countD;$i++)
							{	
								$rowD = mysqli_fetch_array($resultD);
								$idDP=$rowD[0];
								$nP= $rowD[2]."<br />".$rowD[3]."<br />".$rowD[4];
								$IDN=$rowD[1];
								$nachNN=explode(":",$rowD[5]);
								$nachNN[0]=(Integer)$nachNN[0];
								$nachNN[1]=(Integer)$nachNN[1];
								$nachNN[2]=(Integer)$nachNN[2];
								$nachN['$i']=mktime($nachNN[0],$nachNN[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								
								$okonchNN=explode(":",$rowD[6]);
								$okonchNN[0]=(Integer)$okonchNN[0];
								$okonchNN[1]=(Integer)$okonchNN[1];
								$okonchNN[2]=(Integer)$okonchNN[2];
								$okonchN['$i']=mktime($okonchNN[0],$okonchNN[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								
							}
							$prodpr=$rowW['TimePat'];
							$vih=$rowW['vih'];
							$idDP=$rowW['id'];
							$RMID=$rowW['rabmestoID'];
							$nach=explode(":",$rowW['Nach']);
							$nach[0]=(Integer)$nach[0];
							$nach[1]=(Integer)$nach[1];
							$nach[2]=(Integer)$nach[2];
							$nach=mktime($nach[0],$nach[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								//
							$okonch=explode(":",$rowW['Okonch']);
							$okonch[0]=(Integer)$okonch[0];
							$okonch[1]=(Integer)$okonch[1];
							$okonch[2]=(Integer)$okonch[2];
							$okonch=mktime($okonch[0],$okonch[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
//							echo date('G:i',$nachN[0])."<br />";
//							echo date('G:i',$okonchN[0])."<br />";
//							echo date('G:i',$nach)."<br />";
//							echo date('G:i',$okonch)."<br />";
//							exit;
						}
				else 
				{////Если нет дня приёма то идёт поиск дня в базовом расписнии
						$query = "SELECT `raspis_day`.*, `raspis_pack`.*
								FROM raspis_day, raspis_pack
								WHERE ((`raspis_day`.`raspis_pack` =`raspis_pack`.`id`) AND 
									   (`raspis_day`.`dayN` ='".$day."') AND 
									   (`raspis_pack`.`DateD` <= '".date('Y-m-d ',$DayPr)."')AND
									   (`raspis_pack`.`vrachID` ='".$vrach."'))
									   ORDER BY `raspis_pack`.`DateD` DESC";
		   				
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$countB=$count;
						$resultB=$result;
						if ($countB>0)
						{
							$rowB = mysqli_fetch_array($resultB);
							$idDP="N";		
							$prodpr=$rowB['`raspis_pack`.prodpr'];
							$vih=$rowB['`raspis_day`.vih'];
							$RMID=$rowB['`raspis_day`.rabmestoID'];
							$countD=1;					
							$nach=explode(":",$rowB['`raspis_day`.nachPr']);
							$nach[0]=(Integer)$nach[0];
							$nach[1]=(Integer)$nach[1];
							$nach[2]=(Integer)$nach[2];
							$nach=mktime($nach[0],$nach[2],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
							//
							$okonch=explode(":",$rowB['`raspis_day`.okonchPr']);
							$okonch[0]=(Integer)$okonch[0];
							$okonch[1]=(Integer)$okonch[1];
							$okonch[2]=(Integer)$okonch[2];
							$okonch=mktime($okonch[0],$okonch[2],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
							$nachN=NULL;
							$okonchN=NULL;
						}
						//
				}
					if ($vih==0)
					{
					$query = "SELECT `nazv` FROM `rabmesto` WHERE `id`=".$RMID ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
					echo "<tr><td class='bottom'>
					Рабочее место: ".$row[0]."</br>
					Время приёма: ".date('G:i',$nach)."-".date('G:i',$okonch)."
					</br><a href='raspis_change2.php?action=change&step=1&DayPr=".$DayPr."&idDP=".$idDP."&vrach=".$vrach."'>Изменить<a>
					</td></tr>";
					}
				else echo "<tr><td class='bottom'>Выходной</br><a href='raspis_change2.php?action=change&step=1&DayPr=".$DayPr."&idDP=".$idDP."'>Изменить<a>
					</td></tr>";
				echo "</table></td>";	
				$DayPr=$DayPr+(24*60*60);
				}
				///Окончание таблицы
				echo " </tr></table></br>";	
			}		
//include("footer.php");
?>
