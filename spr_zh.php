<?php
$ThisVU="administrator";
$ModName="Жалобы";
include("header.php");
if ((($_GET['vid'])==0) or (!(isset($_GET['vid']))))
{
/////////////Ввод жалоб
	echo "<center><a href='spr_zh.php?vid=1' class='menu2'>Установка соответсвий</a></center>";
	switch ($_GET['action'])
	{
		case "add":
		$query = "INSERT INTO zh (id,zh)
					VALUES (NULL,'".$_GET['New_Zh']."')" ;
		//////////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<script language=\"JavaScript\">
		location.href='spr_zh.php?vid=0'
		</script>";
		break;
		case "del":
		$query = "DELETE FROM zh WHERE id=".$_GET['id'] ;
		//////////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "DELETE FROM soot_zh WHERE zh=".$_GET['id'] ;
		//////////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		echo "<script language=\"JavaScript\">
		location.href='spr_zh.php?vid=0'
		</script>";
		break;
	} 
	echo "<form method='get' action='spr_zh.php' name='zh' id='zh'>
	  <input name='action' type='hidden' value='add' />
	    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
          <tr>
            <td width='50%' valign='top'>Жалоба:<input name='New_Zh' type='text' /><br />
			<center><input name='' type='submit'  value='Добавить'/></center>
              </td>
            <td valign='top' align='left'>";
              
	$query = "SELECT * FROM zh ORDER BY zh" ;
	//////////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count<15) echo "<select name='id' size='".$count."'>";
	else echo "<select name='id' size='15'>";
	
	for ($i=0;$i<$count;$i++)
	{	
		$row = mysqli_fetch_array($result);
		echo "<option value=".$row['id'].">".$row['zh']."</option>";		  
	}
	echo "</select>
              <br />
			  <input name='del' type='submit' onclick='document.zh.action.value=\"del\"' value='Удалить'/>
              </td>
          </tr>
        </table>
	  
	  </form>";
	
}
	else
{
////////////////////Ввод соответствий
////////Действия
	switch ($_GET['action'])
	{
		case "add":
		///////////////Добавление
			$query = "SELECT * FROM soot_zh WHERE ((ds=".$_GET['ds'].") and (zh=".$_GET['id'].") )" ;
			////////echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			if ($count>0) 
			{
			msg("Такое соответствие существует");
			}
			else
			{
				$query = "insert into soot_zh (id,ds,zh) values (NULL,'".$_GET['ds']."','".$_GET['id']."')" ;
				////////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
			}
			ret("spr_zh.php?vid=1&ds=".$_GET['ds']);
		break;
		case "del":
			$query = "DELETE FROM soot_zh WHERE id=".$_GET['soot'] ;
			//////echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			msg('Соответствие удалено');
			ret("spr_zh.php?vid=1&ds=".$_GET['ds']);
		break;
	}
	echo "<center><a href='spr_zh.php?vid=0' class='menu2'>Ввод жалоб</a></center>";
	echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td><form method='get' action='spr_zh.php' name='ust_soot' id='ust-soot'>
	<input name='vid' type='hidden' value='1'>
	<input name='action' type='hidden' value='add'>
	<center><div class='head2'>Установить соответствие</div></center>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td class='head2'>Диагноз<br><select name='ds'>" ;
	$query = "select * from ds order by KlassID asc,Nazv asc" ;
////////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($_GET['ds']==$row['id']) echo "<option value=\"".$row['id']."\" selected='selected'>".$row['Nazv']."</option>";
	else echo "<option value=\"spr_zh.php?vid=1&ds=".$row['id']."\" >".$row['Nazv']."</option>";
}   	
	echo "</select></td>";
	 echo "<td class='head2'>Жалоба<br>";
	 $query = "SELECT * FROM zh ORDER BY zh" ;
	//////////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	echo "<select name='id'>";
	for ($i=0;$i<$count;$i++)
	{	
		$row = mysqli_fetch_array($result);
		echo "<option value=".$row['id'].">".$row['zh']."</option>";		  
	}
	echo "</select>
</td>
  </tr>
</table>
<center><input name='' type='submit'  value='Установить'></center>
</form>
</td>
  </tr>
  <tr>
    <td class='head2'><form action='spr_zh.php' method='get' name='zh' id='zh'>Таблица соответствий <br>
Диагноз:";
echo "<select name=\"ds\" onChange=\"MM_jumpMenu('parent',this,0)\">";
echo "<script type=\"text/JavaScript\">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\spr_zh.php?vid=1&ds=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
    </script>";
echo "<option value=\"0\">Все диагнозы</option>";
$query = "select * from ds order by KlassID asc,Nazv asc" ;
////////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($_GET['ds']==$row['id']) echo "<option value=\"".$row['id']."\" selected='selected'>".$row['Nazv']."</option>";
	else echo "<option value=\"".$row['id']."\" >".$row['Nazv']."</option>";
}   
echo "    </select><br>";
echo "  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
    <tr>
      <td width='50%' align='right' valign='top'>Соответствия<br />";

if (($_GET['ds']==0) or (!(isset($_GET['ds']))))
{
	$query = "SELECT `ds`.`Nazv`, `zh`.`zh`, `soot_zh`.`id`
FROM ds, zh, soot_zh
WHERE ((`ds`.`id` =`soot_zh`.`ds` ) AND (`zh`.`id` =`soot_zh`.`zh`))" ;
	$NE=0;
}
else
{
	$query = "SELECT `ds`.`Nazv`, `zh`.`zh`, `soot_zh`.`id`
FROM ds, zh, soot_zh
WHERE ((`ds`.`id` =`soot_zh`.`ds` ) AND (`zh`.`id` =`soot_zh`.`zh`) AND (`soot_zh`.`ds` ='".$_GET['ds']."'))" ;
	$NE=1;
}

$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count<15) echo "<select name='soot' size='".$count."'>";
	else echo "<select name='soot' size='15'>";
	for ($i=0;$i<$count;$i++)
	{	
		$row = mysqli_fetch_array($result);
		echo "<option value=".$row['id'].">".$row['Nazv']." - ".$row['zh']."</option>";
		
	}
echo "</select>";
////////echo $query."<br>";
echo " <br />
<input name='del' type='submit' onclick='document.zh.action.value=\"del\"' value='Удалить'/>
</td>
      <td width='50%' align='left' valign='top'>Новый диагноз<br />";
	 
	 $query = "SELECT * FROM zh ORDER BY zh" ;
	//////////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	if ($count<15) echo "<select name='id' size='".$count."'>";
	else echo "<select name='id' size='15'>";
	for ($i=0;$i<$count;$i++)
	{	
		$row = mysqli_fetch_array($result);
		echo "<option value=".$row['id'].">".$row['zh']."</option>";		  
	}
	echo "</select>
</td>
    </tr>
  </table>";
if ($NE==1) echo "<center><input name='' type='submit'  value='Установить'></center> ";
echo" 
<input name='vid' type='hidden' value='1'>
<input name='action' type='hidden' value='add'>   </form>
  </td>
  </tr>
</table>";	
}
include("footer.php");
?>