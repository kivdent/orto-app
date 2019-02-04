<?php
session_start();
include('mysql_fuction.php');
$ThisVU="administrator";
$ModName="Клише для заполнения пункта объективно"; 

include("header.php");switch ($_POST['action'])
{
	case "add":
		$query = "INSERT INTO `klishe_obk` 
		(`id`, `nazv`, `function`, `text`, `ds`)
		VALUES 
		(NULL, '".addslashes($_POST['nazv'])."', '".addslashes($_POST['funct'])."', '".addslashes($_POST['text'])."', '".addslashes($_POST['ds'])."')";
////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret('klishe.php');
	break;
}
echo "		<script language=\"JavaScript\" type=\"text/javascript\">
		function AddDs (id,nazv)
		{
			document.klishef.ds.value=id;
			document.klishef.dst.value=nazv;
		}
		
		</script>";
		echo "<form action='klishe.php' method='post' name='klishef' id='klishef'>
Название:<input name='nazv' type='text' />			
<input name='action' type='hidden' value='add' id='action'/><br>

			Функция:<br />
			<textarea name='funct' cols='40' rows='10'></textarea><br />
			Текст:<br />
			<textarea name='text' cols='40' rows='10'></textarea>
			<br />
			Диагноз: 
			<input name='ds' type='hidden' id='ds'/><input name='dst' type='text' id='dst' size='40' readonly='readonly'/><br>

			<input name=\"save\" type=\"submit\" value='Сохранить'>
