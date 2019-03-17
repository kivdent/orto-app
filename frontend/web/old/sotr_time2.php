<?php
$ThisVU="all";
$ModName="Учёт рабочего времени сотрудников";
include("header.php");
switch ($_GET['action'])
{
	case "set_time_in":
		switch ($_GET['step'])
		{
			case "1":
				$query = "INSERT INTO `tabel_reg` (`id`, `sotr`, `date`, `in`)
				VALUES (NULL, ".$_GET['sotr'].", '".date("Y-m-d")."', '".date("H:i").":00')";
				//echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('sotr_time.php');
				include("footer.php");	
				exit;
			break;

		}
	break;
	case "ch_time_in":
		switch ($_GET['step'])
		{
			case "1":
				$query = "UPDATE `tabel_reg` 
					SET `in`='".date("H:i").":00'
					where id=".$_GET['tid'];
				//echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('sotr_time.php');
				include("footer.php");	
				exit;
			break;
		}
	break;
		case "ch_time_out":
		switch ($_GET['step'])
		{
			case "1":
				$query = "UPDATE `tabel_reg` 
					SET `out`='".date("H:i").":00'
					where id=".$_GET['tid'];
				//echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('sotr_time.php');
				include("footer.php");	
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
//echo $query."<br>";
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
switch ($_SESSION['user_prava'])
{
//директор
case "13":

	$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
	echo "<div class=\"head1\">Табель за ".$mn['(date("n")-1)']."</div>";
	$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//echo $query."<br>";
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
	$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."')
)
ORDER BY `sotr` ASC, `date` ASC";
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
	
	$in=explode(":",$row['in']);
	$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
	$out=explode(":",$row['out']);
	$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
	
	$r['$row['id']']['$dt2][in']=$row['in'];
	$r['$row['id']']['$dt2][out']=$row['out'];
	if(($out2-$in2)>0) 
	{	
	$r['$row['id']']['$dt2][tm']=($out2-$in2);
	}
	else  $r['$row['id']']['$dt2][tm']=0;
	$r['$row['id']']['$dt2][id']=$row['tid'];
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
	echo "<td class='bottom' ".$bg.">".date('d',$q)."</td>";
	//echo "<td>".$q."</td>";
}
echo "<td class='head3'>Итого</td>";
echo "</tr>";
$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`
FROM sotr
ORDER BY `sotr`.`surname` ASC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($j=1;$j<=$count;$j++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr><td class='head2'>".$row['surname']."</td>";
	$summ=0;
	for ($i=$dtN_TS;$i<=$dtO_TS; $i+=60*60*24)
	{
	if ((date('D',$i)=='Sun') or (date('D',$i)=='Sat')) $bg="bgcolor='#cccccc'";
	else $bg="";
	if (date("Y-m-d")==date("Y-m-d",$i))
	{
		if ($r['$row['id']']['$i][tm']>0)
		{
			
			if ($r['$row['id']']['$i][tm']<=0)
			{
				
				echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=ch_time_in&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][in']."</a><br>
				<a href=\"sotr_time.php?action=ch_time_out&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>Ушёл</a>
				</td>";
			}
			else
			{
			//msg ($r['$row['id']']['$i][tm']);
			$summ+=$r['$row['id']']['$i][tm'];
			echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=ch_time_in&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][in']."</a><br>
				<a href=\"sotr_time.php?action=ch_time_out&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][out']."</a><br>
				".(floor($r['$row['id']']['$i][tm']/3600))." ч: ".((($r['$row['id']']['$i][tm'])-floor($r['$row['id']']['$i][tm']/3600)*3600)/60)." м 
				</td>";	
				}
		}
		else 
		{
			if ($r['$row['id']']['$i][in']!=$r['$row['id']']['$i][out'])
			{
				echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=ch_time_in&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][in']."</a><br>
				<a href=\"sotr_time.php?action=ch_time_out&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>Ушёл</a>
				</td>";
			}
			else
			{
			 echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=set_time_in&sotr=".$row['id']."&date=".date("Y-m-d",$i)."&step=1\" class='menu7'>Пришёл</a></td>";
			}
		
		}
		}
		else
		{
			
			if ($r['$row['id']']['$i][tm']>0)
		{
			
			$summ+=$r['$row['id']']['$i][tm'];	echo "<td class='bottom'  width='20' align='center' valign='middle' ".$bg.">".$r['$row['id']']['$i][in']."<br>".$r['$row['id']']['$i][out']."<br>".(floor($r['$row['id']']['$i][tm']/3600))." ч: ".((($r['$row['id']']['$i][tm'])-floor($r['$row['id']']['$i][tm']/3600)*3600)/60)." м <br>
			</td>";
		}
		else 
		{

			 echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">В</td>";
		
		}	
					
			
		}
	}
	//for ($j=1;$j<=date("d");$j++)
//	{
//		if (isset($r['$row['id']']['$j][tm'])) echo "<td align='center' valign='center'>".$r['$row['id']']['$j][tm']."</td>";
//		else if ($j<10) echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-0".$j."&step=1\">0</a></td>";
//			else  echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-".$j."&step=1\">0</a></td>";
//	}
$summ=(floor($summ/3600))." ч: ".((($summ)-floor($summ/3600)*3600)/60)." м";
echo "<td align='center' valign='middle' class='head2'>".$summ."</td>";
	echo "</tr>";
		
}
echo "</table>";	
include("footer.php");
exit;

break;



//регистратор
case "5":
	$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
	echo "<div class=\"head1\">Табель за ".$mn['(date("n")-1)']."</div>";
	$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//echo $query."<br>";
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

$dtN_TS=$dtO_TS=mktime(0,0,0,date('m'),date('d'),date('Y'));
$dtN=$dtO=date("Y-m-d");

	$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."')
)
ORDER BY `sotr` ASC, `date` ASC";
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
	
	$in=explode(":",$row['in']);
	$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
	$out=explode(":",$row['out']);
	$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
	
	$r['$row['id']']['$dt2][in']=$row['in'];
	$r['$row['id']']['$dt2][out']=$row['out'];
	if(($out2-$in2)>0) 
	{	
	$r['$row['id']']['$dt2][tm']=($out2-$in2);
	}
	else  $r['$row['id']']['$dt2][tm']=0;
	$r['$row['id']']['$dt2][id']=$row['tid'];
}

}
unset($dt);
//print_r($dtO_TS);
//print_r($r);
echo " <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
          <tr>
            <td width='135' class='head3'>Сотрудник</td>";
for ($q=$dtN_TS;$q<=$dtO_TS; $q+=60*60*24)
{
	if ((date('D',$q)=='Sun') or (date('D',$q)=='Sat')) $bg="bgcolor='#999999'";
	else $bg="";
	echo "<td class='bottom' ".$bg.">".date('d',$q)."</td>";
	//echo "<td>".$q."</td>";
}
echo "<td class='head3'>Итого</td>";
echo "</tr>";
$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`
FROM sotr
ORDER BY `sotr`.`surname` ASC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($j=1;$j<=$count;$j++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr><td class='head2'>".$row['surname']."</td>";
	$summ=0;
	for ($i=$dtN_TS;$i<=$dtO_TS; $i+=60*60*24)
	{
	if ((date('D',$i)=='Sun') or (date('D',$i)=='Sat')) $bg="bgcolor='#cccccc'";
	else $bg="";
	if (date("Y-m-d")==date("Y-m-d",$i))
	{
		if ($r['$row['id']']['$i][tm']>0)
		{
			
			if ($r['$row['id']']['$i][tm']<=0)
			{
				
				echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=ch_time_in&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][in']."</a><br>
				<a href=\"sotr_time.php?action=ch_time_out&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>Ушёл</a>
				</td>";
			}
			else
			{
			//msg ($r['$row['id']']['$i][tm']);
			$summ+=$r['$row['id']']['$i][tm'];
			echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=ch_time_in&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][in']."</a><br>
				<a href=\"sotr_time.php?action=ch_time_out&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][out']."</a><br>
				".(floor($r['$row['id']']['$i][tm']/3600))." ч: ".((($r['$row['id']']['$i][tm'])-floor($r['$row['id']']['$i][tm']/3600)*3600)/60)." м 
				</td>";	
				}
		}
		else 
		{
			if ($r['$row['id']']['$i][in']!=$r['$row['id']']['$i][out'])
			{
				echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=ch_time_in&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>".$r['$row['id']']['$i][in']."</a><br>
				<a href=\"sotr_time.php?action=ch_time_out&tid=".$r['$row['id']']['$i][id']."&step=1\" class='menu7'>Ушёл</a>
				</td>";
			}
			else
			{
			 echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg."><a href=\"sotr_time.php?action=set_time_in&sotr=".$row['id']."&date=".date("Y-m-d",$i)."&step=1\" class='menu7'>Пришёл</a></td>";
			}
		
		}
		}
		else
		{
			
			if ($r['$row['id']']['$i][tm']>0)
		{
			
			$summ+=$r['$row['id']']['$i][tm'];	echo "<td class='bottom'  width='20' align='center' valign='middle' ".$bg.">".$r['$row['id']']['$i][in']."<br>".$r['$row['id']']['$i][out']."<br>".(floor($r['$row['id']']['$i][tm']/3600))." ч: ".((($r['$row['id']']['$i][tm'])-floor($r['$row['id']']['$i][tm']/3600)*3600)/60)." м <br>
			</td>";
		}
		else 
		{

			 echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">В</td>";
		
		}	
					
			
		}
	}
	//for ($j=1;$j<=date("d");$j++)
//	{
//		if (isset($r['$row['id']']['$j][tm'])) echo "<td align='center' valign='center'>".$r['$row['id']']['$j][tm']."</td>";
//		else if ($j<10) echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-0".$j."&step=1\">0</a></td>";
//			else  echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-".$j."&step=1\">0</a></td>";
//	}
$summ=(floor($summ/3600))." ч: ".((($summ)-floor($summ/3600)*3600)/60)." м";
echo "<td align='center' valign='middle' class='head2'>".$summ."</td>";
	echo "</tr>";
		
}
echo "</table>";	
include("footer.php");
exit;
break;




// остатльные
default:
	$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
	echo "<div class=\"head1\">Табель за ".$mn['(date("n")-1)']."</div>";
	$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//echo $query."<br>";
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
	$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."')
)
ORDER BY `sotr` ASC, `date` ASC";
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
	
	$in=explode(":",$row['in']);
	$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
	$out=explode(":",$row['out']);
	$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
	
	$r['$row['id']']['$dt2][in']=$row['in'];
	$r['$row['id']']['$dt2][out']=$row['out'];
	if(($out2-$in2)>0) 
	{	
	$r['$row['id']']['$dt2][tm']=($out2-$in2);
	}
	else  $r['$row['id']']['$dt2][tm']=0;
	$r['$row['id']']['$dt2][id']=$row['tid'];
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
	echo "<td class='bottom' ".$bg.">".date('d',$q)."</td>";
	//echo "<td>".$q."</td>";
}
echo "<td class='head3'>Итого</td>";
echo "</tr>";
$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`
FROM sotr
ORDER BY `sotr`.`surname` ASC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($j=1;$j<=$count;$j++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr><td class='head2'>".$row['surname']."</td>";
	$summ=0;
	for ($i=$dtN_TS;$i<=$dtO_TS; $i+=60*60*24)
	{
	if ((date('D',$i)=='Sun') or (date('D',$i)=='Sat')) $bg="bgcolor='#cccccc'";
	else $bg="";
	if (date("Y-m-d")==date("Y-m-d",$i))
	{
		if ($r['$row['id']']['$i][tm']>0)
		{
			
			if ($r['$row['id']']['$i][tm']<=0)
			{
				
				echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">".$r['$row['id']']['$i][in']."<br>
				</td>";
			}
			else
			{
			//msg ($r['$row['id']']['$i][tm']);
			$summ+=$r['$row['id']']['$i][tm'];
			echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">".$r['$row['id']']['$i][in']."<br>
				".$r['$row['id']']['$i][out']."<br>
				".(floor($r['$row['id']']['$i][tm']/3600))." ч: ".((($r['$row['id']']['$i][tm'])-floor($r['$row['id']']['$i][tm']/3600)*3600)/60)." м 
				</td>";	
				}
		}
		else 
		{
			if ($r['$row['id']']['$i][in']!=$r['$row['id']']['$i][out'])
			{
				echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">".$r['$row['id']']['$i][in']."<br>
				</td>";
			}
			else
			{
			 echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">&nbsp</td>";
			}
		
		}
		}
		else
		{
			
			if ($r['$row['id']']['$i][tm']>0)
		{
			
			$summ+=$r['$row['id']']['$i][tm'];	echo "<td class='bottom'  width='20' align='center' valign='middle' ".$bg.">".$r['$row['id']']['$i][in']."<br>".$r['$row['id']']['$i][out']."<br>".(floor($r['$row['id']']['$i][tm']/3600))." ч: ".((($r['$row['id']']['$i][tm'])-floor($r['$row['id']']['$i][tm']/3600)*3600)/60)." м <br>
			</td>";
		}
		else 
		{

			 echo "<td class='bottom' width='20' align='center' valign='middle' ".$bg.">В</td>";
		
		}	
					
			
		}
	}
	//for ($j=1;$j<=date("d");$j++)
//	{
//		if (isset($r['$row['id']']['$j][tm'])) echo "<td align='center' valign='center'>".$r['$row['id']']['$j][tm']."</td>";
//		else if ($j<10) echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-0".$j."&step=1\">0</a></td>";
//			else  echo "<td><a href=\"tabel.php?action=set_time&sotr=".$row['id']."&date=".date("Y-m")."-".$j."&step=1\">0</a></td>";
//	}
//$summ=(floor($summ/3600))." ч: ".((($summ)-floor($summ/3600)*3600)/60)." м";
$summ=round($summ/3600,2);
echo "<td align='center' valign='middle' class='head2'>".$summ."</td>";
	echo "</tr>";
		
}
echo "</table>";	
include("footer.php");
exit;		
break;
}
?>