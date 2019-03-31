<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title=""; 
//include("header2.php");
switch ($_GET['podr'])
	{
	 case "1":
	 	$podr="<div class=\"smalltextR\"><em>ООО \"ОРТО-ПРЕМЬЕР\"<br />
654005, г. Новокузнецк, пр-т Кузнецкстроевский д.30<br />
ИНН 4217068361<br />
тел. 45-46-33</em><br /></div>";
	 break;
	 case "2":
	 	$podr="<div class=\"smalltextR\"><em>ПБОЮЛ Черненко С.В.<br />
654005, г. Новокузнецк, пр-т Кузнецкстроевский д.30<br />
ИНН 421702155709<br />
тел. 45-46-33</em><br /></div>";
	 break;
	}
switch ($_GET['type'])
{

	case "pat":
		$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `dnev`.`date`, `dnev`.`zh`, `dnev`.`an`, `dnev`.`obk`, `dnev`.`ds`, `dnev`.`lech`
FROM dnev, klinikpat
WHERE ((`dnev`.`id` ='".$_GET['card']."') AND (`klinikpat`.`id` =`dnev`.`pat`))";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dt=explode('-',$row['date']);
		echo "<div class='smalltext'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td align='left'><em><strong>Дата: ".$dt[2].".".$dt[1].".".$dt[0]."</strong></em></td>
					<td align='center'><em><strong>Пациент: ".$row['surname']." ".$row['name']." ".$row['otch']."</strong></em></td>
				  </tr>
				</table>
						<strong>Жалобы:</strong> ".$row['zh']."
						<strong>Анамнез:</strong>  ".$row['an']."
						<strong>Объективно:</strong>  ".$row['obk']."
						<strong>Диагноз:</strong>  ".$row['ds']."
						<strong>Лечение:</strong>  ".$row['lech']."<hr width='100%' noshade='noshade' size='1'/></div>
					
					<div align='right' class='smalltext'>Подпись врача________________ <br />
				  Подпись пациента______________ </div>";

				 
				  //include("footer2.php");
				  exit;
				  
	break;
	case "chek":
	switch ($_GET['table'])
	{
	case "dnev":
		$query = "SELECT `klinikpat`.`surname`, 
						 `klinikpat`.`name`, 
						 `klinikpat`.`otch`, 
						 `dnev`.`date`, 
						 `sotr`.`surname`, 
						 `sotr`.`name`, 
						 `sotr`.`otch`, 
						 `dnev`.`skidka`, 
						 `oplata`.`VidOpl`, 
						 `opl_vid`.`vid`,
						 `dnev`.`summ_k_opl`, 
						 `dnev`.`summ_vnes`, 
						 `dnev`.`summ`,
						 (`dnev`.`summ_k_opl`-`dnev`.`summ_vnes`) AS dolg,
						 `dnev`.`summ`
				FROM klinikpat, dnev, sotr, oplata, opl_vid
				WHERE ((`klinikpat`.`id` =`dnev`.`pat`) AND 
				(`sotr`.`id` =`dnev`.`vrach`) AND 
				(`oplata`.`dnev` =`dnev`.`id`) AND 
				(`dnev`.`id` ='".$_GET['dnev']."') AND 
				(`opl_vid`.`id` =`oplata`.`VidOpl`) )";
//$query = "SELECT 
//`klinikpat`.`surname`, 
//`klinikpat`.`name`, 
//`klinikpat`.`otch`, 
//`dnev`.`date`, 
//`sotr`.`surname`, 
//`sotr`.`name`, 
//`sotr`.`otch`, 
//`dnev`.`summ_k_opl`, 
//`dnev`.`summ_vnes`, 
//`dnev`.`summ` 
//FROM klinikpat, dnev, sotr, oplata
//WHERE (
//(`klinikpat`.`id` =`dnev`.`pat`) AND 
//(`sotr`.`id` =`dnev`.`vrach`) AND 
//(`oplata`.`dnev` =`dnev`.`id`) AND 
//(`dnev`.`id` ='".$_GET['dnev']."'))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$countA=$count;
		$resultA=$result;
		$rowA= mysqli_fetch_array($resultA);
		$tmN=explode(":",$rowA['NachPr']);
		$tmO=explode(":",$rowA['OkonchPr']);
		$ProdPr=mktime($tmO[0],$tmO[1],0,date('m'),date('d'),date('Y'))-mktime($tmN[0],$tmN[1],0,date('m'),date('d'),date('Y'));
		$ProdPr=$ProdPr/60;
		$dt=explode("-",$rowA['date']);
		echo "<br />
<strong><center>Копия чека № 1-".$_GET['dnev']."</center></strong>
<table width=\"100%\" border=\"0\">
  <tr>
    <td><div class=\"smalltext\"><em>Дата приёма: ".$dt[2].".".$dt[1].".".$dt[0]."</em><br />
					<em>Пациент: ".$rowA[0]." ".$rowA[1]." ".$rowA[2]." </em><br />
					<em>Врач: ".$rowA[4]." ".$rowA[5]." ".$rowA[6]."</em><br />
					<em>Вид оплаты: ".$rowA['vid']."</em><br />
					</div></td>
    <td>".$podr."</td>
  </tr>
</table>

					
					<center>Список оказанных услуг</center>
					<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
	$query = "SELECT `manip`.`manip`, `manip_pr`.`kolvo`, `manip`.`price`, (`manip_pr`.`kolvo` *`manip`.`price`) AS STOIM
		FROM manip, manip_pr
		WHERE ((`manip_pr`.`dnev` ='".$_GET['dnev']."') AND
		(`manip`.`id`=`manip_pr`.`manip`))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
				$row = mysqli_fetch_array($result);
			  echo "<tr class='smalltext'>
				<td align='center'>".($i+1).".</td>
				<td align='left'>".$row['manip']."</td>
				<td align='center'>".$row['kolvo']."</td>
				<td align='center'>".$row['price']." руб</td>
				<td align='center'>".$row['STOIM']." руб</td>
			  </tr>";
		}
			echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$rowA['summ']." руб.<br />";

			if ($rowA['skidka']>0)
			{
			echo "Скидка: ".$rowA['skidka']."%<br />
			Итого со скидкой: ".$rowA['summ_k_opl']." руб.</td>";
			}
			  echo "</tr>
			</table>";
			echo "<div class=\"smalltext\">Кассир (".$_SESSION['UserName'].")_________________<br /><br />

			Пациент (".$rowA[0]." ".$rowA[1]." ".$rowA[2].")_________________</div> <br/>";
			
			if ($ProdPr>0) echo "Продолжителность приёма ".$ProdPr." мин";
			
			break;
			case "zaknar":
		$query = "SELECT `klinikpat`.`surname`, 
						 `klinikpat`.`name`, 
						 `klinikpat`.`otch`, 
						 `zaknar`.`date`, 
						 `sotr`.`surname`, 
						 `sotr`.`name`, 
						 `sotr`.`otch`, 
						 `zaknar`.`skidka`, 
						 `zaknar`.`summ_k_opl`,  
						 `zaknar`.`summ`
				FROM klinikpat, zaknar, sotr
				WHERE ((`klinikpat`.`id` =`zaknar`.`pat`) AND 
				(`sotr`.`id` =`zaknar`.`vrach`) AND 
				(`zaknar`.`id` ='".$_GET['dnev']."'))";
//$query = "SELECT 
//`klinikpat`.`surname`, 
//`klinikpat`.`name`, 
//`klinikpat`.`otch`, 
//`dnev`.`date`, 
//`sotr`.`surname`, 
//`sotr`.`name`, 
//`sotr`.`otch`, 
//`dnev`.`summ_k_opl`, 
//`dnev`.`summ_vnes`, 
//`dnev`.`summ` 
//FROM klinikpat, dnev, sotr, oplata
//WHERE (
//(`klinikpat`.`id` =`dnev`.`pat`) AND 
//(`sotr`.`id` =`dnev`.`vrach`) AND 
//(`oplata`.`dnev` =`dnev`.`id`) AND 
//(`dnev`.`id` ='".$_GET['dnev']."'))";
//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$countA=$count;
		$resultA=$result;
		$rowA= mysqli_fetch_array($resultA);
		$dt=explode("-",$rowA['date']);
		echo "<br />
<strong><center>Копия чека № 2-".$_GET['dnev']."</center></strong>
<table width=\"100%\" border=\"0\">
  <tr>
    <td><div class=\"smalltext\"><em>Дата приёма: ".$dt[2].".".$dt[1].".".$dt[0]."</em><br />
					<em>Пациент: ".$rowA[0]." ".$rowA[1]." ".$rowA[2]." </em><br />
					<em>Врач: ".$rowA[4]." ".$rowA[5]." ".$rowA[6]."</em><br />
					</div></td>
    <td>".$podr."</td>
  </tr>
</table>

					
					<center>Список оказанных услуг</center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
	$query = "SELECT `manip`.`manip`, `manip_zn`.`kolvo`, `manip`.`price`, (`manip_zn`.`kolvo` *`manip`.`price`) AS STOIM
		FROM manip, manip_zn
		WHERE ((`manip_zn`.`ZN` ='".$_GET['dnev']."') AND
		(`manip`.`id`=`manip_zn`.`manip`))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
				$row = mysqli_fetch_array($result);
			  echo "<tr class='smalltext'>
				<td align='center'>".($i+1).".</td>
				<td align='left'>".$row['manip']."</td>
				<td align='center'>".$row['kolvo']."</td>
				<td align='center'>".$row['price']." руб</td>
				<td align='center'>".$row['STOIM']." руб</td>
			  </tr>";
		}
			echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$rowA['summ']." руб.<br />";

			if ($rowA['skidka']>0)
			{
			echo "Скидка: ".$rowA['skidka']."%<br />
			Итого со скидкой: ".$rowA['summ_k_opl']." руб.</td>";
			}
			  echo "</tr>
			</table>";
			echo "<div class=\"smalltext\">Кассир (".$_SESSION['UserName'].")_________________<br /><br />

			Пациент (".$rowA[0]." ".$rowA[1]." ".$rowA[2].")_________________</div> ";
			break;
			case "schet_orto":
		$query = "SELECT `klinikpat`.`surname`, 
						 `klinikpat`.`name`, 
						 `klinikpat`.`otch`, 
						 `schet_orto`.`date`, 
						 `sotr`.`surname`, 
						 `sotr`.`name`, 
						 `sotr`.`otch`, 
						 `schet_orto`.`skidka`,
						 `schet_orto`.`summ_k_opl`,  
						 `schet_orto`.`summ`,
						 `schet_orto`.`sh_id`
				FROM klinikpat, schet_orto, sotr
				WHERE ((`klinikpat`.`id` =`schet_orto`.`pat`) AND 
				(`sotr`.`id` =`schet_orto`.`vrach`) AND 
				(`schet_orto`.`id` ='".$_GET['dnev']."'))";
