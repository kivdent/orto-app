<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Ежедневник"; 
$js="ShowPat"; 
//include("header.php");
echo "<div class='head1'>Ежедневник</div>";
echo "<hr width='100%' noshade='noshade' size='1'/>";
			$StartD=mktime(0,0,0,date('m'),date('d'),date('Y'));
			if (isset($_GET['d']))
			{ 	
				$StartD=$_GET[StartD];
				$StartD=$StartD+(($_GET[d])*(7*24*60*60));
				$DayPr=$StartD;
				$EndD=$StartD+(7*24*60*60);
				$next="<a href='raspis_doctor_show.php?d=1&StartD=".$StartD."'>Дальше</a>";
				if ($StartD==$_GET[StartD]) $prev="";
				else $prev="<a href='raspis_doctor_show.php?d=-1&StartD=".$StartD."'>Назад</a>";
			}
			else 
			{
				$DayPr=$StartD;
				$EndD=$StartD+(7*24*60*60);
				$next="<a href='raspis_doctor_show.php?d=1&StartD=".$StartD."'>Дальше</a>";
				$prev="";
			}
			echo "<div align='center' class='feature3'>".$prev."|".$next."</div>";
			$query = "SELECT *
						FROM sotr
						WHERE id='".$_SESSION['UserID']."'";
			$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result);					
			$countZ=$count;
			$resultZ=$result;
			////Цикл по всем врачам
			for ($z=0;$z<$countZ;$z++)
			{	$rowZ = mysqli_fetch_array($resultZ);
				$vrach=$rowZ['id'];
				$VR="Врач: ".$rowZ['surname']." ".$rowZ['name']." ".$rowZ['otch'].", ";
				echo "<div class='bold2'>".$VR."</div>";
				/////Начало строки в таблице
					echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#CCCCCC' bordercolordark='#FFFFFF'><tr>";
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
					$td=mktime(0,0,0,date('m'),date('d'),date('Y'));
					if ($td==$DayPr)	echo "<td valign='top' bgcolor='#ECECEC'>";
					else echo "<td valign='top' bgcolor='#FFFFFF'>";
echo "<center><strong>".date('d.m.y',$DayPr).",<br />".$dn[($day-1)]."</strong></center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#666666' bgcolor='#FFFFFF'>";
					$vih=1;
					if (date("w",$DayPr)==0) $day=7;
					else $day=date("w",$DayPr);
					$query = "SELECT `daypr`.*
					FROM daypr
					WHERE ((`daypr`.`date` ='".date('Y-m-d ',$DayPr)."') AND 
							(`daypr`.`vrachID` ='".$vrach."'))";
					//////////echo $query."<br />";
					$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result);
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
									ORDER BY `nazn`.`NachNaz` DESC" ;
						
						//////////echo $query."<br />";
						$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result);
						$countD=$count;
						$resultD=$result;
						if ($countD>0)
							for ($i=0;$i<$countD;$i++)
							{	
								$rowD = mysqli_fetch_array($resultD);
								$idP[$i]=$rowD[0];
								$nP[$i]= $rowD[2]."<br />".$rowD[3]."<br />".$rowD[4];
								$IDN[$i]=$rowD[1];
								$nachNN=explode(":",$rowD[5]);
								$nachNN[0]=(Integer)$nachNN[0];
								$nachNN[1]=(Integer)$nachNN[1];
								$nachNN[2]=(Integer)$nachNN[2];
								$nachN[$i]=mktime($nachNN[0],$nachNN[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								
								$okonchNN=explode(":",$rowD[6]);
								$okonchNN[0]=(Integer)$okonchNN[0];
								$okonchNN[1]=(Integer)$okonchNN[1];
								$okonchNN[2]=(Integer)$okonchNN[2];
								$okonchN[$i]=mktime($okonchNN[0],$okonchNN[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								
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
									   (`raspis_pack`.`vrachID` ='".$vrach."'))";
		   				
						$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result);
						$countB=$count;
						$resultB=$result;
						if ($countB>0)
						{
							$rowB = mysqli_fetch_array($resultB);
							$idDP="N";		
							$prodpr=$rowB['prodpr'];
							$vih=$rowB['vih'];
							$RMID=$rowB['rabmestoID'];
							$countD=1;					
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
							$nachN=NULL;
							$okonchN=NULL;
						}
						//
				}
                               
					if ($vih==0)
					{
						$tm=$nach;
						while ($tm<$okonch)
						{	
							$tmd=$tm;
							if  ($countW>0)
							{
								$fl=0;
								if ($countD>0)
								{
									for ($i=0;$i<$countD;$i++)
									{	
										if (($nachN[$i]>=$tm) and ($nachN[$i]<($tm+($prodpr*60))))
										{	
											$nachN1=$nachN[$i];
											$okonchN1=$okonchN[$i];
											$fl=$i+1;
										}
									}
								}		
								if ($fl!=0)
										{
											if ($tm!=$nachN1)
											{
												echo "<tr>
												<td >".date('G:i',$tm)."</td>
												<td>&nbsp;</td>
												<td><a class='small' href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."&pred=raspis_doctor_show.php'>Назначить</a></td></tr>";
											}
											echo "<tr>";
											echo "<td class='smalltext' >".date('G:i',$nachN1)."</td>";
											echo "<td><a href='pat_card.php?id=".$idP[($fl-1)]."&ro=0' class='small' target='_blank'>".$nP[($fl-1)]."</a><br /></td>
											<td align='center'><a href='naznach.php?IDN=".$IDN[($fl-1)]."&action=del&pred=raspis_doctor_show.php' class='small'>Отменить</a><br />
											<a href='naznach.php?IDN=".$IDN[($fl-1)]."&action=peren&step=1&pred=raspis_doctor_show.php' class='small'>Переназначить</a><br />
											<a href='naznach.php?IDN=".$IDN[($fl-1)]."&action=naznezh&step=1&pred=raspis_doctor_show.php' class='small'>Назначить</a><br />
											<a href='naznach.php?IDN=".$IDN[($fl-1)]."&action=ctime&step=1&pred=raspis_doctor_show.php' class='small'>Изменить время приёма</a><br />
";
											echo "</td>";
											echo "</tr>";	
											while ($tmd<=$okonchN1)
											{
												$tmd=$tmd+($prodpr*60);
											}
											$tm=$okonchN1;	
										}
									else 
									{
										echo "<tr>
												<td>".date('G:i',$tm)."</td>
												<td>&nbsp;</td>
												<td><a class='small' href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."&pred=raspis_doctor_show.php'>Назначить</a></td></tr>";
											if ($tmd>$tm) $tm=$tmd;
											else
										{ 
											$tm=$tm+$prodpr*60;
											$tmd=$tm;
										}
									}//ELSE			
							}
							else 
							{
									echo "<tr>
									<td>".date('G:i',$tm)."</td>
									<td>&nbsp;</td>
									<td><a class='small' href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."&pred=raspis_doctor_show.php'>Назначить</a></td></tr>";
									if ($tmd>$tm) $tm=$tmd;
									else
									{ 
										$tm=$tm+$prodpr*60;
										$tmd=$tm;
									}
							}//ELSE	
						}//WHILE
					}
				if ($vih==1) echo "<tr><td>Выходной</td></tr>";
				echo "</table></td>";	
				$DayPr=$DayPr+(24*60*60);
				}
				///Окончание таблицы
				echo " </tr></table>";
				echo "<hr width='100%' noshade='noshade' size='1'/>";	
			}		
//include("footer.php");
?>
