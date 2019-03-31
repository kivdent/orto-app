<?php
$ThisVU="stms";
$this->title="Списание материалов."; 
$js="spisok"; 
//include("header.php");

echo "<script language=\"JavaScript\" type=\"text/javascript\">
function AddEl(id,qp,v)
{
	q=prompt('Введите количество',qp);
	url='mater_spis.php?action=add&Q='+q+'&id='+id+'&varr='+v+'&qp='+qp;
	location.href=url;
}
function chQP(qp,max)
{
	if (document.prihf.Q.value>max)
	{	
		alert('Количество не может быть больше '+max);
		document.prihf.Q.value=max;
		document.prihf.QP.value=document.prihf.Q.value/qp;
	}
	else
	{
		document.prihf.QP.value=document.prihf.Q.value/qp;
	}
}
function chQ(qp,max)
{
	if (document.prihf.QP.value>max)
	{
		alert('Количество упаковок не может быть больше '+max);
		document.prihf.QP.value=max;
		document.prihf.Q.value=document.prihf.QP.value*qp;
	}
	else
	{
		document.prihf.Q.value=document.prihf.QP.value*qp;
	}
}
function EnterQ(id,max,q1)
{
	var q=prompt('Введите количество',q1);
	if (q>max) 
	{
		EnterQ(id,max,q1);
	}
	else
	{
	url='mater_spis.php?action=add&Q='+q+'&id='+id;
	location.href=url;
	}
}
function ChangeQ(id,max,q1)
{
	var q=prompt('Введите количество',q1);
	if (q>max) 
	{
		EnterQ(id,max,q1);
	}
	else
	{
	url='mater_spis.php?action=ch&Q='+q+'&id='+id;
	location.href=url;
	}
}
</script>";
switch ($_GET['action'])
{
	case "add":
		if (isset($_GET[Q]))
			{
				$_SESSION['Prih']['$_GET['id]'][Q']=$_GET[Q];
				ret('mater_spis.php');
				exit;
			}
		if (!(isset($_SESSION['QEl'])))
		{
			$_SESSION['QEl']=1;
		}
		else
		{	
			for ($i=1;$i<=$_SESSION['QEl'];$i++)
			{
				if ($_SESSION['Prih']['$i][id']==$_GET['id'])
				{
					msg('Такой материал уже есть в списке');
					ret('mater_spis.php');
					exit;
				}
			}
			$_SESSION['QEl']+=1;	
		}
		$_SESSION['Prih']['$_SESSION['QEl]'][id']=$_GET['id'];
		$query = "SELECT `mater`.`naim`, `edizm`.`abbr`
		FROM mater, edizm
		WHERE ((`edizm`.`id` =`mater`.`edizm`) AND (`mater`.`id` ='".$_GET['id']."'))";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$_SESSION['Prih']['$_SESSION['QEl]'][naim']=$row[0];
		$_SESSION['Prih']['$_SESSION['QEl]'][edizm']=$row[1];
		$_SESSION['Prih']['$_SESSION['QEl]'][varr']=$_GET['varr'];
		$_SESSION['Prih']['$_SESSION['QEl]'][qp']=$_GET['qp'];
		$_SESSION['Prih']['$_SESSION['QEl]'][max']=$_GET['max'];
		$_SESSION['Prih']['$_SESSION['QEl]'][Price']=$_GET['Price'];
		if ($_GET['varr']==1)
		{
			
			echo "
			<script language=\"JavaScript\" type=\"text/javascript\">
			EnterQ('".$_SESSION['QEl']."','".$_GET['max']."','".$_SESSION['Prih']['$_SESSION['QEl]'][qp']."')
			</script>";
		
		}
		else
		{
			echo "<form action='mater_spis.php' method='get' name='prihf' id='prihf'>
				<input name='action' type='hidden' value='add' />
				<input name='id' type='hidden' value='".$_SESSION['QEl']."' />
                <center>
                  Количество штук:
                    <input name='Q' type='text' id='Q' onKeyUp='chQP(\"".$_SESSION['Prih']['$_SESSION['QEl]'][qp']."\",\"".$_GET['max']."\")' value='".$_SESSION['Prih']['$_SESSION['QEl]'][qp']."'>
                    <br>
                   Количество упаковок:
                    <input name='QP' type='text' id='QP' onKeyUp='chQ(\"".$_SESSION['Prih']['$_SESSION['QEl]'][qp']."\",\"".($_GET['max']/$_SESSION['Prih']['$_SESSION['QEl]'][qp'])."\")'  value='1'>
<br />
                  <input name='save'  type='submit'  value='Сохранить' />
			 <hr width='100%' noshade='noshade' size='1'/>
              </center>
			  </form>";	
		}
		//include("footer.php");
		exit;
	break;
	case "del":
		for ($i=1;$i<=$_SESSION['QEl'];$i++)
		{
			if ($_SESSION['Prih']['$i][id']==$_GET['prih'])
			{
				$_SESSION['QEl']=$_SESSION['QEl']-1;
				for ($j=$i;$j<=$_SESSION['QEl'];$j++)
				{
					$_SESSION['Prih']['$j][id']=$_SESSION['Prih']['$j+1][id'];
					$_SESSION['Prih']['$j][Q']=$_SESSION['Prih']['$j+1][Q'];
					$_SESSION['Prih']['$j][naim']=$_SESSION['Prih']['$j+1][naim'];
					$_SESSION['Prih']['$j][edizm']=$_SESSION['Prih']['$j+1][edizm'];
					$_SESSION['Prih']['$j][varr']=$_SESSION['Prih']['$j+1][varr'];
					$_SESSION['Prih']['$j][qp']=$_SESSION['Prih']['$j+1][qp'];
					$_SESSION['Prih']['$j][Price']=$_SESSION['Prih']['$j+1][Price'];
					$_SESSION['Prih']['$j][max']=$_SESSION['Prih']['$j+1][max'];
				}
			}
		}
	break;
	case"ch":
			if (isset($_GET[Q]))
			{
				$_SESSION['Prih']['$_GET['id]'][Q']=$_GET[Q];
				ret('mater_spis.php');
			}
			for ($i=1;$i<=$_SESSION['QEl'];$i++)
			{
				if ($_SESSION['Prih']['$i][id']==$_GET['prih'])
				{
					$q=$_SESSION['Prih']['$i][Q'];
					$varr=$_SESSION['Prih']['$i][varr'];
					$id=$i;
					$i=$_SESSION['QEl'];
				}
			}
			if ($varr==1)
			{
				echo "
			<script language=\"JavaScript\" type=\"text/javascript\">
			ChangeQ('".$id."','".$_SESSION['Prih']['$id][max']."','".$q."')
			</script>";
			}
			else
			{
				echo "<form action='mater_spis.php' method='get' name='prihf' id='prihf'>
				<input name='action' type='hidden' value='ch' />
				<input name='id' type='hidden' value='".$id."' />
                <center>
                  Количество штук:
                    <input name='Q' type='text' id='Q' onKeyUp='chQP(\"".$_SESSION['Prih']['$id][qp']."\")' value='".$q."'>
                    <br>
                    Количество упаковок:
                    <input name='QP' type='text' id='QP' onKeyUp='chQ(\"".$_SESSION['Prih']['$id][qp']."\")'  value='".($q/$_SESSION['Prih']['$id][qp'])."'>
<br />
                  <input name='save'  type='submit'  value='Изменить количество' />
			 <hr width='100%' noshade='noshade' size='1'/>
              </center>
			  </form>";	
			}
		//include("footer.php");
		exit;
	break;
	case "save":
		$query = "INSERT INTO `mater_spis` 
(`id`, `date`, `mesto_hr`)
 VALUES 
 (NULL, '".date('Y-m-d')."','".$_GET['mesto_hr']."')";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "SELECT LAST_INSERT_ID()";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		////Составление списка списания
		$vid=$row[0];
		$query = "INSERT INTO `mater_spis_soot` 
(`id`, `mater_spis`, `mater`, `kolvo`)
		VALUES ";
		for ($i=1;$i<=$_SESSION['QEl'];$i++)
		{
			if ($i==1)  $query.="(NULL, '".$vid."', '".$_SESSION['Prih']['$i][id']."', '".$_SESSION['Prih']['$i][Q']."')";
			else $query.=", (NULL,'".$vid."', '".$_SESSION['Prih']['$i][id']."', '".$_SESSION['Prih']['$i][Q']."')";
		}
		////////echo $query."<br />";
		
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		////Добавление материалов на склад
		$query = "SELECT `ost_mat`.`id`, `ost_mat`.`ost`, `ost_mat`.`mater`
					FROM mesta_hr, ost_mat
					WHERE ((`mesta_hr`.`id` ='".$_GET['mesto_hr']."') AND (`ost_mat`.`mesto_hr` =`mesta_hr`.`id`))";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>0)
		{
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$ost_mat['$row['mater]'][id']=$row[0];
				$ost_mat['$row['mater]'][ost']=$row['ost'];
				$Mesto_hr=$_GET['mesto_hr'];
			}
		}
		else
		{
			$Mesto_hr=$_GET['mesto_hr'];
		}
		for ($i=1;$i<=$_SESSION['QEl'];$i++)
		{
			$query="1";
			if (isset($ost_mat['$_SESSION[Prih']['$i]['id]'][ost']))
			{
				$query = "
					UPDATE ost_mat
					SET ost=".($ost_mat['$_SESSION[Prih']['$i]['id]'][ost']-$_SESSION['Prih']['$i][Q'])." 
					WHERE id=".$ost_mat['$_SESSION[Prih']['$i]['id]'][id'];
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			}	
		}	
		echo "<a href='print.php?type=prih'>Печать накладной</a>";
		unset($_SESSION['Prih']);
		unset($_SESSION['QEl']);
		unset($_SESSION['cc']);
		unset($_SESSION['cm']);
		unset($_SESSION['cat']);
		unset($_SESSION['mat']);
		exit;
	break;
}

