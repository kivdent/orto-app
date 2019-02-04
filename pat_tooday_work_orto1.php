<?php
$ThisVU="all";
$ModName="Работа спациентом";
$js="insert";
include("header2.php");
	 switch ($_GET[action])
	{
		case "oplata":
			$preysk=4;
			switch ($_GET[act])
			{
			case "add":
				if (!(isset($_SESSION[countm][1])))
				{
					$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=".$_GET[manip] ;
					//echo $query."<br>";
					include("query.php");
					$row = mysql_fetch_array($result);
					$_SESSION[countm][1]=1;
					$_SESSION[chek][1][$_SESSION[countm][1]][1]=$_GET[manip];
					$_SESSION[chek][1][$_SESSION[countm][1]][2]=1;
					$_SESSION[chek][1][$_SESSION[countm][1]][3]=$row[manip];
					$_SESSION[chek][1][$_SESSION[countm][1]][4]=$row[price];
				}
				else 
				{
					$f=0;
					for ($i=1;$i<=$_SESSION[countm][1];$i++)
					{
						if ($_GET[manip]==$_SESSION[chek][1][$i][1])
						{
							$f=1;
							$_SESSION[chek][1][$i][2]=$_SESSION[chek][1][$i][2]+1;
						}
					}
					if ($f==0)
					{
						$query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=".$_GET[manip] ;
						//echo $query."<br>";
						include("query.php");
						$row = mysql_fetch_array($result);
						$_SESSION[countm][1]++;
						$_SESSION[chek][1][$_SESSION[countm][1]][1]=$_GET[manip];
						$_SESSION[chek][1][$_SESSION[countm][1]][2]=1;
						$_SESSION[chek][1][$_SESSION[countm][1]][3]=$row[manip];
						$_SESSION[chek][1][$_SESSION[countm][1]][4]=$row[price];
						$_SESSION[chek][1][$_SESSION[countm][1]][5]=$row[zapis];
					}
					
				}
			ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk);
			break;
			case "del":
			if ($_SESSION[countm][1]==1) 
			{
				$_SESSION[countm][1]=0;
			}
			else
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][1][$i][1])
				{
					for ($j=$i;$j<$_SESSION[countm][1-1];$j++)
					{
						
						$_SESSION[chek][1][$j][1]=$_SESSION[chek][1][$j+1][1];
						$_SESSION[chek][1][$j][2]=$_SESSION[chek][1][$j+1][2];
						$_SESSION[chek][1][$j][3]=$_SESSION[chek][1][$j+1][3];
						$_SESSION[chek][1][$j][4]=$_SESSION[chek][1][$j+1][4];
						$_SESSION[chek][1][$j][5]=$_SESSION[chek][1][$j+1][5];
					}
				$_SESSION[countm][1]=$_SESSION[countm][1]-1;
				$i=$j+1;
				}
			}
			ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk);
			break;
			case "p1":
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][1][$i][1])
				{
					$_SESSION[chek][1][$i][2]=$_SESSION[chek][1][$i][2]+1;
				}
			}
			ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk);
			break;
			case "m1":
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][1][$i][1])
				{
					if ($_SESSION[chek][1][$i][2]==1)
					{
						msg("Количество манипуляций не может быть меньше одного");
					}
					else $_SESSION[chek][1][$i][2]=$_SESSION[chek][1][$i][2]-1;
				}
			}
			ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk);
			break;
			case "chQ":
				if ($_GET[sstep]==1)
				{	
					echo "<script language=\"JavaScript\" type=\"text/javascript\">
					function ChQ(id,qq)
					{
						q=prompt('Введите количество',qq);
						url='pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$_GET[preysk]."&id='+id+'&act=chQ&sstep=2&q='+q;
						location.href=url;
					}";
					echo "ChQ('".$_GET[id]."','".$_SESSION[chek][1][$_GET[id]][2]."')</script>";
				}
				else
				{
					$_SESSION[chek][1][$_GET[id]][2]=$_GET[q];
					ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$_GET[preysk]);
				}
			break;
			case "next":
			if ($_SESSION[countm][1]>0)
				{
				echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div><hr width='100%' noshade='noshade' size='1'/>";
		$opl=0;
		
		//$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
//		//echo $query."<br>";
//		//echo $opl." руб<br />";
//		include("query.php");
//		$row = mysql_fetch_array($result);
//		for ($i=1;$i<=1;$i++)
//		{	
//			$opl=$opl+$_SESSION[summ][$i];
//			
//			if ($count>0)
//			{
//				$ck=$row[proc];
//			}
//			else
//			{
//				$ck=0;
//			}
//		}
for ($i=1;$i<=1;$i++)
		{	
			$opl=$opl+$_SESSION[summ][$i];
			if (round(($_SESSION[summ][$i]-($_SESSION[summ][$i]*$_SESSION[proc_sk])/100),-1)==$_SESSION[summ][$i])
			{
				$summ_sk=(floor((($_SESSION[summ][$i]-($_SESSION[summ][$i]*$_SESSION[proc_sk])/100))/10))*10;
			}
			else
			{
				$summ_sk=round(($_SESSION[summ][$i]-($_SESSION[summ][$i]*$_SESSION[proc_sk])/100),-1);
			}	
		}
		$query = "INSERT INTO `schet_orto` (`id`, `vrach`, `pat`, `date`, `summ`, `summ_k_opl`, `summ_vnes`,`skidka`)
		VALUES (NULL, 
		'".$_SESSION["UserID"]."',
		'".$_SESSION[pat]."', 
		'".date('Y-m-d')."',
		'".$opl."',
		'".$summ_sk."',
		0,
		'".$_SESSION[proc_sk]."')" ;
		//echo $query."<br>";
		include("query.php");
		$query = "SELECT LAST_INSERT_ID()";
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		$pr=$row[0];
		$c=1;
		$m[$c][1]=$_SESSION[chek][1][1][1];
		$m[$c][2]=0;
		$m[$c][3]=$_SESSION[chek][1][1][3];
		$m[$c][4]=$_SESSION[chek][1][1][4];
		for ($i=1;$i<=1;$i++)
		{
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				$f=0;
				for ($q=1;$q<=$c;$q++)
				{
					if ($m[$q][1]==$_SESSION[chek][$i][$j][1])
					{
						
						$m[$q][2]+=$_SESSION[chek][$i][$j][2];
						$f=1;
					}		
				}
				if ($f==0) 
				{
					$c=$c+1;
					$m[$c][1]=$_SESSION[chek][$i][$j][1];
					$m[$c][2]=$_SESSION[chek][$i][$j][2];
					$m[$c][3]=$_SESSION[chek][$i][$j][3];
					$m[$c][4]=$_SESSION[chek][$i][$j][4];
				}				
			}
		}
	
		$query = "INSERT INTO `manip_sh_orto` (`id`,`manip`, `kolvo`,`SO`) values ";
		for ($i=1;$i<=1;$i++)
		{
			$NZub=0;
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				if ($j==1)$query.=" (NULL,'".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
				else $query.=", (NULL,'".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
			}
		}
		//echo "Вставка в Манипуляции при приёме<br>";
		//echo $query."<br>";
		
		include("query.php");
echo "Оплата № ".$pr;
echo "<br /><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($s);
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$m[$i][3]."</td>
				<td width='10%' align='center'>".$m[$i][2]."</td>
				<td width='12%' align='center'>".$m[$i][4]." руб.</td>
				<td width='10%' align='center'>".($m[$i][2]*$m[$i][4])." руб.</td>
			  </tr>";
			  $s+=$m[$i][2]*$m[$i][4];
			} 
			
				
			echo "</table>";
			echo "<div align='right'>Итого: ".$s." руб. </div>";
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			//echo $query."<br>";
			include("query.php");
			if ($_SESSION[proc_sk]>0)
			{
				$row = mysql_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".$summ_sk." руб.</div>";
			}
//		$query = "INSERT INTO `oplata` (`id`, `dnev`, `stoim`, `soimSoSk`, `vnes`, `dolg`, `VidOpl`) VALUES (NULL,'".$pr."','".$s."','".$ssk."',0,'".$ssk."',1)" ;
//		//echo "Всатавка в Оплату<br>";
//		//echo $query."<br>";
//		include("query.php");
//	break;
//	echo "<a href='print.php?type=pat&card=".$pr."' target='_blank' class='mmenu'>Печать карты</a><br />"
//;
	echo "<a href='pat_tooday_orto.php'class='mmenu'>Закрыть</a>";
unset($_SESSION[chek]);
unset($_SESSION[proc_sk]);
unset($_SESSION[skidka]);
	unset($_SESSION[countm]);
	unset($_SESSION[NZub]);
	unset($_SESSION[dsZub]);
	unset($_SESSION[QZub]);
	unset($_SESSION[pat]);
	unset($_SESSION[pat_name]);
	unset($_SESSION[zh]);
	unset($_SESSION[obk]);
	unset($_SESSION[lech]);
	unset($_SESSION[an]);
	unset($_SESSION[OsmID]);
	unset($_SESSION[summ]);	
					include("footer.php");
			exit;
				}
				else
				{
					msg("Вы не выбрали не одной манипуляции");
					ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk);
				}
				
		
			break;	
			}
		
			if (!(isset($_GET[preysk]))) 
			{	
				$query = "SELECT * 
				FROM `preysk` 
				LIMIT 1";
				//echo $query."<br />";
				include("query.php");
				$row = mysql_fetch_array($result);
				$preysk=$row[0];
			}
	        else $preysk=$_GET[preysk];
			if (!(isset($_SESSION[pat]))) $_SESSION[pat]=$_GET[pat];
			//////////Заполнение лечения
			echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='1' />";
				$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_SESSION[pat];
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$_SESSION[pat_name]=$row[0]." ".$row[1]." ".$row[2];
			echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
					<hr width='100%' noshade='noshade' size='1'/>
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td><center><div class='head2'>Прейскуранты:</div><br />";
				$query = "select * from preysk";
				//echo $query."<br />";
				include("query.php");
		        for ($i=0;$i<$count;$i++)
		       {
					$row = mysql_fetch_array($result);
					if ($row[id]==$preysk) echo "|<font color='#42929D'>".$row[preysk]."</font>|";
					else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$row[id]."'>".$row[preysk]."</a>|";
				}
				$query = "SELECT `id`,`sotr`,`per_lech`, `summ`, `summ_month`, `vnes` FROM `orto_sh` WHERE `pat`=".$_SESSION[pat] ;
				//echo $query."<br>";
				include("query.php");
				if ($count>0) 
				{
					$row = mysql_fetch_array($result);
					if ($row[sotr]==$_SESSION["UserID"])
					{
						if ('opl_orto'==$preysk) echo "|<font color='#42929D'>Оплата ортодонтии</font>|";
					else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=opl_orto'>Оплата ортодонтии</a>|";
					$sh_id=	$row[id];
					}
				}
				echo " </center></td>
			  </tr>
			  <tr>
				<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>";
		
				//echo "<td width='60%' align='center' valign='top'>Выбирте манипуляцию: <br />";
				//$query = "select * from manip WHERE preysk=".$preysk." order by manip";
		//echo $query."<br />";
		//include("query.php");
		//
		//
		//
		//
		//
		//
		//
		//
		//if ($count>15) echo "<select name='manip' size='15'>";
		//else echo "<select name='manip' size='".$count."'>";
		//if (!($count>0))
		//{
		//	$N="Название";
		//	while (strlen($N)<30) 
		//	{
		//		$N=$N."_";
		//	}
		//	$N=$N."Цена";
		//	echo "<option value=''>".$N."</option>";
		//}
		//for ($i=0;$i<$count;$i++)
		//{
		//	$row = mysql_fetch_array($result);
		//	$N=$row[manip];
		//	while (strlen($N)<30) 
		//	{
		//		$N=$N."_";
		//	}
		//	$N=$N.$row[price]." руб.";
		//	echo "<option value='".$row[id]."'>".$N."</option>";
		//}
		//
		//echo "</select>
		//		<br />
		//	
		//		  <input type='submit' name='Submit' value='Добавить в список' />";
		
				  
				 //echo " </td>";
		
				echo "<td width='40%' valign='top' align='center'>Оплата:";
					
				if ($_SESSION[countm][1]>0)
				{
					echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='6%'><div align='center' class='feature3'>№</div></td>
						<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='17%'><div align='center' class='feature3'>Количество</div></td>
						<td width='12%'><div align='center' class='feature3'>Цена</div></td>
						<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
					unset($_SESSION[summ][1]);
					for ($i=1;$i<=$_SESSION[countm][1];$i++)
					{
						echo "  <tr>
						<td width='6%' align='center'>".$i."</td>
						<td width='62%' align='left'>".$_SESSION[chek][1][$i][3]."<br />
						<a href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk."&chek=".$_SESSION[chek][1][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
		</td>
						<td width='10%' align='center'>".$_SESSION[chek][1][$i][2]."<br />
		<a href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
						<td width='12%' align='center'>".$_SESSION[chek][1][$i][4]." руб.</td>
						<td width='10%' align='center'>".($_SESSION[chek][1][$i][2]*$_SESSION[chek][1][$i][4])." руб.</td>
					  </tr>";
					$_SESSION[summ][1]+=$_SESSION[chek][1][$i][2]*$_SESSION[chek][1][$i][4];	
					} 
					echo "</table>";
					echo "<div align='right'>Итого: ".$_SESSION[summ][1]." руб. </div>";
					////скидка
						if (!isset($_GET[skidka]))
			{
				
				if (!isset($_SESSION[skidka]))
				{
					$query = "SELECT  `klinikpat`.`Skidka`,`klinikpat`.`id`
		FROM  klinikpat
		WHERE (`klinikpat`.`id` ='".$_SESSION[pat]."')" ;
					//////////echo $query."<br>"; <a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET[count]."&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>
					include("query.php");
					if ($count>0)
					{
						$row = mysql_fetch_array($result);
						$ck=$row[1];
						
					}
					else
					{
						$ck=0;
					}
					$_SESSION[skidka]=$ck;
				}
				else
				{
					$ck=$_SESSION[skidka];
				}
			}
			else
			{
				$ck=$_GET[skidka];
				$_SESSION[skidka]=$ck;
			}
			$query = "SELECT `id`, `naimenov`, `proc` FROM `skidka` order by `proc`" ;
			////echo $query."<br>";
			include("query.php");
			echo "<div align='right'>
			<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu2(targ,selObj,restore){
  eval(targ+\".location='pat_tooday_work_orto.php?action=lech&step=4&count=".$_GET[count]."&preysk=".$preysk."&skidka=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			Скидка: <select name='skidka' onchange=\"MM_jumpMenu2('parent',this,0)\">";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				if ($ck==$row[id]) 
				{
					
					echo "<option value='".$row[proc]."' selected='selected'>".$row[naimenov]." (".$row[proc]."%)</option>";
					$_SESSION[proc_sk]=$row[proc];
					if (round(($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[proc])/100),-1)==$_SESSION[summ][$_GET[count]])
					{
						$summ_sk=(floor((($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[proc])/100))/10))*10;
					}
					else
					{
						$summ_sk=round(($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[proc])/100),-1);
					}
				}
				else echo "<option value='".$row[id]."'>".$row[naimenov]." (".$row[proc]."%)</option>";
				
			}
			echo "</select><br />";
			echo "Итого со скидкой: ".$summ_sk." руб.</div>";
			/////конец скидки
					if ($_SESSION[QZub]>1)
					{
						$os=0;
						for($i=1;$i<=1;$i++) 
						{
							$os=$os+($_SESSION[summ][$i]);
						}
					echo "<div align='right'>Общая сумма: ".round(($os-($os*$ck)/100),-1)." руб.</div>";				
					}
				  //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
		//		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
		//		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
				}
				else echo "&nbsp";
				echo "<input name='act' type='hidden' value='add' />";
				echo "<input name='step' type='hidden' value='4' />";
				echo "<input name='action' type='hidden' value='oplata' />
				  </td>
			  </tr>
			</table>
			</td>
			  </tr>
			</table>";
				echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";
			
			
		//$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
		if ('opl_orto'==$preysk)
		{
			///////////////////
			     $query = "SELECT `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `last_pay_month` FROM `orto_sh` WHERE `id`=".$sh_id;
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
			    $payd_month=$row[vnes]/$row[summ_month];
				$dt=explode("-",$row[date]);
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
				echo "<span class='head1'>Cрок лечения: ".$srT."<br />";
		if ($dolgM>0)
		{
			echo "<a href='pr_opl_orto.php?type=vrach&step=5&id_shema=".$sh_id."&n=".(date ("n")+1)."&summ=".($row[summ_month]*$dolgM)."' class='small'>Оплатить долг за ".$dolgM." месяцев (".($row[summ_month]*$dolgM)." р.)</a>";	
		}
		echo "<br />
		<a href='pr_opl_orto.php?type=vrach&step=2&id_shema=".$sh_id."&n=".($row[last_pay_month]+1)."&summ=".$row[summ_month]."' class='small'>Принять оплату за месяц (".$row[summ_month]." р.)</a>			  <br />";
		if ($row[vnes]!=0)echo "<a href='pr_opl_orto.php?type=vrach&step=3&id_shema=".$sh_id."&n=13&summ=".($row[summ]-$row[vnes])."' class='small'>Принять остаток (".($row[summ]-$row[vnes])." р.)</a><br />";
		else
echo "<a href='pr_opl_orto.php?type=vrach&step=4&id_shema=".$sh_id."&n=13&summ=".round(($row[summ]-($row[summ]*0.05)),-1)."' class='small'>Принять всю сумму сразу (".round(($row[summ]-($row[summ]*0.05)),-1)." р.) Скидка 5%.</a></span>";
		}
		else
		{
		$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by range, manip";
				//echo $query."<br />";
				include("query.php");
				$cc=0;
				$cm=0;
					for ($i=0;$i<$count;$i++)
					{
						$row = mysql_fetch_array($result);
						if ($row[cat]==1)
						{
							$cc++;
							$cat[$cc][id]=$row[id];
							$cat[$cc][manip]=$row[manip];
							
						}
						else
						{
							$cm++;
							$mat[$cm][id]=$row[id];
							$mat[$cm][manip]=$row[manip];
							$mat[$cm][price]=$row[price];
							$mat[$cm][UpId]=$row[UpId];
						}
					}
					echo "<script language=\"JavaScript\" type=\"text/javascript\">
					document.onclick = clickHandler; 
					</script>";
				for($i=1;$i<=$cc;$i++)
					{
						echo "
					<SPAN id='Out".$i."' class='mmenuHand'>".$cat[$i][manip]."</SPAN><br />
			<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
				<table width='80%' border='0'>
			";
						
						for($j=1;$j<=$cm;$j++)
						{
						
							if ($cat[$i][id]==$mat[$j][UpId])
							echo "<tr>
				<td width='85%'><a href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>". $mat[$j][manip]."</a></td>
				<td width='15%'>
				".$mat[$j][price]."
				</td>
			  </tr>";
						} 
						echo "</table></div>";
					}
		}
					echo "</form>";
			include("footer.php");
			exit;

		break;
