<?php
session_start();
include('mysql_fuction.php');
$query ="SELECT CONCAT_ws(' ',`sotr`.`surname`,`sotr`.`name`,`sotr`.`otch`) as name, `sotr`.`id`, `usersprava`.`Nazv`,`users`.`UsarPrava` 
FROM
`users`,`sotr`,`usersprava`
WHERE (`login`='".$_POST['login']."')
and (`pass`='".$_POST['pass']."')
and (`users`.`sotr`=`sotr`.`id`)
and (`users`.`UsarPrava`=`usersprava`.`id`)";
$result=sql_query($query,'orto',0);
$count=mysqli_num_rows($result);
if ($count>0)
//// Комбинация имени и пароля посетителя правильная
{
$row= mysqli_fetch_array($result);
$_SESSION['UserName']=$row['name'];
$_SESSION['UserID']=$row['id'];
$_SESSION['valid_user']=$row['Nazv'];
$_SESSION['user_prava']=$row['UsarPrava'];
}
$ThisVU="all";
$ModName="Вход в систему";
//ECHO $_SESSION['valid_user']." ".$ThisVU." ".$_SESSION['UserName'];
include("header.php");
include("footer.php");
?>