echo "<form action='mater_spis.php' method='get' name='prihf' id='prihf'>
			  <span class='head3'>Списание материалов:</span> <br />
			  <center>
			  Место хранения:<br />
";
			$query = "SELECT * 
FROM `mesta_hr`";



			//////////echo $query."<br />";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			echo "<script type=\"text/JavaScript\">
						<!--
						function MM_jumpMenu2(targ,selObj,restore){ //v3.0
						  eval(targ+\".location='mater_spis.php?mesto_hr=\"+selObj.options['selObj.selectedIndex'].value+\"'\");
						  if (restore) selObj.selectedIndex=0;
						}
						//-->
						</script>";
			  echo "<select name='mesto_hr' onchange=\"MM_jumpMenu2('parent',this,0)\">";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					if ($i==0)
					{
						if (isset($_GET['mesto_hr']))
						{
							$mesto_hr=$_GET['mesto_hr'];
						}
						else
						{
							$mesto_hr=$row['id'];
						}
					}
					if ($row['id']==$mesto_hr) echo "<option value='".$row['id']."' selected='selected'>".$row['nazv']."</option>";
					else  echo "<option value='".$row['id']."'>".$row['nazv']."</option>";
				}
			  echo "</select><br />";
			  //echo "//Списание материалов:<br />

