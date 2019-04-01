<?php
$ThisVU="all";
$this->title=""; 
$this->context->layout='@frontend/views/layouts/light.php';
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
						 (`dnev`.`summ_k_opl`-`dnev`.`summ_vnes`) AS dolg
				FROM klinikpat, dnev, sotr, oplata, opl_vid
				WHERE ((`klinikpat`.`id` =`dnev`.`pat`) AND 
				(`sotr`.`id` =`dnev`.`vrach`) AND 
				(`oplata`.`dnev` =`dnev`.`id`) AND 
				(`dnev`.`id` ='".$_GET['dnev']."') AND 
				(`opl_vid`.`id` =`oplata`.`VidOpl`))";
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

			Пациент (".$rowA[0]." ".$rowA[1]." ".$rowA[2].")_________________</div> ";
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
$summ['1][bank_card']=0;
$summ['2][bank_card']=0;
$summ['1][proc']=0;
$summ['2][proc']=0;
$query = "SELECT `id`, `nazv` FROM `podr` WHERE `id`=".$_GET['podr'] ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
for ($h=1;$h<=$countA;$h++)
{
$rowA= mysqli_fetch_array($resultA);
	////
	$opl['$h][kol']=0;
	$opl['$h][el']=1;
	$opl['$h][nazv']=$rowA['nazv'];
	$opl['$h][id']=$rowA['id'];
	echo "<form action='dir_den.php' method='get' >
		<br /><center><span class='feature3' >Финансовый отчёт ".$opl['$h][nazv']." за  ".date('d.m.Y')."</span></center>
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
		`".$tables['$j']."`.`date`,
		(`".$tables['$j']."`.`summ_k_opl`-`".$tables['$j']."`.`summ_vnes`) as dolg,
		(`klinikpat`.`otch`) AS patID, 
		(`sotr`.`surname`) AS sotrID,
		`oplata`.`VidOpl`,
		`".$tables['$j']."`.`id`
		FROM klinikpat, sotr, oplata, ".$tables['$j'].", opl_vid
		WHERE (
		(`oplata`.`date` ='".date('Y-m-d')."') AND 
		(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
		(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables['$j']."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
		(`oplata`.`podr`=".$opl['$h][id'].")
		 AND
		(`oplata`.`type`=".($j+1).")
		)
		ORDER BY `".$tables['$j']."`.`vrach`";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>0)
		{
			  for ($i=0;$i<$count;$i++)
				{
					$opl['$h][kol']++;
					$row = mysqli_fetch_array($result);
					if ($opl['$h][kol']==1) 
					{
						$sotr['$h'][$opl['$h]['el]'][id']=$row['sotrID'];
						$sotr['$h'][$opl['$h]['el]'][sotrN']=$row[3]." ".$row[4]." ".$row[5];
					}
					else 
					{
						$fl=0;
						for ($t=1;$t<=$opl['$h][el'];$t++)
						{
							if ($sotr['$h']['$t][id']==$row['sotrID']) $fl=1;
						}
						if ($fl==0) 
						{
							$opl['$h][el']++;
							$sotr['$h'][$opl['$h]['el]'][sotrN']=$row[3]." ".$row[4]." ".$row[5];
							$sotr['$h'][$opl['$h]['el]'][id']=$row['sotrID'];
						}
					}
					$opl['$h'][$opl['$h]['kol]'][patID']=$row['patID'];
					$opl['$h'][$opl['$h]['kol]'][patN']=$row[0]." ".$row[1]." ".$row[2];
					$opl['$h'][$opl['$h]['kol]'][sotrID']=$row['sotrID'];
					$opl['$h'][$opl['$h]['kol]'][sotrN']=$row[3]." ".$row[4]." ".$row[5];
					$opl['$h'][$opl['$h]['kol]'][summ']=$row[6];
					$opl['$h'][$opl['$h]['kol]'][opl_vid']=$row[7];
					//$opl['$h'][$opl['$h]['kol]'][patN']="<a class='mmenu' target='_blanc' href=\"print.php?type=chek&dnev=".$row['15']."&table=".$tables['$j']."&podr=".$opl['$h][id']."\">".$opl['$h'][$opl['$h]['kol]'][patN']."</a>";
					if ($row['10']!=$row[9]) $opl['$h'][$opl['$h]['kol]'][dolg']=" (долг)";
					else $opl['$h'][$opl['$h]['kol]'][dolg']="";
					if ($row['14']==1)
					{ 
						$summ['$h][nal']+=$row[6];
						$summ['nal']+=$row[6];
					}
					if ($row['14']==2)
					{
						$summ['$h][dog']+=$row[6];
					} 
					if ($row['14']==3)
					{
						$summ['$h][av']+=$row[6];
					} 
					if ($row['14']==4)
					{
						$summ['$h][proc']+=$row[6];
					} 
					if ($row['14']==5)
					{
						$summ['$h][bank_card']+=$row[6];
					} 
					$summ['$h][obsch']+=$row[6];
					$summ['obsch']+=$row[6];
				}
				
		}
	}
	//if ($opl['$h][kol']>0)
//	{
//		$podr['$h][kol_sotr']=1;
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrID']=$opl['$h][1][sotrID']=$row['sotrID'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patN']=$opl['$h][1][patN'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patID']=$opl['$h][1][patID'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrN']=$opl['$h][1][sotrN'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][summ']=$opl['$h][1][summ'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][opl_vid']=$opl['1][opl_vid'];
//		$podr['$h][sotr'][$podr['$h]['kol_sotr]'][dolg']=$opl['$h][1][dolg'];
//		for ($i=2;$i<$opl['$h][kol'];$i++)
//		{
//			for ($t=$i+1;$t<=$opl['$h][kol'];$t++)
//			{
//				if ($opl['$h']['$i][sotrID']=$opl['$h']['$t][sotrID'])
//				{
//					$podr['$h][kol_sotr']++;
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrID']=$opl['$h']['$t][sotrID']=$row['sotrID'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patN']=$opl['$h']['$t][patN'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][patID']=$opl['$h']['$t][patID'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][sotrN']=$opl['$h']['$t][sotrN'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][summ']=$opl['$h']['$t][summ'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][opl_vid']=$opl['$t][opl_vid'];
//					$podr['$h][sotr'][$podr['$h]['kol_sotr]'][dolg']=$opl['$h']['$t][dolg'];
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
	$summ['sn_kass']['$row['podr']']+=$row['summ'];
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
	if ($summ['1][bank_card']!=0) echo "<span class='bold2'>По банковским картам: ".$summ['1][bank_card']."</span><br />";
	if ($summ['1][proc']!=0) echo "<span class='bold2'>Бесплатная гигиена по 10% картам: ".$summ['1][proc']."</span><br />";

	if ($summ['1][av']!=0) echo "<span class='bold2'>Из авансов за день: ".$summ['1][av']."</span><br />";
	if (($summ['kassa']+$summ['sn_kass][1'])<=($summ['pr_av']+$summ['1][nal'])) echo "<span class='bold2'>Выручка к сдаче: ".($summ['pr_av']+$summ['1][nal']+$summ['kassa2']-$summ['kassa']-$summ['sn_kass][1'])."</span><br />";
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
	for ($i=1;$i<=$opl['$h][el'];$i++)
	{	
		$c=0;
		$sotr['$h']['$i][summ']=0;
		echo "<br />
<span class='feature7'>Врач ".$sotr['$h']['$i][sotrN'].":</span><br />";
		echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='bottom' width='50%'>Пациент</td>
				<td class='bottom' width='25%'>Сумма</td>
				<td align='center' class='bottom' width='25%'>Вид оплаты</td>
			  </tr>";
		for ($j=1;$j<=$opl['$h][kol'];$j++)
		{

			if ($sotr['$h']['$i][id']==$opl['$h']['$j][sotrID'])
			{
				  echo "<tr class='alltext'>
					<td>".$opl['$h']['$j][patN']."</td>
					<td>".$opl['$h']['$j][summ']."</td>
					<td>".$opl['$h']['$j][opl_vid'].$opl['$h']['$j][dolg']."</td>
				  </tr>";
				  $sotr['$h']['$i][summ']+=$opl['$h']['$j][summ'];
				  $c++;
			}
		}
		echo "</table>";
		echo "<span class='smalltextR'>Принято пациентов: ".$c."</span><br />
				<span class='smalltextR'>Сумма: ".$sotr['$h']['$i][summ']."</span><br />
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
	echo "<span class='smalltextR'>Сумма: ".$summ['sn_kass']['$_GET['podr']']."</span><br />"; 
	}

	echo "<br />
