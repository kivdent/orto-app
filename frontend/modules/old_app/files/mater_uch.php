<?php

$this->title="Материалы"; 
$ThisVU="stms";
$js="spisok"; 
//include("header.php");
switch ($_GET['action'])
{
	case "addmat":
	switch ($_GET['step'])
		{
			case "0":
				switch ($_GET['subaction'])
					{
						case "del":
							if (!(isset($_SESSION['mater'])))
							{
								msg('Выбирите материал из списка');
								ret('mater_uch.php?action=addmat&step=0');
								exit;
							}
							$query = "SELECT `uch_mat_sootv`.`id`, `uch_mat_sootv`.`mater`
FROM  uch_mat_sootv
GROUP BY `uch_mat_sootv`.`mater`
ORDER BY `uch_mat_sootv`.`mater`";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$cid=0;
				for ($i=0;$i<$count;$i++)
				{
					if ($i==0)
					{
						if (isset($_GET['mater']))
						{
							$mater=$_GET['mater'];
						}
					}
					$row = mysqli_fetch_array($result);
					$cid++;
					if ($mater==$cid) 
					{
							$query = "DELETE FROM  uch_mat_sootv
WHERE `mater`='".$row['mater']."'";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					}
				}
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							ret('mater_uch.php?action=addmat&step=0');
						break;
					}
				echo "<center>Список материалов на учёте|Новый учёт|<a href='mater_uch.php?action=addmat&step=0'>Новый материал</a></center>";
				$query = "SELECT `uch_mat_sootv`.`id`, `uch_mat_sootv`.`mater`
FROM  uch_mat_sootv

GROUP BY `uch_mat_sootv`.`mater`
ORDER BY `uch_mat_sootv`.`mater`";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if (!($count>0))
				{
					echo "<div class=\"head1\">Нет материалов для контроля</div>
					<input name=''type='button' value='Добавить материал в список' onclick='location.href=\"mater_uch.php?action=addmat&step=1\"'/>";
					//include("footer.php");
					exit;
					
				}
				echo "<script type=\"text/JavaScript\">
						<!--
						function MM_jumpMenu2(targ,selObj,restore){ //v3.0
						  eval(targ+\".location='mater_uch.php?action=addmat&step=0&mater=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
						  if (restore) selObj.selectedIndex=0;
						}
						//-->
						</script>";
				echo "<form action=\"mater_uch.php\" method=\"get\">
				Список материалов для учёта:
				 <select name='mater' onchange=\"MM_jumpMenu2('parent',this,0)\">";
				
				$cid=0;
				for ($i=0;$i<$count;$i++)
				{
					if ($i==0)
					{
						if (isset($_GET['mater']))
						{
							$mater=$_GET['mater'];
						}
						else
						{
							$mater=1;
						}
					}
					$row = mysqli_fetch_array($result);
					$cid++;
					if ($mater==$cid) 
					{
						echo "<option value='".$cid."' selected='selected'>".$row['mater']."</option>";
						$_SESSION['mater']=$row['mater'];
					}
					else echo "<option value='".$cid."' >".$row['mater']."</option>";
				}
				echo "/<select><br />
				<input name=''type='button' value='Добавить материал в список' onclick='location.href=\"mater_uch.php?action=addmat&step=1\"'/>
				<input name=''type='button' value='Удалить материал из списка' onclick='location.href=\"mater_uch.php?action=addmat&step=0&subaction=del\"'/>
				<hr width='100%' noshade='noshade' size='1'/>";
				echo "Список отслеживаемых манипуляций:<br />";
				$query = "SELECT `manip`.`manip`, `uch_mat_sootv`.`id`
				FROM manip, uch_mat_sootv
				WHERE ((`manip`.`id` =`uch_mat_sootv`.`manip`) AND (`uch_mat_sootv`.`mater` ='".$_SESSION['mater']."'))";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<select name='manip' size='10'>";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					 echo "<option value='".$row['id']."' >".$row['manip']."</option>";
				}
				echo "</select><br />";
				if ($count>1)echo "<input name=''type='button' value='Удалить манипуляцию из списка' onclick='location.href=\"mater_uch.php?action=addmatsubaction=delman&step=0\"'/>";
				echo "<input name=''type='button' value='Добавить манипуляции' onclick='location.href=\"mater_uch.php?action=addmat&step=2&subaction=pred\"'/>";
				

				echo "</form>";
				//include("footer.php");
				exit;
			break;
			case "1":
			echo "<form action='mater_uch.php' method='get' id='addf' name='addf'><span class=\"head1\">Введите наименование материала или выбирите из списка</span><br />
";
			echo "<input name='mater' type='text' value='".$_SESSION['mater']."' id='mater'/>
			<input name=\"action\" type=\"hidden\" value=\"addmat\" />
			<input name=\"step\" type=\"hidden\" value=\"2\" />
			<input name=\"ok\" type=\"submit\" value=\"Дальше\" />
			</form>";
			$query = "SELECT `mater`.`id`, `mater`.`naim`, `mater`.`UpId`, `mater`.`Cat`
			FROM mater
			ORDER BY `mater`.`UpId` ASC, `mater`.`Cat` DESC";
			echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			echo "<TABLE BORDER=0 align='left'>";
				$cc=0;
				$cm=0;
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					if ($row['Cat']==1)
					{
						$cc++;
						$cat['$cc][id']=$row['id'];
						$cat['$cc][naim']=$row['naim'];
						
					}
					else
					{
						$cm++;
						$mat['$cm][id']=$row['id'];
						$mat['$cm][naim']=$row['naim'];
						$mat['$cm][UpId']=$row['UpId'];
						
					}
					
				}
				for($i=1;$i<=$cc;$i++)
				{
					echo "<TR><TD>
				<TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$cat['$i][naim']."</A><DIV>";
			
					for($j=1;$j<=$cm;$j++)
					{
					
					if ($cat['$i][id']==$mat['$j][UpId'])
						echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD><IMG SRC='image/leaf.gif'><a onclick=\"document.addf.mater.value='".$mat['$j][naim']."'\" class='small'>". $mat['$j][naim']."</a><DIV>
					 </DIV></TD></TR></TABLE>";
					} 
					echo "</DIV></TD></TR></TABLE>
			   </TR></TD>";
				}
			 
			echo "</TABLE>";
			//include("footer.php");
			exit;
			break;
			case "2":
			if (!(isset($_SESSION['mater']))) 
			{
				$_SESSION['mater']=$_GET['mater'];
			}
					$query = "SELECT `manip`.`manip`, `manip`.`id`
				FROM manip, uch_mat_sootv
				WHERE ((`manip`.`id` =`uch_mat_sootv`.`manip`) AND (`uch_mat_sootv`.`mater` ='".$_SESSION['mater']."'))";
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					if ($count>0)
					{
						
						for ($i=0;$i<$count;$i++)
						{
							$_SESSION['bil']=1;
							$row = mysqli_fetch_array($result);
							$_SESSION['QEl']=$i+1;
							$_SESSION['manip']['$_SESSION['QEl]'][id']=$row[1];
							$_SESSION['manip']['$_SESSION['QEl]'][manip']=$row[0];						
						}
					}
				
				
			
			switch ($_GET['subaction'])
			{
				case "pred":
					$_SESSION['pred']=1;
				break;
				case "add":
					if (!(isset($_SESSION['QEl'])))
					{
						$_SESSION['QEl']=1;
					}
					else
					{
						for ($i=1;$i<=$_SESSION['QEl'];$i++)
						{
							
							if ($_SESSION['manip']['$i][id']==$_GET['id'])
							{
							msg('Такая манипуляция есть в списке');
							ret('mater_uch.php?action=addmat&step=2&mater='.$_SESSION['mater']);
							exit;
							}
						}
						$_SESSION['QEl']+=1;
					}	
					
					$_SESSION['manip']['$_SESSION['QEl]'][id']=$_GET['id'];
					$query = "SELECT `manip` FROM `manip` WHERE `id`=".$_GET['id'];
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					$_SESSION['manip']['$_SESSION['QEl]'][manip']=$row['manip'];
					
				break;
				case "del":
					for ($i=$_GET['manip'];$i<=$_SESSION['QEl'];$i++)
						{
							$_SESSION['QEl']=$_SESSION['QEl']-1;
							$_SESSION['manip']['$i][id']=$_SESSION['manip']['$i+1][id'];
							$_SESSION['manip']['$i][manip']=$_SESSION['manip']['$i+1][manip'];
						}
				break;
				case "save":
				if ($_SESSION['bil']==1)
				{	
					$query = "DELETE FROM `uch_mat_sootv` WHERE `mater`='".$_SESSION['mater']."'";
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					unset($_SESSION['bil']);
				}
					for ($i=1;$i<=$_SESSION['QEl'];$i++)
						{	
							if ($i==1)
							{
								$query="INSERT INTO `uch_mat_sootv` (`id`, `mater`, `manip`) 
								VALUES (NULL, '".$_SESSION['mater']."','".$_SESSION['manip']['$i][id']."' )";
							}
							else
							{
								$query.=", (NULL, '".$_SESSION['mater']."','".$_SESSION['manip']['$i][id']."' )";
							}
						}
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					unset($_SESSION['mater']);
					unset($_SESSION['manip']);
					unset($_SESSION['QEl']);
					if ($_SESSION['pred']==1)
					{
						unset($_SESSION['pred']);
						ret('mater_uch.php?action=addmat&step=0');
						exit;
					}
					ret('mater_uch.php');
						exit;
				break;
			}
				echo "<form action='mater_uch.php' method='get' name='AddManipf' id='AddManipf'>
				<input name='subaction' type='hidden' value='del' />
				<input name='action' type='hidden' value='addmat' />
				<input name='step' type='hidden' value='2' /
				Выбранные манипуляции:<br />
		
