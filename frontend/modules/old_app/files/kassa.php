<?php

include('mysql_fuction.php');
$ThisVU="registrator";
$this->title="Касса"; 
//include("header.php");
switch ($_GET['action'])
{
	case "nach":
		switch ($_GET['step'])
		{
			case "1":
				$query = "SELECT * FROM `kassa` WHERE `timeO`='00:00'";
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				if ($count>0)
				{
					msg("Закончите предыдущую смену");
					ret("kassa.php?action=okonch&step=1");
					exit;
				}
				$query = "SELECT `id`, `summ` FROM `kassa` ORDER BY `date` desc,`timeO` desc";
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				echo "<form action='kassa.php' method='get' >
						<input name='action' type='hidden' value='nach' />
						<input name='step' type='hidden' value='2' />
						<input name='summ' type='hidden' value='".$row['summ']."' />
							<div class='head1'>Начало кассовой смены</div>
							<div class='head2'>
							Дата:".date('d.m.Y')."<br />
							Время:".date('G:i')."<br />
							Остаток:".$row['summ']."<br />
							Администратор:".$_SESSION['UserName']."<br />
							<input name='ok' type='submit' id='ok' value='Начать' />
							<input name='cancel' type='button' value='Отмена' onclick='location.href=\"registrator.php\"'/>
						  </div>
						</form>";
			break;
			case "2":
				$query = "INSERT INTO `kassa` (`id`, `sotr`, `date`, `timeN`, `timeO`,`summ`)
VALUES (NULL,'".$_SESSION["UserID"]."','".date('Y-m-d')."','".date('H:i')."','00:00:00','".$_GET['summ']."')";
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				ret('/cash/payment/today');
			break;
		}
	break;
	case "okonch":
	switch ($_GET['step'])
	{
		case "1":
		
		$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`timeO`='00:00:00')";
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$_SESSION['kassa']=$row['id'];
				$summ=$row['summ'];
				
				$query = "SELECT `summ` FROM `kassa` WHERE `id`=".($_SESSION['kassa']-1);
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$ost=$row['summ'];
		$summ+=$ost;
		$query = "SELECT `podr`,SUM(`summ`) as summ FROM `sn_kass` 
		WHERE `smena`=".$_SESSION['kassa']."
		GROUP BY `podr`" ;
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$sn_kass[1]=0;
		$sn_kass[2]=0;
		for ($i=0;$i<$count;$i++)
		{
		   $row = mysqli_fetch_array($result);
		   $sn_kass[$row['podr']]+=$row['summ'];
		}
		echo "<form action='kassa.php' method='get' >
			<div class='head1'>Окончание смены</div>
			<input name='action' type='hidden' value='okonch' />
			<input name='step' type='hidden' value='2' />
			<input name='summ' type='hidden' value='".$summ."' />
			<input name='id' type='hidden' value='".$_SESSION['kassa']."' />
			<div class='head2'>Дата:".date('d.m.Y')."<br />
			Время:".date('G:i')."<br />
			Администратор:".$_SESSION['UserName']."<br /></div>"; 		
		$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);	
		$tables=array ("dnev","zaknar","schet_orto");
		$resultA=$result;
		$countA=$count;
		for ($h=0;$h<$countA;$h++)
		{
		$rowA = mysqli_fetch_array($resultA);
		$sum['nal'][$rowA['id']]=0;
		$nazv[$rowA['id']]=$rowA['nazv'];
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
			`opl_vid`.`vid`,
			`oplata`.`podr`,
			`oplata`.`date`,
			`".$tables[$j]."`.`date`,
			(`".$tables[$j]."`.`summ_k_opl`-`".$tables[$j]."`.`summ_vnes`) as dolg,
			(`klinikpat`.`otch`) AS patID, 
			(`sotr`.`surname`) AS sotrID,
			`oplata`.`VidOpl`,
			`".$tables[$j]."`.`id`
			FROM klinikpat, sotr, oplata, ".$tables[$j].", opl_vid
			WHERE (
			(`oplata`.`date` ='".date('Y-m-d')."') AND 
			(`oplata`.`dnev` =`".$tables[$j]."`.`id`) AND 
			(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
			(`klinikpat`.`id` =`".$tables[$j]."`.`pat`) AND
			(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
			(`oplata`.`VidOpl`=1) AND
			(`oplata`.`podr`=".$rowA['id'].")
			 AND
			(`oplata`.`type`=".($j+1).")
			)
			ORDER BY `".$tables[$j]."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		
			if ($count>0)
			{
				  for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						if ($row['14']==1)
						{ 
							$sum['nal'][$rowA['id']]+=$row[6];
						}
					}
					
			}
		}
		$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `pr_avans`.`summ`
FROM klinikpat, pr_avans
WHERE (
(`pr_avans`.`date` ='".date('Y-m-d')."') AND  
(`klinikpat`.`id` =`pr_avans`.`pat`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$summ2['pr_av']=0;
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$summ2['pr_av']+=$row[3];
		}
		$max_summ=$sum['nal'][$rowA['id']]-$sn_kass[$rowA['id']];
		if ($rowA['id']==1) $max_summ+=$ost+$summ2['pr_av'];
		echo "<br /><div class='head2'>Выручка к сдаче: ".$rowA['nazv'];
		echo "<br />Максимальная сумма:".$max_summ."<br />	
						Сумма:
						<input type='text' name='sn[".$rowA['id']."]' />
						руб.
						<br /></div>";
						
		}
		echo "<input name='ok' type='submit' id='ok' value='ОК' />
						<input name='cancel' type='button' value='Отмена' onclick='location.href=\"pr_opl.php\"'/>
					  
					</form>";
		break;
		case "2":
			$sn=$_GET['sn'];
			if (($sn[1]+$sn[2])>$_GET['summ'])
			{
				msg("Нельзя снять больше ".$_GET['summ']." руб.");
				ret("kassa.php?action=okonch&step=1");
				exit;
			}

			$query = "UPDATE `kassa` 
						SET`timeO`='".date('H:i')."',
							summ=summ-".($sn[1]+$sn[2])."
						WHERE `id`=".$_GET['id'];
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$query = "INSERT INTO `sn_kass` (`id`, `smena`, `znak`, `summ`, `oper`,`podr`)
VALUES (NULL,'".$_GET['id']."','-1','".$sn[1]."',0,1)";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$query = "INSERT INTO `sn_kass` (`id`, `smena`, `znak`, `summ`, `oper`,`podr`)
VALUES (NULL,'".$_GET['id']."','-1','".$sn[2]."',0,2)";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			ret('/reports/financial/daily');
			//include("footer.php");
			exit;
		break;
	}
	break;
}
//include("footer.php");
?>