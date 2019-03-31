<?php
$ThisVU="all";
$this->title="Первичные по месяцам";
//include("header.php");
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
	echo "| <a class='menu2' href='kons.php?fp=".$row['id']."' >".$m[($dt['1]-1)']." ".$dt[0]."</a> |";
}
echo "<div class='head1'>Первичные за ".$m[($dtOp['1]-1)']."</div><br />";
$query = "SELECT `sotr`.`surname`,`sotr`.`name`,`sotr`.`otch`, count(`nazn`.`Id`) as kol FROM nazn, daypr,sotr WHERE ((`daypr`.`date` >='".$dtN."') AND (`daypr`.`date` <='".$dtO."') AND (`nazn`.`Perv` =1) AND (`nazn`.`dayPR` =`daypr`.`id`) and `daypr`.`vrachID`=`sotr`.`id`) GROUP BY `daypr`.`vrachID`
";
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<table width='50%' border='1' cellpadding='1' cellspacing='1' bordercolor='#999999'>
	  <tr>
		<td width='80%' class='feature3'>Врач</td>
		<td width='20%' class='feature3'>Первичные</td>
	  </tr>";
for ($i=0;$i<$count;$i++)
		{
		$row = mysqli_fetch_array($result);
		echo "<tr>
		<td width='80%' class='alltext'>".$row['surname']." ".$row['name']." ".$row['otch']."</td>
		<td width='20%' class='alltext'>".$row['kol']."</td>
	  </tr>";
	  }
	  echo "</table>";
//include("footer.php");
?>