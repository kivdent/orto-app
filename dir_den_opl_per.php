<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Финансовый отчёт за период"; 
include("header.php");
switch ($_GET['type'])
{
	case "vrach_otch":
	$query = "SELECT `id`,`nach` , `okonch` 
	FROM `fin-per` 
	ORDER BY `id` DESC" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
	echo "| <a class='menu2' href='dir_den_opl_per.php?fp=".$row['id']."&type=vrach_otch&vrach=".$_GET['vrach']."' >".$m[($dt['1']-1)]." ".$dt[0]."</a> |";
}
	echo "<div class='head1'>Отчёт за ".$m[($dtOp['1']-1)]."</div><br />";
//ФИО Выручка	
	$tables=array ("dnev","zaknar","schet_orto");
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
			FROM sotr, oplata, ".$tables[$j]."
			WHERE (
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables[$j]."`.`id`) AND 
			(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).") AND
			(`sotr`.`id` =".$_GET['vrach'].")
			)
			GROUP BY `".$tables[$j]."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['summ'])) $sotr['summ']+=$row['summ'];
				else  
				{
					$sotr['summ']=$row['summ'];
					$sotr['name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['dolzh']=$row['dolzh'];
				}
			}
		}
//Количество смен		
		$query = "SELECT `daypr`.`id`
FROM daypr, sotr
WHERE (	(`daypr`.`date` >='".$dtN."') AND 
			(`daypr`.`date` <='".$dtO."') AND  
			(`sotr`.`id` =".$_GET['vrach'].")
			)
			Group by `daypr`.`date`";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$sotr['otrab_smen']=$count;


//количество часов
$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."') AND 
(`sotr`=".$_GET['vrach'].")
)
ORDER BY `sotr` ASC, `date` ASC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$q=1;
$summ=0;
if ($count>0)
{
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$in=explode(":",$row['in']);
	$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
	$out=explode(":",$row['out']);
	$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
	
	if(($out2-$in2)>0) 
	{	
	$summ+=($out2-$in2);
	}
	else  $r[$row['id']][$dt2]['tm']=0;
}

}

$sotr['otrab_chasov']=(floor($summ/3600))." ч: ".((($summ)-floor($summ/3600)*3600)/60)." м";
$sotr['otrab_chasov']=$summ;
//Часов на приёме

$query = "SELECT `nazn`.`NachPr`,
						`nazn`.`OkonchPr`
				FROM dnev,nazn
				WHERE (
				(".$_GET['vrach']." =`dnev`.`vrach`) AND 
				(`dnev`.`date`>='".$dtN."') AND 
				(`dnev`.`date` <='".$dtO."') AND	
				(`nazn`.`id` =`dnev`.`Nid`))";
				//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
if ($count>0)
{
$summ=0;
for ($i=0;$i<$count;$i++)
{
	$rowA= mysqli_fetch_array($result);
	$tmN=explode(":",$rowA['NachPr']);
	$tmO=explode(":",$rowA['OkonchPr']);
	$summ+=mktime($tmO[0],$tmO[1],0,date('m'),date('d'),date('Y'))-mktime($tmN[0],$tmN[1],0,date('m'),date('d'),date('Y'));
		
}
$sotr['chasov_na_pr']=$summ;
}
else $sotr['chasov_na_pr']=0;

//Принято пациентов
$sotr['pr_pat']=0;
for ($j=0;$j<=2;$j++)
{
$query = "SELECT `".$tables[$j]."`.`id`
				FROM ".$tables[$j]."
				WHERE (
				(".$_GET['vrach']." =`".$tables[$j]."`.`vrach`) AND 
				(`".$tables[$j]."`.`date`>='".$dtN."') AND 
				(`".$tables[$j]."`.`date` <='".$dtO."')
				)";
				//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$sotr['pr_pat']+=$count;
}

//пролечено пациентов
$sotr['lech_pat']=0;
for ($j=0;$j<=2;$j++)
		{
$query = "SELECT `".$tables[$j]."`.`pat`
				FROM ".$tables[$j]."
				WHERE (
				(".$_GET['vrach']." =`".$tables[$j]."`.`vrach`) AND 
				(`".$tables[$j]."`.`date`>='".$dtN."') AND 
				(`".$tables[$j]."`.`date` <='".$dtO."')
				)
				GROUP BY `".$tables[$j]."`.`pat`";
				//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$sotr['lech_pat']+=$count;
}

//Первичных пациентов
//Отчёт по манип
$manip1=array("manip_pr","manip_zn","manip_sh_orto");
$manip2=array("`manip_pr`.`dnev`","`manip_zn`.`ZN`","`manip_sh_orto`.`SO`");
for ($j=0;$j<=2;$j++)
		{
	$query = "SELECT `manip`.`manip`,SUM(`".$manip1[$j]."`.`kolvo`), `manip`.`price`,(SUM(`$manip1[$j]`.`kolvo`)* `manip`.`price`) as total
	FROM ".$manip1[$j].", manip,".$tables[$j]."
	WHERE (
	(`manip`.`id` =`".$manip1[$j]."`.`manip`) AND 
	(".$manip2[$j]." =`".$tables[$j]."`.`id`)AND
	(`".$tables[$j]."`.`date`>='".$dtN."') AND 
	(`".$tables[$j]."`.`date` <='".$dtO."') AND
	(".$_GET['vrach']." =`".$tables[$j]."`.`vrach`)
)
GROUP BY `".$manip1[$j]."`.`manip`
ORDER BY total";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
}

echo "<font size=\"2\"></font><b>".$sotr['name']."</b><br><br>";

echo "
Отработано смен: ".$sotr['otrab_smen']."<br>
Отработано часов:".(floor($sotr['otrab_chasov']/3600))." ч: ".((($sotr['otrab_chasov'])-floor($sotr['otrab_chasov']/3600)*3600)/60)."м<br>";
if ($sotr['chasov_na_pr']!=0) echo "Часов на приёме:".(floor($sotr['chasov_na_pr']/3600))." ч: ".((($sotr['chasov_na_pr'])-floor($sotr['chasov_na_pr']/3600)*3600)/60)." м<br>";
echo "
Выручка за месяц: ".$sotr['summ']." руб<br>
Принято пациентов(по чекам):".$sotr['pr_pat']."<br>
Пролечено пациентов:".$sotr['lech_pat']."<br>";
//echo "Первичных:<br>";
echo "Средняя выручка в смену:".round(($sotr['summ']/$sotr['otrab_smen']),2)." руб<br>";
echo "Выручка в час по отработанным часам:".round(($sotr['summ']/($sotr['otrab_chasov']/3600)),2)." руб<br>";
if ($sotr['chasov_na_pr']!=0) echo "Выручка в час по часам на приёме:".round(($sotr['summ']/($sotr['chasov_na_pr']/3600)),2)." руб<br>";
echo "Средняя выручка за один приём:".round(($sotr['summ']/$sotr['pr_pat']),2)." руб<br>
";
if ($sotr['chasov_na_pr']!=0)echo "Средняя продолжительность приёма:".round(($sotr['chasov_na_pr']/60)/$sotr['pr_pat'])." мин<br>
";
$manip1=array("manip_pr","manip_zn","manip_sh_orto");
$manip2=array("`manip_pr`.`dnev`","`manip_zn`.`ZN`","`manip_sh_orto`.`SO`");
for ($j=0;$j<=2;$j++)
		{
	$query = "SELECT `manip`.`manip`,SUM(`".$manip1[$j]."`.`kolvo`), `manip`.`price`,(SUM(`$manip1[$j]`.`kolvo`)* `manip`.`price`) as total
	FROM ".$manip1[$j].", manip,".$tables[$j]."
	WHERE (
	(`manip`.`id` =`".$manip1[$j]."`.`manip`) AND 
	(".$manip2[$j]." =`".$tables[$j]."`.`id`)AND
	(`".$tables[$j]."`.`date`>='".$dtN."') AND 
	(`".$tables[$j]."`.`date` <='".$dtO."') AND
	(".$_GET['vrach']." =`".$tables[$j]."`.`vrach`)
)
GROUP BY `".$manip1[$j]."`.`manip`
ORDER BY total";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
}
echo "
Отчёт по манипуляциям
";
echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='40%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='20%'><div align='center' class='feature3'>Количество</div></td>
						<td width='20%'><div align='center' class='feature3'>Цена</div></td>
						<td width='20%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
					  $manip1=array("manip_pr","manip_zn","manip_sh_orto");
$manip2=array("`manip_pr`.`dnev`","`manip_zn`.`ZN`","`manip_sh_orto`.`SO`");
for ($j=0;$j<=2;$j++)
		{
	$query = "SELECT `manip`.`manip`,SUM(`".$manip1[$j]."`.`kolvo`) as kolvo, `manip`.`price`,(SUM(`$manip1[$j]`.`kolvo`)* `manip`.`price`) as total
	FROM ".$manip1[$j].", manip,".$tables[$j]."
	WHERE (
	(`manip`.`id` =`".$manip1[$j]."`.`manip`) AND 
	(".$manip2[$j]." =`".$tables[$j]."`.`id`)AND
	(`".$tables[$j]."`.`date`>='".$dtN."') AND 
	(`".$tables[$j]."`.`date` <='".$dtO."') AND
	(".$_GET['vrach']." =`".$tables[$j]."`.`vrach`)
)
GROUP BY `".$manip1[$j]."`.`manip`
ORDER BY total desc";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
	{
	$row= mysqli_fetch_array($result);
 echo "<tr>
						<td width='40%'><div align='left' class='feature'>".$row['manip']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['kolvo']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['price']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['total']."</div></td>
					  </tr>";
	}
}
$query = "SELECT COUNT(`schet_orto`.`summ_k_opl`) as kolvo, AVG(`schet_orto`.`summ_k_opl`) as price, SUM(`schet_orto`.`summ_k_opl`) as total
	FROM schet_orto
	WHERE (
	(`schet_orto`.`sh_id` !=0) AND
	(`schet_orto`.`date`>='".$dtN."') AND 
	(`schet_orto`.`date` <='".$dtO."') AND
	(".$_GET['vrach']." =`schet_orto`.`vrach`)
)";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
	{
	$row= mysqli_fetch_array($result);
 echo "<tr>
						<td width='40%'><div align='left' class='feature'>Опдата за ортодонитческое лечение</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['kolvo']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".round($row['price'],2)."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['total']."</div></td>
					  </tr>";
	}

echo "</table>";
	include("footer.php");
	exit;
	break;
}
$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
	echo "| <a class='menu2' href='dir_den_opl_per.php?fp=".$row['id']."' >".$m[($dt['1']-1)]." ".$dt[0]."</a> |";
}
	echo "<div class='head1'>Отчёт по клинике за ".$m[($dtOp['1']-1)]."</div><br />";
	$tables=array ("dnev","zaknar","schet_orto");
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
			FROM sotr, oplata, ".$tables[$j]."
			WHERE (
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables[$j]."`.`id`) AND 
			(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).")
			)
			GROUP BY `".$tables[$j]."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr[$row['id']]['summ'])) $sotr[$row['id']]['summ']+=$row['summ'];
				else  
				{
					$sotr[$row['id']]['summ']=$row['summ'];
					$sotr[$row['id']]['zc']=$row['zc_id'];
					$sotr[$row['id']]['stavka']=$row['stavka'];
					$sotr[$row['id']]['pc']=$row['pc_id'];
					$sotr[$row['id']]['name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr[$row['id']]['dolzh']=$row['dolzh'];
					$sotr_sp[$c]=$row['id'];
					$c++;
				}
			}
		}
		$tables=array ("dnev","zaknar","schet_orto");
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`,  
			SUM(`".$tables[$j]."`.`summ_vnes`) AS summ_vn,
			SUM(`".$tables[$j]."`.`summ_k_opl`) AS summ_k_opl,
			COUNT(`".$tables[$j]."`.`summ_vnes`) AS count,
			AVG(`".$tables[$j]."`.`summ_vnes`) AS avg
			FROM sotr, ".$tables[$j]."
			WHERE (
			(`".$tables[$j]."`.`date` >='".$dtN."') AND 
			(`".$tables[$j]."`.`date` <='".$dtO."') AND  
			(`sotr`.`id` =`".$tables[$j]."`.`vrach`)
			)
			GROUP BY `".$tables[$j]."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr[$row['id']]['summ_ch'])) 
				{
					$sotr[$row['id']]['summ_vn']+=$row['summ_vn'];
					$sotr[$row['id']]['summ_k_opl']+=$row['summ_k_opl'];
					$sotr[$row['id']]['count']+=$row['count'];
					$sotr[$row['id']]['avg']+=$row['count'];
					
				}
				else  
				{
					$sotr[$row['id']]['summ_vn']=$row['summ_vn'];
					$sotr[$row['id']]['summ_k_opl']=$row['summ_k_opl'];
					$sotr[$row['id']]['avg']=$row['count'];
					$sotr[$row['id']]['count']=$row['count'];
				}
			}

		}
		echo "<br /><span class='head3'>Выручка по врачам</span><br />
		<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Врач</td>
    <td class='menutext'>Выручка</td>
    <td class='menutext'>Чеки</td>
    <td class='menutext'>Долг</td> 
    <td class='menutext'>Пациентов</td>
    <td class='menutext'>Ср. с. пац.</td>
  </tr>";
$summ['opl']=0;  
for ($i=0;$i<$c;$i++)
{
	$summ['opl']+=$sotr[$sotr_sp[$i]]['summ'];
	echo "<tr>
    <td><a href=\"dir_den_opl_per.php?type=vrach_otch&vrach=".$sotr_sp[$i]."\">".$sotr[$sotr_sp[$i]]['name']."</a></td>
    <td>".$sotr[$sotr_sp[$i]]['summ']."</td>
     <td>".$sotr[$sotr_sp[$i]]['summ_k_opl']."</td>
    <td>".($sotr[$sotr_sp[$i]]['summ_k_opl']-$sotr[$sotr_sp[$i]]['summ_vn'])."</td> 
    <td>".$sotr[$sotr_sp[$i]]['count']."</td>
    <td>".($sotr[$sotr_sp[$i]]['summ_k_opl']/$sotr[$sotr_sp[$i]]['count'])."</td>
  </tr>";
}
echo "
<tr>
    <td>&nbsp;</td>
    <td><b>".$summ['opl']."</b></td>
  </tr>";
echo "</table><br />";
echo "
Отчёт по манипуляциям
";
echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='40%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='20%'><div align='center' class='feature3'>Количество</div></td>
						<td width='20%'><div align='center' class='feature3'>Цена</div></td>
						<td width='20%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
$manip1=array("manip_pr","manip_zn","manip_sh_orto");
$manip2=array("`manip_pr`.`dnev`","`manip_zn`.`ZN`","`manip_sh_orto`.`SO`");
for ($j=0;$j<=2;$j++)
		{
	$query = "SELECT `manip`.`manip`,SUM(`".$manip1[$j]."`.`kolvo`) as kolvo, `manip`.`price`,(SUM(`$manip1[$j]`.`kolvo`)* `manip`.`price`) as total
	FROM ".$manip1[$j].", manip,".$tables[$j]."
	WHERE (
	(`manip`.`id` =`".$manip1[$j]."`.`manip`) AND 
	(".$manip2[$j]." =`".$tables[$j]."`.`id`)AND
	(`".$tables[$j]."`.`date`>='".$dtN."') AND 
	(`".$tables[$j]."`.`date` <='".$dtO."')
)
GROUP BY `".$manip1[$j]."`.`manip`
ORDER BY total desc";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
	{
	$row= mysqli_fetch_array($result);
 echo "<tr>
						<td width='40%'><div align='left' class='feature'>".$row['manip']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['kolvo']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['price']."</div></td>
						<td width='20%'><div align='center' class='feature3'>".$row['total']."</div></td>
					  </tr>";
	}
}
echo "</table>";
include("footer.php");
?>