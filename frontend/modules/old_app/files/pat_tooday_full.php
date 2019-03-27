<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Пациенты на сегодня";
include("header.php");
if (isset($_SESSION['pat'])) unset($_SESSION['pat']);
if (isset($_SESSION['OsmID'])) unset($_SESSION['OsmID']);
if ($_GET['action']=='del')
{
	$query = "DELETE FROM nazn WHERE Id=".$_GET['Nid'] ;
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
}
else
{
	$query = "SELECT `daypr`.`date`, `daypr`.`id`, `nazn`.*, `klinikpat`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `nazn`.`PatID`, `soderzhnaz`.*,`rezobzv`.`RezObzv`
	FROM daypr, nazn, klinikpat, soderzhnaz, rezobzv
	WHERE ((`daypr`.`date` ='".date('Y-m-d')."') AND
			(`daypr`.`vrachID`=".$_SESSION['UserID'].") AND 
		   (`daypr`.`vih` !=1) AND 
		   (`nazn`.`dayPR` =`daypr`.`id`) AND 
		   (`klinikpat`.`id` =`nazn`.`PatID`) AND 
		   (`soderzhnaz`.`id` =`nazn`.`SoderzhNaz`)AND 
		   (`rezobzv`.`id` =`nazn`.`RezObzv`))
	ORDER BY `nazn`.`NachNaz`" ;
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$countB=$count;
	$resultB=$result;
	if ($countB>0)
	{
	echo "<table width='60%' border='1' cellpadding='1' cellspacing='1' bordercolor='#999999'>
	  <tr>
		<td width='10%' class='feature3'>Время</td>
		<td width='50%' class='feature3'>Пациент</td>
		<td width='20%' class='feature3'>Результат обзвона</td>
		<td width='20%' class='feature3'>Действия</td>
	  </tr>";
	
		for ($i=0;$i<$countB;$i++)
		{
			$rowB = mysqli_fetch_array($resultB);
			$query = "SELECT * FROM `dnev` 
							WHERE (
							(`pat`=".$rowB['11'].") AND
							(`vrach`=".$_SESSION['UserID'].") AND
							(`date`='".date('Y-m-d')."'))";
			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$flag=0;
			if ($count>0) $flag=1;
			
			$NN=explode(":",$rowB[6]);
			if ($rowB['10']==1) echo "<tr bgcolor='#CCCCFF'>";
			else echo "<tr>";
			echo "<td class='alltext'>".$NN[0].":".$NN[1]."</td>
				<td class='alltext'>
				<span class='bottom'>Карта №".$rowB['11']."</span></br>	
				<a href='pat_card.php?id=".$rowB['11']."&ro=0' class='menu2' target='_blank'>".$rowB['12']." ".$rowB['13']." ".$rowB['14']."</a><br>";
			if ($rowB[3]==1)echo "<span class='bottom2'>Первичный</span>";
			echo " <span class='bottom'>".$rowB['17']."</span></td>";
			echo "<td class='alltext'>".$rowB['18']."</td>";
			echo "<td class='alltext' align=center>";
		echo "<a href=pat_tooday.php?action=del&Nid=".$rowB[2]." class='menu2'>Вычеркнуть</a><br>";

//		старый		echo "<a href='pat_tooday_work.php?perv=".$rowB[3]."&SodNazn=".$rowB['16']."&step=1&pat=".$rowB['11']."' class='menu2'>Начать приём</a>";
echo "<a href='pat_tooday_work_full.php?&pat=".$rowB['11']."' class='menu2'>Начать приём</a>";
	
			echo "</td></tr>";
		}
	echo "</table>";
	}
	else echo "<center><span class='head1'>Пациентов на сегодня нет</span></center>";
}
echo " <script language=\"JavaScript\" type=\"text/javascript\">
						setTimeout(\"javascript:location.href='pat_tooday.php'\", 60000);
						</script>";	
include("footer.php");
?>