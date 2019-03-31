<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="День рождения";   
//include("header.php");
$query = "SELECT
					DATE_FORMAT(`klinikpat`.`dr`, '%d.%m.%Y' ) as date,
 			   	`klinikpat`.`surname`,
	 				`klinikpat`.`name`,
	 				`klinikpat`.`otch`,
	 				`klinikpat`.`id`,
	 				`klinikpat`.`MTel`,
	 				`klinikpat`.`DTel`,
	 				`klinikpat`.`RTel`,
	 				`klinikpat`.`adres`,
	 				`klinikpat`.`id`

FROM klinikpat
WHERE ((DATE_FORMAT(`klinikpat`.`dr`, '%m' )=".date('m')."))
ORDER BY `klinikpat`.`dr`
";

  echo "<table width='100%'  
  border='1' cellpadding='1' cellspacing='0 '
  bordercolor='#999999' bgcolor='#ffffff'>";
echo "<tr>";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					echo "<td width='25%' >Пациент&nbsp</td>";
					echo "<td >Дата&nbsp</td>";
					echo "<td>Моб.тел&nbsp</td>";
					echo "<td>Дом.тел&nbsp</td>";
					echo "<td>Раб.тел&nbsp</td>";
					echo "<td>Адрес</td>";
					echo "<td>Назначение последнее</td>";
					echo "<td>Сумма</td>";
					echo "</tr>";
$resultA=$result;
$countA=$count;
echo "Всего ".$count;
for ($z=0;$z<$countA;$z++)
{ 
					
					$row = mysqli_fetch_array($resultA);
					unset($c);
					unset($y);
					unset($dt);
					 $query = "SELECT
					DATE_FORMAT(`daypr`.`date`, '%d.%m.%Y' ) as date,
					DATE_FORMAT(`daypr`.`date`, '%Y' ) as year
FROM nazn, daypr, klinikpat
WHERE (
(`nazn`.`dayPR`=`daypr`.`id`) AND
(`nazn`.`PatID`=`klinikpat`.`id`) AND
(`klinikpat`.`id`=".$row['id'].")
)
ORDER BY `daypr`.`date` desc
LIMIT 0,1";
//echo $query."<br>";	
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$rowA = mysqli_fetch_array($result);
$dt=$rowA['date'];
$y=$rowA['year'];
 $query = "SELECT
DATE_FORMAT(`daypr`.`date`, '%d.%m.%Y' ) as date
FROM nazn, daypr, klinikpat
WHERE (
(`nazn`.`dayPR`=`daypr`.`id`) AND
(`nazn`.`PatID`=`klinikpat`.`id`) AND
(`klinikpat`.`id`=".$row['id'].")
)
ORDER BY `daypr`.`date` desc
LIMIT 0,1";
//echo $query."<br>";	
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$rowA = mysqli_fetch_array($result);					
$tables=array ("dnev","zaknar","schet_orto");
		$c=0;
		for ($t=0;$t<=2;$t++)
		{
			$query = "SELECT 
			SUM(`".$tables[$j]."`.`summ_vnes`) AS `summ`
			FROM klinikpat, ".$tables[$t]."
			WHERE ((`klinikpat`.`id` =`".$tables[$t]."`.`pat`) and
			(`klinikpat`.`id`=".$row['id']."))";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$rowA = mysqli_fetch_array($result);
			$c+=$rowA['summ'];	
		}
		if (($c>=2000) and ($y>=2007))
		{
					echo "<tr class='feature2'>";
					echo "<td width='25%'><span class='bottom'>Карта №".$row['id']."</span></br><a href='pat_card.php?id=".$row['id']."&ro=0' class='menu2' target='_blank'>".$row[1]." ".$row[2]." ".$row[3]."</a>&nbsp</td>";
					echo "<td>".$row['date']."&nbsp</td>";
					echo "<td>".$row['MTel']."&nbsp</td>";
					echo "<td>".$row['DTel']."&nbsp</td>";
					echo "<td>".$row['RTel']."&nbsp</td>";
					echo "<td>".$row['adres']."&nbsp</td>";
					echo "<td>".$dt."&nbsp</td>";
					echo "<td>".$c."&nbsp</td>";
					echo "</tr>";
		}

 }
echo "</table>";
//include("footer.php");
?>