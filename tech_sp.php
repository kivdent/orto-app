<?php
$ThisVU="stms";
$ModName="Список техники"; 
$js="spisok"; 
include("header.php");
switch ($_GET['action'])
{
	case "add":
		switch ($_GET['step'])
		{
			case "1":
					  
		echo "	<form action='tech_sp.php' method='get'>
		<input name='action' type='hidden' value='add'>
		<input name='step' type='hidden' value='2'>
		<input name='cab' type='hidden' value='".$_GET['cab']."'>
			Наименование:
			  <input name='naim' type='text' value='' size='30' maxlength='30' /><br />

  </label>";
echo "Стоимость:
			  <input name='stoim' type='text' value='' size='10' maxlength='10' />рублей<br />	";			
echo "Дата покупки:<select name='drD' id='drD'>";
for ($i=1; $i<32; $i++)
{
if ($i<10)
{
        if (date("j")==$i) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
        else echo "<option value='0".$i."'>".$i."</option>";
}
else
        {
        if (date("j")==$i) echo "<option value='".$i."' selected='selected'>".$i."</option>";
        else echo "<option value='".$i."'>".$i."</option>";
        }
}
echo "</select>
    /
    <select name='drM' id='drM'>";
$s="";
for ($i=1; $i<13; $i++)
{
switch ($i)
	{
	case "1":
		$s="'>Январь</option>";
		break;
	case "2":
		$s="'>Февраль</option>";
		break;
	case "3":
		$s="'>Март</option>";
		break;
	case "4":
		$s="'>Апрель</option>";
		break;
	case "5":
		$s="'>Май</option>";
		break;
	case "6":
		$s="'>Июнь</option>";
		break;
	case "7":
		$s="'>Июль</option>";
		break;
	case "8":
		$s="'>Август</option>";
		break;
	case"9":
		$s="'>Сентябрь</option>";
		break;
	case "10":
		$s="'>Октябрь</option>";
		break;
	case "11":
		$s="'>Ноябрь</option>";
		break;
	case "12":
		$s="'>Декабрь</option>";
		break;
}
if ($i<10)
{
if ($i==date("n"))
				if ($i==date("n")) echo "<option value='0".$i."' selected='selected".$s;
        if (!($i==date("n"))) echo "<option value='0".$i.$s;
}
else
        {
        if ($i==date("n")) echo "<option value='".$i."' selected='selected".$s;
        if (!($i==date("n"))) echo "<option value='".$i.$s;
        }
}

echo "    </select>
    /
    <select name='drY' id='drY'>";
	for ($i=1910; $i<2008; $i++)
	{
	if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
	else echo "<option value='".$i."'>".$i."</option>";
	}
echo "    </select>";

echo " <br /><input name'' type='submit' value='Сохранить'> 
			</form>  ";
			include("footer.php");
			exit;
			break;
			case "2":
				$dt=$_GET['drY']."-".$_GET['drM']."-".$_GET['drD'];
				$query = "INSERT INTO `tech` (`id`, `nazv`, `stoim`, `date`, `cab`)
				 VALUES 
				(NULL, '".$_GET['naim']."', '".$_GET['stoim']."', '".$dt."', '".$_GET['cab']."')";
				//////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('tech_sp.php');
			break;
		}
	break;
	case "change":
		if (isset($_GET['save']))
		{
			$query = "UPDATE `tech` 
			SET 
			`nazv`='".$_GET['naim']."',
			`stoim`='".$_GET['stoim']."',
			`date`='".($_GET['drY']."-".$_GET['drM']."-".$_GET['drD'])."'
			WHERE `id`=".$_GET['id'];
			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret('tech_sp.php');
			include("footer.php");
			exit;
		}
		if (isset($_GET['del']))
		{
			$query = "DELETE FROM `tech` 
			WHERE `id`=".$_GET['id'];
			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret('tech_sp.php');
			include("footer.php");
			exit;
		}	
		$query = "SELECT `nazv`, `stoim`, `date`, `cab` FROM `tech` WHERE `id`=".$_GET['id'];
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$rowA = mysqli_fetch_array($result);
		echo "	<form action='tech_sp.php' method='get'>
		<input name='action' type='hidden' value='change'>
		<input name='cab' type='hidden' value='".$_GET['cab']."'>
		<input name='id' type='hidden' value='".$_GET['id']."'>
			Наименование:
			  <input name='naim' type='text'  size='30' maxlength='30' value='".$rowA['nazv']."' /><br />

		  </label>";
		echo "Стоимость:
					  <input name='stoim' type='text' size='10' maxlength='10'  value='".$rowA['stoim']."'/>рублей<br />	";	
					  $dt=explode('-',$rowA['date']);		
		echo "Дата покупки:<select name='drD' id='drD'>";
		for ($i=1; $i<32; $i++)
		{
		if ($i<10)
		{
				if ($dt[2]==$i) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
				else echo "<option value='0".$i."'>".$i."</option>";
		}
		else
				{
				if ($dt[2]==$i) echo "<option value='".$i."' selected='selected'>".$i."</option>";
				else echo "<option value='".$i."'>".$i."</option>";
				}
		}
		echo "</select>
			/
			<select name='drM' id='drM'>";
		$s="";
		for ($i=1; $i<13; $i++)
		{
		switch ($i)
			{
			case "1":
				$s="'>Январь</option>";
				break;
			case "2":
				$s="'>Февраль</option>";
				break;
			case "3":
				$s="'>Март</option>";
				break;
			case "4":
				$s="'>Апрель</option>";
				break;
			case "5":
				$s="'>Май</option>";
				break;
			case "6":
				$s="'>Июнь</option>";
				break;
			case "7":
				$s="'>Июль</option>";
				break;
			case "8":
				$s="'>Август</option>";
				break;
			case"9":
				$s="'>Сентябрь</option>";
				break;
			case "10":
				$s="'>Октябрь</option>";
				break;
			case "11":
				$s="'>Ноябрь</option>";
				break;
			case "12":
				$s="'>Декабрь</option>";
				break;
		}
		if ($i<10)
		{
		if ($i==$dt[1])
						if ($i==$dt[1]) echo "<option value='0".$i."' selected='selected".$s;
				if (!($i==$dt[1])) echo "<option value='0".$i.$s;
		}
		else
				{
				if (($i==$dt[1])) echo "<option value='".$i."' selected='selected".$s;
				if (!($i==$dt[1])) echo "<option value='".$i.$s;
				}
		}
		
		echo "    </select>
			/
			<select name='drY' id='drY'>";
			for ($i=1910; $i<2008; $i++)
			{
			if ($i==$dt[0]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
			else echo "<option value='".$i."'>".$i."</option>";
			}
		echo "    </select>";
		
		echo " <br /><input name='save' type='submit' value='Сохранить'> 
		<input name='del' type='submit' value='Удалить'> 
			</form>  ";
			include("footer.php");
			exit;
	break;
}
$query = "SELECT `id`, `nazv`, `stoim`, `date`, `cab` FROM `tech`";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$ct=0;
for ($i=0;$i<$count;$i++)
{
	$ct++;
	$row = mysqli_fetch_array($result);
	$tech['$i][id']=$row['id'];
	$tech['$i][nazv']=$row['nazv'];
	$tech['$i][stoim']=$row['stoim'];
	$tech['$i][date']=$row['date'];
	$tech['$i][cab']=$row['cab'];
	$dt=explode("-",$row['date']);
	$base_day		= $dt[2];	
	$base_mon		= $dt[1];
	$base_yr		= $dt[0];
	$current_day		= date ("j");
	$current_mon		= date ("n");
	$current_yr		= date ("Y");
	$base_mon_max		= date ("t",mktime (0,0,0,$base_mon,$base_day,$base_yr));
	$base_day_diff 		= $base_mon_max - $base_day;
	$base_mon_diff 		= 12 - $base_mon - 1;
	$start_day		= 1;
	$start_mon		= 1;
	$start_yr		= $base_yr + 1;
	$day_diff	= ($current_day - $start_day) + 1;
	$mon_diff	= ($current_mon - $start_mon) + 1;
	$yr_diff	= ($current_yr - $start_yr);
	$day_diff	= $day_diff + $base_day_diff;
	$mon_diff	= $mon_diff + $base_mon_diff;
	if ($day_diff >= $base_mon_max)
	{
		$day_diff = $day_diff - $base_mon_max;
		$mon_diff = $mon_diff + 1;
	}
	if ($mon_diff >= 12)
	{
		$mon_diff = $mon_diff - 12;
		$yr_diff = $yr_diff + 1;
	}
if ($yr_diff ==1) $years = " год ";
if (($yr_diff >1) and ($yr_diff <5)) $years = " года ";
if ($yr_diff >4) $years = " лет";

if ($day_diff ==1) $days = " день ";
if (($day_diff >1) and ($day_diff <5)) $days = " дня ";
if ($day_diff >4) $days = " дней ";

if ($mon_diff ==1) $month = " месяц";
if (($mon_diff >1) and ($mon_diff <5)) $month = " месяца ";
if ($mon_diff >4) $month  = " месяцев ";
if ($yr_diff >1) $tech['$i][Sr']=$yr_diff.$years.$mon_diff.$month.$day_diff.$days;
else if ($mon_diff>"1") $tech['$i][Sr']=$mon_diff.$month.$day_diff.$days;
else  $tech['$i][Sr']=$day_diff.$days;

}
$query = "SELECT `id`, `nazv` FROM `rabmesto`";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<TABLE BORDER=0 align='left'>";
for ($w=0;$w<$count;$w++)
{
	$row = mysqli_fetch_array($result);
	echo "<TR><TD>
    <TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$row['nazv']."</A><DIV>
	<a href='tech_sp.php?action=add&cab=".$row['id']."&step=1' class='small2'>Добавить прибор</a>";

		for($i=1;$i<=$ct;$i++)
		{
		
		if ($tech['$i][cab']==$row['id'])
			echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD widht=150><IMG SRC='image/leaf.gif'><a href='tech_sp.php?action=change&id=".$tech['$i][id']."' class='small'>".$tech['$i][nazv']."</a><DIV>
         </DIV></TD><td widht=15></td><td widht=150>Срок службы:".$tech['$i][Sr']."</td></TR></TABLE>";
		} 
		echo "</DIV></TD></TR></TABLE>
   </TR></TD>";
	
}
echo "</TABLE>";
include("footer.php");
?>
