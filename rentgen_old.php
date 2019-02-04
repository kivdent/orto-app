<?php
$ThisVU="all";
$ModName="Рентгенология";
include("header.php");
switch ($_GET['action'])
{
	case "setAssist":
		$query = "INSERT INTO `xray_uch` (`id`, `sotr`, `manip_pr`,`type`)
VALUES (NULL, '".$_GET['asstID']."', '".$_GET['ManipPr']."', '".$_GET['type1']."')" ;
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("rentgen.php?type=".$_GET['type']);
		include("footer.php");
		exit;
	break;
	case "chAssist":
		$query = "UPDATE xray_uch
				  SET sotr='".$_GET['asstID']."' 
				  WHERE id='".$_GET['XrayID']."'" ;
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("rentgen.php?type=".$_GET['type']);
		include("footer.php");
		exit;
	break;
}
echo "<div class=\"head1\">Регистрация рентгеновских снимков</div>";

		echo "<div class='head1'>
Учёт снимков
		  </div>";
$query = "SELECT `id`,`manip_pr`,`sotr`,`type` FROM `xray_uch` ORDER by `manip_pr`" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>0) 
{
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$xRayUcht['$row['type']']['$row['manip_pr]'][id']=$row['id'];
	$xRayUcht['$row['type']']['$row['manip_pr]'][sotr']=$row['sotr'];
}
}
		 $query = "SELECT `id`, `surname`, `name`, `otch` FROM `sotr` WHERE `dolzh`=5 ORDER BY surname" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$asstCount=$count;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$asst['$i][name']=$row[1]." ".$row[2]." ".$row[3];
	$asst['$i][id']=$row[0];
}
		  $query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN=$row['nach'];
$dtO=$row['okonch'];
		  echo "<center><a href=\"rentgen.php?type=per\" class=menu2>".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</a> | <a href=\"rentgen.php?type=today\" class=menu2>".date('d.m.Y')."	</a></center>";	
switch ($_GET['type'])
{
	case "today":
$inc="(`dnev`.`date` ='".date('Y-m-d')."')";
$type="&type=today";
	break;
	case "per":
	$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN=$row['nach'];
$dtO=$row['okonch'];
echo "<div class=\"head3\">Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</div>";
$inc="(`dnev`.`date` >='".$dtN."') AND (`dnev`.`date` <'".$dtO."')";
$type="&type=per";
	break;
	
}
$tables[0]=array ("dnev","`manip_pr`","`manip_pr`.`dnev`");
$tables[1]=array ("zaknar","`manip_zn`","`manip_zn`.`ZN`");
$tables[2]=array ("schet_orto","`manip_sh_orto`","`manip_sh_orto`.`SO`");
$c=0;
for ($j=0;$j<=2;$j++)
{
	switch ($_GET['type'])
{
	case "today":
		$inc="(`".$tables['$j][0']."`.`date` ='".date('Y-m-d')."')";
	break;
	case "per":
		$inc="(`".$tables['$j][0']."`.`date` >='".$dtN."') AND (`".$tables['$j][0']."`.`date` <'".$dtO."')";
	break;
	
}
	$query="SELECT `klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		".$tables['$j][1'].".`kolvo`, 
		`manip`.`price`, 
		".$tables['$j][1'].".`id`,
		`sotr`.`surname`,
		`sotr`.`name`,
		`sotr`.`otch`,
		`".$tables['$j][0']."`.`date`
	FROM klinikpat, ".$tables['$j][1'].", manip, ".$tables['$j][0'].", sotr
	WHERE (
	(`klinikpat`.`id` =`".$tables['$j][0']."`.`pat`) AND 
	".$inc."AND 
	(".$tables['$j][2']." =`".$tables['$j][0']."`.`id`) AND 
	(`manip`.`id` IN (26,27,254,255)) AND 
	(".$tables['$j][1'].".`manip` =`manip`.`id`) AND
	(`sotr`.`id`=`".$tables['$j][0']."`.`vrach`)	
	)
	ORDER BY `".$tables['$j][0']."`.`date`";
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
	{
		$c++;
		$row = mysqli_fetch_array($result);
		$dt=explode("-",$row['date']);
		$manip['$c][date']=$dt[2].".".$dt[1].".".$dt[0];
		if (isset($xRayUcht['$j']['$row['5]'][sotr']))
		{
			$manip['$c][PatName']=$row[0]." ".$row[1]." ".$row[2];
			$manip['$c][KolVo']=$row[3]." (".($row[3]*$row[4])."р.)";
			$manip['$c][sotr']=$xRayUcht['$j']['$row['5]'][sotr'];
			$manip['$c][vrach']="<div class='bottom'>(".$row[6]." ".$row[7]." ".$row[8].")</div>";
			$manip['$c][act']="rentgen.php?action=chAssist&XrayID=".$xRayUcht['$row['5]'][id'].$type;
		}
		else
		{
			$manip['$c][PatName']=$row[0]." ".$row[1]." ".$row[2];
			$manip['$c][KolVo']=$row[3]." (".($row[3]*$row[4])."р.)";
			$manip['$c][sotr']=0;
			$manip['$c][act']="rentgen.php?type1=".$j."&action=setAssist&ManipPr=".$row[5].$type;
			$manip['$c][vrach']="<div class='bottom'>(".$row[6]." ".$row[7]." ".$row[8].")</div>";
		}
	}
}
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000'>
  <tr>
    <td><div align='center'>Пациент</div></td>
    <td><div align='center'>Врач</div></td>
    <td><div align='center'>Дата</div></td>
    <td><div align='center'>К-во(сумма)</div></td>
    <td><div align='center'>Ассистент</div></td>
  </tr>";
for ($i=1;$i<=$c;$i++)
{
//	$row = mysqli_fetch_array($result);
	$dt=explode("-",$row['date']);
     echo " <tr>
    <td>".$manip['$i][PatName']."</td>
    <td><div align='center'>".$manip['$i][vrach']."</div></td>
    <td><div align='center'>".$manip['$i][date']."</div></td>
    <td align='center'>".$manip['$i][KolVo']."</td>
    <td><script type=\"text/JavaScript\">
function MM_jumpMenu(targ,selObj,restore){ 
  eval(targ+\".location='\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}

</script>
<form name=\"form1\" id=\"form1\">
  <select name=\"menu1\" onchange=\"MM_jumpMenu('parent',this,0)\">";
   if ($manip['$i][sotr']==0)
   {
   		 echo " <option value='rentgen.php?type=".$_GET['type']."' selected='selected'>&nbsp;</option>";
   }
   for ($j=0;$j<$asstCount;$j++)
   {
	   if ($manip['$i][sotr']==0)
	   {
		  echo " <option value='".$manip['$i][act']."&asstID=".$asst['$j][id']."'>".$asst['$j][name']."</option>";
		}
		else
		  {
		  if ($asst['$j][id']==$manip['$i][sotr'])  echo " <option value='".$manip['$i][act']."&asstID=".$asst['$j][id']."' selected='selected'>".$asst['$j][name']."</option>";
		  else echo " <option value='".$manip['$i][act']."&asstID=".$asst['$j][id']."' >".$asst['$j][name']."</option>";
		  }
   }
  echo "</select>
</form></td>
  </tr>";
 }
echo "</table>";
include("footer.php");
?>