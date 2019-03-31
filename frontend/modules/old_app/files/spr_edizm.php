<?php
$ThisVU="all";
$this->title="Еденицы измерения"; 
//include("header.php");
switch ($_GET['action'])
{
	case "add":
		$query = "INSERT INTO `edizm` (`id`, `abbr`, `naim` )VALUES (NULL, '".$_GET['abbr']."', '".$_GET['naim']."')";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('spr_edizm.php');
	break;
	case "del":
		$query = "DELETE FROM `edizm` WHERE `id`=".$_GET['id'];
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('spr_edizm.php');
	break;
	
}
echo "<form action='spr_edizm.php' method='get' name='edizmf' id='edizmf'>
		<input name='action' type='hidden' value='add' />
		<div class='head1'>Еденицы измерения</div>
		Наименование:<input name='naim' type='text' /><br />
Аббревиатура:<input name='abbr' type='text' /><br />
<input value='Добавить' type='submit' />
<hr width='100%' noshade='noshade' size='1'/>

		<center>";
		 $query = "SELECT * FROM `edizm`";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count<10) echo "<select name='id' id='edizm' size='".$count."'>";
		else echo "<select name='edizm' id='edizm' size='10'>";
		 for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row['id']."'>".$row['naim']."</option>";
	        }
					echo "</select>		     <br />
<input name='del' type='submit'  value='Удалить' onclick=\"document.edizmf.action.value='del'\"/></center>
		</form>";
//include("footer.php");
?>