//			   <select name='prih' id='prih' size='5'>";
//for ($i=1;$i<=$_SESSION['QEl'];$i++)
//	{
//		$print=$_SESSION['Prih']['$i][naim'];
//		while (strlen($print)<=40)
//		{
//			$print.=".";
//		}
//		$print.=$_SESSION['Prih']['$i][Q'].$_SESSION['Prih']['$i][edizm'];
//		while (strlen($print)<=60)
//		{
//			$print.=".";
//		}
//		$print.=($_SESSION['Prih']['$i][Price']*$_SESSION['Prih']['$i][Q'])."руб.";
//		echo "<option value='".$_SESSION['Prih']['$i][id']."'>".$print."</option> ";
//	}
//echo "</select><input name='action' type='hidden' value='del' />";
echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='30%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
				<td width='19%'><div align='center' class='feature3'>Действие</div></td>
			  </tr>";

			for ($i=1;$i<=$_SESSION['QEl'];$i++)
			{
				echo "  <tr class='bottom'>
				<td align='center'>".$i."</td>
				<td align='left' '>".$print=$_SESSION['Prih']['$i][naim']."</td>
				<td align='center'>".$_SESSION['Prih']['$i][Q'].$_SESSION['Prih']['$i][edizm']."</td>
				<td align='center'>".$_SESSION['Prih']['$i][Price']." руб.</td>
				<td align='center'>".($_SESSION['Prih']['$i][Price']*$_SESSION['Prih']['$i][Q'])." руб.</td>
				<td align='center'><a href=\"mater_order.php?action=del&prih=".$_SESSION['Prih']['$i][id']."\" class='menu2'>Удалить</a>
				</br><a href=\"mater_order.php?action=ch&prih=".$_SESSION['Prih']['$i][id']."\" class='menu2'>Изменить количество</a></td>
			  </tr>";
			$_SESSION['summ']['$_GET['count']']+=$_SESSION['chek']['$_GET['count']']['$i][2']*$_SESSION['chek']['$_GET['count']']['$i][4'];	
			} 
			echo "</table>";
echo "
              <br />
			  <input name='save'  type='submit'  value='Сохранить' onclick='document.prihf.action.value=\"save\"'/>
			 <hr width='100%' noshade='noshade' size='1'/>
              </center>
			  </form>";