case "Sozd_ZN":
 			$preysk=4;
			switch ($_GET[act])
			{
			case "add":
				if (!(isset($_SESSION[countm][1])))
				{
					$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=".$_GET[manip] ;
					//echo $query."<br>";
					include("query.php");
					$row = mysql_fetch_array($result);
					$_SESSION[countm][1]=1;
					$_SESSION[chek][1][$_SESSION[countm][1]][1]=$_GET[manip];
					$_SESSION[chek][1][$_SESSION[countm][1]][2]=1;
					$_SESSION[chek][1][$_SESSION[countm][1]][3]=$row[manip];
					$_SESSION[chek][1][$_SESSION[countm][1]][4]=$row[price];
				}
				else 
				{
					$f=0;
					for ($i=1;$i<=$_SESSION[countm][1];$i++)
					{
						if ($_GET[manip]==$_SESSION[chek][1][$i][1])
						{
							$f=1;
							$_SESSION[chek][1][$i][2]=$_SESSION[chek][1][$i][2]+1;
						}
					}
					if($f==0)
					{
						$query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=".$_GET[manip] ;
						//echo $query."<br>";
						include("query.php");
						$row = mysql_fetch_array($result);
						$_SESSION[countm][1]=$_SESSION[countm][1]+1;
						$_SESSION[chek][1][$_SESSION[countm][1]][1]=$_GET[manip];
						$_SESSION[chek][1][$_SESSION[countm][1]][2]=1;
						$_SESSION[chek][1][$_SESSION[countm][1]][3]=$row[manip];
						$_SESSION[chek][1][$_SESSION[countm][1]][4]=$row[price];
						$_SESSION[chek][1][$_SESSION[countm][1]][5]=$row[zapis];
					}
					
				}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk);
			break;
			case "del":
			if ($_SESSION[countm][1]==1) 
			{
				$_SESSION[countm][1]=0;
			}
			else
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][1][$i][1])
				{
					for ($j=$i;$j<$_SESSION[countm][1-1];$j++)
					{
						
						$_SESSION[chek][1][$j][1]=$_SESSION[chek][1][$j+1][1];
						$_SESSION[chek][1][$j][2]=$_SESSION[chek][1][$j+1][2];
						$_SESSION[chek][1][$j][3]=$_SESSION[chek][1][$j+1][3];
						$_SESSION[chek][1][$j][4]=$_SESSION[chek][1][$j+1][4];
						$_SESSION[chek][1][$j][5]=$_SESSION[chek][1][$j+1][5];
					}
				$_SESSION[countm][1]=$_SESSION[countm][1]-1;
				$i=$j+1;
				}
			}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk);
			break;
			case "p1":
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][1][$i][1])
				{
					$_SESSION[chek][1][$i][2]=$_SESSION[chek][1][$i][2]+1;
				}
			}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk);
			break;
			case "m1":
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][1][$i][1])
				{
					if ($_SESSION[chek][1][$i][2]==1)
					{
						msg("Количество манипуляций не может быть меньше одного");
					}
					else $_SESSION[chek][1][$i][2]=$_SESSION[chek][1][$i][2]-1;
				}
			}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk);
			break;
			case "chQ":
				if ($_GET[sstep]==1)
				{	
					echo "<script language=\"JavaScript\" type=\"text/javascript\">
					function ChQ(id,qq)
					{
						q=prompt('Введите количество',qq);
						url='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$_GET[preysk]."&id='+id+'&act=chQ&sstep=2&q='+q;
						location.href=url;
					}";
					echo "ChQ('".$_GET[id]."','".$_SESSION[chek][1][$_GET[id]][2]."')</script>";
				}
				else
				{
					$_SESSION[chek][1][$_GET[id]][2]=$_GET[q];
					ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1preysk=".$_GET[preysk]);
				}
			break;
			case "next":
			if ($_SESSION[countm][1]>0)
				{
				echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div><hr width='100%' noshade='noshade' size='1'/>";
//		echo "Жалобы: ";
//		for ($i=1;$i<=$_SESSION[QZub];$i++)
//		{
//		$zh=$_SESSION[NZub][$i]." ".$_SESSION[zh][$i]."<br />";	
//		}
//		echo $zh."<br />";
//		echo "Анамнез: ";
//		for ($i=1;$i<=$_SESSION[QZub];$i++)
//		{
//		$an=$_SESSION[NZub][$i]." ".$_SESSION[an][$i]."<br />";	
//		}
//		echo $an."<br />";
//		echo "Объективно: ";
//		for ($i=1;$i<=$_SESSION[QZub];$i++)
//		{
//		$obk=$_SESSION[NZub][$i]." ".$_SESSION[obk][$i]."<br />";	
//		}
//		echo $obk."<br />";
//		echo "Диагноз : ";
//		for ($i=1;$i<=$_SESSION[QZub];$i++)
//		{
//			$NZub=$_SESSION[NZub][$i];
//			$dsZub=$_SESSION[dsZub][$NZub];
//			$query = "Select Nazv from ds where id=".$dsZub;
//			//echo $query."<br />";
//			include("query.php");
//			$row = mysql_fetch_array($result);
//			$ds=$ds.$NZub."-й зуб, ".$row[Nazv]."<br />";
//			echo $ds;
//		}
//		echo "<br />Лечение: ";
//		for ($i=1;$i<=$_SESSION[QZub];$i++)
//		{
//		$lech=$_SESSION[NZub][$i]." ".$_SESSION[lech][$i]."<br />";	
//		}
//		echo $lech."<br />";
		//echo "Итого: ";
		$opl=0;
		//$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
//		//echo $query."<br>";
//		//echo $opl." руб<br />";
//		include("query.php");
//		$row = mysql_fetch_array($result);
//		for ($i=1;$i<=1;$i++)
//		{	
//			$opl=$opl+$_SESSION[summ][$i];
//			
//			if ($count>0)
//			{
//				$ck=$row[proc];
//			}
//			else
//			{
//				$ck=0;
//			}
//		}
		for ($i=1;$i<=1;$i++)
		{	
			$opl=$opl+$_SESSION[summ][$i];
			if (round(($_SESSION[summ][$i]-($_SESSION[summ][$i]*$_SESSION[proc_sk])/100),-1)==$_SESSION[summ][$i])
			{
				$summ_sk=(floor((($_SESSION[summ][$i]-($_SESSION[summ][$i]*$_SESSION[proc_sk])/100))/10))*10;
			}
			else
			{
				$summ_sk=round(($_SESSION[summ][$i]-($_SESSION[summ][$i]*$_SESSION[proc_sk])/100),-1);
			}	
		}
		$query = "INSERT INTO `zaknar` (`id`, `vrach`, `pat` , `tech`, `date`, `dateSd`, `timeSd`, `summ`, `summ_k_opl`, `summ_vnes`,`skidka`)
		VALUES (NULL, 
		'".$_SESSION["UserID"]."',
		'".$_SESSION[pat]."', 
		'".$_GET[tech]."',
		'".date('Y-m-d')."',
		'".$_GET[DateDY]."-".$_GET[DateDM]."-".$_GET[DateDD]."',
		'".$_GET[TimeH].":".$_GET[TimeM].":00',
		'".$opl."',
		'".$summ_sk."',
		0,
		".$_SESSION[proc_sk].")" ;
		//echo $query."<br>";
		include("query.php");
		$query = "SELECT LAST_INSERT_ID()";
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		$pr=$row[0];
		$c=1;
		$m[$c][1]=$_SESSION[chek][1][1][1];
		$m[$c][2]=0;
		$m[$c][3]=$_SESSION[chek][1][1][3];
		$m[$c][4]=$_SESSION[chek][1][1][4];
		for ($i=1;$i<=1;$i++)
		{
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				$f=0;
				for ($q=1;$q<=$c;$q++)
				{
					if ($m[$q][1]==$_SESSION[chek][$i][$j][1])
					{
						
						$m[$q][2]+=$_SESSION[chek][$i][$j][2];
						$f=1;
					}		
				}
				if ($f==0) 
				{
					$c=$c+1;
					$m[$c][1]=$_SESSION[chek][$i][$j][1];
					$m[$c][2]=$_SESSION[chek][$i][$j][2];
					$m[$c][3]=$_SESSION[chek][$i][$j][3];
					$m[$c][4]=$_SESSION[chek][$i][$j][4];
				}				
			}
		}
	
		$query = "INSERT INTO `manip_zn` (`id`,`manip`, `kolvo`,`ZN`) values ";
		for ($i=1;$i<=1;$i++)
		{
			$NZub=0;
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				if ($j==1)$query.=" (NULL,'".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
				else $query.=", (NULL,'".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
			}
		}
		//echo "Вставка в Манипуляции при приёме<br>";
		//echo $query."<br>";
		
		include("query.php");
		$query ="SELECT `id`, `surname`, `name`, `otch` FROM `sotr` WHERE `id`=".$_GET[tech] ;
				//echo $query."<br>";
				include("query.php");
					   $row = mysql_fetch_array($result);

		echo "№ Заказ наряда".$pr."<br />
		Техник :".$row[surname]." ".$row[name]." ".$row[otch];
 if ($_GET[DateDD]==0) echo "Дата сдачи:__/__/______";
 else echo "Дата сдачи:".$_GET[DateDD]."/".$_GET[DateDM]."/".$_GET[DateDY];
 if ($_GET[TimeH]==0) echo " __ч:__м";
 else  echo " ".$_GET[TimeH].":".$_GET[TimeM];
echo "<br /><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($s);
			for ($i=1;$i<=$_SESSION[countm][1];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$m[$i][3]."</td>
				<td width='10%' align='center'>".$m[$i][2]."</td>
				<td width='12%' align='center'>".$m[$i][4]." руб.</td>
				<td width='10%' align='center'>".($m[$i][2]*$m[$i][4])." руб.</td>
			  </tr>";
			  $s+=$m[$i][2]*$m[$i][4];
			} 
			
				
			echo "</table>";
			echo "<div align='right'>Итого: ".$s." руб. </div>";
//			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			////echo $query."<br>";
//			include("query.php");
				if ($_SESSION[proc_sk]>0)
			{
				$row = mysql_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".$summ_sk." руб.</div>";
			}
//		$query = "INSERT INTO `oplata` (`id`, `dnev`, `stoim`, `soimSoSk`, `vnes`, `dolg`, `VidOpl`) VALUES (NULL,'".$pr."','".$s."','".$ssk."',0,'".$ssk."',1)" ;
//		//echo "Всатавка в Оплату<br>";
//		//echo $query."<br>";
//		include("query.php");
//	break;
//	echo "<a href='print.php?type=pat&card=".$pr."' target='_blank' class='mmenu'>Печать карты</a><br />"
//;
	echo "<a href='pat_tooday_orto.php'class='mmenu'>Закрыть</a>";
unset($_SESSION[chek]);
	unset($_SESSION[proc_sk]);
unset($_SESSION[skidka]);
	unset($_SESSION[countm]);
	unset($_SESSION[NZub]);
	unset($_SESSION[dsZub]);
	unset($_SESSION[QZub]);
	unset($_SESSION[pat]);
	unset($_SESSION[pat_name]);
	unset($_SESSION[zh]);
	unset($_SESSION[obk]);
	unset($_SESSION[lech]);
	unset($_SESSION[an]);
	unset($_SESSION[OsmID]);
	unset($_SESSION[summ]);	
					include("footer.php");
			exit;
				}
				else
				{
					msg("Вы не выбрали не одной манипуляции".$_SESSION[countm][1]);
					ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk);
				}
				
		
			break;	
			}
			if (!(isset($_GET[preysk]))) $preysk=4;
			else $preysk=$_GET[preysk];
			if (!(isset($_SESSION[pat]))) $_SESSION[pat]=$_GET[pat];
			//////////Заполнение лечения
			echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='1' />";
				$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_SESSION[pat];
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$_SESSION[pat_name]=$row[0]." ".$row[1]." ".$row[2];
			echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
					<hr width='100%' noshade='noshade' size='1'/>
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td><!--<center><div class='head2'>Прейскуранты:</div><br />";
				$query = "select * from preysk";
				//echo $query."<br />";
				include("query.php");
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			if ($row[id]==$preysk) echo "|<font color='#42929D'>".$row[preysk]."</font>|";
			else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$row[id]."'>".$row[preysk]."</a>|";
		}
				echo " </center>--></td>
			  </tr>
			  <tr>
				<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>";
		
				//echo "<td width='60%' align='center' valign='top'>Выбирте манипуляцию: <br />";
				//$query = "select * from manip WHERE preysk=".$preysk." order by manip";
		//echo $query."<br />";
		//include("query.php");
		//
		//
		//
		//
		//
		//
		//
		//
		//if ($count>15) echo "<select name='manip' size='15'>";
		//else echo "<select name='manip' size='".$count."'>";
		//if (!($count>0))
		//{
		//	$N="Название";
		//	while (strlen($N)<30) 
		//	{
		//		$N=$N."_";
		//	}
		//	$N=$N."Цена";
		//	echo "<option value=''>".$N."</option>";
		//}
		//for ($i=0;$i<$count;$i++)
		//{
		//	$row = mysql_fetch_array($result);
		//	$N=$row[manip];
		//	while (strlen($N)<30) 
		//	{
		//		$N=$N."_";
		//	}
		//	$N=$N.$row[price]." руб.";
		//	echo "<option value='".$row[id]."'>".$N."</option>";
		//}
		//
		//echo "</select>
		//		<br />
		//	
		//		  <input type='submit' name='Submit' value='Добавить в список' />";
		
				  
				 //echo " </td>";
		
				echo "<td width='40%' valign='top' align='center'>Заказ-наряд:<br />
				Техник:  ";
				$query ="SELECT `id`, `surname`, `name`, `otch` FROM `sotr` WHERE `dolzh`=8 ORDER BY `surname`" ;
				//echo $query."<br>";
				include("query.php");
				echo "<select name=\"tech\">";
				for ($i=0;$i<$count;$i++)
				{
					   $row = mysql_fetch_array($result);
					   if ($row[id]==$_GET[tech]) echo "<option value=".$row[id]." selected='selected'>".$row[surname]." ".$row[name]." ".$row[otch]."</option>";
					   echo "<option value=".$row[id].">".$row[surname]." ".$row[name]." ".$row[otch]."</option>";
				}
				echo "</select> Срок сдачи <select name='DateDD'>";
	if (($_GET[DateDD]==0) or (!(isset($_GET[DateDD]))))  echo "<option value='0'  selected='selected'>&nbsp;</option>";
	else echo "<option value='0'>&nbsp;</option>";
	
		for ($i=1; $i<32; $i++)
		{
			$s="";
			if ($i==$_GET[DateDD]) $s=" selected='selected'";
			if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
			else echo "<option value='".$i."' ".$s.">".$i."</option>";
		}

echo "</select>
  /
<select name='DateDM'' size='1'>";
if (($_GET[DateDM]==0) or (!(isset($_GET[DateDM]))))  echo "<option value='0'  selected='selected'>&nbsp;</option>";
else echo "<option value='0'>&nbsp;</option>";
$s="";
for ($i=1; $i<13; $i++)
{
switch ($i)
	{
	case "1":
		$s="'>Январь</option>";
		break;
	case "2":
		$s="'>Февраль</option>";
		break;
	case "3":
		$s="'>Март</option>";
		break;
	case "4":
		$s="'>Апрель</option>";
		break;
	case "5":
		$s="'>Май</option>";
		break;
	case "6":
		$s="'>Июнь</option>";
		break;
	case "7":
		$s="'>Июль</option>";
		break;
	case "8":
		$s="'>Август</option>";
		break;
	case"9":
		$s="'>Сентябрь</option>";
		break;
	case "10":
		$s="'>Октябрь</option>";
		break;
	case "11":
		$s="'>Ноябрь</option>";
		break;
	case "12":
		$s="'>Декабрь</option>";
		break;
}
if ($i<10)
{
	if ($i==$_GET[DateDM]) echo "<option value='0".$i."' selected='selected".$s."</option>";
    else echo "<option value='0".$i.$s."</option>";
}
else		
{
     if ($i==$_GET[DateDM]) echo "<option value='".$i."' selected='selected".$s."</option>";
     else echo "<option value='".$i.$s."</option>";
}
}
echo "      </select>";
echo"/
      <select name='DateDY'>";
	  if (($_GET[DateDY]==0) or (!(isset($_GET[DateDY]))))  echo "<option value='0'  selected='selected'>&nbsp;</option>";
