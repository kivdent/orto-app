<?php
$ThisVU="all";
$this->title="Приём платежей";
//include("header.php");
	$query = "SELECT `skidka`.`proc`, `skidka`.`id`
		FROM skidka" ;
		echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				$sk['$i][id']=$row['id'];
				$sk['$i][proc']=$row['proc'];
				
			}
$c=$count;
for ($i=0;$i<$c;$i++)
{

$query = "UPDATE `klinikpat`
SET `Skidka`=".$sk['$i][proc']."
WHERE `Skidka`=".$sk['$i][id'];
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
}				
//include("footer.php");
?>