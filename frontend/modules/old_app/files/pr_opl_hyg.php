<?php

include('mysql_fuction.php');
$ThisVU="registrator";
$this->title="Продажа гигиены";
$js="insert";
//include("header.php");
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";

$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
if (!($count>0))
{
	msg("Необходимо открыть кассовую смену");
	ret("kassa.php?action=nach&step=1");
}
else
{
    $row = mysqli_fetch_array($result);
	$_SESSION['kassa']=$row['id'];
}
if (!(isset($_GET['step']))) ret("pr_opl_hyg.php?step=4&count=1");
switch ($_GET['step'])
{
case "4":
 echo $_SESSION['countm'][$_GET['count']]."".$_SESSION['summ'][$_GET['count']];
 $preysk=4001;
	switch ($_GET['act'])
	{
	case "add":
		if (!(isset($_SESSION['countm'][$_GET['count']])))
		{
			$query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=".$_GET['manip'] ;
			
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
	ret("pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
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
	ret("pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
	break;
	case "p1":
	for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
	{
		if ($_GET['chek']==$_SESSION['chek'][$_GET['count']][$i][1])
		{
			$_SESSION['chek'][$_GET['count']][$i][2]=$_SESSION['chek'][$_GET['count']][$i][2]+1;
		}
	}
	ret("pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
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
	ret("pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk);
	break;
	case "chQ":
		if ($_GET['sstep']==1)
		{	
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ(id,qq)
			{
				q=prompt('Введите количество',qq);
				url='pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$_GET['preysk']."&id='+id+'&act=chQ&sstep=2&q='+q;
				location.href=url;
			}";
			echo "ChQ('".$_GET['id']."','".$_SESSION['chek'][$_GET['count']][$_GET['id']][2]."')</script>";
		}
		else
		{
			$_SESSION['chek'][$_GET['count']][$_GET['id']][2]=$_GET['q'];
			ret("pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$_GET['preysk']);
		}
	break;
	case "next":

		ret("pr_opl_hyg.php?action=lech&step=5&count=1");
exit;
					echo "<form id='lechf' name='lechf' method='get' action='pr_opl_hyg.php'>
            <label></label>
            Правка лечения:<br />
                  <textarea name='lech' cols='50' rows='7' id='lech'>"; 
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

		

	break;	
	}
	$preysk=4001;
	//////////Заполнение лечения
	echo "<form action='pr_opl_hyg.php' method='get' id='lech' name='lech'>
	<input name='count' type='hidden' value='1' />";
		
	echo "			<table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>
		<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
	  <tr>";
	echo "<td width='40%' valign='top' align='center'>Счёт:<br /> ";
	if ($_SESSION['countm'][$_GET['count']]>0)
		{
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
				<a href='pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&chek=".$_SESSION['chek'][$_GET['count']][$i][1]."&act=del' class='niz2'>Удалить из списка</a>
</td>
				<td width='10%' align='center'>".$_SESSION['chek'][$_GET['count']][$i][2]."<br />
<a href='pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&id=".$i."&act=chQ&sstep=1' class=niz2>изменить</a> </td>
				<td width='12%' align='center'>".$_SESSION['chek'][$_GET['count']][$i][4]." руб.</td>
				<td width='10%' align='center'>".($_SESSION['chek'][$_GET['count']][$i][2]*$_SESSION['chek'][$_GET['count']][$i][4])." руб.</td>
			  </tr>";
			$_SESSION['summ'][$_GET['count']]+=$_SESSION['chek'][$_GET['count']][$i][2]*$_SESSION['chek'][$_GET['count']][$i][4];	
			} 
			echo "</table>";
			echo "<div align='right'>Итого: ".$_SESSION['summ'][$_GET['count']]." руб. </div>";		
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

if (($_GET['code']=="") or (!(isset($_GET['code']))) )
{
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from `manip` WHERE `preysk`=".$preysk." order by `range`, `manip`";
		
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
			document.onclick = clickHandler; 
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
        <td width='85%'><a href='pr_opl_hyg.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&manip=".$mat[$j]['id']."&act=add' class='small'>". $mat[$j]['manip']."</a></td>
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
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from `manip` WHERE( (`preysk`=".$preysk.")  AND (`range`='".$_GET['code']."' ))order by `range`, `manip`";
		
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
			document.onclick = clickHandler; 
			</script>";

				echo "<table width='80%' border='0'>";
    
				
				for($j=1;$j<=$cm;$j++)
				{
				
					if ($cat[$i]['id']==$mat[$j]['UpId'])
					echo "<tr>
        <td width='85%'><a href='pr_opl_hyg.php?action=lech&step=4&count=1&preysk=".$preysk."&manip=".$mat[$j]['id']."&act=add' class='small'>". $mat[$j]['manip']."</a></td>
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
                                   echo $_SESSION['countm'][$_GET['count']]."".$_SESSION['summ'][$_GET['count']];
		$_SESSION['lech'][$_GET['count']]=$_GET['lech'];
		$opl=$_SESSION['summ'][$_GET['count']];
		$query = "INSERT INTO `dnev`    (`id`, `vrach`,`pat`, `date`, `osm`, `ds`, `zh`, `an`, `obk`, `lech`, `resl`,`summ`, `summ_k_opl`, `summ_vnes`,`skidka`,`Nid`)
                                                                VALUES      (NULL, 0,0, '".date('Y-m-d')."', '0', ' ', ' ', ' ', ' ', ' ', 0,'".$opl."','".$opl."',0,0,0)" ;
	
		$result=sql_query($query,'orto',0);  
		$pr=$result;
		$query = "INSERT INTO `manip_pr` (`id`, `NZuba`, `manip`, `kolvo`, `dnev`) VALUES";

			for ($j=1;$j<=$_SESSION['countm'][$_GET['count']];$j++)
			{
				if ($j==1)$query.="(NULL,'0','".$_SESSION['chek'][$_GET['count']][$j][1]."','".$_SESSION['chek'][$_GET['count']][$j][2]."','".$pr."')";
				else $query.=",(NULL,'0','".$_SESSION['chek'][$_GET['count']][$j][1]."','".$_SESSION['chek'][$_GET['count']][$j][2]."','".$pr."')";
			}

		//echo "Вставка в Манипуляции при приёме<br>";
		//
		
		$result=sql_query($query,'orto',0);
		$query = "SELECT `id`, `mater`,`manip`, `mesto_hr` FROM `mater_avto_spis` WHERE `manip`in (";
		$s=0;
		for ($i=1;$i<=$_SESSION['countm'][$_GET['count']];$i++)
		{
			if ($i==1) $query.=$_SESSION['chek'][$_GET['count']][$i][1];
			else $query.=", ".$_SESSION['chek'][$_GET['count']][$i][1];
		}
		
		$query.=")";
		$ssk=($s-round($s*($ck/100)));		
		$result=sql_query($query,'orto',0);   
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			for ($j=1;$j<=$_SESSION['countm'][$_GET['count']];$j++)
			{
				if ($_SESSION['chek'][$j][1]==$row['manip'])
				$query = "UPDATE `ost_mat`
				SET `ost`=`ost`-'".$_SESSION['chek'][$j][2]."'
				WHERE ((`mater`='".$row['mater']."') and
						(`mesto_hr`='".$row['mesto_hr']."'))";
				
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			}
		}
		
	
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
	unset($_SESSION['Nid']);
	unset($_SESSION['proc_sk']);
                ret("http://orto70/pr_opl.php?dnev=".$pr."&action=pr&step=1&Pid=5354&table1=dnev&type=1");
}
////////////Лечение зуба

//include("footer.php");
?>