else echo "<option value='0'>&nbsp;</option>";
$s="";
for ($i=2007; $i<2010; $i++)
{
if ($i==$_GET[DateDY]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
else echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select> к  <select name='TimeH'>";
if (($_GET[TimeH]==0) or (!(isset($_GET[TimeH]))))  echo "<option value='0'  selected='selected'>&nbsp;</option>";
else echo "<option value='0'>&nbsp;</option>";
$s="";
for ($i=8; $i<20; $i++)
{
if ($_GET[TimeH]==$i) echo "<option value='".$i."' selected='selected'>".$i."</option>";
echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select>ч <select name='TimeM'>";
if (($_GET[TimeM]==0) or (!(isset($_GET[TimeM]))))  echo "<option value='N'  selected='selected'>&nbsp;</option>";
else echo "<option value='N'>&nbsp;</option>";
$s="";
for ($i=0; $i<60; $i+=15)
{
if (0==$i) echo "<option value='".$i."'>0".$i."</option>";
else echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select>м ";		
				if ($_SESSION[countm][1]>0)
				{
					echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='6%'><div align='center' class='feature3'>№</div></td>
						<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='17%'><div align='center' class='feature3'>Количество</div></td>
						<td width='12%'><div align='center' class='feature3'>Цена</div></td>
						<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
					unset($_SESSION[summ][1]);
					for ($i=1;$i<=$_SESSION[countm][1];$i++)
					{
						echo "  <tr>
						<td width='6%' align='center'>".$i."</td>
						<td width='62%' align='left'>".$_SESSION[chek][1][$i][3]."<br />
						<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk."&chek=".$_SESSION[chek][1][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
		</td>
						<td width='10%' align='center'>".$_SESSION[chek][1][$i][2]."<br />
		<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
						<td width='12%' align='center'>".$_SESSION[chek][1][$i][4]." руб.</td>
						<td width='10%' align='center'>".($_SESSION[chek][1][$i][2]*$_SESSION[chek][1][$i][4])." руб.</td>
					  </tr>";
					$_SESSION[summ][1]+=$_SESSION[chek][1][$i][2]*$_SESSION[chek][1][$i][4];	
					} 
					echo "</table>";
					echo "<div align='right'>Итого: ".$_SESSION[summ][1]." руб. </div>";
					
					
					
					
					
					////скидка
			if (!isset($_GET[skidka]))
			{
				
				if (!isset($_SESSION[skidka]))
				{
					$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
		FROM skidka, klinikpat
		WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
					//echo $query."<br>";
					include("query.php");
					if ($count>0)
					{
						$row = mysql_fetch_array($result);
						$ck=$row[1];
						
					}
					else
					{
						$ck=0;
					}
					$_SESSION[skidka]=$ck;
				}
				else
				{
					$ck=$_SESSION[skidka];
				}
			}
			else
			{
				$ck=$_GET[skidka];
				$_SESSION[skidka]=$ck;
			}
			$query = "SELECT `id`, `naimenov`, `proc` FROM `skidka` order by `proc`" ;
			//echo $query."<br>";
			include("query.php");
			echo "<div align='right'>
			<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu2(targ,selObj,restore){
  eval(targ+\".location='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk."&skidka=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			Скидка: <select name='skidka' onchange=\"MM_jumpMenu2('parent',this,0)\">";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				if ($ck==$row[id]) 
				{
					
					echo "<option value='".$row[id]."' selected='selected'>".$row[naimenov]." (".$row[proc]."%)</option>";
					$_SESSION[proc_sk]=$row[proc];
					if (round(($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[proc])/100),-1)==$_SESSION[summ][$_GET[count]])
					{
						$summ_sk=(floor((($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[proc])/100))/10))*10;
					}
					else
					{
						$summ_sk=round(($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[proc])/100),-1);
					}
				}
				else echo "<option value='".$row[id]."'>".$row[naimenov]." (".$row[proc]."%)</option>";
				
			}
			echo "</select><br />";
			echo "Итого со скидкой: ".$summ_sk." руб.</div>";
			/////конец скидки
					
					
					
					
					if ($_SESSION[QZub]>1)
					{
						$os=0;
						for($i=1;$i<=1;$i++) 
						{
							$os=$os+($_SESSION[summ][$i]);
						}
					echo "<div align='right'>Общая сумма: ".round(($os-($os*$ck)/100),-1)." руб.</div>";				
					}
				  //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
		//		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
		//		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
				}
				else echo "&nbsp";
				echo "<input name='act' type='hidden' value='add' />";
				echo "<input name='step' type='hidden' value='4' />";
				echo "<input name='action' type='hidden' value='Sozd_ZN' />
				  </td>
			  </tr>
			</table>
			</td>
			  </tr>
			</table>";
				echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";
			
			
		//$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
		$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by range, manip";
				//echo $query."<br />";
				include("query.php");
				$cc=0;
				$cm=0;
					for ($i=0;$i<$count;$i++)
					{
						$row = mysql_fetch_array($result);
						if ($row[cat]==1)
						{
							$cc++;
							$cat[$cc][id]=$row[id];
							$cat[$cc][manip]=$row[manip];
							
						}
						else
						{
							$cm++;
							$mat[$cm][id]=$row[id];
							$mat[$cm][manip]=$row[manip];
							$mat[$cm][price]=$row[price];
							$mat[$cm][UpId]=$row[UpId];
						}
					}
					echo "<script language=\"JavaScript\" type=\"text/javascript\">
					document.onclick = clickHandler; 
					</script>";
				for($i=1;$i<=$cc;$i++)
					{
						echo "
					<SPAN id='Out".$i."' class='mmenuHand'>".$cat[$i][manip]."</SPAN><br />
			<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
				<table width='80%' border='0'>
			";
						
						for($j=1;$j<=$cm;$j++)
						{
						
							if ($cat[$i][id]==$mat[$j][UpId])
							echo "<tr>
				<td width='85%'><a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>". $mat[$j][manip]."</a></td>
				<td width='15%'>
				".$mat[$j][price]."
				</td>
			  </tr>";
						} 
						echo "</table></div>";
					}
		
					echo "</form>";
			include("footer.php");
			exit;
		break;

		case "Sozd_SH":	
		if (isset($_GET[type]))
		{
			$_SESSION[type]=$_GET[type];
			$_SESSION[step]=$_GET[step];
		}
			if (isset($_GET[step]))
		{
			$_SESSION[step]=$_GET[step];
		}
		switch ($_SESSION[type])
		{
			/////Миобрейс
			case "myo":
				switch ($_SESSION[step])
				{
					case "1":
						include("footer2.php");
						exit;
					break;
					case "2":
						include("footer2.php");
						exit;
					break;
				}
			break;
			/////трейнер
			case "tr":
				switch ($_SESSION[step])
				{
					case "1":
						include("footer2.php");
						exit;
					break;
					case "2":
						include("footer2.php");
						exit;
					break;
				}
			break;
			/////Брекеты
			case "br":
				switch ($_SESSION[step])
				{
					case "1":
					    $_SESSION[step]=2;
						echo "<form action='' method='get' name='shForm' id='shForm'>";
						echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
			            <div class='head3'>Сотавление схемы оплаты за лечение на брекетах</div>";
						echo "Стоимость аппаратуры: <input name='StApp' type='text' onKeyUp='rassch()'/><br />
							  Срок лечения: <select name='Srok' id='Srok' onChange='rassch()'>";

						for ($i=1;$i<=36;$i++)
						{
							if ($i==1)	echo "<option value='".$i."' selected='selected'>".$i." мес</option>";
							else echo "<option value='".$i."'>".$i." мес</option>";
						}
						echo "</select>";
						echo "<script language='JavaScript' type='text/javascript'>
						function rassch()
						{
							z=Math.floor(
							(
							document.shForm.StApp.value/parseInt
							(
							document.shForm.Srok.options[document.shForm.Srok.selectedIndex].value
							)
							)/100
							)*100;
							document.shForm.PerMonth.value=z;
						}
						</script><br />

						Оплата в месяц: <input name='PerMonth' id='PerMonth' type='text' />";	  
						echo "<br />
						<input name='action' type='hidden' value='Sozd_SH' />
						<input name='' Value='Сохранить' type='Submit'/>";
						echo "</form>";
						include("footer2.php");
						exit;
					break;
					case "2":
						$query = "INSERT INTO `orto_sh` (`id`, `pat`, `sotr`, `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `full`)
												VALUES (NULL, ".$_SESSION[pat].", ".$_SESSION[UserID].",'".date('Y-m-d')."', ".$_GET[Srok].", ".$_GET[StApp].", ".$_GET[PerMonth].", 0, 0)" ;
						//echo $query."<br>";
						include("query.php");
						ret("pat_tooday_orto.php");
						unset($_SESSION[pat]);
						unset($_SESSION[pat_name]);
						unset($_SESSION[step]);
						unset($_SESSION[type]);
						include("footer2.php");
						exit;
					break;
				}
			break;
		}
		if (!(isset($_SESSION[pat]))) $_SESSION[pat]=$_GET[pat];
		$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_SESSION[pat];
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		$_SESSION[pat_name]=$row[0]." ".$row[1]." ".$row[2];
echo "		<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
			<div class='head3'>Выбор аппараптуры: </div>";
			echo "<!--<a href='pat_tooday_work_orto.php?action=Sozd_SH&type=myo&step=1' class='menu2'>Миобрейс</a><br />
";
			echo "<a href='pat_tooday_work_orto.php?action=Sozd_SH&type=tr&step=1' class='menu2'>Трейнер</a><br />-->
";
			echo "<a href='pat_tooday_work_orto.php?action=Sozd_SH&type=br&step=1' class='menu2'>Брекеты</a><br />
";
			include("footer2.php");
			exit;
		break;
	}
include("footer2.php");
exit;

//////////////////////////////////////////////////////////////-------------------------//////////////////////////////////////
if (($_GET[perv]==1) or ($_GET[SodNazn]==4) or ($_GET[action]=="osm"))
{
	////////////////Осмотр
	switch ($_GET[step])
	{
		case "1":
		//////////Шаг 1
				echo "		<div class='head3' >Осмотр пациента</div>
							<a href='pat_tooday_work_orto.php?action=lech&step=1&osmID&pat=".$_SESSION[pat]."' class='menu2'>Пропустить</a>
					<form id='form1' name='form1' method='get' action='pat_tooday_work_orto.php'>
					<input name='action' type='hidden' value='osm' />
					<input name='step' type='hidden' value='2' />
					<input name='perv' type='hidden' value='".$_GET[perv]."' />
					<input name='pat' type='hidden' value='".$_GET[pat]."' />
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td width='24%'>Прикус</td>
				<td width='76%'><select name='prik' id='prik'>";
				$query = "SELECT `vidprik`.*
							FROM vidprik";
				//echo $query."<br>";
				include("query.php");
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "<option value=".$row[id].">".$row[prik]."</option>";
				}
			 echo "    </select>    </td>
			  </tr>
			  <tr>
				<td>Вид АД </td>
				<td><select name='ADVid' id='ADVid'>"; 
				$query = "SELECT `advid`.*
			FROM advid";
				//echo $query."<br>";
				include("query.php");
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);

					echo "<option value=".$row[id].">".$row[vid]."</option>";
				}
			echo "    </select>    </td>
			  </tr>
			  <tr>
				<td>Величина АД </td>
				<td>
				  <select name='ADVelUP' id='ADVelUP'>";
				for ($i=70;$i<300;$i=$i+10)
				{
					if ($i==120) echo "<option value=".$i." selected='selected'>".$i."</option>";
					else echo "<option value=".$i.">".$i."</option>";
				}
			echo "      </select>
				  /
			<select name='ADVelDown' id='ADVelDown'>"; 
			for ($i=50;$i<280;$i=$i+10) 
			{
				if ($i==80) echo "<option value=".$i." selected='selected'>".$i."</option>";
				else echo "<option value=".$i.">".$i."</option>";
			}
			echo "      </select>
				  </td>
			  </tr>
			  <tr>
				<td>Аллергия</td>
				<td>
				  <input name='count' type='hidden' id='count' value='1' />";
			
			$query = "SELECT `allvid`.*
			FROM allvid" ;
			
			//echo $query."<br>";
			include("query.php");
			$countA=$count;
			for ($i=0;$i<$countA;$i++)
			{ 
				echo "<input name='CountAll' type='hidden' value='".($i+1)."' />";
				echo "<select name='AllVid[".$i."]' id='AllVid[".$i."]'>
				 <option value='0'>&nbsp;</option>";
				$query = "SELECT `allvid`.*
				FROM allvid" ;
				//echo $query."<br>";
				include("query.php");
				for ($j=0;$j<$count;$j++)
				{
					$row = mysql_fetch_array($result);	
					echo "<option value=".$row[id].">".$row[vid]."</option>";
				}
				echo "</select>
				   проявление";
				echo "<select name='AllProyav[".$i."]' id='AllProyav[".$i."]' onchange=''>
					  <option value='0'>&nbsp;</option>";
				$query = "SELECT `allproyav`.*
								FROM allproyav" ;
				//echo $query."<br>";
				include("query.php"); 
				for ($j=0;$j<$count;$j++)
				{
							$row = mysql_fetch_array($result);	
							echo "<option value=".$row[id].">".$row[proyav]."</option>";
				}
				echo "</select><br />";
			}
			
			echo "      </td>
			  </tr>
			  <tr>
				<td>Сопутств заболев </td>
				<td>";
			$query = "SELECT `sopzab`.*
			FROM sopzab" ;
			//echo $query."<br>";
			include("query.php");
			for ($i=0;$i<$count;$i++)
			{
						$row = mysql_fetch_array($result);	
						echo "<input name='sopzabID[".$i."]' type='checkbox' value='".$row[id]."'/><label for='sopzabID[".$i."]'>".$row[zab]."</label><br />";
			}
			echo "<input name='countzab' type='hidden' value='".($i+1)."' />";
			
			echo "	</td>
			  </tr>
			</table>
			<input name='ok' type='submit'  value='Дальше>>'/>
					</form>";
		break;
		case "2":
		//////////////Шаг 2
		//////сохранение в медкарте
			$query = "INSERT INTO `medcard` (`id`, `date`, `PatID`, `ADVid`, `ADZnach`, `prik`, `perv`)
									VALUES (NULL,'".date('Y-m-d')."', '".$_GET[pat]."', '".$_GET[ADVid]."', '".$_GET[ADVelUP]."/".$_GET[ADVelDown]."', '".$_GET[prik]."', '".$_GET[perv]."')" ;
			//echo $query."<br>";
			include("query.php");
			$query = "SELECT `medcard`.`id`
						FROM medcard
						WHERE ((`medcard`.`date` ='".date('Y-m-d')."') AND 
						(`medcard`.`PatID` ='".$_GET[pat]."') AND 
						(`medcard`.`ADVid` ='".$_GET[ADVid]."') AND 
						(`medcard`.`ADZnach` ='".$_GET[ADVelUP]."/".$_GET[ADVelDown]."') AND 
						(`medcard`.`prik` ='".$_GET[prik]."') AND 
						(`medcard`.`perv` ='".$_GET[perv]."'))" ;
			//echo $query."<br>";
			include("query.php");
			$row = mysql_fetch_array($result);
			$MCID=$row[id];	
			$f=0;
			$AllVid=$_GET['AllVid'];
			$AllProyav=$_GET['AllProyav'];
			$query = "INSERT INTO `allergmc` (`id`, `MedCardID`, `AllVidID`, `AllProyavID`)
								VALUES ";
			for ($i=0;$i<$_GET[CountAll];$i++)
			{	
				if ($AllVid[$i]!="")
				{
					if ($f==0) $query = $query." (NULL, ".$MCID.",".$AllVid[$i].", ".$AllProyav[$i].") ";
					else $query = $query.", (NULL,'".$MCID."','".$sopzabID[$i]."')";
					$f=1;
					
				}				
			}
			//echo $query."<br>";
			if ($f==1) include("query.php");
			$f=0;
			$sopzabID=$_GET[sopzabID];
			$query = "INSERT INTO `sopzabmc` (`id`, `MedCardID`, `ZabolevID`) 
	VALUES ";	
			for ($i=0;$i<$_GET[countzab];$i++)
			{
				if (isset($sopzabID[$i]))
				{
					if ($f==0) $query = $query." (NULL,'".$MCID."','".$sopzabID[$i]."')";
					else $query = $query.",(NULL,'".$MCID."','".$sopzabID[$i]."')";
					$f=1;
					
				}
				
			}
			//echo $query."<br>";
			if ($f==1) include("query.php");
			$query = "INSERT INTO `osmotr` (`id`, `Date`, `Perv`, `Pat`)
							VALUES(NULL,'".date('Y-m-d')."', '".$_GET[perv]."', '".$_GET[pat]."')" ;
			//echo $query."<br>";
			include("query.php");
			$query = "SELECT `osmotr`.*
						FROM osmotr
						WHERE ((`osmotr`.`Date` ='".date('Y-m-d')."') AND 
						(`osmotr`.`Perv` ='".$_GET[perv]."') AND 
						(`osmotr`.`Pat` ='".$_GET[pat]."'))
						ORDER BY id DESC" ;
			//echo $query."<br>";
			include("query.php");
			$row = mysql_fetch_array($result);
			$_SESSION[OsmID]=$row[id];
			$_SESSION[perv]=$_GET[perv];
			$_SESSION[pat]=$_GET[pat];
			$_SESSION[query]="INSERT INTO `sostzubosm` (`id`, `NZuba`, `SostZuba`, `Osmotr`) 
VALUES ";
			$_SESSION[f]=0;
			echo "<div class='head3' >Заполнение зубной формулы</div>
						<a href='pat_tooday_work_orto.php?action=lech&step=1&osmID&pat=".$_SESSION[pat]."' class='menu2'>Пропустить</a>
			  		<form id='form1' name='form1' method='get' action='pat_tooday_work_orto.php'>
					<input name='action' type='hidden' value='osm' />
					<input name='step' type='hidden' value='3' />
					<input name='ZubN' type='hidden' value='1' />
					<div class='head2'>
					  Зуб № 18					
					  </div>";
$query = "SELECT `sz`.*
FROM sz
ORDER BY `sz`.`sz` ASC" ;
include("query.php");
for ($i=0;$i<$count;$i++)
{
	$row = mysql_fetch_array($result);
	echo "<input name='sz' type='radio' value='".$row[id]."'/>".$row[sz]."<br />";
}
echo "<input name='ok' type='submit'  value='Дальше>>'/></form>";		
		break;
		case "3":
		/////Шаг 3 зубная формула
		if ($_SESSION[f]==0) 
		{
			$_SESSION[query]=$_SESSION[query]." (NULL, ".$_GET[ZubN].", ".$_GET[sz].", ".$_SESSION['OsmID'].")";
			$_SESSION[f]=1;
		}
		else $_SESSION[query]=$_SESSION[query].", (NULL, ".$_GET[ZubN].", ".$_GET[sz].", ".$_SESSION['OsmID'].")";
		//echo $_SESSION[query];
		echo "<div class='head3' >Заполнение зубной формулы</div>
			  		<form id='form1' name='form1' method='get' action='pat_tooday_work_orto.php'>
					<input name='action' type='hidden' value='osm' />";
		if ($_GET[ZubN]==31) echo "<input name='step' type='hidden' value='4' />";
		else echo "<input name='step' type='hidden' value='3' />";		
		
					echo "<input name='ZubN' type='hidden' value='".($_GET[ZubN]+1)."' />
					<div class='head2'>
					  Зуб ";
		$query = "SELECT *
FROM nzuba
WHERE (`nzuba`.`id` ='".($_GET[ZubN]+1)."')" ;
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		echo "№".$row[NZuba];
		echo "
					  </div>";  
	$query = "SELECT `sz`.*
	FROM sz
	ORDER BY `sz`.`sz` ASC" ;
	include("query.php");
	for ($i=0;$i<$count;$i++)
	{
		$row = mysql_fetch_array($result);
		if ($row[id]==10) echo "<input name='sz' type='radio' value='".$row[id]."' checked='checked'/>".$row[sz]."<br />";
		else echo "<input name='sz' type='radio' value='".$row[id]."'/>".$row[sz]."<br />";
	}
	echo "<input name='ok' type='submit'  value='Дальше>>'/></form>";	
		break;
		case "4":
		////Сохранение рузультатов осмтра.
		$query =$_SESSION[query];
		//echo $query."<br>";
		include("query.php");
        echo "<div class='head3' >Осмотр завершён</div>";
		echo "<a href='pat_tooday_work_orto.php?action=lech&step=1&osmID&pat=".$_SESSION[pat]."' class='menu2'>Начать лечение.</a>";
		unset($_SESSION[query]);
		unset($_SESSION[perv]);
		break;
	}	
}
else
{  
///////////////////////Лечение
if ($_GET[action]==lech)
{
 switch ($_GET[step])
 {
 case "1":
 	if (isset($_GET[pat])) $_SESSION[pat]=$_GET[pat];
	if (!(isset($_SESSION[OsmID])))
	{

	     		$query = "SELECT `osmotr`.`id`
						FROM osmotr
						WHERE (`osmotr`.`Pat` ='".$_SESSION[pat]."')
						ORDER BY `osmotr`.`Date` DESC" ;
						//echo $query."<br>";
						include("query.php");
				if ($count>0)
				{
					$row = mysql_fetch_array($result);
					$_SESSION[OsmID]=$row[id];
				}
				else 
				{
					echo "<div class='head1'>Этому пациенту не было произведено ни одного осмотра.</div>
					<a href='pat_tooday_work_orto.php?action=osm&step=1&pat=$_SESSION[pat]&perv=0' class='mmenu'>Провести осмотр</a>";
					$_SESSION[OsmID]=0;
				}
	
	}
		
//Отображение зубной формулы
////Фамилия
	$query = "SELECT `surname`,`name`,`otch` FROM `klinikpat` WHERE `id`='".$_SESSION[pat]."'" ;
	//echo $query."<br>";
	include("query.php");
	$row = mysql_fetch_array($result);
	echo "<div class='head1'>Пациент: ".$row[surname]." ".$row[name]." ".$row[otch]." "."</div>";
	$_SESSION[pat_name]=$row[surname]." ".$row[name]." ".$row[otch];
	//Предупреждение
	$query = "SELECT `allvid`.`vid`, `allproyav`.`proyav`
				FROM medcard, allergmc, allvid, allproyav
				WHERE ((`medcard`.`PatID` ='".$_SESSION[pat]."') AND 
				(`allergmc`.`MedCardID` =`medcard`.`id`) AND 
				(`allvid`.`id` =`allergmc`.`AllVidID` ) AND 
				(`allproyav`.`id` =`allergmc`.`AllProyavID`))" ;
	//echo $query."<br>";
	include("query.php");
	if ($count>0)
	{		
		echo "<div class='feature5'>Упациента аллергия: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo $row[vid]."(".$row[proyav].") ";
		}
	 echo "</div>";
	}
		$query = "SELECT `allvid`.`vid` 
FROM medcard, allergmc, allvid, allproyav
WHERE (
(
`medcard`.`PatID` = '".$_SESSION[pat]."'
)
AND (
`allergmc`.`MedCardID` = `medcard`.`id` 
)
AND (
`allvid`.`id` = `allergmc`.`AllVidID` 
)
AND (
`allergmc`.`AllProyavID` =0
)
)
" ;
	//echo $query."<br>";
	include("query.php");
	if ($count>0)
	{		
		echo "<div class='head2'>Упациента аллергия: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo $row[vid]."  ";
		}
    echo "</div>";
	}
	$query = "SELECT `sopzab`.`zab`
	FROM sopzab, sopzabmc,medcard
	WHERE ((`medcard`.`PatID` ='".$_SESSION[pat]."') AND
	       (`sopzabmc`.`MedCardID` =`medcard`.`id`) AND 
		   (`sopzab`.`id` =`sopzabmc`.`ZabolevID`) )" ;
	//echo $query."<br>";
	include("query.php");
	if ($count>0)
	{		
		echo "<div class='head2'>Сопутствующие заболевания: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo $row[zab]." ";
		}
         echo "</div>";
	}
	$query = "SELECT `advid`.`vid`, `medcard`.`ADZnach`
	FROM advid, medcard
	WHERE ((`advid`.`id` =`medcard`.`ADVid`) AND (`medcard`.`PatID`  ='".$_SESSION[pat]."'))" ;
	//echo $query."<br>";
	include("query.php");
	$row = mysql_fetch_array($result);
	echo "<div class='head2'>АД пациента: ".$row[vid]."(".$row[ADZnach].")</div>";
	echo "		<form  action='pat_tooday_work_orto.php' method='get' >
		<input name='action' type='hidden' value='lech' />
		<input name='step' type='hidden' value='2' />
		  <div class='head2'>Выбирите зуб или зубы </div>";
			echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";
				//Заполняем 10 сегмент
				$query = "SELECT `id` FROM `sostzubosm` WHERE `Osmotr`=".$_SESSION[OsmID] ;
		//echo $query."<br>";
		include("query.php");
				if (($count>0) and ($_SESSION[OsmID]!=0) and ($_SESSION[OsmID]!=""))
				{
				echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
					$query = "SELECT `nzuba`.`NZuba` , `sz`.`id` , `sz`.`obozn` , `sz`.`sz` 
FROM `sostzubosm` , `sz` , `nzuba` 
WHERE (
(
`sostzubosm`.`Osmotr` = '".$_SESSION[OsmID]."'
)
AND (
`sostzubosm`.`NZuba` <=32
)
AND (
`sz`.`id` = `sostzubosm`.`SostZuba` 
)
AND (
`nzuba`.`id` = `sostzubosm`.`NZuba` 
)
)
ORDER BY `sostzubosm`.`NZuba` ASC 

" ;
	//echo $query."<br>";
	include("query.php");
	for ($i=1;$i<=32;$i++)
	{
		$row = mysql_fetch_array($result);
		if (($row[id]==7) or ($row[id]==6)) $z[1][$i]="<input type='checkbox' name='Nzub[".$i."]' value='".$i."'  disabled='disabled'/>";
		else $z[1][$i]="<input type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		if ($row[obozn]=="") $z[2][$i]="&nbsp;";
		else $z[2][$i]=$row[obozn];
		$z[3][$i]=$row[NZuba];
		$z[4][$i]=$row[sz];
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
			}
		 echo "</tr>";
	}
		////20 сегмент
		 echo " </table></td>
                <td bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=1;$i<=3;$i++)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=9;$j<=16;$j++)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
						 echo "</tr>";
					}
				echo "                </table></td>
              </tr>
              <tr>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=32;$j>=25;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>";
		      }
			  //Если формулы нет
			  else
			  {
			  	echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
	$query = "SELECT `id`, `NZuba` FROM `nzuba` ORDER BY `id`" ;
	//echo $query."<br>";
	include("query.php");
	
	for ($i=1;$i<=32;$i++)
	{	
	$row = mysql_fetch_array($result);	
		$z[1][$i]="<input type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		$z[2][$i]="&nbsp;";
		$z[3][$i]=$row[NZuba];
		$z[4][$i]="";
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
			}
		 echo "</tr>";
	}
		////20 сегмент
		 echo " </table></td>
                <td bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=1;$i<=3;$i++)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=9;$j<=16;$j++)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
						 echo "</tr>";
					}
				echo "                </table></td>
              </tr>
              <tr>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=32;$j>=25;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>";
			  }
			  echo "<div align='center'>
		        <input name='Input' type='submit'  value='Дальше>>>'/></div>
		        </form>";
	break;
	case "2":
	///Выбор диагноза
	    $z=$_GET[Nzub];
		echo "	<form  action='pat_tooday_work_orto.php' method='get' >
		<input name='action' type='hidden' value='lech' />
		<input name='step' type='hidden' value='3'/>
		  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>";
			reset($z);
			$_SESSION[QZub]=0;
			while (list($el)=each($z))
	{
				$_SESSION[QZub]=$_SESSION[QZub]+1;
				$query = "SELECT `nzuba`.`NZuba`, `nzuba`.`id`
				FROM nzuba
				WHERE (`nzuba`.`id` ='".$el."')" ;
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$NZub=$row[NZuba];
				$NZubID=$row[id];
				echo " <td align='center'>Зуб №".$NZub."<br />
				<input name='NZub[".$_SESSION[QZub]."]' type='hidden' value='".$NZub."'/>";	
				$query = 'SELECT `ds`.`Nazv`, `ds`.`id`
				FROM ds
				WHERE (`ds`.`Cat` =0)
				ORDER BY `ds`.`KlassID` ASC' ;
				//echo $query.'<br>';
				include('query.php');
				echo "<select name='dsZub[".$NZub."]' size='".$count."' >";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "<option value=".$row[id].">".$row[Nazv]."</option>";
				}
				echo "        </select>
				</td>";
		}
		echo	"</tr>
		  </table>
		<div align='center'>
		<input name='count' type='hidden' value='1' />
		<input name='Input' type='submit'  value='Дальше>>>'/></div>  
		</form>";
	break;
	case "3":
	////////Заполнение карты
	if (!(isset($_SESSION[NZub]))) $_SESSION[NZub]=$_GET[NZub];
	if (!(isset($_SESSION[dsZub]))) $_SESSION[dsZub]=$_GET[dsZub];
	if (isset($_GET[lech])) $_SESSION[lech][$_GET[count]]=$_GET[lech];
	$NZub=$_SESSION[NZub][$_GET[count]];
	//$NZub=$NZub1;
	$dsZub=$_SESSION[dsZub][$NZub];
	if (!(isset($_GET[klishe])))
	{
		$query = "SELECT `id`, `nazv`,`text` FROM `klishe_obk` WHERE `ds`=".$dsZub;
		//echo $query."<br />";
		include("query.php");
		if ($count>0)
		{
			
			if ($count==1)
			{
				$row = mysql_fetch_array($result);
				$klishe=$row[id];
			}
			else
			{
				echo "<div class=\"head2\">Выбирите клише из списка:</div>";
				echo "<form method='get' id='card' name='card'>
	<input name='obk_1' type='hidden' value='".$_GET[count]."' />";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "
					<a href='pat_tooday_work_orto.php?action=lech&step=3&count=".$_GET[count]."&klishe=".$row[id]."' class='menu2'>".$row[nazv]."</a><div class=\"smalltext\">
".stripslashes($row[text])."</div><hr width='100%' noshade='noshade' size='1'/>";
				}
				echo "</form>";
				include("footer.php");
				exit;
			}
		}
		else
		{
			$klishe='N';
		}
	}
	else
	{
		$klishe=$_GET[klishe];
	}
	//$dsZub=$dsZub;
	echo "<form method='get' action='pat_tooday_work_orto.php' id='card' name='card'>
	<input name='count' type='hidden' value='".$_GET[count]."' />
	 <div class='head3'> Пациент:".$_SESSION[pat_name]."</div>";
	echo "<input name='step' type='hidden' value='4'/>
	<input name='action' type='hidden' value='lech'/>";
	echo "<div class='head2'>Диагноз: ";
	$query = "Select Nazv from ds where id=".$dsZub;
	//echo $query."<br />";
	include("query.php");
	$row = mysql_fetch_array($result);
	 echo $NZub."-й зуб, ".$row[Nazv]."</div>
	  <hr width='100%' noshade='noshade' size='1'/>
	  <a href='#' class='niz2' >Пропустить заполнение карты</a><br />
	    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='300' align='right' valign='top'><div class='head2'>Жалобы</div><textarea name='zh_1' id='zh'  cols='40'  rows='2'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td width='' align='left' valign='top'><div class='head2'>Варианты</div>";
	$query = "SELECT `zh`.`zh`, `zh`.`id`
