<?php
include('mysql_fuction.php');
switch ($_POST['action'])
{
     case "get_pat_data":
        $query = "select `id`,`surname`,`name`,`otch`, DATE_FORMAT(`dr`, '%d.%m.%Y') as dr,`DTel`, `RTel`, `MTel` from `klinikpat` where `id`='".$_POST['pat']."'";
        $result=sql_query($query,'orto',0);
        $count=mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        $string="</br>Номерт карты: ".$row['id']."</br>
	Имя: ".$row['name']."</br>
               	Отчество: ".$row['otch']."</br>"
                  . "Фамилия: ".$row['surname']."</br>"
                . "Дата рождения: ".$row['dr']."</br>"
                . "Мобильный телефон: ".$row['MTel']."</br>"
                 . "Домашний телефон: ".$row['DTel']."</br>"
                 . "Рабочий телефон: ".$row['RTel']."</br>"
                . "<a href=\"pat_card.php?id=".$row['id']."&ro=0\" target=\"_blank\");\">Открыть карту пациента</a></br>";
      echo   $string;
    break; 
    case "find":
        $term = strip_tags(substr($_POST['search_term'],0, 100));
               $query = "select id,surname,name,otch,dr,DTel, RTel, MTel from klinikpat 
                where  surname like '".$term."%'
                order by surname";
        $result=sql_query($query,'orto',0);
        $count=mysqli_num_rows($result);
        $string="";
        if ($count>0)
            {
            
            $string.= "<select name='pat' id='pat' size='15' >";	
            for ($i=0; $i<$count; $i++)
            {
                    $row = mysqli_fetch_array($result);
                    $string.= "<option value=".$row['id'].">".$row['surname']." ".$row['name']." ".$row['otch']."</option>";

            }
            $string.= "</select>";
        }
        else
            {
                $string = "Ничего не найдено";
            } 
        echo $string;
        echo "<script type='text/javascript'> 
        $(\"#pat\").click(function(e){ 
                                              e.preventDefault(); 
                                              var search_val=$(\"#pat option:selected\").val(); 
                                                $.post(\"./pat_find_funct.php\", {action : \"get_pat_data\",pat : search_val}, function(data){
                                                            if (data.length>0){ 
                                                           $(\"#patinfo\").html(data); 
                                                            } 
                                                         })
                                                         })

</script>";
         break;
}