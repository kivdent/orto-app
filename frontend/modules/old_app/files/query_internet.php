<?php
    switch ($bd) {
    case "internet":
        $link = mysqli_connect("mysql.stomkuz.mass.hc.ru", "stomkuz_cms1", "auzau1Go", "wwwortopremier_cms");
    break;
    case "orto":
        $link = mysqli_connect("localhost" , "orto", "445223", "orto");
    break;
    case "wp":
        $link = mysqli_connect("localhost" , "orto", "445223", "wordpress");
    break;
}
//

/* проверяем соединение */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$charset="cp1251";
//$charset="utf8";
if ($result = mysqli_query($link, "SET character_set_results = '".$charset."', character_set_client = '".$charset."', character_set_connection = '".$charset."', character_set_database = '".$charset."', character_set_server = '".$charset."'")) 
{
 //echo "cp1251";   
}
if ($result = mysqli_query($link, $query)) 
{
    
} 
else  {echo "Ошибка: ", mysqli_error($link);}
mysqli_close($link);
?>