//$query = "SELECT 
//`klinikpat`.`surname`, 
//`klinikpat`.`name`, 
//`klinikpat`.`otch`, 
//`dnev`.`date`, 
//`sotr`.`surname`, 
//`sotr`.`name`, 
//`sotr`.`otch`, 
//`dnev`.`summ_k_opl`, 
//`dnev`.`summ_vnes`, 
//`dnev`.`summ` 
//FROM klinikpat, dnev, sotr, oplata
//WHERE (
//(`klinikpat`.`id` =`dnev`.`pat`) AND 
//(`sotr`.`id` =`dnev`.`vrach`) AND 
//(`oplata`.`dnev` =`dnev`.`id`) AND 
//(`dnev`.`id` ='".$_GET['dnev']."'))";
//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$countA=$count;
		$resultA=$result;
		$rowA= mysqli_fetch_array($resultA);
		$dt=explode("-",$rowA['date']);
		echo "<br />
<strong><center>Копия чека № 3-".$_GET['dnev']."</center></strong>
<table width=\"100%\" border=\"0\">
  <tr>
    <td><div class=\"smalltext\"><em>Дата приёма: ".$dt[2].".".$dt[1].".".$dt[0]."</em><br />
					<em>Пациент: ".$rowA[0]." ".$rowA[1]." ".$rowA[2]." </em><br />
					<em>Врач: ".$rowA[4]." ".$rowA[5]." ".$rowA[6]."</em><br />
					</div></td>
    <td>".$podr."</td>
  </tr>