</form>";
function ShowTree($klass,$upID=0,$ur=1)
{
	$tab=10;
	$query = "SELECT `ds`.`id`, `ds`.`Nazv`, `ds`.`upID`, `ds`.`KlassID`
FROM ds
WHERE ((`ds`.`KlassID` ='".$klass."') AND (`ds`.`upID` ='".$upID."') AND (`ds`.`Cat` =1))";
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$countA=$count;
	$resultA=$result;
	if ($countA>0)
	{
	    for ($z=0;$z<$countA;$z++)
		{
			$rowA = mysqli_fetch_array($resultA);
			echo "<tr>
		<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
		  <tr>
			 <td width='".($ur*$tab)."'><img src='image/transrerent.gif'  width='".($ur*$tab)."' height=1/></td>
			<td width='50%' class='head3'>".$rowA['Nazv']."</td>
			<td width='25%' align='center'></td>
			<td width='25%' align='center'></td>
		  </tr>
		</table></td>
	  </tr>";
			ShowTree($klass,$rowA['id'],($ur+1));
		}
	}
	$query = "SELECT `ds`.`id`, `ds`.`Nazv`, `ds`.`upID`, `ds`.`KlassID`
FROM ds
WHERE ((`ds`.`KlassID` ='".$klass."') AND (`ds`.`upID` ='".$upID."') AND (`ds`.`Cat` =0))";
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$countB=$count;
	$resultB=$result;
	/////Поиск и вывод диагнозов
	if ($countB>0)
	{
			for ($i=0;$i<$countB;$i++)
			{
				$rowB = mysqli_fetch_array($resultB);
				echo " <tr>
    <td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
      <tr>
        <td width='".($ur*$tab)."'><img src='image/transrerent.gif'  width='".($ur*$tab)."' height=1/></td>

		<td width='50%' class='head2' ><a href=\"#\" onClick='AddDs(\"".$rowB['id']."\",\"".$rowB['Nazv']."\")'>".$rowB['Nazv']."</a></td>
        <td width='25%' align='center'></td>
      </tr>
    </table></td>
  </tr>";
			}
		}
		else    echo "  <tr>
    <td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
      <tr>
        <td width='".($ur*$tab)."'><img src='image/transrerent.gif'  width='".($ur*$tab)."' height=1/></td>
        <td width='100%' class='head2'>Нет диагнозов </td>
      </tr>
    </table></td>
  </tr>   
  <tr>
    <td width='1' height='1'><img src='image/transrerent.gif'  width='1' height='1' border='0'/></td>
  </tr>";
}
function DsShow($klass)
{
	$query = "SELECT `klass`.`id`, `klass`.`Nazv`
	FROM klass
	WHERE (`klass`.`id` ='".$klass."')";
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	echo "<div class='head1'>".$row['Nazv']."</div>";
	echo "<form action='' method='get'>
	<table width='62%' border='0' cellspacing='0' cellpadding='1'>";
	ShowTree($klass);  
	echo "</table>
	</form>";
}
function DelCat($id)
{
	$query = "delete from ds where cat='0' and id=".$id;
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$query = "SELECT `ds`.`id`
				FROM ds
				WHERE `ds`.`upID` ='".$id."'";
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		DelCat($row['id']);
	}
	$query = "delete from ds where cat='1' and id=".$id;
	//////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$count=$count;
	$result=$result;
	$row = mysqli_fetch_array($result);
}
function ShowKlass()
{
	$query = "SELECT `razd`.`id`, `razd`.`Razd`
FROM razd";
	////////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$countA=$count;
	$resultA=$result;
	//Показать все разделы
	for ($i=0;$i<$countA;$i++)
	{
		$rowA = mysqli_fetch_array($resultA);
		echo "<div class='head1'>".$rowA['Razd']."</div><br>";
		////////показать все классификации в разделах
		$query = "SELECT `klass`.`id`, `klass`.`Nazv`, `klass`.`Razd`
					FROM klass
					WHERE (`klass`.`Razd` ='".$rowA['id']."')";
		////////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>0)
		{
			$countB=$count;
			$resultB=$result;
			for ($j=0;$j<$countB;$j++)
			{
				$rowB = mysqli_fetch_array($resultB);
				echo "<a class='mmenu' href='klishe.php?mod=show&action=show&klass=".$rowB['id']."'>".$rowB['Nazv']."</a><br>";	
			}
		}
		else echo "<div class='head2'>Нет классификаций в разделе</div>";
;
	}
}
///////////////////////////////Начало работы
//////Выбор модуля
switch ($_GET['mod'])
{
	////////////////Модуль классификации
	case "klass":
		switch ($_GET['action'])
		{
			//Удаление
			case "del":
				$query = "DELETE FROM klass
								WHERE (`klass`.`id` ='".$_GET['klass']."')";
				//////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			break;
			//Добавление
			case "add":
			////////////////////Пошаговое добавление
				switch ($_GET['step'])
				{
					case "1":
						echo "<form action='klishe.php' method='get' name='f1' id='f1'>
						  Название классификации: 
							<input name='step' type='hidden' value='2'>
							<input name='razd'  type='hidden' value='".$_GET['razd']."'>
							<input name='mod' type='hidden' value='".$_GET['mod']."'>
							<input name='action' type='hidden' value='".$_GET['action']."'>
							<input name='nazv' type='text' id='nazv' size='25'><br>
							<input name='' type='submit' value='Дальше>>'>
						</form>";
						include("footer.php");
						exit;
					break;	
					case "2":
						$query = "INSERT INTO klass (`id`, `Nazv`, `Razd`)
									VALUES (NULL, '".$_GET['nazv']."','".$_GET['razd']."')";
						//////////echo $query."<br />";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					break;
				}
			break;
		}
	break;
	////Показать диагнозы
	case "show":
	    switch ($_GET['action'])
		{
			////////Добавление
			case "add":
				switch ($_GET['step'])
				{
					case "1":
						echo "<form action='klishe.php' method='get' name='f1' id='f1'>";
						if ($_GET['cat']==1) echo "Название раздела: ";
						else echo "Диагноз: ";					   
						echo "<input name='step' type='hidden' value='2'>
							<input name='upID'  type='hidden' value='".$_GET['upID']."'>
							<input name='mod' type='hidden' value='".$_GET['mod']."'>
							<input name='action' type='hidden' value='".$_GET['action']."'>
							<input name='cat' type='hidden' value='".$_GET['cat']."'>
							<input name='klass' type='hidden' value='".$_GET['klass']."'>
							<input name='nazv' type='text' id='nazv'><br>
							<input name='' type='submit' value='Дальше>>'>
						</form>";
						include("footer.php");
						exit;
					break;
					case "2":
						$query = "INSERT INTO  ds (`id`, `Nazv`, `upID`, `KlassID`, `Cat`)
VALUES (NULL, '".$_GET['nazv']."', '".$_GET['upID']."', '".$_GET['klass']."', '".$_GET['cat']."')";
						//////////echo $query."<br />";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					break;
				}
				
			break;
			////////Удаление
			case "del":
				if ($_GET['cat']==0)
				{
					$query = "DELETE FROM ds WHERE id=".$_GET['id'];
					//////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$query = "DELETE FROM soot_zh WHERE ds=".$_GET['id'] ;
					//////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
				else
				{
					DelCat($_GET['id']);
				}
			break;
			////////Изменение
			case "change":
				switch ($_GET['step'])
				{
					case "1":
						echo "<form action='klishe.php' method='get' name='f1' id='f1'>";
						if ($_GET['cat']==1) echo "Название раздела: ";
						else echo "Диагноз: ";
						$query = "select Nazv from ds where id=".$_GET['id'];	
						//////////echo $query."<br />";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);					
						$row = mysqli_fetch_array($result);	
						echo "<input name='step' type='hidden' value='2'>
							<input name='id'  type='hidden' value='".$_GET['id']."'>
							<input name='mod' type='hidden' value='".$_GET['mod']."'>
							<input name='action' type='hidden' value='".$_GET['action']."'>
							<input name='cat' type='hidden' value='".$_GET['cat']."'>
							<input name='klass' type='hidden' value='".$_GET['klass']."'>
							<input name='nazv' type='text' id='nazv' value='".$row['Nazv']."'><br>
							<input name='' type='submit' value='Дальше>>'>
						</form>";
						include("footer.php");
						exit;
					break;
					case "2":
						$query = "UPDATE ds
								SET Nazv='".$_GET['nazv']."'
								WHERE id='".$_GET['id']."'";
						//////////echo $query."<br />";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					break;
				}
			break;			
		}
		DsShow($_GET['klass']);
	break;
}
/////Показать классификации или диагнозы
if ((!isset($_GET['klass'])) or ($_GET['action']=="ShowKlass") or ($_GET['mod']=="klass"))
{
	ShowKlass();
}			
include("footer.php");
?>