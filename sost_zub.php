<?php
$ThisVU="all";
$ModName="Состояние зуба";
$js="insert";
include("header2.php");
if (!(isset($_GET['kol_kan'])))
{
	$_GET['kol_kan']=1;	
}
switch ($_GET['action'])
{
 case "open_last":
	$query = "SELECT `id`, `pat`, `date`, `nzub`, `sost`, `ds`, `kol_kan`, `ging`, `furk`, `concr`, `eod`, `prim`, `zh`, `an`, `obk` , DATE_FORMAT(`date`,'%d.%m.%Y') as print_date FROM `sost_zub` WHERE 
	((`pat`=".$_GET['pat'].") AND (`nzub`=".$_GET['nzub']."))
	ORDER BY date desc
	LIMIT 0,1";
	echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$count_ex=$count;
	if ($count>0) 
	{	
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			if ($i==0) $SESSION['sost_zub']=$row;
			$doe['$i][id']=$row['id'];
			$doe['$i][pr']=$row['print_date'];
		}

	}
	else
	{
		$act_new=true;
	}
 break;
 case "open_date":
 break;
}
switch ($_POST['action'])
{
	case "new_save":
  	 	msg('new_save');
   	exit;
 		$query = "INSERT INTO `sost_pov`
 		(`id`, `total`, `vest`, `oral`, `med`, `dist`) 
		VALUES
		(NULL, `".$_POST['total']."`, `".$_POST['vest']."`, `".$_POST['oral']."`, `".$_POST['med']."`, `".$_POST['dist']."`)";
		echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "SELECT LAST_INSERT_ID()";
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$sost_id=$row[0];
		$query = "INSERT INTO `sost_zub` WHERE
		( `id`,`".$_SESSION['pat][id']."`, `".date('Y-m-d')."`, `".$_SESSION['nzub][id']."`, `".$sost_id."`, `".$_POST['ds']."`, `kol_kan`, `ging`, `furk`, `concr`, `eod`, `prim`, `zh`, `an`, `obk` )
		VALUES 
		(NULL, `pat`, `date`, `nzub`, `sost`, `ds`, `kol_kan`, `ging`, `furk`, `concr`, `eod`, `prim`, `zh`, `an`, `obk`)";
		echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
 break;
 case "change_save":
 break;
}
if (!(isset($_SESSION['pat][name'])))
{
	$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_GET['pat'];
		echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$_SESSION['pat][name']=$row['surname']." ".$row['name']." ".$row['otch'];
		$_SESSION['pat][id']=$_GET['pat'];
}
if (!(isset($_SESSION['nzub][id'])))
{
$query = "SELECT `NZuba` FROM `nzuba` WHERE `id`=".$_GET['nzub'];
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$_SESSION['nzub][id']=$_GET['nzub'];
$_SESSION['nzub][pr']=$row['NZuba'];
}
echo "<form action=\"sost_zub.php\" method=\"post\" name='sostzub' id='sostzub'>";
if ($act_new) echo "<input type=\"hidden\" value=\"new_save\" name='action'>";
else echo "<input type=\"hidden\" value=\"change_save\" name='action'>";
echo "
<div class='head1'>Пациент: ".$_SESSION['pat][name']." (Карта №".$_SESSION['pat][id'].")</div>
<div class='head2'>Зуб №".$_SESSION['nzub][pr']."  Дата осмотра
<script type=\"text/JavaScript\">
<!--
function jumpMenu2(targ,selObj,restore){
  eval(targ+\".location='sost_zub.php?\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>";
echo " <select name=\"date_ex\" onchange=\"jumpMenu2('parent',this,0)\">";
		for ($i=0;$i<$count_ex;$i++)
		{
			echo "<option value='action=open_date&sost_zub_id=".$doe['$i][id']."'";
			if ($doe['$i][id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$i."</option>"; 
		}
echo "</select> </div>
 <div align=\"center\"><a href='sost_zub.php?pat=".$_SESSION['pat][id']."&action=hist&kol_kan=".$_GET['kol_kan']."' class='mmenu'>История зуба</a>|
 <a href='sost_zub.php?pat=".$_SESSION['pat][id']."&nzub=".$_SESSION['nzub']."&action=new&kol_kan=".$_GET['kol_kan']."' class='mmenu'> Новый осмотр</a>
 |<a href='#' class='mmenu'  onClick=\"javascript:document.sostzub.submit()\">Сохранить изменения</a>
</div></br>

<div class='alltext'>Диагноз:
<input type=\"hidden\" name=\"ds\" id=\"ds\">
<input type=\"text\" name=\"dsPr\" size=\"84\" id=\"dsPr\">
<a 'href=\"#\"' class='small2' onClick=\"javascript:chDs('dsPr','ds','./choise_ds.php','')\"'>вставить</a></div> 
</br>
<table width='100%' border=0 class='alltext'>
<tr>
<td>Коронка:<select name=\"total\">";
$query = "SELECT `id`, `nazv` FROM `spr_sost_total` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}

echo "</select></br>
Вестибулярная:<select name=\"vest\">";
$query = "SELECT `id`, `nazv` FROM `spr_sost_pov` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></br>
Оральная:<select name=\"oral\">";
$query = "SELECT `id`, `nazv` FROM `spr_sost_pov` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></br>
Медиальная:<select name=\"dist\">";
$query = "SELECT `id`, `nazv` FROM `spr_sost_pov` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></br>
Дистальная:<select name=\"med\">";
$query = "SELECT `id`, `nazv` FROM `spr_sost_pov` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select>
</td>
<td>Пародонт:<select name=\"ging\">";
$query = "SELECT `id`, `nazv` FROM `spr_sost_ging` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></br>
Фуркация:<select name=\"furk\">";
$query = "SELECT `id`, `nazv` FROM `spr_furk` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></br>
Зубные отложения:<select name=\"concr\">";
$query = "SELECT `id`, `nazv` FROM `spr_concr` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></br>
ЭОД<input type=\"eod\" name=\"eod\"></td>
</tr>
</table>

<table width='100%' border=0 class='alltext'>
<tr>
<td>Жалобы <a href='#' class='small2' onClick=\"javascript:chDs('zh','0','./zh_an_obk.php','&table=zh')\">вставить</a></br>
<textarea name=\"zh\" id=\"zh\" rows=\"3\" cols=\"20\"></textarea>
</td>
<td>Анамнез <a href='#' class='small2' onClick=\"javascript:chDs('an','0','./zh_an_obk.php','&table=an')\" >вставить</a></br>
<textarea name=\"an\" id=\"an\" rows=\"3\" cols=\"20\"></textarea>
</td>
<td>Симптомы <a href='#' class='small2' onClick=\"javascript:chDs('ob','0','./zh_an_obk.php','&table=ob')\">вставить</a></br>
<textarea name=\"ob\" id=\"ob\" rows=\"3\" cols=\"20\"></textarea>
</td>
</tr>
</table>
<script type=\"text/JavaScript\">
<!--
function jumpMenu1(targ,selObj,restore){
  eval(targ+\".location='sost_zub.php?kol_kan=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
";
if (!(isset($_GET['kol_kan'])))
{
	$_GET['kol_kan']=1;	
}
$size=round((100/$_GET['kol_kan']),0)."%";
echo "
<div class='feature3'>Корневые каналы (Количество <select name=\"kol_kan\" onchange=\"jumpMenu1('parent',this,0)\">
";
for ($i=1;$i<=5;$i++)
{
	echo "<option value='".$i."'";
	if ($i==$_GET['kol_kan']) echo " selected='selected' "; 
	echo ">".$i."</option>"; 
}
echo "</select>) </div>";
echo "<table width='100%' border='1' class='alltext'>
<tr>
<td>&nbsp</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{
		echo "<td width='".$size."'>	
		<select name=\"nazv[".$j."]\">";
		$query = "SELECT `id`, `nazv` FROM `spr_nazv_kk` ORDER BY `id`";
		echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
		echo "</select></td>";
	}
echo "</tr>
<tr>
<td >Содержимое</td>
";

for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{
		echo "
		<td><select name=\"soderzh[".$j."]\">";
$query = "SELECT `id`, `nazv` FROM `spr_soderzh_kk` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></td>";
	}
echo "
</tr>
<tr>";
echo "<td>Уровень обтурации по R</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{
		echo "<td><select name=\"dl_obtur[".$j."]\">";
$query = "SELECT `id`, `nazv` FROM `spr_gl_obtur` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></td>";
	}
		echo "

</tr>
<tr>
<td>Состояние периапикальных тканей по R</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{		echo "
<td><select name=\"xray[".$j."]\">";
$query = "SELECT `id`, `nazv` FROM `spr_xray_kk` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></td>";
	}

echo "
</tr>
<tr>
<td>Размеры деструкции</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{echo "
<td><input type=\"text\" name=\"size_destr1[".$j."]\" size=\"3\" maxlength=\"3\">x<input type=\"text\" name=\"size_destr2[".$i."]\" size=\"3\" maxlength=\"3\"></td>
";
	}
		echo "</tr>
<tr>
<td>Штифт в к/к</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{
		echo "
		<td><select name=\"shtift[".$j."]\">";
			echo "<option value='0'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">Нет</option>"; 
			echo "<option value='1'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">Да</option>"; 
echo "</select></td>";
	}
echo "
</tr>
<tr>
<td>Интсрумент в к/к</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{
	echo "
<td><select name=\"instrum[".$j."]\">";
			echo "<option value='0'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">Нет</option>"; 
			echo "<option value='1'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">Да</option>"; 
echo "</select></td>";
	}
echo "
</tr>
<tr>
<td>Перфорация</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{echo "
<td><select name=\"perfo[".$j."]\">";
			echo "<option value='0'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">Нет</option>"; 
			echo "<option value='1'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">Да</option>"; 
echo "</select></td>";
	}
		echo "
</tr>
<tr>
<td>Длинна к/к</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{
	echo "
<td><input type=\"text\" name=\"long[".$j."]\" size=\"5\" maxlength=\"5\"></td>";
	}
		
echo "
</tr>
<tr>
<td>Техника обработки</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{echo "
<td><select name=\"obr[".$j."]\">";
$query = "SELECT `id`, `nazv` FROM `spr_obr` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></td>";
	}
		
echo "
</tr>
<tr>
<td>Мастер файл</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{echo "
<td><select name=\"m_file[".$j."]\">";
$query = "SELECT `id`, `nazv` FROM `spr_m_file` ORDER BY `id`";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'";
			//if ($row['id']==$_SESSION['sost_zub][id']) echo " selected='selected' "; 
			echo ">".$row['nazv']."</option>"; 
		}
echo "</select></td>";
	}
		echo "
</tr>

<tr>
<td>Прим</td>
";
for ($j=1;$j<=$_GET['kol_kan'];$j++)
	{echo "
<td><textarea name=\"prim_kk[".$j."]\" rows=\"3\" cols=\"15\"></textarea></td>";
	}
		
echo "
</tr>
</table>
</br>
<div class='alltext'>Примечание:</br><textarea name=\"prim\" rows=\"5\" cols=\"25\"></textarea></br>
<a href='sost_zub.php?pat=".$_GET['pat']."&action=ch&kol_kan=".$_GET['kol_kan']."' class='mmenu'>Сохранить изменения</a>
 </div></form>
";

include("footer2.php");
?>