<?php
$ThisVU="administrator";
$ModName="Справочник манипуляций";
$js="manip"; 
include("header.php");

switch ($_POST['action'])
{		
	case "price_ch":
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE `preysk`=".$_POST['preysk']." order by `range`, `manip`";
echo $query."<br />";
	
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$countA=$count;
	$resultA=$result;
	for ($i=0;$i<$countA;$i++)
			{
				$rowA = mysqli_fetch_array($resultA);
				$price_new=	$rowA['price'];
				
				if (round(($rowA['price']+($rowA['price']*$_POST['price'])/100),-1)==$rowA['price'])
			{
				$price_new=(floor((($rowA['price']+($rowA['price']*$_POST['price'])/100))/10))*10;
			}
			else
			{
				$price_new=round(($rowA['price']+($rowA['price']*$_POST['price'])/100),-1);
			}				
				
				//msg($price_new." ".$rowA['price']);
			$query = "UPDATE `manip` 
			SET `price`=".$price_new."
			WHERE `id`=".$rowA['id'];
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			}
			ret('spr_manip.php');
		
		exit;	
	break;
	case "all_change":
		$mat=$_SESSION['mat'];
		$price=$_POST['price'];
		//msg($mat['$_SESSION['cm]'][id']);
		for ($j=1;$j<=$_SESSION['cm'];$j++)
		{
			$query = "UPDATE `manip` 
			SET `price`=".$price['$j']."
			WHERE `id`=".$mat['$j][id'];
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		}
		ret('spr_manip.php');
		
		exit;	
break;
}
switch ($_GET['action'])
{
	case "AddCat":
		switch ($_GET['step'])
		{
			case "1":
				echo "<div class='head1'>Добавление категории</div>
				<form action='spr_manip.php' method='get' name='AddCatf'>
				<input name='action' type='hidden' value='AddCat' />
				<input name='step' type='hidden' value='2' />
				<input name='preysk' type='hidden' value='".$_GET['preysk']."' />
				Название категории:
				<textarea name='manip' cols='50' rows='3'></textarea>
				<br />
		<input name='save' type='submit'  value='Сохранить'/>
				</form> "; 
				include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO manip (`id`, `manip`,`preysk`, `cat`)
					VALUES (NULL,'".$_GET['manip']."','".$_GET['preysk']."','1')";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret("spr_manip.php?preysk=".$_GET['preysk']);
			break;
		}
	break;
	case "add":
		switch ($_GET['step'])
		{
			case "1":
				
echo "
<form action='spr_manip.php' method='get' id='manipf' name='manipf' onsubmit='return(chek(document.manipf.manip.value,document.manipf.price.value))'>
<input name='action' type='hidden' value='add' />
				<input name='step' type='hidden' value='2' />
				<input name='UpId' type='hidden' value='".$_GET['UpId']."' />
				<input name='preysk' type='hidden' value='".$_GET['preysk']."' />
			Новая манипуляция:<textarea name='manip' cols='50' rows='3'></textarea><br />

            <input type='text' name='price'  size='5' id='price'/><br /> 
			Запись в карте:<textarea name='zapis' cols='50' rows='3'></textarea>            
             <input type='submit' name='add' value='Добавить' />
			 </form>";
			 include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO manip (`id`, `manip`, `preysk`, `zapis`, `price`,`cat`, `UpId`)
							VALUES (NULL,'".$_GET['manip']."','".$_GET['preysk']."','".$_GET['zapis']."','".$_GET['price']."','0','".$_GET['UpId']."')";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				msg('Манпуляция добавлена');
				ret("spr_manip.php?preysk=".$_GET['preysk']);
			break;
		}
			break;
			case "del":
				$query = "DELETE FROM manip WHERE id=".$_GET['id'];
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($_GET['cat']==1)
				{
				$query = "DELETE FROM manip WHERE UpId=".$_GET['id'];
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				}
				msg('Манипуляция удалена');
				ret("spr_manip.php?preysk=".$_GET['preysk']);
	break;
	case "change":
	if (isset($_GET['del']))
	{
		echo "<script language=\"JavaScript\" type=\"text/javascript\">location.href='spr_manip.php?action=del&id=".$_GET['id']."&cat=1'</script>";
	}
	if (isset($_GET['ok']))
	{
		$query = "UPDATE manip SET `manip`='".$_GET['manip']."',  
									`zapis`='".$_GET['zapis']."', 
									`price`= '".$_GET['price']."'
				WHERE id='".$_GET['id']."'";
		echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		msg('Прейскурант изменен');
		ret("spr_manip.php?preysk=".$_GET['preysk']);
	}
	else
	{
	    if ($_GET['id']=="")
		{
			msg('Выбирите позицию');
			ret("spr_manip.php");
		}
		$query = "SELECT * FROM `manip` WHERE `id`=".$_GET['id'];
		echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$rowA = mysqli_fetch_array($result);		
			echo "<form action='spr_manip.php' method='get' id='manipf' name='manipf' onsubmit='chek(document.manipf.manip.value,document.manipf.price.value)'>
			<input name='action' type='hidden'  value='change'/>
			<input name='id' type='hidden'  value='".$_GET['id']."'/>
			Манипуляция:
			<textarea name='manip' cols='50' rows='3'>".$rowA['manip']."</textarea><br />

             Стоимость:
             <input type='text' name='price'  size='5' id='price' value='".$rowA['price']."'/><br /> 
			Запись в карте:
			<textarea name='zapis' cols='50' rows='3'>".$rowA['zapis']."</textarea> <br />
          
             <input type='submit' name='ok' value='Изменить' /><input type='submit' name='del' value='Удалить' />";
		include("footer.php");
		exit;
	}
	break;
	case "show":
	 if (!(isset($_GET['preysk'])))
{
	$query = "SELECT `id` FROM `preysk`";
	echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	$preysk=$row[0];
} 
else $preysk=$_GET['preysk'];
echo "
			<form action='' method='get'><script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='spr_manip.php?action=show&preysk=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			<input name='action' type='hidden'  value='add'/>
			Прейскурант:
			 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
			$query = "SELECT * FROM preysk";
			echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($preysk==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
				else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
			}

echo "        </select></form>
<center>";
echo "Манипуляции:";
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE `preysk`=".$preysk." order by `range`, `manip`";
echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$cc=0;
$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['cat']==1)
		{
			$cc++;
			$cat['$cc][id']=$row['id'];
			$cat['$cc][manip']=$row['manip'];
			
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
$_SESSION['mat']=$mat;
$_SESSION['cm']=$cm;
$counter=0;
echo "<form action=\"spr_manip.php\" method=\"post\">";
echo "Увеличить на <input type=\"text\" name=\"price\" size='4' value='5'> %
<input type=\"hidden\" name=\"action\" value=\"price_ch\">
<input type=\"hidden\" name=\"preysk\" value=\"".$preysk."\">
<input type='submit' name='Submit' value='Ok' />";
echo "</form>";
echo "<form action=\"spr_manip.php\" method=\"post\">";

echo "<input type=\"hidden\" name=\"action\" value=\"all_change\">";
echo "<center><a href='spr_manip.php?action=AddCat&step=1&preysk=".$preysk."' class='menu'>Добавить категорию</a></center><hr width='100%' noshade='noshade' size='1'/>";
if ($cc>0)
{
echo "<TABLE BORDER='0'  align='left'>";
for($i=1;$i<=$cc;$i++)
	{
		echo "<TR><TD bgcolor='#FFFFFF'>
    <TABLE border='0' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000' align='left'><TR><TD align='left' bgcolor='#FFFFFF'>".$cat['$i][manip']."
    <TABLE border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000' >";
		for($j=1;$j<=$cm;$j++)
		{
		if ($cat['$i][id']==$mat['$j][UpId'])
			echo "<TR><TD WIDTH=10 bgcolor='#FFFFFF'> ".$mat['$j][id']." </TD><TD bgcolor='#FFFFFF'> ".$mat['$j][manip']." </TD><td bgcolor='#FFFFFF'>".$mat['$j][price']." руб.</td></TR>";
		} 
		echo "</TABLE></DIV></TD></TR>
   </TABLE>
   </TR></TD>";
	}
echo "</TABLE>";


}
include("footer.php");
exit;
	break;
}
if (!(isset($_GET['preysk'])))
{
	$query = "SELECT `id` FROM `preysk`";
	echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	$preysk=$row[0];
} 
else $preysk=$_GET['preysk'];
echo "
			<form action='' method='get'><script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='spr_manipp.php?preysk=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			<input name='action' type='hidden'  value='add'/>
			Прейскурант:
			 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
			$query = "SELECT * FROM preysk";
			echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($preysk==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
				else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
			}

