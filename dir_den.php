<?php
$ThisVU="director";
$ModName="Финансовый отчёт за день"; 
include("header.php");
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";
//////////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>0)
{
echo "<span class='feature4'>ВНИМАНИЕ. Кассовая смена не закрыта.</span><br>";
}
echo "<form action='dir_den.php' method='get' >
		<center><span class='head1' >Финансовый отчёт за ".date('d.m.Y')."</span></center>
		<hr width='100%' noshade='noshade' size='1'/>";
$query = "SELECT `summ` 
FROM `kassa` 
WHERE `date` != '".date('Y-m-d')."'
ORDER BY `date` DESC , `timeN` DESC 
";
////////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$ond=$row['summ'];

$query = "SELECT `kassa`.`timeN`, `kassa`.`timeO`, `kassa`.`summ`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`kassa`.`id`
FROM kassa, sotr
WHERE ((`kassa`.`date` ='".date('Y-m-d')."') AND 
(`sotr`.`id` =`kassa`.`sotr` )) 
ORDER BY `kassa`.`timeN` DESC";
////////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
$qsm=0;
for ($i=0;$i<$countA;$i++)
{
	if ($i==0) $okn=$rowA['summ'];
	$qsm++;
	$rowA = mysqli_fetch_array($resultA);
	$tn=$rowA['timeN'];
	if ($rowA['timeO']=='00:00:00') $to=date('H:i:s');
	else $to=$rowA['timeO'];
	echo "<span class='head3'>
		Смена с ".$rowA['timeN']." по ".$rowA['timeO'].". Администратор: ".$rowA['surname']." ".$rowA['name']." ".$rowA['otch'].". </span><br />
			<span class='head2'>Оплата за лечение наличными, Орто-премьер:</span>";
	////
	$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, 
	`oplata`.`vnes`
	FROM klinikpat, sotr, oplata, dnev
	WHERE ((`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =1) AND
	(`oplata`.`time` >'".$tn."') AND
	(`oplata`.`time` <'".$to."') AND
	(`oplata`.`podr` =1)
	)
	ORDER BY `sotr`.`surname`";
	////////////echo $query."<br />";
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
	echo "<span class='head2'>Оплата за лечение наличными, ЧП Черненко:</span>";
	////
	
	$query = "SELECT 
	`klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, 
	`sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, 
	`oplata`.`vnes`
	FROM klinikpat, sotr, oplata, dnev
	WHERE ((`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =1) AND
	(`oplata`.`time` >'".$tn."') AND
	(`oplata`.`time` <'".$to."') AND
	(`oplata`.`podr` =2)
	)
	ORDER BY `sotr`.`surname`";
	////////////echo $query."<br />";
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
				 $summ['$qsm][8']+=$row[6];
			}
			echo "</table>
			<div class='menutext2'>Итого: ".$summ['$qsm][8']."</div>";
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
	WHERE ((`dnev`.`date`!='".date('Y-m-d')."') AND
	(`oplata`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`time` >'".$tn."') AND
	(`oplata`.`time` <'".$to."'))
	ORDER BY `sotr`.`surname`";
	//////////////echo $query."<br />";
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
	WHERE ((`dnev`.`date`='".date('Y-m-d')."') AND
	(`dnev`.`summ_k_opl`!=`dnev`.`summ_vnes`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`nazn`.`PatID` =`dnev`.`pat`) AND 
	(`daypr`.`date` =`dnev`.`date`) AND 
	(`nazn`.`dayPR` =`daypr`.`id`)
	)
	ORDER BY `sotr`.`surname`";
	////////////echo $query."<br />";
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
	echo "<span class='head2'>Приём авансов:</span>";
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `pr_avans`.`summ`
FROM klinikpat, pr_avans
WHERE (
(`pr_avans`.`time` >'".$tn."') AND 
(`pr_avans`.`time` <'".$to."') AND
(`pr_avans`.`date` ='".date('Y-m-d')."') AND  
(`klinikpat`.`id` =`pr_avans`.`pat`))";
	////////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
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
			$summ['$qsm][4']+=$row[3];
		}
		echo "</table><div class='menutext2'>Итого: ".$summ['$qsm][4']."</div>";
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
	WHERE ((`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =3) AND
	(`oplata`.`time` >'".$tn."') AND
	(`oplata`.`time` <'".$to."'))
	ORDER BY `sotr`.`surname`";	
	////////////echo $query."<br />";
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
	WHERE ((`dnev`.`date` ='".date('Y-m-d')."') AND 
	(`oplata`.`date` =`dnev`.`date`) AND 
	(`oplata`.`dnev` =`dnev`.`id`) AND 
	(`sotr`.`id` =`dnev`.`vrach`) AND 
	(`klinikpat`.`id` =`dnev`.`pat`) AND
	(`oplata`.`VidOpl` =3) AND
	(`oplata`.`time` >'".$tn."') AND
	(`opl_firm`.`opl` =`oplata`.`id`) AND
	(`oplata`.`time` <'".$to."')
	)
	ORDER BY `sotr`.`surname`";
	////////////echo $query."<br />";
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
	echo "<span class='head2'>Деньги из кассы:</span>";
	$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `oper_vid`.`naim`,`sn_kass`.`summ`
FROM sotr, oper_vid, sn_kass
WHERE ((`sn_kass`.`smena` = '".$rowA['id']."') 
AND (`oper_vid`.`id` =`sn_kass`.`oper`) 
AND (`sotr`.`id` =`sn_kass`.`otv`))";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{	
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
	  $summ['$qsm][7']+=$row[4];
	}
	echo "</table>";
	}
	else
	{
		echo "<span class='head2'>Нет</span><br>";
	}
			echo "<div class='menutext2'>Итого: ".$summ['$qsm][7']."</div>
			<br />
			<hr width='100%' noshade='noshade' size='1'/>";
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
					$sn+=$summ['$i][1']+$summ['$i][2']+$summ['$i][3'];
					$sbn+=$summ['$i][4']+$summ['$i][5'];
					
			}
			$query = "SELECT * FROM `dnev` WHERE `date`='".date('Y-m-d')."'";
			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			echo "<p><span class='head3'>Принято пациентов: ".$count."</span><br />
			<span class='head3'>Остаток на начало смены: ".$ond."</span><br />
				<span class='head2'>Принято наличными за лечение: ".$snl."</span><br />
				<span class='head2'>Сумма по оплатам из аванса: ".$prav."</span><br />
				<span class='head2'>Сумма по оплатам по договорам: ".$opldog."</span><br />
				<span class='head2'>Принято оплат за долг: ".$opld."</span><br />
				<span class='head2'Долгов сегодня: ".$dolgs."</span><br />
				<span class='head2'>Всего наличными: ".$sn."</span><br />
				<span class='head2'>Всего по безналу: ".$sbn."</span><br />
				<span class='head2'>Всего за день: ".($sn+$sbn)."</span><br /><br />
				<span class='head2'>Всего изъято денег из кассы: ".$idk."</span><br />";
				$query = "SELECT `summ` FROM `sn_kass` WHERE `smena`='".$rowA['id']."' and `oper`=0";
				//////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				echo "<span class='head3'>Снятие кассы : ".$row['summ']."</span><br />
				<span class='head3'>Остаток к концу смены: ".$rowA['summ']."</span><br />
			  </p>
			</form>";
}
include("footer.php");
?>