<?php
/* @var $this View*/

use common\modules\notifier\assets\NotifierAsset;
use yii\web\View;

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Пациенты на сегодня";
NotifierAsset::register($this);
//include("header.php");
switch ($_GET['action'])
{
	case "yavka":
		$query = "UPDATE `nazn` SET `Yavka`=1 WHERE `Id`=".$_GET['IDN'] ;
		//////////echo $query."<br>";
		$result=sql_query($query,'orto',0);
		ret("pat_tooday_reg.php");
	break;
	case "obzv":
		$query = "UPDATE `nazn` SET `RezObzv`=".$_GET['RezObzv']." WHERE `Id`=".$_GET['IDN'] ;
		//////////echo $query."<br>";
		$result=sql_query($query,'orto',0);
		ret("pat_tooday_reg.php");
	break;
	case "NachPr":
		$query = "UPDATE `nazn` SET `NachPr`='".date("H:i").":00' WHERE `Id`=".$_GET['IDN'] ;
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);  
		ret("pat_tooday_reg.php");
	break;
	case "OkonchPr":
		$query = "UPDATE `nazn` SET `OkonchPr`='".date("H:i").":00' WHERE `Id`=".$_GET['IDN'] ;
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);
		ret("pat_tooday_reg.php");
	break;
}
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
$next="<a href='naznach_pat_full.php?vrach=".$_GET['vrach']."&d=1&StartD=".$StartD."'>Дальше</a>";
if (isset($_GET[d]))
{
	
	$DayPr=mktime(0,0,0,date("m"),date("d"),date("Y"))+($_GET[d]*24*60*60);
	$prev="<a href='pat_tooday_reg.php?d=".($_GET[d]-1)."' class='menu2'>".date("d.m.Y",($DayPr-(24*60*60)))."</a>";
	$next="<a href='pat_tooday_reg.php?d=".($_GET[d]+1)."' class='menu2'>".date("d.m.Y",($DayPr+(24*60*60)))."</a>";

}
else
{
	$DayPr=mktime(0,0,0,date("m"),date("d"),date("Y"));
	$prev="<a href='pat_tooday_reg.php?d=-1' class='menu2'>".date("d.m.Y",($DayPr-(24*60*60)))."</a>";
	$next="<a href='pat_tooday_reg.php?d=1' class='menu2'>".date("d.m.Y",($DayPr+(24*60*60)))."</a>";
};

if (date("w",$DayPr)==0) $day=6;
else $day=date("w",$DayPr);
echo "<h4><div class='head3'>". $prev."|Расписание на ".date("d-m-Y",$DayPr).", ".$dn[(date("w",$DayPr)-1)]."|".$next."</div></h4>";
					$query = "SELECT id
