<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Финансовый отчёт за период"; 
//include("header.php");
$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;


//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
	echo "| <a class='menu2' href='dir_den_opl_per_clin.php?fp=".$row['id']."' >".$m[($dt[1]-1)]." ".$dt[0]."</a> |";
}
	echo "<div class='head1'>Отчёт по клинике за ".$m[($dtOp[1]-1)]."</div><br />";
		$c=0;
			$query = "SELECT 
			SUM(`oplata`.`vnes`) AS summ,
			`oplata`.`VidOpl`
			FROM oplata
			WHERE (
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`podr`=1) 
			)
			GROUP BY `oplata`.`VidOpl`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				 switch ($row['VidOpl'])
				 {
					case "1":
						 $summ[1]['nal']=$row['summ'];
					break;
					case "2":
						$summ[1]['bn']=$row['summ'];
					break;
					case "3":
						$summ[1]['av']=$row['summ'];
					break;
					case "4":
						$summ[1]['proc']=$row['summ'];
					break;
					case "5":
						$summ[1]['bank_card']=$row['summ'];
					break;
				}				
			}
		echo "<span class='head3'>Орто-премьер</span><br />";
		echo "<span class='head2'>Наличные ".($summ[1]['nal']+$summ[1]['av'])."</span><br />";
		echo "<span class='head2'>Договора ".$summ[1]['bn']."</span><br />";
		echo "<span class='head2'>10% Карты ".$summ[1]['proc']."</span><br />";
		echo "<span class='head2'>Банковские карты ".$summ[1]['bank_card']."</span><br />";
		echo "<span class='head2'>Всего ".($summ[1]['nal']+$summ[1]['av']+$summ[1]['bn']+$summ[1]['bank_card'])."</span><br />";
	
			$c=0;
			$query = "SELECT 
			SUM(`oplata`.`vnes`) AS summ,
			`oplata`.`VidOpl`
			FROM oplata
			WHERE (
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`podr`=2) 
			)
			GROUP BY `oplata`.`VidOpl`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$summ[2]['nal']=0;
			$summ[2]['bn']=0;
			$summ[2]['av']=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				 switch ($row['VidOpl'])
				 {
					case "1":
						 $summ[2]['nal']=$row['summ'];
					break;
					case "2":
						$summ[2]['bn']=$row['summ'];
					break;
					case "3":
						$summ[2]['av']=$row['summ'];
					break;
					case "4":
						$summ[2]['proc']=$row['summ'];
					break;
					case "5":
						$summ[2]['bank_card']=$row['summ'];
					break;
					
				}				
			}
		echo "<span class='head3'>ИП Черненко</span><br />";
		echo "<span class='head2'>Наличные ".($summ[2]['nal']+$summ[2]['av'])."</span><br />";
		echo "<span class='head2'>Договора ".$summ[2]['bn']."</span><br />";
		echo "<span class='head2'>Всего ".($summ[2]['nal']+$summ[2]['av']+$summ[2]['bn'])."</span><br />";
		echo "<span class='head3'>Итоги</span><br />";
		echo "<span class='head2'>Наличные ".($summ[1]['nal']+$summ[1]['av']+$summ[2]['nal']+$summ[2]['av'])."</span><br />";
		echo "<span class='head2'>Договора ".($summ[1]['bn']+$summ[2]['bn'])."</span><br />";
		echo "<span class='head2'>Всего ".($summ[1]['nal']+$summ[1]['av']+$summ[1]['bn']+$summ[2]['nal']+$summ[2]['av']+$summ[2]['bn'])."</span><br />";		
//include("footer.php");
?>