<select name='manip' size='7'>";
for ($i=1;$i<=$_SESSION['QEl'];$i++)
{
	echo "<option value='".$i."'>".$_SESSION['manip']['$i][manip']."</option>";
}
echo "</select><br />
		<input name='del' type='submit' onclick='document.AddManipf.subaction.value=\"del\"' value='Удалить из списка'/><input name='save' type='submit' onclick='document.AddManipf.subaction.value=\"save\"' value='Сохранить список'/>
				</form> 
				<hr width='100%' noshade='noshade' size='1'/>"; 
				if (!($_GET['preysk']))
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
		  eval(targ+\".location='mater_uch.php?action=addmat&step=2&preysk=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
		  if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>
					<input name='action' type='hidden'  value='addmat'/>
					<input name='step' type='hidden'  value='2'/>
					Прейскурант:
					 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
					$query = "SELECT * FROM preysk";
					//echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						if ($preysk==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
						else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
					}
		
		echo "        </select>
		
		</form>
		<center>";
		echo "Манипуляции:";
		$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=".$preysk." order by manip";
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
		
		if ($cc>0)
		{
		echo "<TABLE BORDER=0 align='left'>";
		for($i=1;$i<=$cc;$i++)
			{
				echo "<TR><TD>
			<TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$cat['$i][manip']."</A><DIV><TABLE BORDER=0>";
				
				for($j=1;$j<=$cm;$j++)
				{
				
			if ($cat['$i][id']==$mat['$j][UpId'])
					echo "<TR><TD WIDTH=10></TD><TD><IMG SRC='image/leaf.gif'><a href='mater_uch.php?action=addmat&step=2&id=".$mat['$j][id']."&subaction=add' class='small'>". $mat['$j][manip']."</a></TD><td></td></TR>";
			} 
				echo "</TABLE></DIV></TD></TR>
			   </TABLE>
			   </TR></TD>";
			}

			echo "</TABLE>";
			}
			//include("footer.php");
			exit;
			break;
		}
	break;
	case "newuch":
		switch ($_GET['step'])
		{
			case "1":
				echo "
				<div class=\"head1\">Выбирите соотвествующие данные</div>
				<form action='mater_uch.php' method='get' name='AddManipf'>Дата выдачи";
				echo ":<select name='drD' id='drD'>";
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
					for ($i=1910; $i<date("Y")+1; $i++)
					{
					if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
					else echo "<option value='".$i."'>".$i."</option>";
					}
				echo "    </select>";
					echo "<br />Материал:";
 					$query = "SELECT `uch_mat_sootv`.`id`, `uch_mat_sootv`.`mater`
FROM mater, uch_mat_sootv
WHERE ((`mater`.`id` =`uch_mat_sootv`.`mater`) and (`mater`.`cat` =0))
ORDER BY `uch_mat_sootv`.`mater` ASC ";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);

				 echo "<select name='mater'>";
				$cid="";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$nid=$row['mater'];
					if ($i==0)
					{
						
						if (!(isset($_GET['mater'])))
						{
							$mater=$row['mater'];
						}
						else
						{
							$mater=$_GET['mater'];
						}						
					}
					if ($cid!=$nid)
					{
					$cid=$nid;
					echo "<option value='".$row['mater']."' >".$row['mater']."</option>";
					}
				}
				echo "</select><br />";
					echo "МОЛ:<select name='mol'>";
