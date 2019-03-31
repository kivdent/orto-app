<?php
$ThisVU="all";
$this->title=""; 
//include("header.php");
$query = "SELECT `id`,`price`,`manip` FROM `manip` WHERE `cat`=0 ORDER BY `preysk`";
echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Манипуляция</td>
    <td class='menutext'>Старая цена</td>
    <td class='menutext'>Новая цена</td>
  </tr>";
for ($i=0;$i<$countA;$i++)
{
	$rowA = mysqli_fetch_array($resultA);

	if ($rowA['price']==round(($rowA['price']*1.1),-1))
	{
		$np=$rowA['price']+10;
	}
	else
	{
		$np=round(($rowA['price']*1.1),-1);
	}
	$query = "UPDATE `manip`
				SET `price`=".$np."
				WHERE `id`=".$rowA['id'];
echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	//$query = "";
//	echo $query."<br />";
//	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
}
echo "</table>";
//include("footer.php");
?>