FROM zh, soot_zh
WHERE ((`zh`.`id` =`soot_zh`.`zh`) AND (`soot_zh`.`ds` ='".$dsZub."'))
ORDER BY `zh`.`zh` ASC";
		//echo $query."<br />";
		include("query.php");
		if ($count==0)
		{
			$query = "SELECT `zh`.`zh`, `zh`.`id`
FROM zh
ORDER BY `zh`.`zh` ASC";
include("query.php");
		}
		if ($count>25) echo "<select id='tablefields' name='var_zh' size='1' multiple='multiple' ondblclick='insertValueQuery()' onMouseOver='document.card.var_zh.size=25' onmouseout='document.card.var_zh.size=1'>";
      else echo "<select id='tablefields' name='var_zh' size='1' multiple='multiple' ondblclick= 'insertValueQuery()' onMouseOver='document.card.var_zh.size=".$count."' onmouseout='document.card.var_zh.size=1'>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo "<option value='".$row[zh]."'>".$row[zh]."</option>";
		}
          
		  echo "</select><br />
<input type='button' name='insertzh' value='&lt;&lt;' onclick='insertValueQuery()' title='Вставить' /></td>
  </tr>
  <tr>
    <td height='148' align='right' valign='top'><div class='head2'>Анамнез</div>
        <textarea name='an_1' id='an'  cols='40'  rows='2'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td align='left' valign='top'><div class='head2'>Варианты</div>";
    $query = "SELECT `an`.`an`, `an`.`id`
FROM an, soot_an
WHERE ((`an`.`id` =`soot_an`.`an`) AND (`soot_an`.`ds` ='".$dsZub."'))
ORDER BY `an`.`an` ASC";
	//echo $query."<br />";

	include("query.php");
	if ($count==0)
	{
		$query = "SELECT `an`.`an`, `an`.`id`
FROM an
ORDER BY `an`.`an` ASC";
include("query.php");
	}
	if ($count>25) echo "<select id='tablefields' name='var_an' size='1' multiple='multiple' ondblclick='insertValueQueryan()' onMouseOver='document.card.var_an.size=25' onmouseout='document.card.var_an.size=1'>";
      else echo "<select id='tablefields' name='var_an' size='1' multiple='multiple' ondblclick= 'insertValueQueryan()' onMouseOver='document.card.var_an.size=".$count."' onmouseout='document.card.var_an.size=1'>";

		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo "<option value='".$row[an]."'>".$row[an]."</option>";
		}
          
		  echo "</select>
      <br />
        <input type='button' name='insertan' value='&lt;&lt;' onclick='insertValueQueryan()' title='Вставить' /></td>
  </tr>		  
  <tr>
    <td height='148' align='right' valign='top'><div class='head2'>Объективно</div>";
		
			echo "<textarea name='obk_1' id='obk'  cols='40'  rows='10'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>";
		if ($klishe=='N')
		{
		echo "<td align='left' valign='top'><div class='head2'>Варианты</div>";
					 $query = "SELECT `ob`.`ob`, `ob`.`id`
	FROM ob, soot_ob
	WHERE ((`ob`.`id` =`soot_ob`.`ob`) AND (`soot_ob`.`ds` ='".$dsZub."'))
	ORDER BY `ob`.`ob` ASC";
		//echo $query."<br />";
		include("query.php");
		if ($count==0)
	{
 $query = "SELECT `ob`.`ob`, `ob`.`id`
	FROM ob
	ORDER BY `ob`.`ob` ASC";
include("query.php");
	}
		if ($count>25) echo "<select id='tablefields' name='var_obk' size='1' multiple='multiple' ondblclick='insertValueQueryobk()' onMouseOver='document.card.var_obk.size=25' onmouseout='document.card.var_obk.size=1'>";
		  else echo "<select id='tablefields' name='var_obk' size='1' multiple='multiple' ondblclick= 'insertValueQueryobk()' onMouseOver='document.card.var_obk.size=".$count."' onmouseout='document.card.var_obk.size=1'>";
	
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				echo "<option value='".$row[ob]."'>".$row[ob]."</option>";
			}
			  
			  echo "</select>
	<br />
			<input type='button' name='insertobk' value='&lt;&lt;' onclick='insertValueQueryobk()' title='Вставить' />";	
		echo "</td>";
		}
		else 
		{
			echo "<td align='left' valign='top'><div class='head2'>Варианты</div>";
			$query = "SELECT `nazv`, `function`, `text` FROM `klishe_obk` WHERE `id`=".$klishe;
			//echo $query."<br />";
			include("query.php");
			$row = mysql_fetch_array($result);
				  echo "<script type=\"text/JavaScript\">
				<!--
				function MM_jumpMenu(targ,selObj,restore){
				document.card.obk.value=\"".stripslashes($row['function'])."\"; 
				  if (restore) selObj.selectedIndex=0;
				}
				//-->
				</script>";
				echo stripslashes($row[text]);
				echo "<script type=\"text/JavaScript\">
				<!--
				document.card.obk.value=\"".stripslashes($row['function'])."\"; 
				//-->
				</script>";
				echo "</td>";
		}
  echo "</tr>
</table>
<center><input name='next' type='submit'  value='Дальше>>>'/></center>
</form>";	
	break;
	case "4":
	if (!(isset($_SESSION[zh][$_GET[count]])))$_SESSION[zh][$_GET[count]]=$_GET[zh_1];
	if (!(isset($_SESSION[an][$_GET[count]]))) $_SESSION[an][$_GET[count]]=$_GET[an_1];
	if (!(isset($_SESSION[obk][$_GET[count]]))) $_SESSION[obk][$_GET[count]]=$_GET[obk_1];
	if (!(isset($_GET[preysk]))) 
	{
		
		$query = "SELECT * 
		FROM `preysk` 
		LIMIT 1";
		//echo $query."<br />";
		include("query.php");
		$row = mysql_fetch_array($result);
		$preysk=$row[0];
	}
	else $preysk=$_GET[preysk];
	switch ($_GET[act])
	{
	case "add":
		if (!(isset($_SESSION[countm][$_GET[count]])))
		{
			$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=$_GET[manip]" ;
			//echo $query."<br>";
			include("query.php");
			$row = mysql_fetch_array($result);
			$_SESSION[countm][$_GET[count]]=1;
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][1]=$_GET[manip];
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][2]=1;
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][3]=$row[manip];
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][4]=$row[price];
		}
		else 
		{
			$f=0;
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($_GET[manip]==$_SESSION[chek][$_GET[count]][$i][1])
				{
					$f=1;
					$_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]+1;
				}
			}
			if($f==0)
			{
				$query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=$_GET[manip]" ;
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$_SESSION[countm][$_GET[count]]=$_SESSION[countm][$_GET[count]]+1;
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][1]=$_GET[manip];
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][2]=1;
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][3]=$row[manip];
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][4]=$row[price];
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][5]=$row[zapis];
			}
			
		}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "del":
	if ($_SESSION[countm][$_GET[count]]==1) 
	{
		$_SESSION[countm][$_GET[count]]=0;
	}
	else
	for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
	{
		if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
		{
			for ($j=$i;$j<$_SESSION[countm][$_GET[count]-1];$j++)
			{
				
				$_SESSION[chek][$_GET[count]][$j][1]=$_SESSION[chek][$_GET[count]][$j+1][1];
				$_SESSION[chek][$_GET[count]][$j][2]=$_SESSION[chek][$_GET[count]][$j+1][2];
				$_SESSION[chek][$_GET[count]][$j][3]=$_SESSION[chek][$_GET[count]][$j+1][3];
				$_SESSION[chek][$_GET[count]][$j][4]=$_SESSION[chek][$_GET[count]][$j+1][4];
				$_SESSION[chek][$_GET[count]][$j][5]=$_SESSION[chek][$_GET[count]][$j+1][5];
			}
		$_SESSION[countm][$_GET[count]]=$_SESSION[countm][$_GET[count]]-1;
		$i=$j+1;
		}
	}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "p1":
	for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
	{
		if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
		{
			$_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]+1;
		}
	}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "m1":
	for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
	{
		if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
		{
			if ($_SESSION[chek][$_GET[count]][$i][2]==1)
			{
				msg("Количество манипуляций не может быть меньше одного");
			}
			else $_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]-1;
		}
	}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "chQ":
		if ($_GET[sstep]==1)
		{	
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ(id,qq)
			{
				q=prompt('Введите количество',qq);
				url='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$_GET[preysk]."&id='+id+'&act=chQ&sstep=2&q='+q;
				location.href=url;
			}";
			echo "ChQ('".$_GET[id]."','".$_SESSION[chek][$_GET[count]][$_GET[id]][2]."')</script>";
		}
		else
		{
			$_SESSION[chek][$_GET[count]][$_GET[id]][2]=$_GET[q];
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$_GET[preysk]);
		}
	break;
	case "next":
	if (isset($_SESSION[countm][$_GET[count]]))
		{
					echo "<form id='lechf' name='lechf' method='get' action='pat_tooday_work_orto.php'>
            <label></label>
            Правка лечения:<br />
                  <textarea name='lech' cols='50' rows='7' id='lech'>"; 
			//$query = "SELECT `zapis` FROM `manip` WHERE `id` in (";
//			for($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
//			{
//				if ($i==1) $query = $query."'".$_SESSION[chek][$_GET[count]][$i][1]."'";
//				else $query = $query.",'".$_SESSION[chek][$_GET[count]][$i][1]."'";
//			}
//			$query = $query.")";
//			//echo $query."<br />";
//			include("query.php");
//			for ($i=1;$i<=$count;$i++)
//			{
//				$row = mysql_fetch_array($result);
//				echo $row[zapis]." ";
//			}
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				echo $_SESSION[chek][$_GET[count]][$i][5]." ";
			}
			echo "</textarea>
                  <br />
                  <input type='submit' name='Submit' value='Продолжить' />";
			echo "<input name='action' type='hidden' value='lech' />";
			if ($_GET[count]==$_SESSION[QZub])
			{
			 	echo "<input name='step' type='hidden' value='5' />";
				echo "<input name='count' type='hidden' value='".($_GET[count])."' />";
			}
			else 
			{
				echo "<input name='step' type='hidden' value='3' />";
				echo "<input name='count' type='hidden' value='".($_GET[count]+1)."' />";
			}
            echo "</form>";
			include("footer.php");
	exit;
		}
		else
		{
			msg("Вы не выбрали не одной манипуляции");
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
		}
		

	break;	
	}
	if (!(isset($_GET[preysk]))) $preysk=1;
	else $preysk=$_GET[preysk];
	$NZub=$_SESSION[NZub][$_GET[count]];
	//$NZub=$NZub1;
	$dsZub=$_SESSION[dsZub][$NZub];
	//echo $_SESSION[NZub]." ".$NZub." ".$_SESSION[dsZub]." ".$dsZub." ".$_GET[count];
	//////////Заполнение лечения
	echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='".$_GET[count]."' />
			<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
			<div class='head2'>Диагноз: ";
			
	$query = "Select Nazv from ds where id=".$dsZub;
	//echo $query."<br />";
	include("query.php");
	$row = mysql_fetch_array($result);
	echo $NZub."-й зуб, ".$row[Nazv]."</div>
			<hr width='100%' noshade='noshade' size='1'/>
			<table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>
		<td><center><div class='head2'>Прейскуранты:</div><br />";
		$query = "select * from preysk";
		//echo $query."<br />";
		include("query.php");
for ($i=0;$i<$count;$i++)
{
	$row = mysql_fetch_array($result);
	if ($row[id]==$preysk) echo "|<font color='#42929D'>".$row[preysk]."</font>|";
	else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$row[id]."'>".$row[preysk]."</a>|";
}
		echo " </center></td>
	  </tr>
	  <tr>
		<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>";

		//echo "<td width='60%' align='center' valign='top'>Выбирте манипуляцию: <br />";
		//$query = "select * from manip WHERE preysk=".$preysk." order by manip";
