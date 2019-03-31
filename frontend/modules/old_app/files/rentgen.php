<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Пациенты на сегодня";
//include("header.php");
switch ($_GET['action'])
{
	case "yavka":
		$query = "UPDATE `nazn` SET `Yavka`=1 WHERE `Id`=".$_GET['IDN'] ;
		////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("pat_tooday_reg.php");
	break;
	case "obzv":
		$query = "UPDATE `nazn` SET `RezObzv`=".$_GET['RezObzv']." WHERE `Id`=".$_GET['IDN'] ;
		////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("pat_tooday_reg.php");
	break;
}
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$DayPr=mktime(0,0,0,date("m"),date("d"),date("Y"));
if (date("w",$DayPr)==0) $day=7;
else $day=date("w",$DayPr);
echo "<h4><div class='head3'>Расписание на ".date("d-m-Y",$DayPr).", ".$dn[(date("w",$DayPr)-1)]."</div></h4>";
					$query = "SELECT id
FROM sotr
WHERE (dolzh IN (1,2,3))
ORDER BY dolzh ASC";
////echo $query."<br>"; 	
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				
$countZ=$count;
$resultZ=$result;
for ($z=0;$z<$countZ;$z++)
{ 
$rowZ = mysqli_fetch_array($resultZ);
$vrach=$rowZ['id'];
$query="select `id`,`vrachID`,`prodpr` from`raspis_pack` where 
((`DateD`='".date("Y-m-d",$DayPr)."' or 
`DateD`<'".date("Y-m-d",$DayPr)."')) and
`vrachID`='".$vrach."'";
//echo $query."<br>"; 
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
////echo $query."<br>"; 			
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$countD=$count;
			$resultD=$result;
			$rowD= mysqli_fetch_array($result);
			if ($countD>0) 
			{
				$query = "SELECT * FROM `rabmesto` where id='".$rowD['rabmestoID']."'" ;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				//echo "<em>Рабочее место ".$row['nazv']."</em><br>";
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
////echo $query."<br>"; 					
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
				//	echo "<em>Рабочее место ".$row['nazv']."</em><br>";
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
////echo $query."<br>"; 					
					$query = "select surname,name,otch from `sotr` where id='".$rowA['vrachID']."'" ;
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					$VR="<br /><em>Врач: ".$row['surname']." ".$row['name']." ".$row['otch']."</em>";
					echo $VR."<br>";
					$tm=$nach;
					$tmd=$tm;
					echo "<table  border='1' cellpadding='1' cellspacing='0 ' bordercolor='#999999' width='735'>";
					echo "<tr>";
					echo "<td width='55'>Время</td>";
					echo "<td width='230'>Пациент</td>";
					echo "<td width='90'>Действие</td>";
					//echo "<td width='90'>Моб.тел</td>";
					//echo "<td width='90'>Дом.тел</td>";
					//echo "<td width='90'>Раб.тел</td>";
					//echo "<td width='90'>Обзвон</td>";
					echo "</tr>";
					while ($tm<$okonch)
					{					
						$query = "SELECT `nazn`.*
									FROM nazn
									WHERE ((`nazn`.`dayPR` ='".$idDP."') AND 
											(`nazn`.`NachNaz` >='".date('H:i',$tm).":00') AND 
											(`nazn`.`NachNaz` <'".date('H:i',($tm+($rowA['prodpr']*60))).":00'))";
						////echo $query."<br>"; 										
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$countF=$count;
						$resultF=$result;
						if ($count>0)
						{
							
							
							$rowF = mysqli_fetch_array($resultF);
							$Yavka=$rowF['Yavka'];
							$PatID=$rowF['PatID'];
							$IDN=$rowF['Id'];
							$RezObzv=$rowF['RezObzv'];
							if ($rowF['Perv']==1) $Perv="Первичный:";
							else $Perv="";
							$SoderzhNaz=$rowF['SoderzhNaz'];
							$NachNaz=explode(":",$rowF['NachNaz']);
							$NachNaz[0]=(Integer)$NachNaz[0];
							$NachNaz[1]=(Integer)$NachNaz[1];
							$NachNaz[2]=(Integer)$NachNaz[2];
							$NachNaz=mktime($NachNaz[0],$NachNaz[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
							$OkonchNaz=explode(":",$rowF['OkonchNaz']);
							$OkonchNaz[0]=(Integer)$OkonchNaz[0];
							$OkonchNaz[1]=(Integer)$OkonchNaz[1];
							$OkonchNaz[2]=(Integer)$OkonchNaz[2];
							$OkonchNaz=mktime($OkonchNaz[0],$OkonchNaz[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
							$query = "SELECT `klinikpat`.*
											FROM klinikpat
											WHERE (`klinikpat`.`id` ='".$PatID."')";
						//	echo $query."<br>"; 
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							$PAT="<em>".$row['surname']." ".$row['name']." ".$row['otch']."</em>";
							if ($row['MTel']!='') $mt=$row['MTel'];
							else  $mt="&nbsp;";
							
							
							if ($row['RTel']!='') $rt=$row['RTel'];
							else  $rt="&nbsp;";
							
							if ($row['DTel']!='') $dt=$row['DTel'];
							else  $dt="&nbsp;";
							$query = "SELECT `soderzhnaz`.`SoderzhNaz`
FROM soderzhnaz
WHERE (`soderzhnaz`.`id` ='".$SoderzhNaz."')";
						//	echo $query."<br>"; 
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							if ($tm!=$NachNaz)
							{
								//	echo "<tr>";
//									echo "<td class='alltext'>".date('G:i',$tm)."</td>";
//									echo "<td>&nbsp;</td><td>
//									<a href='naznach.php?date=".$tm."&prodpr=".$rowA['prodpr']."&vrach=".$rowA['vrachID']."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID='".$RMID." class='menu2'>Назначить</a>";
//									echo "</td>";
//									echo "</tr>";	
							}
							if ($Yavka==0) echo "<tr>";
							else echo "<tr bgcolor='#CCCCFF'>";
							echo "<td class='alltext'>".date('G:i',$NachNaz)."</td>";
							echo "<td><a href='pat_card.php?id=".$PatID."&ro=1' class='menu2' target='_blank'>".$PAT."</a><br />
							<span class='bottom2'>".$Perv."</span>
							<span class='bottom'>".$row['SoderzhNaz']."</span>
</td>";
							echo "<td>
						<center>
						<a href='pat_tooday_work_rentgen.php?step=4&pat=".$PatID."&count=1' class='small'>Оплата</a></center>";
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
//						echo "<tr>";
//						echo "<td class='alltext'>".date('G:i',$tm)."</td>";
//						echo "<td>&nbsp;</td>";
//						echo "<td>
//						<a href='naznach.php?date=".$tm."&prodpr=".$rowA['prodpr']."&vrach=".$rowA['vrachID']."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID='".$RMID." class='menu2'>Назначить</a>
//						</td>";
//						echo "<td>&nbsp;</td>";
//						echo "<td>&nbsp;</td>";
//						echo "<td>&nbsp;</td>";
//						echo "<td>&nbsp;</td>";
//						echo "</tr>";
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
}
//include("footer.php");
?>