FROM sotr
WHERE (dolzh IN (1,2,3))
ORDER BY dolzh ASC";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);					
$countZ=$count;
$resultZ=$result;
for ($z=0;$z<$countZ;$z++)
{ 
$rowZ = mysqli_fetch_array($resultZ);
$vrach=$rowZ['id'];
$query="select `id`,`vrachID`,`prodpr` from`raspis_pack` where 
((`DateD`='".date("Y-m-d",$DayPr)."' or 
`DateD`<'".date("Y-m-d",$DayPr)."')) and
`vrachID`='".$vrach."'
ORDER BY `DateD`
LIMIT 1"; 
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
//	//echo $query."</br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$countD=$count;
			$resultD=$result;
			$rowD= mysqli_fetch_array($result);
			if ($countD>0) 
			{
				$query = "SELECT * FROM `rabmesto` where id='".$rowD['rabmestoID']."'" ;
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					$countB=$count;
					$resultB=$result;
					$rowB = mysqli_fetch_array($resultB);
                                                                                       $RMID=$rowB['rabmestoID'];
					$vih=$rowB['vih'];
					$idDP="N";
					$query = "SELECT nazv FROM `rabmesto` where id='".$rowB['rabmestoID']."'" ;
					
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					$VR="<em>Врач: ".$row['surname']." ".$row['name']." ".$row['otch']."</em>";
					echo $VR."<br>";
					$tm=$nach;
					$tmd=$tm;
					echo "<table  border='1' cellpadding='1' cellspacing='0 ' bordercolor='#999999' width='735'>";
					echo "<tr>";
					echo "<td width='55'>Время</td>";
					echo "<td width='230'>Пациент</td>";
					echo "<td width='90'>Действие</td>";
					echo "<td width='90'>Приём</td>";
					echo "<td width='90'>Моб.тел</td>";
					echo "<td width='90'>Дом.тел</td>";
					echo "<td width='90'>Раб.тел</td>";
					echo "<td width='90'>Обзвон</td>";
					echo "</tr>";
					while ($tm<$okonch)
					{					
						$query = "SELECT `nazn`.*
									FROM nazn
									WHERE ((`nazn`.`dayPR` ='".$idDP."') AND 
											(`nazn`.`NachNaz` >='".date('H:i',$tm).":00') AND 
											(`nazn`.`NachNaz` <'".date('H:i',($tm+($rowA['prodpr']*60))).":00'))";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
							$NachPr=$rowF['NachPr'];
					$OkonchPr=$rowF['OkonchPr'];
				//msg($NachPr." | ".$OkonchPr);
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
							$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
							$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							if ($tm!=$NachNaz)
							{
									echo "<tr>";
									echo "<td class='alltext'>".date('G:i',$tm)."</td>";
									echo "<td>&nbsp;</td><td>
									<a href='naznach.php?date=".$tm."&prodpr=".$rowA['prodpr']."&vrach=".$rowA['vrachID']."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."' class='menu2'>Назначить</a>";
									echo "</td>";
									echo "</tr>";	
							}
							if ($Yavka==0) echo "<tr>";
							else echo "<tr bgcolor='#CCCCFF'>";
							echo "<td class='alltext'>".date('G:i',$NachNaz)."</td>";
							echo "<td title='".$PatID."'>
							<span class='bottom'>Карта №".$PatID."</span></br>							
							<a href='pat_card.php?id=".$PatID."&ro=0' class='menu2' target='_blank'>".$PAT." </a><br />
							<span class='bottom2'>".$Perv."</span>
							<span class='bottom'>".$row['SoderzhNaz']."</span>";
							
						
							






	$query = "SELECT `disc_cards`.`pat`, `disc_cards_types`.`proc`, `disc_cards_types`.`summ`,`disc_cards`.`type` 
FROM disc_cards, disc_cards_types
WHERE ((`disc_cards_types`.`id` =`disc_cards`.`type`) AND (`disc_cards`.`pat` =".$PatID."))";
	////echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		$disc[$row['pat']]['summ']=$row['summ'];
		$disc[$row['pat']]['proc']=$row['proc'];
		$disc[$row['pat']]['type']=$row['type'];
	}
			$query = "SELECT `id`, `proc`, `summ` FROM `disc_cards_types` order by summ";
////echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$dt_count=$count;
for ($i=0;$i<$dt_count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt1[$i]['type']=$row['id'];
	$dt1[$i]['summ']=$row['summ'];
	$dt1[$i]['proc']=$row['proc'];
	$dt1[$j]['count']=0;
}
	$tables=array ("dnev","zaknar","schet_orto");
		$c=0;
		for ($t=0;$t<=2;$t++)
		{
			$query = "SELECT 
			`klinikpat`.`id`, 
			`klinikpat`.`surname`, 
			`klinikpat`.`name`, 
			`klinikpat`.`otch`,  
			SUM(`".$tables[$t]."`.`summ_vnes`) AS `summ`,
			`skidka`.`proc`
			FROM klinikpat, ".$tables[$t].",skidka
			WHERE ((`klinikpat`.`id` =`".$tables[$t]."`.`pat`) and
			(`skidka`.`id`=`klinikpat`.`skidka`) and
			(`klinikpat`.`id`=".$PatID."))
			GROUP BY `klinikpat`.`id`
			ORDER BY `summ`";
			////echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$countc['5']=0;
			$countc['10']=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr[$row['id']]['summ'])) $sotr[$row['id']]['summ']+=$row['summ'];
				else  
				{	
							$sotr[$row['id']]['summ']=$row['summ'];
							if (isset($disc[$row['id']]['proc']))
							$sotr[$row['id']]['sk_card']=$disc[$row['id']]['proc'];
							else $sotr[$row['id']]['sk_card']=0;
							$sotr[$row['id']]['sk_int']=$row['proc'];
							$sotr[$row['id']]['name']=$row['surname']." ".$row['name']." ".$row['otch'];
							$sotr_sp[$c]=$row['id'];
							$c++;
				}
			}
		}
	
	
	
	for ($i=0;$i<$c;$i++)
		{
			for ($j=0;$j<$dt_count;$j++)
					{
						if ($sotr[$sotr_sp[$i]]['summ']>=$dt1[$j]['summ'])
						{
							if ((!(isset($disc[$sotr_sp[$i]]['summ']))) or ( 
									($sotr[$sotr_sp[$i]]['sk_card']<$dt1[$j]['proc']) or
									($dt1[$j]['proc']>$sotr[$sotr_sp[$i]]['sk_int'])))
							{
								$sotr[$sotr_sp[$i]]['sk_card']=$dt1[$j]['proc'];
								if ($sotr[$sotr_sp[$i]]['sk_card']>=$sotr[$sotr_sp[$i]]['sk_int']) 
								{
									$sotr[$sotr_sp[$i]]['sk_tot']=$sotr[$sotr_sp[$i]]['sk_card'];
									$n=$j;
									$sotr[$sotr_sp[$i]]['sk_vid']="(сум)";
								}
								else 
								{
									$sotr[$sotr_sp[$i]]['sk_tot']=$sotr[$sotr_sp[$i]]['sk_int'];
								
									$sotr[$sotr_sp[$i]]['sk_vid']="(coц)";
							}
							}
						}
					}
                                                                                        if ($sotr[$sotr_sp[$i]]['sk_vid']=="(coц)")  $countc[$sotr[$sotr_sp[$i]]['sk_tot']]++;
					if ($sotr[$sotr_sp[$i]]['sk_vid']=="(сум)") 
					{
						$dt1[$n]['count']++;
						$sotr[$sotr_sp[$i]]['type']=$n+1;
					}
			}					
		for ($i=0;$i<$c;$i++)
		{
			if ($sotr[$sotr_sp[$i]]['sk_tot']!=0)
			{
			
			if ($sotr[$sotr_sp[$i]]['sk_vid']!="(coц)")
			{
				if ($sotr[$sotr_sp[$i]]['type']>$disc[$sotr_sp[$i]]['type'])
				echo "<br><a class='menu2' href='discount.php?act=make&action=new&step=1&pat=".$sotr_sp[$i]."&type=".$sotr[$sotr_sp[$i]]['type']."'>Выдать карту</a>";
 		 }
 		 }
		}
		
		
							
							echo "</td>";
							echo "<td class='bottom'>
						<center>
						<a href='naznach.php?IDN=".$IDN."&action=naznezh&step=1&pred=pat_tooday_reg.php&vrach=".$rowA['vrachID']."' class='small'>Назначить</a><br />
						<a href='naznach.php?IDN=".$IDN."&action=peren&step=1&pred=pat_tooday_reg.php' class='small'>Переназначить</a>|
