<?php
$ThisVU="stms";
$this->title="Место тхранения"; 
$js="spisok";
//include("header.php");
switch ($_GET['action'])
{
	case "add":
		$query = "INSERT INTO `mesta_hr`  (`id`, `nazv`, `mol`)VALUES (NULL, '".$_GET['nazv']."', '".$_GET['mol']."')";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('mater_mesta_hr.php');
	break;
	case "del":
		$query = "DELETE FROM `mesta_hr` WHERE `id`=".$_GET['mesto_hr'];
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('mater_mesta_hr.php');
	break;
	case "ch":
		if (isset($_GET['change']))
		{
			$query = "UPDATE `mesta_hr` 
			SET
			`nazv`='".$_GET['nazv']."', 
			`mol`='".$_GET['mol']."'
			WHERE `id`=".$_GET['mesto_hr'];
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('mater_mesta_hr.php');
		}
		$query = "SELECT `id`, `nazv`, `mol` FROM `mesta_hr` WHERE `id`=".$_GET['mesto_hr'];
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$rowA= mysqli_fetch_array($result);
		echo "<form action='mater_mesta_hr.php' method='get' name='edizmf' id='edizmf'>
		<input name='action' type='hidden' value='ch' />
		<input name='mesto_hr' type='hidden' value='".$_GET['mesto_hr']."' />
		<div class='head1'>Места хранения материалов</div>
Название<input name='nazv' type='text' value='".$rowA['nazv']."'/><br />
Отвественное лицо<select name='mol' id='mol' value='".$rowA['mol']."'>";
$query = "SELECT id,surname,name,otch FROM sotr ORDER BY surname ASC";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (($row['id']==$rowA['sotr']) || ($i==0)) echo "<option value='".$row['id']."' selected='selected'>".$row[1]." ".$row[2]." ".$row[3]."</option>";
	else echo "<option value='".$row['id']."'>".$row[1]." ".$row[2]." ".$row[3]."</option>";
}
echo "      </select><br />

<input value='Изменить' name='change' type='submit'/>
</center>
		</form>";
	//include("footer.php");
	exit;
	break;
	
	
}
echo "<form action='mater_mesta_hr.php' method='get' name='edizmf' id='edizmf'>
		<input name='action' type='hidden' value='add' />
		<div class='head1'>Места хранения материалов</div>
Название<input name='nazv' type='text' /><br />
Отвественное лицо<select name='mol' id='mol'>";
$query = "SELECT id,surname,name,otch FROM sotr ORDER BY surname ASC";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	echo "<option value='".$row['id']."'>".$row[1]." ".$row[2]." ".$row[3]."</option>";
}
echo "      </select>
<input value='Добавить' type='submit' />
<hr width='100%' noshade='noshade' size='1'/>

		<center>";
		 $query = "SELECT `id`, `nazv`, `mol` FROM `mesta_hr`";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count<10) echo "<select name='mesto_hr' id='mesto_hr' size='".$count."'>";
		else echo "<select name='mesto_hr' id='mesto_hr' size='10'>";
		 for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'>".$row['nazv']."</option>";
	        }
					echo "</select>		     <br />
<input name='del' type='submit'  value='Удалить' onclick=\"document.edizmf.action.value='del'\"/>
<input name='del' type='submit'  value='Изменить' onclick=\"document.edizmf.action.value='ch'\"/>
</center>
		</form>";
//include("footer.php");
?>