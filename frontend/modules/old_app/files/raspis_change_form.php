<?php 
$ThisVU="all";
$this->title="Расписание на неделю";
//include("header.php"); 
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
if (date("w")==0) $day=7;
else $day=date("w");
if (isset($_GET[d]))
{ 	
	$cm=$_GET['cm'];
	$cm=$cm+((date("t",$cm)+1)*24*60*60*$_GET[d]);
	$cm=mktime(0,0,0,date("m",$cm),1,date("Y",$cm));
	$pd=$cm;
	$do=mktime(0,0,0,date("m",$cm),date("t",$cm),date("Y",$cm));
}
else 
{
	$cm=mktime(0,0,0,date("m"),1,date("Y"));
	$pd=$cm;
	$do=mktime(0,0,0,date("m"),date("t"),date("Y"));
}
//                     Показ таблицы на месяц
if (isset($_POST['ok']) or $_GET['cm'])
{	if (isset($_POST['vrach'])) $vrach=$_POST['vrach'];
		else $vrach=$_GET['vrach'];
	$vih=1;
	$query = "select surname,name,otch from `sotr` where id='".$vrach."'" ;
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	$s=$row['surname']." ".$row['name']." ".$row['otch'];
	$query="SELECT `id`,`DateD`,`prodpr` FROM `raspis_pack` WHERE `vrachID`=".$vrach; 
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result); 
	$row = mysqli_fetch_array($result);
	$PRID=$row['id'];
	$DPR1=$row['prodpr'];
	if (date("n",$cm)==1)
	{ 
		$ml=11;
		$ms=1;
	}
	else
	{
		if (date("n",$cm)==12)
		{
			$ml=11;
			$ms=0;
		}
		else
		{
			$ms=((date("n",$cm)-1)+1);
			$ml=((date("n",$cm)-1)-1);
		}
	}
	echo  $ml.date("n",$cm).$ms;
	echo "<h4><center><a href='raspis_change_form.php?d=-1&cm=".$cm."&vrach=".$vrach."'>".$mn['$ml']."</a> |Расписание на <strong>".$mn[(date("n",$cm)-1)]."|<a href='raspis_change_form.php?d=1&cm=".$cm."&vrach=".$vrach."'>".$mn['$ms']."</a></strong><br>
	Врач: ".$s."</center></h4>";
	echo "<hr />";
	echo "<table width='100%' border='1' cellpadding='0' bgcolor='#ffffff' cellspacing='0' bordercolor='#000000'><tr>";
	for($i=1;$i<8;$i++)
	{
		echo "<td align='center' width=14%>".$dn[($i-1)]."</td>";
	}
	$i=1;
	echo "  </tr><tr>";
	$fl=1;
	while ($pd<=$do)
	{//2
			if (date("w",$pd)==0) $day2=7;
			else $day2=date("w",$pd);
			$st="feature2";
			if (date('Y-m-d',$pd)==date('Y-m-d')) $st="feature3";
			if (($day2==6) or ($day2==7))$st="feature4";
			if (($day2>$i) and ($pd==$cm))
			{//5
				echo "<td>&nbsp;</td>";
			}//5
			else 
			{//1
				$fl=0;
				$query = "SELECT `daypr`.*
							FROM daypr
							WHERE ((`daypr`.`date` ='".(date("Y-m-d",$pd))."') AND 						(`daypr`.`vrachID` ='".$_POST['vrach']."'))";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($count>0)
					{
						$row = mysqli_fetch_array($result);
						$var=1;
						$vih=$row['vih'];
						$RMID=$row['rabmestoID'];
						$Nach=$row['Nach'];
						$Okonch=$row['Okonch'];
						$DPR=$row['TimePat'];
						$DPid=$row['id'];
					}
				else
				{
					$query = "select * FROM `raspis_day` where dayN='".$day2."'  and raspis_pack='".$PRID."'";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					if ($count>0)
					{	
						$resultB=$result;
						$rowB = mysqli_fetch_array($resultB);
						$vih=$rowB['vih'];
						$var=2;						
						$RMID=$rowB['rabmestoID'];
						$Nach=$rowB['nachPr'];
						$Okonch=$rowB['okonchPr'];
						$DPR=$DPR1;
						$DPid="N";
					}
				}
				if ($vih==0)
				{//4
					$query = "SELECT `rabmesto`.`nazv`
					FROM rabmesto
					WHERE (`rabmesto`.`id` ='".$RMID."')";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$countС=$count;
					$resultС=$result;
					$rowС = mysqli_fetch_array($resultС);
						//
					$nach=explode(":",$Nach);
					$nach[0]=(Integer)$nach[0];
					$nach[1]=(Integer)$nach[1];
					$nach[2]=(Integer)$nach[2];
					$nach=mktime($nach[0],$nach[1],0,date("m"),date("d"),date("Y"));
					//
					$okonch=explode(":",$Okonch);
					$okonch[0]=(Integer)$okonch[0];
					$okonch[1]=(Integer)$okonch[1];
					$okonch[2]=(Integer)$okonch[2];
					$okonch=mktime($okonch[0],$okonch[1],0,date("m"),date("d"),date("Y"));
					echo "<td align='center'><div class='".$st."'>".date("d/m/Y",$pd)."<br>
						рабочее место ".$rowС['nazv']."<br>
						".date('G:i',$nach)."-".date('G:i',$okonch)."</div>  
						<hr width='100%' noshade='noshade' size='1'/>
						<div class='bottom'>"; 
						//echo "<a href='raspis_change_form.php?action=otd&date=".$pd."&vrach=".$vrach."&nach=".$nach."&okonch=".$okonch."&prodpr=".$DPR."&datePR=".$pd."&rabmesto=".$RMID."'>Отдать</a>";
echo "						<a href='raspis_change_form.php?action=setvih&date=".$pd."&vrach=".$vrach."&nach=".$nach."&okonch=".$okonch."&prodpr=".$DPR."&rabmesto=".$RMID."&DPid=".$DPid."'>Удалить</a>";
//						echo "<a href='raspis_change_form.php?action=change&date=".$pd."&vrach=".$vrach."&nach=".$nach."&okonch=".$okonch."&prodpr=".$DPR."&rabmesto=".$RMID."'>Изменить</a>";
						echo "</div>
						</td>";	
				}//4
				else
				{//3
					echo "<td>
						<div class='".$st."'>".date("d/m/Y",$pd)."<br>Выходной</div>
						 <hr width='100%' noshade='noshade' size='1'/>";
						// echo "<div class='bottom'>						  <a href='raspis_change_form.php?action=add&date=".$pd."&vrach=".$vrach."&DPid=".$DPid."'>Изменить</a></div>";
						echo "</td>";
				}//3
				$pd=$pd+(24*60*60); 
			}//1
		if (($day2==7) and ($fl==0))echo "  </tr><tr>";
		$i=$i+1;
	}//2
	for ($i=($day2+1);$i<8;$i++)
	{
		echo "<td>&nbsp;</td>";
	}
	echo "  </tr></table>";
	echo "<form action='raspis.php' method='post'><center><input name='' type='submit'  value='ОК'/></center></form>";
}
///////////////////////////////////////////////  Работа с действиями
if (isset($_GET['action']))
{
	switch ($_GET['action'])
	{
		case ("otd"):
			if (isset($_GET['ok2']))
			// сохренение замены!
			{
			//Получение последнего пакета расписаний для этого врача
				$query = "SELECT `raspis_pack`.`id`, `raspis_pack`.`DateD`
FROM raspis_pack
WHERE ((`raspis_pack`.`vrachID`='".$_GET['vrach']."') AND (`raspis_pack`.`DateD`<='".date("Y-m-d",$_GET['datePR'])."'))";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				////////echo $query."<br />";
				$dd=0;
				for ($i=0; $i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$dd2=explode("-",$row['DateD']);
					$dd2=mktime(0,0,0,$dd[1],$dd[2],$dd[0]);
					if ($dd2>$dd) $RPID=$row['id'];
					$dd=$dd2;
				}
				echo $RPID."<br />";
				echo $dd."<br />";
				//Получение дня из пакета расписаний
				if (date("w",$_GET['datePR'])==0) $day=6;
				else $day=(date("w",$_GET['datePR'])-1);
				$query = "SELECT `raspis_day`.`nachPr`, `raspis_day`.`okonchPr`
							FROM raspis_day
							WHERE ((`raspis_day`.`id` ='".$RPID."') AND (`raspis_day`.`dayN` ='".$day."'))";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$count=$count;
				$result=$result;
				$row = mysqli_fetch_array($result);
						//
					$nach=explode(":",$row['nachPr']);
					$nach[0]=(Integer)$nach[0];
					$nach[1]=(Integer)$nach[1];
					$nach[2]=(Integer)$nach[2];
					$nach=mktime($nach[0],$nach[1],0,date("m"),date("d"),date("Y"));
					//
					$okonch=explode(":",$row['okonchPr']);
					$okonch[0]=(Integer)$okonch[0];
					$okonch[1]=(Integer)$okonch[1];
					$okonch[2]=(Integer)$okonch[2];
					$okonch=mktime($okonch[0],$okonch[1],0,date("m"),date("d"),date("Y"));
					$nach1=mktime($_GET['nachH'],$_GET['nachM'],0,date("m"),date("d"),date("Y"));
					$okonch1=mktime($_GET['okonchH'],$_GET['okonchM'],0,date("m"),date("d"),date("Y"));
					if ((($nach>$nach1) and ($nach<$okonch1)) or (($okonch>$nach1) and ($okonch<$okonch1)))
				{
					echo "В это время врач работает ";
					echo "<form method='post' action='raspis.php'>";
					echo "<br />  
						<input name='next' type='submit' value='назад'>
						</form>";
					//include("footer.php");
					exit;
				}
				//Проверка на расписания
				$query = "SELECT `daypr`.*
							FROM daypr
							WHERE ((`daypr`.`vrachID` ='".$_GET['vrach']."') AND (`daypr`.`date` ='".date("Y-m-d",$_GET['datePR'])."') AND (`daypr`.`vih` =0))";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$count=$count;
				$result=$result;
				$row = mysqli_fetch_array($result);
				$nach=explode(":",$row['Nach']);
					$nach[0]=(Integer)$nach[0];
					$nach[1]=(Integer)$nach[1];
					$nach[2]=(Integer)$nach[2];
					$nach=mktime($nach[0],$nach[1],0,date("m"),date("d"),date("Y"));
					//
					$okonch=explode(":",$row['Okonch']);
					$okonch[0]=(Integer)$okonch[0];
					$okonch[1]=(Integer)$okonch[1];
					$okonch[2]=(Integer)$okonch[2];
					$okonch=mktime($okonch[0],$okonch[1],0,date("m"),date("d"),date("Y"));
					$nach1=mktime($_GET['nachH'],$_GET['nachM'],0,date("m"),date("d"),date("Y"));
					$okonch1=mktime($_GET['okonchH'],$_GET['okonchM'],0,date("m"),date("d"),date("Y"));
					if (($nach=$nach1) and ($nach=$okonch1)  and ($okonch=$okonch1) and ($row['rabmestoID']==$_GET['rabmesto']))
				{// Если время приёмов совпадает
						echo "В это время врач работает ";
						echo "<form method='post' action='raspis.php'>";
						echo "<br />  
							<input name='next' type='submit' value='назад'>
							</form>";
						//include("footer.php");
						exit;
				}
				$query = "INSERT INTO `daypr` ( `id` , `vih` , `vrachID` , `date` ,`rabmestoID`,  `Nach` , `Okonch` , `TimePat` ) 
							VALUES (
							NULL , '0', '".$_GET['vrach']."','".date("Y-m-d",$_GET['datePR'])."', '".$_GET['rabmesto']."','".$_GET['nachH'].":".$_GET['nachM'].":00', '".$_GET['okonchH'].":".$_GET['okonchM'].":00', '".$_GET['prodpr']."')";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				//Добавляем выходной врачу
				$query = "INSERT INTO `daypr` ( `id` , `vih` , `vrachID` , `date` ,`rabmestoID`,  `Nach` , `Okonch` , `TimePat` ) 
							VALUES (
							NULL , '1', '".$_GET['vrach2']."','".date("Y-m-d",$_GET['datePR'])."', '".$_GET['rabmesto']."','".$_GET['nachH'].":".$_GET['nachM'].":00', '".$_GET['okonchH'].":".$_GET['okonchM'].":00', '".$_GET['prodpr']."')";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				echo "<h4>Смена успешео добавлена<h4><hr width='100%' noshade='noshade' size='1'/>";				
				echo "<form action='raspis.php' method='post'>
				<input name='' type='submit' value='OK' size=7/>
				</form>";
				//include("footer.php");
				exit;
			}
			//Основная форма передачи смены
			echo "Отдать врачу часы ".date("d/m/Y",$_GET['datePR']);
			
			echo "<hr width='100%' noshade='noshade' size='1'/>";
			$query = "SELECT sotr.id, sotr.surname, sotr.name, sotr.otch FROM sotr WHERE sotr.id !=".$_GET['vrach'];
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result); 
			
			echo "<form action='raspis_change_form.php' method='get'>";
			// Врачи
			echo "<input name='datePR' type='hidden' value='".$_GET['datePR']."' />";
			echo "<input name='rabmesto' type='hidden' value='".$_GET['rabmesto']."' />";
			echo "<input name='vrach2' type='hidden' value='".$_GET['vrach']."' />";
			echo "<select name='vrach'>";
			for ($i=0; $i <$count; $i++)
			{
				$row = mysqli_fetch_array($result);
				echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
			}
			echo "</select>";
			 //начало смены
			echo " <br>От<select name='nachH'>";
			for ($i=date("G",$_GET['nach']); ($i<date("G",$_GET['okonch'])+1); $i++)
			{
				$s="";
				if ($i==date("G",$_GET['nach'])) $s=" selected='selected'";
				if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
				else echo "<option value='".$i."' ".$s.">".$i."</option>";
			}		
			echo "		</select>
					ч:
					<select name='nachM'>";
			for ($i=0; $i<61; $i++)
			{
				$s="";
				if ($i==date("i",$_GET['nach'])) $s=" selected='selected'";
				if ($i<10) echo "<option value='0".$i."' ".$s.">0".$i."</option>";
				else echo "<option value='".$i."' ".$s.">".$i."</option>";
			}			
			echo "</select>
					м<br>";
			//окончание смены
			echo "<br>До <select name='okonchH'>";
			for ($i=8; $i<21; $i++)
			{
				$s="";
				if ($i==date("G",$_GET['okonch'])) $s=" selected='selected'";
				if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
				else echo "<option value='".$i."' ".$s.">".$i."</option>";
			}		
			echo "		</select>
				  ч:
				<select name='okonchM'>";
			for ($i=0; $i<61; $i++)
			{
				$s="";
				if ($i==date("i",$_GET['okonch'])) $s=" selected='selected'";
				if ($i<10) echo "<option value='0".$i."' ".$s.">0".$i."</option>";
				else echo "<option value='".$i."' ".$s.">".$i."</option>";
			}		
			echo "		</select>
				  м";		
			echo "</select>
					</label><br>";
			echo "<input name='prodpr' type='text' value='".$_GET['prodpr']."' maxlength='2' size='2'/><br />";
			echo "<input name='action' type='hidden' value='otd' />";
			//
			echo "<input name='ok2' type='submit' value='ОК'>";
			echo "</form>";
			echo "<form action='raspis.php' method='post'>
			<input name='' type='submit' value='Отменить' size=7/>
			</form>";
			exit;
		break;
		case "setvih":
		//Работа с действием Сделать выходной
		//Основная форма Выходного
			if (isset($_GET['ok2']))
			{
				$query = "SELECT `daypr`.*
							FROM daypr
							WHERE ((`daypr`.`vrachID` ='".$_GET['vrach']."') AND (`daypr`.`date` ='".date("Y-m-d",$_GET['datePR'])."') AND (`daypr`.`vih` =0))";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($count>0)
				{
					$row = mysqli_fetch_array($result);
					$id=$row['id'];
					$query = "UPDATE daypr
							SET `daypr`.`vih`=1
							WHERE (`daypr`.`id` ='".$id."')";
					////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					echo "<h4>Смена успешео добавлена<h4><hr width='100%' noshade='noshade' size='1'/>";				
					echo "<form action='raspis.php' method='post'>
					<input name='' type='submit' value='OK' size=7/>
					</form>";
					//include("footer.php");
					exit;				
				}
				else
				{
					$query = "INSERT INTO `daypr` ( `id` , `vih` , `vrachID` , `date` ,`rabmestoID`,  `Nach` , `Okonch` , `TimePat` ) 
								VALUES (
								NULL , '1', '".$_GET['vrach']."','".date("Y-m-d",$_GET['datePR'])."', '".$_GET['rabmesto']."','".$_GET['nachH'].":".$_GET['nachM'].":00', '".$_GET['okonchH'].":".$_GET['okonchM'].":00', '".$_GET['prodpr']."')";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					echo "<h4>Выходной долбавлен<h4><hr width='100%' noshade='noshade' size='1'/>";				
					echo "<form action='raspis.php' method='post'>
					<input name='' type='submit' value='OK' size=7/>
					</form>";
					//include("footer.php");
					exit;
				}
			}
			echo "Сделать выходным смену ".date("d/m/Y",$_GET['date']);
			echo "<hr width='100%' noshade='noshade' size='1'/>";
			echo "<form action='raspis_change_form.php' method='get'>";
			// Врачи
			echo "<input name='datePR' type='hidden' value='".$_GET['date']."' />";
			echo "<input name='rabmesto' type='hidden' value='".$_GET['rabmesto']."' />";
			echo "<input name='vrach' type='hidden' value='".$_GET['vrach']."' />";
			echo "<input name='nachH' type='hidden' value=''".date('G',$_GET['nach'])."' />";
			echo "<input name='nachM' type='hidden' value=''".date('i',$_GET['nach'])."' />";
			echo "<input name='okonchH' type='hidden' value=''".date('G',$_GET['nachH'])."' />";
			echo "<input name='okonchM' type='hidden' value=''".date('i',$_GET['nachH'])."' />";
			echo "<input name='prodpr' type='hidden' value=''".$_GET['prodpr']."' />";
			echo "<input name='action' type='hidden' value='setvih' />";
			//
			echo "<input name='ok2' type='submit' value='ОК'>";
			echo "</form>";
			echo "<form action='raspis.php' method='post'>
			<input name='' type='submit' value='Отменить' size=7/>
			</form>";
		echo $_GET['action'];
		echo $_GET['vrach'];
		echo $_GET['date'];
		break;
		case "change":
		//Работа с действием Изменить
		echo $_GET['action'];
		echo $_GET['vrach'];
		echo $_GET['date'];
		break;
		case "add":
			if ($_GET['DPid']="N")
			{
				
			}
		break;
	}
	exit;
}
//include("footer.php");
?>
