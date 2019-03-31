<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Скидки"; 
//include("header.php");
///$query = "SELECT `id`,`nach` , `okonch` 
//FROM `fin-per` 
//ORDER BY `id` DESC" ;
//echo $query."<br>";
//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
//for ($i=0; $i<$count; $i++)
//{
//	$row = mysqli_fetch_array($result);
//	if (!(isset($_GET['fp'])) and ($i==0))
//	{
//		$dtNp=explode("-",$row['nach']);
//		$dtOp=explode("-",$row['okonch']);
//		$dtN=$row['nach'];
//		$dtO=$row['okonch'];
//		$fp=$row['id'];
//	}
//	else
//	{
//		if ($_GET['fp']==$row['id'])
//		{
//			$dtNp=explode("-",$row['nach']);
//			$dtOp=explode("-",$row['okonch']);
//			$dtN=$row['nach'];
//			$dtO=$row['okonch'];
//			$fp=$row['id'];
//		}
//	}
//	$dt=explode("-",$row['okonch']);
//	echo "| <a class='menu2' href='dir_den_opl_per.php?fp=".$row['id']."' >".$m[($dt['1]-1)']." ".$dt[0]."</a> |";
//}
	switch ($_GET['act'])
	{
	case "new":
	echo "<div class='head1'>Скидки</div><br />";
	$query = "SELECT `disc_cards`.`pat`, `disc_cards_types`.`proc`, `disc_cards_types`.`summ` 
FROM disc_cards, disc_cards_types
WHERE `disc_cards`.`type` =`disc_cards_types`.`id` ";
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		$disc[$row['pat']]['summ']=$row['summ'];
		$disc[$row['pat']]['proc']=$row['proc'];
	}
			$query = "SELECT `id`, `proc`, `summ` FROM `disc_cards_types` order by summ";
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$dt_count=$count;
for ($i=0;$i<$dt_count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt[$i]['type']=$row['id'];
	$dt[$i]['summ']=$row['summ'];
	$dt[$i]['proc']=$row['proc'];
	$dt[$j]['count']=0;
}
	$tables=array ("dnev","zaknar","schet_orto");
		$c=0;
		for ($t=0;$t<=2;$t++)
		{
			$query = "SELECT 
			`klinikpat`.`id`, 
			`klinikpat`.`surname`, 
			`klinikpat`.`name`, 
			`klinikpat`.`otch`,  
			SUM(`".$tables[$j]."`.`summ_vnes`) AS `summ`,
			`skidka`.`proc`
			FROM klinikpat, ".$tables[$t].",skidka
			WHERE ((`klinikpat`.`id` =`".$tables[$t]."`.`pat`) and
			(`skidka`.`id`=`klinikpat`.`skidka`))
			GROUP BY `klinikpat`.`id`
			ORDER BY `summ`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$countc[5]=0;
			$countc['10']=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr[$row['id']]['summ'])) $sotr[$row['id']]['summ']+=$row['summ'];
				else  
				{	
					
							$sotr[$row['id']]['summ']=$row['summ'];
							if (!(isset($disc[$row['id']]['proc'])))
							$sotr[$row['id']]['sk_card']=$disc[$row['id']]['proc'];
							else $sotr[$row['id']]['sk_card']=0;
							$sotr[$row['id']]['sk_int']=$row['proc'];
							$sotr[$row['id']]['name']=$row['surname']." ".$row['name']." ".$row['otch'];
							$sotr_sp[$c]=$row['id'];
							$c++;
				}
			}
		}
	
	
	
	for ($i=0;$i<$c;$i++)
		{
			for ($j=0;$j<$dt_count;$j++)
					{
						if ($sotr[$sotr_sp[$i]]['summ']>=$dt[$j]['summ'])
						{
							if ((!(isset($disc[$sotr_sp[$i]]['summ']))) or ( 
									($sotr[$sotr_sp[$i]]['sk_card']<$dt[$j]['proc']) or
									($dt[$j]['proc']>$sotr[$sotr_sp[$i]]['sk_int'])))
							{
							$sotr[$sotr_sp[$i]]['sk_card']=$dt[$j]['proc'];
							if ($sotr[$sotr_sp[$i]]['sk_card']>=$sotr[$sotr_sp[$i]]['sk_int']) 
							{
								$sotr[$sotr_sp[$i]]['sk_tot']=$sotr[$sotr_sp[$i]]['sk_card'];
								$n=$j;
								$sotr[$sotr_sp[$i]]['sk_vid']="(сум)";
							}
							else 
							{
								$sotr[$sotr_sp[$i]]['sk_tot']=$sotr[$sotr_sp[$i]]['sk_int'];
								
								$sotr[$sotr_sp[$i]]['sk_vid']="(coц)";
							}
							}
						}
					}
					if ($sotr[$sotr_sp[$i]]['sk_vid']=="(coц)")  $countc[$sotr[$sotr_sp[$i]]['sk_tot']]++;
					if ($sotr[$sotr_sp[$i]]['sk_vid']=="(сум)") $dt[$n]['count']++;
			}
	
	
	
	
		echo "<br /><span class='head3'>Скидки по сумме</span><br />";
		for ($j=0;$j<$dt_count;$j++)
		{
		echo "Карт по сумме ".$dt[$j]['proc']."%: ".$dt[$j]['count']."<br>";
		$s+=$dt[$j]['count'];
		}
		echo "Карт социальных 5%: ".$countc[5]."<br>
				Карт социальных 10%: ".$countc['10']."<br>
				Карт всего: ".($s+$countc[5]+$countc['10'])."<br>";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Пациент</td>
    <td class='menutext'>Сумма</td>
    <td class='menutext'>Скидка по карте</td>
    <td class='menutext'>Скидка по сумме</td> 
    <td class='menutext'>Общая</td>
  </tr>"; 
		for ($i=0;$i<$c;$i++)
		{
			if ($sotr[$sotr_sp[$i]]['sk_tot']!=0)
			{
			echo " <tr>
    		<td class='menutext'>".$sotr[$sotr_sp[$i]]['name']."</td>
    		<td class='menutext'>".$sotr[$sotr_sp[$i]]['summ']."</td>";
    		echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['sk_int']."%</td> ";
    		echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['sk_card']."%</td>
    		<td class='menutext'>".$sotr[$sotr_sp[$i]]['sk_tot']."% ".$sotr[$sotr_sp[$i]]['sk_vid']."</td>
 		 </tr>";
 		 }
		}
