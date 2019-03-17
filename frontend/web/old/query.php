<?php 
//       $result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$db = mysql_pconnect("127.0.0.1" , "orto", "445223");
mysql_query("/*!40101 SET NAMES 'cp1251' */") or die("Error: " . mysql_error());
$mysql = mysql_select_db("orto");
if (!$mysql)
{
echo "Невозможно соеденится с базой данных";
exit;
}
// Запрос к базе данных, чтобы проверить,
// существует ли соответствующая запись
$result = mysql_query($query) or die("Invalid query: " . mysql_error());
if (!$result)
{
	echo "Запрос невозможен";
	exit;
}
$count= mysql_num_rows($result);
//mysql_close();
?>
