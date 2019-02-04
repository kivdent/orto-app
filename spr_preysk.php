<?php
session_start();
include('mysql_fuction.php');
$ThisVU="administrator";
$ModName="Прейскуранты"; 
include("header.php");

 switch ($_GET['action'])
{
	case "add":
		$query = "INSERT INTO preysk (`id`,`preysk`)
					VALUES (NULL,'".$_GET['New_preysk']."')";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Прейскурант добавлен');
		ret("spr_preysk.php");
	break;
	case "3":
		$query = "DELETE FROM preysk WHERE id=".$_GET['id'];
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Прейскурант удалён');
		ret("spr_preysk.php");
	break;
	case "2":
	if (isset($_GET['ok']))
	{
		$query = "UPDATE preysk SET preysk='".$_GET['New_preysk']."' WHERE id='".$_GET['id']."'";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Прейскурант изменен');
		ret("spr_preysk.php");
	}
	else
	{
		$query = "SELECT `preysk` FROM `preysk` WHERE `id`=".$_GET['id'];
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		echo " <form id='pr' name='pr' method='get' action='spr_preysk.php'>
		<input name='action' type='hidden' value='2' />
		<input name='id' type='hidden' value='".$_GET['id']."' />
		Новый:<input type='text' name='New_preysk' value='".$row['preysk']."'/>
        <input type='submit' name='ok' value='Изменить' />
        </form>";
		include("footer.php");
		exit;
	}
	break;
			  }
 
echo " <form id='pr' name='pr' method='get' action='spr_preysk.php'>
		<input name='action' type='hidden' value='add' />
          Прейскуранты<br />
          <table width='100%' border='0' cellspacing='0' cellpadding='1'>
            <tr>
              <td width='50%'>Новый:
                <input type='text' name='New_preysk' />
                <input type='submit' name='Submit3' value='Добавить' /></td>
              <td width='50%'>";
$query = "SELECT * FROM `preysk`";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>15) echo "<select name='id' size=15>";
echo "<select name='id' size=".$count.">";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	echo "<option value=".$row['id'].">".$row['preysk']."</option>";
}
			 
              echo " </select><br />
              <input type='submit' name='Submit' value='Изменить'  onclick='document.pr.action.value=2'/>
              <input type='submit' name='Submit' value='Удалить' onclick='document.pr.action.value=3'/></td>
            </tr>
          </table>
          </form>";
include("footer.php");
?>