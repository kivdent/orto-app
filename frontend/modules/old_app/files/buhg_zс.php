<?php
$ThisVU="buhg";
$this->title="Зарплатная карта";   
//include("header.php");
switch ($_GET['action'])
{
	case "add":
		switch ($_GET['step'])
		{
			case "1":
				echo "<form action='buhg_zс.php' method='get' name='zp'>
					<input name='action' type='hidden' value='add' />
					<input name='step' type='hidden' value='2' />";
					$query = "SELECT `id`, `surname`, `name`, `otch` FROM `sotr` ORDER BY `surname`";
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					
					echo "<div class='head2'>Сотрудник
					<select name='sotr'>";
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
					
					}
					echo "</select></div>
					<div class='head2'>Тип зарплаты
					<select name='type'>";
					$query = "SELECT `id`, `naim` FROM `zc_type`";
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value='".$row['id']."'>".$row['naim']."</option>";
					}
					echo "</select></div>
					<div class='head2'>Ставка
					<input name='stavka' type='text' /></div>
					<input name='' type='submit'  value='Дальше'/>
					</form>";
			break;
			case "2":
				
			break;
		}
	break;
}
	echo "<div class='head1'>Зарплатные карты </div>
		
		<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Сотрудник</td>
    <td class='menutext'>Тип</td>
    <td class='menutext'>Ставка</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<a href='buhg_zс.php?action=add&step=1' class='menu'>Добавить</a>";
//include("footer.php");
?>