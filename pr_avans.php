<?php
session_start();
include('mysql_fuction.php');
$ThisVU="registrator";
$ModName="Приём аванса";
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

if (!(isset($_GET['pat'])))
{
	echo "<div class='head3'>Выбирите пациента из списка</div>";
	//////создание списка пациентов
	$query = 'select id,surname,name,otch,dr from klinikpat order by surname asc';
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	echo "<form action='pr_avans.php' method='get' name='avf' id='avf'>";
	echo "<select name='pat' size='10' ondblclick='document.avf.submit()'>";
	for ($i=0; $i <$count; $i++)
	{
		$row = mysqli_fetch_array($result);
		echo    "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	}
	echo "</select>";
	echo "<input name='step' type='hidden' value='1'><br>";
	echo "<input name='ok' type='submit' value='Выбрать пациента'>";
	echo "</form>";
}
switch ($_GET['step'])
{
	
	case "1":
		$query = "SELECT * FROM `klinikpat` WHERE `id`=".$_GET['pat'] ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		echo "<form action='' method='get' >
				<input name='pat' type='hidden' value='".$_GET['pat']."' />
				<input name='step' type='hidden' value='2' />
				<div class='head2'>Пациент: ".$row['surname']." ".$row['name']." ".$row['otch']."<br />
				Сумма аванса:
				<input name='av' type='text' id='av' />
				</div>
				<input name='ok' type='submit' value='OK'>
				</form>";
	break;
	case "2":
		$query = "SELECT `id`, `avans`  FROM `avans` WHERE `pat`=".$_GET['pat'] ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		if ($count>0)
		{
			$av=$_GET['av']+$row['avans'];
			$query = "UPDATE `avans` 
					SET `avans`=".$av."
					WHERE `pat`=".$_GET['pat'];
		}
		else
		{
			$query = "INSERT INTO `avans` (`id`, `pat`, `avans`) VALUES (NULL,'".$_GET['pat']."','".$_GET['av']."')" ;
		}
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "INSERT INTO `pr_avans` (`id`,`date`, `time`, `pat`, `summ`) VALUES (NULL,'".date('Y-m-d')."','".date('H:i').":00','".$_GET['pat']."','".$_GET['av']."')";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "UPDATE `kassa` 
SET `summ`=`summ`+".$_GET['av']."
WHERE `id`=".$_SESSION['kassa'];
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("pat_tooday_reg.php");
	break;
}
include("footer.php");
?>