echo "</table><br />";
//include("footer.php");
exit;
break;







case "make":
switch ($_GET['action'])
{
	case "new":
		switch ($_GET['step'])
		{
			case "1":
				if (!(isset($_GET['num'])))
				{
				$cards=array("3%","5%","10%");
				echo "<script language=\"JavaScript\" type=\"text/javascript\">";
			//echo "function num(id,qq)";
			echo "{";
				echo "q=prompt('Тип карты ".$cards[($_GET['type']-1)].". Введите №',0);
				url='discount.php?act=make&action=new&step=1&pat=".$_GET['pat']."&type=".$_GET['type']."&num='+q;
				location.href=url;";
			echo "}";
			
			//echo "ChQ('".$_GET['id']."','".$_SESSION['chek'][$_GET['id']]['2']."')";
			echo "</script>";
			exit;
			}
				$query = "SELECT `id` FROM `disc_cards` WHERE `pat`=".$_GET['pat'];
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				if ($count>0)
				{
					$query = "DELETE FROM `disc_cards` WHERE `pat`=".$_GET['pat'];
					//echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
				
				$query = "INSERT INTO `disc_cards`(`id`,`pat`, `type`,`num`,`date`) VALUES (NULL,".$_GET['pat'].", ".$_GET['type'].",".$_GET['num'].",'".date('Y-m-d')."')";
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);
				$query = "SELECT LAST_INSERT_ID()";
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);    
				$row = mysqli_fetch_array($result);
				$id=	$row[0];
				$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_GET['pat'];
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				echo "
				Выдана карта №  ".$_GET['num']."
				<br>Пациент ".$row[0]." ".$row[1]." ".$row[2];
				//include("footer.php");
				exit;
			break;
		}
	break;
}
		echo "<div class='head1'>Скидки</div><br />";
	$query = "SELECT `disc_cards`.`pat`, `disc_cards_types`.`proc`, `disc_cards_types`.`summ` 