$query = "SELECT 
`mater`.`UpId` ,
 `mater`.`Cat` , 
 `mater`.`id` ,
  `mater`.`naim` ,
   `mater`.`QPack` , 
   `mater`.`QPrice` , 
   `mater`.`Price` , 
   `edizm`.`abbr` , 
   `ost_mat`.`ost` 

FROM mesta_hr, ost_mat, mater, edizm
WHERE (
(
`mesta_hr`.`id` ='".$mesto_hr."'
)
AND (
`ost_mat`.`mesto_hr` = `mesta_hr`.`id` 
)
AND (
`mater`.`id` = `ost_mat`.`mater` 
)
AND (
`edizm`.`id` = `mater`.`edizm` 
)
)
ORDER BY `mater`.`UpId` ASC, `mater`.`Cat` DESC";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//echo "<TABLE BORDER=0 align='left'>";
	$_SESSION['cm']=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
			$_SESSION['cm']++;
			$_SESSION['mat']['$_SESSION['cm]'][id']=$row['id'];
			$_SESSION['mat']['$_SESSION['cm]'][naim']=$row['naim'];
			$_SESSION['mat']['$_SESSION['cm]'][UpId']=$row['UpId'];
			$_SESSION['mat']['$_SESSION['cm]'][qpack']=$row['QPack'];
			$_SESSION['mat']['$_SESSION['cm]'][ost']=$row['ost'];
			$_SESSION['mat']['$_SESSION['cm]'][abbr']=$row['abbr'];
			$_SESSION['mat']['$_SESSION['cm]'][Price']=$row['Price'];
			if ($row['QPack']==1) $_SESSION['mat']['$_SESSION['cm]'][varr']=1;
			else $_SESSION['mat']['$_SESSION['cm]'][varr']=2;	
	}
	
$query = "SELECT `id`, `naim` FROM `mater` WHERE `Cat`=1";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$_SESSION['cc']=0;	
for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			$_SESSION['cc']++;
			$_SESSION['cat']['$_SESSION['cc]'][id']=$row['id'];
			$_SESSION['cat']['$_SESSION['cc]'][naim']=$row['naim'];
			
		}

//for($i=1;$i<=$_SESSION['cc'];$i++)
//	{
//		echo "<TR><TD>
 //   <TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$_SESSION['cat']['$i][naim']."</A><DIV>";

//		for($j=1;$j<=$_SESSION['cm'];$j++)
//		{
		
//		if ($_SESSION['cat']['$i][id']==$_SESSION['mat']['$j][UpId'])
//			echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD widht=150><IMG SRC='image/leaf.gif'><a href='mater_spis.php?action=add&id=".$_SESSION['mat']['$j][id']."&varr=".$_SESSION['mat']['$j][varr']."&qp=".$_SESSION['mat']['$j][qpack']."&max=".$_SESSION['mat']['$j][ost']."&Price=".$_SESSION['mat']['$j][Price']."' class='small'>". $_SESSION['mat']['$j][naim']."</a><DIV>
 //        </DIV></TD><td widht=15></td><td widht=150>".$_SESSION['mat']['$j][ost']." 
//			".$_SESSION['mat']['$j][abbr']."</td></TR></TABLE>";
//		} 
//		echo "</DIV></TD></TR></TABLE>
 //  </TR></TD>";
//	}
 
//echo "</TABLE>";

echo "<script language=\"JavaScript\" type=\"text/javascript\">
			document.onclick = clickHandler; 
			</script>";
		for($i=1;$i<=$_SESSION['cc'];$i++)
			{
				echo "
			<SPAN id='Out".$i."' class='mmenuHand'>".$_SESSION['cat']['$i][naim']."</SPAN><br />
	<div id=Out".$i."details style=\"display:None; position:relative; left:12;\">
		<table width='80%' border='0'>";
				for($j=1;$j<=$_SESSION['cm'];$j++)
				{
					if ($_SESSION['cat']['$i][id']==$_SESSION['mat']['$j][UpId'])
					echo "<tr>
        <td width='85%'><a href='mater_spis.php?action=add&id=".$_SESSION['mat']['$j][id']."&varr=".$_SESSION['mat']['$j][varr']."&qp=".$_SESSION['mat']['$j][qpack']."&max=".$_SESSION['mat']['$j][ost']."&Price=".$_SESSION['mat']['$j][Price']."' class='small'>". $_SESSION['mat']['$j][naim']."</a></td>
        <td width='15%'>
	".$_SESSION['mat']['$j][ost']." 
			".$_SESSION['mat']['$j][abbr']."
		</td>
      </tr>";
				} 
				echo "</table></div>";
			}
//include("footer.php");
?>