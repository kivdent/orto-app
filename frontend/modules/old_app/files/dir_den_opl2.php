<?php
$ThisVU="all";
$ModName="Финансовый отчёт за день"; 
include("header.php");
$dt="2007-12-12";
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".$dt."') and (`timeO`='00:00:00')";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>0)
{
echo "<span class='feature4'>ВНИМАНИЕ. Кассовая смена не закрыта.</span><br>";
$zakr=0;
} 
else $zakr=1;
$query = "SELECT `kassa`.`timeN`, `kassa`.`timeO`, `kassa`.`summ`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`kassa`.`id`
FROM kassa, sotr
WHERE ((`kassa`.`date` ='".$dt."') AND 
(`sotr`.`id` =`kassa`.`sotr` )) 
ORDER BY `kassa`.`timeN` DESC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row= mysqli_fetch_array($result);
$summ['kassa']=$row['summ'];
$sm_id=$row['id'];
$query = "SELECT `summ` FROM `sn_kass` WHERE `smena`='".$row['id']."' and `oper`=0";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row= mysqli_fetch_array($result);
$summ['sd']=$row['summ'];
for ($i=$sm_id;$i>0;$i--)
{
	$query = "SELECT `kassa`.`timeN`, `kassa`.`timeO`, `kassa`.`summ`,`kassa`.`id`
FROM kassa
WHERE `kassa`.`id`=".($i-1)." 
ORDER BY `kassa`.`timeN` DESC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
		$row= mysqli_fetch_array($result);
		$summ['kassa2']=$row['summ'];
		$i=0;
	}
}


echo "<form action='dir_den.php' method='get' >
		<center><span class='head1' >Финансовый отчёт за ".$dt."</span></center>
		<hr width='100%' noshade='noshade' size='1'/>";
