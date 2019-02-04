<?php

$ThisVU="administrator";
$ModName="Справочник манипуляций";
$js="manip"; 
include("header.php");
if (!($_GET['preysk']))
{
	$query = "SELECT `id` FROM `preysk`";
	////////echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	$preysk=$row[0];
} 
else $preysk=$_GET['preysk'];
switch ($_GET['action'])
{
	case "add":
		$query = "INSERT INTO manip (`id`, `manip`, `preysk`, `zapis`, `price`,`cat`, `UpId`)
					VALUES (NULL,'".$_GET['manip']."','".$_GET['preysk']."','".$_GET['zapis']."','".$_GET['price']."','0','".$_GET['UpId']."')";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Манпуляция добавлена');
		ret("spr_manip.php");
	break;
	case "del":
		$query = "DELETE FROM manip WHERE id=".$_GET['id'];
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Манипуляция удалена');
		ret("spr_manip.php");
	break;
	case "change":
	if (isset($_GET['ok']))
	{
		$query = "UPDATE manip SET `manip`='".$_GET['manip']."', 
									`preysk`='".$_GET['preysk']."', 
									`zapis`='".$_GET['zapis']."', 
									`price`= '".$_GET['price']."'
				WHERE id='".$_GET['id']."'";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Прейскурант изменен');
		ret("spr_manip.php");
	}
	else
	{
	    if ($_GET['id']=="")
		{
			msg('Выбирите позицию');
			ret("spr_manip.php");
		}
		$query = "SELECT  FROM `manip` WHERE `id`=".$_GET['id'];
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$rowA = mysqli_fetch_array($result);		
			echo "<form action='spr_manip.php' method='get' id='manipf' name='manipf' onsubmit='chek(document.manipf.manip.value,document.manipf.price.value)'>
			<input name='action' type='hidden'  value='change'/>
			<input name='id' type='hidden'  value='".$_GET['id']."'/>
			<input name='preysk' type='hidden'  value='".$_GET['preysk']."'/>
			Новая манипуляция:
			 <input name='manip' type='text' id='manip' value='".$rowA['manip']."'/>
             Стоимость:
             <input type='text' name='price'  size='5' id='price' value='".$rowA['price']."'/><br /> 
			Запись в карте:
             <input type='text' name='zapis' id='zapis' value='".$rowA['zapis']."'/>              
             <input type='submit' name='ok' value='Изменить' />";
		include("footer.php");
		exit;
	}
	break;
			  }
echo "<form action='spr_manip.php' method='get' id='manipf' name='manipf' onsubmit='return(chek(document.manipf.manip.value,document.manipf.price.value))'>
		<table width='100%' border='0' cellspacing='0' cellpadding='1'>
          <tr>
            <td>
			<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='spr_manip.php?preysk=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			<input name='action' type='hidden'  value='add'/>
			Прейскурант:
			 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
			$query = "SELECT * FROM preysk";
			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($preysk==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
				else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
			}

echo "        </select>
<hr width='100%' noshade='noshade' size='1'/>
			Новая манипуляция:
			 <input name='manip' type='text' id='manip' />
             Стоимость:
             <input type='text' name='price'  size='5' id='price'/><br /> 
			Запись в карте:
             <input type='text' name='zapis' id='zapis'/>              
             <input type='submit' name='add' value='Добавить' />
             </td>
          </tr>
          <tr>
            <td>
			<center>";
echo "<hr width='100%' noshade='noshade' size='1'/>Манипуляции:";

$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by manip";
////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$cc=0;
$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['Cat']==1)
		{
			$cc++;
			$cat['$cc][id']=$row['id'];
			$cat['$cc][manip']=$row['naim'];
			
		}
		else
		{
			$cm++;
			$mat['$cm][id']=$row['id'];
			$mat['$cm][manip']=$row['manip'];
			$mat['$cm][price']=$row['price'];
			$mat['$cm][UpId']=$row['UpId'];
			
		}
		
	}
include("footer.php");
?>