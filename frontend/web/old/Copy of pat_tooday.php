<?php
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
		   (`daypr`.`vih` !=1) AND 
		   (`nazn`.`dayPR` =`daypr`.`id`) AND 
		   (`klinikpat`.`id` =`nazn`.`PatID`) AND 
		   (`soderzhnaz`.`id` =`nazn`.`SoderzhNaz`)AND 
		   (`rezobzv`.`id` =`nazn`.`RezObzv`))
	ORDER BY `nazn`.`NachNaz`" ;
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
	echo "<table width='60%' border='1' cellpadding='1' cellspacing='1' bordercolor='#999999'>
	  <tr>
		<td width='10%' class='feature3'>Время</td>
		<td width='50%' class='feature3'>Пациент</td>
		<td width='20%' class='feature3'>Результат обзвона</td>
		<td width='20%' class='feature3'>Действия</td>
	  </tr>";
	
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$NN=explode(":",$row[6]);
			if ($row['10']==1) echo "<tr bgcolor='#42929D'>";
			else echo "<tr>";
			echo "<td class='alltext'>".$NN[0].":".$NN[1]."</td>
				<td class='alltext'><a href=#>".$row['12']." ".$row['13']." ".$row['14']."</a><br>";
			if ($row[3]==1)echo "<span class='bottom2'>Первичный</span>";
			echo " <span class='bottom'>".$row['17']."</span></td>";
			echo "<td class='alltext'>".$row['18']."</td>";
			echo "<td class='alltext' align=center>
	<a href=pat_tooday.php?action=del&Nid=".$row[2]." class='menu2'>Вычеркнуть</a><br>
	<a href='pat_tooday_work.php?perv=".$row[3]."&SodNazn=".$row['16']."&step=1&pat=".$row['11']."' class='menu2'>Начать приём</a></td>";
			echo "</tr>";
		}
	echo "</table>";
	}
	else echo "<center><span class='head1'>Пациентов на сегодня нет</span></center>";
}
include("footer.php");
?>