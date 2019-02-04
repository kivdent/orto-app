<?php
$ThisVU="stms";
$ModName="Составление заявки"; 
$js="spisok";  
include("header.php");
echo "<script language=\"JavaScript\" type=\"text/javascript\">
function AddEl(id,qp,v)
{
	q=prompt('Введите количество',qp);
	url='mater_order.php?action=add&Q='+q+'&id='+id+'&varr='+v+'&qp='+qp;
	location.href=url;
}
function chQP(qp,max)
{

		document.prihf.QP.value=document.prihf.Q.value/qp;
}
function chQ(qp,max)
{

		document.prihf.Q.value=document.prihf.QP.value*qp;
}
function EnterQ(id,max,q1)
{
	var q=prompt('Введите количество',q1);
	url='mater_order.php?action=add&Q='+q+'&id='+id;
	location.href=url;
}

</script>";
switch ($_GET['action'])
{
	case "add":
		if (isset($_GET[Q]))
			{
				$_SESSION['Prih']['$_GET['id]'][Q']=$_GET[Q];
				ret('mater_order.php');
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
					ret('mater_order.php');
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
		$_SESSION['Prih']['$_SESSION['QEl]'][Price']=$_GET['price'];
		$_SESSION['Prih']['$_SESSION['QEl]'][newm']=0;
		if ($_GET['varr']==1)
		{
			
			echo "
			<script language=\"JavaScript\" type=\"text/javascript\">
			EnterQ('".$_SESSION['QEl']."','".$_GET['max']."','".$_SESSION['Prih']['$_SESSION['QEl]'][qp']."')
			</script>";
		}
		else
		{
			echo "<form action='mater_order.php' method='get' name='prihf' id='prihf'>
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
		include("footer.php");
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
					$_SESSION['Prih']['$j][newm']=$_SESSION['Prih']['$j+1][newm'];
				}
			}
		}
	break;
	case"ch":
			if (isset($_GET[Q]))
			{
				$_SESSION['Prih']['$_GET['id]'][Q']=$_GET[Q];
				ret('mater_order.php');
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
				echo "<script language=\"JavaScript\" type=\"text/javascript\">
					q=prompt('Введите количество','".$q."');
					url='mater_order.php?action=ch&Q='+q+'&id=".$id."';
					location.href=url;
					</script>";	
			}
			else
			{
				echo "<form action='mater_order.php' method='get' name='prihf' id='prihf'>
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
		include("footer.php");
		exit;
	break;
	case "save":
		$query = "INSERT INTO `mater_order` (`id`, `date`) VALUES (NULL, '".date('Y-m-d')."')";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "SELECT LAST_INSERT_ID()";
		////////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$order=$row[0];
//		INSERT INTO `mater_order_sootv` 
//(`id`, `mater_order`, `mater`, `kolvo`, `new`) 
//VALUES (`id`, `mater_order`, `mater`, `kolvo`, `new`)
		$query = "INSERT INTO `mater_order_sootv` 
(`id`, `mater_order`, `mater`,`mater_name`, `kolvo`,`price`, `new`) 
VALUES ";
		$query1 = "INSERT INTO `mater_order_sootv` 
(`id`, `mater_order`, `mater`,`mater_name`, `kolvo`, `price`, `new`) 
VALUES ";
		$new=0;
		for ($i=1;$i<=$_SESSION['QEl'];$i++)
		{
			if ($_SESSION['Prih']['$i][newm']==0)
			{
				if ($i==1)  $query.="(NULL,
									'".$order."', 
									'".$_SESSION['Prih']['$i][id']."', 
									'0',
									'".$_SESSION['Prih']['$i][Q']."', 
									'".$_SESSION['Prih']['$i][Price']."',
									'0')";
				else $query.=", (NULL,
									'".$order."', '".$_SESSION['Prih']['$i][id']."', 
									'0',
									'".$_SESSION['Prih']['$i][Q']."', 
									'".$_SESSION['Prih']['$i][Price']."',
									'0')";
			}
			else
			{
				$new=1;
				if ($i==1)  $query.="(NULL,
									'".$order."', 
									'0',
									'".$_SESSION['Prih']['$i][naim']."',
									'".$_SESSION['Prih']['$i][Q']."', 
									'".$_SESSION['Prih']['$i][Price']."',
									'1')";
				else $query.=", (NULL,
									'".$order."', 
									'0',
									'".$_SESSION['Prih']['$i][naim']."',
									'".$_SESSION['Prih']['$i][Q']."', 
									'".$_SESSION['Prih']['$i][Price']."',
									'1')";
			}
		}
		////////echo $query."<br />";
		
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		
		echo "<a href='print.php?type=order'>Печать заявки</a>";
		unset($_SESSION['Prih']);
		unset($_SESSION['QEl']);
		unset($_SESSION['cc']);
		unset($_SESSION['cm']);
		unset($_SESSION['cat']);
		unset($_SESSION['mat']);
		ret('http://orto/mater_order.php');
	break;
	case "newmat":
		switch ($_GET['step'])
		{
			case "1":
				echo "<form name='card' id='card'>
				<input name='action' type='hidden' value='newmat'>
				<input name='step' type='hidden' value='2'>
		  Название: 
		      <input name='mater' type='text' id='mater' size='60' />
		      <br />
		      Цена за ед.:
		      <input name='Price' type='text' id='Price' size='6' />
		      <br />
		      Количество.:
		      <input name='kolvo' type='text' id='kolvo' size='5' />
		      <br />
		      <input type='submit' name='Submit' value='Добавить' />
		    </form>	";
			include("footer.php");
				exit;
			break;
			case "2":
				if (!(isset($_SESSION['QEl'])))
				{
					$_SESSION['QEl']=1;
				}
				else
				{	
					$_SESSION['QEl']+=1;	
				}
				$_SESSION['Prih']['$_SESSION['QEl]'][id']=0;
				$_SESSION['Prih']['$_SESSION['QEl]'][naim']=$_GET['mater'];
				$_SESSION['Prih']['$_SESSION['QEl]'][edizm']='';
				$_SESSION['Prih']['$_SESSION['QEl]'][varr']=1;
				$_SESSION['Prih']['$_SESSION['QEl]'][qp']=1;
				$_SESSION['Prih']['$_SESSION['QEl]'][max']=$_GET['kolvo'];
				$_SESSION['Prih']['$_SESSION['QEl]'][Price']=$_GET['Price'];
				$_SESSION['Prih']['$_SESSION['QEl]'][newm']=1;
				$_SESSION['Prih']['$_SESSION['QEl]'][Q']=$_GET['kolvo'];
			break;
		}
	break;
}

