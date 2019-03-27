<?php
session_start();
include('mysql_fuction.php');
$ThisVU="registrator";
$ModName="Приём платежей";
include("header.php");
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";
//////////echo $query."<br />";
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
}
switch ($_GET['action'])
{
	case "pr":
		switch ($_GET['step'])
		{
			case "1":
				$_SESSION['table']=$_GET['table1'];
				$_SESSION['type']=$_GET['type'];
				$query= "SELECT `summ_k_opl`, `summ_vnes` FROM `".$_SESSION['table']."` WHERE `id`=".$_GET['dnev'] ;
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$_SESSION['kop']=$row['summ_k_opl'];
				$_SESSION['dolg']=$row['summ_k_opl']-$row['summ_vnes'];
				$_SESSION['svn']=$row['summ_vnes'];
				$_SESSION['id']=$_GET['dnev'];
				echo "<form id='dolgf' name='dolgf' method='get' action='pr_dolg.php'>
					<span class='head3'>Приём оплаты:</span><br />
					<input name='step' type='hidden' value='2'>	
					<input name='action' type='hidden' value='pr'>			
					К оплате: ".$_SESSION['kop']."<br />
					Оплачено: ".$row['summ_vnes']."<br />
					Сумма долга: ".$_SESSION['dolg']."<br />";
				$query = "SELECT * FROM `dogovor` WHERE (`pat`='".$_GET['Pid']."')" ;
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				if ($count>0)
				{
					$row = mysqli_fetch_array($result);
					$firm=$row['firm'];
				}
				
				$query = "SELECT `id`,`avans` FROM `avans` WHERE `pat`='".$_GET['Pid']."'" ;
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				if ($count>0)
				{
					$row = mysqli_fetch_array($result);
					$av=$row['avans'];
				}
				
				$query = "SELECT * FROM `opl_vid`" ;
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
				echo "</select> <input name='gift_num' id='gift_num' type='hidden' value=''><br />
";
				echo "Оплата на: "; 
				$query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_dolg.php'>
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
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_dolg.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='".$_GET['v_opl']."'>
							 Договор<br />";
							//echo "<select name='Fid' size='5'>";
						$query = "SELECT `id`,`nazv` FROM `firms` WHERE id=".$_GET['firm'] ;
						$row = mysqli_fetch_array($result);
						//////echo $query."<br>";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
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
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_dolg.php'>
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
					case "5":
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
                                                                                      case "4004":
                                                                                            
                                                                                                        $query = "SELECT `balance`,`id` FROM `certif` WHERE `number`=".$_GET['gift_num'] ;
						$row = mysqli_fetch_array($result);
						//echo $query."<br>";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
                                                                                                        if (!($count>0)) 
                                                                                                        {
                                                                                                            msg("Карта не найдена");
						   echo "<script type=\"text/javascript\">
                                                                                                                            history.back();
                                                                                                                    </script>";
                                                                                                        }
                                                                                                        if ($row['balance']<$_SESSION['dolg']) 
                                                                                                        {
                                                                                                            $max_summ=$row['balance'];
                                                                                                        }
                                                                                                        else 
                                                                                                        {
                                                                                                            $max_summ=$_SESSION['dolg'];
                                                                                                        }
                                                                                                        echo "<script type=\"text/javascript\">
                                                                                                        function chek() {
                                                                                                        if ($('#summ').val()>".$max_summ.") 
                                                                                                            {
                                                                                                                alert('Сумма не может быть больше ".$max_summ."');
                                                                                                                $('#summ').val(".$max_summ.");
                                                                                                            }
                                                                                                      

                                                                                                        }
                                                                                                        </script>";
						echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
                                                    
							<input name='step' type='hidden' value='3'>
                                                                                                                          <input name='gift_balance' type='hidden' value='".$row['balance']."'>
                                                                                                                          <input name='gift_id' type='hidden' value='".$row['id']."'>
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='".$_GET['v_opl']."'>
							К оплате: ".$_SESSION['kop']."<br />
							Сумма долга: ".$_SESSION['dolg']."<br />
                                                                                                                         Номер карты ".$_GET['gift_num']." баланс ".$row['balance']."</br>
							Сумма к оплате:<input type='text' id='summ' name='summ'  value='". $max_summ."'/ onkeyup='chek()'>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>	";
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
							ret('pr_dolg.php?action=pr&step=2&v_opl=1');
						}
					break;
					case "2":
						if ($_GET['summ']>$_SESSION['dolg'])
						{
							msg('Максимальный размер оплаты'.$_SESSION['dolg']);
							ret('pr_dolg.php?action=pr&step=2&v_opl=2&firm='.$_GET['Fid']);
						}
						$query = "INSERT INTO `opl_firm` (`id`, `firm`, `opl`) VALUES (NULL,'".$_GET['Fid']."', '".$_GET['summ']."')" ;
						//////echo $query."<br>";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
					break;
					case "3":
						if ($_GET['summ']>$_SESSION['dolg'])
						{
							msg('Максимальный размер оплаты'.$_SESSION['dolg']);
							ret('pr_dolg.php?action=pr&step=2&v_opl=3&av='.$_GET['av']);
						}
						if ($_GET['summ']>$_GET['av'])
						{
							msg('Максимальный размер оплаты через аванс'.$_GET['av']);
							ret('pr_dolg.php?action=pr&step=2&v_opl=3&av='.$_GET['av']);
						}
						$query = "SELECT `avans`.`id`, `avans`.`avans`
FROM avans, dnev
WHERE ((`avans`.`pat` =`".$_SESSION['table']."` .`pat`) AND (`".$_SESSION['table']."` .`id` ='".$_SESSION['id']."'))" ;
						//////echo $query."<br>";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
						$row = mysqli_fetch_array($result);
						if ($row['avans']==$_GET['summ']) $query = "DELETE  FROM `avans` WHERE `id` =".$row['id'];
						else $query = "UPDATE `avans` 
									SET `avans`=".($row['avans']-$_GET['summ'])."
									WHERE `id`=".$row['id'];
					//////echo $query."<br>";
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					break;
					case "5":
						if ($_GET['summ']>$_SESSION['dolg'])
						{
							msg('Максимальный размер оплаты'.$_SESSION['dolg']);
							ret('pr_opl.php?action=pr&step=2&v_opl=1');
						}
					break;
                                                                                       case "4004":
                                                                                                if ($_GET['gift_balance']==$_GET['summ'])
                                                                                                {
                                                                                                      $query = "DELETE FROM `certif` WHERE `id`=".$_GET['gift_id'];  
                                                                                                      echo "<strong>Баланс падарочной карты нулевой.</strong>";
                                                                                                }
                                                                                                else 
                                                                                                {
                                                                                                    $balance=$_GET['gift_balance']-$_GET['summ'];
                                                                                                    $query = "UPDATE `certif` SET `balance`=".$balance." WHERE `id`=".$row['id'];  
                                                                                                    echo "<strong>Баланс падарочной карты ".$balance." рублей.</br></strong>";
                                                                                                }	
					break;
				}
				$query = "UPDATE `".$_SESSION['table']."` 
									SET `summ_vnes`=".($_SESSION['svn']+$_GET['summ'])."
									WHERE `id`=".$_SESSION['id'];
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
						VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00','".$_SESSION['id']."','".$_GET['summ']."', '".$_GET['v_opl']."','".$_SESSION['podr']."','".$_SESSION['type']."') " ;
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			
				if ($_GET['v_opl']==1)
				{
					$query = "UPDATE `kassa` 
					SET `summ`=`summ`+".$_GET['summ']."
					WHERE `id`=".$_SESSION['kassa'];
					////echo $query."<br />";
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				}
				echo "<a href=\"print.php?type=chek&dnev=".$_SESSION['id']."&table=".$_SESSION['table']."\">Печать чека</a>";
					echo "<a class='mmenu' href=\"pr_opl.php\">Дальше</a>";
				unset($_SESSION['podr']);
				unset($_SESSION['dolg']);
				unset($_SESSION['kassa']);
				unset($_SESSION['id']);
				unset($_SESSION['svn']);
				unset($_SESSION['kop']);
				//ret("pr_dolg.php");
			break;
		}
	break;
}