</table>

					
					<center>Список оказанных услуг</center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
	if ($rowA['sh_id']==0)
	{	  
	$query = "SELECT `manip`.`manip`, `manip_sh_orto`.`kolvo`, `manip`.`price`, (`manip_sh_orto`.`kolvo` *`manip`.`price`) AS STOIM
		FROM manip, manip_sh_orto
		WHERE ((`manip_sh_orto`.`SO` ='".$_GET['dnev']."') AND
		(`manip`.`id`=`manip_sh_orto`.`manip`))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
				$row = mysqli_fetch_array($result);
			  echo "<tr class='smalltext'>
				<td align='center'>".($i+1).".</td>
				<td align='left'>".$row['manip']."</td>
				<td align='center'>".$row['kolvo']."</td>
				<td align='center'>".$row['price']." руб</td>
				<td align='center'>".$row['STOIM']." руб</td>
			  </tr>";
		}echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$rowA['summ']." руб.<br />";
		if ($rowA['proc']>0)
			{
			echo "Скидка: ".$rowA['proc']."%<br />
			Итого со скидкой: ".$rowA['summ_k_opl']." руб.</td>";
			}
			  echo "</tr>
			</table>";
		}
		else
		{
			echo "<tr class='smalltext'>
				<td align='center'>1.</td>
				<td align='left'>Оплата за ортодонтическое лечение</td>
				<td align='center'>1</td>
				<td align='center'>".$rowA['summ']." руб</td>
				<td align='center'>".$rowA['summ']." руб</td>
			  </tr>";
			  echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$rowA['summ']." руб.<br />";
		//if ($rowA['proc']>0)
//			{
//			echo "Скидка: ".$rowA['proc']."%<br />
//			Итого со скидкой: ".$rowA['summ_k_opl']." руб.</td>";
//			}
			  echo "</tr>
			</table>";
		}
			

			
			echo "<div class=\"smalltext\">Кассир (".$_SESSION['UserName'].")_________________<br /><br />

			Пациент (".$rowA[0]." ".$rowA[1]." ".$rowA[2].")_________________</div> ";
			break;
		case "schet_hyg":
