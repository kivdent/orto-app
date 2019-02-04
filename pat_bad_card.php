<?php
$ThisVU="registrator";
$ModName="Незаполненные карты";
include("header.php");
switch ($_GET['action'])
{
	case "del":
		$query="delete from klinikpat where id='".$_POST['element']."'";
        $result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	break;
}
$query = "SELECT `klinikpat`.`id` , `klinikpat`.`surname` , `daypr`.`date` ,  `sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` 
FROM klinikpat, nazn, daypr, sotr
WHERE (
(
`nazn`.`PatID` = `klinikpat`.`id` 
)
AND (
`klinikpat`.`otch` = ''
)
AND (
`klinikpat`.`name` = ''
)
AND (
`daypr`.`id` = `nazn`.`dayPR` 
)
AND (
`sotr`.`id` = `daypr`.`vrachID` 
)
)
ORDER BY `klinikpat`.`surname` 
" ;
////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "      <table width='100%' border='0' cellspacing='0' cellpadding='2' bgcolor='#FFFFFF'>
        <tr>
          <td>
            <table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000'>
              <tr>
                <td width='35%'><div align='center' ><font color='#42929D'>Пациент</font></div></td>
        <td width='25%'><div align='center'> <font color='#42929D'>Дата приёма</font></div></td>
        <td width='40%'><div align='center' > <font color='#42929D'>Врач</font></div></td>
      </tr>";
              
             
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode("-",$row['date']);
	echo "<tr class='feature'>
                <td><a href='pat_card.php?ro=0&id=".$row[0]."' class='menu2' target='_blank'>".$row[1]." (№ карты: ".$row[0].")</a></td>
        		<td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
       			 <td>".$row['surname']." ".$row['name']." ".$row['otch']."</td>
          </tr>";
}
echo "</table>";
include("footer.php");
?>
