<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Приём оплаты ортодонтия";
$js="ShowPat";
include("header.php");
if ($_GET['type']=="vrach")
{
				echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			   echo "<tr class='smalltext'>
				<td align='center'>1.</td>
				<td align='left'>Оплата за ортодонтическое лечение</td>
				<td align='center'>1</td>
				<td align='center'>".$_GET['summ']." руб</td>
				<td align='center'>".$_GET['summ']." руб</td>
			  </tr>
			  </table>";
			  $query = "INSERT INTO `schet_orto_schema` (`id`, `step`, `n`, `summ`,`sh_id`) 
			VALUES (NULL, ".$_GET['step'].", ".$_GET['n'].", ".$_GET['summ'].",".$_GET['id_shema'].")" ;
			////echo $query."<br>";
			$result=sql_query($query,'orto',0);   
                                                    unset ($row);
                                                    $row[0]=$result;
			msg($row[0]);
			$query = "INSERT INTO `schet_orto` (`id`, `vrach`, `pat`, `date`, `summ`, `summ_k_opl`, `summ_vnes`,`sh_id`)
		VALUES (NULL, 
		'".$_SESSION['UserID']."',
		'".$_SESSION['pat']."', 
		'".date('Y-m-d')."',
		'".$_GET['summ']."',
		'".$_GET['summ']."',
		0,
		".$row[0].")" ;
			////echo $query."<br>";
			$result=sql_query($query,'orto',0);
			
			echo "<a href='pat_tooday_orto.php'class='mmenu'>Закрыть</a>";
			unset($_SESSION['chek']);
			unset($_SESSION['countm']);
			unset($_SESSION['NZub']);
			unset($_SESSION['dsZub']);
			unset($_SESSION['QZub']);
			unset($_SESSION['pat']);
			unset($_SESSION['pat_name']);
			unset($_SESSION['zh']);
			unset($_SESSION['obk']);
			unset($_SESSION['lech']);
			unset($_SESSION['an']);
			unset($_SESSION['OsmID']);
			unset($_SESSION['summ']);	
		include("footer.php");
exit;			
}
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if (!($count>0))
{
	msg("Необходимо открыть кассовую смену");
	ret("kassa.php?action=nach&step=1");
}
else
{
    $row = mysqli_fetch_array($result);
	$_SESSION['kassa']=$row['id'];
}
switch ($_GET['action'])
{
	case "prOpl":
		switch ($_GET['step'])
		{
			case "1":
				$query = "SELECT `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `last_pay_month` FROM `orto_sh` WHERE `id`=".$_GET['sh_id'] ;
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$payd_month=$row['vnes']/$row['summ_month'];
				$dt=explode("-",$row['date']);
				$base_day		= $dt[2];	
				$base_mon		= $dt[1];
				$base_yr		= $dt[0];
				$current_day		= date ("j");
				$current_mon		= date ("n");
				$current_yr		= date ("Y");
				$base_mon_max		= date ("t",mktime (0,0,0,$base_mon,$base_day,$base_yr));
				$base_day_diff 		= $base_mon_max - $base_day;
				$base_mon_diff 		= 12 - $base_mon - 1;
				$start_day		= 1;
				$start_mon		= 1;
				$start_yr		= $base_yr + 1;
				$day_diff	= ($current_day - $start_day) + 1;
				$mon_diff	= ($current_mon - $start_mon) + 1;
				$yr_diff	= ($current_yr - $start_yr);
				$day_diff	= $day_diff + $base_day_diff;
				$mon_diff	= $mon_diff + $base_mon_diff;
				if ($day_diff >= $base_mon_max)
				{
					$day_diff = $day_diff - $base_mon_max;
					$mon_diff = $mon_diff + 1;
				}
				if ($mon_diff >= 12)
				{
					$mon_diff = $mon_diff - 12;
					$yr_diff = $yr_diff + 1;
				}
			if ($yr_diff ==1) $years = " год ";
			if (($yr_diff >1) and ($yr_diff <5)) $years = " года ";
			if ($yr_diff >4) $years = " лет";
			
			if ($day_diff ==1) $days = " день ";
			if (($day_diff >1) and ($day_diff <5)) $days = " дня ";
			if ($day_diff >4) $days = " дней ";
			
			if ($mon_diff ==1) $month = " месяц";
			if (($mon_diff >1) and ($mon_diff <5)) $month = " месяца ";
			if ($mon_diff >4) $month  = " месяцев ";
			if ($yr_diff >=1) 
			{
				$srT=$yr_diff.$years.$mon_diff.$month.$day_diff.$days;
				$dSR=($yr_diff*12)+$mon_diff;
			}
			else 
			{
				
				if ($mon_diff>="1") 
				{
					$srT=$mon_diff.$month.$day_diff.$days;
					$dSR=$mon_diff;
				}
				else  
				{
					$srT=$day_diff.$days;
					$dSR=1;
				}
			}
			$dolgM=$dSR-$payd_month;
				echo "<span class='head1'> Приём оплат ортодонтических пациентов.</span><br />
		<span class='head3'>Пациент: ".$_GET['PatName'].", срок лечения: ".$srT."<br />";
		
		if ($dolgM>0)
		{
			echo "<a href='pr_opl_orto.php?action=prOpl&step=5&id_shema=".$_GET['sh_id']."&n=".(date ("n")+1)."&summ=".($row['summ_month']*$dolgM)."' class='menu2'>Оплатить долг за ".$dolgM." месяцев (".($row['summ_month']*$dolgM)." р.)</a>";	
		}
		if ($row['last_pay_month']==12) echo "<br />
		<a href='pr_opl_orto.php?action=prOpl&step=2&id_shema=".$_GET['sh_id']."&n=1&summ=".$row['summ_month']."' class='menu2'>Принять оплату за месяц (".$row['summ_month']." р.)</a><br />";
		else echo "<br />
		<a href='pr_opl_orto.php?action=prOpl&step=2&id_shema=".$_GET['sh_id']."&n=".($row['last_pay_month']+1)."&summ=".$row['summ_month']."' class='menu2'>Принять оплату за месяц (".$row['summ_month']." р.)</a><br />";
		if ($row['vnes']!=0)echo "<a href='pr_opl_orto.php?action=prOpl&step=3&id_shema=".$_GET['sh_id']."&n=13&summ=".($row['summ']-$row['vnes'])."' class='menu2'>Принять остаток (".($row['summ']-$row['vnes'])." р.)</a><br />";
		else
echo "<a href='pr_opl_orto.php?action=prOpl&step=4&id_shema=".$_GET['sh_id']."&n=13&summ=".round(($row['summ']-($row['summ']*0.05)),-1)."' class='menu2'>Принять всю сумму сразу (".round(($row['summ']-($row['summ']*0.05)),-1)." р.) Скидка 5%.</a></span>";
			include("footer.php");
			exit;
			break;
			case "2":
				if (!(isset($_GET['podr'])))
				{
					echo "Оплата на: "; 
					$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					echo "<form name='pform' id='pform' action='pr_opl_orto.php' method='get'><select name='podr'>";
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value=".$row[0].">".$row[1]."</option>";
					}
					echo "</select><br />";
					echo "<input name='action' type='hidden' value=prOpl>";
					if (isset($_GET['so'])) echo "<input name='so' type='hidden' value=".$_GET['so'].">";
					echo "<input name='step' type='hidden' value=".$_GET['step'].">";
					echo "<input name='id_shema' type='hidden' value=".$_GET['id_shema'].">";
					echo "<input name='n' type='hidden' value=".$_GET[n].">";
					echo "<input name='summ' type='hidden' value=".$_GET['summ'].">";
					if (isset($av)) echo "<input name='av' type='hidden' value=".$av.">";
					if (isset($firm)) echo "<input name='firm' type='hidden' value='".$firm."'>";
					echo "<input name='ok' type='submit'  value='Дальше>>>'/></form>";
					include("footer.php");
				exit;
				}
				else
				{
					$_SESSION['podr']=$_GET['podr'];
				}
				if (isset($_GET['so']))
				{
					$query = "UPDATE`schet_orto` 
					SET `summ_vnes`=`summ_k_opl`
					WHERE `id`=".$_GET['so'] ;
					
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$sh_id=$_GET['so'];
				}
				else
				{
				
					$query = "SELECT `sotr`,`summ_month`,`pat` FROM `orto_sh` WHERE `id`=".$_GET['id_shema'] ;
						////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);	
					$sotr=$row['sotr'];
					$summ_month=$row['summ_month'];
					$pat=$row['pat'];
					$query = "INSERT INTO `schet_orto_schema` (`id`, `step`, `n`, `summ`,`sh_id`)												             		VALUES (NULL, ".$_GET['step'].", ".$_GET[n].", ".$_GET['summ'].",".$_GET['id_shema'].")" ;
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);
					$row[0] = $result;
					$query = "INSERT INTO `schet_orto` (
					`id`, 
					`vrach`, 
					`pat`, 
					`date`, 
					`summ`, 
					`summ_k_opl`, 
					`summ_vnes`,
					`sh_id`)
			VALUES (
			NULL, 
			'".$sotr."',
			'".$pat."', 
			'".date('Y-m-d')."',
			'".$summ_month."',
			'".$summ_month."',
			'".$_GET['summ']."',
			".$row[0].")" ;
					$result=sql_query($query,'orto',0);     
                                                                                        $sh_id=$result;
				////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
					$query = "UPDATE `orto_sh` 
							set `vnes`=`vnes`+`summ_month`,
							`last_pay_month`=".$_GET[n]."
							WHERE `id`=".$_GET['id_shema'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				
				$query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
						VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00','".$sh_id."','".$_GET['summ']."', '1',".$_SESSION['podr'].",'3') " ;
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$query = "UPDATE `kassa` 
				SET `summ`=`summ`+".$_GET['summ']."
				WHERE `id`=".$_SESSION['kassa'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<a class='mmenu' target='_blanc' href=\"print.php?type=orto_sch&id_shema=".$_GET['id_shema']."&summ=".$_GET['summ']."&podr=".$_SESSION['podr']."\">Печать чека</a><br />";
				echo "<a class='mmenu' href=\"pr_opl_orto.php\">Дальше</a>";
				include("footer.php");
				exit;
			break;
			case "3":
			if (!(isset($_GET['podr'])))
				{
					echo "Оплата на: "; 
					$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					echo "<form name='pform' id='pform' action='pr_opl_orto.php' method='get'><select name='podr'>";
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value=".$row[0].">".$row[1]."</option>";
					}
					echo "</select><br />";
					$query = "SELECT * FROM `opl_vid`" ;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
                                                                     echo "<script type=\"text/javascript\">
                                                                    function show_gift_num_input() {
                                                                    if ($('#v_opl').val()==\"4004\") 
                                                                        {
                                                                            $('#gift_num').attr(\"type\",\"text\");
                                                                        }
                                                                        else
                                                                        {
                                                                            $('#gift_num').attr(\"type\",\"hidden\");
                                                                        }
                                                                                           
                                                                    }
                                                                    </script>";                 
				echo "Вид оплаты: <select name='v_opl' id='v_opl' onchange='show_gift_num_input()'>";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					if ($row[0]==3)
					{
							if (isset($av)) 
							{
							echo "<option value=".$row[0]." selected='selected'>".$row[1]."</option>";
							}
					}
					else 
					{
						if ($row[0]==2)
						{
								if (isset($firm)) echo "<option value=".$row[0]." selected='selected'>".$row[1]."</option>";
						}
						else echo "<option value=".$row[0].">".$row[1]."</option>";
					}
					
				}
				echo "</select> <input name='gift_num' id='gift_num' type='hidden' value=''><br /> ";
					echo "<input name='action' type='hidden' value=prOpl>";
					if (isset($_GET['so'])) echo "<input name='so' type='hidden' value=".$_GET['so'].">";
					echo "<input name='step' type='hidden' value=".$_GET['step'].">";
					echo "<input name='id_shema' type='hidden' value=".$_GET['id_shema'].">";
					echo "<input name='n' type='hidden' value=".$_GET[n].">";
					echo "<input name='summ' type='hidden' value=".$_GET['summ'].">";
					if (isset($av)) echo "<input name='av' type='hidden' value=".$av.">";
					if (isset($firm)) echo "<input name='firm' type='hidden' value='".$firm."'>";
					echo "<input name='ok' type='submit'  value='Дальше>>>'/></form>";
					include("footer.php");
				exit;
				}
				else
				{
					$_SESSION['podr']=$_GET['podr'];
				}
				if (isset($_GET['so']))
				{
					$query = "UPDATE`schet_orto` 
					SET `summ_vnes`=`summ_k_opl`
					WHERE `id`=".$_GET['so'] ;
					
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$sh_id=$_GET['so'];
				}
				else
			
			{
				
					$query = "SELECT `sotr`,`summ_month`,`pat` FROM `orto_sh` WHERE `id`=".$_GET['id_shema'] ;
						////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);	
					$sotr=$row['sotr'];
					$summ_month=$row['summ_month'];
					$pat=$row['pat'];
					$query = "INSERT INTO `schet_orto_schema` (`id`, `step`, `n`, `summ`,`sh_id`)												             		VALUES (NULL, ".$_GET['step'].", ".$_GET[n].", ".$_GET['summ'].",".$_GET['id_shema'].")" ;
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);
					$row[0] = $result;
					$query = "INSERT INTO `schet_orto` (
					`id`, 
					`vrach`, 
					`pat`, 
					`date`, 
					`summ`, 
					`summ_k_opl`, 
					`summ_vnes`,
					`sh_id`)
			VALUES (
			NULL, 
			'".$sotr."',
			'".$pat."', 
			'".date('Y-m-d')."',
			'".$summ_month."',
			'".$summ_month."',
			'".$_GET['summ']."',
			".$row[0].")" ;
					$result=sql_query($query,'orto',0);    
                                                                                        $sh_id=$result;
				////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
					$query = "UPDATE `orto_sh` 
							set `vnes`=`vnes`+`summ_month`,
							`last_pay_month`=".$_GET[n]."
							WHERE `id`=".$_GET['id_shema'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				
				$query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
						VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00','".$sh_id."','".$_GET['summ']."', '".$_GET['v_opl']."',".$_SESSION['podr'].",'3') " ;
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($_GET['v_opl']==1)
				{
				$query = "UPDATE `kassa` 
				SET `summ`=`summ`+".$_GET['summ']."
				WHERE `id`=".$_SESSION['kassa'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
				echo "<a class='mmenu' target='_blanc' href=\"print.php?type=orto_sch&id_shema=".$_GET['id_shema']."&summ=".$_GET['summ']."\">Печать чека</a><br />";
				echo "<a class='mmenu' href=\"pr_opl_orto.php\">Дальше</a>";
				include("footer.php");
				exit;
			break;
			case "4":
				if (!(isset($_GET['podr'])))
				{
					echo "Оплата на: "; 
					$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					echo "<form name='pform' id='pform' action='pr_opl_orto.php' method='get'><select name='podr'>";
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value=".$row[0].">".$row[1]."</option>";
					}
					echo "</select><br />";
					echo "<input name='action' type='hidden' value=prOpl>";
					if (isset($_GET['so'])) echo "<input name='so' type='hidden' value=".$_GET['so'].">";
					echo "<input name='step' type='hidden' value=".$_GET['step'].">";
					echo "<input name='id_shema' type='hidden' value=".$_GET['id_shema'].">";
					echo "<input name='n' type='hidden' value=".$_GET[n].">";
					echo "<input name='summ' type='hidden' value=".$_GET['summ'].">";
					if (isset($av)) echo "<input name='av' type='hidden' value=".$av.">";
					if (isset($firm)) echo "<input name='firm' type='hidden' value='".$firm."'>";
					echo "<input name='ok' type='submit'  value='Дальше>>>'/></form>";
					include("footer.php");
				exit;
				}
				else
				{
					$_SESSION['podr']=$_GET['podr'];
				}
				if (isset($_GET['so']))
				{
					$query = "UPDATE`schet_orto` 
					SET `summ_vnes`=`summ_k_opl`
					WHERE `id`=".$_GET['so'] ;
					
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$sh_id=$_GET['so'];
				}
				else
				{
				
					$query = "SELECT `sotr`,`summ_month`,`pat` FROM `orto_sh` WHERE `id`=".$_GET['id_shema'] ;
						////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);	
					$sotr=$row['sotr'];
					$summ_month=$row['summ_month'];
					$pat=$row['pat'];
					$query = "INSERT INTO `schet_orto_schema` (`id`, `step`, `n`, `summ`,`sh_id`)												             		VALUES (NULL, ".$_GET['step'].", ".$_GET[n].", ".$_GET['summ'].",".$_GET['id_shema'].")" ;
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);
					$row[0]= $result;
					$query = "INSERT INTO `schet_orto` (
					`id`, 
					`vrach`, 
					`pat`, 
					`date`, 
					`summ`, 
					`summ_k_opl`, 
					`summ_vnes`,
					`sh_id`)
			VALUES (
			NULL, 
			'".$sotr."',
			'".$pat."', 
			'".date('Y-m-d')."',
			'".$summ_month."',
			'".$summ_month."',
			'".$_GET['summ']."',
			".$row[0].")" ;
					$result=sql_query($query,'orto',0);     
			$sh_id=$result;
				////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
					$query = "UPDATE `orto_sh` 
							set `vnes`=`vnes`+`summ_month`,
							`last_pay_month`=".$_GET[n]."
							WHERE `id`=".$_GET['id_shema'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				
				$query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
						VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00','".$sh_id."','".$_GET['summ']."', '1',".$_SESSION['podr'].",'3') " ;
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$query = "UPDATE `kassa` 
				SET `summ`=`summ`+".$_GET['summ']."
				WHERE `id`=".$_SESSION['kassa'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<a class='mmenu' target='_blanc' href=\"print.php?type=orto_sch&id_shema=".$_GET['id_shema']."&summ=".$_GET['summ']."\">Печать чека</a><br />";
				echo "<a class='mmenu' href=\"pr_opl_orto.php\">Дальше</a>";
				include("footer.php");
				exit;
			break;
			case "5":
				if (!(isset($_GET['podr'])))
				{
					echo "Оплата на: "; 
					$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					echo "<form name='pform' id='pform' action='pr_opl_orto.php' method='get'><select name='podr'>";
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value=".$row[0].">".$row[1]."</option>";
					}
					echo "</select><br />";
					echo "<input name='action' type='hidden' value=prOpl>";
					if (isset($_GET['so'])) echo "<input name='so' type='hidden' value=".$_GET['so'].">";
					echo "<input name='step' type='hidden' value=".$_GET['step'].">";
					echo "<input name='id_shema' type='hidden' value=".$_GET['id_shema'].">";
					echo "<input name='n' type='hidden' value=".$_GET[n].">";
					echo "<input name='summ' type='hidden' value=".$_GET['summ'].">";
					if (isset($av)) echo "<input name='av' type='hidden' value=".$av.">";
					if (isset($firm)) echo "<input name='firm' type='hidden' value='".$firm."'>";
					echo "<input name='ok' type='submit'  value='Дальше>>>'/></form>";
					include("footer.php");
				exit;
				}
				else
				{
					$_SESSION['podr']=$_GET['podr'];
				}
				if (isset($_GET['so']))
				{
					$query = "UPDATE`schet_orto` 
					SET `summ_vnes`=`summ_k_opl`
					WHERE `id`=".$_GET['so'] ;
					
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$sh_id=$_GET['so'];
				}
				else
				{
				
					$query = "SELECT `sotr`,`summ_month`,`pat` FROM `orto_sh` WHERE `id`=".$_GET['id_shema'] ;
						////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);	
					$sotr=$row['sotr'];
					$summ_month=$row['summ_month'];
					$pat=$row['pat'];
					$query = "INSERT INTO `schet_orto_schema` (`id`, `step`, `n`, `summ`,`sh_id`)												             		VALUES (NULL, ".$_GET['step'].", ".$_GET[n].", ".$_GET['summ'].",".$_GET['id_shema'].")" ;
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);
					$row[0] = $result;
					$query = "INSERT INTO `schet_orto` (
					`id`, 
					`vrach`, 
					`pat`, 
					`date`, 
					`summ`, 
					`summ_k_opl`, 
					`summ_vnes`,
					`sh_id`)
			VALUES (
			NULL, 
			'".$sotr."',
			'".$pat."', 
			'".date('Y-m-d')."',
			'".$summ_month."',
			'".$summ_month."',
			'".$_GET['summ']."',
			".$row[0].")" ;
					$result=sql_query($query,'orto',0); ;
                                                                                        $sh_id=$result;
				////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
					$query = "UPDATE `orto_sh` 
							set `vnes`=`vnes`+`summ_month`,
							`last_pay_month`=".$_GET[n]."
							WHERE `id`=".$_GET['id_shema'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				
				$query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
						VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00','".$sh_id."','".$_GET['summ']."', '1',".$_SESSION['podr'].",'3') " ;
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$query = "UPDATE `kassa` 
				SET `summ`=`summ`+".$_GET['summ']."
				WHERE `id`=".$_SESSION['kassa'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<a class='mmenu' target='_blanc' href=\"print.php?type=orto_sch&id_shema=".$_GET['id_shema']."&summ=".$_GET['summ']."&podr=".$_GET['podr']."\">Печать чека</a><br />";
				echo "<a class='mmenu' href=\"pr_opl_orto.php\">Дальше</a>";
				include("footer.php");
				exit;
			break;
		}
	break;
}
 echo "<span class='head1'> Приём оплат ортодонтических пациентов.</span><br />
		<span class='head3'>Список ортодонтических пациентов:</span> <br />
		
		  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='30%'>
			  
			  <form action=\"pr_opl_orto.php\" method=\"post\" name='fform' id='fform'>
			  <input name=\"find\" type=\"text\" value='".$_POST['find']."' onKeyUp='findP(this)' tabindex='1'/  autofocus><br />