<a href='naznach.php?IDN=".$IDN."&action=ctime&step=1&pred=pat_tooday_reg.php' class='small'>Изменить время приёма</a>|
<a href='naznach.php?IDN=".$IDN."&action=del&pred=pat_tooday_reg.php' class='small'>Отменить</a>";
if ($Yavka==0) echo "|<a href='pat_tooday_reg.php?IDN=".$IDN."&action=yavka' class='small'>Явка</a></center>";
echo "|".\yii\helpers\Html::a(
    'Счёт',
        ['/invoice/manage/create','patient_id'=>$PatID,'appointment_id'=>$IDN,'invoice_type'=>\common\modules\invoice\models\Invoice::TYPE_MATERIALS],
        ['class'=>'small']
    );
//						echo "|Изменить продолжительность";
echo "</td>";
						echo "<td width='90' ";
						 echo "class='bottom'";
						echo "><a href='pat_tooday_reg.php?IDN=".$IDN."&action=NachPr'";
						if ($NachPr=="00:00:00") echo "class='small'";
						else echo "class='small2'";
						echo ">Начало</a>|";
						echo "<a href='pat_tooday_reg.php?IDN=".$IDN."&action=OkonchPr' ";
						if ($OkonchPr=="00:00:00") echo "class='small'";
						else echo "class='small2'";
						echo ">Окончание</a></td>";
						;
						echo "<td width='90' class='bottom'>".$mt." ".\yii\helpers\Html::button('CMC',['appointment'=>$IDN,'class'=>'btn btn-info btn-xs send_sms'])."
</td>";
						echo "<td width='90' class='bottom'>".$dt."</td>";
						echo "<td width='90' class='bottom'>".$rt."</td>";
						echo "<td width='90' class='bottom'>";
						echo "<script type=\"text/JavaScript\">
			<!--
			function MM_jumpMenu(targ,selObj,restore){ //v3.0
			  eval(targ+\".location='\pat_tooday_reg.php?action=obzv\"+selObj.options[selObj.selectedIndex].value+\"'\");
			  if (restore) selObj.selectedIndex=0;
			}
			//-->
				</script>
		        <select name=\"obzv\" onchange=\"MM_jumpMenu('parent',this,0)\">";
				$query = "SELECT * FROM `rezobzv`";
				//////////echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result); 
					if ($row['id']==$RezObzv) 
                                                                                       echo "<option  value='&IDN=".$IDN."&RezObzv=".$row['id']."' selected='selected'>".$row['RezObzv']."</option>";
					else echo "<option  value='&IDN=".$IDN."&RezObzv=".$row['id']."'>".$row['RezObzv']."</option>";
				}
               
                
						echo "</select></td></tr>";
						 		
						 while ($tmd<=$OkonchNaz)
						 {
						 	$tmd=$tmd+($rowA['prodpr']*60);
						 }
						 $tm=$OkonchNaz;				
						}
						else 
						{
						echo "<tr>";
						echo "<td class='alltext'>".date('G:i',$tm)."</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>
						<a href='naznach.php?date=".$tm."&prodpr=".$rowA['prodpr']."&vrach=".$rowA['vrachID']."&okonchS=".$okonch."&idDP=".$idDP."&nachS=".$nach."&RMID=".$RMID."' class='menu2'>Назначить</a>
						</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
						echo "<td>&nbsp;</td>";
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
}
//include("footer.php");
?>