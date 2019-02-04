<?php
$ThisVU="registrator";
$ModName="Приём платежей";

include("header.php");
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";
//////////echo $query."<br />";
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
	case "pr":
		switch ($_GET['step'])
		{
			case "1":
				$query= "SELECT `summ_k_opl`, `summ_vnes` FROM `dnev` WHERE `id`=".$_GET['dnev'] ;
				//////////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$_SESSION['kop']=$row['summ_k_opl'];
				$_SESSION['dolg']=$row['summ_k_opl']-$row['summ_vnes'];
				$_SESSION['svn']=$row['summ_vnes'];
				$_SESSION['id']=$_GET['dnev'];
				echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
					<span class='head3'>Приём оплаты:</span><br />
					<input name='step' type='hidden' value='2'>	
					<input name='action' type='hidden' value='pr'>			
					К оплате: ".$_SESSION['kop']."<br />
					Оплачено: ".$row['summ_vnes']."<br />
					Сумма долга: ".$_SESSION['dolg']."<br />";
				$query = "SELECT * FROM `dogovor` WHERE (`pat`='".$_GET['Pid']."')" ;
				////////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($count>0)
				{
					$row = mysqli_fetch_array($result);
					$firm=$row['firm'];
				}
				
				$query = "SELECT `id`,`avans` FROM `avans` WHERE `pat`='".$_GET['Pid']."'" ;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($count>0)
				{
					$row = mysqli_fetch_array($result);
					$av=$row['avans'];
				}
				
				$query = "SELECT * FROM `opl_vid`" ;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "Вид оплаты:<select name='v_opl'>";
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
				echo "</select><br />
";
				echo "Оплата на: "; 
				$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
				////////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<select name='podr'>";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					echo "<option value=".$row[0].">".$row[1]."</option>";
				}
				echo "</select><br />
