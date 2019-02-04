<?php
$ThisVU="all";
$ModName="Финансовый отчёт за период"; 
include("header.php");
$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;


//echo $query."<br>";
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
	echo "| <a class='menu2' href='dir_den_opl_per.php?fp=".$row['id']."' >".$m[($dt['1]-1)']." ".$dt[0]."</a> |";
}
	echo "<div class='head1'>Отчёт по клинике за ".$m[($dtOp['1]-1)']."</div><br />";
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
			FROM sotr, oplata, ".$tables['$j']."
			WHERE (
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
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
		$tables=array ("dnev","zaknar","schet_orto");
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`,  
			SUM(`".$tables['$j']."`.`summ_vnes`) AS summ_vn,
			SUM(`".$tables['$j']."`.`summ_k_opl`) AS summ_k_opl,
			COUNT(`".$tables['$j']."`.`summ_vnes`) AS count,
			AVG(`".$tables['$j']."`.`summ_vnes`) AS avg
			FROM sotr, ".$tables['$j']."
			WHERE (
			(`".$tables['$j']."`.`date` >='".$dtN."') AND 
			(`".$tables['$j']."`.`date` <='".$dtO."') AND  
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`)
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ_ch'])) 
				{
					$sotr['$row['id]'][summ_vn']+=$row['summ_vn'];
					$sotr['$row['id]'][summ_k_opl']+=$row['summ_k_opl'];
					$sotr['$row['id]'][count']+=$row['count'];
					$sotr['$row['id]'][avg']+=$row['count'];
					
				}
				else  
				{
				$sotr['$row['id]'][summ_vn']=$row['summ_vn'];
					$sotr['$row['id]'][summ_k_opl']=$row['summ_k_opl'];
					$sotr['$row['id]'][avg']=$row['count'];
					$sotr['$row['id]'][count']=$row['count'];
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
	$summ['opl']+=$sotr[$sotr_sp['$i]][summ'];
	echo "<tr>
    <td>".$sotr[$sotr_sp['$i]][name']."</td>
    <td>".$sotr[$sotr_sp['$i]][summ']."</td>
     <td>".$sotr[$sotr_sp['$i]][summ_k_opl']."</td>
    <td>".($sotr[$sotr_sp['$i]][summ_k_opl']-$sotr[$sotr_sp['$i]][summ_vn'])."</td> 
    <td>".$sotr[$sotr_sp['$i]][count']."</td>
    <td>".($sotr[$sotr_sp['$i]][summ_k_opl']/$sotr[$sotr_sp['$i]][count'])."</td>
  </tr>";
}
echo "
<tr>
    <td>&nbsp;</td>
    <td><b>".$summ['opl']."</b></td>
  </tr>";
echo "</table><br />";
include("footer.php");
?>