if (!(isset($_GET['action']))) ret("pr_dolg.php?action=month");
$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
echo "<center>|<a href=\"pr_dolg.php?action=all\" class=\"menu2\">Все пациенты</a>|";
echo "<br>";
echo "<table width='100%' border='0'>
<tr>
<td align='center'>";
 if (isset($_GET['month']))
			{
				$month=$_GET['month'];
			}
		else
			{
				$month=DATE("n");
			}
if (isset($_GET['year']))
			{
				$year=$_GET['year'];
			}
		else
			{
				$year=DATE("Y");
			}
for ($i=0;$i<=11;$i++)
{
	if (($i+1)==$month) $cl="menu8";
	else $cl="menu2"; 
	echo "|<a href=\"pr_dolg.php?action=month&month=".($i+1)."&year=".$year."\" class=\"".$cl."\">".$mn[$i]."</a>|";
	if ($i==5) echo "<br>";
}
echo "</td>
<td align='left'>";
for ($i=2007;$i<=(date('Y')+2);$i++)
{
	if ($i==$year) $cl="menu8";
	else $cl="menu2"; 
	echo "|<a href=\"pr_dolg.php?action=month&month=".$month."&year=".$i."\" class=\"".$cl."\">".$i."</a>|";
	
}
echo "
</td>
</tr>
</table>";


