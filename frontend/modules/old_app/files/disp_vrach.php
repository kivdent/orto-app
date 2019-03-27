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
                         var link='disp_vrach.php?per=choose&m='+$('#month').val()+'&y='+$('#year').val();
                         document.location.href=link;
                        }
</script>";
echo "<a href='disp_vrach.php?per=all' class='menu2'>За всё время</a>||";
echo "<a href='disp_vrach.php?per=current' class='menu2'>Текущий месяц</a>||";
echo "<a href='disp_vrach.php?per=3' class='menu2'>3 месяца назад</a>||";
echo "<a href='disp_vrach.php?per=6' class='menu2'>6 месяцев назад</a>||";
echo "<a href='disp_vrach.php?per=12' class='menu2'>12 месяцев назад</a>||";
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
        echo "диспасерные карты за ".$month_name." месяц";
   break;
     case "current":
        $dtN=date("Y-m")."-1";
        $dtO=date("Y-m-d");
        echo "Диспансерные карты текущего месяца";
   break;
    case "all":
        $dtN="2007-07-04";
        $dtO=date("Y-m-d");
          echo "Все диспансерные карты";
   break;
    case"3":  
       $dtN=date("Y-m-1",strtotime("-3 month"));
       $dtO=date("Y-m-t",strtotime("-3 month")); 
       echo "Диспасерные карты 3 месяца назад";
   break;
 case"6":  
       $dtN=date("Y-m-1",strtotime("-6 month"));
       $dtO=date("Y-m-t",strtotime("-6 month")); 
        echo "диспансерные карты 6 месяцев назад";
   break;
 case"12":  
       $dtN=date("Y-m-1",strtotime("-12 month"));
       $dtO=date("Y-m-t",strtotime("-12 month")); 
        echo "диспансерные карты 12 месяцев назад";
   break;
}
echo "</span><br>";
$query = "SELECT
     `klinikpat`.`id` as pat_id,
    CONCAT_WS(
       \" \",
        `klinikpat`.`surname`,
        `klinikpat`.`name`,
        `klinikpat`.`otch`
    ) AS pat_name,
    `kontr_osm`.`next_date`,
    `kontr_osm`.`work`,
    `rezobzv`.`RezObzv`,
    MAX(last_nazn.last_date) as last_date,
    ANY_VALUE(last_nazn.sotr_name) as sotr_name
FROM
    `kontr_osm`,
    `klinikpat`,
    `rezobzv`,
    `disp_card`
JOIN(
    SELECT
        MAX(`daypr`.`date`) AS last_date,
        CONCAT_WS(
            \" \",
            `sotr`.`surname`,
            `sotr`.`name`,
            `sotr`.`otch`
        ) AS sotr_name,
        `nazn`.`PatID`
    FROM
        `daypr`,
        `sotr`,
        `nazn`
    WHERE
        (`sotr`.`id` = `daypr`.`vrachID`) AND (`nazn`.`dayPR`=`daypr`.`id`)
    GROUP BY `daypr`.`vrachID`,`nazn`.`PatID`
) AS last_nazn
ON
    last_nazn.`PatID` = `disp_card`.`pat`
WHERE
    (
        `kontr_osm`.`next_date` >=  '".$dtN."'
    ) AND(
        `kontr_osm`.`next_date` <='".$dtO."'
    ) AND(`rezobzv`.`id` = `kontr_osm`.`rezobzv`) AND(`klinikpat`.`id` = `disp_card`.`pat`) AND(`disp_card`.`vrach` = ".$sotr.") AND(
        `kontr_osm`.`disp_card` = `disp_card`.`id`
    )
    GROUP BY `kontr_osm`.`id`";
	//////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count>0)
                {
                   for ($i=0;$i<$count;$i++)
                    {
                        $row= mysqli_fetch_array($result);
                        $pat[$row['pat_id']]['pat_name']=$row['pat_name'];
                        $pat[$row['pat_id']]['sotr_name']=$row['sotr_name'];
                        $pat[$row['pat_id']]['last_date']=$row['last_date'];
                        $pat[$row['pat_id']]['RezObzv']=$row['RezObzv'];
                        $pat[$row['pat_id']]['next_date']=$row['next_date'];
                        $pat[$row['pat_id']]['work']=$row['work'];
                    }
               
                 // Вывод таблици пациентов
               echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
              <tr><td> <span class='menutext'>№ карты</span></td>
                    <td  align='center' class='menutext'>Пациент</td>
                    <td> <span class='menutext'>Контрольный осмотр</span></td>
                    <td> <span class='menutext'>Работа</span></td>
                    <td> <span class='menutext'>Дата последеней записи</span></td>
                   
             </tr>";
                foreach ($pat as $key =>$value) {
                        echo "<tr class='alltext'><td>".$key."</td>";
                        echo "<td><a href='pat_card.php?id=".$key."&ro=0&action=disp' class='menu2' target='_blank'>".$value['pat_name']."</a></td>";
                        echo "<td>".$value['next_date']."</td>";
                         echo "<td>".$value['work']."</td>";
                        echo "<td>".$value['last_date']." (".$value['sotr_name'].")</td></tr>";
	                  }
               echo "</table>";
                }
 else {
     echo "<span class='head2'>Ничего не найдено</span>";
         
 }
include("footer.php");
?>