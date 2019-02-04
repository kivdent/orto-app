<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Финансовый отчёт за день"; 
include("header.php");
echo "<span class='head2'>Оплата за лечение</span>";
	$query = "SELECT 
	`klinikpat`.`surname`, 
	`klinikpat`.`name`, 
	`klinikpat`.`otch`, 
	`sotr`.`surname`, 
	`sotr`.`name`, 
	`sotr`.`otch`, 
	`dnev`.`summ_k_opl`
	FROM klinikpat, sotr, dnev
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date` ='".date('Y-m-d')."') AND 
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
			<td class='menutext'>Сумма</td>
		  </tr>";
	if ($count>0)
	{
		  for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
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
	`zaknar`.`summ_k_opl`
	FROM klinikpat, sotr, zaknar
	WHERE (
	(`zaknar`.`vrach`='".$_SESSION['UserID']."') AND
	(`zaknar`.`date` ='".date('Y-m-d')."') AND 
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
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
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
	`schet_orto`.`summ_k_opl`
	FROM klinikpat, sotr, schet_orto
	WHERE (
	(`schet_orto`.`vrach`='".$_SESSION['UserID']."') AND
	(`schet_orto`.`date` ='".date('Y-m-d')."') AND 
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
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
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