FROM disc_cards, disc_cards_types
WHERE `disc_cards`.`type` =`disc_cards_types`.`id` ";
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		$disc[$row['pat']]['summ']=$row['summ'];
		$disc[$row['pat']]['proc']=$row['proc'];
	}
			$query = "SELECT `id`, `proc`, `summ` FROM `disc_cards_types` order by summ";
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$dt_count=$count;
for ($i=0;$i<$dt_count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt[$i]['type']=$row['id'];
	$dt[$i]['summ']=$row['summ'];
	$dt[$i]['proc']=$row['proc'];
	$dt[$j]['count']=0;
}
	$tables=array ("dnev","zaknar","schet_orto");
		$c=0;
		for ($t=0;$t<=2;$t++)
		{
			$query = "SELECT 
			`klinikpat`.`id`, 
			`klinikpat`.`surname`, 
			`klinikpat`.`name`, 
			`klinikpat`.`otch`,  
			SUM(`".$tables[$j]."`.`summ_vnes`) AS `summ`,
			`skidka`.`proc`
			FROM klinikpat, ".$tables[$t].",skidka
			WHERE ((`klinikpat`.`id` =`".$tables[$t]."`.`pat`) and
			(`skidka`.`id`=`klinikpat`.`skidka`))
			GROUP BY `klinikpat`.`id`
			ORDER BY `summ`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$countc[5]=0;
			$countc['10']=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr[$row['id']]['summ'])) $sotr[$row['id']]['summ']+=$row['summ'];
				else  
				{	
							$sotr[$row['id']]['summ']=$row['summ'];
							if (isset($disc[$row['id']]['proc']))
							$sotr[$row['id']]['sk_card']=$disc[$row['id']]['proc'];
							else $sotr[$row['id']]['sk_card']=0;
							$sotr[$row['id']]['sk_int']=$row['proc'];
							$sotr[$row['id']]['name']=$row['surname']." ".$row['name']." ".$row['otch'];
							$sotr_sp[$c]=$row['id'];
							$c++;
				}
			}
		}
	
	
	
	for ($i=0;$i<$c;$i++)
		{
			for ($j=0;$j<$dt_count;$j++)
					{
						if ($sotr[$sotr_sp[$i]]['summ']>=$dt[$j]['summ'])
						{
							if ((!(isset($disc[$sotr_sp[$i]]['summ']))) or ( 
									($sotr[$sotr_sp[$i]]['sk_card']<$dt[$j]['proc']) or
									($dt[$j]['proc']>$sotr[$sotr_sp[$i]]['sk_int'])))
							{
								$sotr[$sotr_sp[$i]]['sk_card']=$dt[$j]['proc'];
								if ($sotr[$sotr_sp[$i]]['sk_card']>=$sotr[$sotr_sp[$i]]['sk_int']) 
								{
									$sotr[$sotr_sp[$i]]['sk_tot']=$sotr[$sotr_sp[$i]]['sk_card'];
									$n=$j;
									$sotr[$sotr_sp[$i]]['sk_vid']="(сум)";
								}
								else 
								{
									$sotr[$sotr_sp[$i]]['sk_tot']=$sotr[$sotr_sp[$i]]['sk_int'];
								
									$sotr[$sotr_sp[$i]]['sk_vid']="(coц)";
							}
							}
						}
					}
					if ($sotr[$sotr_sp[$i]]['sk_vid']=="(coц)")  $countc[$sotr[$sotr_sp[$i]]['sk_tot']]++;
					if ($sotr[$sotr_sp[$i]]['sk_vid']=="(сум)") 
					{
						$dt[$n]['count']++;
						$sotr[$sotr_sp[$i]]['type']=$n+1;
					}
			}
	
	
	
	
		echo "<br /><span class='head3'>Скидки по сумме</span><br />";
		//for ($j=0;$j<$dt_count;$j++)
		//{
		//echo "Карт по сумме ".$dt[$j]['proc']."%: ".$dt[$j]['count']."<br>";
		//$s+=$dt[$j]['count'];
		//}
		//echo "Карт социальных 5%: ".$countc[5]."<br>
	//			Карт социальных 10%: ".$countc['10']."<br>
	//			Карт всего: ".($s+$countc[5]+$countc['10'])."<br>";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Пациент</td>
   <!--<td class='menutext'>Сумма</td> 
     <td class='menutext'>Скидка по карте</td>
    <td class='menutext'>Скидка по сумме</td> --> 
    <td class='menutext'>Скидка</td>
    
  </tr>"; 
		for ($i=0;$i<$c;$i++)
		{
			if ($sotr[$sotr_sp[$i]]['sk_tot']!=0)
			{
			
			if ($sotr[$sotr_sp[$i]]['sk_vid']!="(coц)")
			{
			if ($sotr[$sotr_sp[$i]]['type']>$disc[$sotr_sp[$i]]['type'])
			{
				echo " <tr>";	
				echo "<td class='menutext'><a class='menu2' href='discount.php?act=make&action=new&step=1&pat=".$sotr_sp[$i]."&type=".$sotr[$sotr_sp[$i]]['type']."'>".$sotr[$sotr_sp[$i]]['name']."</a></td>
    		";
    			//echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['summ']."</td>";
    			//echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['sk_int']."%</td> ";
    			//echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['sk_card']."%</td>";
    			echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['sk_tot']."%</td>
 		 </tr>";
 		 }
 		 }
 		 }
		}
echo "</table><br />";
	//include("footer.php");
	exit;
break;

case "view":
	$query = "SELECT `disc_cards`.`id`, `disc_cards`.`pat`, `disc_cards_types`.`proc`, `disc_cards_types`.`summ`,`klinikpat`.`surname`,`klinikpat`.`name`,`klinikpat`.`otch`,`disc_cards`.`num`
FROM disc_cards, disc_cards_types,`klinikpat`
WHERE ((`disc_cards`.`type` =`disc_cards_types`.`id`) AND
(`klinikpat`.`id`=`disc_cards`.`pat`))
ORDER BY `disc_cards`.`id`";
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr> 
    <td class='menutext'>Номер карты</td>
    <td class='menutext'>Пациент</td>
    <td class='menutext'>Скидка по карте</td>   
  </tr>"; 
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		//$row = mysqli_fetch_array($result);
		//$disc[$row['pat']]['summ']=$row['summ'];
		//$disc[$row['pat']]['proc']=$row['proc'];
		echo "<tr> 
    <td class='menutext'>№".$row['num']."</td>
    <td class='menutext'><a href='pat_card.php?id=".$row['pat']."&ro=1' class='small' target='_blank'>".$row['surname']." ".$row['name']." ".$row['otch']."</a>
</td>
    <td class='menutext'>".$row['proc']."%</td>   
  </tr>"; 
	}
	echo "</table><br />";
	//include("footer.php");
	exit;
break;
case "types":
	
	//include("footer.php");
	exit;
break;
}
?>