$query = "SELECT `id`, `nazv` FROM `podr`" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
for ($h=1;$h<=$countA;$h++)
{
$rowA= mysqli_fetch_array($resultA);
	////
	$opl['$h][kol']=0;
	$opl['$h][el']=1;
	$opl['$h][nazv']=$rowA['nazv'];
	$opl['$h][id']=$rowA['id'];
	$tables=array ("dnev","zaknar","schet_orto");
	
	for ($j=0;$j<=2;$j++)
	{
		$query = "SELECT 
		`klinikpat`.`surname`,
		`klinikpat`.`name`,
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		`opl_vid`.`vid`,
		`oplata`.`podr`,
		`oplata`.`date`,
		`".$tables['$j']."`.`date`,
		(`".$tables['$j']."`.`summ_k_opl`-`".$tables['$j']."`.`summ_vnes`) as dolg,
		(`klinikpat`.`otch`) AS patID, 
		(`sotr`.`surname`) AS sotrID,
		`oplata`.`VidOpl`,
		`".$tables['$j']."`.`id`
		FROM klinikpat, sotr, oplata, ".$tables['$j'].", opl_vid
		WHERE (
		(`oplata`.`date` ='".$dt."') AND 
		(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
		(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables['$j']."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
		(`oplata`.`podr`=".$opl['$h][id'].")
		 AND
		(`oplata`.`type`=".($j+1).")
		)
		ORDER BY `".$tables['$j']."`.`vrach`";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>0)
		{
			  for ($i=0;$i<$count;$i++)
				{
					$opl['$h][kol']++;
					$row = mysqli_fetch_array($result);
					if ($opl['$h][kol']==1) 
					{
						$sotr['$h'][$opl['$h]['el]'][id']=$row['sotrID'];
						$sotr['$h'][$opl['$h]['el]'][sotrN']=$row[3]." ".$row[4]." ".$row[5];
					}
					else 
					{
						$fl=0;
						for ($t=1;$t<=$opl['$h][el'];$t++)
						{
							if ($sotr['$h']['$t][id']==$row['sotrID']) $fl=1;
						}
						if ($fl==0) 
						{
							$opl['$h][el']++;
							$sotr['$h'][$opl['$h]['el]'][sotrN']=$row[3]." ".$row[4]." ".$row[5];
							$sotr['$h'][$opl['$h]['el]'][id']=$row['sotrID'];
						}
					}
					$opl['$h'][$opl['$h]['kol]'][patID']=$row['patID'];
					$opl['$h'][$opl['$h]['kol]'][patN']=$row[0]." ".$row[1]." ".$row[2];
					$opl['$h'][$opl['$h]['kol]'][sotrID']=$row['sotrID'];
					$opl['$h'][$opl['$h]['kol]'][sotrN']=$row[3]." ".$row[4]." ".$row[5];
					$opl['$h'][$opl['$h]['kol]'][summ']=$row[6];
					$opl['$h'][$opl['$h]['kol]'][opl_vid']=$row[7];
					$opl['$h'][$opl['$h]['kol]'][patN']="<a class='mmenu' target='_blanc' href=\"print2.php?type=chek&dnev=".$row['15']."&table=".$tables['$j']."&podr=".$opl['$h][id']."\">".$opl['$h'][$opl['$h]['kol]'][patN']."</a>";
					if ($row['10']!=$row[9]) $opl['$h'][$opl['$h]['kol]'][dolg']=" (долг)";
					else $opl['$h'][$opl['$h]['kol]'][dolg']="";
					if ($row['14']==1)
					{ 
						$summ['$h][nal']+=$row[6];
						$summ['nal']+=$row[6];
					}
					$summ['$h][obsch']+=$row[6];
					$summ['obsch']+=$row[6];
				}
				
		}
	}
	//if ($opl['$h][kol']>0)
//	{
//		$podr['$h][kol_sotr']=1;
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrID']=$opl['$h][1][sotrID']=$row['sotrID'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patN']=$opl['$h][1][patN'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patID']=$opl['$h][1][patID'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrN']=$opl['$h][1][sotrN'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][summ']=$opl['$h][1][summ'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][opl_vid']=$opl['1][opl_vid'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][dolg']=$opl['$h][1][dolg'];
//		for ($i=2;$i<$opl['$h][kol'];$i++)
//		{
//			for ($t=$i+1;$t<=$opl['$h][kol'];$t++)
//			{
//				if ($opl['$h']['$i][sotrID']=$opl['$h']['$t][sotrID'])
//				{
//					$podr['$h][kol_sotr']++;
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrID']=$opl['$h']['$t][sotrID']=$row['sotrID'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patN']=$opl['$h']['$t][patN'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patID']=$opl['$h']['$t][patID'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrN']=$opl['$h']['$t][sotrN'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][summ']=$opl['$h']['$t][summ'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][opl_vid']=$opl['$t][opl_vid'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][dolg']=$opl['$h']['$t][dolg'];
//				}
//			}
//		}
//	}
}
$query = "SELECT `podr`,SUM(`summ`) as summ FROM `sn_kass` 
		WHERE ((`smena`='".$sm_id."')
		AND not(`oper`=0))
		GROUP BY `podr`" ;
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$summ['sn_kass][1']=0;
$summ['sn_kass][2']=0;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$summ['sn_kass']['$row['podr']']+=$row['summ'];
}
//echo "<span class='head2'>Приём авансов:</span>";
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `pr_avans`.`summ`
FROM klinikpat, pr_avans
WHERE (
(`pr_avans`.`date` ='".$dt."') AND  
(`klinikpat`.`id` =`pr_avans`.`pat`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ['pr_av']=0;
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$summ['pr_av']+=$row[3];
		}
		
echo "<span class='head1'>Итоги: ".$opl['2][nazv']."</span><br />";		
echo "<span class='head3'>Сумма за день: ".($summ['pr_av']+$summ['2][obsch'])."</span><br />";
if ($summ['sn_kass][1']>0) echo "<span class='head3'>Взято из кассы: ".$summ['sn_kass][1']."</span><br />";
if ($summ['2][obsch']!=$summ['2][nal'])echo "<span class='head3'>Наличными за день: ".($summ['pr_av']+$summ['2][nal'])."</span><br />";
if ($zakr==1) echo "<span class='head3'>Выручка к сдаче: ".($summ['pr_av']+$summ['2][nal']+$summ['kassa2']-$summ['kassa']-$summ['sn_kass][1'])."</span><br />";
else echo "<span class='head3'>Выручка к сдаче: ".($summ['pr_av']+$summ['2][nal']+$summ['kassa2']-$summ['sn_kass][1'])."</span><br />";
echo "<a class='mmenu' target='_blanc' href=\"print2.php?type=otch_d&podr=1\">Печать отчёта  ".$opl['2][nazv']."</a><br />";
echo "<hr width='100%' noshade='noshade' size='1'/>";

echo "<span class='head1'>Итоги: ".$opl['1][nazv']."</span><br />";		
echo "<span class='head3'>Сумма за день: ".$summ['1][obsch']."</span><br />";
if ($summ['sn_kass][1']>0) 
{
	echo "<span class='head3'>Взято из кассы: ".$summ['sn_kass][2']."</span><br />";
	echo "<span class='head3'>Выручка к сдаче: ".($summ['1][obsch']-$summ['sn_kass][2'])."</span><br />";
}
echo "<a class='mmenu' target='_blanc' href=\"print2.php?type=otch_d&podr=2\">Печать отчёта  ".$opl['1][nazv']."</a><br />";
echo "<hr width='100%' noshade='noshade' size='1'/>";
echo "<span class='head1'>Общий остаток в кассе: ".$summ['kassa']."</span><br />";
echo "<hr width='100%' noshade='noshade' size='1'/>";
echo "<span class='head1'>Итоги по врачам</span><br />";	
for ($h=1;$h<=$countA;$h++)
{
	echo "<span class='head3'>Оплата за лечение ".$opl['$h][nazv'].":</span><br />";
	for ($i=1;$i<=$opl['$h][el'];$i++)
	{	
		$c=0;
		$sotr['$h']['$i][summ']=0;
		echo "<span class='head2'>Врач ".$sotr['$h']['$i][sotrN'].":</span><br />";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext' width='50%'>Пациент</td>
				<td class='menutext' width='25%'>Сумма</td>
				<td align='center' class='menutext' width='25%'>Вид оплаты</td>
			  </tr>";
		for ($j=1;$j<=$opl['$h][kol'];$j++)
		{

			if ($sotr['$h']['$i][id']==$opl['$h']['$j][sotrID'])
			{
				  echo "<tr class='alltext'>
					<td>".$opl['$h']['$j][patN']."</td>
					<td>".$opl['$h']['$j][summ']."</td>
					<td>".$opl['$h']['$j][opl_vid'].$opl['$h']['$j][dolg']."</td>
				  </tr>";
				  $sotr['$h']['$i][summ']+=$opl['$h']['$j][summ'];
				  $c++;
			}
		}
		echo "</table>";
		echo "<span class='menutext2'>Принято пациентов: ".$c."</span><br />
				<span class='menutext2'>Сумма: ".$sotr['$h']['$i][summ']."</span><br />
";
	
	}
	$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `oper_vid`.`naim`,`sn_kass`.`summ`
FROM sotr, oper_vid, sn_kass
WHERE ((`sn_kass`.`smena` = '".$sm_id."') 
AND (`oper_vid`.`id` =`sn_kass`.`oper`)
AND not(0 =`sn_kass`.`oper`) 
AND (`sotr`.`id` =`sn_kass`.`otv`)
AND (`sn_kass`.`podr` =".$opl['$h][id']."))";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{echo "<span class='head3'>Деньги из кассы:</span>";	
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
	  <tr>
	  	<td><center class='menutext'>Отвественное лицо</center></td>
	  	<td><center class='menutext'>Сумма</center></td>
		<td><center class='menutext'>Цель</center></td>
		
	  </tr>";
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
	  echo "<tr>
		<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
		<td>".$row[4]."</td>
		<td>".$row[3]."</td>
	  </tr>";
	}
	echo "</table>";
	echo "<span class='menutext2'>Сумма: ".$summ['sn_kass'][$opl['$h]['id']']."</span><br />"; 
}
	
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `pr_avans`.`summ`
FROM klinikpat, pr_avans
WHERE (
(`pr_avans`.`date` ='".$dt."') AND  
(`klinikpat`.`id` =`pr_avans`.`pat`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
		echo "<span class='head3'>Приём авансов:</span>";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'> <tr>
				<td><center class='menutext'>Пациент</center></td>
				<td><center class='menutext'>Сумма</center></td>
			  </tr>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<tr>
				<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
				<td>".$row[3]."</td>
			  </tr>";
		}
		echo "</table><span class='menutext2'>Итого: ".$summ['pr_av']."</span>";
		echo "<hr width='100%' noshade='noshade' size='1'/>";
	}
	echo "<hr width='100%' noshade='noshade' size='1'/>";
	}
include("footer.php");
?>