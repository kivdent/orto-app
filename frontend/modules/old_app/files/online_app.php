<?php
$ThisVU="all";
$this->title="Онлайн заявки";
//include("header.php");
include("function_oap.php");
echo "
<script type=\"text/JavaScript\" src=\"js/jq.js\">
</script>";
//$oap_app_status=array(1=>'Принята',2=>'Попытка дозвониться', 3=>'Не дозвонились', 4=>'Отказ от записи',5=>'Успешно');//Статуса application_table
echo "<input id=\"online_app\"type=\"hidden\" value=\"true\"/>
    <table border='1' cellpadding='1' cellspacing='0 ' bordercolor='#999999' width='100%' id='app_table'>
        <tbody>
        <tr>
        <td width='90'>Время заявки</td>
        <td width='150'>Тип заявки</td>
        <td width='150'>Имя</td>
        <td width='90'>Телефон</td>
        <td width='90'>Почта</td>
        <td width='90'>Желаемая дата и время приема</td>
        <td width='150'>Врач</td>
        <td width='90'>Статус</td>
       </tr>
       ";
$query="SELECT  `application_table`.`id`, `application_table`.`type`, DATE_FORMAT(`application_table`.`time_app`,'%d.%c.%Y %H:%i') as time_app, 
    `application_table`.`tel`, `application_table`.`pat_name`, `application_table`.`email`, DATE_FORMAT(`application_table`.`time_nazn`,'%d.%c.%Y %H:%i') as time_nazn, `application_table`.`sotr`, 
    `application_table`.`daypr`, `application_table`.`NachNaz`, `application_table`.`OkonchNaz`, `application_table`.`status`,  
    `sotr`.`surname` ,  `sotr`.`name` ,  `sotr`.`otch` 
FROM  `application_table` ,  `sotr` 
WHERE (
(
`application_table`.`sotr` =  `sotr`.`id`
)
AND (
`application_table`.`status` IN ( 1, 2 )
)
)";
$result1=sql_query($query,'orto',0);
$count1=mysqli_num_rows($result1);
$i=0;
for($i;$i<$count1;$i++) 
{   
   $row=mysqli_fetch_array($result1);
//`id`, `type`, `time_app`, `tel`, `email`, `time_nazn`, `daypr`, `NachNaz`, `OkonchNaz`, `status`
// date($row['time_app'],"m.d.y H:i")
   if ($row['status']==1) {
       $bgcolor="style=\"background-color:red\"";
   }
   if ($row['status']==2) {
       $bgcolor="style=\"background-color:green\"";
   }
echo "<tr id=\"row".$row['id']."\" ".$bgcolor.">
        <td width='90' class='bottom'>".$row['time_app']."</td>
        <td width='150' class='bottom'>".$oap_app_type['$row['type']']."</td>
        <td width='150' class='bottom'>".$row['name']."</td>
        <td width='90' class='bottom'>".$row['tel']."</td>
        <td width='90' class='bottom'>".$row['email']."</td>
        <td width='90' class='bottom'>".$row['time_nazn']."</td>
        <td width='150' class='bottom'>".$row['surname']." ".$row['name']." ".$row['otch']."</td>
        <td width='90' class='bottom'>";
        jump_menu("#row".$row['id'],"online_app_function.php","action=change_status&app_id=".$row['id'],$option_status,'app_change'.$row['id'],$row['status']);
        echo "</td>
       </tr>";
}
echo "</tbody></table>";
//include("footer.php");
exit;
?>