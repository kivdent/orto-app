<?php
session_start();
include('mysql_fuction.php');
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
	echo "| <a class='menu2' href='month_otch.php?fp=".$row['id']."' >".$m[($dt[1]-1)]." ".$dt[0]."</a> |";
}
	echo "<div class='head1'>Отчёт за ".$m[($dtOp[1]-1)]."</div><br />";
		$query = "SELECT
		`dnev`.`date`,
	count(`dnev`.`id`) as total
	FROM dnev
	WHERE (
	(`dnev`.`vrach`='".$_SESSION['UserID']."') AND
	(`dnev`.`date` >='".$dtN."') AND 
	(`dnev`.`date` <='".$dtO."') 
	)
	GROUP BY  `dnev`.`date`
	ORDER BY  `dnev`.`date`";
	echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$c=$count;
	$r=$result;
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
		  <tr>
			<td class='menutext'>Дата</td>
			<td class='menutext'>Всего</span></td>
		  </tr>";
	if ($count>0)
	{
		  for ($i=0;$i<$c;$i++)
			{
				$row = mysqli_fetch_array($r);
				$dt=explode("-",$row['date']);
				echo "
				<tr class='alltext'>
				<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
				<td>".$row['total']."</td>
				</tr>";
			}
	
	}
	echo "</table>";
include("footer.php");
?>