//echo $query."<br />";
//include("query.php");
//
//
//
//
//
//
//
//
//if ($count>15) echo "<select name='manip' size='15'>";
//else echo "<select name='manip' size='".$count."'>";
//if (!($count>0))
//{
//	$N="Название";
//	while (strlen($N)<30) 
//	{
//		$N=$N."_";
//	}
//	$N=$N."Цена";
//	echo "<option value=''>".$N."</option>";
//}
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysql_fetch_array($result);
//	$N=$row[manip];
//	while (strlen($N)<30) 
//	{
//		$N=$N."_";
//	}
//	$N=$N.$row[price]." руб.";
//	echo "<option value='".$row[id]."'>".$N."</option>";
//}
//
//echo "</select>
//		<br />
//	
//		  <input type='submit' name='Submit' value='Добавить в список' />";

		  
		 //echo " </td>";

		echo "<td width='40%' valign='top' align='center'>Счёт:<br /> ";
		
		
		
		
		//echo $_SESSION[countm][$_GET[count]];
		if (isset($_SESSION[countm][$_GET[count]]))
		{
			$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
			for($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($i==1) $query = $query."'".$_SESSION[chek][$_GET[count]][$i][1]."'";
				else $query = $query.",'".$_SESSION[chek][$_GET[count]][$i][1]."'";
			}
			$query = $query.")";
			//echo $query."<br />";
			include("query.php");
//			if ($count>15) echo "<select name='chek' size='15'>";
//			else echo "<select name='chek' size='".$count."'>";
//			$_SESSION[summ][$_GET[count]]=0;
//			for ($i=1;$i<=$count;$i++)
//			{
//				$row = mysql_fetch_array($result);
//				$N=$row[manip];
//				while (strlen($N)<=30) 
//				{
//				$N=$N."_";
//				}
//				$N=$N.$row[price]."*".$_SESSION[chek][$_GET[count]][$i][2]."=".($row[price]*$_SESSION[chek][$_GET[count]][$i][2])."руб.";
//				echo "<option value=".$row[id].">".$N."</option>";
//				$_SESSION[summ][$_GET[count]]=$_SESSION[summ][$_GET[count]]+($row[price]*$_SESSION[chek][$_GET[count]][$i][2]);
//			}
//			echo "</select> <br />";
			echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($_SESSION[summ][$_GET[count]]);
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$_SESSION[chek][$_GET[count]][$i][3]."<br />
				<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&chek=".$_SESSION[chek][$_GET[count]][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
</td>
				<td width='10%' align='center'>".$_SESSION[chek][$_GET[count]][$i][2]."<br />
<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
				<td width='12%' align='center'>".$_SESSION[chek][$_GET[count]][$i][4]." руб.</td>
				<td width='10%' align='center'>".($_SESSION[chek][$_GET[count]][$i][2]*$_SESSION[chek][$_GET[count]][$i][4])." руб.</td>
			  </tr>";
			$_SESSION[summ][$_GET[count]]+=$_SESSION[chek][$_GET[count]][$i][2]*$_SESSION[chek][$_GET[count]][$i][4];	
			} 
			echo "</table>";
			echo "<div align='right'>Итого: ".$_SESSION[summ][$_GET[count]]." руб. </div>";
			
			
//скидка			
			if (!isset($_GET[skidka]))
			{
				if (!isset($_SESSION[skidka]))
				{
					$query = "SELECT  `klinikpat`.`Skidka`,`klinikpat`.`id`
		FROM  klinikpat
		WHERE (`klinikpat`.`id` ='".$_SESSION[pat]."')" ;
		
					////echo $query."<br>"; <a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET[count]."&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>
					include("query.php");
					if ($count>0)
					{
						$row = mysql_fetch_array($result);
						$ck=$row[0];
						
					}
					else
					{
						$ck=0;
					}
					$_SESSION[skidka]=$ck;
				}
				else
				{
					$ck=$_SESSION[skidka];
				}
			}
			else
			{
				$ck=$_GET[skidka];
				$_SESSION[skidka]=$ck;
			}
			//msg($ck);
			$query = "SELECT `id`, `naimenov`, `proc` FROM `skidka` order by `proc`" ;
			//echo $query."<br>";
			include("query.php");
			echo "<div align='right'>
			<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu2(targ,selObj,restore){
  eval(targ+\".location='pat_tooday_work_orto.php?action=lech&step=4&count=".$_GET[count]."&preysk=".$preysk."&skidka=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			Скидка: <select name='skidka' onchange=\"MM_jumpMenu2('parent',this,0)\">";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				if ($ck==$row[proc])
				{
					echo "<option value='".$row[proc]."' selected='selected'>".$row[naimenov]."</option>";
					$_SESSION[proc_sk]=$row[proc];
					if (round(($_SESSION[summ]-($_SESSION[summ]*$ck)/100),-1)==$_SESSION[summ])
					{
						$summ_sk=(floor((($_SESSION[summ]-($_SESSION[summ]*$ck)/100))/10))*10;
					}
					else
					{
						$summ_sk=round(($_SESSION[summ]-($_SESSION[summ]*$ck)/100),-1);
					}
				}
				else echo "<option value='".$row[proc]."'>".$row[naimenov]."</option>";
				
			}
			echo "</select><br />";
			echo "Итого со скидкой: ".$summ_sk." руб.</div>";
			
			
			
			
			//Конец скидки
		  //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
//		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
//		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
		}
		else echo "&nbsp";
		echo "<input name='act' type='hidden' value='add' />";
		echo "<input name='step' type='hidden' value='4' />";
		echo "<input name='action' type='hidden' value='lech' />
		  </td>
	  </tr>
	</table>
	</td>
	  </tr>
	</table>";
		echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";
	
	
//$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by manip";
		//echo $query."<br />";
		include("query.php");
		$cc=0;
		$cm=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				if ($row[cat]==1)
				{
					$cc++;
					$cat[$cc][id]=$row[id];
					$cat[$cc][manip]=$row[manip];
					
				}
				else
				{
					$cm++;
					$mat[$cm][id]=$row[id];
					$mat[$cm][manip]=$row[manip];
					$mat[$cm][price]=$row[price];
					$mat[$cm][UpId]=$row[UpId];
				}
			}
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			document.onclick = clickHandler; 
			</script>";
		for($i=1;$i<=$cc;$i++)
			{
				echo "
			<SPAN id='Out".$i."' class='mmenuHand'>".$cat[$i][manip]."</SPAN><br />
	<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
		<table width='80%' border='0'>
    ";
				
				for($j=1;$j<=$cm;$j++)
				{
				
					if ($cat[$i][id]==$mat[$j][UpId])
					echo "<tr>
        <td width='85%'><a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>". $mat[$j][manip]."</a></td>
        <td width='15%'>
		".$mat[$j][price]."
		</td>
      </tr>";
				} 
				echo "</table></div>";
			}

			echo "</form>";
	include("footer.php");
	exit;
	break;
	case "5":
		$_SESSION[lech][$_GET[count]]=$_GET[lech];
		echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div><hr width='100%' noshade='noshade' size='1'/>";
		echo "Жалобы: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$zh=$_SESSION[NZub][$i]." ".$_SESSION[zh][$i]."<br />";	
		}
		echo $zh."<br />";
		echo "Анамнез: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$an=$_SESSION[NZub][$i]." ".$_SESSION[an][$i]."<br />";	
		}
		echo $an."<br />";
		echo "Объективно: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$obk=$_SESSION[NZub][$i]." ".$_SESSION[obk][$i]."<br />";	
		}
		echo $obk."<br />";
		echo "Диагноз : ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			$NZub=$_SESSION[NZub][$i];
			$dsZub=$_SESSION[dsZub][$NZub];
			$query = "Select Nazv from ds where id=".$dsZub;
			//echo $query."<br />";
			include("query.php");
			$row = mysql_fetch_array($result);
			$ds=$ds.$NZub."-й зуб, ".$row[Nazv]."<br />";
			echo $ds;
		}
		echo "<br />Лечение: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$lech=$_SESSION[NZub][$i]." ".$_SESSION[lech][$i]."<br />";	
		}
		echo $lech."<br />";
		//echo "Итого: ";
		$opl=0;
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{	
			$opl=$opl+$_SESSION[summ][$i];
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			//echo $query."<br>";
			//echo $opl." руб<br />";
			include("query.php");
			if ($count>0)
			{
				$row = mysql_fetch_array($result); 
				//echo "Итого со скидкой: ".(($opl-round(($opl*$row[0])/100)))." руб<br />";
				$ck=$row[proc];
			}
			else
			{
				$ck=0;
			}
		}
		//echo $_SESSION[NZub][$i]." ".$_SESSION[zh][$i]." ".$_SESSION[an][$i]." ".$_SESSION[obk][$i]." ".$_GET[lech].$_SESSION[summ][$i]."<br />";	
		//echo "Всатавка в Дневник<br>";
		$query = "INSERT INTO `dnev` (`id`, `vrach`,`pat`, `date`, `osm`, `ds`, `zh`, `an`, `obk`, `lech`, `resl`,`summ`, `summ_k_opl`, `summ_vnes`)
		VALUES (NULL, '".$_SESSION["UserID"]."','".$_SESSION[pat]."', '".date('Y-m-d')."', '".$_SESSION[OsmID]."', '".addslashes($ds)."', '".addslashes($zh)."', '".addslashes($an)."', '".addslashes($obk)."', '".addslashes($lech)."', 0,'".$opl."','".round((($opl-($opl*$ck)/100)),-1)."',0)" ;
		//echo $query."<br>";
		include("query.php");
		$query = "SELECT id FROM `dnev` WHERE
		( (`pat`='".$_SESSION[pat]."') AND
		(`date`='".date('Y-m-d')."') AND  
		(`vrach`='".$_SESSION["UserID"]."') AND 
		(`osm`='".$_SESSION[OsmID]."') AND 
		(`ds`='".addslashes($ds)."') AND 
		(`zh`='".addslashes($zh)."') AND 
		(`an`='".addslashes($an)."') AND 
		(`obk`='".addslashes($obk)."') AND 
		(`lech`='".addslashes($lech)."') AND 
		(`resl`=0))";
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		$pr=$row[id];
		$query="INSERT INTO `ds_pr` (`id`, `ds`, `pr`,`NZub`) VALUES ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			$NZub=$_SESSION[NZub][$i];
			$dsZub=$_SESSION[dsZub][$NZub];
			if ($i==1) $query=$query."(NULL,'".$dsZub."','".$pr."','".$NZub."')";
			else $query=$query.", (NULL,'".$dsZub."','".$pr."','".$NZub."') ";
		}
		//echo "Всатавка в Диагнозы приёма<br>";
		//echo $query."<br>";
		include("query.php");
//		$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
//		//echo $query."<br>";
//		include("query.php");
//		if ($count>0)
//			{
//				$ck=$row[proc];
//				echo $ck."<br />";
//			}
//		else
//			{
//				$ck=0;
//			}
		//$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
		$c=1;
		//$query = $query."'".$_SESSION[chek][1][1][1]."'";
		$m[$c][1]=$_SESSION[chek][1][1][1];
		$m[$c][2]=0;
		$m[$c][3]+=$_SESSION[chek][1][1][3];
		$m[$c][4]+=$_SESSION[chek][1][1][4];
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				$f=0;
				for ($q=1;$q<=$c;$q++)
				{
					if ($m[$q][1]==$_SESSION[chek][$i][$j][1])
					{
						
						$m[$q][2]+=$_SESSION[chek][$i][$j][2];
						$f=1;
						//echo $m[$q][1]." ".$m[$q][2]."<br />";
					}		
				}
				if ($f==0) 
				{
					//$query = $query.",'".$_SESSION[chek][$i][$j][1]."'";
					$c=$c+1;
					$m[$c][1]=$_SESSION[chek][$i][$j][1];
					$m[$c][2]=$_SESSION[chek][$i][$j][2];
					$m[$c][3]=$_SESSION[chek][$i][$j][3];
					$m[$c][4]=$_SESSION[chek][$i][$j][4];
					//echo $m[$c][1]." ".$m[$c][2]."<br />";
				}				
			}
		}
		//echo "Выбор из манипуляций<br>";
//		$query = $query.") ORDER by id";
//		//echo $query."<br />";
//		include("query.php");
//		for ($i=1;$i<=$count;$i++)
//		{
//			$row = mysql_fetch_array($result);
//			if ($m[$i][1]==$row[id]) 
//			{
//				$m[$i][3]=$row[price];
//				$m[$i][4]=$row[manip];
//			}
//			
//		}
//		
		$query = "INSERT INTO `manip_pr` (`id`, `NZuba`, `manip`, `kolvo`, `dnev`) VALUES";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			$NZub=$_SESSION[NZub][$i];
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				if ($j==1)$query.="(NULL,'".$NZub."','".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
				else $query.=",(NULL,'".$NZub."','".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
			}
		}
		//echo "Вставка в Манипуляции при приёме<br>";
		//echo $query."<br>";
		
		include("query.php");
		$query = "SELECT `id`, `mater`,`manip`, `mesto_hr` FROM `mater_avto_spis` WHERE `manip`in ( ";
		$s=0;
		for ($i=1;$i<=$c;$i++)
		{
			if ($i==1) $query.=$m[$i][1];
			else $query.=", ".$m[$i][1];
		}
		$query.=")";
		$ssk=($s-round($s*($ck/100)));		
		//echo $query."<br />";
		include("query.php");
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			for ($j=1;$j<=$c;$j++)
			{
				if ($m[$j][1]==$row[manip])
				$query = "UPDATE `ost_mat`
				SET `ost`=`ost`-'".$m[$j][2]."'
				WHERE ((`mater`='".$row[mater]."') and
						(`mesto_hr`='".$row[mesto_hr]."'))";
				//echo $query."<br />";
				include("query.php");
			}
		}
		echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($s);
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$m[$i][3]."</td>
				<td width='10%' align='center'>".$m[$i][2]."</td>
				<td width='12%' align='center'>".$m[$i][4]." руб.</td>
				<td width='10%' align='center'>".($m[$i][2]*$m[$i][4])." руб.</td>
			  </tr>";
			  $s+=$m[$i][2]*$m[$i][4];
			} 
			
				
			echo "</table>";
			echo "<div align='right'>Итого: ".$s." руб. </div>";
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			//echo $query."<br>";
			include("query.php");
			if ($count>0)
			{
				$row = mysql_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".
				round(($s-($s*$row[0])/100),-1)." руб.</div>";
			}
//		$query = "INSERT INTO `oplata` (`id`, `dnev`, `stoim`, `soimSoSk`, `vnes`, `dolg`, `VidOpl`) VALUES (NULL,'".$pr."','".$s."','".$ssk."',0,'".$ssk."',1)" ;
//		//echo "Всатавка в Оплату<br>";
//		//echo $query."<br>";
//		include("query.php");
//	break;
	echo "<a href='print.php?type=pat&card=".$pr."' target='_blank' class='mmenu'>Печать карты</a><br />"
;
	echo "<a href='pat_tooday.php'class='mmenu'>Закрыть</a>";
	unset($_SESSION[chek]);
	unset($_SESSION[countm]);
	unset($_SESSION[NZub]);
	unset($_SESSION[dsZub]);
	unset($_SESSION[QZub]);
	unset($_SESSION[pat]);
	unset($_SESSION[pat_name]);
	unset($_SESSION[zh]);
	unset($_SESSION[obk]);
	unset($_SESSION[lech]);
	unset($_SESSION[an]);
	unset($_SESSION[OsmID]);
	unset($_SESSION[summ]);	
	}
}
		
	if (($_GET[action]!="lech"))
	{
		echo "<script language='JavaScript' type='text/javascript'>
		location.href='pat_tooday_work_orto.php?action=lech&perv=0&step=1&pat=".$_GET[pat]."';
		</script>";
	}
}

