<?php
$ThisVU="terapevt";
$this->title="Работа спациентом";
$js="insert";
//include("header2.php");
	switch ($_GET['step'])
{
case "4":
	if (!(isset($_GET['preysk']))) 
	{	
		$query = "SELECT * 
		FROM `preysk` 
		LIMIT 1";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$preysk=$row[0];
	}
	else $preysk=$_GET['preysk'];
	switch ($_GET['act'])
	{
	case "add":
		if (!(isset($_SESSION['countm'][$_GET['count']])))
		{
			$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=".$_GET['manip'] ;
			//////echo $query."<br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$_SESSION['countm'][$_GET['count']]=1;
			$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][1]=$_GET['manip'];
			$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][2]=1;
			$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][3]=$row['manip'];
			$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][4]=$row['price'];
		}
		else 
		{
			$f=0;
			for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
			{
				if ($_GET['manip']==$_SESSION['chek'][$_GET['count']][$i][1])
				{
					$f=1;
					$_SESSION['chek'][$_GET['count']][$i][2]=$_SESSION['chek'][$_GET['count']][$i][2]+1;
				}
			}
			if($f==0)
			{
				$query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=".$_GET['manip'] ;
				//////echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$_SESSION['countm'][$_GET['count']]=$_SESSION['countm'][$_GET['count']]+1;
				$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][1]=$_GET['manip'];
				$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][2]=1;
				$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][3]=$row['manip'];
				$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][4]=$row['price'];
				$_SESSION['chek'][$_GET['count']][$_SESSION['countm'][$_GET['count']]][5]=$row['zapis'];
			}
			
		}
	ret("pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
	break;
	case "del":
	if ($_SESSION['countm'][$_GET['count']]==1) 
	{
		$_SESSION['countm'][$_GET['count']]=0;
	}
	else
	for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
	{
		if ($_GET['chek']==$_SESSION['chek'][$_GET['count']][$i][1])
		{
			for ($j=$i;$j<$_SESSION['countm'][$_GET['count']-1];$j++)
			{
				
				$_SESSION['chek'][$_GET['count']][$j][1]=$_SESSION['chek'][$_GET['count']][$j+1][1];
				$_SESSION['chek'][$_GET['count']][$j][2]=$_SESSION['chek'][$_GET['count']][$j+1][2];
				$_SESSION['chek'][$_GET['count']][$j][3]=$_SESSION['chek'][$_GET['count']][$j+1][3];
				$_SESSION['chek'][$_GET['count']][$j][4]=$_SESSION['chek'][$_GET['count']][$j+1][4];
				$_SESSION['chek'][$_GET['count']][$j][5]=$_SESSION['chek'][$_GET['count']][$j+1][5];
			}
		$_SESSION['countm'][$_GET['count']]=$_SESSION['countm'][$_GET['count']]-1;
		$i=$j+1;
		}
	}
	ret("pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
	break;
	case "p1":
	for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
	{
		if ($_GET['chek']==$_SESSION['chek'][$_GET['count']][$i][1])
		{
			$_SESSION['chek'][$_GET['count']][$i][2]=$_SESSION['chek'][$_GET['count']][$i][2]+1;
		}
	}
	ret("pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
	break;
	case "m1":
	for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
	{
		if ($_GET['chek']==$_SESSION['chek'][$_GET['count']][$i][1])
		{
			if ($_SESSION['chek'][$_GET['count']][$i][2]==1)
			{
				msg("Количество манипуляций не может быть меньше одного");
			}
			else $_SESSION['chek'][$_GET['count']][$i][2]=$_SESSION['chek'][$_GET['count']][$i][2]-1;
		}
	}
	ret("pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
	break;
	case "chQ":
		if ($_GET['sstep']==1)
		{	
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ(id,qq)
			{
				q=prompt('Введите количество',qq);
				url='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$_GET['preysk']."&id='+id+'&act=chQ&sstep=2&q='+q;
				location.href=url;
			}";
			echo "ChQ('".$_GET['id']."','".$_SESSION['chek'][$_GET['count']][$_GET['id']][2]."')</script>";
		}
		else
		{
			$_SESSION['chek'][$_GET['count']][$_GET['id']][2]=$_GET[q];
			ret("pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$_GET['preysk']);
		}
	break;
	case "next":
	if (isset($_SESSION['countm'][$_GET['count']]))
		{
		ret("pat_tooday_work.php?action=lech&step=5&count=".$_GET['count']);
		exit;
					echo "<form id='lechf' name='lechf' method='get' action='pat_tooday_work.php'>
            <label></label>
            Правка лечения:<br />
                  <textarea name='lech' cols='50' rows='7' id='lech'>"; 
			//$query = "SELECT `zapis` FROM `manip` WHERE `id` in (";
//			for($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
//			{
//				if ($i==1) $query = $query."'".$_SESSION['chek'][$_GET['count']][$i][1]."'";
//				else $query = $query.",'".$_SESSION['chek'][$_GET['count']][$i][1]."'";
//			}
//			$query = $query.")";
//			//////////echo $query."<br />";
//			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//			for ($i=1;$i<=$count;$i++)
//			{
//				$row = mysqli_fetch_array($result);
//				echo $row['zapis']." ";
//			}
			for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
			{
				echo $_SESSION['chek'][$_GET['count']][$i][5]." ";
			}
			echo "</textarea>
                  <br />
                  <input type='submit' name='Submit' value='Продолжить' />";
			echo "<input name='action' type='hidden' value='lech' />";
			 	echo "<input name='step' type='hidden' value='5' />";
				echo "<input name='count' type='hidden' value='".($_GET['count'])."' />";
            echo "</form>";
			//include("footer.php");
	exit;
		}
		else
		{
			msg("Вы не выбрали не одной манипуляции");
			ret("pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
		}
		

	break;	
	}
	if (!(isset($_GET['preysk']))) $preysk=1;
	else $preysk=$_GET['preysk'];
	if (!(isset($_SESSION['pat']))) $_SESSION['pat']=$_GET['pat'];
	//////////Заполнение лечения
	echo "<form action='pat_tooday_work.php' method='get' id='lech' name='lech'>
	<input name='count' type='hidden' value='1' />";
		$query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=".$_SESSION['pat'];
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$_SESSION['pat_name']=$row[0]." ".$row[1]." ".$row[2];
	echo "<div class='head3'>Пациент: ".$_SESSION['pat_name']."</div>
			<hr width='100%' noshade='noshade' size='1'/>
			<table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>
		<td><center><div class='head2'>Прейскуранты:</div><br />";
		$query = "select * from preysk";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($row['id']==$preysk) echo "|<font color='#42929D'>".$row['preysk']."</font>|";
	else echo "|<a class=menu2 href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$row['id']."'>".$row['preysk']."</a>|";
}
		echo " </center></td>
	  </tr>
	  <tr>
		<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>";

		//echo "<td width='60%' align='center' valign='top'>Выбирте манипуляцию: <br />";
		//$query = "select * from manip WHERE preysk=".$preysk." order by manip";
////////////echo $query."<br />";
//$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//
//
//
//
//
//
//
//
//if ($count>15) echo "<select name='manip' size='15'>";
//else echo "<select name='manip' size='".$count."'>";
//if (!($count>0))
//{
//	$N="Название";
//	while (strlen($N)<30) 
//	{
//		$N=$N."_";
//	}
//	$N=$N."Цена";
//	echo "<option value=''>".$N."</option>";
//}
//for ($i=0;$i<$count;$i++)
//{
//	$row = mysqli_fetch_array($result);
//	$N=$row['manip'];
//	while (strlen($N)<30) 
//	{
//		$N=$N."_";
//	}
//	$N=$N.$row['price']." руб.";
//	echo "<option value='".$row['id']."'>".$N."</option>";
//}
//
//echo "</select>
//		<br />
//	
//		  <input type='submit' name='Submit' value='Добавить в список' />";

		  
		 //echo " </td>";

		echo "<td width='40%' valign='top' align='center'>Счёт:<br /> ";
		
		
		
		
		//echo $_SESSION['countm'][$_GET['count']];
		if ($_SESSION['countm'][$_GET['count']]>0)
		{
//			$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
//			for($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
//			{
//				if ($i==1) $query = $query."'".$_SESSION['chek'][$_GET['count']][$i][1]."'";
//				else $query = $query.",'".$_SESSION['chek'][$_GET['count']][$i][1]."'";
//			}
//			$query = $query.")";
//			////////echo $query."<br />";
//			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//			if ($count>15) echo "<select name='chek' size='15'>";
//			else echo "<select name='chek' size='".$count."'>";
//			$_SESSION['summ'][$_GET['count']]=0;
//			for ($i=1;$i<=$count;$i++)
//			{
//				$row = mysqli_fetch_array($result);
//				$N=$row['manip'];
//				while (strlen($N)<=30) 
//				{
//				$N=$N."_";
//				}
//				$N=$N.$row['price']."*".$_SESSION['chek'][$_GET['count']][$i][2]."=".($row['price']*$_SESSION['chek'][$_GET['count']][$i][2])."руб.";
//				echo "<option value=".$row['id'].">".$N."</option>";
//				$_SESSION['summ'][$_GET['count']]=$_SESSION['summ'][$_GET['count']]+($row['price']*$_SESSION['chek'][$_GET['count']][$i][2]);
//			}
//			echo "</select> <br />";
			echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($_SESSION['summ'][$_GET['count']]);
			for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$_SESSION['chek'][$_GET['count']][$i][3]."<br />
				<a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&chek=".$_SESSION['chek'][$_GET['count']][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
</td>
				<td width='10%' align='center'>".$_SESSION['chek'][$_GET['count']][$i][2]."<br />
<a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
				<td width='12%' align='center'>".$_SESSION['chek'][$_GET['count']][$i][4]." руб.</td>
				<td width='10%' align='center'>".($_SESSION['chek'][$_GET['count']][$i][2]*$_SESSION['chek'][$_GET['count']][$i][4])." руб.</td>
			  </tr>";
			$_SESSION['summ'][$_GET['count']]+=$_SESSION['chek'][$_GET['count']][$i][2]*$_SESSION['chek'][$_GET['count']][$i][4];	
			} 
			echo "</table>";
			echo "<div align='right'>Итого: ".$_SESSION['summ'][$_GET['count']]." руб. </div>";
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION['pat']."'))" ;
			//////echo $query."<br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			if ($count>0)
			{
				$row = mysqli_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".
				round(($_SESSION['summ'][$_GET['count']]-($_SESSION['summ'][$_GET['count']]*$row[0])/100),-1)." руб.</div>";
				$ck=$row[0];
			}
			else
			{
				$ck=0;
			}
			if ($_SESSION['QZub']>1)
			{
				$os=0;
				for($i=1;$i<=$_GET['count'];$i++) 
				{
					$os=$os+($_SESSION['summ'][$i]);
				}
			echo "<div align='right'>Общая сумма: ".round(($os-($os*$ck)/100),-1)." руб.</div>";				
			}
		  //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
//		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
//		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
		}
		else echo "&nbsp";
		echo "<input name='act' type='hidden' value='add' />";
		echo "<input name='step' type='hidden' value='4' />";
		echo "<input name='action' type='hidden' value='lech' />
		  </td>
	  </tr>
	</table>
	</td>
	  </tr>
	</table>";
		echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center><br />";
echo "Код: <input name='code' id='code' type='text' size='5' onKeyUp='findС(this)'/><br />";
//$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
if (($_GET['code']=="") or (!(isset($_GET['code']))) )
{
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by range, manip";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$cc=0;
		$cm=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($row['cat']==1)
				{
					$cc++;
					$cat[$cc]['id']=$row['id'];
					$cat[$cc]['manip']=$row['manip'];
					
				}
				else
				{
					$cm++;
					$mat[$cm]['id']=$row['id'];
					$mat[$cm]['manip']=$row['manip'];
					$mat[$cm]['price']=$row['price'];
					$mat[$cm]['UpId']=$row['UpId'];
				}
			}
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			<!--document.onclick = clickHandler;--> 
			</script>";
		for($i=1;$i<=$cc;$i++)
			{
				echo "
			<SPAN id='Out".$i."' class='mmenuHand'>".$cat[$i]['manip']."</SPAN><br />
	<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
		<table width='80%' border='0'>
    ";
				
				for($j=1;$j<=$cm;$j++)
				{
				
					if ($cat[$i]['id']==$mat[$j]['UpId'])
					echo "<tr>
        <td width='85%'><a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&manip=".$mat[$j]['id']."&act=add' class='small'>". $mat[$j]['manip']."</a></td>
        <td width='15%'>
		".$mat[$j]['price']."
		</td>
      </tr>";
				} 
				echo "</table></div>";
			}
}
else
{
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE( (preysk=".$preysk.")  AND (`range`='".$_GET['code']."' ))order by range, manip";
		////echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$cc=0;
		$cm=0;
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
	
					$cm++;
					$mat[$cm]['id']=$row['id'];
					$mat[$cm]['manip']=$row['manip'];
					$mat[$cm]['price']=$row['price'];
					$mat[$cm]['UpId']=$row['UpId'];
			}
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			<!--document.onclick = clickHandler;--> 
			</script>";

				echo "<table width='80%' border='0'>";
    
				
				for($j=1;$j<=$cm;$j++)
				{
				
					if ($cat[$i]['id']==$mat[$j]['UpId'])
					echo "<tr>
        <td width='85%'><a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&manip=".$mat[$j]['id']."&act=add' class='small'>". $mat[$j]['manip']."</a></td>
        <td width='15%'>
		".$mat[$j]['price']."
		</td>
      </tr>";
				} 
				echo "</table>";

}
			echo "</form>";
	//include("footer.php");
	exit;
	case "5":
		$_SESSION['lech'][$_GET['count']]=$_GET['lech'];
		echo "<div class='head3'>Пациент: ".$_SESSION['pat_name']."</div><hr width='100%' noshade='noshade' size='1'/>";
//		echo "Жалобы: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$zh=$_SESSION['NZub'][$i]." ".$_SESSION['zh'][$i]."<br />";	
//		}
//		echo $zh."<br />";
//		echo "Анамнез: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$an=$_SESSION['NZub'][$i]." ".$_SESSION['an'][$i]."<br />";	
//		}
//		echo $an."<br />";
//		echo "Объективно: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$obk=$_SESSION['NZub'][$i]." ".$_SESSION['obk'][$i]."<br />";	
//		}
//		echo $obk."<br />";
//		echo "Диагноз : ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//			$NZub=$_SESSION['NZub'][$i];
//			$dsZub=$_SESSION['dsZub'][$NZub];
//			$query = "Select Nazv from ds where id=".$dsZub;
//			//////////echo $query."<br />";
//			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//			$row = mysqli_fetch_array($result);
//			$ds=$ds.$NZub."-й зуб, ".$row['Nazv']."<br />";
//			echo $ds;
//		}
//		echo "<br />Лечение: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$lech=$_SESSION['NZub'][$i]." ".$_SESSION['lech'][$i]."<br />";	
//		}
//		echo $lech."<br />";
		//echo "Итого: ";
		$opl=0;
		$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION['pat']."'))" ;
		//////echo $query."<br>";
		//echo $opl." руб<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		for ($i=1;$i<=1;$i++)
		{	
			$opl=$opl+$_SESSION['summ'][$i];
			
			if ($count>0)
			{
				 
				//echo "Итого со скидкой: ".(($opl-round(($opl*$row[0])/100)))." руб<br />";
				$ck=$row['proc'];
			}
			else
			{
				$ck=0;
			}
		}
		//echo $_SESSION['NZub'][$i]." ".$_SESSION['zh'][$i]." ".$_SESSION['an'][$i]." ".$_SESSION['obk'][$i]." ".$_GET['lech'].$_SESSION['summ'][$i]."<br />";	
		//echo "Всатавка в Дневник<br>";
		$query = "INSERT INTO `dnev` (`id`, `vrach`,`pat`, `date`, `osm`, `ds`, `zh`, `an`, `obk`, `lech`, `resl`,`summ`, `summ_k_opl`, `summ_vnes`)
		VALUES (NULL, '".$_SESSION["UserID"]."','".$_SESSION['pat']."', '".date('Y-m-d')."', '0', ' ', ' ', ' ', ' ', ' ', 0,'".$opl."','".round((($opl-($opl*$ck)/100)),-1)."',0)" ;
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$query = "SELECT LAST_INSERT_ID()";
		//$query = "SELECT id FROM `dnev` WHERE
//		( (`pat`='".$_SESSION['pat']."') AND
//		(`date`='".date('Y-m-d')."') AND  
//		(`vrach`='".$_SESSION["UserID"]."') AND 
//		(`osm`='".$_SESSION['OsmID']."') AND 
//		(`ds`='".addslashes($ds)."') AND 
//		(`zh`='".addslashes($zh)."') AND 
//		(`an`='".addslashes($an)."') AND 
//		(`obk`='".addslashes($obk)."') AND 
//		(`lech`='".addslashes($lech)."') AND 
//		(`lech`='".addslashes($lech)."') AND 
//		(`resl`=0))";
		//////echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$pr=$row[0];
//		$query="INSERT INTO `ds_pr` (`id`, `ds`, `pr`,`NZub`) VALUES ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//			$NZub=$_SESSION['NZub'][$i];
//			$dsZub=$_SESSION['dsZub'][$NZub];
//			if ($i==1) $query=$query."(NULL,'".$dsZub."','".$pr."','".$NZub."')";
//			else $query=$query.", (NULL,'".$dsZub."','".$pr."','".$NZub."') ";
//		}
//		//echo "Всатавка в Диагнозы приёма<br>";
//		//////echo $query."<br>";
//		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//		$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION['pat']."'))" ;
//		//////echo $query."<br>";
//		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//		if ($count>0)
//			{
//				$ck=$row['proc'];
//				echo $ck."<br />";
//			}
//		else
//			{
//				$ck=0;
//			}
		//$query = "SELECT `id`,`manip`,`price` FROM `manip` WHERE `id` in (";
		$c=1;
		//$query = $query."'".$_SESSION['chek'][1][1][1]."'";
		$m[$c][1]=$_SESSION['chek'][1][1][1];
		$m[$c][2]=0;
		$m[$c][3]=$_SESSION['chek'][1][1][3];
		$m[$c][4]=$_SESSION['chek'][1][1][4];
		for ($i=1;$i<=1;$i++)
		{
			for ($j=1;$j<=$_SESSION['countm'][$i];$j++)
			{
				$f=0;
				for ($q=1;$q<=$c;$q++)
				{
					if ($m[$q][1]==$_SESSION['chek'][$i][$j][1])
					{
						
						$m[$q][2]+=$_SESSION['chek'][$i][$j][2];
						$f=1;
						//echo $m[$q][1]." ".$m[$q][2]."<br />";
					}		
				}
				if ($f==0) 
				{
					//$query = $query.",'".$_SESSION['chek'][$i][$j][1]."'";
					$c=$c+1;
					$m[$c][1]=$_SESSION['chek'][$i][$j][1];
					$m[$c][2]=$_SESSION['chek'][$i][$j][2];
					$m[$c][3]=$_SESSION['chek'][$i][$j][3];
					$m[$c][4]=$_SESSION['chek'][$i][$j][4];
					//echo $m[$c][1]." ".$m[$c][2]."<br />";
				}				
			}
		}
		//echo "Выбор из манипуляций<br>";
//		$query = $query.") ORDER by id";
//		////////echo $query."<br />";
//		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//		for ($i=1;$i<=$count;$i++)
//		{
//			$row = mysqli_fetch_array($result);
//			if ($m[$i][1]==$row['id']) 
//			{
//				$m[$i][3]=$row['price'];
//				$m[$i][4]=$row['manip'];
//			}
//			
//		}
//		
		$query = "INSERT INTO `manip_pr` (`id`, `NZuba`, `manip`, `kolvo`, `dnev`) VALUES";
		for ($i=1;$i<=1;$i++)
		{
			$NZub=0;
			for ($j=1;$j<=$_SESSION['countm'][$i];$j++)
			{
				if ($j==1)$query.="(NULL,'0','".$_SESSION['chek'][$i][$j][1]."','".$_SESSION['chek'][$i][$j][2]."','".$pr."')";
				else $query.=",(NULL,'0','".$_SESSION['chek'][$i][$j][1]."','".$_SESSION['chek'][$i][$j][2]."','".$pr."')";
			}
		}
		//echo "Вставка в Манипуляции при приёме<br>";
		//////echo $query."<br>";
		
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$query = "SELECT `id`, `mater`,`manip`, `mesto_hr` FROM `mater_avto_spis` WHERE `manip`in ( ";
		$s=0;
		for ($i=1;$i<=$c;$i++)
		{
			if ($i==1) $query.=$m[$i][1];
			else $query.=", ".$m[$i][1];
		}
		$query.=")";
		$ssk=($s-round($s*($ck/100)));		
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			for ($j=1;$j<=$c;$j++)
			{
				if ($m[$j][1]==$row['manip'])
				$query = "UPDATE `ost_mat`
				SET `ost`=`ost`-'".$m[$j][2]."'
				WHERE ((`mater`='".$row['mater']."') and
						(`mesto_hr`='".$row['mesto_hr']."'))";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			}
		}
		echo "<br />
		№ оплаты ".$pr."<br />
<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
			unset($s);
			for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
			{
				echo "  <tr>
				<td width='6%' align='center'>".$i."</td>
				<td width='62%' align='left'>".$m[$i][3]."</td>
				<td width='10%' align='center'>".$m[$i][2]."</td>
				<td width='12%' align='center'>".$m[$i][4]." руб.</td>
				<td width='10%' align='center'>".($m[$i][2]*$m[$i][4])." руб.</td>
			  </tr>";
			  $s+=$m[$i][2]*$m[$i][4];
			} 
			
				
			echo "</table>";
			echo "<div align='right'>Итого: ".$s." руб. </div>";
			$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION['pat']."'))" ;
			//////echo $query."<br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			if ($count>0)
			{
				$row = mysqli_fetch_array($result); 
				echo "<div align='right'>Итого со скидкой: ".
				round(($s-($s*$row[0])/100),-1)." руб.</div>";
			}
//		$query = "INSERT INTO `oplata` (`id`, `dnev`, `stoim`, `soimSoSk`, `vnes`, `dolg`, `VidOpl`) VALUES (NULL,'".$pr."','".$s."','".$ssk."',0,'".$ssk."',1)" ;
//		//echo "Всатавка в Оплату<br>";
//		//////echo $query."<br>";
//		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//	break;
//	echo "<a href='print.php?type=pat&card=".$pr."' target='_blank' class='mmenu'>Печать карты</a><br />"
//;
	echo "<a href='pat_tooday.php'class='mmenu'>Закрыть</a>";
unset($_SESSION['chek']);
	unset($_SESSION['countm']);
	unset($_SESSION['NZub']);
	unset($_SESSION['dsZub']);
	unset($_SESSION['QZub']);
	unset($_SESSION['pat']);
	unset($_SESSION['pat_name']);
	unset($_SESSION['zh']);
	unset($_SESSION['obk']);
	unset($_SESSION['lech']);
	unset($_SESSION['an']);
	unset($_SESSION['OsmID']);
	unset($_SESSION['summ']);	
break;
}
////////////Лечение зуба
//include("footer2.php");
?>