$query = "select id,surname,name,otch from `sotr` WHERE (dolzh=1) ORDER BY dolzh ASC" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<option value='0'>Все врачи</option>";
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}
echo "</select><br />
Стоимость выданного материала<input name=\"stoim\" type=\"text\" size='6'/>руб.
<br />
<input name='action' type='hidden'  value='newuch'/>
<input name='step' type='hidden'  value='2'/>
<input name='' type='submit' /value='Сохранить'></form> ";
//include("footer.php");
			exit;
			break;
			case "2":
				$dt=$_GET['drY']."-".$_GET['drM']."-".$_GET['drD'];
				$query = "INSERT INTO `uch_mat` (`id`, `mater`, `date`, `mol`,`stoim`) VALUES (`id`, '".$_GET['mater']."', '".$dt."', '".$_GET['mol']."', '".$_GET['stoim']."')";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('mater_uch.php');
			exit;
			break;
		}
	break;
	case "change":
		switch ($_GET['step'])
		{
			case "1":
				$query = "SELECT `mater`, `date`, `mol`, `stoim` FROM `uch_mat` WHERE `id`=".$_GET['id'];
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$rowA = mysqli_fetch_array($result);
				$dt=explode("-",$rowA['date']);
				echo "
				<div class=\"head1\">Измените соотвествующие данные</div>
				<form action='mater_uch.php' method='get' name='AddManipf'>Дата выдачи";
				echo ":<select name='drD' id='drD'>";
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
						if ($i==$dt[1]) echo "<option value='".$i."' selected='selected".$s;
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
					echo "<br />Материал:";
 					$query = "SELECT  `uch_mat_sootv`.`id`, `uch_mat_sootv`.`mater`
FROM  uch_mat_sootv
ORDER BY `uch_mat_sootv`.`mater` ASC ";
				echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);

				 echo "<select name='mater'>";
				$cid="";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$nid=$row['mater'];
					if ($i==0)
					{
						
						if (!(isset($_GET['mater'])))
						{
							$mater=$row['mater'];
						}
						else
						{
							$mater=$_GET['mater'];
						}						
					}
					if ($cid!=$nid)
					{
					$cid=$nid;
					if ($row['mater']==$rowA['mater']) echo "<option value='".$row['mater']."' selected='selected'>".$row['mater']."</option>";
					else echo "<option value='".$row['mater']."' >".$row['mater']."</option>";
					}
				}
				echo "/<select><br />";
					echo "МОЛ:<select name='mol'>";