";
				if (isset($av)) echo "<input name='av' type='hidden' value=".$av.">";
				if (isset($firm)) echo "<input name='firm' type='hidden' value='".$firm."'>";
				echo "<input name='ok' type='submit'  value='Дальше>>>'/>
				</form>";
				include("footer.php");
				exit;
			break;
			case "2":
				$_SESSION['podr']=$_GET['podr'];
				switch ($_GET['v_opl'])
				{
					case "1":
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='".$_GET['v_opl']."'>
							К оплате: ".$_SESSION['kop']."<br />
							Сумма долга: ".$_SESSION['dolg']."<br />
							Сумма к оплате:<input type='text' name='summ' value='".$_SESSION['dolg']."'/>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>	";
							include("footer.php");
							exit;
					break;
					case "2":
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='".$_GET['v_opl']."'>
							 Договор<br />";
							//echo "<select name='Fid' size='5'>";
						$query = "SELECT `id`,`nazv` FROM `firms` WHERE id=".$_GET['firm'] ;
						$row = mysqli_fetch_array($result);
						//////////echo $query."<br>";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
//						for ($i=0;$i<$count;$i++)
//						{
//							
//							echo "<option value=".$row['id'].">".$row['nazv']."</option>";
//							
//						}
						//echo "</select>";
							echo "<input name='Fid' type='hidden' value='".$_GET['firm']."' />";
							echo "<br />
							Фирма: ".$row['nazv']."<br />
							К оплате: ".$_SESSION['kop']."<br />
							Сумма долга: ".$_SESSION['dolg']."<br />
							Сумма к оплате:<input type='text' name='summ' value='".$_SESSION['dolg']."'/>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>";
							include("footer.php");
							exit;
					break;
					case "3":
					if (!(isset($_SESSION['podr'])))
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='av' type='hidden' value='".$_GET['av']."'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='".$_GET['v_opl']."'>
							Размер аванса: ".$_GET['av']."
							 <br />
							К оплате: ".$_SESSION['kop']."<br />
							Сумма долга: ".$_SESSION['dolg']."<br />";
							if ($_SESSION['dolg']<$_GET['av']) echo " Сумма к оплате:<input type='text' name='summ' value='".$_SESSION['dolg']."'/>		руб.<br />";
							else echo " Сумма к оплате:<input type='text' name='summ' value='".$_GET['av']."'/>		руб.<br />";
							echo "<input name='ok' type='submit'  value='Дальше>>>'>
							</form>";
							include("footer.php");
							exit;
					break;
				}
			break;
			case "3":
				switch ($_GET['v_opl'])
				{
					case "1":
						if ($_GET['summ']>$_SESSION['dolg'])
						{
							msg('Максимальный размер оплаты'.$_SESSION['dolg']);
							ret('pr_opl.php?action=pr&step=2&v_opl=1');
						}
					break;
					case "2":
						if ($_GET['summ']>$_SESSION['dolg'])
						{
							msg('Максимальный размер оплаты'.$_SESSION['dolg']);
							ret('pr_opl.php?action=pr&step=2&v_opl=2&firm='.$_GET['Fid']);
						}
						$query = "INSERT INTO `opl_firm` (`id`, `firm`, `opl`) VALUES (NULL,'".$_GET['Fid']."',$_GET['summ'])" ;
						//////////echo $query."<br>";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
					break;
					case "3":
						if ($_GET['summ']>$_SESSION['dolg'])
						{
							msg('Максимальный размер оплаты'.$_SESSION['dolg']);
							ret('pr_opl.php?action=pr&step=2&v_opl=3&av='.$_GET['av']);
						}
						if ($_GET['summ']>$_GET['av'])
						{
							msg('Максимальный размер оплаты через аванс'.$_GET['av']);
							ret('pr_opl.php?action=pr&step=2&v_opl=3&av='.$_GET['av']);
						}
						$query = "SELECT `avans`.`id`, `avans`.`avans`
FROM avans, dnev
WHERE ((`avans`.`pat` =`dnev`.`pat`) AND (`dnev`.`id` ='".$_SESSION['id']."'))" ;
						//////////echo $query."<br>";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
						if ($row['avans']==$_GET['summ']) $query = "DELETE  FROM `avans` WHERE `id` =".$row['id'];
						else $query = "UPDATE `avans` 
									SET `avans`=".($row['avans']-$_GET['summ'])."
									WHERE `id`=".$row['id'];
					//////////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					break;
				}
				$query = "UPDATE `dnev` 
									SET `summ_vnes`=".($_SESSION['svn']+$_GET['summ'])."
									WHERE `id`=".$_SESSION['id'];
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`) 
						VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00',".$_SESSION['id'].",".$_GET['summ'].", ".$_GET['v_opl'].",".$_SESSION['podr'].") " ;
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$query = "UPDATE `kassa` 
				SET `summ`=`summ`+".$_GET['summ']."
				WHERE `id`=".$_SESSION['kassa'];
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<a href=\"print.php?type=chek&dnev=".$_SESSION['id']."\">Печать чека</a>";
				unset($_SESSION['podr']);
				unset($_SESSION['dolg']);
				unset($_SESSION['kassa']);
				unset($_SESSION['id']);
				unset($_SESSION['svn']);
				unset($_SESSION['kop']);
				//ret("pr_opl.php");
			break;
		}
	break;
}
echo "<form id='lechf' name='lechf' method='post' action=''>
            <span class='head3'>Список должников на сегодня:</span>
            <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
              <tr>
                <td width='44%' class='mmenu'>Пациент</td>
                <td width='44%' class='mmenu'>Врач</td>
                <td width='12%' class='mmenu'>Сумма<br />
                  долга</td>
                </tr>";
$query = "SELECT 
`dnev`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`dnev`.`summ_k_opl`,`dnev`.`summ_vnes`,`klinikpat`.`id`
FROM dnev, klinikpat, sotr
WHERE ((`dnev`.`date` ='".date('Y-m-d')."') AND (`klinikpat`.`id` =`dnev`.`pat`) AND (`sotr`.`id` =`dnev`.`vrach`) AND (`dnev`.`summ_k_opl` !=`dnev`.`summ_vnes`))"
 ;
//////////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
for($j=0;$j<$countA;$j++)
{
	$rowA = mysqli_fetch_array($resultA);
	echo "<tr><td width='44%' bgcolor='#cccccc'><a href='pr_opl.php?dnev=".$rowA[0]."&action=pr&step=1&Pid=".$rowA[9]."' class='menu2' title='Принять долг'>".$rowA[1]." ".$rowA[2]." ".$rowA[3]."</a></td>
                <td width='44%'>".$rowA[4]." ".$rowA[5]." ".$rowA[6]."</td>
                <td width='12%' >".($rowA[7]-$rowA[8])." руб.</td>
                </tr>";
	$query = "SELECT 
`dnev`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`dnev`.`summ_k_opl`,
`dnev`.`summ_vnes`,
`dnev`.`pat`,
`dnev`.`date`
FROM dnev, klinikpat, sotr
WHERE ((`dnev`.`date` !='".date('Y-m-d')."') 
AND (`dnev`.`pat`='".$rowA[9]."') 
AND (`klinikpat`.`id`=`dnev`.`pat`) 
AND (`sotr`.`id` =`dnev`.`vrach`) 
AND (`dnev`.`summ_k_opl` !=`dnev`.`summ_vnes`))";
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		$dt=explode("-",$row['10']);
		echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от ".$dt[2].".".$dt[1].".".$dt[0]."</span>
		<a href='pr_opl.php?dnev=".$row[0]."&action=pr&step=1&Pid=".$row[9]."' class='menu2' title='Принять долг'>".$row[1]." ".$row[2]." ".$row[3]."</a></td>
					<td width='44%'>".$row[4]." ".$row[5]." ".$row[6]."</td>
					<td width='12%' >".($row[7]-$row[8])." руб.</td>
					</tr>";
		
	}
}
echo " </table>
        </form>";
echo " <script language=\"JavaScript\" type=\"text/javascript\">
						setTimeout(\"javascript:location.href='pr_opl.php'\", 60000);
						</script>";	
include("footer.php");
?>