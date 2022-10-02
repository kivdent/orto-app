<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Диспансеризация пациентов"; 
//include("header.php");
$query = "SELECT * FROM `rezobzv` ORDER BY `id` desc";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$rocount=$count;
for ($i=0;$i<$count;$i++)
{
$row = mysqli_fetch_array($result);
$ro[$i]['id']=$row['id'];
$ro[$i]['RezObzv']=$row['RezObzv'];
}
switch ($_GET['act'])
{
	case "obzv":
		$query = "UPDATE `kontr_osm` SET `rezobzv`=".$_GET['RezObzv']." WHERE `id`=".$_GET['ko'] ;
		//////////echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	break;
}
if (!(isset($_GET['action']))) ret("disp.php?action=month");
$mn=array("Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь","Октябрь","Ноябрь","Декабрь");
echo "<center>|<a href=\"disp.php?action=all\" class=\"menu2\">Все пациенты</a>|";
echo "|<a href=\"disp.php?action=non\" class=\"menu2\">Не пришедшие</a>|";
echo "|<a href=\"disp.php?action=month\" class=\"menu2\">По дате</a>|";
echo "|<a href=\"disp.php?action=spis\" class=\"menu2\">Список</a>|</center>";
echo "<br>";
echo "<table width='100%' border='0'>
<tr>
<td align='center'>";
 if (isset($_GET['month']))
			{
				$month=$_GET['month'];
			}
		else
			{
				$month=DATE("n");
			}
if (isset($_GET['year']))
			{
				$year=$_GET['year'];
			}
		else
			{
				$year=DATE("Y");
			}
for ($i=0;$i<=11;$i++)
{
	if (($i+1)==$month) $cl="menu8";
	else $cl="menu2"; 
	echo "|<a href=\"disp.php?action=month&month=".($i+1)."&year=".$year."\" class=\"".$cl."\">".$mn[$i]."</a>|";
	if ($i==5) echo "<br>";
}
echo "</td>
<td align='left'>";
for ($i=2007;$i<=(date('Y')+2);$i++)
{
	if ($i==$year) $cl="menu8";
	else $cl="menu2"; 
	echo "|<a href=\"disp.php?action=month&month=".$month."&year=".$i."\" class=\"".$cl."\">".$i."</a>|";
	
}
echo "
</td>
</tr>
</table>";
switch ($_GET['action'])
{
  case "all":
 
  $query = "SELECT
					DATE_FORMAT(`daypr`.`date`, '%d.%m.%Y' ) as datepr,
					DATE_FORMAT(`daypr`.`date`, '%m' ) as month,
					DATE_FORMAT(`daypr`.`date`, '%Y' ) as year,
					`sotr`.`surname`, 
	 	 			`sotr`.`name`, 
	 				`sotr`.`otch`, 
	 				`sotr`.`id`,
	 				`klinikpat`.`surname`,
	 				`klinikpat`.`name`,
	 				`klinikpat`.`otch`,
	 				`klinikpat`.`id`,
	 				`klinikpat`.`MTel`,
	 				`klinikpat`.`DTel`,
	 				`klinikpat`.`RTel`,
	 				`nazn`.`PatID`,
                                                                                       `daypr`.`date`
FROM nazn, daypr,sotr,klinikpat
WHERE (
(`nazn`.`dayPR`=`daypr`.`id`) AND
(`nazn`.`PatID`=`klinikpat`.`id`) AND
(`sotr`.`id`=`daypr`.`vrachID`)
)
GROUP BY `nazn`.`PatID`
ORDER BY datepr desc
";

  echo "<table  border='1' cellpadding='1' cellspacing='0 ' bordercolor='#999999' bgcolor='#ffffff'>";
echo "<tr>";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					echo "<td width='230'>Пациент</td>";
					echo "<td width='230'>Врач</td>";
					echo "<td width='90'>Дата</td>";
					echo "<td width='90'>Моб.тел</td>";
					echo "<td width='90'>Дом.тел</td>";
					echo "<td width='90'>Раб.тел</td>";
					echo "<td width='90'>Действие</td>";
					echo "<td width='90'>Назначение последнее</td>";
					echo "</tr>";
$resultA=$result;
$countA=$count;
for ($z=0;$z<$countA;$z++)
{ 
					$row = mysqli_fetch_array($resultA);
					$query = "SELECT `id` FROM `disp_card` WHERE `pat`=".$row['PatID'];
					//echo $query."<br>";
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);				
					echo "<tr class='feature2'>";
					echo "<td width='230'>".$row[7]." ".$row[8]." ".$row[9]."</td>";
					echo "<td width='230'>".$row[3]." ".$row[4]." ".$row[5]."</td>";
					echo "<td width='90'>".$row['next_date']."</td>";
					echo "<td width='90'>".$row['MTel']."</td>";
					echo "<td width='90'>".$row['DTel']."</td>";
					echo "<td width='90'>".$row['RTel']."</td>";
					echo "<td width='90'><a href='naznach.php?IDN=n&action=naznezh&step=1&pred=disp.php&vrach=".$row['sotrid']."&pat=".$row['patid']."' class='menu2'>Назначить</a></td>";	
					echo "<td width='90' ".$bg.">".$row[3]." ".$row[4]." ".$row[5]."<br>".$row['datepr']."</td>";
					echo "</tr>";

 }
