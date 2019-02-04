<?php
session_start();
include('mysql_fuction.php');
$ThisVU="buhg";
$ModName="Зарплатная карта";   
include("header.php");
switch ($_GET['action'])
{
	case "add":
		switch ($_GET['step'])
		{
			case "1":
				echo "<form action='buhg_zc.php' method='get' name='zp'>
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
					<input name='' type='submit'  value='Дальше>>'/>
					</form>";
					include("footer.php");
					exit;
			break;
			case "2":
				switch ($_GET['type'])
				{
				case "1":
					$query = "SELECT * FROM `zarp_card` WHERE `sotr`=".$_GET['sotr'] ;
					echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					if ($count>0) 
					{
						msg('У сотрудника уже есть зарплатная карта');
						ret('buhg_zc.php');
						exit;
					}
					echo "<form action='buhg_zc.php' method='get' name='zp'>
					<input name='action' type='hidden' value='add' />
					<input name='type' type='hidden' value='1' />
					<input name='stavka' type='hidden' value='".$_GET['stavka']."' />
					<input name='sotr' type='hidden' value='".$_GET['sotr']."' />
					<input name='step' type='hidden' value='3' />";
					$query = "SELECT `id`, `naim` FROM `proc_sh` ORDER BY `naim`";
					echo $query."<br />";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					
					echo "<div class='head2'>Процентная схема
					<select name='proc_sh'>";
					for ($i=0;$i<$count;$i++)
					{
						$row = mysqli_fetch_array($result);
						echo "<option value='".$row['id']."'>".$row['naim']."</option>";
					
					}
					echo "</select></div>
					<input name='' type='submit'  value='Дальше>>'/>
					</form>";
					include("footer.php");
					exit;
				break;
				case "2":
					$query = "SELECT * FROM `zarp_card` WHERE `sotr`=".$_GET['sotr'] ;
					echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					if ($count>0) 
					{
						msg('У сотрудника уже есть зарплатная карта');
						ret("buhg_zc.php");
						exit;
					}
					ret("buhg_zc.php?action=".$_GET['action']."&step=3&stavka=".$_GET['stavka']."&type=2&sotr=".$_GET['sotr']);
					exit;
				break;
				case "3":
					$query = "SELECT * FROM `zarp_card` WHERE `sotr`=".$_GET['sotr'] ;
					echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					if ($count>0) 
					{
						msg('У сотрудника уже есть зарплатная карта');
						ret('buhg_zc.php');
						exit;
					}
					echo "<form action='buhg_zc.php' method='get' name='zp'>
					<input name='action' type='hidden' value='add' />
					<input name='stavka' type='hidden' value='".$_GET['stavka']."' />
					<input name='sotr' type='hidden' value='".$_GET['sotr']."' />
					<input name='step' type='hidden' value='3' />
					<input name='type' type='hidden' value='3' />
					<div class='head2'>Ставка в час<input name='proc_sh' type='text' /></div>
					<input name='' type='submit'  value='Дальше>>'/>";
					include("footer.php");
					exit;
				break;
				}
			break;
			case "3":
					echo "<div class='head2'>Надбавки к зарплате</div>
					<div class='head3'><form action='buhg_zc.php' method='get' name='zp'>
					<input name='action' type='hidden' value='add' />
					<input name='type' type='hidden' value='".$_GET['type']."' />
					<input name='stavka' type='hidden' value='".$_GET['stavka']."' />
					<input name='sotr' type='hidden' value='".$_GET['sotr']."' />
					<input name='step' type='hidden' value='4' />";
					if (isset($_GET['proc_sh'])) echo "<input name='proc_sh' type='hidden' value='".$_GET['proc_sh']."'>";
					$query = "SELECT `id`, `summ`, `naim` FROM `nadb` ORDER BY `naim`" ;
					echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					for ($i=0;$i<$count;$i++)
					{
						   $row = mysqli_fetch_array($result);
							echo "<input name='nadb[".$i."]' type='checkbox' value='".$row['id']."'>".$row['naim']." (".$row['summ']."р)<br>";
					}
					echo "<input name='' type='submit'  value='Дальше>>'/>
					</form></div>";
					include("footer.php");
					exit;
					
			break;
			case "4":
					switch ($_GET['type'])
					{
						case "1":
							$query = "INSERT INTO `zarp_card` (`id`, `sotr`, `type`, `stavka`,`ps`)
											 VALUES (NULL, ".$_GET['sotr'].", ".$_GET['type'].", ".$_GET['stavka'].", ".$_GET['proc_sh'].")" ;
							echo $query."<br>";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$query = "SELECT LAST_INSERT_ID()" ;
							echo $query."<br>";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							$zc=$row[0];
						break;
						case "2":
							$query = "INSERT INTO `zarp_card` (`id`, `sotr`, `type`, `stavka`)
											 VALUES (NULL, ".$_GET['sotr'].", ".$_GET['type'].", ".$_GET['stavka'].")" ;
							echo $query."<br>";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$query = "SELECT LAST_INSERT_ID()" ;
							echo $query."<br>";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							$zc=$row[0];
						break;
						case "3":
							$query = "INSERT INTO `zarp_card` (`id`, `sotr`, `type`, `stavka`,`ph`)
											 VALUES (NULL, ".$_GET['sotr'].", ".$_GET['type'].", ".$_GET['stavka'].", ".$_GET['proc_sh'].")" ;
							echo $query."<br>";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$query = "SELECT LAST_INSERT_ID()" ;
							echo $query."<br>";
							$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
							$row = mysqli_fetch_array($result);
							$zc=$row[0];
						break;
					}
					
					$nadb=$_GET['nadb'];
					reset($nadb);
					$query="INSERT INTO `nadb_sootv` (`id`, `zc`, `nadb`) VALUES ";
					$i=0;
					while (list($el)=each($nadb))
					{
						if ($i==0) $query.="(NULL, ".$zc.", ".$el.")";
						else $query.=", (NULL, ".$zc.", ".$el.")";
						$i++;
					}
					if ($i!=0)
					{
						echo $query."<br>";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					}
					include("footer.php");
					ret('buhg_zc.php');
					exit;
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
  </tr>";
$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `zarp_card`.`stavka`, `zc_type`.`naim`
FROM sotr, zarp_card, zc_type
WHERE ((`zarp_card`.`type` =`zc_type`.`id`) AND (`zarp_card`.`sotr` =`sotr`.`id`))
ORDER BY `sotr`.`surname`" ;

$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
       $row = mysqli_fetch_array($result);
	   echo "<tr>
		<td>".$row['surname']." ".$row['name']." ".$row['otch']."</td>
		<td>".$row['naim']."</td>
		<td>".$row['stavka']."</td>
	  </tr>";
	}


echo "</table>
<a href='buhg_zc.php?action=add&step=1' class='menu'>Добавить</a>";
include("footer.php");
?>