<?php
$ThisVU="all";
$this->title="Финансовый отчёт за день по чекам"; 
//include("header.php");

$qsm=1;

echo "<form action='dir_den.php' method='get' >
			<span class='head2'>Оплата за лечение наличными:</span>";
	////
	$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, 
	`oplata`.`vnes`
	FROM klinikpat, sotr, oplata, dnev
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =1)
	)
	ORDER BY `sotr`.`surname`";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
		echo "
				<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
		  <tr>
			<td  align='center' class='menutext'>Пациент</td>
			<td> <span class='menutext'>Врач</span></td>
			<td class='menutext'>Сумма</td>
		  </tr>";
		  for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				echo "
				  <tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
					<td>".$row[3]." ".$row[4]." ".$row[5]."</td>
					<td>".$row[6]."</td>
				  </tr>";
				 $summ['$qsm][1']+=$row[6];
			}
			echo "</table>
			<div class='menutext2'>Итого: ".$summ['$qsm][1']."</div>";
	}
	else
	{
		echo "<span class='head2'>Нет</span><br>";
	}
	echo "<span class='head2'>Оплата долгов:</span>";					
	$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, 
	`oplata`.`vnes`,`dnev`.`date`
	FROM klinikpat, sotr, oplata, dnev
	WHERE ((`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date`!='".date('Y-m-d')."') AND
	(`oplata`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`))
	ORDER BY `sotr`.`surname`";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
							  <tr>
								<td><center>
								  <span class='menutext' >Пациент</span>
								</center></td>
								<td><center class='menutext'>Дата</center></td>
								<td><center class='menutext'>Врач</center></td>
								<td><center class='menutext'>Сумма</center></td>
								  </tr>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$dt=explode("-",$row[7]);
			echo "<tr class='alltext'>
								<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
								<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
								<td>".$row[3]." ".$row[4]." ".$row[5]."</td>
								<td>".$row[6]."</td>
							  </tr>";
			 $summ['$qsm][2']+=$row[6];
					
		}
		echo "</table>
					<div class='menutext2'>Итого: ".$summ['$qsm][2']."</div>";
	}
	else
	{
		echo "<span class='head2'>Нет</span><br>";
	}
	
	echo "<span class='head2'>Долгов сегодня:</span>";
	$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,
	`dnev`.`summ_k_opl`,`dnev`.`summ_vnes`,`nazn`.`NachNaz`
	FROM klinikpat, sotr, dnev, daypr, nazn
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date`='".date('Y-m-d')."') AND
	(`dnev`.`summ_k_opl`!=`dnev`.`summ_vnes`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`nazn`.`PatID` =`dnev`.`pat`) AND 
	(`daypr`.`date` =`dnev`.`date`) AND 
	(`nazn`.`dayPR` =`daypr`.`id`)
	)
	ORDER BY `sotr`.`surname`";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
							  <tr>
								<td><center>
								  <span class='menutext' >Пациент</span>
								</center></td>
								<td><center class='menutext'>Врач</center></td>
								<td><center class='menutext'>Долг</center></td>
								  </tr>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<tr class='alltext'>
								<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
								<td>".$row[3]." ".$row[4]." ".$row[5]."</td>
								<td>".($row[6]-$row[7])."</td>
							  </tr>";
			 $summ['$qsm][3']+=($row[6]-$row[7]);
		}
		echo "</table>
					<div class='menutext2'>Итого: ".$summ['$qsm][3']."</div>";
	}
	else
	{
		echo "<span class='head2'>Нет</span><br>";
	}
	
	echo "<span class='head2'>Оплаты из авансов:</span>";
	$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, 
	`oplata`.`vnes` 
	FROM klinikpat, sotr, oplata, dnev
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =3))
	ORDER BY `sotr`.`surname`";	
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{	
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
				<td><center class='menutext'>Пациент</center></td>
				<td><center class='menutext'>Врач</center></td>
				<td><center class='menutext'>Сумма</center></td>
			  </tr>";
		
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<tr class='alltext'>
					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
					<td>".$row[3]." ".$row[4]." ".$row[5]."</td>
					<td>".$row[6]."</td>
				  </tr>";
				 $summ['$qsm][5']+=$row[6];
         }
		echo "</table><div class='menutext2'>Итого: ".$summ['$qsm][5']."</div>";
	}
	else
	{
		echo "<span class='head2'>Нет</span><br>";
	}
	
	echo "<span class='head2'>Оплаты по договорам:</span>";
$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, 
	`oplata`.`vnes`,`opl_firm`.`firm` 
	FROM klinikpat, sotr, oplata, dnev,opl_firm
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =3) AND
	(`opl_firm`.`opl` =`oplata`.`id`)
	)
	ORDER BY `sotr`.`surname`";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{	
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
	  <tr>
		<td><center class='menutext'>Пациент</center></td>
		<td><center class='menutext'>Договор</center></td>
		<td><center class='menutext'>Врач</center></td>
		<td><center class='menutext'>Сумма</center></td>
	  </tr>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			  echo "<tr class='alltext'>
				<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
				<td>".$row[7]."</td>
				<td>".$row[3]." ".$row[4]." ".$row[5]."</td>
				<td>".$row[6]."</td>
			</tr>";
				 $summ['$qsm][6']+=$row[6];
		}
	echo "</table><div class='menutext2'>Итого: ".$summ['$qsm][6']."</div>";
	}
	else
	{
		echo "<span class='head2'>Нет</span><br>";
	}

			echo "<hr width='100%' noshade='noshade' size='1'/>";
			$snl=0;
			$opld=0;
			$dolgs=0;
			$prav=0;
			$soav=0;
			$opldog=0;
			$idk=0;
			$sn=0;
			$sbn=0;
			for ($i=1;$i<=$qsm;$i++)
			{
					$snl+=$summ['$i][1'];
					$opld+=$summ['$i][2'];
					$dolgs+=$summ['$i][3'];
					$prav+=$summ['$i][4'];
					$soav+=$summ['$i][5'];
					$opldog+=$summ['$i][6'];
					$idk+=$summ['$i][7'];
					$sn+=$summ['$i][1']+$summ['$i][2'];
					$sbn+=$summ['$i][4']+$summ['$i][5'];
					
			}
			$query = "SELECT * FROM `dnev` WHERE ((`dnev`.`vrach`='".$_SESSION['UserID']."') AND `date`='".date('Y-m-d')."')";
			//////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			echo "<p><span class='head3'>Принято пациентов: ".$count."</span><br />
				<span class='head2'>Принято наличными за лечение: ".$snl."</span><br />
				<span class='head2'>Оплаты из аванса: ".$prav."</span><br />
				<span class='head2'>Оплаты по договорам: ".$opldog."</span><br />
				<span class='head2'>Принято оплат за долг: ".$opld."</span><br />
				<span class='head2'Долгов сегодня: ".$dolgs."</span><br />
				<span class='head2'>Всего наличными: ".$sn."</span><br />
				<span class='head2'>Всего по безналу: ".$sbn."</span><br />
				<span class='head2'>Всего за день: ".($sn+$sbn)."</span><br /><br />

			</form>";

//include("footer.php");
?>