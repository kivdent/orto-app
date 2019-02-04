<?php
switch ($_POST['action']){
    case "change_status"://Изменение статуса заявки
        include("function_oap.php");
        $query="UPDATE `application_table` 
                SET `status`=".$_POST['status_app']." 
                WHERE `id`=".$_POST['app_id'];
        $result=sql_query($query,'orto',0);
        if ($_POST['status_app']==3 OR $_POST['status_app']==4 OR $_POST['status_app']==5){
        $query="DELETE FROM `oap_application_table` WHERE `id`=".$_POST['app_id'];
        $result=sql_query($query,'wp',0);
        }
        
        
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
AND (
`application_table`.`id` =".$_POST['app_id']."
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
   
echo "        <td width='90' class='bottom'>".$row['time_app']."</td>
        <td width='150' class='bottom'>".$oap_app_type['$row['type']']."</td>
        <td switchwidth='150' class='bottom'>".$row['name']."</td>
        <td width='90' class='bottom'>".$row['tel']."</td>
        <td width='90' class='bottom'>".$row['email']."</td>
        <td width='90' class='bottom'>".$row['time_nazn']."</td>
        <td width='150' class='bottom'>".$row['surname']." ".$row['name']." ".$row['otch']."</td>
        <td width='90' class='bottom'>";
        jump_menu("#row".$row['id'],"online_app_function.php","action=change_status&app_id=".$row['id'],$option_status,'app_change'.$row['id'],$row['status']);
        echo "</td>
     
       ";
        

        switch ($row['status']){
        case "1":
        echo "<script type=\"text/JavaScript\">
            $(row".$row['id'].").css('backgroundColor', 'red');
            </script>";     
        break;
        case "2":
        echo "<script type=\"text/JavaScript\">
            $(row".$row['id'].").css('backgroundColor', 'green');
            </script>";     
        break;
        default:
          echo "<script type=\"text/JavaScript\">
            $(row".$row['id'].").css('backgroundColor', 'grey');
            </script>";     
        }
    } 
    
    break;
    //Фуекция проверки новых заявок
    case "check_new":
        include("function_oap.php");
        $query="SELECT * FROM `oap_application_table`";
        $result=sql_query($query,'wp',0);
        $count=mysqli_num_rows($result);
                if ($count==0)
        {
            echo "";
        }
        else{
            $field_info = mysqli_fetch_fields($result);
            //Массив с навнием столбцов таблицы
            $table_fields_count=0;
            foreach ($field_info as $val) 
                    {

                        $table_fields['$table_fields_count']=$val->name;
                        $table_fields_count++;
                    }
            //Массив онлайн
            $online_app=array();
            $i=0;
            for($i;$i<$count;$i++) 
            {   
               $row=mysqli_fetch_array($result);
               //print_r($row);
               foreach ($table_fields as $key=>$val)
                   {
                        $online_app[$row['$table_fields['0]']']['$val']=$row['$val'];
                    }
            }
           //массив оффлайн
            $query="SELECT * FROM `application_table`  WHERE `status` in (1,2)";
            $result=sql_query($query,'orto',0);
            $count=mysqli_num_rows($result);
           
            $offline_app=array();
            $i=0;
            for($i;$i<$count;$i++) 
            {   
               $row=mysqli_fetch_array($result);
               foreach ($table_fields as $key=>$val)
                   {
                        $offline_app[$row['$table_fields['0]']']['$val']=$row['$val'];
                    }
            }
           //Поиск новых
            $new_row=(array_diff_key($online_app,$offline_app));
            //Вставка новых
            
            if (count($new_row))
                {
                $query="INSERT INTO `application_table` (";
                foreach ($table_fields as $val)
                {
                     $query=$query."`".$val."`, ";


                }
                $query=substr($query,0,-2).") VALUES ";
                unset ($val);
                foreach ($new_row as $val_row)
                {
                    $query=$query."(";    
                    foreach ($val_row as $val)
                    {
                       $query=$query."'".$val."', "; 
                    }
                    $query=substr($query,0,-2)."), ";
                    unset ($val);
                }
                unset ($val_row);
                $query=substr($query,0,-2);
                $result=sql_query($query,'orto',0);
                echo "red";
                }
            else {
                    echo "";
                }
        }  
    break;
}

