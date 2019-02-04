<?php
$ThisVU="stms";
$ModName="Место хранения"; 
$js="spisok"; 
include("header.php");
$query = "SELECT `mater`.`id`, 
					`mater`.`naim`, 
					`mater`.`Price`, 
					`mater`.`QPack`, 
					`mater`.`Cat`, 
					`mater`.`UpId`
			FROM mater";
//////////echo $query."<br />";
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
	
$query = "SELECT `mesta_hr`.`id`, `mesta_hr`.`nazv`, `mesta_hr`.`mol`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`
FROM mesta_hr, sotr
WHERE (`sotr`.`id` =`mesta_hr`.`mol`)";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<center>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if (!isset($_GET['mesto_hr'])) $mesto_hr=$row['id'];
	else $mesto_hr=$_GET['mesto_hr'];
	echo "|<a class='mmenu' href='mater_ost.php?mesto_hr=".$row[0]."'>".$row[1]."</a>|";
}
echo "</center><hr width='100%' noshade='noshade' size='1'/>";
$query = "SELECT `mesta_hr`.`id`, `mesta_hr`.`nazv`, `mesta_hr`.`mol`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`
FROM mesta_hr, sotr
WHERE( (`sotr`.`id` =`mesta_hr`.`mol`) AND
		(`mesta_hr`.`id`='".$mesto_hr."'))";
//////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$resultA=$result;
$countA=$count;
$rowA = mysqli_fetch_array($resultA);
echo "<span class='head2'>Место хранения: ".$rowA[1]."(".$rowA[3]." ".$rowA[4]." ".$rowA[5].")</span><br>";
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
echo "<TABLE BORDER=0 align='left'>";
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

for($i=1;$i<=$_SESSION['cc'];$i++)
	{
		echo "<TR><TD>
    <TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$_SESSION['cat']['$i][naim']."</A><DIV>";

		for($j=1;$j<=$_SESSION['cm'];$j++)
		{
		
		if ($_SESSION['cat']['$i][id']==$_SESSION['mat']['$j][UpId'])
			echo "<TABLE BORDER=0><TR><TD WIDTH=10></TD><TD widht=150><IMG SRC='image/leaf.gif'><a href='mater.php?action=change&id=".$_SESSION['mat][id']."' class='small'>". $_SESSION['mat']['$j][naim']."</a><DIV>
         </DIV></TD><td widht=15></td><td widht=150>".$_SESSION['mat']['$j][ost']." 
			".$_SESSION['mat']['$j][abbr']."</td></TR></TABLE>";
		} 
		echo "</DIV></TD></TR></TABLE>
   </TR></TD>";
	}
 
echo "</TABLE>";
include("footer.php");
?>