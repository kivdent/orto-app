<?php
//Модуль функций для синхронизации с инетрнет ресурсом
$oap_app_status=array(1=>'Принята',2=>'Попытка дозвониться', 3=>'Не дозвонились', 4=>'Отказ от записи',5=>'Успешно');//Статуса application_table
$oap_app_type=array(1=>'Заявка на обратный звонок с сайта', 2=>'Заявка на обратный звонок из облачной атс',3=>'Заявка из расписание с сайта');//Тип заявок application_table
$option_status=array(//список вариантов для изменения статуса заявки
        array('label'=>'Принята','value_option'=>'1','str'=>'&status_app=1'),
        array('label'=>'Попытка дозвониться','value_option'=>'2','str'=>'&status_app=2'),
        array('label'=>'Не дозвонились','value_option'=>'3','str'=>'&status_app=3'),
        array('label'=>'Отказ от записи','value_option'=>'4','str'=>'&status_app=4'),
        array('label'=>'Успешно','value_option'=>'5','str'=>'&status_app=5'));
//Таблицы для синхронизации
$tables_to_sync=array(
    'nazn'=>array('master'=>'nazn','slave'=>'oap_nazn','add_condition'=>""),
    'daypr'=>array('master'=>'daypr','slave'=>'oap_daypr','add_condition'=>"WHERE `date` >='".date('Y-m-d ')."'"),
    'raspis_day'=>array('master'=>'raspis_day','slave'=>'oap_raspis_day','add_condition'=>""),       
    'raspis_pack'=>array('master'=>'raspis_pack','slave'=>'oap_raspis_pack','add_condition'=>""),      
    'sotr'=>array('master'=>'sotr','slave'=>'oap_sotr','add_condition'=>""),
    'application_table'=>array('master'=>'application_table','slave'=>'oap_application_table','add_condition'=>"")
    );

///Фунция запроса к базе данных
function sql_query_oap($query,$bd='orto',$echo_query='false')
{
    //выбираем базу
    switch ($bd) {
    case "internet"://соединение с базой orto-premier.ru
        $link = mysqli_connect("mysql.stomkuz.mass.hc.ru", "stomkuz_cms1", "auzau1Go", "wwwortopremier_cms");
        $charset="cp1251";
        //$charset="utf8";
    break;
    case "orto"://соединение с основной базой программы
        $link = mysqli_connect("localhost" , "orto", "445223", "orto");
        $charset="cp1251";
        //$charset="utf8";
    break;
    case "wp"://соединение с локальной копией orto-premier.ru
        $link = mysqli_connect("localhost" , "orto", "445223", "wordpress");
        $charset="cp1251";
        //$charset="utf8";
    break;
}
//
if ($echo_query)
    {
        echo "<br>База данных: ".$bd."</br>
                  Кодировка: ".$charset."</br>
                  Запрос: ".$query."</br>";
    }
/* проверяем соединение */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
if ($result = mysqli_query($link, "SET character_set_results = '".$charset."', character_set_client = '".$charset."', character_set_connection = '".$charset."', character_set_database = '".$charset."', character_set_server = '".$charset."'")) 
{
 //echo "cp1251";   
}
if ($result = mysqli_query($link, $query)) 
{
    return($result);
} 
else  {echo "Ошибка: ", mysqli_error($link);}
mysqli_close($link);
}

