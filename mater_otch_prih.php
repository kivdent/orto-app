<?php
$ThisVU="stms";
$ModName="Отчёт по приходам"; 
$js="spisok"; 
include("header.php");
$query = "SELECT `id`, `date` FROM `prih` ORDER BY `date` asc";
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
				if ($dt['$z][m']==$months['$j][n'])	echo "<a href='mater_otch_prih.php?id=".$dt['$z][n']."' class='small'>Поступление №".$dt['$z][n']."(".$dt['$z][dt'].")</a><br>";
			}
		}
		echo "</td>";
	}
    echo "</tr></table>";
}
		echo "</form>";	
		if (isset($_GET['id']))
		{
			$query = "SELECT `mater`.`naim`, `mater_prih`.`Price`, `mater_prih`.`kol-vo`
			FROM mater, mater_prih
			WHERE ((`mater`.`id` =`mater_prih`.`mater`) AND (`mater_prih`.`prih` ='".$_GET['id']."'))";
			////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);				
			echo "			<table width='100%' border='1' cellspacing='0' cellpadding='0'>
				  <tr>
					<td width='60%'>Материал</td>
					<td width='17%'>Цена</td>
					<td width='25%'>Количество</td>
					<td width='18%'>Стоимость</td>
				  </tr>";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);

				echo "    <tr class='smalltext'>
					<td>".$row['naim']."</td>
					<td>".$row['Price']."</td>
					<td>".$row[2]."</td>
					<td>".($row['Price']*$row[2])."</td>
				  </tr>";
			  }
			echo "</table>";
			echo "<a href=\"print.php?type=mater_otch_prih&id=".$_GET['id']."\" class='menu2'>Печать отчёта</a>";
		}
include("footer.php");
?>