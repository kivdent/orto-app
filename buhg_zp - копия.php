<?php
$ThisVU="buhg";
$ModName="Начисление заработной платы";  
include("header.php");
//	$query = "SELECT 'id' FROM `sotr` WHERE `dolzh` IN (1,2,3)";
//	////echo $query."<br />";
//	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//	$resultA=$result;
//	$countA=$count;
$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;


////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	if (!(isset($_GET['fp'])) and ($i==0))
	{
		$dtNp=explode("-",$row['nach']);
		$dtOp=explode("-",$row['okonch']);
		$dtN=$row['nach'];
		$dtO=$row['okonch'];
		$fp=$row['id'];
	}
	else
	{
		if ($_GET['fp']==$row['id'])
		{
			$dtNp=explode("-",$row['nach']);
			$dtOp=explode("-",$row['okonch']);
			$dtN=$row['nach'];
			$dtO=$row['okonch'];
			$fp=$row['id'];
		}
	}
	$dt=explode("-",$row['okonch']);
	switch ($_GET['action'])
	{
		case "avans":
			switch ($_GET['avans'])
			{
			 case "insert":
			 $query = "INSERT INTO `zp_avans` (`id`, `sotr`, `fp`, `avans`) 
			 			VALUES (NULL, ".$_GET['sotr'].", ".$_GET['fp'].", ".$_GET['summ'].")";
			echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret('buhg_zp.php');
				exit;
			 break;
			 case "update":
			 	 $query = "UPDATE `zp_avans` 
			 	 			SET 
			 	 			`avans`= ".$_GET['summ']."
			 	 			WHERE
			 	 			`id`=".$_GET['id'];
			echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret('buhg_zp.php');
				exit;
			 break;
			}
			
			$query = "SELECT `id`,`avans` FROM `zp_avans` WHERE ((`sotr`=".$_GET['sotr'].") AND (`fp`=".$_GET['fp']."))";
			echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			
			if ($count>0)
			{
				$row = mysqli_fetch_array($result);
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ()
			{
				q=prompt('Изменение суммы аванса','".$row['avans']."');
				url='buhg_zp.php?action=avans&fp=".$_GET['fp']."&sotr=".$_GET['sotr']."&avans=update&id=".$row['id']."&summ='+q;
				location.href=url;
			}";
			echo "ChQ()</script>";
			exit;
				
			}
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ()
			{
				q=prompt('Сумма аванса','1000');
				url='buhg_zp.php?action=avans&fp=".$_GET['fp']."&sotr=".$_GET['sotr']."&avans=insert&summ='+q;
				location.href=url;
			}";
			echo "ChQ()</script>";
			exit;
			ret('buhg_zp.php');
		break;
	}
	echo "| <a class='menu2' href='buhg_zp.php?fp=".$row['id']."' >".$m[($dt['1]-1)']." ".$dt[0]."</a> |";
}
	echo "<div class='head1'>Начисление заработной платы за ".$m[($dtOp['1]-1)']."</div><br />";
	echo "<a class='mmenu' target='_blanc' href=\"print.php?type=zp_otchet&fp=".$fp."&m=".($dtOp[1]-1)."\">Печать отчёта</a><br />";
	echo "<a class='mmenu' target='_blanc' href=\"print4.php?type=zp_otchet_1&fp=".$fp."&m=".($dtOp[1]-1)."\">Печать сумм январь 2011</a><br />";
		
	$tables=array ("dnev","zaknar","schet_orto");
	$manip_pr=array("manip_pr","manip_zn","manip_sh_orto");
	$manip_dnev=array("dnev","ZN","SO");
			for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT SUM( `oplata`.`vnes` ) AS summ, `".$tables['$j']."`.`vrach` 
FROM ".$tables['$j'].", manip, ".$manip_pr['$j'].", oplata
WHERE (
(
`oplata`.`date` >= '".$dtN."'
)
AND (
`oplata`.`date` <= '".$dtO."'
)
AND (
`oplata`.`dnev` = `".$tables['$j']."`.`id` 
)
AND (
`".$manip_pr['$j']."`.`".$manip_dnev['$j']."` = `".$tables['$j']."`.`id` 
)
AND (
`manip`.`id` = `".$manip_pr['$j']."`.`manip` 
)
AND (
`manip`.`UpId` 
IN ( 513, 273, 485 )))
GROUP BY `".$tables['$j']."`.`vrach`" ;
//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$sum_mat['$row['vrach']']=$row['summ'];
			}
		}
	//for ($j=0;$j<$countA;$j++)
//	{
//		$row = mysqli_fetch_array($resultA);
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			SUM(`oplata`.`vnes`) AS summ,
			`zarp_card`.`stavka`,
			`zarp_card`.`id` as zc_id,
			`proc_sh`.`id` as pc_id,
			`zarp_card`.`pn`
			FROM sotr, oplata, ".$tables['$j'].",zarp_card,proc_sh
			WHERE (
			(`proc_sh`.`id`=`zarp_card`.`ps`) AND 
			(`zarp_card`.`type`=1) AND
			(`".$tables['$j']."`.`vrach`=`zarp_card`.`sotr`) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).")
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][zc']=$row['zc_id'];
					$sotr['$row['id]'][stavka']=$row['stavka'];
					$sotr['$row['id]'][pc']=$row['pc_id'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['$row['id]'][dolzh']=$row['dolzh'];
					$sotr['$row['id]'][pn']=$row['pn'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
		
	//}

	echo "<br /><span class='head3'>Расчёт по проценту от выручки</span><br />
		<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Врач</td>
    <td class='menutext'>Выручка</td>
    <td class='menutext'>%</td>
	<td class='menutext'>% от выручки</td>
	<td class='menutext'>Подоходный</td>
	
    <td class='menutext'>Зарплата</td>
    <td class='menutext'>Действия</td>
  </tr>";
for ($i=0;$i<$c;$i++)
{
	
	echo "<tr>
    <td>".$sotr[$sotr_sp['$i]][name']."</td>
    <td>".($sotr[$sotr_sp['$i]][summ']-$sum_mat[$sotr_sp['$i]'])."</td>
    <td>";
     $sotr[$sotr_sp['$i]][summ']=($sotr[$sotr_sp['$i]][summ']-$sum_mat[$sotr_sp['$i]']);
	$query = "SELECT `predel`,`proc` FROM `proc_sh_sootv` WHERE `proc_sh`=".$sotr[$sotr_sp['$i]][pc']." ORDER BY `predel` ASC" ;
	////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count==1) 
	{
		$row = mysqli_fetch_array($result);
		$proc=$row['proc'];
	}
	else
	for ($j=0;$j<$count;$j++)
		{
			   $row = mysqli_fetch_array($result);
			   if ($sotr[$sotr_sp['$i]][summ']<$row['predel'])
			   {
			   		$proc=$row['proc'];
					$j=$count+1;
			   }  
		}
	$zp=(($sotr[$sotr_sp['$i]][summ']*$proc)/100);
	$zp-=$zp*$sotr[$sotr_sp['$i]][pn'];
	
	//switch ($sotr[$sotr_sp['$i]][dolzh'])
//	{
//		case "1":
//			if ($sotr[$sotr_sp['$i]][summ']<100000)
//			{ 
//				$proc=18;
//				$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//			}
//			else if ($sotr[$sotr_sp['$i]][summ']<150000)
//			{ 
//				$proc=19;
//				$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//			}
//			else
//			{ 
//				$proc=21;
//				$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//			}	
//		break;
//		case "8":
//			if ($sotr[$sotr_sp['$i]][summ']<100000)
//			{ 
//				$proc=18;
//				$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//			}
//			else
//			{ 
//				$proc=19.5;
//				$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//			}	
//		break;
//	}
//	switch ($sotr_sp['$i'])
//	{
//		case "22":
//			$proc=18;
//			$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//		break;
//		case "21":
//			$proc=17;
//			$zp=($sotr[$sotr_sp['$i]][summ']*$proc)/100;
//		break;
//		case "2":
//			$proc='ставка';
//			$zp=65000-65000*0.13;
//		break;
//	}
	echo $proc."%</td>
	<td>".round((($sotr[$sotr_sp['$i]][summ']*$proc)/100),2)."</td>
	<td>".round(((($sotr[$sotr_sp['$i]][summ']*$proc)/100)*$sotr[$sotr_sp['$i]][pn']),2)."</td>
	
    <td>".round($zp,2)."</td>
    <td>
   "; 
  // echo "<a href=buhg_zp.php?action=avans&fp=".$fp."&sotr=".$sotr_sp['$i']." class='menu2'>Размер аванса</a><br>
   // <a href=buhg_zp.php?action=prem&fp=".$fp."&sotr=".$sotr_sp['$i']." class='menu2'>Премия</a><br>";
   echo " <a class='menu2' target='_blanc' href=\"print.php?type=zp_fishka&sotr=".$sotr_sp['$i']."&vid=1&fp=".$fp."\">Печать</a><br />";
   echo "

    </td>
  </tr>";
}
//for ($j=0;$j<$countA;$j++)
//	{
//		$row = mysqli_fetch_array($resultA);
			for ($j=0;$j<=2;$j++)
		{
				$query = "SELECT SUM( `oplata`.`vnes` ) AS summ, `".$tables['$j']."`.`vrach` 
FROM ".$tables['$j'].", manip, ".$manip_pr['$j'].", oplata
WHERE (
(`".$tables['$j']."`.`vrach`=2) AND
(`oplata`.`VidOpl`=5) AND
(
`oplata`.`date` >= '".$dtN."'
)
AND (
`oplata`.`date` <= '".$dtO."'
)
AND (
`oplata`.`dnev` = `".$tables['$j']."`.`id` 
)
AND (
`".$manip_pr['$j']."`.`".$manip_dnev['$j']."` = `".$tables['$j']."`.`id` 
)
AND (
`manip`.`id` = `".$manip_pr['$j']."`.`manip` 
)
AND (
`manip`.`UpId` 
IN ( 513, 273, 485 )))";
//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$sum_mat['$row['vrach']']=$row['summ'];
			}
		}
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			SUM(`oplata`.`vnes`) AS summ
			FROM sotr, oplata, ".$tables['$j']."
			WHERE (
			(`".$tables['$j']."`.`vrach`=2) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).") AND 
			(`oplata`.`VidOpl`=5)
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		}
		for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
	echo "<tr>
    <td>".$sotr['2][name']."</td>
    <td>".($sotr['2][summ']-$sum_mat[2])."</td>
    <td class='menutext'></td>
	<td class='menutext'></td>
	<td class='menutext'></td>
	
    <td>".($sotr['2][summ']-$sum_mat[2])."</td>
    <td class='menutext'></td>
  </tr>";
echo "</table><br />";
$query = "SELECT `sotr`.`id`,`sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` , `zarp_card`.`ph`,`zarp_card`.`id` as zc
FROM sotr, zarp_card
WHERE (
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =3
)
)";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
echo "<span class='head3'>Расчёт по сменам</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Сотрудник</td>
    <td class='menutext'>Часов</td>
	<td class='menutext'>За час</td>
	<td class='menutext'>Сумм по сменам</td>
	<td class='menutext'>Сумм по снимкам</td>
	<td class='menutext'>Надбавки</td>
	<td class='menutext'>Подоходный</td>
    <td class='menutext'>Зарплата</td>
    <td class='menutext'>Действия</td>
  </tr>";
for ($i=0; $i<$countA; $i++)
{
	$rowA = mysqli_fetch_array($resultA);
	echo "<tr>";
	echo "<td>".$rowA['surname']." ".$rowA['name']." ".$rowA['otch']."</td>";
	//$query = "SELECT `nach` , `okonch`, `id`
//FROM `fin-per` 
//ORDER BY `id` DESC 
//LIMIT 0,1" ;
////echo $query."<br>";
//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//
//$row = mysqli_fetch_array($result);
//$fp=$row['id'];
//$dtNp=explode("-",$row['nach']);
//$dtOp=explode("-",$row['okonch']);
$dtN_TS=mktime(0,0,0,(integer)$dtNp[1],(integer)$dtNp[2],(integer)$dtNp[0]);
$dtO_TS=mktime(0,0,0,(integer)$dtOp[1],(integer)$dtOp[2],(integer)$dtOp[0]);
//$dtN_TS=mktime(0,0,0,12,3,2007);
//$dtO_TS=mktime(0,0,0,12,31,2007);
//mktime(
//$dtN=$row['nach'];
//$dtO=$row['okonch'];
//msg($dtN_TS." - ".$dtO_TS);
	$query = "SELECT `tabel`.`time`
	FROM  tabel
	WHERE (
	(`tabel`.`date` >='".$dtN."') AND 
	(`tabel`.`date` <='".$dtO."') AND 
	(`tabel`.`sotr` =".$rowA['id'].")
	)";
	////echo $query."<br />";

	
$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."') AND 
(`sotr` =".$rowA['id'].")
)
ORDER BY `sotr` ASC, `date` ASC";	
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
			$in=explode(":",$row['in']);
		$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
		$out=explode(":",$row['out']);
		$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
		if (($out2-$in2)>0) $summ+=($out2-$in2);
		//$summ+=(floor($row['time'])*60)+(($row['time']-floor($row['time']))*100);
	}
	//
	$summ+=21600;
	$ss=round($summ/3600,2);
    echo "<td>".$ss."</td>";
	echo "<td>".$rowA['ph']."</td>";
	$zp=(($summ/3600)*$rowA['ph']);
	echo "<td>".round($zp,2)."</td>";`xray_uch`.
	$query = "SELECT `summ` FROM `xray_summ` WHERE `sotr`=".$rowA['id']." AND `fp`=".$fp;
	////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	if ($count>0)
	{
		$row = mysqli_fetch_array($result);
		$summ=$row['summ'];
	}
	else
	{
	
		$tables[0]=array ("dnev","`manip_pr`","`manip_pr`.`dnev`");
		$tables[1]=array ("zaknar","`manip_zn`","`manip_zn`.`ZN`");
		$tables[2]=array ("schet_orto","`manip_sh_orto`","`manip_sh_orto`.`SO`");
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query="SELECT 
				sum(".$tables['$j][1'].".`kolvo`*`manip`.`price` ) as summ
			FROM ".$tables['$j][1'].", manip, ".$tables['$j][0'].",xray_uch
			WHERE (
			(`".$tables['$j][0']."`.`date` >='".$dtN."') AND 
			(`".$tables['$j][0']."`.`date` <'".$dtO."') AND
			(".$tables['$j][2']." =`".$tables['$j][0']."`.`id`) AND 
			(`manip`.`id` IN (26,27,254,255)) AND 
			(".$tables['$j][1'].".`manip` =`manip`.`id`) AND
			(`xray_uch`.`type`=".$j.") AND
			(`xray_uch`.`sotr`=".$rowA['id']." ) AND
			(".$tables['$j][1'].".`id`=`xray_uch`.`manip_pr`)
			)
			GROUP BY `xray_uch`.`type`";
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$summ+=$row['summ'];
			//for ($i=0;$i<$count;$i++)
//			{
//				$c++;
//				$row = mysqli_fetch_array($result);
//				$dt=explode("-",$row['date']);
//				$manip['$c][date']=$dt[2].".".$dt[1].".".$dt[0];
//				//if (isset($xRayUcht['$j']['$row['5]'][sotr']))
////				{
////					$manip['$c][PatName']=$row[0]." ".$row[1]." ".$row[2];
////					$manip['$c][KolVo']=$row[3]." (".($row[3]*$row[4])."р.)";
////					$manip['$c][sotr']=$xRayUcht['$j']['$row['5]'][sotr'];
////					$manip['$c][vrach']="<div class='bottom'>(".$row[6]." ".$row[7]." ".$row[8].")</div>";
////					$manip['$c][act']="rentgen.php?action=chAssist&XrayID=".$xRayUcht['$row['5]'][id'].$type;
////				}
////				else
////				{
////					$manip['$c][PatName']=$row[0]." ".$row[1]." ".$row[2];
////					$manip['$c][KolVo']=$row[3]." (".($row[3]*$row[4])."р.)";
////					$manip['$c][sotr']=0;
////					$manip['$c][act']="rentgen.php?type1=".$j."&action=setAssist&ManipPr=".$row[5].$type;
////					$manip['$c][vrach']="<div class='bottom'>(".$row[6]." ".$row[7]." ".$row[8].")</div>";
////				}
//			}
	
		}
	}
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		sum(`oplata`.`vnes`) AS summ, 
		`opl_vid`.`vid`, 
		`oplata`.`date`
		FROM klinikpat, sotr, oplata, dnev, opl_vid
		WHERE (
		(`dnev`.`vrach`='".$rowA['id']."') AND
		(`oplata`.`date` >='".$dtN."') AND 
		(`oplata`.`date` <='".$dtO."') AND 
		(`oplata`.`dnev` =`dnev`.`id`) AND 
		(`sotr`.`id` =`dnev`.`vrach`) AND 
		(`klinikpat`.`id` =`dnev`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
		(`oplata`.`type`=1))
		GROUP BY `dnev`.`vrach`
		";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);	
		$row = mysqli_fetch_array($result);
		$summ=$row['summ'];
	echo "<td>".$summ*0.15."</td>";
	$zp+=$summ*0.15;
	$query = "SELECT `nadb`.`summ`
FROM nadb, nadb_sootv
WHERE ((`nadb_sootv`.`zc` =".$rowA['zc'].") AND (`nadb`.`id` =`nadb_sootv`.`nadb`))";
	////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
		$summ+=$row['summ'];
	}
	echo "<td>".$summ."</td>";
	$zp+=$summ;
	echo "<td>".round(($zp*0.13),2)."</td>";
	$zp-=($zp*0.13);
    echo "<td>".round($zp,2)."</td>";
    echo "<td>";
    echo " <a class='menu2' target='_blanc' href=\"print.php?type=zp_fishka&sotr=".$rowA['id']."&vid=2&fp=".$fp."\">Печать</a><br />";
 
    echo "</td>";
	echo "</tr>";
}
echo "</table>";

echo "<span class='head3'>Расчёт по ставке</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Сотрудник</td>
    <td class='menutext'>Ставка</td>
    <td class='menutext'>Подоходный</td>
	<td class='menutext'>Зарплата</td>
    <td class='menutext'>Действия</td>
  </tr>";
$query = "SELECT `sotr`.`id`, `sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` 
FROM sotr, zarp_card
WHERE (
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =2
)
)";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr>";
	echo "<td>".$row['surname']." ".$row['name']." ".$row['otch']."</td>";
	echo "<td>".$row['stavka']."</td>";
	echo "<td>".($row['stavka']*$row['pn'])."</td>";
	echo "<td>".($row['stavka']-($row['stavka']*$row['pn']))."</td>";
	echo "<td>";
	echo " <a class='menu2' target='_blanc' href=\"print.php?type=zp_fishka&sotr=".$row['id']."&vid=3&fp=".$fp."\">Печать</a><br />";
	echo "</td></tr>";
}
echo "</table><br />";
include("footer.php");
?>