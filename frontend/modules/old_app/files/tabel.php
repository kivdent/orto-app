<?php
$ThisVU="all";
$this->title="Заполнение табеля";
//include("header.php");
switch ($_GET['action'])
{
	case "set_time":
		switch ($_GET['step'])
		{
			case "1":
				echo "<script language=\"JavaScript\" type=\"text/javascript\">
						q=prompt('Введите количество часов',0);
						url='tabel.php?action=set_time&sotr=".$_GET['sotr']."&date=".$_GET['date']."&step=2&time='+q;
						location.href=url;
						</script>
					";
				//include("footer.php");	
				exit;
			break;
			case "2":
				$query = "INSERT INTO `tabel` (`id`, `sotr`, `date`, `time`)
				VALUES (NULL, ".$_GET['sotr'].", '".$_GET['date']."', ".$_GET['time'].")";
				////echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('tabel.php');
				//include("footer.php");	
				exit;
			break;
		}
	break;
	case "ch_time":
		switch ($_GET['step'])
		{
			case "1":
				echo "<script language=\"JavaScript\" type=\"text/javascript\">
						q=prompt('Введите количество часов',0);
						url='tabel.php?action=ch_time&tid=".$_GET['tid']."&step=2&time='+q;
						location.href=url;
						</script>
					";
				//include("footer.php");	
				exit;
			break;
			case "2":
				if ($_GET['time']>0)
				{
					$query = "UPDATE `tabel` 
					SET `time`=".$_GET['time']."
					where id=".$_GET['tid'];
				}
				else
				{
					$query = "DELETE FROM `tabel` 
					where id=".$_GET['tid'];
				}
				echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('tabel.php');
				//include("footer.php");	
				exit;
			break;
		}
	break;
}
//echo "<span class=\"menutext2\">Заполнения табеля. Сегодня: ".date("m.d.Y").".</span><br />
//		<form action='' method='get' name='sotr'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
//  <tr>
//    <td width='21%' class='feature7'>Сотрудник</td>
//    <td width='79%'>";
//	$query = "SELECT `sotr`.`id` , `sotr`.`surname` , `sotr`.`name` , `sotr`.`otch`, `dolzh`.`dolzh`
//FROM sotr, dolzh
//WHERE (
//(
//`sotr`.`dolzh` 
//IN ( 1, 2, 3, 4, 5, 6 ) 
//)
//AND (
//`dolzh`.`id` = `sotr`.`dolzh` 
//)
//)
//ORDER BY `dolzh`.`dolzh` ASC , `sotr`.`surname` ASC 
//" ;
//////echo $query."<br>";
//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//echo "<select name='sotr'>";
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysqli_fetch_array($result);
//	echo "<option value='".$row['id']."'>".$row[1]." ".$row[2]." ".$row[3]."</option>";
//}
//	
//	echo "</select></td>
//  </tr>
//  <tr>
//    <td class='feature7'>Количество часов</td>
//    <td><input name='QTime' type='text' id='QTime' size='3' maxlength='4' /></td>
//  </tr>
//</table>
//<center><input name='action' type='hidden' value='save' />
//<input name='' type='submit'  value='Сохранить'/></center>
//</form><br />";

	$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
	echo "<div class=\"head1\">Табель за ".$mn['(date("n")-1)']."</div>";
	//$query = "SELECT `nach` , `okonch` 
//FROM `fin-per` 
//ORDER BY `id` DESC 
//LIMIT 0,1" ;
$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
WHERE `id`=13";
//////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN_TS=mktime(0,0,0,(integer)$dtNp[1],(integer)$dtNp[2],(integer)$dtNp[0]);
$dtO_TS=mktime(0,0,0,(integer)$dtOp[1],(integer)$dtOp[2],(integer)$dtOp[0]);
//$dtN_TS=mktime(0,0,0,12,3,2007);
//$dtO_TS=mktime(0,0,0,12,31,2007);
//mktime(
$dtN=$row['nach'];
$dtO=$row['okonch'];
//msg($dtN_TS." - ".$dtO_TS);
	$query = "SELECT `sotr`.`id`, `tabel`.`time`,`tabel`.`date`,`tabel`.`id` AS tid
FROM sotr, tabel
WHERE (
(`tabel`.`date` >='".$dtN."') AND 
(`tabel`.`date` <='".$dtO."') AND 
(`tabel`.`sotr` =`sotr`.`id`)
)
ORDER BY `sotr`.`surname` ASC, `tabel`.`date` ASC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$q=1;
if ($count>0)
{
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode("-",$row['date']);
	$dt2=mktime(0,0,0,$dt[1],$dt[2],$dt[0]);
	$r[$row['id']][$dt2]['tm']=$row['time'];
	$r[$row['id']][$dt2]['id']=$row['tid'];
}

}
unset($dt);


echo " <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
          <tr>
            <td width='135' class='head3'>Сотрудник</td>";
for ($q=$dtN_TS;$q<=$dtO_TS; $q+=60*60*24)
{
	if ((date('D',$q)=='Sun') or (date('D',$q)=='Sat')) $bg="bgcolor='#999999'";
	else $bg="";
	echo "<td class='head3' ".$bg.">".date('d.m',$q)."</td>";
	//echo "<td>".$q."</td>";
}
echo "<td class='head3'>Итого</td>";
echo "</tr>";
$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`
FROM sotr
WHERE `sotr`.`dolzh` IN (4,5,6,7)
ORDER BY `sotr`.`surname` ASC";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($j=1;$j<=$count;$j++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr><td class='head2'>".$row['surname']." ".$row['name']." ".$row['otch']."</td>";
	$summ=0;
	for ($i=$dtN_TS;$i<=$dtO_TS; $i+=60*60*24)
	{if ((date('D',$i)=='Sun') or (date('D',$i)=='Sat')) $bg="bgcolor='#cccccc'";
	else $bg="";
		if (isset($r[$row['id']][$i]['tm']))
		{$summ+=(floor($r[$row['id']][$i]['tm'])*60)+(($r[$row['id']][$i]['tm']-floor($r[$row['id']]['$i][tm']))*100);
			
			echo "<td width='20' align='center' valign='middle' ".$bg."><a href=\"tabel.php?action=ch_time&tid=".$r[$row['id']][$i]['id']."&step=1\" class='menu7'>".$r[$row['id']][$i]['tm']."</a></td>";
			
		}
		else 
		{
			echo "<td width='20' align='center' valign='middle' ".$bg."><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m-d",$i)."&step=1\" class='menu7'>0</a></td>";
		}
	}
	//for ($j=1;$j<=date("d");$j++)
//	{
//		if (isset($r['$row['id']']['$j][tm'])) echo "<td align='center' valign='center'>".$r['$row['id']']['$j][tm']."</td>";
//		else if ($j<10) echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-0".$j."&step=1\">0</a></td>";
//			else  echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-".$j."&step=1\">0</a></td>";
//	}
$summ=(floor($summ/60))+((($summ/60-floor($summ/60))*60)/100);
//$summ=(round($summ/60,));
	
echo "<td align='center' valign='middle' class='head2'>".$summ."</td>";
	echo "</tr>";
		
}
echo "</table>";
//include("footer.php");		
?>