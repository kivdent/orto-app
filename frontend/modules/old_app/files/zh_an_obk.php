<?php
$ThisVU="all";
$this->title="Диагноз";
$js="insert";
include("header2.php");
echo "<form name='card' id='card'>
<table border=0>
<tr>
<td valign='top'><textarea valign='top' name='zh_1' id='zh'  cols='40'  rows='2'  dir='ltr' 
onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
<td>
";

$query = "SELECT `".$_GET['table']."`.`".$_GET['table']."`, `".$_GET['table']."`.`id`
FROM ".$_GET['table']."
ORDER BY `".$_GET['table']."`.`".$_GET['table']."` ASC";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		if ($count>25) echo "<select id='tablefields' name='var_zh' size='20' multiple='multiple' ondblclick='insertValueQuery()'>";
      else echo "<select id='tablefields' name='var_zh' size='".$count."' multiple='multiple' ondblclick= 'insertValueQuery()'>";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo "<option value='".$row[0]."'>".$row[0]."</option>";
		}
 
		  echo "</select><br />
<input align='right' type='button' name='insertzh' value='&lt;&lt;' onclick='insertValueQuery()' title='Вставить' /><br>
<a href='#' class='small' onClick=\"javascript:insDs('".$_GET['nazv']."','".$_GET['id']."',document.card.zh.value,0)\"'>Вставить</a></td>
</tr>
</table></form>";				
include("footer2.php");
?>