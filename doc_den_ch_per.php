<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Финансовый отчёт за период по чекам"; 
include("header.php");
$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN=$row['nach'];
$dtO=$row['okonch'];
echo "<div class=\"head1\">Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</div>";
echo "<span class='head2'>Оплата за лечение</span>";
	$query = "SELECT 
	`klinikpat`.`surname`, 
	`klinikpat`.`name`, 
	`klinikpat`.`otch`, 
	`sotr`.`surname`, 
	`sotr`.`name`, 
	`sotr`.`otch`, 
	`dnev`.`summ_k_opl`,
	`dnev`.`date`,
	`dnev`.`id`
	FROM klinikpat, sotr, dnev
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date` >='".$dtN."') AND 
	(`dnev`.`date` <='".$dtO."') AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`)
	)";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ['ter']=0;
	$c=$count;
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
		  <tr>
			<td  align='center' class='menutext'>Пациент</td>
			<td> <span class='menutext'>Дата</span></td>
			<td class='menutext'>Сумма</td>
		  </tr>";
	if ($count>0)
	{
		  for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$dt=explode("-",$row[7]);
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
					<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
					<td>".$row[6]."</td>
				  </tr>";
				 $summ['ter']+=$row[6];
			}
	
	}
	////zaknar
	$query = "SELECT 
	`klinikpat`.`surname`, 
	`klinikpat`.`name`, 
	`klinikpat`.`otch`, 
	`sotr`.`surname`, 
	`sotr`.`name`, 
	`sotr`.`otch`, 
	`zaknar`.`summ_k_opl`,
	`zaknar`.`date`
	FROM klinikpat, sotr, zaknar
	WHERE (
	(`zaknar`.`vrach`='".$_SESSION['UserID']."') AND
	(`zaknar`.`date` >='".$dtN."') AND 
	(`zaknar`.`date` <='".$dtO."') AND 
	(`sotr`.`id` =`zaknar`.`vrach`) AND 
	(`klinikpat`.`id` =`zaknar`.`pat`)
	)";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ['zaknar']=0;
	$c+=$count;
	if ($count>0)
	{
		  for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$dt=explode("-",$row[7]);
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
					<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
					<td>".$row[6]."</td>
				  </tr>";
				 $summ['zaknar']+=$row[6];
			}
	
	}	
	////schet_orto
	$query = "SELECT 
	`klinikpat`.`surname`, 
	`klinikpat`.`name`, 
	`klinikpat`.`otch`, 
	`sotr`.`surname`, 
	`sotr`.`name`, 
	`sotr`.`otch`, 
	`schet_orto`.`summ_k_opl`,
	`schet_orto`.`date`
	FROM klinikpat, sotr, schet_orto
	WHERE (
	(`schet_orto`.`vrach`='".$_SESSION['UserID']."') AND
	(`schet_orto`.`date` >='".$dtN."') AND 
	(`schet_orto`.`date` <='".$dtO."') AND 
	(`sotr`.`id` =`schet_orto`.`vrach`) AND 
	(`klinikpat`.`id` =`schet_orto`.`pat`)
	)";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ['schet_orto']=0;
	$c+=$count;
	if ($count>0)
	{
		  for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$dt=explode("-",$row[7]);
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
					<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
					<td>".$row[6]."</td>
				  </tr>";
				 $summ['schet_orto']+=$row[6];
			}
	
	}
	$summ= $summ['schet_orto']+$summ['zaknar']+$summ['ter'];	
	echo "</table>";
	echo "<span class='head3'>Выписано чеков: ".$c."</span><br />";
	echo "<span class='head3'>Сумма: ".$summ."</span>";
include("footer.php");
?>