$query = "select id,surname,name,otch from `sotr` WHERE (dolzh=1) ORDER BY dolzh ASC" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<option value='0'>Все врачи</option>";
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
if ($row['id']==$rowA['mol']) echo "<option value='".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
echo "<option value='".$row['id']."' >".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
}
echo "</select><br />
Стоимость выданного материала<input name=\"stoim\" type=\"text\" size='6' value='".$rowA['stoim']."'/>руб.
<br />
<input name='action' type='hidden'  value='change'/>
<input name='step' type='hidden'  value='2'/>
<input name='save' type='submit' /value='Сохранить'>
<input name='id' type='hidden' /value='".$_GET['id']."'>
<input name='del' type='submit' /value='Удалить'></form> ";
//include("footer.php");
			exit;
			break;
			case "2":
				if (isset($_GET['save']))
				{
				$dt=$_GET['drY']."-".$_GET['drM']."-".$_GET['drD'];
				$query = "UPDATE `uch_mat` 
							SET
							`mater`='".$_GET['mater']."', 
							`date`='".$dt."', 
							`mol`='".$_GET['mol']."',
							`stoim`='".$_GET['stoim']."'
							WHERE `id`=".$_GET['id'];
				echo $query."<br />";
				}
				if (isset($_GET['del']))
				{
				$dt=$_GET['drY']."-".$_GET['drM']."-".$_GET['drD'];
				$query = "DELETE FROM `uch_mat` 
							WHERE `id`=".$_GET['id'];
				echo $query."<br />";
				}
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret('mater_uch.php');
			exit;
			break;
		}
	break;
}

