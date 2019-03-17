<?php
session_start();

include('mysql_fuction.php');
$ThisVU="all";
$ModName="Диспансеризация"; 
include("header.php");
$sotr=$_SESSION['UserID'];
$month_name=array(1=>"Январь",
                                2=>"Февраль",
                                3=>"Март",
    4=>"Апрель",
    5=>"Май",
    6=>"Июнь",
    7=>"Июль",
    8=>"Август",
    9=>"Сентябрь",
    10=>"Октябрь",
    11=>"Ноябрь",
    12=>"Декабрь");
echo "<script type=\"text/javascript\">
   function gochoose() {
                         var link='doc_den_ch_per2.php?per=choose&m='+$('#month').val()+'&y='+$('#year').val();
                         document.location.href=link;
                        }
</script>";
echo "<a href='doc_den_ch_per2.php?per=all' class='menu2'>За всё время</a>||";
echo "<a href='doc_den_ch_per2.php?per=current' class='menu2'>Текущий месяц</a>||";
echo "<a href='doc_den_ch_per2.php?per=3' class='menu2'>3 месяца назад</a>||";
echo "<a href='doc_den_ch_per2.php?per=6' class='menu2'>6 месяцев назад</a>||";
echo "<a href='doc_den_ch_per2.php?per=12' class='menu2'>12 месяцев назад</a>||";
echo "Выбрать месяц ";
echo "<select id='month'>";
foreach ($month_name as $key => $value) {
    echo "<option value='".$key."'>".$value."</option>";
}
 echo  "</select>";
 echo "";
 echo " год <select id='year'>";
 for ($i = 2007; $i <=date("Y"); $i++) {
    echo "<option value='".$i."'>".$i."</option>";
}
 echo "</select>"
 . "<span id='go' onclick=\"gochoose()\" class='menu2' style='cursor:pointer'> Перейти</span><br>";
echo "<span class='head2'>Список пациентов  ";

if (!isset($_GET['per'])) {$_GET['per']="current";}
switch ($_GET['per'])
{
    case "choose":
        $dt=mktime(0,0,0,$_GET["m"],1,$_GET["y"]);
        
        $dtN=date("Y-m-d",$dt);
        $dtO=date("Y-m-t",$dt);
        echo "имеющих последнее посещение у  Вас за ".$month_name." месяц";
   break;
     case "current":
        $dtN=date("Y-m")."-1";
        $dtO=date("Y-m-d");
        echo "имеющих последнее посещение у  Вас за текущий месяц";
   break;
    case "all":
        $dtN="2007-07-04";
        $dtO=date("Y-m-d");
          echo "всё вермя";
   break;
    case"3":  
       $dtN=date("Y-m-1",strtotime("-3 month"));
       $dtO=date("Y-m-t",strtotime("-3 month")); 
       echo "имеющих последнее посещение у  Вас 3 месяца назад";
   break;
 case"6":  
       $dtN=date("Y-m-1",strtotime("-6 month"));
       $dtO=date("Y-m-t",strtotime("-6 month")); 
        echo "имеющих последнее посещение у  Вас 6 месяцев назад";
   break;
 case"12":  
       $dtN=date("Y-m-1",strtotime("-12 month"));
       $dtO=date("Y-m-t",strtotime("-12 month")); 
        echo "имеющих последнее посещение у  Вас 12 месяцев назад";
   break;
}
echo "</span><br>";
$query = "SELECT
    CONCAT_WS(
        \" \",
        `klinikpat`.`surname`,
        `klinikpat`.`name`,
        `klinikpat`.`otch`
    ) AS pat_name,
    CONCAT_WS(
       \" \",
        `sotr`.`surname`,
        `sotr`.`name`,
        `sotr`.`otch`
    ) AS sotr_name,
    `klinikpat`.`id` AS pat_id,
    MAX(`daypr`.`date`) last_nazn_date
FROM
    klinikpat,
    sotr,
    nazn,
    daypr
WHERE
    (
        (`daypr`.`vrachID` = '".$sotr."') AND
        (`daypr`.`date` >= '".$dtN."') AND
        (`daypr`.`date` <=  '".$dtO."') AND
        (`sotr`.`id` = '1') AND
        (`nazn`.`PatID` = `klinikpat`.`id`) AND
        (`daypr`.`id` = `nazn`.`dayPR`)
    )
GROUP BY
    `klinikpat`.`id`
