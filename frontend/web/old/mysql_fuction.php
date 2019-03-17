    <?php 
    function sql_query($query,$bd='orto',$echo_query='false')
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
        //$charset="cp1251";
        $charset="utf8";
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
    $last_id=mysqli_insert_id($link);//возвращает номер последненго вставленного элемента
    if ($last_id==0) {return($result);} else return($last_id);
} 
else  {echo "Ошибка: ", mysqli_error($link);}
mysqli_close($link);
}
?>