//		$query = "SELECT  `schet_hyg`.`id`
//				FROM schet_hyg
//				WHERE  `schet_hyg`.`id` =".$_GET['dnev'];
//$query = "SELECT 
//`klinikpat`.`surname`, 
//`klinikpat`.`name`, 
//`klinikpat`.`otch`, 
//`dnev`.`date`, 
//`sotr`.`surname`, 
//`sotr`.`name`, 
//`sotr`.`otch`, 
//`dnev`.`summ_k_opl`, 
//`dnev`.`summ_vnes`, 
//`dnev`.`summ` 
//FROM klinikpat, dnev, sotr, oplata
//WHERE (
//(`klinikpat`.`id` =`dnev`.`pat`) AND 
//(`sotr`.`id` =`dnev`.`vrach`) AND 
//(`oplata`.`dnev` =`dnev`.`id`) AND 
//(`dnev`.`id` ='".$_GET['dnev']."'))";
//echo $query."<br />";
//		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//		$countA=$count;
//		$resultA=$result;
//		$rowA= mysqli_fetch_array($resultA);
		echo "<strong><center>Копия чека № 5-".$_GET['dnev']."</center></strong>
<table width=\"100%\" border=\"0\">
  <tr>
    <td><div class=\"smalltext\"><em>Дата:".date('d.m.Y')."</em><br />
					</div></td>
    <td>".$podr."</td>
  </tr>
</table>
<center>Список оказанных услуг</center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
	$query = "SELECT `manip`.`manip`, `manip_hyg`.`kolvo`, `manip`.`price`, (`manip_hyg`.`kolvo` *`manip`.`price`) AS STOIM
		FROM manip, manip_hyg
		WHERE ((`manip_hyg`.`schet_hyg` ='".$_GET['dnev']."') AND
		(`manip`.`id`=`manip_hyg`.`manip`))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$s=0;
		for ($i=0;$i<$count;$i++)
		{
				$row = mysqli_fetch_array($result);
			  echo "<tr class='smalltext'>
				<td align='center'>".($i+1).".</td>
				<td align='left'>".$row['manip']."</td>
				<td align='center'>".$row['kolvo']."</td>
				<td align='center'>".$row['price']." руб</td>
				<td align='center'>".$row['STOIM']." руб</td>
			  </tr>";
			  $s+=$row['STOIM'];
		}
			echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$s." руб.<br />";
			  echo "</tr>
			</table>";
			echo "<div class=\"smalltext\">Кассир (".$_SESSION['UserName'].")_________________<br /><br />";
			break;
	}	
	break;
	case "orto_sch":
		$query = "SELECT `klinikpat`.`surname`, 
						 `klinikpat`.`name`, 
						 `klinikpat`.`otch`, 
						 `orto_sh`.`date`, 
						 `sotr`.`surname`, 
						 `sotr`.`name`, 
						 `sotr`.`otch`,  
						 `orto_sh`.`vnes`,  
						 `orto_sh`.`summ`,
						 (`orto_sh`.`last_pay_month`-1) AS month
				FROM klinikpat, orto_sh, sotr
				WHERE ((`klinikpat`.`id` =`orto_sh`.`pat`) AND 
				(`sotr`.`id` =`orto_sh`.`sotr`) AND 
				(`orto_sh`.`id` ='".$_GET['id_shema']."'))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$countA=$count;
		$resultA=$result;
		$rowA= mysqli_fetch_array($resultA);
		echo "<br />
