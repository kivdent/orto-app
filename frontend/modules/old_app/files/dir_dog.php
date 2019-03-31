<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Финансовый отчёт за период"; 
//include("header.php");
$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;


//////echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
echo "| <a class='menu2' href='dir_dog.php?fp=0' >Полный отчёт</a> |";
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
	echo "| <a class='menu2' href='dir_dog.php?fp=".$row['id']."' >".$m[($dt[1]-1)]." ".$dt[0]."</a> |";
}
	if ($_GET['fp']==0) 
	{
		echo "<div class='head1'>Полный отчёт</div><br />";
		$fp=0;
	} 
	else echo "<div class='head1'>Отчёт по договорам за ".$m[($dtOp[1]-1)]."</div><br />";
	$query = "SELECT `id`,`nazv` FROM `firms`";
	//////echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	Echo "<form action=\"dir_dog.php\" method=\"get\" name='f1'>
			<select name=\"firm\" OnChange='location.href=this.value'>";
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($i==0)
			{
				if (isset($_GET['firm']))
				{
					 $firm=$_GET['firm'];
					 $s="selected='selected'";
				}
				else $firm=$row['id'];	
				
			}
			echo "<option ".$s." value='dir_dog.php?firm=".$row['id']."&fp=".$fp."'>".$row['nazv']."</option>";
	}
	Echo "</select></form>";			echo "Фирма";
		
			echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Врач</td>
			  	<td class='menutext'>Пациент</td>
				<td class='menutext'>Сумма</td>
				<td class='menutext'>Дата</td>
				 </tr>";
	$tables=array ("dnev","zaknar","schet_orto");
	$s=0;
	$c=0;
		if($fp==0) $per="";
		else $per="(`oplata`.`date` >='".$dtN."') AND 
		(`oplata`.`date` <='".$dtO."') AND ";
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		 `firms`.`nazv`,
		`oplata`.`date`
		FROM klinikpat, sotr, oplata, ".$tables[$j].",firms ,dogovor
		WHERE ( ".$per."
		(`oplata`.`dnev` =`".$tables[$j]."`.`id`) AND 
		(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j]."`.`pat`) AND
		(`oplata`.`VidOpl`=2) AND
		(`oplata`.`type`=".($j+1).")AND
		(`dogovor`.`pat`=`klinikpat`.`id`) AND 
		(`dogovor`.`firm`=`firms`.`id`) AND 
		(".$firm."=`firms`.`id`)
		)
		ORDER BY `oplata`.`date`";
			
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			

			$c+=$count;
		$summ=0;
		if ($count>0)
		{
			  for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$dt=explode("-",$row[8]);
					echo "
					  <tr class='alltext'>
					  <td>".$row[3]." ".$row[4]." ".$row[5]."</td>
						<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
						<td>".$row[6]." руб.</td>
						<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
					  </tr>";
					 $s+=$row[6];
				}
				
		}
		}
		echo "</table><br />";
echo "Итого: ".$s;
//include("footer.php");
?>