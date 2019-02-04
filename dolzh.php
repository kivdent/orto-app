<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Финансовый отчёт за день (оплаты)"; 
include("header.php");
$qsm=1;

echo "<form action='dir_den.php' method='get' >
			<span class='head2'>Оплата за лечение :</span>";
	////
	$c=0;
	$tables=array ("dnev","zaknar","schet_orto");
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Пациент</td>
				<td class='menutext'>Сумма</td>
				<td  align='center' class='menutext'>Дата</td>
			  </tr>";
	for ($j=0;$j<=2;$j++)
	{
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`,
		(`".$tables[$j]."`.`summ_k_opl` -`".$tables[$j]."`.`summ_vnes` ) as dolg,
		 `".$tables[$j]."`.`date` 
		FROM klinikpat, sotr, ".$tables[$j]."
		WHERE (
		(`".$tables[$j]."`.`vrach`='".$_SESSION['UserID']."') AND
		(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j]."`.`pat`) AND
		(`".$tables[$j]."`.`summ_k_opl` >`".$tables[$j]."`.`summ_vnes`))
		order by  `".$tables[$j]."`.`date` ";
		//////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$c+=$count;
		$summ[$j]=0;
		if ($count>0)
		{
			  for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$dt=explode("-",$row[7]);
					echo "
					  <tr class='alltext'>
						<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
						<td>".$row[6]." руб.</td>
						<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
					  </tr>";
					 $summ[$j]+=$row[6];
				}
		}
	}
	echo "</table>";
	echo "<p><span class='head3'>Итого долгов ".$c."</span><br />
				<span class='head2'>Сумма долгов: ".($summ[0]+$summ[1]+$summ[2])."</span><br />";

include("footer.php");
?>