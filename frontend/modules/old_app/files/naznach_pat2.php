<?php
$ThisVU="all";
$this->title="Работа с расписанием"; 
//include("header.php");
echo "<a href='naznach_pat_full.php'>naznach_pat2.php</a>";
echo "<h4>Выбирите продолжение</h4>";
echo "<hr />"; 
if (!isset($_GET['show']))
{
//	echo "	<form method='get' action=''>
//			  <label></label>
//			  <table width='460' border='0' cellspacing='0' cellpadding='0'>
//				<tr>
//				  <td><table width='100%' border='1' cellpadding='1'>
//					<tr>
//					  <td width='34%'><label>Врач</label></td>
//					  <td width='66%'>
//					  <select name='vrach' id='vrach'>";
//					  $query = "select id,surname,name,otch from `sotr`" ;
//						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//						for ($i=0; $i <$count; $i++)
//						{
//						$row = mysqli_fetch_array($result);
//						echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
//						}
//						echo "<option value='all'>Все</option>
//								</select></td>
//					</tr>
//					<tr>
//					  <td>Смены</td>
//					  <td><select name='smeni' id='smeni'>
//						<option value='free'>Свободные</option>
//						<option value='all'>Все</option>
//										  </select></td>
//					</tr>
//					<tr>
//					  <td>Время</td>
//					  <td><label>
//						<select name='vremya' id='vremya'>
//							<option value='all' selected='selected'>Все</option>
//							<option value='utro'>Утро</option>
//							<option value='vecher'>Вечер</option>
//						</select>
//					  </label></td>
//					</tr>
//				  </table></td>
//				</tr>
//				<tr>
//				  <td><label>
//					<div align='center'>
//					  <input name='Show' type='submit' value='Показать смены' />
//					  </div>
//				  </label></td>
//				</tr>
//			  </table>
//			  <p>&nbsp;</p>
//			</form>";
			$StartD=mktime(0,0,0,date('m'),date('d'),date('Y'));
			if (isset($_GET[d]))
			{ 	
				$StartD=$_GET['StartD'];
				$StartD=$StartD+(($_GET[d])*(7*24*60*60));
				$DayPr=$StartD;
				$EndD=$StartD+(7*24*60*60);
				$next="<a href='naznach_pat.php?d=1&StartD=".$StartD."'>Дальше<a>";
				if ($StartD==$_GET['StartD']) $prev="";
				else $prev="<a href='naznach_pat.php?d=-1&StartD=".$StartD."'>Назад<a>";
			}
			else 
			{
				$DayPr=$StartD;
				$EndD=$StartD+(7*24*60*60);
				$next="<a href='naznach_pat.php?d=1&StartD=".$StartD."'>Дальше<a>";
				$prev="";
			}
			echo "<div align='center' class='feature3'>".$prev."|".$next."</div>";
			while ($DayPr<$EndD)
			{

					$query = "SELECT *
FROM sotr
WHERE (dolzh=1)
ORDER BY dolzh ASC";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);					
					$countZ=$count;
					$resultZ=$result;
					for ($z=0;$z<$countZ;$z++)
					{
						$vih=1;
						$rowZ = mysqli_fetch_array($resultZ);
						$vrach=$rowZ['id'];
						$VR="Врач: ".$rowZ['surname']." ".$rowZ['name']." ".$rowZ['otch'].", ";
						if (date("w",$DayPr)==0) $day=7;
							else $day=date("w",$DayPr);
						$query = "SELECT `daypr`.*, `nazn`.*
		FROM daypr, nazn
		WHERE ((`daypr`.`date` ='".date('Y-m-d ',$DayPr)."') AND 
				(`nazn`.`dayPR` =`daypr`.`id`) AND
				(`daypr`.`vrachID` ='".$vrach."'))
		ORDER BY `nazn`.`NachNaz` ASC" ;
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$countD=$count;
						$resultD=$result;
						if ($countD>0) 
						{
							//
							for ($i=0;$i<$countD;$i++)
							{
								$rowD= mysqli_fetch_array($resultD);
								$nach=explode(":",$rowD['`daypr`.Nach']);
								$nach[0]=(Integer)$nach[0];
								$nach[1]=(Integer)$nach[1];
								$nach[2]=(Integer)$nach[2];
								$nach=mktime($nach[0],$nach[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								//
								$okonch=explode(":",$rowD['`daypr`.Okonch']);
								$okonch[0]=(Integer)$okonch[0];
								$okonch[1]=(Integer)$okonch[1];
								$okonch[2]=(Integer)$okonch[2];
								$okonch=mktime($okonch[0],$okonch[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								$vih=$rowD['`daypr`.vih'];
								$idDP=$rowD['`daypr`.id'];
								$RMID=$rowD['`daypr`.rabmestoID'];

								$nachNN=explode(":",$rowD['`nazn`.NachNaz']);
								$nachNN[0]=(Integer)$nachNN[0];
								$nachNN[1]=(Integer)$nachNN[1];
								$nachNN[2]=(Integer)$nachNN[2];
								$nachN['$i']=mktime($nachNN[0],$nachNN[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								
								$okonchNN=explode(":",$rowD['`nazn`.OkonchNaz']);
								$okonchNN[0]=(Integer)$okonchNN[0];
								$okonchNN[1]=(Integer)$okonchNN[1];
								$okonchNN[2]=(Integer)$okonchNN[2];
								$okonchN['$i']=mktime($okonchNN[0],$okonchNN[1],0,date("m",$DayPr),date("d",$DayPr),date("Y",$DayPr));
								$prodpr=$rowD['`daypr`.TimePat'];
								
							}
						}
				else 
				{
						$query = "SELECT `raspis_day`.*, `raspis_pack`.*
								FROM raspis_day, raspis_pack
								WHERE ((`raspis_day`.`raspis_pack` =`raspis_pack`.`id`) AND 
									   (`raspis_day`.`dayN` ='".(date('w ',$DayPr)+1)."') AND 
									   (`raspis_pack`.`DateD` <= '".date('Y-m-d ',$DayPr)."')AND
									   (`raspis_pack`.`vrachID` ='".$vrach."'))";
		   				
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
						echo "<div class='bold1'>".date("d/m/Y",$DayPr)."</div>";
						echo "<div class='bold2'>".$VR;
						$query = "SELECT nazv FROM `rabmesto` where id='".$RMID."'" ;
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
						echo $row['nazv']."</div>";
						$tm=$nach;
						echo "<table border='1' cellpadding='1' width='440' class='feature2'>";
						echo "<tr>";
						echo "<td width='55'>Время</td>";
						echo "<td width='230'>Пациент</td>";
						echo "<td width='135'>Действие</td>";
						echo "</tr>";
						while ($tm<$okonch)
						{	
							$tmd=$tm;
							if  ($resultD>0)
							{
								$fl=0;
								for ($i=0;$i<$countD;$i++)
								{	
									
									if (($nachN['$i']>=$tm) and ($nachN['$i']<($tm+($prodpr*60))))
									{	
										$nachN1=$nachN['$i'];
										$okonchN1=$okonchN['$i'];
										$fl=1;
									}
								}		
									if ($fl==1)
										{
											if ($tm!=$nachN1)
											{
													echo "<tr>";
													echo "<td>".date('G:i',$tm)."</td>";
													echo "<td>&nbsp;</td>";
													echo "<td><a href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."'>Назначить<a></td>";
													echo "</tr>";	
											}
											//echo "<tr>";
//											echo "<td>".date('G:i',$nachN1)."</td>";
//											echo "<td>Занято<br /></td>
//											<td><a href='naznach.php?IDN=".$IDN."&action=del'>Отменить<a>";
//											echo "</td>";
//											echo "</tr>";	
											while ($tmd<=$okonchN1)
											{
												$tmd=$tmd+($prodpr*60);
											}
											$tm=$okonchN1;	
										}
											else 
											{
												echo "<tr>";
												echo "<td>".date('G:i',$tm)."</td>";
												echo "<td>&nbsp;</td>";
												echo "<td>
												<a href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."'>Назначить<a>
												</td>";
												echo "</tr>";
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
									echo "<tr>";
									echo "<td>".date('G:i',$tm)."</td>";
									echo "<td>&nbsp;</td>";
									echo "<td>
									<a href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."'>Назначить<a>
									</td>";
									echo "</tr>";
									if ($tmd>$tm) $tm=$tmd;
									else
									{ 
										$tm=$tm+$prodpr*60;
										$tmd=$tm;
									}
							}//ELSE	
						}//WHILE
							echo "</tr>";
							echo "</table>";
					}	
				}
					$DayPr=$DayPr+(24*60*60);
			}
}			
//include("footer.php");
?>