<strong><center>Копия чека № 4-".$_GET['id_shema'].$rowA['month']."</center></strong>
<table width=\"100%\" border=\"0\">
  <tr>
    <td><div class=\"smalltext\"><em>Дата: ".date('d.m.Y')."</em><br />
					<em>Пациент: ".$rowA[0]." ".$rowA[1]." ".$rowA[2]." </em><br />
					<em>Врач: ".$rowA[4]." ".$rowA[5]." ".$rowA[6]."</em><br />
					</div></td>
    <td>".$podr."</td>
  </tr>
</table>

					<center>Список оказанных услуг</center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			   echo "<tr class='smalltext'>
				<td align='center'>1.</td>
				<td align='left'>Оплата за ортодонтическое лечение</td>
				<td align='center'>1</td>
				<td align='center'>".$_GET['summ']." руб</td>
				<td align='center'>".$_GET['summ']." руб</td>
			  </tr>";
			  echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$_GET['summ']." руб.<br />";

			  echo "</tr>
			</table>";
			echo "<div class=\"smalltext\">Кассир (".$_SESSION['UserName'].")_________________<br /><br />

			Пациент (".$rowA[0]." ".$rowA[1]." ".$rowA[2].")_________________</div> ";
	break;
	case "orto_sch":
		$query = "SELECT `klinikpat`.`surname`, 
						 `klinikpat`.`name`, 
						 `klinikpat`.`otch`, 
						 `orto_sh`.`date`, 
						 `sotr`.`surname`, 
						 `sotr`.`name`, 
						 `sotr`.`otch`,  
						 `orto_sh`.`vnes`,  
						 `orto_sh`.`summ`,
						 (`orto_sh`.`last_pay_month`-1) AS month
				FROM klinikpat, orto_sh, sotr
				WHERE ((`klinikpat`.`id` =`orto_sh`.`pat`) AND 
				(`sotr`.`id` =`orto_sh`.`sotr`) AND 
				(`orto_sh`.`id` ='".$_GET['id_shema']."'))";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$countA=$count;
		$resultA=$result;
		$rowA= mysqli_fetch_array($resultA);
		echo "<br />
<strong><center>Копия чека № 4-".$_GET['id_shema'].$rowA['month']."</center></strong>
<table width=\"100%\" border=\"0\">
  <tr>
    <td><div class=\"smalltext\"><em>Дата: ".date('d.m.Y')."</em><br />
					<em>Пациент: ".$rowA[0]." ".$rowA[1]." ".$rowA[2]." </em><br />
					<em>Врач: ".$rowA[4]." ".$rowA[5]." ".$rowA[6]."</em><br />
					</div></td>
    <td>".$podr."</td>
  </tr>
</table>

					<center>Список оказанных услуг</center><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена </div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			   echo "<tr class='smalltext'>
				<td align='center'>1.</td>
				<td align='left'>Оплата за ортодонтическое лечение</td>
				<td align='center'>1</td>
				<td align='center'>".$_GET['summ']." руб</td>
				<td align='center'>".$_GET['summ']." руб</td>
			  </tr>";
			  echo "</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$_GET['summ']." руб.<br />";

			  echo "</tr>
			</table>";
			echo "<div class=\"smalltext\">Кассир (".$_SESSION['UserName'].")_________________<br /><br />

			Пациент (".$rowA[0]." ".$rowA[1]." ".$rowA[2].")_________________</div> ";
	break;
	case "otch_d":
		$query = "SELECT `kassa`.`timeN`, `kassa`.`timeO`, `kassa`.`summ`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`kassa`.`id`
FROM kassa, sotr
WHERE ((`kassa`.`date` ='".date('Y-m-d')."') AND 
(`sotr`.`id` =`kassa`.`sotr` )) 
ORDER BY `kassa`.`timeN` DESC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row= mysqli_fetch_array($result);
$summ['kassa']=$row['summ'];
$sm_id=$row['id'];
if ($row['timeO']=="00:00:00")
{
	$zakr=0;
} 
else $zakr=1;