echo "        </select></form>
<center>";
echo $row['preysk'];
$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`koef` from manip WHERE `preysk`=".$preysk." order by `range`, `manip`";
echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$cc=0;
$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['cat']==1)
		{
			$cc++;
			$cat['$cc][id']=$row['id'];
			$cat['$cc][manip']=$row['manip'];
			
		}
		else
		{
			$cm++;
			$mat['$cm][id']=$row['id'];
			$mat['$cm][manip']=$row['manip'];
			$mat['$cm][price']=$row['price'];
			$mat['$cm][UpId']=$row['UpId'];
			$mat['$cm][koef']=$row['koef'];
		}
	}
$_SESSION['mat']=$mat;
$_SESSION['cm']=$cm;
$counter=0;
echo "<form action=\"spr_manip.php\" method=\"post\">";
echo "Увеличить на <input type=\"text\" name=\"price\" size='4' value='5'> %
<input type=\"hidden\" name=\"action\" value=\"price_ch\">
<input type=\"hidden\" name=\"preysk\" value=\"".$preysk."\">
<input type='submit' name='Submit' value='Ok' />";
echo "</form>";
echo "<form action=\"spr_manip.php\" method=\"post\">";

echo "<input type=\"hidden\" name=\"action\" value=\"all_change\">";
//echo "<center><a href='spr_manip.php?action=AddCat&step=1&preysk=".$preysk."' class='menu'>Добавить категорию</a></center><hr width='100%' noshade='noshade' size='1'/>";
if ($cc>0)
{
echo "<TABLE BORDER=0 align='left'>";
for($i=1;$i<=$cc;$i++)
	{
		echo "<TR><TD><TABLE BORDER=0 align='left'><TR><TD align='left'>".$cat['$i][manip'];
  //echo " <DIV><a href='spr_manip.php?action=del&id=".$cat['$i][id']."&cat=1' class='small2'>Удалить категорию</a>|<a href='spr_manip.php?action=add&UpId=".$cat['$i][id']."&step=1&preysk=".$preysk."' class='small2'>Добавить манипуляцию</a>";
    Echo "<TABLE BORDER=1>";
    	echo "<TR>
			<TD>Код</TD><TD>Манипуляция</TD>
			<td>Цена</td>
			<td>Коэффициент</td>
			</TR>";
		for($j=1;$j<=$cm;$j++)
		{
		if ($cat['$i][id']==$mat['$j][UpId'])
			echo "<TR>
			<TD>".$mat['$j][id']."</TD><TD>".$mat['$j][manip']."</TD>
			<td>".$mat['$j][price']."</td>
			<td>".$mat['$j][koef']."</td>
			</TR>";
		} 
		echo "</TABLE></DIV></TD></TR>
   </TABLE>
   </TR></TD>";
	}
echo "</TABLE>";


}

echo "</form>";

include("footer.php");
?>