<?php 
$ThisVU="all";
$this->title="Расписание на неделю"; 
//include("header.php");
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
if (date("w")==0) $day=7;
else $day=date("w");
echo "<h4>Расписание на неделю</h4>";
echo "<hr />";
$cd=$day*24*60*60;
$FDN=date("U")-$cd;
echo "<table width='100%' border='1' cellpadding='1'><tr>";
for($i=1;$i<8;$i++)
{
    echo "<td>".$dn[($i-1)]."</td>";
}
echo "</tr><tr>";
 for($i=1;$i<8;$i++)
{
    $CDN=$FDN+(24*60*60*$i);
    echo "<table width='100%' border='1' cellpadding='1'>
		  <tr>
			<td>".date("d-m-Y",$CDN)."</td>
		  </tr>
		 <tr>
			<td>Время смены</td></tr>
		   <tr>
			<td><table width='100%' border='1' cellpadding='1'>
		  <tr>
			<td>Отдать</td>
			<td>Выходной</td>
			<td>Изменить</td>
		  </tr>
		</table>
		</td>
		  </tr>
		</table>";
}
echo "  </tr></table>";
//include("footer.php");
?>