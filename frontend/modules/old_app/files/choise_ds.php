<?php
$ThisVU="all";
$ModName="Диагноз";
$js="insert";
include("header2.php");
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=1 order by range, manip";
		//echo $query."<br />";
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
			
			
			
			
			
			
$query = "SELECT * FROM `klass`";
//echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$klass['count']=0;
for ($i=0;$i<$count;$i++)
			{
			$row = mysqli_fetch_array($result);
			$klass['el']['$klass['count]'][id']=$row['id'];
			$klass['el']['$klass['count]'][Nazv']=$row['Nazv'];
			$klass['count']++;
			}			
echo "<div id=\"finderparent\">
<ul id=\"finder\">";	
for($i=1;$i<=$klass['count'];$i++)
			{
				echo "<li>".$klass['el']['$i][Nazv']."<ul>";
				$query = "SELECT `id`, `Nazv`, `upID`, `KlassID`, `Cat` FROM `ds` WHERE `KlassID`=".$klass['el']['$i][id'];
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				for ($j=0;$j<$count;$j++)
				{
			$row = mysqli_fetch_array($result);
			echo "
<li><a href='#' class='small' onClick=\"javascript:insDs('".$_GET['nazv']."','".$_GET['id']."','".$row['Nazv']."','".$row['id']."')\"'>".$row['Nazv']."</a></li>";
				}
				echo "</ul></li>";
			}
echo "
</ul>
</div>";
			include("footer2.php");
?>