echo "<center>Список материалов на учёте||<a href='mater_uch.php?action=newuch&step=1'>Новый учёт</a>|<a href='mater_uch.php?action=addmat&step=0'>Новый материал</a></center>
		<form action='' method='get'>
          Материалы на текущем учёте:<br />";
	$query = "SELECT 
	`uch_mat`.`mater` , 
	`uch_mat`.`date` ,
	`uch_mat`.`id` , 
	`sotr`.`surname` , 
	`sotr`.`name` , 
	`sotr`.`otch` ,
	 sum( (`manip`.`price` * `manip_pr`.`kolvo`) ) AS SUMM, 
	 `uch_mat`.`stoim`
FROM uch_mat, sotr, dnev, manip, manip_pr, uch_mat_sootv
WHERE (
(
`dnev`.`date` >= `uch_mat`.`date` 
)
AND (
`dnev`.`date` <= '".date('Y-m-d')."'
)
AND (
`manip_pr`.`manip` = `uch_mat_sootv`.`manip` 
)
AND (
`uch_mat_sootv`.`mater` = `uch_mat`.`mater` 
)
AND (
`manip`.`id` = `manip_pr`.`manip` 
)
AND (
`manip_pr`.`dnev` = `dnev`.`id` 
)
AND (
`sotr`.`id` = `uch_mat`.`mol` 
)
AND (
`dnev`.`vrach` = `uch_mat`.`mol` 
)
AND (
`uch_mat`.`mol` != '0'
)

)
GROUP BY `uch_mat`.`id` 
";
	echo $query."<br />";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<table width='100%' border='1' cellspacing='0' cellpadding='1'>
            <tr>
              <td width='26%'  class='head2'>Материал</td>
              <td width='31%' class='head2'>МОЛ</td>
              <td width='10%' class='head2'>Дата выдачи</td>
              <td width='17%' class='head2'>Стоимость</td>
              <td width='16%' class='head2'>Выручка к текущей дате </td>
            </tr>";
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
			$dt=explode("-",$row['date']);
            echo "<tr>
              <td><a href=\"mater_uch.php?action=change&id=".$row['id']."&step=1\" class='mmenu'>".$row['mater']."</a></td>
              <td>".$row['surname']." ".$row['surname']." ".$row['surname']."</td>
              <td>".$dt[2]."-".$dt[1]."-".$dt[0]."</td>
              <td>".$row['stoim']."руб</td>
              <td>".$row['SUMM']."руб</td>
            </tr>";

			}
$query = "SELECT 
	`uch_mat`.`mater` , 
	`uch_mat`.`date` ,
	`uch_mat`.`id` , 
	 sum( (`manip`.`price` * `manip_pr`.`kolvo`) ) AS SUMM, 
	 `uch_mat`.`stoim`
FROM mater, uch_mat, dnev, manip, manip_pr, uch_mat_sootv
WHERE (
(
`dnev`.`date` >= `uch_mat`.`date` 
)
AND (
`dnev`.`date` <= '".date('Y-m-d')."'
)
AND (
`manip_pr`.`manip` = `uch_mat_sootv`.`manip` 
)
AND (
`uch_mat_sootv`.`mater` = `uch_mat`.`mater` 
)
AND (
`manip`.`id` = `manip_pr`.`manip` 
)
AND (
`manip_pr`.`dnev` = `dnev`.`id` 
)
AND (
`uch_mat`.`mol` = '0'
)
)
GROUP BY `uch_mat`.`id` 
";
	echo $query."<br />";	
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
			{
			$row = mysqli_fetch_array($result);
			$dt=explode("-",$row['date']);
            echo "<tr>
              <td><a href=\"mater_uch.php?action=change&id=".$row['id']."&step=1\" class='mmenu'>".$row['mater']."</a></td>
              <td>ВСЕ</td>
              <td>".$dt[2]."-".$dt[1]."-".$dt[0]."</td>
              <td>".$row['stoim']."руб</td>
              <td>".$row['SUMM']."руб</td>
            </tr>";

			}

          echo "</table>
          <br />
		</form>
";//include("footer.php");
?>