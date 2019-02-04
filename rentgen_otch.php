<?php
$ThisVU="all";
$ModName="Рентгенология";
include("header.php");
//switch ($_GET['action'])
//{
//	case "setAssist":
//		$query = "INSERT INTO `xray_uch` (`id`, `sotr`, `manip_pr`)
//VALUES (NULL, '".$_GET['asstID']."', '".$_GET['ManipPr']."')" ;
//		//////echo $query."<br>";
//		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//		ret("rentgen.php?type=".$_GET['type']);
//		include("footer.php");
//		exit;
//	break;
//	case "chAssist":
//		$query = "UPDATE xray_uch
//				  SET sotr='".$_GET['asstID']."' 
//				  WHERE id='".$_GET['XrayID']."'" ;
//		//////echo $query."<br>";
//		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//		ret("rentgen.php?type=".$_GET['type']);
//		include("footer.php");
//		exit;
//	break;
//}
echo "<div class=\"head1\">Отчёт по снимкам</div>";
$query = "SELECT `id`, `surname`, `name`, `otch` FROM `sotr` WHERE `dolzh`=5 ORDER BY surname" ;
//////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$asstCount=$count;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if( (!(isset($_GET['sotr']))) AND ($i==0)) $sotr=$row[0];
	if (isset($_GET['sotr'])) $sotr=$_GET['sotr'];
	$asst['$i][name']=$row[1]." ".$row[2]." ".$row[3];
	$asst['$i][id']=$row[0];
}
echo "<div class=\"head3\"> <script type=\"text/JavaScript\">

function MM_jumpMenu(targ,selObj,restore){ 
  eval(targ+\".location='\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}

</script>
<form name=\"form1\" id=\"form1\">
  Ассистент:<select name=\"menu1\" onchange=\"MM_jumpMenu('parent',this,0)\">";
  
   for ($j=0;$j<$asstCount;$j++)
   {
		if ($asst['$j][id']==$sotr)  echo " <option value='rentgen_otch.php?sotr=".$asst['$j][id']."&type=".$_GET['type']."' selected='selected'>".$asst['$j][name']."</option>";
		 else echo " <option value='rentgen_otch.php?sotr=".$asst['$j][id']."&type=".$_GET['type']."' >".$asst['$j][name']."</option>";
   }
  echo "</select>
</form>
</div>";
//$query = "SELECT `id`,`manip_pr`FROM `xray_uch` WHERE `sotr`='".$sotr;
////////echo $query."<br>";
//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//if ($count>0) 
//{
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysqli_fetch_array($result);
//	$xRayUcht['$row['manip_pr]'][id']=$row['id'];
//	$xRayUcht['$row['manip_pr]'][sotr']=$row['sotr'];
//}
//}

		  $query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN=$row['nach'];
$dtO=$row['okonch'];
		  echo "<center><a href=\"rentgen_otch.php?type=per\" class=menu2>".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</a> | <a href=\"rentgen_otch.php?type=today\" class=menu2>".date('d.m.Y')."	</a></center>";	
switch ($_GET['type'])
{
	case "today":
		//$query="SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `manip_pr`.`kolvo`, `manip`.`price`,`manip_pr`.`id`
//FROM klinikpat, manip_pr, manip, dnev, xray_uch
//WHERE ((`klinikpat`.`id` =`dnev`.`pat`) AND (`dnev`.`date` ='".date('Y-m-d')."') AND (`manip_pr`.`dnev` =`dnev`.`id`) AND (`manip`.`id` IN (26,27)) AND (`manip_pr`.`manip` =`manip`.`id`) AND (`xray_uch`.`sotr`='".$sotr."') AND (
//`xray_uch`.`manip_pr` = `manip_pr`.`id` 
//)
//)
//";
	
	$type="&type=today";
	break;
	case "per":
	$query = "SELECT `nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN=$row['nach'];
$dtO=$row['okonch'];
echo "<div class=\"head3\">Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</div>";
//	$query="SELECT `klinikpat`.`surname`, 
//	`klinikpat`.`name`, 
//	`klinikpat`.`otch`, 
//	`manip_pr`.`kolvo`, 
//	`manip`.`price`, 
//	`manip_pr`.`id`
//FROM klinikpat, manip_pr, manip, dnev, xray_uch
//WHERE ((`klinikpat`.`id` =`dnev`.`pat`) AND (`dnev`.`date` >='".$dtN."') AND (`dnev`.`date` <'".$dtO."') AND  (`manip_pr`.`dnev` =`dnev`.`id`) AND (`manip`.`id` IN (26,27)) AND (`manip_pr`.`manip` =`manip`.`id`)
//AND (`xray_uch`.`sotr`='".$sotr."') AND (
//`xray_uch`.`manip_pr` = `manip_pr`.`id` 
//))
//ORDER BY `dnev`.`date`";
$type="&type=per";
	break;
	
}
//////echo $query."<br>";
$tables[0]=array ("dnev","`manip_pr`","`manip_pr`.`dnev`");
$tables[1]=array ("zaknar","`manip_zn`","`manip_zn`.`ZN`");
$tables[2]=array ("schet_orto","`manip_sh_orto`","`manip_sh_orto`.`SO`");
$c=0;
$summ=0;
$cs=0;
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
	FROM klinikpat, ".$tables['$j][1'].", manip, ".$tables['$j][0'].", sotr,xray_uch
	WHERE (
	(`klinikpat`.`id` =`".$tables['$j][0']."`.`pat`) AND 
	".$inc."AND 
	(".$tables['$j][2']." =`".$tables['$j][0']."`.`id`) AND 
	(`manip`.`id` IN (26,27,254,255)) AND 
	(".$tables['$j][1'].".`manip` =`manip`.`id`) AND
	(`sotr`.`id`=`".$tables['$j][0']."`.`vrach`)	AND
	(`xray_uch`.`type`=".$j.") AND
	(`xray_uch`.`sotr`='".$sotr."' ) AND
	(".$tables['$j][1'].".`id`=`xray_uch`.`manip_pr`)
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
		$manip['$c][PatName']=$row[0]." ".$row[1]." ".$row[2];
		$manip['$c][KolVo']=$row[3]." (".($row[3]*$row[4])."р.)";
		$manip['$c][sotr']=$xRayUcht['$j']['$row['5]'][sotr'];
		$manip['$c][vrach']="<div class='bottom'>(".$row[6]." ".$row[7]." ".$row[8].")</div>";
		$summ+=$row[3]*$row[4];
		$cs+=$row[3];
	}
}
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($c==0)
{
	echo "<div class=\"head1\">Снимков нет</div>";
	include("footer.php");
	exit;
}
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysqli_fetch_array($result);
//		$manip['$i][PatName']=$row[0]." ".$row[1]." ".$row[2];
//		$manip['$i][KolVo']=$row[3]." (".($row[3]*$row[4])."р.)";
//		$KolVo+=$row[3];
//		$summ+=($row[3]*$row[4]);
//}
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000'>
  <tr>
    <td><div align='center'>Пациент</div></td>
	 <td><div align='center'>Дата</div></td>
    <td><div align='center'>К-во(сумма)</div></td>
  </tr>";
for ($i=1;$i<=$c;$i++)
{
	
     echo " <tr>
    <td>".$manip['$i][PatName']."<br />".$manip['$i][vrach']."</td>
	<td><div align='center'>".$manip['$i][date']."</div></td>
    <td align='center'>".$manip['$i][KolVo']."</td>
  	
  </tr>";
 }
echo "</table>";
echo "<div class='menutext2'>Всего снимков:".$cs."<br />
Сумма:".$summ."</div>";
include("footer.php");
?>