//Функция синхронизации талиц
function table_sync($table_master,$table_slave,$master_bd,$slave_bd,$add_condition='')
{
//синхронизация таблиц daypr nazn raspis_day raspis_pack sotr
//базы данных orto, wp, internet
//Формирование записей архива мастер
if ($table_master=='nazn') 
{
    $add_condition="WHERE dayPR in (SELECT `id` FROM `daypr` WHERE `date` >='".date('Y-m-d ')."')";
}

    
$query="SELECT * FROM `".$table_master."` ".$add_condition; 
$result=sql_query_oap($query,$master_bd,'true');
$count=mysqli_num_rows($result); 
$field_info = mysqli_fetch_fields($result);

//Массив с навнием столбцов таблицы
$table_fields_count=0;
foreach ($field_info as $val) 
        {
            
            $table_fields[$table_fields_count]=$val->name;
            $table_fields_count++;
        }

//Массив талицы мастер 
$master_row=array();
$i=0;
for($i;$i<$count;$i++) 
{   
   $row=mysqli_fetch_array($result);
   foreach ($table_fields as $key=>$val)
       {
            $master_row[$row[$table_fields[0]]][$val]=$row[$val];
        }
}
//Формирование записей архива слайв
if (($table_master=='nazn') or  ($table_master=='daypr'))
{
    $add_condition="";
}
$query="SELECT * FROM `".$table_slave."` ".$add_condition; 
$result=sql_query_oap($query,$slave_bd,'true');
$count=mysqli_num_rows($result); 
//Массив таблицы слайв 
$slave_row=array();
$i=0;
for($i;$i<$count;$i++) 
{   
   $row=mysqli_fetch_array($result);
   foreach ($table_fields as $key=>$val)
       {
            $slave_row[$row[$table_fields[0]]][$val]=$row[$val];
        }
}
unset ($val);
unset ($key);
//Сравнение массивов
//1. Поиск  добавленных
$new_row=(array_diff_key($master_row, $slave_row));
//2. Поиск измененых
foreach ($master_row as $key=>$val_master)
       {
           if (array_key_exists($key,$slave_row))
           {
               if (count(array_diff($val_master,$slave_row[$key]))>0)
               {
                   $change_row[$key]=$val_master;
               }
           }
       }
unset($key);
unset($val_master);
//3. Поиск удаленых
$del_row=(array_diff_key($slave_row, $master_row));

//Просмотр массивово с измененными данными
//echo "</br>Новые</br>";
//print_r($new_row);
//echo "</br>Измененые</br>";
//print_r($change_row);
//echo "</br>Удаленые</br>";
//print_r($del_row);

$result_funct[new_row]=0;
$result_funct[change_row]=0;
$result_funct[del_row]=0;
//Вставляем новые строки
unset ($val);

if (count($new_row))
{
$result_funct[new_row]='1';
$query="INSERT INTO `".$table_slave."` (";
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
$result=sql_query_oap($query,$slave_bd,1);

}


//Обновляем измененые строки
if (count($change_row))
{
$result_funct[change_row]=1;
$query="REPLACE INTO `".$table_slave."` ("; 
    
foreach ($table_fields as $val)
{
     $query=$query."`".$val."`, ";
}
$query=substr($query,0,-2).") VALUES ";
unset ($val);
foreach ($change_row as $val_row)
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
$result=sql_query_oap($query,$slave_bd,1);
}

//Удалям лишние строки
if (count($del_row))
{
$result_funct[del_row]=1;   
$query="DELETE FROM `".$table_slave."` WHERE "; 
foreach ($del_row as $val_row)
{
    $query=$query."`".$table_fields[0]."`='".$val_row[$table_fields[0]]."' OR ";    
}
unset ($val_row);
$query=substr($query,0,-4);
$result=sql_query_oap($query,$slave_bd,1);
}
return($result_funct);
}
//Функция выпадающего списка с изменением 
function jump_menu($id_change,$action_page,$action_str,$select_options,$menu_id,$selected_option="0"){
    //формат $select_option=array(array('label'=>'label','value_option'=>'value','str'='значение переменной, например $status_app='),...))
    //фоормат $action_str стриница с дествием, название действия: \pat_tooday_reg.php\
    //http://dnzl.ru/view_post.php?id=272
    $function_name="JumpMenu_".$menu_id;
 
//echo "<script type=\"text/JavaScript\">
//			<!--
//			function ".$function_name."(targ,selObj,restore){ //v3.0
//			  eval(targ+\".location='".$action_str."\"+selObj.options[selObj.selectedIndex].value+\"'\");
//			  if (restore) selObj.selectedIndex=0;
//			}
//			//-->
//</script>";
    //echo"<select name=\"".$function_name."\" onchange=\"".$function_name."('parent',this,0)\">";
    //print_r($select_options);
    echo "<script type=\"text/JavaScript\">
            $(document).ready(function(){
                $(".$function_name.").on(\"change\",function(){
                    var myData = \"".$action_str."\"+$(\"#".$function_name."\").val(); //post variables
                    jQuery.ajax({
                        type: \"POST\", // HTTP метод  POST или GET
                        url:\"".$action_page."\", //url-адрес, по которому будет отправлен запрос
                        dataType:\"text\", // Тип данных,  которые пришлет сервер в ответ на запрос ,например, HTML, json
                        data:myData, //данные, которые будут отправлены на сервер (post переменные)
                        success:function(response){
                        $(\"".$id_change."\").html(response);
                        },
                        error:function (xhr, ajaxOptions, thrownError){
                        alert(thrownError); //выводим ошибку
                        }
                    });
                });
            });
         </script>";
    echo"<select name=\"".$function_name."\" id=\"".$function_name."\">";
    unset($val);
				foreach ($select_options as $val)
				{
					
					if ($val[value_option]==$selected_option) {
                                            echo "<option  value='".$str."' selected='selected'>".$val[label]."</option>";
                                        }
                                         else {
                                             echo "<option  value='".$val[str]."'>".$val[label]."</option>";
                                         }
				}
    echo "</select>";
}
//Синхронизация таблиц

?>