<br />
<span class='bold2'>Кассир ".$_SESSION['UserName']."___________________</span><br />";
	break;
	
	
	case "zp_otchet_1":
		$fp=$_GET['fp'];
	$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	if (!(isset($_GET['fp'])) and ($i==0))
	{
		$dtNp=explode("-",$row['nach']);
		$dtOp=explode("-",$row['okonch']);
		$dtN=$row['nach'];
		$dtO=$row['okonch'];
		$fp=$row['id'];
	}
	else
	{
		if ($_GET['fp']==$row['id'])
		{
			$dtNp=explode("-",$row['nach']);
			$dtOp=explode("-",$row['okonch']);
			$dtN=$row['nach'];
			$dtO=$row['okonch'];
			$fp=$row['id'];
		}
	}
}
	$dt=explode("-",$row['okonch']);
	echo "<div class='bold2'>Начисление заработной платы. Долги прошлых месяцев.</div><br />";	
	$tables=array ("dnev","zaknar","schet_orto");
	//for ($j=0;$j<$countA;$j++)
//	{
//		$row = mysqli_fetch_array($resultA);
		
		$summ_all=0;
		$summ_tek=0;
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			SUM(`oplata`.`vnes`) AS summ,
			`zarp_card`.`stavka`,
			`zarp_card`.`id` as zc_id,
			`proc_sh`.`id` as pc_id,
			`zarp_card`.`pn`
			FROM sotr, oplata, ".$tables['$j'].",zarp_card,proc_sh
			WHERE (
			(`proc_sh`.`id`=`zarp_card`.`ps`) AND 
			(`zarp_card`.`type`=1) AND
			(`".$tables['$j']."`.`vrach`=`zarp_card`.`sotr`) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).") AND
			`".$tables['$j']."`.`date`<'".$dtN."'
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][zc']=$row['zc_id'];
					$sotr['$row['id]'][stavka']=$row['stavka'];
					$sotr['$row['id]'][pc']=$row['pc_id'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['$row['id]'][dolzh']=$row['dolzh'];
					$sotr['$row['id]'][pn']=$row['pn'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
		
	//}

	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Врач</td>
    <td class='feature3'>Выручка</td>
    <td class='feature3'>%</td>
	<td class='feature3'>% от выручки</td>
	<!-- <td class='feature3'>Подоходный</td>
	
    <td class='feature3'>Зарплата</td> -->
  </tr>";
for ($i=0;$i<$c;$i++)
{

	echo "<tr>
    <td>".$sotr[$sotr_sp['$i]][name']."</td>
    <td>".$sotr[$sotr_sp['$i]][summ']."</td>
    <td>";
	$query = "SELECT `predel`,`proc` FROM `proc_sh_sootv` WHERE `proc_sh`=".$sotr[$sotr_sp['$i]][pc']." ORDER BY `predel` DESC limit 1" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count==1) 
	{
		$row = mysqli_fetch_array($result);
		$proc=$row['proc'];
	}
	else
	for ($j=0;$j<$count;$j++)
		{
			   $row = mysqli_fetch_array($result);
			   if ($sotr[$sotr_sp['$i]][summ']<$row['predel'])
			   {
			   		$proc=$row['proc'];
					$j=$count+1;
			   }  
		}
	$zp=(($sotr[$sotr_sp['$i]][summ']*$proc)/100);
	//$zp-=$zp*$sotr[$sotr_sp['$i]][pn'];
	echo $proc."%</td>
	<td>".round((($sotr[$sotr_sp['$i]][summ']*$proc)/100),2)."</td>";
	//echo "
	//<td>".round(((($sotr[$sotr_sp['$i]][summ']*$proc)/100)*$sotr[$sotr_sp['$i]][pn']),2)."</td>
	//  <td>".round($zp,2)."</td>";
    echo "
  </tr>";
  $summ_tek+=round($zp,2);
}
echo "</table><br/>";
echo "<div class='bold2'>Начисление заработной платы 01.01.2011-24.01.2011</div><br />";
	unset($sotr);	
	$dtO="2011-01-22";	
	$tables=array ("dnev","zaknar","schet_orto");
	//for ($j=0;$j<$countA;$j++)
//	{
//		$row = mysqli_fetch_array($resultA);
		unset($sotr);
		$summ_all=0;
		$summ_tek=0;
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			`zarp_card`.`stavka`,
			`zarp_card`.`id` as zc_id,
			`proc_sh`.`id` as pc_id,
			`zarp_card`.`pn`,
			SUM(`".$tables['$j']."`.`summ_vnes`) as summ2
			FROM sotr,".$tables['$j'].",zarp_card,proc_sh
			WHERE (
			(`proc_sh`.`id`=`zarp_card`.`ps`) AND 
			(`zarp_card`.`type`=1) AND
			(`".$tables['$j']."`.`vrach`=`zarp_card`.`sotr`) AND
			(`".$tables['$j']."`.`date` >='".$dtN."') AND 
			(`".$tables['$j']."`.`date` <='".$dtO."') AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`)
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ2'];
					$sotr['$row['id]'][zc']=$row['zc_id'];
					$sotr['$row['id]'][stavka']=$row['stavka'];
					$sotr['$row['id]'][pc']=$row['pc_id'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['$row['id]'][dolzh']=$row['dolzh'];
					$sotr['$row['id]'][pn']=$row['pn'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
		
	//}

	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Врач</td>
    <td class='feature3'>Выручка</td>
    <td class='feature3'>%</td>
	<td class='feature3'>% от выручки</td>
	<!-- <td class='feature3'>Подоходный</td>
	
    <td class='feature3'>Зарплата</td> -->
  </tr>";
for ($i=0;$i<$c;$i++)
{

	echo "<tr>
    <td>".$sotr[$sotr_sp['$i]][name']."</td>
    <td>".$sotr[$sotr_sp['$i]][summ']."</td>
    <td>";
	$query = "SELECT `predel`,`proc` FROM `proc_sh_sootv` WHERE `proc_sh`=".$sotr[$sotr_sp['$i]][pc']." ORDER BY `predel` DESC limit 1" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count==1) 
	{
		$row = mysqli_fetch_array($result);
		$proc=$row['proc'];
	}
	else
	for ($j=0;$j<$count;$j++)
		{
			   $row = mysqli_fetch_array($result);
			   if ($sotr[$sotr_sp['$i]][summ']<$row['predel'])
			   {
			   		$proc=$row['proc'];
					$j=$count+1;
			   }  
		}
	$zp=(($sotr[$sotr_sp['$i]][summ']*$proc)/100);
	//$zp-=$zp*$sotr[$sotr_sp['$i]][pn'];
	echo $proc."%</td>
	<td>".round((($sotr[$sotr_sp['$i]][summ']*$proc)/100),2)."</td>";
	//echo "
	//<td>".round(((($sotr[$sotr_sp['$i]][summ']*$proc)/100)*$sotr[$sotr_sp['$i]][pn']),2)."</td>
	//  <td>".round($zp,2)."</td>";
    echo "
  </tr>";
  $summ_tek+=round($zp,2);
}
$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			SUM(`oplata`.`vnes`) AS summ
			FROM sotr, oplata, ".$tables['$j']."
			WHERE (
			(`".$tables['$j']."`.`vrach`=2) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).") AND 
			(`oplata`.`VidOpl`=5)
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		}
		for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
	echo "<tr>
    <td>".$sotr['2][name']."</td>
    <td>".$sotr['2][summ']."</td>
    <td class='menutext'></td>
    <td>".$sotr['2][summ']."</td>
  </tr>";
  $summ_tek+=$sotr['2][summ']; 
 $summ_all+= $summ_tek;
echo "</table>";

	echo "<br><div class='bold2'>Начисление заработной платы 24.01.2011-31.01.2011</div>";
	$dtN="2011-01-24";	
	$dtO="2011-01-31";	
	$tables=array ("dnev","zaknar","schet_orto");
		unset($sotr);
		$summ_all=0;
		$summ_tek=0;
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			`zarp_card`.`stavka`,
			`zarp_card`.`id` as zc_id,
			`proc_sh`.`id` as pc_id,
			`zarp_card`.`pn`,
			SUM(`".$tables['$j']."`.`summ_vnes`) as summ2
			FROM sotr, ".$tables['$j'].",zarp_card,proc_sh
			WHERE (
			(`proc_sh`.`id`=`zarp_card`.`ps`) AND 
			(`zarp_card`.`type`=1) AND
			(`".$tables['$j']."`.`vrach`=`zarp_card`.`sotr`) AND
			(`".$tables['$j']."`.`date` >='".$dtN."') AND 
			(`".$tables['$j']."`.`date` <='".$dtO."') AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`)
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ2'];
					$sotr['$row['id]'][zc']=$row['zc_id'];
					$sotr['$row['id]'][stavka']=$row['stavka'];
					$sotr['$row['id]'][pc']=$row['pc_id'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['$row['id]'][dolzh']=$row['dolzh'];
					$sotr['$row['id]'][pn']=$row['pn'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
		
	$new_proc[1]="0.216";
	$new_proc[3]="0.25";
	$new_proc[9]="0.223";
	$new_proc['24']="0.168";
	echo "<br /><span class='feature7'>Расчёт по проценту от выручки</span><br />
		<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Врач</td>
    <td class='feature3'>Выручка</td>
    <td class='feature3'>%</td>
	<td class='feature3'>% от выручки</td>
	<!-- <td class='feature3'>Подоходный</td>
	
    <td class='feature3'>Зарплата</td> -->
  </tr>";
for ($i=0;$i<$c;$i++)
{

	echo "<tr>
    <td>".$sotr[$sotr_sp['$i]][name']."</td>
    <td>".$sotr[$sotr_sp['$i]][summ']."</td>
    <td>";
	$query = "SELECT `predel`,`proc` FROM `proc_sh_sootv` WHERE `proc_sh`=".$sotr[$sotr_sp['$i]][pc']." ORDER BY `predel` DESC limit 1" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count==1) 
	{
		$row = mysqli_fetch_array($result);
		$proc=$row['proc'];
	}
	else
	for ($j=0;$j<$count;$j++)
		{
			   $row = mysqli_fetch_array($result);
			   if ($sotr[$sotr_sp['$i]][summ']<$row['predel'])
			   {
			   		$proc=$row['proc'];
					$j=$count+1;
			   }  
		}
	$zp=(($sotr[$sotr_sp['$i]][summ']*$proc)/100);
	//$zp-=$zp*$sotr[$sotr_sp['$i]][pn'];
	echo ($new_proc[$sotr_sp['$i]']*100)."%</td>
	<td>".round((($sotr[$sotr_sp['$i]][summ']*$new_proc[$sotr_sp['$i]'])),2)."</td>";
	//echo "
	//<td>".round(((($sotr[$sotr_sp['$i]][summ']*$proc)/100)*$sotr[$sotr_sp['$i]][pn']),2)."</td>
	//  <td>".round($zp,2)."</td>";
    echo "</tr>";
}
	echo "</table>";
	break;
	
	////Отчёт по ЗП
	case "zp_otchet":
	$fp=$_GET['fp'];
	$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	if (!(isset($_GET['fp'])) and ($i==0))
	{
		$dtNp=explode("-",$row['nach']);
		$dtOp=explode("-",$row['okonch']);
		$dtN=$row['nach'];
		$dtO=$row['okonch'];
		$fp=$row['id'];
	}
	else
	{
		if ($_GET['fp']==$row['id'])
		{
			$dtNp=explode("-",$row['nach']);
			$dtOp=explode("-",$row['okonch']);
			$dtN=$row['nach'];
			$dtO=$row['okonch'];
			$fp=$row['id'];
		}
	}
}
	$dt=explode("-",$row['okonch']);
	echo "<div class='bold2'>Начисление заработной платы за ".$m['$_GET[m]']."</div><br />";
		
	$tables=array ("dnev","zaknar","schet_orto");
	//for ($j=0;$j<$countA;$j++)
//	{
//		$row = mysqli_fetch_array($resultA);
		
		$summ_all=0;
		$summ_tek=0;
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			SUM(`oplata`.`vnes`) AS summ,
			`zarp_card`.`stavka`,
			`zarp_card`.`id` as zc_id,
			`proc_sh`.`id` as pc_id,
			`zarp_card`.`pn`
			FROM sotr, oplata, ".$tables['$j'].",zarp_card,proc_sh
			WHERE (
			(`proc_sh`.`id`=`zarp_card`.`ps`) AND 
			(`zarp_card`.`type`=1) AND
			(`".$tables['$j']."`.`vrach`=`zarp_card`.`sotr`) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).")
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][zc']=$row['zc_id'];
					$sotr['$row['id]'][stavka']=$row['stavka'];
					$sotr['$row['id]'][pc']=$row['pc_id'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['$row['id]'][dolzh']=$row['dolzh'];
					$sotr['$row['id]'][pn']=$row['pn'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
		
	//}

	echo "<br /><span class='feature7'>Расчёт по проценту от выручки</span><br />
		<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Врач</td>
    <td class='feature3'>Выручка</td>
    <td class='feature3'>%</td>
	<td class='feature3'>% от выручки</td>
	<!-- <td class='feature3'>Подоходный</td>
	
    <td class='feature3'>Зарплата</td> -->
  </tr>";
for ($i=0;$i<$c;$i++)
{

	echo "<tr>
    <td>".$sotr[$sotr_sp['$i]][name']."</td>
    <td>".$sotr[$sotr_sp['$i]][summ']."</td>
    <td>";
	$query = "SELECT `predel`,`proc` FROM `proc_sh_sootv` WHERE `proc_sh`=".$sotr[$sotr_sp['$i]][pc']." ORDER BY `predel` ASC" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count==1) 
	{
		$row = mysqli_fetch_array($result);
		$proc=$row['proc'];
	}
	else
	for ($j=0;$j<$count;$j++)
		{
			   $row = mysqli_fetch_array($result);
			   if ($sotr[$sotr_sp['$i]][summ']<$row['predel'])
			   {
			   		$proc=$row['proc'];
					$j=$count+1;
			   }  
		}
	$zp=(($sotr[$sotr_sp['$i]][summ']*$proc)/100);
	//$zp-=$zp*$sotr[$sotr_sp['$i]][pn'];
	echo $proc."%</td>
	<td>".round((($sotr[$sotr_sp['$i]][summ']*$proc)/100),2)."</td>";
	//echo "
	//<td>".round(((($sotr[$sotr_sp['$i]][summ']*$proc)/100)*$sotr[$sotr_sp['$i]][pn']),2)."</td>
	//  <td>".round($zp,2)."</td>";
    echo "
  </tr>";
  $summ_tek+=round($zp,2);
}
$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query = "SELECT 
			`sotr`.`id`, 
			`sotr`.`surname`, 
			`sotr`.`name`, 
			`sotr`.`otch`,
			`sotr`.`dolzh`, 
			SUM(`oplata`.`vnes`) AS summ
			FROM sotr, oplata, ".$tables['$j']."
			WHERE (
			(`".$tables['$j']."`.`vrach`=2) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id` =`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).") AND 
			(`oplata`.`VidOpl`=5)
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		}
		for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
	echo "<tr>
    <td>".$sotr['2][name']."</td>
    <td>".$sotr['2][summ']."</td>
    <td class='menutext'></td>
    <td>".$sotr['2][summ']."</td>
  </tr>";
  $summ_tek+=$sotr['2][summ']; 
 $summ_all+= $summ_tek;


echo "</table>";
echo "
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$summ_tek." руб.<br />";
			  echo "</tr>
			</table>";
$summ_tek=0;
$query = "SELECT `sotr`.`id`,`sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` , `zarp_card`.`ph`,`zarp_card`.`id` as zc
FROM sotr, zarp_card
WHERE (
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =3
)
)";
//echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
echo "<span class='feature7'>Расчёт по сменам</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Сотрудник</td>
    <td class='feature3'>Часов</td>
	<td class='feature3'>За час</td>
	<td class='feature3'>Сумм по сменам</td>
	<td class='feature3'>Сумм по снимкам</td>
	<td class='feature3'>Надбавки</td>
	<!-- <td class='feature3'>Подоходный</td> -->
    <td class='feature3'>Зарплата</td>
  </tr>";
for ($i=0; $i<$countA; $i++)
{
	$rowA = mysqli_fetch_array($resultA);
	echo "<tr>";
	echo "<td>".$rowA['surname']." ".$rowA['name']." ".$rowA['otch']."</td>";
$dtN_TS=mktime(0,0,0,(integer)$dtNp[1],(integer)$dtNp[2],(integer)$dtNp[0]);
$dtO_TS=mktime(0,0,0,(integer)$dtOp[1],(integer)$dtOp[2],(integer)$dtOp[0]);

	$query = "SELECT `tabel`.`time`
	FROM  tabel
	WHERE (
	(`tabel`.`date` >='".$dtN."') AND 
	(`tabel`.`date` <='".$dtO."') AND 
	(`tabel`.`sotr` =".$rowA['id'].")
	)";
	//echo $query."<br />";
$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."') AND 
(`sotr` =".$rowA['id'].")
)
ORDER BY `sotr` ASC, `date` ASC";	
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
			$in=explode(":",$row['in']);
		$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
		$out=explode(":",$row['out']);
		$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
		if (($out2-$in2)>0) $summ+=($out2-$in2);
		//$summ+=(floor($row['time'])*60)+(($row['time']-floor($row['time']))*100);
	}
	//
	$summ+=21600;
	$ss=round($summ/3600,2);
    echo "<td>".$ss."</td>";
	echo "<td>".$rowA['ph']."</td>";
	$zp=(($summ/3600)*$rowA['ph']);
	echo "<td>".round($zp,2)."</td>";`xray_uch`.
	$query = "SELECT `summ` FROM `xray_summ` WHERE `sotr`=".$rowA['id']." AND `fp`=".$fp;
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	if ($count>0)
	{
		$row = mysqli_fetch_array($result);
		$summ=$row['summ'];
	}
	else
	{
	
		$tables[0]=array ("dnev","`manip_pr`","`manip_pr`.`dnev`");
		$tables[1]=array ("zaknar","`manip_zn`","`manip_zn`.`ZN`");
		$tables[2]=array ("schet_orto","`manip_sh_orto`","`manip_sh_orto`.`SO`");
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query="SELECT 
				sum(".$tables['$j][1'].".`kolvo`*`manip`.`price` ) as summ
			FROM ".$tables['$j][1'].", manip, ".$tables['$j][0'].",xray_uch
			WHERE (
			(`".$tables['$j][0']."`.`date` >='".$dtN."') AND 
			(`".$tables['$j][0']."`.`date` <'".$dtO."') AND
			(".$tables['$j][2']." =`".$tables['$j][0']."`.`id`) AND 
			(`manip`.`id` IN (26,27,254,255)) AND 
			(".$tables['$j][1'].".`manip` =`manip`.`id`) AND
			(`xray_uch`.`type`=".$j.") AND
			(`xray_uch`.`sotr`=".$rowA['id']." ) AND
			(".$tables['$j][1'].".`id`=`xray_uch`.`manip_pr`)
			)
			GROUP BY `xray_uch`.`type`";
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$summ+=$row['summ'];

		}
	}
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		sum(`oplata`.`vnes`) AS summ, 
		`opl_vid`.`vid`, 
		`oplata`.`date`
		FROM klinikpat, sotr, oplata, dnev, opl_vid
		WHERE (
		(`dnev`.`vrach`='".$rowA['id']."') AND
		(`oplata`.`date` >='".$dtN."') AND 
		(`oplata`.`date` <='".$dtO."') AND 
		(`oplata`.`dnev` =`dnev`.`id`) AND 
		(`sotr`.`id` =`dnev`.`vrach`) AND 
		(`klinikpat`.`id` =`dnev`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
		(`oplata`.`type`=1))
		GROUP BY `dnev`.`vrach`
		";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);	
		$row = mysqli_fetch_array($result);
		$summ=$row['summ'];
	echo "<td>".$summ*0.15."</td>";
	$zp+=$summ*0.15;
	$query = "SELECT `nadb`.`summ`
FROM nadb, nadb_sootv
WHERE ((`nadb_sootv`.`zc` =".$rowA['zc'].") AND (`nadb`.`id` =`nadb_sootv`.`nadb`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;

	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
		$summ+=$row['summ'];
	}
	echo "<td>".$summ."</td>";
	$zp+=$summ;
	//echo "<td>".round(($zp*0.13),2)."</td>";
	//$zp-=($zp*0.13);
    echo "<td>".round($zp,2)."</td>";
    $summ_tek+=round($zp,2);
	echo "</tr>";
}
$summ_all+= $summ_tek;
echo "</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$summ_tek." руб.<br />
				</tr>
			</table>";
echo "<span class='feature7'>Расчёт по ставке</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Сотрудник</td>
 <!--    <td class='feature3'>Ставка</td>
    <td class='feature3'>Подоходный</td> -->
	<td class='feature3'>Зарплата</td>
  </tr>";
$query = "SELECT `sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` 
FROM sotr, zarp_card
WHERE (
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =2
)
)";
//echo $query."<br />";
$summ_tek=0;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr>";
	echo "<td>".$row['surname']." ".$row['name']." ".$row['otch']."</td>";
	echo "<td>".$row['stavka']."</td>";
	//echo "<td>".($row['stavka']*$row['pn'])."</td>";
	//echo "<td>".($row['stavka']-($row['stavka']*$row['pn']))."</td>";
	
	$summ_tek+=($row['stavka']-($row['stavka']*$row['pn']));
	echo "</tr>";
}
$summ_all+= $summ_tek;
echo "</table><table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Итого: ".$summ_tek." руб.<br /></tr>
			</table>";
