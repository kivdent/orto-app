<?php
$ThisVU="all";
$this->title="Работа с рсписанием";
//include("header.php");
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$DayPr=mktime(0,0,0,date("m"),date("d"),date("Y"));
if (date("w",$DayPr)==0) $day=7;
else $day=date("w",$DayPr);
echo "<h4>Расписание на ".date("d-m-Y",$DayPr).", ".$dn[(date("w",$DayPr)-1)]."</h4>";
echo "<hr />"; 
$query="select `id`,`vrachID`,`prodpr` from`raspis_pack` where 
((`DateD`='".date("Y-m-d",$DayPr)."' or 
`DateD`<'".date("Y-m-d",$DayPr)."')) and
`vrachID`='".$_SESSION['UserID']."'"; 
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
// промотр всех пакетов расписаний
for ($i=0;$i<$countA;$i++)
	{
			$rowA = mysqli_fetch_array($resultA);	
									//////////Выбор из дня приёма
			$query = "SELECT `daypr`.*
	FROM daypr
	WHERE ((`daypr`.`date` ='".date("Y-m-d",$DayPr)."') AND (`daypr`.`vrachID` ='".$rowA['vrachID']."'))";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$countD=$count;
			$resultD=$result;
			$rowD= mysqli_fetch_array($result);
			if ($countD>0) 
			{
				$query = "SELECT * FROM `rabmesto` where id='".$rowD['rabmestoID']."'" ;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				echo "<em>Рабочее место ".$row['nazv']."</em><br>";
				//
				$nach=explode(":",$rowD['Nach']);
				$nach[0]=(Integer)$nach[0];
				$nach[1]=(Integer)$nach[1];
				$nach[2]=(Integer)$nach[2];
				$nach=mktime($nach[0],$nach[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
				//
				$okonch=explode(":",$rowD['Okonch']);
				$okonch[0]=(Integer)$okonch[0];
				$okonch[1]=(Integer)$okonch[1];
				$okonch[2]=(Integer)$okonch[2];
				$okonch=mktime($okonch[0],$okonch[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
				$vih=$rowD['vih'];
				$idDP=$rowD['id'];
				$RMID=$rowD['rabmestoID'];
			}
			else
			{/////////////////////////Выбор из пакетов расписаний
			
					$query = "select * FROM `raspis_day` where dayN='".$day."' and raspis_pack='".$rowA['id']."'";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$countB=$count;
					$resultB=$result;
					$rowB = mysqli_fetch_array($resultB);
					$vih=$rowB['vih'];
					$idDP="N";
					$query = "SELECT nazv FROM `rabmesto` where id='".$rowB['rabmestoID']."'" ;
					$RMID=$rowB['rabmestoID'];
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					echo "<em>Рабочее место ".$row['nazv']."</em><br>";
					//
					$nach=explode(":",$rowB['nachPr']);
					$nach[0]=(Integer)$nach[0];
					$nach[1]=(Integer)$nach[1];
					$nach[2]=(Integer)$nach[2];
					$nach=mktime($nach[0],$nach[2],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
					//
					$okonch=explode(":",$rowB['okonchPr']);
					$okonch[0]=(Integer)$okonch[0];
					$okonch[1]=(Integer)$okonch[1];
					$okonch[2]=(Integer)$okonch[2];
					$okonch=mktime($okonch[0],$okonch[2],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
				}	
				//Вывод таблицы	
				if ($vih==0)
				{
					$query = "select surname,name,otch from `sotr` where id='".$rowA['vrachID']."'" ;
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					$VR="<em>Врач: ".$row['surname']." ".$row['name']." ".$row['otch']."</em>";
					echo $VR."<br>";
					$tm=$nach;
					$tmd=$tm;
					echo "<table border='1' cellpadding='1' width='440'>";
					echo "<tr>";
					echo "<td width='55'>Время</td>";
					echo "<td width='230'>Пациент</td>";
					echo "<td width='135'>Действие</td>";
					echo "</tr>";
					while ($tm<$okonch)
					{					
						$query = "SELECT `nazn`.*
									FROM nazn
									WHERE ((`nazn`.`dayPR` ='".$idDP."') AND 
											(`nazn`.`NachNaz` >='".date('H:i',$tm).":00') AND 
											(`nazn`.`NachNaz` <'".date('H:i',($tm+($rowA['prodpr']*60))).":00'))";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						if ($count>0)
						{
							
							
							$row = mysqli_fetch_array($result);
							$PatID=$row['PatID'];
							$IDN=$row['Id'];
							if ($row['Perv']==1) $Perv="Первичный:";
							else $Perv="";
							$SoderzhNaz=$row['SoderzhNaz'];
							$NachNaz=explode(":",$row['NachNaz']);
							$NachNaz[0]=(Integer)$NachNaz[0];
							$NachNaz[1]=(Integer)$NachNaz[1];
							$NachNaz[2]=(Integer)$NachNaz[2];
							$NachNaz=mktime($NachNaz[0],$NachNaz[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
							$OkonchNaz=explode(":",$row['OkonchNaz']);
							$OkonchNaz[0]=(Integer)$OkonchNaz[0];
							$OkonchNaz[1]=(Integer)$OkonchNaz[1];
							$OkonchNaz[2]=(Integer)$OkonchNaz[2];
							$OkonchNaz=mktime($OkonchNaz[0],$OkonchNaz[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
							$query = "SELECT `klinikpat`.*
											FROM klinikpat
											WHERE (`klinikpat`.`id` ='".$PatID."')";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							$PAT="<em>".$row['surname']." ".$row['name']." ".$row['otch']."</em>";
							$query = "SELECT `soderzhnaz`.`SoderzhNaz`
FROM soderzhnaz
WHERE (`soderzhnaz`.`id` ='".$SoderzhNaz."')";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							if ($tm!=$NachNaz)
							{
									echo "<tr>";
									echo "<td>".date('G:i',$tm)."</td>";
									echo "<td>&nbsp;</td><td>
									<a href='naznach.php?date=".$tm."&prodpr=".$rowA['prodpr']."&vrach=".$rowA['vrachID']."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID='".$RMID.">Назначить<a>";
									echo "</td>";
									echo "</tr>";	
							}
							echo "<tr>";
							echo "<td>".date('G:i',$NachNaz)."</td>";
							echo "<td>".$PAT."<br />
							<span class='bottom2'>".$Perv."</span>
							<span class='bottom'>".$row['SoderzhNaz']."</span>
</td>";
							echo "<td>
						<a href='naznach.php?IDN=".$IDN."&action=del'>Отменить<a>";
						//echo "|Переназначить";
//						echo "|Изменить продолжительность";
						echo "</td>";
						echo "</tr>";
						 		
						 while ($tmd<=$OkonchNaz)
						 {
						 	$tmd=$tmd+($rowA['prodpr']*60);
						 }
						 $tm=$OkonchNaz;				
						}
						else 
						{
						echo "<tr>";
						echo "<td>".date('G:i',$tm)."</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>
						<a href='naznach.php?date=".$tm."&prodpr=".$rowA['prodpr']."&vrach=".$rowA['vrachID']."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID='".$RMID.">Назначить<a>
						</td>";
						echo "</tr>";
						if ($tmd>$tm) $tm=$tmd;
						else
						{ 
						$tm=$tm+($rowA['prodpr']*60);
						$tmd=$tm;
						}
						}
						
					}		
				echo "</tr>";
				echo "</table>";
			}
		}
echo "<form action='raspis.php' method='post'><center><input name='' type='submit'  value='ОК'/></center></form>";//include("footer.php");
?>