echo "</table>";
 break;
  case "spis":
  	 
	break;
	case "non":
  	 
	break;
	case "sozd_ko":
  		switch($_GET['step'])
  		{
  			case "1":
  				echo "<form action=\"disp.php\" method=\"get\">";
					$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch` 
						FROM  sotr
							WHERE (`sotr`.`dolzh` IN (1,2,3,9))
						GROUP BY `sotr`.`id`
						ORDER BY `sotr`.`surname` ASC
						";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
echo "Врач: <select name=\"vrach\">";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($_GET['vrach']==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	else echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
}
		echo "</select><br>";
		echo "Следующий осмотр";
		echo "<select name=\"month\" size=\"0\">";
		for ($i=0;$i<=11;$i++)
			
		{	
			echo "<option value='".($i+1)."'>".$mn[$i]."</option>";
		}
		echo "</select>  ";
				echo "<select name=\"year\" size=\"0\">";
		for ($i=date("Y");$i<=(date("Y")+5);$i++)
			
		{	
			echo "<option value='".$i."'>".$i."</option>";
		}
		echo "</select>  ";
		echo "
		<input type=\"submit\" value=\"Сохранить\">
		<input type=\"hidden\" name=\"pat\" value=\"".$_GET['pat']."\">
		<input type=\"hidden\" name=\"pred\" value=\"".$_GET['pred']."\">
		<input type=\"hidden\" name=\"action\" value=\"".$_GET['action']."\">
		<input type=\"hidden\" name=\"step\" value=\"2\">
		</form>";			
		//include("footer2.php");
		exit;
  			break;
  			case "2":
  					$query = "INSERT INTO `disp_card` (`id`,  `date`,`pat`,`vrach`) VALUES  (NULL,'".date('Y-m-d')."',".$_GET['pat'].",'".$_SESSION["UserID"]."')";
		echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$query = "SELECT LAST_INSERT_ID()";
		echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$dc=$row[0];
		$query = "INSERT INTO `kontr_osm` (`id`, `disp_card`, `date`, `vrach`, `next_date`) VALUES 
				(NULL, '".$dc."', '".date('Y-m-d')."', '".$_SESSION["UserID"]."','".$_GET['year']."-".$_GET['month']."-".date('d')."')";
		echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		//ret($_GET['pred']);
  			break;
  		}
	break;
	case "month":
  	 	$query = "SELECT
					DATE_FORMAT(`kontr_osm`.`next_date`, '%d.%m.%Y' ) as next_date,
					DATE_FORMAT(`kontr_osm`.`next_date`, '%m' ) as month,
					DATE_FORMAT(`kontr_osm`.`next_date`, '%Y' ) as year,
					`sotr`.`surname`, 
	 	 			`sotr`.`name`, 
	 				`sotr`.`otch`, 
	 				`sotr`.`id` as sotrid,
	 				`klinikpat`.`surname`,
	 				`klinikpat`.`name`,
	 				`klinikpat`.`otch`,
	 				`klinikpat`.`id` as patid,
	 				`klinikpat`.`MTel`,
	 				`klinikpat`.`DTel`,
	 				`klinikpat`.`RTel`,
	 				`kontr_osm`.`id` as ko,
	 				`kontr_osm`.`rezobzv`,
	 				`kontr_osm`.`work`
FROM sotr,klinikpat,`disp_card`,`kontr_osm`
WHERE (
(`kontr_osm`.`next_date`>='".$year."-".$month."-1') AND
(`kontr_osm`.`next_date`<='".$year."-".$month."-".date("t",(mktime(0,0,0,$month,1,$year)))."') AND
(`kontr_osm`.`vrach`=`sotr`.`id`) AND
(`disp_card`.`pat`=`klinikpat`.`id`) AND
(`kontr_osm`.`disp_card`=`disp_card`.`id`)
)
ORDER BY `kontr_osm`.`next_date` asc";

  echo "<table  border='1' cellpadding='1' cellspacing='0 ' bordercolor='#999999' bgcolor='#ffffff'>";
echo "<tr>";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					echo "<td width='230'>Пациент</td>";
					echo "<td width='230'>Врач</td>";
					echo "<td width='90'>Дата</td>";
					echo "<td width='90'>Моб.тел</td>";
					echo "<td width='90'>Дом.тел</td>";
					echo "<td width='90'>Раб.тел</td>";
					echo "<td width='200'>Работа</td>";
					echo "<td width='90'>Действие</td>";
					echo "<td width='90'>Назначение последнее</td>";
					echo "<td width='90'>Обзвон</td>";
					echo "</tr>";
$resultA=$result;
$countA=$count;
for ($z=0;$z<$countA;$z++)
{ 
					$row = mysqli_fetch_array($resultA);
					$ko=$row['ko'];
					$rezobzv=$row['rezobzv'];
					  $query = "SELECT
					DATE_FORMAT(`daypr`.`date`, '%d.%m.%Y' ) as datepr,
					DATE_FORMAT(`daypr`.`date`, '%m' ) as month,
					DATE_FORMAT(`daypr`.`date`, '%Y' ) as year,
					`sotr`.`surname`, 
	 	 			`sotr`.`name`, 
	 				`sotr`.`otch`, 
	 				`sotr`.`id`,
	 				`klinikpat`.`surname`,
	 				`klinikpat`.`name`,
	 				`klinikpat`.`otch`,
	 				`klinikpat`.`id`,
	 				`klinikpat`.`MTel`,
	 				`klinikpat`.`DTel`,
	 				`klinikpat`.`RTel`,
	 				`nazn`.`PatID`
                                                                                        FROM nazn, daypr,sotr,klinikpat
                                                                                        WHERE (
                                                                                        (`nazn`.`dayPR`=`daypr`.`id`) AND
                                                                                        (`nazn`.`PatID`=`klinikpat`.`id`) AND
                                                                                        ( `sotr`.`id`=`daypr`.`vrachID`) AND 
                                                                                        (`nazn`.`PatID`=".$row['patid'].")
                                                                                        )
                                                                                        ORDER BY `daypr`.`date` desc
                                                                                        LIMIT 0,1"
                                                                                        ;
					//echo $query."<br>";
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);						
					$rowA = mysqli_fetch_array($result);
					if (($rowA['month']==$month) and ($rowA['year']==$year)) $bg="bgcolor='green'";
					else $bg="bgcolor='red'";
					echo "<tr class='feature2'>";
					echo "<td width='230'>".$row[7]." ".$row[8]." ".$row[9]."</td>";
					echo "<td width='230'>".$row[3]." ".$row[4]." ".$row[5]."</td>";
					echo "<td width='90'>".$row['next_date']."</td>";
					echo "<td width='90'>".$row['MTel']."</td>";
					echo "<td width='90'>".$row['DTel']."</td>";
					echo "<td width='90'>".$row['RTel']."</td>";
					echo "<td width='200'>".$row['work']."</td>";
					echo "<td width='90'><a href='naznach.php?IDN=n&action=naznezh&step=1&pred=disp.php&vrach=".$row['sotrid']."&pat=".$row['patid']."' class='menu2'>Назначить</a></td>";
					echo "<td width='90' ".$bg.">".$rowA['datepr']."</td>";
					echo "<td width='90'><script type=\"text/JavaScript\">
			<!--
			function MM_jumpMenu(targ,selObj,restore){ //v3.0
			  eval(targ+\".location='\disp.php?action=".$_GET['action']."&month=".$month."&year=".$year."&act=obzv\"+selObj.options[selObj.selectedIndex].value+\"'\");
			  if (restore) selObj.selectedIndex=0;
			}
			//-->
				</script>
		        <select name=\"obzv\" onchange=\"MM_jumpMenu('parent',this,0)\">";
				for ($q=0;$q<$rocount;$q++)
				{
					if ($rezobzv==$ro[$q]['id']) echo "<option  value='&ko=".$ko."&RezObzv=".$ro[$q]['id']."' selected='selected'>".$ro[$q]['RezObzv']."</option>";
					else echo "<option  value='&ko=".$ko."&RezObzv=".$ro[$q]['id']."'>".$ro[$q]['RezObzv']."</option>";
				}
echo "</select>";
					echo "</td>";
					echo "</tr>";

 }
echo "</table>";
	break;
	default:
	$query = "SELECT
					DATE_FORMAT(`kontr_osm`.`next_date`, '%d.%m.%Y' ) as next_date,
					DATE_FORMAT(`kontr_osm`.`next_date`, '%m' ) as month,
					DATE_FORMAT(`kontr_osm`.`next_date`, '%Y' ) as year,
					`sotr`.`surname`, 
	 	 			`sotr`.`name`, 
	 				`sotr`.`otch`, 
	 				`sotr`.`id` as sotrid,
	 				`klinikpat`.`surname`,
	 				`klinikpat`.`name`,
	 				`klinikpat`.`otch`,
	 				`klinikpat`.`id` as patid,
	 				`klinikpat`.`MTel`,
	 				`klinikpat`.`DTel`,
	 				`klinikpat`.`RTel`,
	 				`kontr_osm`.`id` as ko,
	 				`kontr_osm`.`rezobzv`
FROM sotr,klinikpat,`disp_card`,`kontr_osm`
WHERE (
(`kontr_osm`.`next_date`>='".$year."-".$month."-1') AND
(`kontr_osm`.`next_date`<='".$year."-".$month."-".date("t",(mktime(0,0,0,$month,1,$year)))."') AND
(`kontr_osm`.`vrach`=`sotr`.`id`) AND
(`disp_card`.`pat`=`klinikpat`.`id`) AND
(`kontr_osm`.`disp_card`=`disp_card`.`id`)
)
ORDER BY `kontr_osm`.`next_date` asc";

  echo "<table  border='1' cellpadding='1' cellspacing='0 ' bordercolor='#999999' bgcolor='#ffffff'>";
echo "<tr>";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
					echo "<td width='230'>Пациент</td>";
					echo "<td width='230'>Врач</td>";
					echo "<td width='90'>Дата</td>";
					echo "<td width='90'>Моб.тел</td>";
					echo "<td width='90'>Дом.тел</td>";
					echo "<td width='90'>Раб.тел</td>";
					echo "<td width='90'>Действие</td>";
					echo "<td width='90'>Назначение последнее</td>";
					echo "<td width='90'>Обзвон</td>";
						
					
					echo "</tr>";
$resultA=$result;
$countA=$count;
for ($z=0;$z<$countA;$z++)
{ 
					$row = mysqli_fetch_array($resultA);
					$ko=$row['ko'];
					  $query = "SELECT
					DATE_FORMAT(`daypr`.`date`, '%d.%m.%Y' ) as date,
					DATE_FORMAT(`daypr`.`date`, '%m' ) as month,
					DATE_FORMAT(`daypr`.`date`, '%Y' ) as year,
					`sotr`.`surname`, 
	 	 			`sotr`.`name`, 
	 				`sotr`.`otch`, 
	 				`sotr`.`id`,
	 				`klinikpat`.`surname`,
	 				`klinikpat`.`name`,
	 				`klinikpat`.`otch`,
	 				`klinikpat`.`id`,
	 				`klinikpat`.`MTel`,
	 				`klinikpat`.`DTel`,
	 				`klinikpat`.`RTel`,
	 				`nazn`.`PatID`
FROM nazn, daypr,sotr,klinikpat
WHERE (
(`nazn`.`dayPR`=`daypr`.`id`) AND
(`nazn`.`PatID`=`klinikpat`.`id`) AND
( `sotr`.`id`=`daypr`.`vrachID`) AND 
(`nazn`.`PatID`=".$row['patid'].")
)
ORDER BY `daypr`.`date` desc
LIMIT 0,1"
;
					//echo $query."<br>";
					$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);						
					$rowA = mysqli_fetch_array($result);
					if (($rowA['month']==$month) and ($rowA['year']==$year)) $bg="bgcolor='green'";
					else $bg="bgcolor='red'";
					echo "<tr class='feature2'>";
					echo "<td width='230'>".$row[7]." ".$row[8]." ".$row[9]."</td>";
					echo "<td width='230'>".$row[3]." ".$row[4]." ".$row[5]."</td>";
					echo "<td width='90'>".$row['next_date']."</td>";
					echo "<td width='90'>".$row['MTel']."</td>";
					echo "<td width='90'>".$row['DTel']."</td>";
					echo "<td width='90'>".$row['RTel']."</td>";
					echo "<td width='90'><a href='naznach.php?IDN=n&action=naznezh&step=1&pred=disp.php&vrach=".$row['sotrid']."&pat=".$row['patid']."' class='menu2'>Назначить</a></td>";	
					echo "<td width='90' ".$bg.">".$rowA[3]." ".$rowA[4]." ".$rowA[5]."<br>".$rowA['date']."</td>";
					echo "<td width='90' ".$bg.">";
					
					echo "<script type=\"text/JavaScript\">
			<!--
			function MM_jumpMenu(targ,selObj,restore){ //v3.0
			  eval(targ+\".location='\disp.php?action=".$_GET['action']."&month=".$_GET['month']."&year=".$_GET['month']."&act=obzv\"+selObj.options[selObj.selectedIndex].value+\"'\");
			  if (restore) selObj.selectedIndex=0;
			}
			//-->
				</script>
		        <select name=\"obzv\" onchange=\"MM_jumpMenu('parent',this,0)\">";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result); 
					if ($row['id']==$rezobzv) echo "<option  value='&ko=".$ko."&RezObzv=".$row['id']."' selected='selected'>".$row['RezObzv ']."</option>";
					else echo "<option  value='&ko=".$ko."&RezObzv=".$row['id']."'>".$row['RezObzv']."</option>";
				}
               
                
						echo "</select>";
					echo "</td>";
					
					echo "</tr>";

 }
echo "</table>";
	break;
}

//include("footer.php");
?>