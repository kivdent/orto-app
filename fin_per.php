<?php
$ThisVU="buhg";
$ModName="Финансовый отчёт по врачам за период";
include("header.php");
switch ($_GET['action'])
{
	case "setPer":
	switch ($_GET['step'])
		{
			case "2":
					$dtN=$_GET['NDateDY']."-".$_GET['NDateDM']."-".$_GET['NDateDD'];
					$dtO=$_GET['ODateDY']."-".$_GET['ODateDM']."-".$_GET['ODateDD'];
                                        $uet=$_GET['uet'];
					$query = "SELECT `okonch` FROM `fin-per` WHERE `okonch`<=".$dtN;
					////echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					if ($count>0)
					{
						$row = mysqli_fetch_array($result);
						$dt=explode("-",$row['okonch']);
						msg('Начало периода не может быть раньше ',$dt[2].'.'.$dt[1].'.'.$dt[0]);
						exit;
						include("footer.php");	
					}
					$query = "INSERT INTO `fin-per` (`id`, `nach`, `okonch`,`uet`) VALUES 
													(NULL,'".$dtN."','".$dtO."','".$uet."')" ;
                                        echo $query."<br>";
					$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
					$row = mysqli_fetch_array($result);
					ret('fin_per.php');
				
					include("footer.php");	
					exit;
			break;
		}
		
		echo "<form action=\"fin_per.php\" method=\"get\" name=\"period\"><div class='head2'>Установка отчётного периода</div>
		<input name='step' type='hidden' value='2' />
		<input name='action' type='hidden' value='setPer' />";
		echo "Начало: <select name='NDateDD'>";
		for ($i=$d[2]; $i<32; $i++)
		{
			$s="";
			if ($i==date("j")) $s=" selected='selected'";
			if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
			else echo "<option value='".$i."' ".$s.">".$i."</option>";
		}
		echo "</select>
		  /
		<select name='NDateDM'' size='1'>";
		$s="";
		for ($i=1; $i<13; $i++)
		{
		switch ($i)
			{
			case "1":
				$s="'>Январь</option>";
				break;
			case "2":
				$s="'>Февраль</option>";
				break;
			case "3":
				$s="'>Март</option>";
				break;
			case "4":
				$s="'>Апрель</option>";
				break;
			case "5":
				$s="'>Май</option>";
				break;
			case "6":
				$s="'>Июнь</option>";
				break;
			case "7":
				$s="'>Июль</option>";
				break;
			case "8":
				$s="'>Август</option>";
				break;
			case"9":
				$s="'>Сентябрь</option>";
				break;
			case "10":
				$s="'>Октябрь</option>";
				break;
			case "11":
				$s="'>Ноябрь</option>";
				break;
			case "12":
				$s="'>Декабрь</option>";
				break;
		}
		if ($i<10)
		{

					if ($i==date("n")) echo "<option value='0".$i."' selected='selected".$s."</option>";
					else echo "<option value='0".$i.$s."</option>";
		}
			else
				{
					if ($i==date("n")) echo "<option value='".$i."' selected='selected".$s."</option>";
					else echo "<option value='".$i.$s."</option>";
				}
		
		}
		echo "      </select>";
		echo"/
			  <select name='NDateDY'>";
		$s="";
		for (($i=date("Y"));($i<date("Y")+2); $i++)
		{
		if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
		else echo "<option value='".$i."'>".$i."</option>";
		}
		echo "      </select><br />
";
		echo "Окончание: <select name='ODateDD'>";
		for ($i=1; $i<32; $i++)
		{
			$s="";
			if ($i==date("j")) $s=" selected='selected'";
			if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
			else echo "<option value='".$i."' ".$s.">".$i."</option>";
		}
		echo "</select>
		  /
		<select name='ODateDM'' size='1'>";
		$s="";
		for ($i=1; $i<13; $i++)
		{
		switch ($i)
			{
			case "1":
				$s="'>Январь</option>";
				break;
			case "2":
				$s="'>Февраль</option>";
				break;
			case "3":
				$s="'>Март</option>";
				break;
			case "4":
				$s="'>Апрель</option>";
				break;
			case "5":
				$s="'>Май</option>";
				break;
			case "6":
				$s="'>Июнь</option>";
				break;
			case "7":
				$s="'>Июль</option>";
				break;
			case "8":
				$s="'>Август</option>";
				break;
			case"9":
				$s="'>Сентябрь</option>";
				break;
			case "10":
				$s="'>Октябрь</option>";
				break;
			case "11":
				$s="'>Ноябрь</option>";
				break;
			case "12":
				$s="'>Декабрь</option>";
				break;
		}
		if ($i<10)
		{

					if ($i==date("n")) echo "<option value='0".$i."' selected='selected".$s."</option>";
					else echo "<option value='0".$i.$s."</option>";
			}
			else
				{
					if ($i==date("n")) echo "<option value='".$i."' selected='selected".$s."</option>";
					else echo "<option value='".$i.$s."</option>";
				}
		}
		echo "      </select>";
		echo"/
			  <select name='ODateDY'>";
		$s="";
		for (($i=date("Y"));($i<date("Y")+2); $i++)
		{
		if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
		else echo "<option value='".$i."'>".$i."</option>";
		}
		echo "      </select><br>
                   УЕТ <input name='uet' type='text' Value='100'/> руб.<br>
<input name='' type='submit' Value='Сохранить'/></form>";

		
		include("footer.php");
		exit;	
	break;
}
echo "<div class=\"head1\">Финансовый отчёт по врачам за период</div>";

echo "<a href=\"fin_per.php?action=setPer\" class=\"menu\">Установить период</a>";
include("footer.php");
?>
