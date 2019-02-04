<?php
session_start();
include('mysql_fuction.php');
$ThisVU="administrator";
$ModName="Договора";
$js="find"; 
include("header.php");
switch ($_GET['action'])
{
	case "add":
		if (!(isset($_GET['pat'])))
		{
			msg('Выбирите пациента');
			ret('spr_dogovora.php');
		}
		$query = "SELECT * FROM `dogovor` WHERE ((`firm`='".$_GET['firm']."') and (`pat`='".$_GET['pat']."'))" ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>0)
		{
			msg('Такой пациент уже прикреплён');
			ret('spr_dogovora.php');
		}
		$query = "INSERT INTO `dogovor` (`id`, `firm`, `pat`) VALUES (NULL,'".$_GET['firm']."','".$_GET['pat']."')" ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('spr_dogovora.php');
	break;
	case "del":
		if (!(isset($_GET['pr_pat'])))
		{
			msg('Выбирите пациента');
			ret('spr_dogovora.php');
		}
		$query = "DELETE FROM `dogovor` WHERE `id`='".$_GET['pr_pat']."'" ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('spr_dogovora.php');
	break;
}
echo "<form id='dogf' name='dogf' method='get' action=''>
<input name='action' type='hidden' value='del'>
		 <center>Фирма:<br />";

$query = "SELECT `nazv`,`id` FROM `firms` WHERE `sv`!=1";
//////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);		 
echo "<select name='firm'>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (!isset($_GET['firm'])) $fid=$row['id'];
	if ($row['id']==$_GET['firm']) 
	{
		echo "<option value='".$row['id']."' selected='selected'>".$row['nazv']."</option>";
		$fid=$row['id'];
	}	
	else echo "<option value='".$row['id']."'>".$row['nazv']."</option>";	
}
echo "</select></center>
		          <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td valign='top'><center>Прикреплённые пациенты:<br />";
	
	    $query = "SELECT `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `dogovor`.`id`
FROM klinikpat, dogovor
WHERE ((`dogovor`.`firm` ='".$fid."') AND (`klinikpat`.`id` =`dogovor`.`pat` ))" ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>25) echo "<select name='pr_pat' size='25'>";
			else  echo "<select name='pr_pat' size='".$count."'>";
		for ($i=0; $i <$count; $i++)
			{
				$row = mysqli_fetch_array($result);
				echo    "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
			}	
      echo "</select>
      <br />
      <label>
      <input type='submit' name='Submit' value='Удалить' /></form>
      </label>
    </center></td>
    <td valign='top'><form action='spr_dogovora.php' method='get' name='fform' id='fform'><center>
          Список пациентов клиники:<br />
		 <input name='FS' id='FS' type='text' onkeyup='FindPat()' value='".$_GET['FS']."'>
		 <input name='FS1' id='FS1' type='hidden' value=''><br>";
    if (isset($_GET['FS'])) $query = "select id,surname,name,otch,dr from klinikpat
	WHERE  surname LIKE '".$_GET['FS']."%' 
	order by surname asc";
	else $query = "select id,surname,name,otch,dr from klinikpat order by surname asc";
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			if ($count>25) echo "<select name='pat' size='25'>";
			else  echo "<select name='pat' size='".$count."'>";
			for ($i=0; $i <$count; $i++)
			{
				$row = mysqli_fetch_array($result);
				echo    "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
			}
	echo "</select>
      <br />
      <input type='submit' name='Submit2' value='Добавить' />
    </center><input name='firm' type='hidden' value='".$fid."'>
	<input name='action' type='hidden' value='add'>
	</form></td>
  </tr>
</table>";
include("footer.php");
?>