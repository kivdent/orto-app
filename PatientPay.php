<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Все оплаты</title>
</head>
<body>
<?php 
echo "Сегодня:".date("H:i,jS F")."<br>";
@ $db = mysql_pconnect("localhost", "root", "");
if (!$db)
{
echo "Error: Could not connect to database. Please try again later.";
exit;
}
else echo "ok!!!!!!!!!!!<br>";
mysql_select_db("test");
$query = "select payID, sirName, payd, dolg from patpay";
$result = mysql_query($query);
$num_results = mysql_num_rows($result);
for ($i=0; $i <$num_results; $i++)
{
$row = mysqli_fetch_array($result);
echo ($i+l)." . Фамилия " ;
echo htmlspecialchars( stripslashes($row['sirName']));
echo " Внесено: ";
echo htmlspecialchars (stripslashes($row['payd']));
echo " Долг: ";
echo htmlspecialchars (stripslashes($row["dolg" ] )) ;
echo " payID: ";
echo htmlspecialchars (stripslashes($row["payID" ] )) ;
echo "<br>";
}
?>
</body>
</html>
