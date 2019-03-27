<?php
$ThisVU="stms";
$js="spisok";
$ModName="Соответствия материалов для автосписания"; 
include("header.php");
switch ($_GET['action'])
{
	case "addmat":
	switch ($_GET['step'])
		{
			case "1":
			echo "<form action='mater_sootv.php' method='get' id='addf' name='addf'><span class=\"head1\">Введите  материал</span><br />
			<input name=\"action\" type=\"hidden\" value=\"addmat\" />
			<input name=\"step\" type=\"hidden\" value=\"2\" />
			</form>";
			$query = "SELECT `mater`.`id`, `mater`.`naim`, `mater`.`UpId`, `mater`.`Cat`
			FROM mater
			ORDER BY `mater`.`UpId` ASC, `mater`.`Cat` DESC";
			//////////echo $query."<br />";
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
						echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD><IMG SRC='image/leaf.gif'><a href='mater_sootv.php?action=addmat&step=2&mater=".$mat['$j][id']."' class='small'>".$mat['$j][naim']."</a><DIV>
					 </DIV></TD></TR></TABLE>";
					} 
					echo "</DIV></TD></TR></TABLE>
			   </TR></TD>";
				}
			 
			echo "</TABLE>";
			include("footer.php");
			exit;
			break;
			case "2":
			if (!(isset($_SESSION['mater']))) 
			{
				$_SESSION['mater']=$_GET['mater'];
			}
					$query = "SELECT `manip`.`manip`, `manip`.`id`
				FROM manip, mater_avto_spis
				WHERE ((`manip`.`id` =`mater_avto_spis`.`manip`) AND (`mater_avto_spis`.`mater` ='".$_SESSION['mater']."'))";
					////////echo $query."<br />";
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
							ret('mater_sootv.php?action=addmat&step=2&mater='.$_SESSION['mater']);
							exit;
							}
						}
						$_SESSION['QEl']+=1;
					}	
					
					$_SESSION['manip']['$_SESSION['QEl]'][id']=$_GET['id'];
					$query = "SELECT `manip` FROM `manip` WHERE `id`=".$_GET['id'];
					////////echo $query."<br />";
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
					$query = "DELETE FROM mater_avto_spis WHERE `mater`='".$_SESSION['mater']."'";
					////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					unset($_SESSION['bil']);
				}
					for ($i=1;$i<=$_SESSION['QEl'];$i++)
						{	
							if ($i==1)
							{
								$query="INSERT INTO mater_avto_spis (`id`, `mater`, `manip`,`mesto_hr`) 
								VALUES (NULL, '".$_SESSION['mater']."','".$_SESSION['manip']['$i][id']."','".$_GET['mesto_hr']."' )";
							}
							else
							{
								$query.=", (NULL, '".$_SESSION['mater']."','".$_SESSION['manip']['$i][id']."','".$_GET['mesto_hr']."' )";
							}
						}
					////////echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					unset($_SESSION['mater']);
					unset($_SESSION['manip']);
					unset($_SESSION['QEl']);
					unset($_SESSION['pred']);
					ret('mater_sootv.php');
					exit;
				break;
			}
				echo "<form action='mater_sootv.php' method='get' name='AddManipf' id='AddManipf'>
				<input name='subaction' type='hidden' value='del' />
				<input name='action' type='hidden' value='addmat' />";
				echo "<input name='step' type='hidden' value='2' />
				Место хранения:";
				$query = "SELECT `id`, `nazv`, `mol` FROM `mesta_hr`";
		//////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		 echo "<select name='mesto_hr' id='mesto_hr'>";
		 for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			if ($_GET['mesto_hr']==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['nazv']."</option>";
			else echo "<option value='".$row['id']."'>".$row['nazv']."</option>";
	        }
					echo "</select><br />
	
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
			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			$preysk=$row[0];
		} 
		else $preysk=$_GET['preysk'];
		echo "
					<form action='' method='get'><script type=\"text/JavaScript\">
		<!--
		function MM_jumpMenu(targ,selObj,restore){ //v3.0
		  eval(targ+\".location='mater_sootv.php?action=addmat&step=2&preysk=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
		  if (restore) selObj.selectedIndex=0;
		}
		//-->
		</script>
					<input name='action' type='hidden'  value='addmat'/>
					<input name='step' type='hidden'  value='2'/>
					Прейскурант:
					 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
					$query = "SELECT * FROM preysk";
					////////////echo $query."<br />";
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
		//////////echo $query."<br />";
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
					echo "<TR><TD WIDTH=10></TD><TD><IMG SRC='image/leaf.gif'><a href='mater_sootv.php?action=addmat&step=2&id=".$mat['$j][id']."&subaction=add' class='small'>". $mat['$j][manip']."</a></TD><td></td></TR>";
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
	break;
}