echo "<form action='mater_order.php' method='get' name='prihf' id='prihf'>
			  <span class='head3'>Составление завки:</span> <br />
			  <center>
			 Заявка<br />

			   <select name='prih' id='prih' size='5'>";
			   
for ($i=1;$i<=$_SESSION['QEl'];$i++)
	{
		$print=$_SESSION['Prih']['$i][naim'];
		while (strlen($print)!=40)
		{
			$print.="_";
		}
		$print.=$_SESSION['Prih']['$i][Q'].$_SESSION['Prih']['$i][edizm'];
		while (strlen($print)!=60)
		{
			$print.="_";
		}
		$print.=($_SESSION['Prih']['$i][Price']*$_SESSION['Prih']['$i][Q'])."руб.";
		echo "<option value='".$_SESSION['Prih']['$i][id']."'>".$print."</option> ";
	}
	
	
	
echo "</select><input name='action' type='hidden' value='del' />";
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
			  <input name='del'  type='submit'  value='Удалить позицию' onclick='document.prihf.action.value=\"del\"'/>
			  <input name='ch'  type='submit'  value='Изменить количество' onclick='document.prihf.action.value=\"ch\"'/>
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
   `ost_mat`.`ost`, 
`mater`.`MinOst` 
FROM mesta_hr, ost_mat, mater, edizm
WHERE (
(
`mesta_hr`.`osn` =1
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
echo "<a href='mater_order.php?step=1&action=newmat' class='mmenu'>Новый материал</a><br>";
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
			if (($row['ost']<$row['MinOst']) or  ($row['ost']==''))  $_SESSION['mat']['$_SESSION['cm]'][style']='smallred';
			else $_SESSION['mat']['$_SESSION['cm]'][style']='small';
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
//    <TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$_SESSION['cat']['$i][naim']."</A><DIV>";
//
//		for($j=1;$j<=$_SESSION['cm'];$j++)
//		{
//		
//		if ($_SESSION['cat']['$i][id']==$_SESSION['mat']['$j][UpId'])
//			echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD widht=150><IMG SRC='image/leaf.gif'><a href='mater_order.php?action=add&id=".$_SESSION['mat']['$j][id']."&varr=".$_SESSION['mat']['$j][varr']."&qp=".$_SESSION['mat']['$j][qpack']."&max=".$_SESSION['mat']['$j][ost']."&price=".$_SESSION['mat']['$j][Price']."' class='".$_SESSION['mat']['$j][style']."'>". $_SESSION['mat']['$j][naim']."</a><DIV>
//         </DIV></TD><td widht=15></td><td widht=150>".$_SESSION['mat']['$j][ost']." 
//			".$_SESSION['mat']['$j][abbr']."</td></TR></TABLE>";
//		} 
//		echo "</DIV></TD></TR></TABLE>
//   </TR></TD>";
//	}
// 
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


include("footer.php");
?>