echo "</table><table width='100%' border='0' cellspacing='0' cellpadding='0'>
			  <tr>
				<td width='67%' height='49'>&nbsp;</td>
				<td width='33%' class='feature7'>Общая сумма: ".$summ_all." руб.<br /></tr>
			</table>";
	break;
	case "zp_fishka":
		$query = "SELECT `id`,`nach` , `okonch` 
FROM `fin-per` 
ORDER BY `id` DESC" ;


//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	if (!(isset($_GET['fp'])) and ($i==0))
	{
		$dtNp=explode("-",$row['nach']);
		$dtOp=explode("-",$row['okonch']);
		$dtN=$row['nach'];
		$dtO=$row['okonch'];
		$fp=$row['id'];
	}
	else
	{
		if ($_GET['fp']==$row['id'])
		{
			$dtNp=explode("-",$row['nach']);
			$dtOp=explode("-",$row['okonch']);
			$dtN=$row['nach'];
			$dtO=$row['okonch'];
			$fp=$row['id'];
		}
	}
}
	$dt=explode("-",$row['okonch']);
	
		switch ($_GET['vid'])
		{
			case "1":
					$tables=array ("dnev","zaknar","schet_orto");
					$c=0;
					for ($j=0;$j<=2;$j++)
					{
						$query = "SELECT 
						`sotr`.`id`, 
						`sotr`.`surname`, 
						`sotr`.`name`, 
						`sotr`.`otch`,
						`sotr`.`dolzh`, 
						SUM(`oplata`.`vnes`) AS summ,
						`zarp_card`.`stavka`,
						`zarp_card`.`id` as zc_id,
						`proc_sh`.`id` as pc_id,
						`zarp_card`.`pn`
						FROM sotr, oplata, ".$tables['$j'].",zarp_card,proc_sh
						WHERE (
						(`sotr`.`id`=".$_GET['sotr'].") AND
						(`proc_sh`.`id`=`zarp_card`.`ps`) AND 
						(`zarp_card`.`type`=1) AND
						(`".$tables['$j']."`.`vrach`=`zarp_card`.`sotr`) AND
			(`oplata`.`date` >='".$dtN."') AND 
			(`oplata`.`date` <='".$dtO."') AND 
			(`oplata`.`dnev` =`".$tables['$j']."`.`id`) AND 
			(`sotr`.`id`=`".$tables['$j']."`.`vrach`) AND 
			(`oplata`.`type`=".($j+1).")
			)
			GROUP BY `".$tables['$j']."`.`vrach`";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if (isset($sotr['$row['id]'][summ'])) $sotr['$row['id]'][summ']+=$row['summ'];
				else  
				{
					$sotr['$row['id]'][summ']=$row['summ'];
					$sotr['$row['id]'][zc']=$row['zc_id'];
					$sotr['$row['id]'][stavka']=$row['stavka'];
					$sotr['$row['id]'][pc']=$row['pc_id'];
					$sotr['$row['id]'][name']=$row['surname']." ".$row['name']." ".$row['otch'];
					$sotr['$row['id]'][dolzh']=$row['dolzh'];
					$sotr['$row['id]'][pn']=$row['pn'];
					$sotr_sp['$c']=$row['id'];
					$c++;
				}
			}
		}
