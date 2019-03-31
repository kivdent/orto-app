<?php

include('mysql_fuction.php');
function ShowPolz()
{
 echo "<form  method='post'  action='spr_polz.php'>
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#000000' >
  <tr>
  	 <td width='10%' class='feature3'></td>
    <td width='25%' class='feature3'>Логин</td>
    <td width='40%' class='feature3'>Фамлия Имя Отчество</td>
    <td width='25%'class='feature3'>Уровень доступа </td>
    </tr>";
$query = "SELECT `users`.`login`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `usersprava`.`alias`
FROM users, sotr, usersprava
WHERE ((`sotr`.`id` =`users`.`sotr`) AND (`usersprava`.`id` =`users`.`UsarPrava`))
";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	  echo "<tr>
    <td align=right><input name='login' type='radio' value='".$row['login']."'></td>
	<td class='alltext'>".$row['login']."</td>
    <td class='alltext'>".$row[1]." ".$row[2]." ".$row[3]."</td>
    <td class='alltext'>".$row[4]."</td>
  </tr>";
}
echo "</table>
<input name='add' type='submit' value='Добавить'>
<input name='change' type='submit' value='Изменить'>
<input name='del' type='submit' value='Удалить'>
</form>";
}
function ShowAdd($sm,$id)
{ 
$query = "SELECT 
  users.pass,
  users.UsarPrava,
  users.sotr,
  users.login
FROM
  users
WHERE
  (users.login = '".$id."')";
echo "";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$rowA=mysqli_fetch_array($result);
echo "<form name='form1' id='form1' method='post' action='spr_polz.php' onSubmit='return(PrPass(document.form1.pass.value,document.form1.pass2.value))'>
  <table width='50%' border='0' cellspacing='0' cellpadding='1'>
    <tr>
      <td width='40%'>Логин</td>
      <td width='60%'> <input name='login' type='hidden' value='".$rowA['login']."' /><input name='NewLogin' type='text' id='NewLogin' value='".$rowA['login']."'></td>
    </tr>
    <tr>
      <td>Пароль</td>
      <td><input name='pass' type='password' id='pass' value='".$rowA['pass']."'></td>
    </tr>
    <tr>
      <td>Повторить пароль </td>
      <td><input name='pass2' type='password' id='pass2' value='".$rowA['pass']."'></td>
    </tr>
    <tr>
      <td>Сотрудник</td>
      <td><select name='sotr' id='sotr'>";
$query = "SELECT id,surname,name,otch FROM sotr ORDER BY surname ASC";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (($row['id']==$rowA['sotr']) || ($i==0)) echo "<option value='".$row['id']."' selected='selected'>".$row[1]." ".$row[2]." ".$row[3]."</option>";
	else echo "<option value='".$row['id']."'>".$row[1]." ".$row[2]." ".$row[3]."</option>";
}
echo "      </select>
      </td>
    </tr>
    <tr>
      <td>Права</td>
      <td><select name='UsarPrava' id='UsarPrava'>";
$query = "SELECT 
  usersprava.id,
  usersprava.Nazv,
  usersprava.alias
FROM
  usersprava
ORDER BY
  usersprava.alias";
echo "";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (($row['id']==$rowA['UsarPrava']) || ($i==0)) echo "<option value='".$row['id']."' selected='selected'>".$row['alias']."</option>";
	else echo "<option value='".$row['id']."'>".$row['alias']."</option>";
		}
 echo "      </select>
      </td>
    </tr>
  </table>
  <input name='".$sm."' type='submit' id='".$sm."' value='Сохранить'>
</form>";
}
$ThisVU="administrator";
$this->title="&laquo;Пользователи&raquo;";
$js="pass"; 
//include("header.php");
// Добавление пациента
if (isset($_POST['add']) or isset($_POST['add2']))
{
	if (!(isset($_POST['add2'])))
	{
		$sm="add2";
		ShowAdd($sm,"0");
		//include("footer.php");
		exit;		
	}
	else
	{
				
		$query="INSERT INTO users 
				  (users.login,
				  users.pass,
				  users.sotr,
				  users.UsarPrava)
				  VALUES
				  ('".$_POST['NewLogin']."',
				  '".$_POST['pass']."',
				  '".$_POST['sotr']."',
				  '".$_POST['UsarPrava']."'
				  )"; 
				  echo "";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	}
}
//удаление
if (isset($_POST['del'])) 
{
	if (!isset($_POST['login'])) 
	{
		echo "<div class='head1'>Выбирите запись!</div>";
	}
	else
	{
		$query="delete from users where login='".$_POST['login']."'";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	}
}
//Изменение
if ((isset($_POST['change'])) || (isset($_POST['change2'])))
{
	if (!isset($_POST['change2']))
	{	
	if (!isset($_POST['login'])) 
		{
			echo "<div class='head1'>Выбирите запись!</div>";
		}
		else
		{
			$sm="change2";
			ShowAdd($sm,$_POST['login']);
			//include("footer.php");
			exit;	
		}	
	}
	else
	{
		$query = "UPDATE users
				SET
				  login='".$_POST['NewLogin']."',
				  pass='".$_POST['pass']."',
				  sotr='".$_POST['sotr']."',
				  UsarPrava='".$_POST['UsarPrava']."'
				WHERE
				  login='".$_POST['login']."'";
		echo "";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$count=$count;
		$result=$result;
		$row = mysqli_fetch_array($result);
	}
}

if (!(isset($_POST['add']))) 
ShowPolz();
//include("footer.php");
?>
