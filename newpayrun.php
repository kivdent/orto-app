<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Внесение оплаты пациента <?php echo $_POST['sirname']; ?></title>
</head>
<body>
<?php echo "Внесение оплаты пациента ".$_POST['sirname']; 
$sirname=addslashes($_POST['sirname']);
$payd=$_POST['payd'];
$dolg=$_POST['kopl']-$_POST['payd'];
$date=date("Y-m-d");
$time=date("H-i-s");
$nul="null";
@ $db = mysql_pconnect("localhost", "root", "");
if (!$db)
{
echo "Error: Could not connect to database. Please try again later.";
exit;
}
echo "ok";
mysql_select_db("test");
$query = "insert into patpay values
('".$nul."','".$sirname."','".$payd."','".$dolg."','".$date."','".$time."')";
////echo $query;
$result = mysql_query ($query);
if ($result)
echo mysql_affected_rows() . " данных внесено.";
?>
</body>
</html>
