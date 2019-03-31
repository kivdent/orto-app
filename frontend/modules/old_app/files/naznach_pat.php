<?php

include('mysql_fuction.php');
include('function_oap.php');
$ThisVU="all";
$this->title="Работа с расписанием"; 
//include("header.php");

echo "<div class='head1'>Назначение пациентов</div>";
echo "<center><a href='naznach_pat_full.php' class='menu2'>Полное расписание</a></center>";
echo "<hr width='100%' noshade='noshade' size='1'/>";
			//Назначение стартовой даты $StartD
                        $StartD=mktime(0,0,0,date('m'),date('d'),date('Y'));
			//Если есть дата в строке
                        if (isset($_GET['d']))
			{ 	
                                //Назначение стартовой даты из строки
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
echo "<form id=\"jump_vrach\" method=\"get\">";
echo "<div>Выбирите врача: ";
			$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch` 
						FROM raspis_pack, sotr
						WHERE `raspis_pack`.`vrachID` = `sotr`.`id`
						GROUP BY `sotr`.`id`
						ORDER BY `sotr`.`surname` ASC
						";
			$result=sql_query($query,'orto',0);    
                                                     $count=mysqli_num_rows($result);					
 echo " <select id=\"vrach\">";
if ((!(isset($_GET['vrach']))) or ($_GET['vrach']=='all')) echo "<option value='all' selected='selected'>Все врачи</option>";
else echo "<option value='all'>Все врачи</option>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($_GET['vrach']==$row['id']) echo "<option value='naznach_pat.php?vrach=".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	else echo "<option value='naznach_pat.php?vrach=".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
}
echo "  </select>";
echo "<script type=\"text/JavaScript\">
 $('#vrach').change(function() {
  var url = $(\"#vrach\").val();
 $(location).attr('href',url);
    });
</script>";
//
//
// форма выбора врача  jump_menu($id_change,$action_page,$action_str,$select_options,$menu_id,$selected_option="0")
 //формат $select_option=array(array('label'=>'label','value_option'=>'value','str'='значение переменной, например $status_app='),...))
 //формат $action_str стриница с дествием, название действия: \pat_tooday_reg.php\
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysqli_fetch_array($result);
//                $select_options[$i]=(array('label'=>".$row['surname']." ".$row['name']." ".$row['otch'].",'value_option'=>".$row['id'].",'str'='$vrach=');                                                  )
//	}
//$selected="0";
//if isset($_GET['vrach']) {$selected=$_GET['vrach'])}
//jump_menu("vrach_change","naznach_pat.php","naznach_pat.php",$select_options,$menu_id,$selected_option="0");
//                        
echo "</div></form>";
if ((!(isset($_GET['vrach']))) or ($_GET['vrach']=='all'))	$query = "SELECT `raspis_pack`. * , `sotr`. * , `sotr`.`id` 
FROM raspis_pack, sotr
WHERE `raspis_pack`.`vrachID` = `sotr`.`id`";
					else $query = "SELECT *
						FROM sotr
						WHERE id=".$_GET['vrach'];

			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);					
			$countZ=$count;
			$resultZ=$result;
			for ($z=0;$z<$countZ;$z++)
			{	$rowZ = mysqli_fetch_array($resultZ);
				$vrach=$rowZ['id'];
				$VR="Врач: ".$rowZ['surname']." ".$rowZ['name']." ".$rowZ['otch'].", ";
				echo "<div class='bold2'>".$VR."</div>";
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
					echo "<td valign='top'><center><strong>".date('d.m.y',$DayPr).", ".$dn[($day-1)]."</strong></center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#666666'>";
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
									   (`raspis_pack`.`vrachID` ='".$vrach."'))
									   ORDER BY `raspis_pack`.`DateD` DESC";
		   				
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
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
											$fl=1;
										}
									}
								}	
									if ($fl==1)
										{
											if (($tm!=$nachN1) and ($tm!=$nach))
											{
												echo "<tr>
												<td><a href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."&pred=naznach_pat.php'>".date('G:i',$tm)." Назначить.<a></td></tr>";
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
												echo "<tr><td><a href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."&pred=naznach_pat.php'>".date('G:i',$tm)." Назначить.<a></td></tr>";
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
									echo "<tr><td><a href='naznach.php?date=".$tm."&prodpr=".$prodpr."&vrach=".$vrach."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."&pred=naznach_pat.php'>".date('G:i',$tm)." Назначить.<a></td></tr>";
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
			}		
//include("footer.php");
?>