//echo $query."<br>";
echo "<form id='lechf' name='lechf' method='post' action=''>
            <span class='head3'>Список должников:</span>
            <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
              <tr>
                <td width='38%' class='mmenu'>Пациент</td>
				<td width='10%' class='mmenu'>Дата</td>
                <td width='38%' class='mmenu'>Врач</td>
                <td width='14%' class='mmenu'>Сумма<br />
                  долга</td>
                </tr>";

$tables=array ("dnev","zaknar","schet_orto");
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
		if ($_GET['action']=='month')
{
$query = "SELECT 
`".$tables[$j]."`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`".$tables[$j]."`.`summ_k_opl`,`".$tables[$j]."`.`summ_vnes`,`klinikpat`.`id`,`".$tables[$j]."`.`date`
FROM ".$tables[$j].", klinikpat, sotr
WHERE (
(`klinikpat`.`id` =`".$tables[$j]."`.`pat`) AND 
(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
(`".$tables[$j]."`.`summ_k_opl` !=`".$tables[$j]."`.`summ_vnes`)AND
(`".$tables[$j]."`.`date`>='".$year."-".$month."-1') AND
(`".$tables[$j]."`.`date`<='".$year."-".$month."-".date("t",(mktime(0,0,0,$month,1,$year)))."')
)
ORDER BY `klinikpat`.`surname`" ;
}
else
{
$query = "SELECT 
`".$tables[$j]."`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`".$tables[$j]."`.`summ_k_opl`,`".$tables[$j]."`.`summ_vnes`,`klinikpat`.`id`,`".$tables[$j]."`.`date`
FROM ".$tables[$j].", klinikpat, sotr
WHERE (
(`klinikpat`.`id` =`".$tables[$j]."`.`pat`) AND 
(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
(`".$tables[$j]."`.`summ_k_opl` !=`".$tables[$j]."`.`summ_vnes`))
ORDER BY `klinikpat`.`surname`" ;
}

//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode("-",$row['date']);
	echo "<tr><td width='44%'><a href='pr_opl.php?dnev=".$row[0]."&action=pr&step=1&Pid=".$row[9]."&table1=".$tables[$j]."&type=".($j+1)."' class='menu2' title='Принять долг'>".$row[1]." ".$row[2]." ".$row[3]."</a></td>
				<td width='10%' class='head2'>".$dt[2].".".$dt[1].".".$dt[0]."</td>
                <td width='44%' class='head2'>".$row[4]." ".$row[5]." ".$row[6]."</td>
                <td width='12%' class='head2'>".($row[7]-$row[8])." руб</td>
                </tr>";
}
}

echo " </table>
        </form>";
include("footer.php");
?>