$i=0;
				echo "ФИО: ".$sotr['$sotr_sp['0]'][name']."<br/>";
				echo "Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</br>";
				echo "Выручка: ".$sotr['$sotr_sp['0]'][summ']." руб.<br/>";
				$query = "SELECT `predel`,`proc` FROM `proc_sh_sootv` WHERE `proc_sh`=".$sotr[$sotr_sp['$i]][pc']." ORDER BY `predel` ASC" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count==1) 
	{
		$row = mysqli_fetch_array($result);
		$proc=$row['proc'];
	}
	else
	for ($j=0;$j<$count;$j++)
		{
			   $row = mysqli_fetch_array($result);
			   if ($sotr[$sotr_sp['$i]][summ']<$row['predel'])
			   {
			   		$proc=$row['proc'];
					$j=$count+1;
			   }  
		}
	$zp=(($sotr[$sotr_sp['$i]][summ']*$proc)/100);
	$zp-=$zp*$sotr[$sotr_sp['$i]][pn'];
				echo "Процент: ".$proc."%<br/>";
				echo "Сумма от выручки: ".round((($sotr[$sotr_sp['$i]][summ']*$proc)/100),2)." руб.<br/>";
				echo "Подоходный: ".round(((($sotr[$sotr_sp['$i]][summ']*$proc)/100)*$sotr[$sotr_sp['$i]][pn']),2)."руб. (".($sotr[$sotr_sp['$i]][pn']*100)."%) <br/>";
				echo "<br/>Зарплата: ".round($zp,2)." руб. <br/>";
			break;
//Расчёт			
			case "2":
				$query = "SELECT `sotr`.`id`,`sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` , `zarp_card`.`ph`,`zarp_card`.`id` as zc
FROM sotr, zarp_card
WHERE (
(`sotr`.`id` =".$_GET['sotr'].") 
AND
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =3
)
)";
//echo $query."<br />";


$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
 
$rowA = mysqli_fetch_array($resultA);
	echo "ФИО: ".$rowA['surname']." ".$rowA['name']." ".$rowA['otch']."<br/>";
	echo "Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</br>";
	
//echo $query."<br>";
$dtN_TS=mktime(0,0,0,(integer)$dtNp[1],(integer)$dtNp[2],(integer)$dtNp[0]);
$dtO_TS=mktime(0,0,0,(integer)$dtOp[1],(integer)$dtOp[2],(integer)$dtOp[0]);

$query = "SELECT `tabel`.`time`
	FROM  tabel
	WHERE (
	(`tabel`.`date` >='".$dtN."') AND 
	(`tabel`.`date` <='".$dtO."') AND 
	(`tabel`.`sotr` =".$rowA['id'].")
	)";
	//echo $query."<br />";

	
$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."') AND 
(`sotr` =".$rowA['id'].")
)
ORDER BY `sotr` ASC, `date` ASC";	
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
			$in=explode(":",$row['in']);
		$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
		$out=explode(":",$row['out']);
		$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
		if (($out2-$in2)>0) $summ+=($out2-$in2);
	}
	$summ+=21600;
	$ss=round($summ/3600,2);
	echo "Отработано часов: ".$ss."<br/>";
	echo "Ставка в час: ".$rowA['ph']."  руб.<br/>";	
	$zp=(($summ/3600)*$rowA['ph']);
	echo "Зарплата по часам: ".round($zp,2)."  руб.<br/>";	
	$query = "SELECT `summ` FROM `xray_summ` WHERE `sotr`=".$rowA['id']." AND `fp`=".$fp;
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	if ($count>0)
	{
		$row = mysqli_fetch_array($result);
		$summ=$row['summ'];
	}
	else
	{
	
		$tables[0]=array ("dnev","`manip_pr`","`manip_pr`.`dnev`");
		$tables[1]=array ("zaknar","`manip_zn`","`manip_zn`.`ZN`");
		$tables[2]=array ("schet_orto","`manip_sh_orto`","`manip_sh_orto`.`SO`");
		$c=0;
		for ($j=0;$j<=2;$j++)
		{
			$query="SELECT 
				sum(".$tables['$j][1'].".`kolvo`*`manip`.`price` ) as summ
			FROM ".$tables['$j][1'].", manip, ".$tables['$j][0'].",xray_uch
			WHERE (
			(`".$tables['$j][0']."`.`date` >='".$dtN."') AND 
			(`".$tables['$j][0']."`.`date` <'".$dtO."') AND
			(".$tables['$j][2']." =`".$tables['$j][0']."`.`id`) AND 
			(`manip`.`id` IN (26,27,254,255)) AND 
			(".$tables['$j][1'].".`manip` =`manip`.`id`) AND
			(`xray_uch`.`type`=".$j.") AND
			(`xray_uch`.`sotr`=".$rowA['id']." ) AND
			(".$tables['$j][1'].".`id`=`xray_uch`.`manip_pr`)
			)
			GROUP BY `xray_uch`.`type`";
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$summ+=$row['summ'];
		}
	}
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		sum(`oplata`.`vnes`) AS summ, 
		`opl_vid`.`vid`, 
		`oplata`.`date`
		FROM klinikpat, sotr, oplata, dnev, opl_vid
		WHERE (
		(`dnev`.`vrach`='".$rowA['id']."') AND
		(`oplata`.`date` >='".$dtN."') AND 
		(`oplata`.`date` <='".$dtO."') AND 
		(`oplata`.`dnev` =`dnev`.`id`) AND 
		(`sotr`.`id` =`dnev`.`vrach`) AND 
		(`klinikpat`.`id` =`dnev`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
		(`oplata`.`type`=1))
		GROUP BY `dnev`.`vrach`
		";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);	
		$row = mysqli_fetch_array($result);
		
		$summ=$row['summ'];
		echo "Сумма по снимкам: ".$summ." руб.<br/>";
		echo "Зарплата по снимкам: ".$summ*0.15." руб.<br/>";
	$zp+=$summ*0.15;
	$query = "SELECT `nadb`.`summ`
FROM nadb, nadb_sootv
WHERE ((`nadb_sootv`.`zc` =".$rowA['zc'].") AND (`nadb`.`id` =`nadb_sootv`.`nadb`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
		$summ+=$row['summ'];
	}
	echo "Надбавки: ".$summ." руб.<br/>";
	$zp+=$summ;
	
	echo "Сумма: ".round($zp,2)." руб.<br/>";
	echo "Подоходный: ".round(($zp*0.13),2)." руб.<br/>";
	$zp-=($zp*0.13);
	echo "<br/>Зарплата: ".round($zp,2)." руб.<br/>";    
			break;
			case "3":
				$query = "SELECT `sotr`.`id`, `sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` 
FROM sotr, zarp_card
WHERE (
(`sotr`.`id` =".$_GET['sotr'].") AND
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =2
)
)";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
				echo "ФИО: ".$row['surname']." ".$row['name']." ".$row['otch']."<br/>";
				echo "Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</br>";
	
				echo "Ставка: ".$row['stavka']." руб.<br/>";
				echo "Подоходный: ".($row['stavka']*$row['pn'])." руб.<br/>";
				echo "<br/>Зарплата: ".($row['stavka']-($row['stavka']*$row['pn']))." руб.<br/>";
			break;
		}
	break;
} 
echo "<script language=\"JavaScript\" type=\"text/javascript\">window.print();</script>";
//schet_orto
//zaknar
//dnev
//orto_sch
//schet_hyg
//echo "<center> <a href='#' onclick='window.close()' class='mmenu'>Закрыть окно</a</center>";

//include("footer2.php");
?>
