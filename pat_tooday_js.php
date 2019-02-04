<?php
echo "<script language=JavaScript>
function ShowInp()
{
	 document.write('<select name=VidAll['+document.form1.count.value+'] onchange=ShowInp()><option value=0>&nbsp;</option>'+'";
$query = "SELECT `allvid`.*
FROM allvid" ;
////////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);	
	echo "<option value=".$row['id'].">".$row['vid']."</option>"; 
}
echo "'+'</select>');
	 document.form1.count.value=document.form1.count.value+1;
}
</script>";
?>

	  <?php include("pat_tooday_js.php"); ?>
	  <script language="JavaScript">
	      ShowInp();
	  </script>