////////////Лечение зуба
include("footer2.php");
?> <?php
$ThisVU="all";
$ModName="Работа спациентом";
$js="insert";
include("header2.php");
	 switch ($_GET[action])
	{
		case "Sozd_ZN":
//			if (!(isset($_GET[preysk]))) 
//			{	
//				$query = "SELECT * 
//				FROM `preysk` 
//				LIMIT 1";
//				//echo $query."<br />";
//				include("query.php");
//				$row = mysql_fetch_array($result);
//				$preysk=$row[0];
//			}
//			else $preysk=$_GET[preysk];
 			$preysk=4;
			switch ($_GET[act])
			{
			case "add":
				if (!(isset($_SESSION[countm][$_GET[count]])))
				{
					$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=".$_GET[manip] ;
					//echo $query."<br>";
					include("query.php");
					$row = mysql_fetch_array($result);
					$_SESSION[countm][$_GET[count]]=1;
					$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][1]=$_GET[manip];
					$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][2]=1;
					$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][3]=$row[manip];
					$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][4]=$row[price];
				}
				else 
				{
					$f=0;
					for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
					{
						if ($_GET[manip]==$_SESSION[chek][$_GET[count]][$i][1])
						{
							$f=1;
							$_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]+1;
						}
					}
					if($f==0)
					{
						$query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=".$_GET[manip] ;
						//echo $query."<br>";
						include("query.php");
						$row = mysql_fetch_array($result);
						$_SESSION[countm][$_GET[count]]=$_SESSION[countm][$_GET[count]]+1;
						$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][1]=$_GET[manip];
						$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][2]=1;
						$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][3]=$row[manip];
						$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][4]=$row[price];
						$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][5]=$row[zapis];
					}
					
				}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
			break;
			case "del":
			if ($_SESSION[countm][$_GET[count]]==1) 
			{
				$_SESSION[countm][$_GET[count]]=0;
			}
			else
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
				{
					for ($j=$i;$j<$_SESSION[countm][$_GET[count]-1];$j++)
					{
						
						$_SESSION[chek][$_GET[count]][$j][1]=$_SESSION[chek][$_GET[count]][$j+1][1];
						$_SESSION[chek][$_GET[count]][$j][2]=$_SESSION[chek][$_GET[count]][$j+1][2];
						$_SESSION[chek][$_GET[count]][$j][3]=$_SESSION[chek][$_GET[count]][$j+1][3];
						$_SESSION[chek][$_GET[count]][$j][4]=$_SESSION[chek][$_GET[count]][$j+1][4];
						$_SESSION[chek][$_GET[count]][$j][5]=$_SESSION[chek][$_GET[count]][$j+1][5];
					}
				$_SESSION[countm][$_GET[count]]=$_SESSION[countm][$_GET[count]]-1;
				$i=$j+1;
				}
			}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
			break;
			case "p1":
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
				{
					$_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]+1;
				}
			}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
			break;
			case "m1":
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
				{
					if ($_SESSION[chek][$_GET[count]][$i][2]==1)
					{
						msg("Количество манипуляций не может быть меньше одного");
					}
					else $_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]-1;
				}
			}
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
			break;
			case "chQ":
				if ($_GET[sstep]==1)
				{	
					echo "<script language=\"JavaScript\" type=\"text/javascript\">
					function ChQ(id,qq)
					{
						q=prompt('Введите количество',qq);
						url='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$_GET[preysk]."&id='+id+'&act=chQ&sstep=2&q='+q;
						location.href=url;
					}";
					echo "ChQ('".$_GET[id]."','".$_SESSION[chek][$_GET[count]][$_GET[id]][2]."')</script>";
				}
				else
				{
					$_SESSION[chek][$_GET[count]][$_GET[id]][2]=$_GET[q];
					ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$_GET[preysk]);
				}
			break;
			case "next":
			if (isset($_SESSION[countm][$_GET[count]]))
				{
				ret("pat_tooday_work_orto.php?action=lech&step=5&count=".$_GET[count]);
				exit;
							echo "<form id='lechf' name='lechf' method='get' action='pat_tooday_work_orto.php'>
					<label></label>
					Правка лечения:<br />
						  <textarea name='lech' cols='50' rows='7' id='lech'>"; 
					//$query = "SELECT `zapis` FROM `manip` WHERE `id` in (";
		//			for($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
		//			{
		//				if ($i==1) $query = $query."'".$_SESSION[chek][$_GET[count]][$i][1]."'";
		//				else $query = $query.",'".$_SESSION[chek][$_GET[count]][$i][1]."'";
		//			}
		//			$query = $query.")";
		//			//echo $query."<br />";
		//			include("query.php");
		//			for ($i=1;$i<=$count;$i++)
		//			{
		//				$row = mysql_fetch_array($result);
		//				echo $row[zapis]." ";
		//			}
					for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
					{
						echo $_SESSION[chek][$_GET[count]][$i][5]." ";
					}
					echo "</textarea>
						  <br />
						  <input type='submit' name='Submit' value='Продолжить' />";
					echo "<input name='action' type='hidden' value='lech' />";
						echo "<input name='step' type='hidden' value='5' />";
						echo "<input name='count' type='hidden' value='".($_GET[count])."' />";
					echo "</form>";
					include("footer.php");
			exit;
				}
				else
				{
					msg("Вы не выбрали не одной манипуляции");
					ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
				}
				
		
			break;	
			}
			if (!(isset($_GET[preysk]))) $preysk=4;
			else $preysk=$_GET[preysk];
			if (!(isset($_SESSION[pat]))) $_SESSION[pat]=$_GET[pat];
			//////////Заполнение лечения
			echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='1' />";
				$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_SESSION[pat];
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$_SESSION[pat_name]=$row[0]." ".$row[1]." ".$row[2];
			echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
					<hr width='100%' noshade='noshade' size='1'/>
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td><!--<center><div class='head2'>Прейскуранты:</div><br />";
				$query = "select * from preysk";
				//echo $query."<br />";
				include("query.php");
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			if ($row[id]==$preysk) echo "|<font color='#42929D'>".$row[preysk]."</font>|";
			else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$row[id]."'>".$row[preysk]."</a>|";
		}
				echo " </center>--></td>
			  </tr>
			  <tr>
				<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>";
		
				//echo "<td width='60%' align='center' valign='top'>Выбирте манипуляцию: <br />";
				//$query = "select * from manip WHERE preysk=".$preysk." order by manip";
		//echo $query."<br />";
		//include("query.php");
		//
		//
		//
		//
		//
		//
		//
		//
		//if ($count>15) echo "<select name='manip' size='15'>";
		//else echo "<select name='manip' size='".$count."'>";
		//if (!($count>0))
		//{
		//	$N="Название";
		//	while (strlen($N)<30) 
		//	{
		//		$N=$N."_";
		//	}
		//	$N=$N."Цена";
		//	echo "<option value=''>".$N."</option>";
		//}
		//for ($i=0;$i<$count;$i++)
		//{
		//	$row = mysql_fetch_array($result);
		//	$N=$row[manip];
		//	while (strlen($N)<30) 
		//	{
		//		$N=$N."_";
		//	}
		//	$N=$N.$row[price]." руб.";
		//	echo "<option value='".$row[id]."'>".$N."</option>";
		//}
		//
		//echo "</select>
		//		<br />
		//	
		//		  <input type='submit' name='Submit' value='Добавить в список' />";
		
				  
				 //echo " </td>";
		
				echo "<td width='40%' valign='top' align='center'>Счёт:<br /> ";
				
				
				
				
				//echo $_SESSION[countm][$_GET[count]];
				if ($_SESSION[countm][$_GET[count]]>0)
				{
		//			$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
		//			for($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
		//			{
		//				if ($i==1) $query = $query."'".$_SESSION[chek][$_GET[count]][$i][1]."'";
		//				else $query = $query.",'".$_SESSION[chek][$_GET[count]][$i][1]."'";
		//			}
		//			$query = $query.")";
		//			//echo $query."<br />";
		//			include("query.php");
		//			if ($count>15) echo "<select name='chek' size='15'>";
		//			else echo "<select name='chek' size='".$count."'>";
		//			$_SESSION[summ][$_GET[count]]=0;
		//			for ($i=1;$i<=$count;$i++)
		//			{
		//				$row = mysql_fetch_array($result);
		//				$N=$row[manip];
		//				while (strlen($N)<=30) 
		//				{
		//				$N=$N."_";
		//				}
		//				$N=$N.$row[price]."*".$_SESSION[chek][$_GET[count]][$i][2]."=".($row[price]*$_SESSION[chek][$_GET[count]][$i][2])."руб.";
		//				echo "<option value=".$row[id].">".$N."</option>";
		//				$_SESSION[summ][$_GET[count]]=$_SESSION[summ][$_GET[count]]+($row[price]*$_SESSION[chek][$_GET[count]][$i][2]);
		//			}
		//			echo "</select> <br />";
					echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='6%'><div align='center' class='feature3'>№</div></td>
						<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='17%'><div align='center' class='feature3'>Количество</div></td>
						<td width='12%'><div align='center' class='feature3'>Цена</div></td>
						<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
					unset($_SESSION[summ][$_GET[count]]);
					for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
					{
						echo "  <tr>
						<td width='6%' align='center'>".$i."</td>
						<td width='62%' align='left'>".$_SESSION[chek][$_GET[count]][$i][3]."<br />
						<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&chek=".$_SESSION[chek][$_GET[count]][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
		</td>
						<td width='10%' align='center'>".$_SESSION[chek][$_GET[count]][$i][2]."<br />
		<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
						<td width='12%' align='center'>".$_SESSION[chek][$_GET[count]][$i][4]." руб.</td>
						<td width='10%' align='center'>".($_SESSION[chek][$_GET[count]][$i][2]*$_SESSION[chek][$_GET[count]][$i][4])." руб.</td>
					  </tr>";
					$_SESSION[summ][$_GET[count]]+=$_SESSION[chek][$_GET[count]][$i][2]*$_SESSION[chek][$_GET[count]][$i][4];	
					} 
					echo "</table>";
					echo "<div align='right'>Итого: ".$_SESSION[summ][$_GET[count]]." руб. </div>";

//скидка
if (!isset($_GET[skidka]))
			{
				if (!isset($_SESSION[skidka]))
				{
					$query = "SELECT  `klinikpat`.`Skidka`,`klinikpat`.`id`
		FROM  klinikpat
		WHERE (`klinikpat`.`id` ='".$_SESSION[pat]."')" ;
		
					////echo $query."<br>"; <a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET[count]."&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>
					include("query.php");
					if ($count>0)
					{
						$row = mysql_fetch_array($result);
						$ck=$row[0];
						
					}
					else
					{
						$ck=0;
					}
					$_SESSION[skidka]=$ck;
				}
				else
				{
					$ck=$_SESSION[skidka];
				}
			}
			else
			{
				$ck=$_GET[skidka];
				$_SESSION[skidka]=$ck;
			}
			//msg($ck);
			$query = "SELECT `id`, `naimenov`, `proc` FROM `skidka` order by `proc`" ;
			//echo $query."<br>";
			include("query.php");
			echo "<div align='right'>
			<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu2(targ,selObj,restore){
  eval(targ+\".location='pat_tooday_work_orto.php?action=lech&step=4&count=".$_GET[count]."&preysk=".$preysk."&skidka=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			Скидка: <select name='skidka' onchange=\"MM_jumpMenu2('parent',this,0)\">";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				if ($ck==$row[proc])
				{
					echo "<option value='".$row[proc]."' selected='selected'>".$row[naimenov]."</option>";
					$_SESSION[proc_sk]=$row[proc];
					if (round(($_SESSION[summ]-($_SESSION[summ]*$ck)/100),-1)==$_SESSION[summ])
					{
						$summ_sk=(floor((($_SESSION[summ]-($_SESSION[summ]*$ck)/100))/10))*10;
					}
					else
					{
						$summ_sk=round(($_SESSION[summ]-($_SESSION[summ]*$ck)/100),-1);
					}
				}
				else echo "<option value='".$row[proc]."'>".$row[naimenov]."</option>";
				
			}
			echo "</select><br />";
			echo "Итого со скидкой: ".$summ_sk." руб.</div>";
			//скидка
				  //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
		//		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
		//		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
				}
				else echo "&nbsp";
				echo "<input name='act' type='hidden' value='add' />";
				echo "<input name='step' type='hidden' value='4' />";
				echo "<input name='action' type='hidden' value='lech' />
				  </td>
			  </tr>
			</table>
			</td>
			  </tr>
			</table>";
				echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";
			
			
		//$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
		$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by range, manip";
				//echo $query."<br />";
				include("query.php");
				$cc=0;
				$cm=0;
					for ($i=0;$i<$count;$i++)
					{
						$row = mysql_fetch_array($result);
						if ($row[cat]==1)
						{
							$cc++;
							$cat[$cc][id]=$row[id];
							$cat[$cc][manip]=$row[manip];
							
						}
						else
						{
							$cm++;
							$mat[$cm][id]=$row[id];
							$mat[$cm][manip]=$row[manip];
							$mat[$cm][price]=$row[price];
							$mat[$cm][UpId]=$row[UpId];
						}
					}
					echo "<script language=\"JavaScript\" type=\"text/javascript\">
					document.onclick = clickHandler; 
					</script>";
				for($i=1;$i<=$cc;$i++)
					{
						echo "
					<SPAN id='Out".$i."' class='mmenuHand'>".$cat[$i][manip]."</SPAN><br />
			<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
				<table width='80%' border='0'>
			";
						
						for($j=1;$j<=$cm;$j++)
						{
						
							if ($cat[$i][id]==$mat[$j][UpId])
							echo "<tr>
				<td width='85%'><a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>". $mat[$j][manip]."</a></td>
				<td width='15%'>
				".$mat[$j][price]."
				</td>
			  </tr>";
						} 
						echo "</table></div>";
					}
		
					echo "</form>";
			include("footer.php");
			exit;
		break;
		case "Sozd_SH":
			
		break;
	}
exit;
include("footer2.php");
//////////////////////////////////////////////////////////////-------------------------//////////////////////////////////////
if (($_GET[perv]==1) or ($_GET[SodNazn]==4) or ($_GET[action]=="osm"))
{
	////////////////Осмотр
	switch ($_GET[step])
	{
		case "1":
		//////////Шаг 1
				echo "		<div class='head3' >Осмотр пациента</div>
							<a href='pat_tooday_work_orto.php?action=lech&step=1&osmID&pat=".$_SESSION[pat]."' class='menu2'>Пропустить</a>
					<form id='form1' name='form1' method='get' action='pat_tooday_work_orto.php'>
					<input name='action' type='hidden' value='osm' />
					<input name='step' type='hidden' value='2' />
					<input name='perv' type='hidden' value='".$_GET[perv]."' />
					<input name='pat' type='hidden' value='".$_GET[pat]."' />
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td width='24%'>Прикус</td>
				<td width='76%'><select name='prik' id='prik'>";
				$query = "SELECT `vidprik`.*
							FROM vidprik";
				//echo $query."<br>";
				include("query.php");
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "<option value=".$row[id].">".$row[prik]."</option>";
				}
			 echo "    </select>    </td>
			  </tr>
			  <tr>
				<td>Вид АД </td>
				<td><select name='ADVid' id='ADVid'>"; 
				$query = "SELECT `advid`.*
			FROM advid";
				//echo $query."<br>";
				include("query.php");
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "<option value=".$row[id].">".$row[vid]."</option>";
				}
			echo "    </select>    </td>
			  </tr>
			  <tr>
				<td>Величина АД </td>
				<td>
				  <select name='ADVelUP' id='ADVelUP'>";
				for ($i=70;$i<300;$i=$i+10)
				{
					if ($i==120) echo "<option value=".$i." selected='selected'>".$i."</option>";
					else echo "<option value=".$i.">".$i."</option>";
				}
			echo "      </select>
				  /
			<select name='ADVelDown' id='ADVelDown'>"; 
			for ($i=50;$i<280;$i=$i+10) 
			{
				if ($i==80) echo "<option value=".$i." selected='selected'>".$i."</option>";
				else echo "<option value=".$i.">".$i."</option>";
			}
			echo "      </select>
				  </td>
			  </tr>
			  <tr>
				<td>Аллергия</td>
				<td>
				  <input name='count' type='hidden' id='count' value='1' />";
			
			$query = "SELECT `allvid`.*
			FROM allvid" ;
			
			//echo $query."<br>";
			include("query.php");
			$countA=$count;
			for ($i=0;$i<$countA;$i++)
			{ 
				echo "<input name='CountAll' type='hidden' value='".($i+1)."' />";
				echo "<select name='AllVid[".$i."]' id='AllVid[".$i."]'>
				 <option value='0'>&nbsp;</option>";
				$query = "SELECT `allvid`.*
				FROM allvid" ;
				//echo $query."<br>";
				include("query.php");
				for ($j=0;$j<$count;$j++)
				{
					$row = mysql_fetch_array($result);	
					echo "<option value=".$row[id].">".$row[vid]."</option>";
				}
				echo "</select>
				   проявление";
				echo "<select name='AllProyav[".$i."]' id='AllProyav[".$i."]' onchange=''>
					  <option value='0'>&nbsp;</option>";
				$query = "SELECT `allproyav`.*
								FROM allproyav" ;
				//echo $query."<br>";
				include("query.php"); 
				for ($j=0;$j<$count;$j++)
				{
							$row = mysql_fetch_array($result);	
							echo "<option value=".$row[id].">".$row[proyav]."</option>";
				}
				echo "</select><br />";
			}
			
			echo "      </td>
			  </tr>
			  <tr>
				<td>Сопутств заболев </td>
				<td>";
			$query = "SELECT `sopzab`.*
			FROM sopzab" ;
			//echo $query."<br>";
			include("query.php");
			for ($i=0;$i<$count;$i++)
			{
						$row = mysql_fetch_array($result);	
						echo "<input name='sopzabID[".$i."]' type='checkbox' value='".$row[id]."'/><label for='sopzabID[".$i."]'>".$row[zab]."</label><br />";
			}
			echo "<input name='countzab' type='hidden' value='".($i+1)."' />";
			
			echo "	</td>
			  </tr>
			</table>
			<input name='ok' type='submit'  value='Дальше>>'/>
					</form>";
		break;
		case "2":
		//////////////Шаг 2
		//////сохранение в медкарте
			$query = "INSERT INTO `medcard` (`id`, `date`, `PatID`, `ADVid`, `ADZnach`, `prik`, `perv`)
									VALUES (NULL,'".date('Y-m-d')."', '".$_GET[pat]."', '".$_GET[ADVid]."', '".$_GET[ADVelUP]."/".$_GET[ADVelDown]."', '".$_GET[prik]."', '".$_GET[perv]."')" ;
			//echo $query."<br>";
			include("query.php");
			$query = "SELECT `medcard`.`id`
						FROM medcard
						WHERE ((`medcard`.`date` ='".date('Y-m-d')."') AND 
						(`medcard`.`PatID` ='".$_GET[pat]."') AND 
						(`medcard`.`ADVid` ='".$_GET[ADVid]."') AND 
						(`medcard`.`ADZnach` ='".$_GET[ADVelUP]."/".$_GET[ADVelDown]."') AND 
						(`medcard`.`prik` ='".$_GET[prik]."') AND 
						(`medcard`.`perv` ='".$_GET[perv]."'))" ;
			//echo $query."<br>";
			include("query.php");
			$row = mysql_fetch_array($result);
			$MCID=$row[id];	
			$f=0;
			$AllVid=$_GET['AllVid'];
			$AllProyav=$_GET['AllProyav'];
			$query = "INSERT INTO `allergmc` (`id`, `MedCardID`, `AllVidID`, `AllProyavID`)
								VALUES ";
			for ($i=0;$i<$_GET[CountAll];$i++)
			{	
				if ($AllVid[$i]!="")
				{
					if ($f==0) $query = $query." (NULL, ".$MCID.",".$AllVid[$i].", ".$AllProyav[$i].") ";
					else $query = $query.", (NULL,'".$MCID."','".$sopzabID[$i]."')";
					$f=1;
					
				}				
			}
			//echo $query."<br>";
			if ($f==1) include("query.php");
			$f=0;
			$sopzabID=$_GET[sopzabID];
			$query = "INSERT INTO `sopzabmc` (`id`, `MedCardID`, `ZabolevID`) 
	VALUES ";	
			for ($i=0;$i<$_GET[countzab];$i++)
			{
				if (isset($sopzabID[$i]))
				{
					if ($f==0) $query = $query." (NULL,'".$MCID."','".$sopzabID[$i]."')";
					else $query = $query.",(NULL,'".$MCID."','".$sopzabID[$i]."')";
					$f=1;
					
				}
				
			}
			//echo $query."<br>";
			if ($f==1) include("query.php");
			$query = "INSERT INTO `osmotr` (`id`, `Date`, `Perv`, `Pat`)
							VALUES(NULL,'".date('Y-m-d')."', '".$_GET[perv]."', '".$_GET[pat]."')" ;
			//echo $query."<br>";
			include("query.php");
			$query = "SELECT `osmotr`.*
						FROM osmotr
						WHERE ((`osmotr`.`Date` ='".date('Y-m-d')."') AND 
						(`osmotr`.`Perv` ='".$_GET[perv]."') AND 
						(`osmotr`.`Pat` ='".$_GET[pat]."'))
						ORDER BY id DESC" ;
			//echo $query."<br>";

			include("query.php");
			$row = mysql_fetch_array($result);
			$_SESSION[OsmID]=$row[id];
			$_SESSION[perv]=$_GET[perv];
			$_SESSION[pat]=$_GET[pat];
			$_SESSION[query]="INSERT INTO `sostzubosm` (`id`, `NZuba`, `SostZuba`, `Osmotr`) 
VALUES ";
			$_SESSION[f]=0;
			echo "<div class='head3' >Заполнение зубной формулы</div>
						<a href='pat_tooday_work_orto.php?action=lech&step=1&osmID&pat=".$_SESSION[pat]."' class='menu2'>Пропустить</a>
			  		<form id='form1' name='form1' method='get' action='pat_tooday_work_orto.php'>
					<input name='action' type='hidden' value='osm' />
					<input name='step' type='hidden' value='3' />
					<input name='ZubN' type='hidden' value='1' />
					<div class='head2'>
					  Зуб № 18					
					  </div>";
$query = "SELECT `sz`.*
FROM sz
ORDER BY `sz`.`sz` ASC" ;
include("query.php");
for ($i=0;$i<$count;$i++)
{
	$row = mysql_fetch_array($result);
	echo "<input name='sz' type='radio' value='".$row[id]."'/>".$row[sz]."<br />";
}
echo "<input name='ok' type='submit'  value='Дальше>>'/></form>";		
		break;
		case "3":
		/////Шаг 3 зубная формула
		if ($_SESSION[f]==0) 
		{
			$_SESSION[query]=$_SESSION[query]." (NULL, ".$_GET[ZubN].", ".$_GET[sz].", ".$_SESSION['OsmID'].")";
			$_SESSION[f]=1;
		}
		else $_SESSION[query]=$_SESSION[query].", (NULL, ".$_GET[ZubN].", ".$_GET[sz].", ".$_SESSION['OsmID'].")";
		//echo $_SESSION[query];
		echo "<div class='head3' >Заполнение зубной формулы</div>
			  		<form id='form1' name='form1' method='get' action='pat_tooday_work_orto.php'>
					<input name='action' type='hidden' value='osm' />";
		if ($_GET[ZubN]==31) echo "<input name='step' type='hidden' value='4' />";
		else echo "<input name='step' type='hidden' value='3' />";		
		
					echo "<input name='ZubN' type='hidden' value='".($_GET[ZubN]+1)."' />
					<div class='head2'>
					  Зуб ";
		$query = "SELECT *