<input name=\"FindFl\" type=\"hidden\" value=\"0\" />
</form>

<br>";
if ($_POST['FindFl']!='1')
{
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `klinikpat`.`id`, `orto_sh`.`summ_month`, `orto_sh`.`last_pay_month`, `orto_sh`.`vnes`, `klinikpat`.`DTel`, `klinikpat`.`RTel`, `klinikpat`.`MTel`, `orto_sh`.`id` as sh_id
	FROM klinikpat, orto_sh
	WHERE (
	(`klinikpat`.`id` =`orto_sh`.`pat`) AND 
	(`orto_sh`.`last_pay_month` !=13) AND 
	(`orto_sh`.`summ` !=`orto_sh`.`vnes`) AND 
	(`orto_sh`.`full` =0)
	)
	order by `klinikpat`.`surname`" ;
}
else
{
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `klinikpat`.`id`, `orto_sh`.`summ_month`, `orto_sh`.`last_pay_month`, `orto_sh`.`vnes`, `klinikpat`.`DTel`, `klinikpat`.`RTel`, `klinikpat`.`MTel`, `orto_sh`.`id` as sh_id
	FROM klinikpat, orto_sh
	WHERE (
	(`klinikpat`.`id` =`orto_sh`.`pat`) AND 
	(`orto_sh`.`last_pay_month` !=13) AND 
	(`orto_sh`.`summ` !=`orto_sh`.`vnes`) AND 
	(`orto_sh`.`full` =0) AND 
	(`klinikpat`.`surname` like '".$_POST['find']."%'))   order by `klinikpat`.`surname`" ;
}
////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>0)
{
echo "<form action='pr_opl_orto.php' method='get' name='opl_orto' id='opl_orto' >";
if ($count>15) echo "<select name='pat' size='15'  id='pat' onClick=\" ShowInfo2(this)\">";
else echo "<select name='pat' id='pat' size='".$count."' onClick=\" ShowInfo2(this)\">";	
    $aNum=	"";
	$aName=	"";
	$aSname="";
	$aOtch=	"";
	$aRt=	"";
	$aDt=	"";
	$aSt=	"";
	$aPMonth=	"";
	$shID=	"";
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "<option value=".$row['id'].">".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	if ($i==0)
	{
		$aNum.="aNum=new Array(\"".$row['id']."\"";
		$aName.="aName=new Array(\"".$row['name']."\"";
		$aSname.="aSname=new Array(\"".$row['surname']."\"";
		$aOtch.="aOtch=new Array(\"".$row['otch']."\"";
		$aRt.="aRt=new Array(\"".$row['RTel']."\"";
		$aDt.="aDt=new Array(\"".$row['DTel']."\"";
		$aSt.="aSt=new Array(\"".$row['MTel']."\"";
		$aPMonth="aPMonth=new Array(\"".$row['summ_month']."\"";
		$shID="shID=new Array(\"".$row['sh_id']."\"";
	}
	else
	{
		$aNum.=", \"".$row['id']."\"";
		$aName.=", \"".$row['name']."\"";
		$aSname.=", \"".$row['surname']."\"";
		$aOtch.=", \"".$row['otch']."\"";
		$aRt.=", \"".$row['RTel']."\"";
		$aDt.=", \"".$row['DTel']."\"";
		$aSt.=", \"".$row['MTel']."\"";
		$aPMonth.=", \"".$row['summ_month']."\"";
		$shID.=", \"".$row['sh_id']."\"";
	}
}
$aNum.=");";
$aName.=");";
$aSname.=");";
$aOtch.=");";
$aRt.=");";
$aDt.=");";
$aSt.=");";
$aPMonth.=");";
$shID.=");";
			
             echo " </select></td>";
echo "<script language='JavaScript' type='text/javascript'>";
echo $aNum;
echo $aName;
echo $aSname;
echo $aOtch;
echo $aRt;
echo $aDt;
echo $aSt;
echo $aPMonth;
echo $shID;
echo "</script>";
              
echo "<td><div align='center'>№ карты 
                <input input name='NCard' type='text' id='NCard' size='7' />
                <br>
Пациент: <input name='PatName' type='text'  size='75'/><br />
                д.т.<input name='DTel' type='text' id='DTel' />  
                р.т.<input name='RTel' type='text' id='RTel' />  
                с.т.<input name='STel' type='text' id='STel' />
                <br />
              Сумма за месяц: 
              <input name='MSumm' type='text' id='MSumm' /><br />
			  <input name='action' type='hidden' value='prOpl'>
			   <input name='step' type='hidden' value='1'>
			    <input name='sh_id' type='hidden' value=''>
<input name='' type='submit'  value='Принять оплату'/></div>
";
}
else
{
	echo "Долгов по ортодонтии нет";
}
echo "
              ";
include("footer.php");
?>