switch ($_GET['subaction'])
					{
						case "del":
							if (!(isset($_SESSION['mater'])))
							{
								msg('Выбирите материал из списка');
								ret('mater_sootv.php?action=addmat&step=0');
								exit;
							}
							$query = "DELETE FROM  uch_mat_sootv
WHERE `mater`='".$row['mater']."'";
							////////echo $query."<br />";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							ret('mater_sootv.php?action=addmat&step=0');
					break;
					}
				$query = "SELECT `mater`.`naim`, `mater_avto_spis`.`id`,`mater_avto_spis`.`mater`,`mesta_hr`.`nazv`
FROM mater, mater_avto_spis, mesta_hr

WHERE ((`mater`.`id` =`mater_avto_spis`.`mater`) AND (`mesta_hr`.`id`=`mater_avto_spis`.`mesto_hr`))

GROUP BY `mater_avto_spis`.`mater`
ORDER BY `mater_avto_spis`.`mater`";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if (!($count>0))
				{
					echo "<div class=\"head1\">Нет материалов для контроля</div>
					<input name=''type='button' value='Добавить материал в список' onclick='location.href=\"mater_sootv.php?action=addmat&step=1\"'/>";
					include("footer.php");
					exit;
					
				}
				echo "<script type=\"text/JavaScript\">
						<!--
						function MM_jumpMenu2(targ,selObj,restore){ //v3.0
						  eval(targ+\".location='mater_sootv.php?action=addmat&step=0&mater=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
						  if (restore) selObj.selectedIndex=0;
						}
						//-->
						</script>";
				 
				echo "<form action=\"mater_sootv.php\" method=\"get\">
				Список материалов для учёта:
				 <select name='mater' onchange=\"MM_jumpMenu2('parent',this,0)\">";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					if ($i==0)
					{
						if (isset($_GET['mater']))
						{
							$mater=$_GET['mater'];
						}
						else
						{
							$mater=$row['mater'];
						}
					}
					if ($mater==$row['mater']) 
					{
						echo "<option value='".$row['mater']."' selected='selected'>".$row['naim']."</option>";
						$MH=$row['nazv'];
					}
					else echo "<option value='".$row['mater']."' >".$row['naim']."</option>";
				}
				
				echo "</select><br />
				Место хранения: ".$MH."<br />
				<input name=''type='button' value='Добавить материал в список' onclick='location.href=\"mater_sootv.php?action=addmat&step=1\"'/>
				<input name=''type='button' value='Удалить материал из списка' onclick='location.href=\"mater_sootv.php?action=addmat&step=0&subaction=del\"'/>
				<hr width='100%' noshade='noshade' size='1'/>";
				echo "Список отслеживаемых манипуляций:<br />";
				$query = "SELECT `manip`.`manip`, `mater_avto_spis`.`id`
				FROM manip, mater_avto_spis
				WHERE ((`manip`.`id` =`mater_avto_spis`.`manip`) AND (`mater_avto_spis`.`mater` ='".$mater."'))";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "<select name='manip' size='10'>";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					 echo "<option value='".$row['id']."' >".$row['manip']."</option>";
				}
				echo "</select><br />";
				if ($count>1)echo "<input name=''type='button' value='Удалить манипуляцию из списка' onclick='location.href=\"mater_sootv.php?action=addmatsubaction=delman&step=0\"'/>";
				echo "<input name=''type='button' value='Добавить манипуляции' onclick='location.href=\"mater_sootv.php?action=addmat&step=2&subaction=pred&mater=".$mater."\"'/>";
				
				echo "</form>";
include("footer.php");
?>