FROM nzuba
WHERE (`nzuba`.`id` ='".($_GET[ZubN]+1)."')" ;
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		echo "№".$row[NZuba];
		echo "
					  </div>";  
	$query = "SELECT `sz`.*
	FROM sz
	ORDER BY `sz`.`sz` ASC" ;
	include("query.php");
	for ($i=0;$i<$count;$i++)
	{
		$row = mysql_fetch_array($result);
		if ($row[id]==10) echo "<input name='sz' type='radio' value='".$row[id]."' checked='checked'/>".$row[sz]."<br />";
		else echo "<input name='sz' type='radio' value='".$row[id]."'/>".$row[sz]."<br />";
	}
	echo "<input name='ok' type='submit'  value='Дальше>>'/></form>";	
		break;
		case "4":
		////Сохранение рузультатов осмтра.
		$query =$_SESSION[query];
		//echo $query."<br>";
		include("query.php");
        echo "<div class='head3' >Осмотр завершён</div>";
		echo "<a href='pat_tooday_work_orto.php?action=lech&step=1&osmID&pat=".$_SESSION[pat]."' class='menu2'>Начать лечение.</a>";
		unset($_SESSION[query]);
		unset($_SESSION[perv]);
		break;
	}	
}
else
{  
///////////////////////Лечение
if ($_GET[action]==lech)
{
 switch ($_GET[step])
 {
 case "1":
 	if (isset($_GET[pat])) $_SESSION[pat]=$_GET[pat];
	if (!(isset($_SESSION[OsmID])))
	{

	     		$query = "SELECT `osmotr`.`id`
						FROM osmotr
						WHERE (`osmotr`.`Pat` ='".$_SESSION[pat]."')
						ORDER BY `osmotr`.`Date` DESC" ;
						//echo $query."<br>";
						include("query.php");
				if ($count>0)
				{
					$row = mysql_fetch_array($result);
					$_SESSION[OsmID]=$row[id];
				}
				else 
				{
					echo "<div class='head1'>Этому пациенту не было произведено ни одного осмотра.</div>
					<a href='pat_tooday_work_orto.php?action=osm&step=1&pat=$_SESSION[pat]&perv=0' class='mmenu'>Провести осмотр</a>";
					$_SESSION[OsmID]=0;
				}
	
	}
		
//Отображение зубной формулы
////Фамилия
	$query = "SELECT `surname`,`name`,`otch` FROM `klinikpat` WHERE `id`='".$_SESSION[pat]."'" ;
	//echo $query."<br>";
	include("query.php");
	$row = mysql_fetch_array($result);
	echo "<div class='head1'>Пациент: ".$row[surname]." ".$row[name]." ".$row[otch]." "."</div>";
	$_SESSION[pat_name]=$row[surname]." ".$row[name]." ".$row[otch];
	//Предупреждение
	$query = "SELECT `allvid`.`vid`, `allproyav`.`proyav`
				FROM medcard, allergmc, allvid, allproyav
				WHERE ((`medcard`.`PatID` ='".$_SESSION[pat]."') AND 
				(`allergmc`.`MedCardID` =`medcard`.`id`) AND 
				(`allvid`.`id` =`allergmc`.`AllVidID` ) AND 
				(`allproyav`.`id` =`allergmc`.`AllProyavID`))" ;
	//echo $query."<br>";
	include("query.php");
	if ($count>0)
	{		
		echo "<div class='feature5'>Упациента аллергия: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo $row[vid]."(".$row[proyav].") ";
		}
	 echo "</div>";
	}
		$query = "SELECT `allvid`.`vid` 
FROM medcard, allergmc, allvid, allproyav
WHERE (
(
`medcard`.`PatID` = '".$_SESSION[pat]."'
)
AND (
`allergmc`.`MedCardID` = `medcard`.`id` 
)
AND (
`allvid`.`id` = `allergmc`.`AllVidID` 
)
AND (
`allergmc`.`AllProyavID` =0
)
)
" ;
	//echo $query."<br>";
	include("query.php");
	if ($count>0)
	{		
		echo "<div class='head2'>Упациента аллергия: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo $row[vid]."  ";
		}
    echo "</div>";
	}
	$query = "SELECT `sopzab`.`zab`
	FROM sopzab, sopzabmc,medcard
	WHERE ((`medcard`.`PatID` ='".$_SESSION[pat]."') AND
	       (`sopzabmc`.`MedCardID` =`medcard`.`id`) AND 
		   (`sopzab`.`id` =`sopzabmc`.`ZabolevID`) )" ;
	//echo $query."<br>";
	include("query.php");
	if ($count>0)
	{		
		echo "<div class='head2'>Сопутствующие заболевания: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo $row[zab]." ";
		}
         echo "</div>";
	}
	$query = "SELECT `advid`.`vid`, `medcard`.`ADZnach`
	FROM advid, medcard
	WHERE ((`advid`.`id` =`medcard`.`ADVid`) AND (`medcard`.`PatID`  ='".$_SESSION[pat]."'))" ;
	//echo $query."<br>";
	include("query.php");
	$row = mysql_fetch_array($result);
	echo "<div class='head2'>АД пациента: ".$row[vid]."(".$row[ADZnach].")</div>";
	echo "		<form  action='pat_tooday_work_orto.php' method='get' >
		<input name='action' type='hidden' value='lech' />
		<input name='step' type='hidden' value='2' />
		  <div class='head2'>Выбирите зуб или зубы </div>";
			echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";
				//Заполняем 10 сегмент
				$query = "SELECT `id` FROM `sostzubosm` WHERE `Osmotr`=".$_SESSION[OsmID] ;
		//echo $query."<br>";
		include("query.php");
				if (($count>0) and ($_SESSION[OsmID]!=0) and ($_SESSION[OsmID]!=""))
				{
				echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
					$query = "SELECT `nzuba`.`NZuba` , `sz`.`id` , `sz`.`obozn` , `sz`.`sz` 
FROM `sostzubosm` , `sz` , `nzuba` 
WHERE (
(
`sostzubosm`.`Osmotr` = '".$_SESSION[OsmID]."'
)
AND (
`sostzubosm`.`NZuba` <=32
)
AND (
`sz`.`id` = `sostzubosm`.`SostZuba` 
)
AND (
`nzuba`.`id` = `sostzubosm`.`NZuba` 
)
)
ORDER BY `sostzubosm`.`NZuba` ASC 

" ;
	//echo $query."<br>";
	include("query.php");
	for ($i=1;$i<=32;$i++)
	{
		$row = mysql_fetch_array($result);
		if (($row[id]==7) or ($row[id]==6)) $z[1][$i]="<input type='checkbox' name='Nzub[".$i."]' value='".$i."'  disabled='disabled'/>";
		else $z[1][$i]="<input type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		if ($row[obozn]=="") $z[2][$i]="&nbsp;";
		else $z[2][$i]=$row[obozn];
		$z[3][$i]=$row[NZuba];
		$z[4][$i]=$row[sz];
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
			}
		 echo "</tr>";
	}
		////20 сегмент
		 echo " </table></td>
                <td bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=1;$i<=3;$i++)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=9;$j<=16;$j++)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
						 echo "</tr>";
					}
				echo "                </table></td>
              </tr>
              <tr>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=32;$j>=25;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>";
		      }
			  //Если формулы нет
			  else
			  {
			  	echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
	$query = "SELECT `id`, `NZuba` FROM `nzuba` ORDER BY `id`" ;
	//echo $query."<br>";
	include("query.php");
	
	for ($i=1;$i<=32;$i++)
	{	
	$row = mysql_fetch_array($result);	
		$z[1][$i]="<input type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		$z[2][$i]="&nbsp;";
		$z[3][$i]=$row[NZuba];
		$z[4][$i]="";
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
			}
		 echo "</tr>";
	}
		////20 сегмент
		 echo " </table></td>
                <td bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=1;$i<=3;$i++)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=9;$j<=16;$j++)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
						 echo "</tr>";
					}
				echo "                </table></td>
              </tr>
              <tr>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=32;$j>=25;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>";
			  }
			  echo "<div align='center'>
		        <input name='Input' type='submit'  value='Дальше>>>'/></div>
		        </form>";
	break;
	case "2":
	///Выбор диагноза
	    $z=$_GET[Nzub];
		echo "	<form  action='pat_tooday_work_orto.php' method='get' >
		<input name='action' type='hidden' value='lech' />
		<input name='step' type='hidden' value='3'/>
		  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
			<tr>";
			reset($z);
			$_SESSION[QZub]=0;
			while (list($el)=each($z))
	{
				$_SESSION[QZub]=$_SESSION[QZub]+1;
				$query = "SELECT `nzuba`.`NZuba`, `nzuba`.`id`
				FROM nzuba
				WHERE (`nzuba`.`id` ='".$el."')" ;
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$NZub=$row[NZuba];
				$NZubID=$row[id];
				echo " <td align='center'>Зуб №".$NZub."<br />
				<input name='NZub[".$_SESSION[QZub]."]' type='hidden' value='".$NZub."'/>";	
				$query = 'SELECT `ds`.`Nazv`, `ds`.`id`
				FROM ds
				WHERE (`ds`.`Cat` =0)
				ORDER BY `ds`.`KlassID` ASC' ;
				//echo $query.'<br>';
				include('query.php');
				echo "<select name='dsZub[".$NZub."]' size='".$count."' >";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "<option value=".$row[id].">".$row[Nazv]."</option>";
				}
				echo "        </select>
				</td>";
		}
		echo	"</tr>
		  </table>
		<div align='center'>
		<input name='count' type='hidden' value='1' />
		<input name='Input' type='submit'  value='Дальше>>>'/></div>  
		</form>";
	break;
	case "3":
	////////Заполнение карты
	if (!(isset($_SESSION[NZub]))) $_SESSION[NZub]=$_GET[NZub];
	if (!(isset($_SESSION[dsZub]))) $_SESSION[dsZub]=$_GET[dsZub];
	if (isset($_GET[lech])) $_SESSION[lech][$_GET[count]]=$_GET[lech];
	$NZub=$_SESSION[NZub][$_GET[count]];
	//$NZub=$NZub1;
	$dsZub=$_SESSION[dsZub][$NZub];
	if (!(isset($_GET[klishe])))
	{
		$query = "SELECT `id`, `nazv`,`text` FROM `klishe_obk` WHERE `ds`=".$dsZub;
		//echo $query."<br />";
		include("query.php");
		if ($count>0)
		{
			
			if ($count==1)
			{
				$row = mysql_fetch_array($result);
				$klishe=$row[id];
			}
			else
			{
				echo "<div class=\"head2\">Выбирите клише из списка:</div>";
				echo "<form method='get' id='card' name='card'>
	<input name='obk_1' type='hidden' value='".$_GET[count]."' />";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysql_fetch_array($result);
					echo "
					<a href='pat_tooday_work_orto.php?action=lech&step=3&count=".$_GET[count]."&klishe=".$row[id]."' class='menu2'>".$row[nazv]."</a><div class=\"smalltext\">
".stripslashes($row[text])."</div><hr width='100%' noshade='noshade' size='1'/>";
				}
				echo "</form>";
				include("footer.php");
				exit;
			}
		}
		else
		{
			$klishe='N';
		}
	}
	else
	{
		$klishe=$_GET[klishe];
	}
	//$dsZub=$dsZub;
	echo "<form method='get' action='pat_tooday_work_orto.php' id='card' name='card'>
	<input name='count' type='hidden' value='".$_GET[count]."' />
	 <div class='head3'> Пациент:".$_SESSION[pat_name]."</div>";
	echo "<input name='step' type='hidden' value='4'/>
	<input name='action' type='hidden' value='lech'/>";
	echo "<div class='head2'>Диагноз: ";
	$query = "Select Nazv from ds where id=".$dsZub;
	//echo $query."<br />";
	include("query.php");
	$row = mysql_fetch_array($result);
	 echo $NZub."-й зуб, ".$row[Nazv]."</div>
	  <hr width='100%' noshade='noshade' size='1'/>
	  <a href='#' class='niz2' >Пропустить заполнение карты</a><br />
	    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='300' align='right' valign='top'><div class='head2'>Жалобы</div><textarea name='zh_1' id='zh'  cols='40'  rows='2'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td width='' align='left' valign='top'><div class='head2'>Варианты</div>";
	$query = "SELECT `zh`.`zh`, `zh`.`id`
FROM zh, soot_zh
WHERE ((`zh`.`id` =`soot_zh`.`zh`) AND (`soot_zh`.`ds` ='".$dsZub."'))
ORDER BY `zh`.`zh` ASC";
		//echo $query."<br />";
		include("query.php");
		if ($count==0)
		{
			$query = "SELECT `zh`.`zh`, `zh`.`id`
FROM zh
ORDER BY `zh`.`zh` ASC";
include("query.php");
		}
		if ($count>25) echo "<select id='tablefields' name='var_zh' size='1' multiple='multiple' ondblclick='insertValueQuery()' onMouseOver='document.card.var_zh.size=25' onmouseout='document.card.var_zh.size=1'>";
      else echo "<select id='tablefields' name='var_zh' size='1' multiple='multiple' ondblclick= 'insertValueQuery()' onMouseOver='document.card.var_zh.size=".$count."' onmouseout='document.card.var_zh.size=1'>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo "<option value='".$row[zh]."'>".$row[zh]."</option>";
		}
          
		  echo "</select><br />
<input type='button' name='insertzh' value='&lt;&lt;' onclick='insertValueQuery()' title='Вставить' /></td>
  </tr>
  <tr>
    <td height='148' align='right' valign='top'><div class='head2'>Анамнез</div>
        <textarea name='an_1' id='an'  cols='40'  rows='2'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td align='left' valign='top'><div class='head2'>Варианты</div>";
    $query = "SELECT `an`.`an`, `an`.`id`
FROM an, soot_an
WHERE ((`an`.`id` =`soot_an`.`an`) AND (`soot_an`.`ds` ='".$dsZub."'))
ORDER BY `an`.`an` ASC";
	//echo $query."<br />";

	include("query.php");
	if ($count==0)
	{
		$query = "SELECT `an`.`an`, `an`.`id`
FROM an
ORDER BY `an`.`an` ASC";
include("query.php");
	}
	if ($count>25) echo "<select id='tablefields' name='var_an' size='1' multiple='multiple' ondblclick='insertValueQueryan()' onMouseOver='document.card.var_an.size=25' onmouseout='document.card.var_an.size=1'>";
      else echo "<select id='tablefields' name='var_an' size='1' multiple='multiple' ondblclick= 'insertValueQueryan()' onMouseOver='document.card.var_an.size=".$count."' onmouseout='document.card.var_an.size=1'>";

		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			echo "<option value='".$row[an]."'>".$row[an]."</option>";
		}
          
		  echo "</select>
      <br />
        <input type='button' name='insertan' value='&lt;&lt;' onclick='insertValueQueryan()' title='Вставить' /></td>
  </tr>		  
  <tr>
    <td height='148' align='right' valign='top'><div class='head2'>Объективно</div>";
		
			echo "<textarea name='obk_1' id='obk'  cols='40'  rows='10'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>";
		if ($klishe=='N')
		{
		echo "<td align='left' valign='top'><div class='head2'>Варианты</div>";
					 $query = "SELECT `ob`.`ob`, `ob`.`id`
	FROM ob, soot_ob
	WHERE ((`ob`.`id` =`soot_ob`.`ob`) AND (`soot_ob`.`ds` ='".$dsZub."'))
	ORDER BY `ob`.`ob` ASC";
		//echo $query."<br />";
		include("query.php");
		if ($count==0)
	{
 $query = "SELECT `ob`.`ob`, `ob`.`id`
	FROM ob
	ORDER BY `ob`.`ob` ASC";
include("query.php");
	}
		if ($count>25) echo "<select id='tablefields' name='var_obk' size='1' multiple='multiple' ondblclick='insertValueQueryobk()' onMouseOver='document.card.var_obk.size=25' onmouseout='document.card.var_obk.size=1'>";
		  else echo "<select id='tablefields' name='var_obk' size='1' multiple='multiple' ondblclick= 'insertValueQueryobk()' onMouseOver='document.card.var_obk.size=".$count."' onmouseout='document.card.var_obk.size=1'>";
	
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				echo "<option value='".$row[ob]."'>".$row[ob]."</option>";
			}
			  
			  echo "</select>
	<br />
			<input type='button' name='insertobk' value='&lt;&lt;' onclick='insertValueQueryobk()' title='Вставить' />";	
		echo "</td>";
		}
		else 
		{
			echo "<td align='left' valign='top'><div class='head2'>Варианты</div>";
			$query = "SELECT `nazv`, `function`, `text` FROM `klishe_obk` WHERE `id`=".$klishe;
			//echo $query."<br />";
			include("query.php");
			$row = mysql_fetch_array($result);
				  echo "<script type=\"text/JavaScript\">
				<!--
				function MM_jumpMenu(targ,selObj,restore){
				document.card.obk.value=\"".stripslashes($row['function'])."\"; 
				  if (restore) selObj.selectedIndex=0;
				}
				//-->
				</script>";
				echo stripslashes($row[text]);
				echo "<script type=\"text/JavaScript\">
				<!--
				document.card.obk.value=\"".stripslashes($row['function'])."\"; 
				//-->
				</script>";
				echo "</td>";
		}
  echo "</tr>