$query = "SELECT `kassa`.`timeN`, `kassa`.`timeO`, `kassa`.`summ`,`kassa`.`id`
FROM kassa
WHERE `kassa`.`id`=".($sm_id-1)." 
ORDER BY `kassa`.`timeN` DESC";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row= mysqli_fetch_array($result);
$summ['kassa2']=$row['summ'];
$summ['1][dog']=0;
$summ['1][av']=0;
$summ['2][dog']=0;
$summ['2][av']=0;
$summ['1][nal']=0;
$summ['2][nal']=0;
$query = "SELECT `id`, `nazv` FROM `podr` WHERE `id`=".$_GET['podr'] ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
for ($h=1;$h<=$countA;$h++)
{
$rowA= mysqli_fetch_array($resultA);
	////
	$opl[$h]['kol']=0;
	$opl[$h]['el']=1;
	$opl[$h]['nazv']=$rowA['nazv'];
	$opl[$h]['id']=$rowA['id'];
	echo "<form action='dir_den.php' method='get' >
		<br /><center><span class='feature3' >Финансовый отчёт ".$opl[$h]['nazv']." за  ".date('d.m.Y')."</span></center>
		<hr width='100%' noshade='noshade' size='1'/>";
	$tables=array ("dnev","zaknar","schet_orto");
	
	for ($j=0;$j<=2;$j++)
	{
		$query = "SELECT 
		`klinikpat`.`surname`,
		`klinikpat`.`name`,
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		`opl_vid`.`vid`,
		`oplata`.`podr`,
		`oplata`.`date`,
		`".$tables[$j]."`.`date`,
		(`".$tables[$j]."`.`summ_k_opl`-`".$tables[$j]."`.`summ_vnes`) as dolg,
		(`klinikpat`.`otch`) AS patID, 
		(`sotr`.`surname`) AS sotrID,
		`oplata`.`VidOpl`,
		`".$tables[$j]."`.`id`
		FROM klinikpat, sotr, oplata, ".$tables[$j].", opl_vid
		WHERE (
		(`oplata`.`date` ='".date('Y-m-d')."') AND 
		(`oplata`.`dnev` =`".$tables[$j]."`.`id`) AND 
		(`sotr`.`id` =`".$tables[$j]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j]."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
		(`oplata`.`podr`=".$opl[$h]['id'].")
		 AND
		(`oplata`.`type`=".($j+1).")
		)
		ORDER BY `".$tables[$j]."`.`vrach`";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>0)
		{
			  for ($i=0;$i<$count;$i++)
				{
					$opl[$h]['kol']++;
					$row = mysqli_fetch_array($result);
					if ($opl[$h]['kol']==1) 
					{
						$sotr[$h][$opl[$h]['el']]['id']=$row['sotrID'];
						$sotr[$h][$opl[$h]['el']]['sotrN']=$row[3]." ".$row[4]." ".$row[5];
					}
					else 
					{
						$fl=0;
						for ($t=1;$t<=$opl[$h]['el'];$t++)
						{
							if ($sotr[$h][$t]['id']==$row['sotrID']) $fl=1;
						}
						if ($fl==0) 
						{
							$opl[$h]['el']++;
							$sotr[$h][$opl[$h]['el']]['sotrN']=$row[3]." ".$row[4]." ".$row[5];
							$sotr[$h][$opl[$h]['el']]['id']=$row['sotrID'];
						}
					}
					$opl[$h][$opl[$h]['kol']]['patID']=$row['patID'];
					$opl[$h][$opl[$h]['kol']]['patN']=$row[0]." ".$row[1]." ".$row[2];
					$opl[$h][$opl[$h]['kol']]['sotrID']=$row['sotrID'];
					$opl[$h][$opl[$h]['kol']]['sotrN']=$row[3]." ".$row[4]." ".$row[5];
					$opl[$h][$opl[$h]['kol']]['summ']=$row[6];
					$opl[$h][$opl[$h]['kol']]['opl_vid']=$row[7];
					//$opl[$h][$opl[$h]['kol']]['patN']="<a class='mmenu' target='_blanc' href=\"print.php?type=chek&dnev=".$row['15']."&table=".$tables[$j]."&podr=".$opl[$h]['id']."\">".$opl[$h][$opl[$h]['kol']]['patN']."</a>";
					if ($row['10']!=$row[9]) $opl[$h][$opl[$h]['kol']]['dolg']=" (долг)";
					else $opl[$h][$opl[$h]['kol']]['dolg']="";
					if ($row['14']==1)
					{ 
						$summ[$h]['nal']+=$row[6];
						$summ['nal']+=$row[6];
					}
					if ($row['14']==2)
					{
						$summ[$h]['dog']+=$row[6];
					} 
					if ($row['14']==3)
					{
						$summ[$h]['av']+=$row[6];
					} 
					if ($row['14']==4)
					{
						$summ[$h]['proc']+=$row[6];
					} 
					if ($row['14']==5)
					{
						$summ[$h]['bank_card']+=$row[6];
					} 
					$summ[$h]['obsch']+=$row[6];
					$summ['obsch']+=$row[6];
				}
				
		}
	}
	//if ($opl[$h]['kol']>0)
//	{
//		$podr[$h]['kol_sotr']=1;
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][sotrID']=$opl[$h]['1][sotrID']=$row['sotrID'];
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][patN']=$opl[$h]['1][patN'];
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][patID']=$opl[$h]['1][patID'];
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][sotrN']=$opl[$h]['1][sotrN'];
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][summ']=$opl[$h]['1][summ'];
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][opl_vid']=$opl['1][opl_vid'];
//		$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][dolg']=$opl[$h]['1][dolg'];
//		for ($i=2;$i<$opl[$h]['kol'];$i++)
//		{
//			for ($t=$i+1;$t<=$opl[$h]['kol'];$t++)
//			{
//				if ($opl[$h]['$i][sotrID']=$opl[$h]['$t][sotrID'])
//				{
//					$podr[$h]['kol_sotr']++;
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][sotrID']=$opl[$h]['$t][sotrID']=$row['sotrID'];
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][patN']=$opl[$h]['$t][patN'];
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][patID']=$opl[$h]['$t][patID'];
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][sotrN']=$opl[$h]['$t][sotrN'];
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][summ']=$opl[$h]['$t][summ'];
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][opl_vid']=$opl['$t][opl_vid'];
//					$podr[$h]['sotr'][$podr[$h][''kol_sotr]'][dolg']=$opl[$h]['$t][dolg'];
//				}
//			}
//		}
//	}
}
$query = "SELECT `podr`,SUM(`summ`) as summ FROM `sn_kass` 
		WHERE (
		(`smena`='".$sm_id."') AND  
		 (not(`oper` =0))
		 )
		GROUP BY `podr`" ;
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$summ['sn_kass][1']=0;
$summ['sn_kass][2']=0;
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$summ['sn_kass'][$row['podr']]+=$row['summ'];
}
//echo "<span class='head2'>Приём авансов:</span>";
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `pr_avans`.`summ`
FROM klinikpat, pr_avans
WHERE (
(`pr_avans`.`date` ='".date('Y-m-d')."') AND  
(`klinikpat`.`id` =`pr_avans`.`pat`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ['pr_av']=0;
	for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$summ['pr_av']+=$row[3];
		}
		
		
if ($_GET['podr']==1)
{	
	echo "<span class='bold2'>Сумма за день: ".($summ['pr_av']+$summ['1][obsch'])."</span><br />";
	if ($summ['sn_kass][1']>0) echo "<span class='bold2'>Взято из кассы: ".$summ['sn_kass][1']."</span><br />";
	echo "<span class='bold2'>Наличными за день: ".($summ['pr_av']+$summ['1][nal'])."</span><br />";
	if ($summ['1][dog']!=0) echo "<span class='bold2'>По договорам за день: ".$summ['1][dog']."</span><br />";
	if ($summ['1][av']!=0) echo "<span class='bold2'>Из авансов за день: ".$summ['1][av']."</span><br />";
	if ($summ['1][bank_card']!=0) echo "<span class='bold2'>По банковским картам: ".$summ['1][bank_card']."</span><br />";
	if ($summ['1][proc']!=0) echo "<span class='bold2'>Бесплатная гигиена по 10% картам: ".$summ['1][proc']."</span><br />";

	if ($summ['kassa']<=($summ['pr_av']+$summ['1][nal'])) echo "<span class='bold2'>Выручка к сдаче: ".($summ['pr_av']+$summ['1][nal']+$summ['kassa2']-$summ['kassa']-$summ['sn_kass][1'])."</span><br />";
	else echo "<span class='bold2'>Выручка к сдаче: ".($summ['pr_av']+$summ['1][nal']+$summ['kassa2']-$summ['sn_kass][1']-$summ['1][dog'])."</span><br />";
}
else
{		
	echo "<span class='bold2'>Сумма за день: ".$summ['1][obsch']."</span><br />";
	if ($summ['1][dog']!=0) echo "<span class='bold2'>По договорам за день: ".$summ['1][dog']."</span><br />";
		if ($summ['1][bank_card']!=0) echo "<span class='bold2'>По банковским картам: ".$summ['1][bank_card']."</span><br />";
	if ($summ['1][proc']!=0) echo "<span class='bold2'>Бесплатная гигиена по 10% картам: ".$summ['1][proc']."</span><br />";
	if ($summ['1][av']!=0) echo "<span class='bold2'>Из авансов за день: ".$summ['1][av']."</span><br />";
	if ($summ['sn_kass][1']>0) 
	{
		echo "<span class='bold2'>Взято из кассы: ".$summ['sn_kass][2']."</span><br />";
		echo "<span class='bold2'>Выручка к сдаче: ".($summ['1][obsch']-$summ['sn_kass][2'])."</span><br />";
	}
}
for ($h=1;$h<=$countA;$h++)
{
	for ($i=1;$i<=$opl[$h]['el'];$i++)
	{	
		$c=0;
		$sotr[$h][$i]['summ']=0;
		echo "<br />
<span class='feature7'>Врач ".$sotr[$h][$i]['sotrN'].":</span><br />";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='bottom' width='50%'>Пациент</td>
				<td class='bottom' width='25%'>Сумма</td>
				<td align='center' class='bottom' width='25%'>Вид оплаты</td>
			  </tr>";
		for ($j=1;$j<=$opl[$h]['kol'];$j++)
		{

			if ($sotr[$h][$i]['id']==$opl[$h][$j]['sotrID'])
			{
				  echo "<tr class='alltext'>
					<td>".$opl[$h][$j]['patN']."</td>
					<td>".$opl[$h][$j]['summ']."</td>
					<td>".$opl[$h][$j]['opl_vid'].$opl[$h][$j]['dolg']."</td>
				  </tr>";
				  $sotr[$h][$i]['summ']+=$opl[$h][$j]['summ'];
				  $c++;
			}
		}
		echo "</table>";
		echo "<span class='smalltextR'>Принято пациентов: ".$c."</span><br />
				<span class='smalltextR'>Сумма: ".$sotr[$h][$i]['summ']."</span><br />
";
	
	}
}
	if ($_GET['podr']==1)
	{
	$query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `pr_avans`.`summ`
FROM klinikpat, pr_avans
WHERE (
(`pr_avans`.`date` ='".date('Y-m-d')."') AND  
(`klinikpat`.`id` =`pr_avans`.`pat`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
		echo "<span class='feature7'>Приём авансов:</span>";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'> <tr>
				<td><center class='bottom'>Пациент</center></td>
				<td><center class='bottom'>Сумма</center></td>
			  </tr>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<tr>
				<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
				<td>".$row[3]."</td>
			  </tr>";
		}
		echo "</table><span class='smalltextR'>Итого: ".$summ['pr_av']."</span><br />";

	}
	}
	$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `oper_vid`.`naim`,`sn_kass`.`summ`
FROM sotr, oper_vid, sn_kass
WHERE ((`sn_kass`.`smena` = '".$sm_id."') 
AND (`oper_vid`.`id` =`sn_kass`.`oper`) 
AND (`sotr`.`id` =`sn_kass`.`otv`)
AND not(0 =`sn_kass`.`oper`) 
AND (`sn_kass`.`podr` =".$_GET['podr']."))";
//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
	{
	echo "<span class='feature7'>Деньги из кассы:</span>";	
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
	  <tr>
	  	<td><center class='bottom'>Отвественное лицо</center></td>
	  	<td><center class='bottom'>Сумма</center></td>
		<td><center class='bottom'>Цель</center></td>
		
	  </tr>";
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
	  echo "<tr>
		<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
		<td>".$row[4]."</td>
		<td>".$row[3]."</td>
	  </tr>";
	}
	echo "</table>";
	echo "<span class='smalltextR'>Сумма: ".$summ['sn_kass'][$_GET['podr']]."</span><br />"; 
	}

	echo "<br />
<br />
<span class='bold2'>Кассир ".$_SESSION['UserName']."___________________</span><br />";
	break;
} 
//echo "<script language=\"JavaScript\" type=\"text/javascript\">
//				 window.print();
//				  </script>";
//schet_orto
//zaknar
//dnev
//orto_sch
//schet_hyg
//echo "<center> <a href='#' onclick='window.close()' class='mmenu'>Закрыть окно</a</center>";

//include("footer2.php");
?>