ORDER BY
    last_nazn_date DESC";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
                {
                   for ($i=0;$i<$count;$i++)
                    {
                        $row= mysqli_fetch_array($result);
                        $pat[$row['pat_id']]['pat_name']=$row['pat_name'];
                        $pat[$row['pat_id']]['sotr_name']=$row['sotr_name'];
                        $pat[$row['pat_id']]['last_nazn_date']=$row['last_nazn_date'];
                    }
               
                 // Вывод таблици пациентов
               echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
              <tr><td> <span class='menutext'>№ карты</span></td>
                    <td  align='center' class='menutext'>Пациент</td>
                    <td> <span class='menutext'>Дата последеней записи</span></td>
                    <td> <span class='menutext'>Действия</span></td>
             </tr>";
                foreach ($pat as $key =>$value) {
                        echo "<tr class='alltext'><td>".$key."</td>";
                        echo "<td><a href='pat_card.php?id=".$key."&ro=0' class='menu2' target='_blank'>".$value['pat_name']."</a></td>";
                        echo "<td>".$value['last_nazn_date']."</td>";
                        echo "<td><a href='pat_card.php?id=".$key."&ro=0&action=stat' class='menu2 ' target='_blank'>Посмотреть сведения</a></td></tr>";
	                  }
               echo "</table>";
//                  $countB=$count;
//	$rowB=$row;
//	$resultB=$result;
//	$summ['ter']=0;
//	$c=$count;

//	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
//		  <tr><td> <span class='menutext'>№ карты</span></td>
//			<td  align='center' class='menutext'>Пациент</td>
//			<td> <span class='menutext'>Дата последеней записи</span></td>
//			<td> <span class='menutext'>Действия</span></td>
//			<td class='menutext'>Сумма</td>
//		  </tr>";
//	if ($countB>0)
//	{
//		  for ($i=0;$i<$countB;$i++)
//			{
//				$rowB= mysqli_fetch_array($resultB);
//				$query = "SELECT `date` FROM `dnev` WHERE `id`=".$rowB['id']." order by `date` desc limit 0,1";
////echo $query."<br>";
//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//$row = mysqli_fetch_array($result);
//				if ($rowB[6]>=0)
//				{
//				$dt=explode("-",$rowB[7]);
//				$query = "SELECT `kontr_osm`.`date`,DATE_FORMAT(`kontr_osm`.`next_date`, '%d.%m.%Y' ) as next_date
//				FROM kontr_osm, disp_card
//							WHERE ((`disp_card`.`pat` =".$rowB['pid'].") AND 
//							(`kontr_osm`.`disp_card` =`disp_card`.`id`))
//							ORDER BY `kontr_osm`.`date` desc";
//					//echo $query."<br>";
//					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//					
//					if ($count>0) 
//					{$row = mysqli_fetch_array($result);	
//					$next_date=$row['next_date'];
//					}
//					else
//					{
//						$next_date="нет";
//					}			
//				echo "
//				  <tr class='alltext'>
//					<td>
//<a href='pat_card.php?id=".$rowB['pid']."&ro=0' class='menu2' target='_blank'>".$rowB[0]." ".$rowB[1]." ".$rowB[2]."</a><br>					
//					</td>
//					<td>".$rowB['pid']."</td>
//					";
//				$query = "SELECT `date` FROM `dnev` WHERE `id`=".$rowB['id']." order by `date` desc limit 0,1";
////echo $query."<br>";
//$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//$row = mysqli_fetch_array($result);		
//				echo "
//					<td>".$row['date']."</td>
//					<td>".$next_date."</td>
//					<td>".$rowB[6]."</td>
//				  </tr>";
//				 $summ['ter']+=$rowB[6];
//				 }
//			}
//	
//	}
//	////zaknar
//	$query = "SELECT 
//	`klinikpat`.`surname`, 
//	`klinikpat`.`name`, 
//	`klinikpat`.`otch`, 
//	`sotr`.`surname`, 
//	`sotr`.`name`, 
//	`sotr`.`otch`, 
//	`zaknar`.`summ_k_opl`,
//	`zaknar`.`date`
//	FROM klinikpat, sotr, zaknar
//	WHERE (
//	(`zaknar`.`vrach`='".$_SESSION['UserID']."') AND
//	(`zaknar`.`date` >='".$dtN."') AND 
//	(`zaknar`.`date` <='".$dtO."') AND 
//	(`sotr`.`id` =`zaknar`.`vrach`) AND 
//	(`klinikpat`.`id` =`zaknar`.`pat`)
//	)";
//	//////echo $query."<br />";
//	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//	$summ['zaknar']=0;
//	$c+=$count;
//	if ($count>0)
//	{
//		  for ($i=0;$i<$count;$i++)
//			{
//				$row = mysqli_fetch_array($result);
//				$dt=explode("-",$row[7]);
//				echo "
//				  <tr class='alltext'>
//					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
//					<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
//					<td>".$row[6]."</td>
//				  </tr>";
//				 $summ['zaknar']+=$row[6];
//			}
//	
//	}	
//	////schet_orto
//	$query = "SELECT 
//	`klinikpat`.`surname`, 
//	`klinikpat`.`name`, 
//	`klinikpat`.`otch`, 
//	`sotr`.`surname`, 
//	`sotr`.`name`, 
//	`sotr`.`otch`, 
//	`schet_orto`.`summ_k_opl`,
//	`schet_orto`.`date`
//	FROM klinikpat, sotr, schet_orto
//	WHERE (
//	(`schet_orto`.`vrach`='".$_SESSION['UserID']."') AND
//	(`schet_orto`.`date` >='".$dtN."') AND 
//	(`schet_orto`.`date` <='".$dtO."') AND 
//	(`sotr`.`id` =`schet_orto`.`vrach`) AND 
//	(`klinikpat`.`id` =`schet_orto`.`pat`)
//	)";
//	//////echo $query."<br />";
//	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//	$summ['schet_orto']=0;
//	$c+=$count;
//	if ($count>0)
//	{
//		  for ($i=0;$i<$count;$i++)
//			{
//				$row = mysqli_fetch_array($result);
//				$dt=explode("-",$row[7]);
//				echo "
//				  <tr class='alltext'>
//					<td>".$row[0]." ".$row[1]." ".$row[2]."</td>
//					<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
//					<td>".$row[6]."</td>
//				  </tr>";
//				 $summ['schet_orto']+=$row[6];
//			}
//	
//	}
//	$summ= $summ['schet_orto']+$summ['zaknar']+$summ['ter'];	
//	echo "</table>";
//	echo "<span class='head3'>Выписано чеков: ".$c."</span><br />";
//	echo "<span class='head3'>Сумма: ".$summ."</span>";
                }
 else {
     echo "<span class='head2'>Ничего не найдено</span>";
         
 }
include("footer.php");
?>