</table>
<center><input name='next' type='submit'  value='Дальше>>>'/></center>
</form>";	
	break;
	case "4":
	if (!(isset($_SESSION[zh][$_GET[count]])))$_SESSION[zh][$_GET[count]]=$_GET[zh_1];
	if (!(isset($_SESSION[an][$_GET[count]]))) $_SESSION[an][$_GET[count]]=$_GET[an_1];
	if (!(isset($_SESSION[obk][$_GET[count]]))) $_SESSION[obk][$_GET[count]]=$_GET[obk_1];
	if (!(isset($_GET[preysk]))) 
	{
		
		$query = "SELECT * 
		FROM `preysk` 
		LIMIT 1";
		//echo $query."<br />";
		include("query.php");
		$row = mysql_fetch_array($result);
		$preysk=$row[0];
	}
	else $preysk=$_GET[preysk];
	switch ($_GET[act])
	{
	case "add":
		if (!(isset($_SESSION[countm][$_GET[count]])))
		{
			$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=$_GET[manip]" ;
			//echo $query."<br>";
			include("query.php");
			$row = mysql_fetch_array($result);
			$_SESSION[countm][$_GET[count]]=1;
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][1]=$_GET[manip];
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][2]=1;
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][3]=$row[manip];
			$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][4]=$row[price];
		}
		else 
		{
			$f=0;
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($_GET[manip]==$_SESSION[chek][$_GET[count]][$i][1])
				{
					$f=1;
					$_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]+1;
				}
			}
			if($f==0)
			{
				$query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=$_GET[manip]" ;
				//echo $query."<br>";
				include("query.php");
				$row = mysql_fetch_array($result);
				$_SESSION[countm][$_GET[count]]=$_SESSION[countm][$_GET[count]]+1;
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][1]=$_GET[manip];
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][2]=1;
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][3]=$row[manip];
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][4]=$row[price];
				$_SESSION[chek][$_GET[count]][$_SESSION[countm][$_GET[count]]][5]=$row[zapis];
			}
			
		}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "del":
	if ($_SESSION[countm][$_GET[count]]==1) 
	{
		$_SESSION[countm][$_GET[count]]=0;
	}
	else
	for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
	{
		if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
		{
			for ($j=$i;$j<$_SESSION[countm][$_GET[count]-1];$j++)
			{
				
				$_SESSION[chek][$_GET[count]][$j][1]=$_SESSION[chek][$_GET[count]][$j+1][1];
				$_SESSION[chek][$_GET[count]][$j][2]=$_SESSION[chek][$_GET[count]][$j+1][2];
				$_SESSION[chek][$_GET[count]][$j][3]=$_SESSION[chek][$_GET[count]][$j+1][3];
				$_SESSION[chek][$_GET[count]][$j][4]=$_SESSION[chek][$_GET[count]][$j+1][4];
				$_SESSION[chek][$_GET[count]][$j][5]=$_SESSION[chek][$_GET[count]][$j+1][5];
			}
		$_SESSION[countm][$_GET[count]]=$_SESSION[countm][$_GET[count]]-1;
		$i=$j+1;
		}
	}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "p1":
	for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
	{
		if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
		{
			$_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]+1;
		}
	}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "m1":
	for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
	{
		if ($_GET[chek]==$_SESSION[chek][$_GET[count]][$i][1])
		{
			if ($_SESSION[chek][$_GET[count]][$i][2]==1)
			{
				msg("Количество манипуляций не может быть меньше одного");
			}
			else $_SESSION[chek][$_GET[count]][$i][2]=$_SESSION[chek][$_GET[count]][$i][2]-1;
		}
	}
	ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
	break;
	case "chQ":
		if ($_GET[sstep]==1)
		{	
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ(id,qq)
			{
				q=prompt('Введите количество',qq);
				url='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$_GET[preysk]."&id='+id+'&act=chQ&sstep=2&q='+q;
				location.href=url;
			}";
			echo "ChQ('".$_GET[id]."','".$_SESSION[chek][$_GET[count]][$_GET[id]][2]."')</script>";
		}
		else
		{
			$_SESSION[chek][$_GET[count]][$_GET[id]][2]=$_GET[q];
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$_GET[preysk]);
		}
	break;
	case "next":
	if (isset($_SESSION[countm][$_GET[count]]))
		{
					echo "<form id='lechf' name='lechf' method='get' action='pat_tooday_work_orto.php'>
            <label></label>
            Правка лечения:<br />
                  <textarea name='lech' cols='50' rows='7' id='lech'>"; 
			//$query = "SELECT `zapis` FROM `manip` WHERE `id` in (";
//			for($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
//			{
//				if ($i==1) $query = $query."'".$_SESSION[chek][$_GET[count]][$i][1]."'";
//				else $query = $query.",'".$_SESSION[chek][$_GET[count]][$i][1]."'";
//			}
//			$query = $query.")";
//			//echo $query."<br />";
//			include("query.php");
//			for ($i=1;$i<=$count;$i++)
//			{
//				$row = mysql_fetch_array($result);
//				echo $row[zapis]." ";
//			}
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				echo $_SESSION[chek][$_GET[count]][$i][5]." ";
			}
			echo "</textarea>
                  <br />
                  <input type='submit' name='Submit' value='Продолжить' />";
			echo "<input name='action' type='hidden' value='lech' />";
			if ($_GET[count]==$_SESSION[QZub])
			{
			 	echo "<input name='step' type='hidden' value='5' />";
				echo "<input name='count' type='hidden' value='".($_GET[count])."' />";
			}
			else 
			{
				echo "<input name='step' type='hidden' value='3' />";
				echo "<input name='count' type='hidden' value='".($_GET[count]+1)."' />";
			}
            echo "</form>";
			include("footer.php");
	exit;
		}
		else
		{
			msg("Вы не выбрали не одной манипуляции");
			ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk);
		}
		

	break;	
	}
	if (!(isset($_GET[preysk]))) $preysk=1;
	else $preysk=$_GET[preysk];
	$NZub=$_SESSION[NZub][$_GET[count]];
	//$NZub=$NZub1;
	$dsZub=$_SESSION[dsZub][$NZub];
	//echo $_SESSION[NZub]." ".$NZub." ".$_SESSION[dsZub]." ".$dsZub." ".$_GET[count];
	//////////Заполнение лечения
	echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='".$_GET[count]."' />
			<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div>
			<div class='head2'>Диагноз: ";
			
	$query = "Select Nazv from ds where id=".$dsZub;
	//echo $query."<br />";
	include("query.php");
	$row = mysql_fetch_array($result);
	echo $NZub."-й зуб, ".$row[Nazv]."</div>
			<hr width='100%' noshade='noshade' size='1'/>
			<table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>
		<td><center><div class='head2'>Прейскуранты:</div><br />";
		$query = "select * from preysk";
		//echo $query."<br />";
		include("query.php");
for ($i=0;$i<$count;$i++)
{
	$row = mysql_fetch_array($result);
	if ($row[id]==$preysk) echo "|<font color='#42929D'>".$row[preysk]."</font>|";
	else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$row[id]."'>".$row[preysk]."</a>|";
}
		echo " </center></td>
	  </tr>
	  <tr>
		<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>";

		//echo "<td width='60%' align='center' valign='top'>Выбирте манипуляцию: <br />";
		//$query = "select * from manip WHERE preysk=".$preysk." order by manip";
//echo $query."<br />";
//include("query.php");
//
//
//
//
//
//
//
//
//if ($count>15) echo "<select name='manip' size='15'>";
//else echo "<select name='manip' size='".$count."'>";
//if (!($count>0))
//{
//	$N="Название";
//	while (strlen($N)<30) 
//	{
//		$N=$N."_";
//	}
//	$N=$N."Цена";
//	echo "<option value=''>".$N."</option>";
//}
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysql_fetch_array($result);
//	$N=$row[manip];
//	while (strlen($N)<30) 
//	{
//		$N=$N."_";
//	}
//	$N=$N.$row[price]." руб.";
//	echo "<option value='".$row[id]."'>".$N."</option>";
//}
//
//echo "</select>
//		<br />
//	
//		  <input type='submit' name='Submit' value='Добавить в список' />";

		  
		 //echo " </td>";

		echo "<td width='40%' valign='top' align='center'>Счёт:<br /> ";
		
		
		
		
		//echo $_SESSION[countm][$_GET[count]];
		if (isset($_SESSION[countm][$_GET[count]]))
		{
			$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
			for($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				if ($i==1) $query = $query."'".$_SESSION[chek][$_GET[count]][$i][1]."'";
				else $query = $query.",'".$_SESSION[chek][$_GET[count]][$i][1]."'";
			}
			$query = $query.")";
			//echo $query."<br />";
			include("query.php");
//			if ($count>15) echo "<select name='chek' size='15'>";
//			else echo "<select name='chek' size='".$count."'>";
//			$_SESSION[summ][$_GET[count]]=0;
//			for ($i=1;$i<=$count;$i++)
//			{
//				$row = mysql_fetch_array($result);
//				$N=$row[manip];
//				while (strlen($N)<=30) 
//				{
//				$N=$N."_";
//				}
//				$N=$N.$row[price]."*".$_SESSION[chek][$_GET[count]][$i][2]."=".($row[price]*$_SESSION[chek][$_GET[count]][$i][2])."руб.";
//				echo "<option value=".$row[id].">".$N."</option>";
//				$_SESSION[summ][$_GET[count]]=$_SESSION[summ][$_GET[count]]+($row[price]*$_SESSION[chek][$_GET[count]][$i][2]);
//			}
//			echo "</select> <br />";
			echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($_SESSION[summ][$_GET[count]]);
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$_SESSION[chek][$_GET[count]][$i][3]."<br />
				<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&chek=".$_SESSION[chek][$_GET[count]][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
</td>
				<td width='10%' align='center'>".$_SESSION[chek][$_GET[count]][$i][2]."<br />
<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
				<td width='12%' align='center'>".$_SESSION[chek][$_GET[count]][$i][4]." руб.</td>
				<td width='10%' align='center'>".($_SESSION[chek][$_GET[count]][$i][2]*$_SESSION[chek][$_GET[count]][$i][4])." руб.</td>
			  </tr>";
			$_SESSION[summ][$_GET[count]]+=$_SESSION[chek][$_GET[count]][$i][2]*$_SESSION[chek][$_GET[count]][$i][4];	
			} 
			echo "</table>";
			echo "<div align='right'>Итого: ".$_SESSION[summ][$_GET[count]]." руб. </div>";





//скидки		
		
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			//echo $query."<br>";
			include("query.php");
			if ($count>0)
			{
				$row = mysql_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".
				round(($_SESSION[summ][$_GET[count]]-($_SESSION[summ][$_GET[count]]*$row[0])/100),-1)." руб.</div>";
				$ck=$row[0];
			}
			else
			{
				$ck=0;
			}
			
			
			
			
			
			
			if ($_SESSION[QZub]>1)
			{
				$os=0;
				for($i=1;$i<=$_GET[count];$i++) 
				{
					$os=$os+($_SESSION[summ][$i]);
				}
				
				
				
				
				
				
				//конец скидки
			echo "<div align='right'>Общая сумма: ".round(($os-($os*$ck)/100),-1)." руб.</div>";				
			}
		  //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
//		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
//		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
		}
		else echo "&nbsp";
		echo "<input name='act' type='hidden' value='add' />";
		echo "<input name='step' type='hidden' value='4' />";
		echo "<input name='action' type='hidden' value='lech' />
		  </td>
	  </tr>
	</table>
	</td>
	  </tr>
	</table>";
		echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";
	
	
//$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by manip";
		//echo $query."<br />";
		include("query.php");
		$cc=0;
		$cm=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysql_fetch_array($result);
				if ($row[cat]==1)
				{
					$cc++;
					$cat[$cc][id]=$row[id];
					$cat[$cc][manip]=$row[manip];
					
				}
				else
				{
					$cm++;
					$mat[$cm][id]=$row[id];
					$mat[$cm][manip]=$row[manip];
					$mat[$cm][price]=$row[price];
					$mat[$cm][UpId]=$row[UpId];
				}
			}
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			document.onclick = clickHandler; 
			</script>";
		for($i=1;$i<=$cc;$i++)
			{
				echo "
			<SPAN id='Out".$i."' class='mmenuHand'>".$cat[$i][manip]."</SPAN><br />
	<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
		<table width='80%' border='0'>
    ";
				
				for($j=1;$j<=$cm;$j++)
				{
				
					if ($cat[$i][id]==$mat[$j][UpId])
					echo "<tr>
        <td width='85%'><a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=".$_GET[count]."&preysk=".$preysk."&manip=".$mat[$j][id]."&act=add' class='small'>". $mat[$j][manip]."</a></td>
        <td width='15%'>
		".$mat[$j][price]."
		</td>
      </tr>";
				} 
				echo "</table></div>";
			}

			echo "</form>";
	include("footer.php");
	exit;
	break;
	case "5":
		$_SESSION[lech][$_GET[count]]=$_GET[lech];
		echo "<div class='head3'>Пациент: ".$_SESSION[pat_name]."</div><hr width='100%' noshade='noshade' size='1'/>";
		echo "Жалобы: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$zh=$_SESSION[NZub][$i]." ".$_SESSION[zh][$i]."<br />";	
		}
		echo $zh."<br />";
		echo "Анамнез: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$an=$_SESSION[NZub][$i]." ".$_SESSION[an][$i]."<br />";	
		}
		echo $an."<br />";
		echo "Объективно: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$obk=$_SESSION[NZub][$i]." ".$_SESSION[obk][$i]."<br />";	
		}
		echo $obk."<br />";
		echo "Диагноз : ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			$NZub=$_SESSION[NZub][$i];
			$dsZub=$_SESSION[dsZub][$NZub];
			$query = "Select Nazv from ds where id=".$dsZub;
			//echo $query."<br />";
			include("query.php");
			$row = mysql_fetch_array($result);
			$ds=$ds.$NZub."-й зуб, ".$row[Nazv]."<br />";
			echo $ds;
		}
		echo "<br />Лечение: ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
		$lech=$_SESSION[NZub][$i]." ".$_SESSION[lech][$i]."<br />";	
		}
		echo $lech."<br />";
		//echo "Итого: ";
		$opl=0;
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{	
			$opl=$opl+$_SESSION[summ][$i];
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			//echo $query."<br>";
			//echo $opl." руб<br />";
			include("query.php");
			if ($count>0)
			{
				$row = mysql_fetch_array($result); 
				//echo "Итого со скидкой: ".(($opl-round(($opl*$row[0])/100)))." руб<br />";
				$ck=$row[proc];
			}
			else
			{
				$ck=0;
			}
		}
		//echo $_SESSION[NZub][$i]." ".$_SESSION[zh][$i]." ".$_SESSION[an][$i]." ".$_SESSION[obk][$i]." ".$_GET[lech].$_SESSION[summ][$i]."<br />";	
		//echo "Всатавка в Дневник<br>";
		$query = "INSERT INTO `dnev` (`id`, `vrach`,`pat`, `date`, `osm`, `ds`, `zh`, `an`, `obk`, `lech`, `resl`,`summ`, `summ_k_opl`, `summ_vnes`)
		VALUES (NULL, '".$_SESSION["UserID"]."','".$_SESSION[pat]."', '".date('Y-m-d')."', '".$_SESSION[OsmID]."', '".addslashes($ds)."', '".addslashes($zh)."', '".addslashes($an)."', '".addslashes($obk)."', '".addslashes($lech)."', 0,'".$opl."','".round((($opl-($opl*$ck)/100)),-1)."',0)" ;
		//echo $query."<br>";
		include("query.php");
		$query = "SELECT id FROM `dnev` WHERE
		( (`pat`='".$_SESSION[pat]."') AND
		(`date`='".date('Y-m-d')."') AND  
		(`vrach`='".$_SESSION["UserID"]."') AND 
		(`osm`='".$_SESSION[OsmID]."') AND 
		(`ds`='".addslashes($ds)."') AND 
		(`zh`='".addslashes($zh)."') AND 
		(`an`='".addslashes($an)."') AND 
		(`obk`='".addslashes($obk)."') AND 
		(`lech`='".addslashes($lech)."') AND 
		(`resl`=0))";
		//echo $query."<br>";
		include("query.php");
		$row = mysql_fetch_array($result);
		$pr=$row[id];
		$query="INSERT INTO `ds_pr` (`id`, `ds`, `pr`,`NZub`) VALUES ";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			$NZub=$_SESSION[NZub][$i];
			$dsZub=$_SESSION[dsZub][$NZub];
			if ($i==1) $query=$query."(NULL,'".$dsZub."','".$pr."','".$NZub."')";
			else $query=$query.", (NULL,'".$dsZub."','".$pr."','".$NZub."') ";
		}
		//echo "Всатавка в Диагнозы приёма<br>";
		//echo $query."<br>";
		include("query.php");
//		$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
//		//echo $query."<br>";
//		include("query.php");
//		if ($count>0)
//			{
//				$ck=$row[proc];
//				echo $ck."<br />";
//			}
//		else
//			{
//				$ck=0;
//			}
		//$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
		$c=1;
		//$query = $query."'".$_SESSION[chek][1][1][1]."'";
		$m[$c][1]=$_SESSION[chek][1][1][1];
		$m[$c][2]=0;
		$m[$c][3]+=$_SESSION[chek][1][1][3];
		$m[$c][4]+=$_SESSION[chek][1][1][4];
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				$f=0;
				for ($q=1;$q<=$c;$q++)
				{
					if ($m[$q][1]==$_SESSION[chek][$i][$j][1])
					{
						
						$m[$q][2]+=$_SESSION[chek][$i][$j][2];
						$f=1;
						//echo $m[$q][1]." ".$m[$q][2]."<br />";
					}		
				}
				if ($f==0) 
				{
					//$query = $query.",'".$_SESSION[chek][$i][$j][1]."'";
					$c=$c+1;
					$m[$c][1]=$_SESSION[chek][$i][$j][1];
					$m[$c][2]=$_SESSION[chek][$i][$j][2];
					$m[$c][3]=$_SESSION[chek][$i][$j][3];
					$m[$c][4]=$_SESSION[chek][$i][$j][4];
					//echo $m[$c][1]." ".$m[$c][2]."<br />";
				}				
			}
		}
		//echo "Выбор из манипуляций<br>";
//		$query = $query.") ORDER by id";
//		//echo $query."<br />";
//		include("query.php");
//		for ($i=1;$i<=$count;$i++)
//		{
//			$row = mysql_fetch_array($result);
//			if ($m[$i][1]==$row[id]) 
//			{
//				$m[$i][3]=$row[price];
//				$m[$i][4]=$row[manip];
//			}
//			
//		}
//		
		$query = "INSERT INTO `manip_pr` (`id`, `NZuba`, `manip`, `kolvo`, `dnev`) VALUES";
		for ($i=1;$i<=$_SESSION[QZub];$i++)
		{
			$NZub=$_SESSION[NZub][$i];
			for ($j=1;$j<=$_SESSION[countm][$i];$j++)
			{
				if ($j==1)$query.="(NULL,'".$NZub."','".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
				else $query.=",(NULL,'".$NZub."','".$_SESSION[chek][$i][$j][1]."','".$_SESSION[chek][$i][$j][2]."','".$pr."')";
			}
		}
		//echo "Вставка в Манипуляции при приёме<br>";
		//echo $query."<br>";
		
		include("query.php");
		$query = "SELECT `id`, `mater`,`manip`, `mesto_hr` FROM `mater_avto_spis` WHERE `manip`in ( ";
		$s=0;
		for ($i=1;$i<=$c;$i++)
		{
			if ($i==1) $query.=$m[$i][1];
			else $query.=", ".$m[$i][1];
		}
		$query.=")";
		$ssk=($s-round($s*($ck/100)));		
		//echo $query."<br />";
		include("query.php");
		for ($i=0;$i<$count;$i++)
		{
			$row = mysql_fetch_array($result);
			for ($j=1;$j<=$c;$j++)
			{
				if ($m[$j][1]==$row[manip])
				$query = "UPDATE `ost_mat`
				SET `ost`=`ost`-'".$m[$j][2]."'
				WHERE ((`mater`='".$row[mater]."') and
						(`mesto_hr`='".$row[mesto_hr]."'))";
				//echo $query."<br />";
				include("query.php");
			}
		}
		echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($s);
			for ($i=1;$i<=$_SESSION[countm][$_GET[count]];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$m[$i][3]."</td>
				<td width='10%' align='center'>".$m[$i][2]."</td>
				<td width='12%' align='center'>".$m[$i][4]." руб.</td>
				<td width='10%' align='center'>".($m[$i][2]*$m[$i][4])." руб.</td>
			  </tr>";
			  $s+=$m[$i][2]*$m[$i][4];
			} 
			
				
			echo "</table>";
			echo "<div align='right'>Итого: ".$s." руб. </div>";
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION[pat]."'))" ;
			//echo $query."<br>";
			include("query.php");
			if ($count>0)
			{
				$row = mysql_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".
				round(($s-($s*$row[0])/100),-1)." руб.</div>";
			}
//		$query = "INSERT INTO `oplata` (`id`, `dnev`, `stoim`, `soimSoSk`, `vnes`, `dolg`, `VidOpl`) VALUES (NULL,'".$pr."','".$s."','".$ssk."',0,'".$ssk."',1)" ;
//		//echo "Всатавка в Оплату<br>";
//		//echo $query."<br>";
//		include("query.php");
//	break;
	echo "<a href='print.php?type=pat&card=".$pr."' target='_blank' class='mmenu'>Печать карты</a><br />"
;
	echo "<a href='pat_tooday.php'class='mmenu'>Закрыть</a>";
	unset($_SESSION[chek]);
	unset($_SESSION[countm]);
	unset($_SESSION[NZub]);
	unset($_SESSION[dsZub]);
	unset($_SESSION[QZub]);
	unset($_SESSION[pat]);
	unset($_SESSION[pat_name]);
	unset($_SESSION[zh]);
	unset($_SESSION[obk]);
	unset($_SESSION[lech]);
	unset($_SESSION[an]);
	unset($_SESSION[OsmID]);
	unset($_SESSION[summ]);	
	}
}
		
	if (($_GET[action]!="lech"))
	{
		echo "<script language='JavaScript' type='text/javascript'>
		location.href='pat_tooday_work_orto.php?action=lech&perv=0&step=1&pat=".$_GET[pat]."';
		</script>";
	}
}

////////////Лечение зуба
include("footer2.php");
?>
