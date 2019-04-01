<?php
$ThisVU="all";
$this->title="Работа спациентом";
$js="insert";
$this->context->layout='@frontend/views/layouts/light.php';
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=1 order by range, manip";
		////////////echo $query."<br />";
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
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			<!--document.onclick = clickHandler;--> 
			</script>";
		for($i=1;$i<=$cc;$i++)
			{
				echo "
			<SPAN id='Out".$i."' class='mmenuHand'>".$cat['$i][manip']."</SPAN><br />
	<div id=Out".$i."details style=\"display:Yes; position:relative; left:12;\">
		<table width='80%' border='1'>
		 <td width='70%'>Манипуляция</td>
		 <td width='15%'>ст цена</td>
		 <td width='15%'>нов цена</td>
		 <td width='15%'>id</td>
    ";
				
				for($j=1;$j<=$cm;$j++)
				{
				
					if ($cat['$i][id']==$mat['$j][UpId'])
					{
					echo "<tr>
        <td width='85%'><a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&manip=".$mat['$j][id']."&act=add' class='small'>". $mat['$j][manip']."</a></td>
        <td width='15%'>".$mat['$j][price']."</td>
        <td width='15%'>";
			//if (round(($mat['$j][price']+($mat['$j][price']*10)/100),-1)==$mat['$j][price'])
			///		{
						$summ_sk=round(($mat['$j][price']+($mat['$j][price']*10)/100),-1);
			//		}
			//		else
			//		{
			//			$summ_sk=(floor((($mat['$j][price']+($mat['$j][price']*10)/100))/10))*10;
			//		}
					
				//	if ($summ_sk<100) $summ_sk+=10;
					$summ_sk=round(($mat['$j][price']+($mat['$j][price']*10)/100),-1);
     echo $summ_sk."</td>
      <td width='15%'>".$mat['$j][id']."</td>
     </tr>";
     	$query = "UPDATE `manip` SET `price`=".$summ_sk." WHERE `id`=".$mat['$j][id']." and `id`not in(22,385,281,69)";
echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
				} 
				}
				echo "</table></div>";
			}
?>