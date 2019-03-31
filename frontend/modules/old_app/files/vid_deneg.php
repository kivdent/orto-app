<?php

include('mysql_fuction.php');
$ThisVU="registrator";
$this->title="Касса";  
//include("header.php");
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
if (!($count>0))
{
	msg("Необходимо открыть кассовую смену");
	ret("kassa.php?action=nach&step=1");
}
else
{
    $row = mysqli_fetch_array($result);
	$_SESSION['kassa']=$row['id'];
	$summ=$row['summ'];
}
$query = "SELECT `summ` FROM `kassa` WHERE `id`=".($_SESSION['kassa']-1);
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$ost=$row['summ'];
switch ($_GET['step'])
	{
		case "1":
			//$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`id`='".$_SESSION['kassa']."')";
//				//echo $query."<br />";
//				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//				$row = mysqli_fetch_array($result);
			
				

			echo "<form action='vid_deneg.php' method='get' >
			<div class='head1'>Выдача дененг из кассы</div>
			<div class='head2'>Выдача из: "; 
				$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				
				echo "
				<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='vid_deneg.php?step=1&podr=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
				<select name='podr' onchange=\"MM_jumpMenu('parent',this,0)\">";
				for ($i=0;$i<$count;$i++)
				{
					
					$row = mysqli_fetch_array($result);
					if (!(isset($_GET['podr'])) and ($i==0)) 
					{
						echo "<option value=".$row[0]." selected='selected'>".$row[1]."</option>";
						$podr=$row[0];
					}
					else
					{
						if ($row[0]==$_GET['podr']) 
						{
							echo "<option value=".$row[0]." selected='selected'>".$row[1]."</option>";
							$podr=$row[0];
						}
						else echo "<option value=".$row[0].">".$row[1]."</option>";
					}
				}
				echo "</select><br />";
				$tables=array ("dnev","zaknar","schet_orto");
	for ($h=1;$h<=2;$h++)
	{
	$summ_nal[$h]=0;
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
		(`oplata`.`podr`=".$h.")
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
					if ($row[14]==1)
					{ 
						$summ_nal[$h]+=$row[6];
					}
				}
				
		}
	}
	}
	//SELECT FROM sn_
	$query = "SELECT `podr`,SUM(`summ`) FROM `sn_kass` 
WHERE `smena`=".$_SESSION['kassa']."
GROUP BY `podr`" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$sn_kass[1]=0;
	$sn_kass[2]=0;
	for ($i=0;$i<$count;$i++)
	{
       $row = mysqli_fetch_array($result);
	   $sn_kass[$row['podr']]+=$row[1];
	}
	if ($podr==1) $max_summ=$summ_nal[1]+$ost-$sn_kass[1];
	else $max_summ=$summ_nal[2]-$sn_kass[2]; 
	
				echo "<input name='action' type='hidden' value='okonch' />
					<input name='step' type='hidden' value='2' />
					<input name='summ' type='hidden' value='".$max_summ."' />
					<input name='id' type='hidden' value='".$_SESSION['kassa']."' />
						Дата:".date('d.m.Y')."<br />
						Время:".date('G:i')."<br />
						Максимальная сумма:".$max_summ."<br />
						Администратор:".$_SESSION['UserName']."<br />
						Цель<select name='cel' id='cel'>";
                        $query = "SELECT `id` , `naim` 
						FROM `oper_vid` 
						WHERE `znak` = -1
						";
						//echo $query."<br />";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
						for ($i=0;$i<$count;$i++)
						{
							$row = mysqli_fetch_array($result);
							echo "<option value=".$row['id'].">".$row['naim']."</option>";
						}	                 
						echo "</select><br>Ответственное лицо:<select name='otv' id='otv'>";
						$query = "SELECT `id`, `surname`, `name`,`otch` FROM `sotr` ORDER BY `surname`";
						//echo $query."<br />";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
						for ($i=0;$i<$count;$i++)
						{
							$row = mysqli_fetch_array($result);
							echo "<option value=".$row['id'].">".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
						}	
						echo "</select><br />
						Сумма:
						<input type='text' name='sn' />
						руб.
						<br />
						<input name='ok' type='submit' id='ok' value='ОК' />
						<input name='cancel' type='button' value='Отмена' onclick='location.href=\"pr_opl.php\"'/>
					  </div>
					</form>";
		break;
		case "2":
			if ($_GET['sn']>$_GET['summ'])
			{
				msg("Нельзя Выдать больше больше ".$_GET['summ']." руб.");
				ret("vid_deneg.php?step=1");
				exit;
			}
			$query = "UPDATE `kassa` 
						SET 
						`summ`=`summ`-".$_GET['sn']."
						WHERE `id`=".$_GET['id'];
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$query = "INSERT INTO `sn_kass` (`id`, `smena`, `znak`, `summ`, `oper`,`otv`,`podr`)
VALUES (NULL,'".$_GET['id']."','-1','".$_GET['sn']."','".$_GET['cel']."','".$_GET['otv']."','".$_GET['podr']."')";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			ret("pr_opl.php");
		break;
	}
//include("footer.php");
?>