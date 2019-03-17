<?php
$ThisVU="stms";
$ModName="Отчёт по списанию"; 
$js="spisok"; 
include("header.php");
$query = "SELECT `id`, `date` FROM `mater_spis` ORDER BY `date`";
////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$months['1][n']=01;
$months['1][nazv']='Январь';
$months['2][n']=02;
$months['2][nazv']='Февраль';
$months['3][n']=03;
$months['3][nazv']='Март';
$months['4][n']=04;
$months['4][nazv']='Апрель';
$months['5][n']=05;
$months['5][nazv']='Май';
$months['6][n']=06;
$months['6][nazv']='Июнь';
$months['7][n']=07;
$months['7][nazv']='Июль';
$months['8][n']=08;
$months['8][nazv']='Август';
$months['9][n']=09;
$months['9][nazv']='Сентябрь';
$months['10][n']=10;
$months['10][nazv']='Октябрь';
$months['11][n']=11;
$months['11][nazv']='Ноябрь';
$months['12][n']=12;
$months['12][nazv']='Декабрь';
$cp=$count;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$d=explode('-',$row['date']);
	if ($i==0)
	{
		$yn=$d[0];
		$yo=$d[0];
	}
	if ($d[0]>$yo) $yo=$d[0];
	$dt['$i][y']=$d[0];
	$dt['$i][m']=$d[1];
	$dt['$i][d']=$d[2];
	$dt['$i][dt']=$d[2].".".$d[1].".".$d[0];
	$dt['$i][n']=$row['id'];
}
echo "<form action='mater_otch_prih.php' method='get' name='otch' id='otch'>";
for ($i=$yn;$i<=$yo;$i++)
{ 
	echo "<div class=\"head3\">".$i."</div><table width='100%' border='1' cellspacing='0' cellpadding='0'>";
          
	for ($j=1;$j<=12;$j++)
	{
		echo "<td valign='top' class='smaltext'>".$months['$j][nazv']."<hr width='100%' noshade='noshade' size='1'/>
";
		for ($z=0;$z<$cp;$z++)
		{
			if ($dt['$z][y']==$i)
			{	
				if ($dt['$z][m']==$months['$j][n'])	echo "<a href='mater_otch_spis.php?id=".$dt['$z][n']."' class='small'>Списание №".$dt['$z][n']."(".$dt['$z][dt'].")</a><br>";
			}
		}
		echo "</td>";
	}
    echo "</tr></table>";
}
		echo "</form>";	
		if (isset($_GET['id']))
		{
			$query = "SELECT `mesta_hr`.`nazv`
FROM mesta_hr, mater_spis
WHERE ((`mesta_hr`.`id` =`mater_spis`.`mesto_hr`) AND (`mater_spis`.`id` ='".$_GET['id']."'))";
			////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			echo "<div class=\"head2\">
			Место хранения: \"".$row['nazv']."\"
			</div>";
			$query = "SELECT `mater`.`naim`,`mater_spis_soot`.`kolvo`
FROM mater, mater_spis_soot
WHERE ((`mater`.`id` =`mater_spis_soot`.`mater`) AND (`mater_spis_soot`.`mater_spis` ='".$_GET['id']."'))";
			////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);				
			echo "			<table width='50%' border='1' cellspacing='0' cellpadding='0'>
				  <tr>
					<td width=80%>Материал</td>
					<td width=20%>Количество</td>
				  </tr>";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);

				echo "    <tr class='smalltext'>
					<td>".$row['naim']."</td>
					<td>".$row[1]."</td>
				  </tr>";
			  }
			echo "</table>";
			echo "<a href=\"print.php?type=mater_otch_spis&id=".$_GET['id']."\" class='menu2'>Печать отчёта</a>";
		}
include("footer.php");
?>