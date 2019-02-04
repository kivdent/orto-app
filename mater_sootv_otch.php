<?php
$ThisVU="stms";
$js="spisok";
$ModName="Отчёт по материалам для автосписания"; 
include("header.php");
echo "<form action='mater_sootv_otch.php' method='get' name='ShowAuto' id='ShowAuto'>";

echo "<table width='100%' border='1' cellspacing='0' cellpadding='0'>
  <tr>
    <td><div class=\"head2\">Материал";
$query = "SELECT `mater`.`naim`, `mater_avto_spis`.`id`,`mater_avto_spis`.`mater`
FROM mater, mater_avto_spis
WHERE (`mater`.`id` =`mater_avto_spis`.`mater`)
GROUP BY `mater_avto_spis`.`mater`
ORDER BY `mater_avto_spis`.`mater`";
				////////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				echo "
				 <select name='mater'\">";
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					if ($i==0)
					{
						if (isset($_GET['mater']))
						{
							$mater=$_GET['mater'];
						}
						else
						{
							$mater=$row['mater'];
						}
					}
					if ($mater==$row['mater']) 
					{
						echo "<option value='".$row['mater']."' selected='selected'>".$row['naim']."</option>";
					}
					else echo "<option value='".$row['mater']."' >".$row['naim']."</option>";
				}
				echo "/<select></div>
     <br /><div class=\"head2\">Отчёт за период с ";
	 
	 	if (isset($_GET['nachD']))
		{
			$nach=mktime(0,0,0,$_GET['nachM'],$_GET['nachD'],$_GET['nachY']);
			$okonch=mktime(0,0,0,$_GET['okonchM'],$_GET['okonchD'],$_GET['okonchY']);
		}
		else
		{
			$nach=mktime(0,0,0,date('m'),'01',date('Y'));
			$okonch=mktime(0,0,0,date('m'),date('d'),date('Y'));
		}
		if ($nach>=$okonch)
		{
			msg('неправильно выбран период');
			ret('mater_sootv_otch.php');
		}
	 	echo ":<select name='nachD' id='nachD'>";
				for ($i=1; $i<32; $i++)
				{
				if ($i<10)
				{
						if (date("j",$nach)==$i) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
						else echo "<option value='0".$i."'>".$i."</option>";
				}
				else
						{
						if (date("j",$nach)==$i) echo "<option value='".$i."' selected='selected'>".$i."</option>";
						else echo "<option value='".$i."'>".$i."</option>";
						}
				}
				echo "</select>
					/
					<select name='nachM' id='nachM'>";
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
				if ($i==date("n",$nach))
								if ($i==date("n",$nach)) echo "<option value='0".$i."' selected='selected".$s;
						if (!($i==date("n",$nach))) echo "<option value='0".$i.$s;
				}
				else
						{
						if ($i==date("n",$nach)) echo "<option value='".$i."' selected='selected".$s;
						if (!($i==date("n",$nach))) echo "<option value='".$i.$s;
						}
				}
				
				echo "    </select>
					/
					<select name='nachY' id='nachY'>";
					for ($i=1910; $i<2008; $i++)
					{
					if ($i==date("Y",$nach)) echo "<option value='".$i."' selected='selected'>".$i."</option>";
					else echo "<option value='".$i."'>".$i."</option>";
					}
				echo "    </select>";
echo "по";
	echo ":<select name='okonchD' id='okonchD'>";
				for ($i=1; $i<32; $i++)
				{
				if ($i<10)
				{
						if (date("j")==$i) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
						else echo "<option value='0".$i."'>".$i."</option>";
				}
				else
						{
						if (date("j")==$i) echo "<option value='".$i."' selected='selected'>".$i."</option>";
						else echo "<option value='".$i."'>".$i."</option>";
						}
				}
				echo "</select>
					/
					<select name='okonchM' id='okonchM'>";
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
				if ($i==date("n"))
								if ($i==date("n")) echo "<option value='0".$i."' selected='selected".$s;
						if (!($i==date("n"))) echo "<option value='0".$i.$s;
				}
				else
						{
						if ($i==date("n")) echo "<option value='".$i."' selected='selected".$s;
						if (!($i==date("n"))) echo "<option value='".$i.$s;
						}
				}
				
				echo "    </select>
					/
					<select name='okonchY' id='okonchY'>";
					for ($i=1910; $i<2008; $i++)
					{
					if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
					else echo "<option value='".$i."'>".$i."</option>";
					}
				echo "    </select></div>";
echo "<br />
<input name='' type='submit'  value='Показать'/>
	</td>
  </tr>
</table>";

$query = "SELECT 
	`dnev`.`date`, 
	`sotr`.`surname`, 
	`sotr`.`name` , 
	`sotr`.`otch` ,
	  `manip_pr`.`kolvo`
FROM sotr, dnev, manip_pr, mater_avto_spis
WHERE (
(
`dnev`.`date` >= '".date('Y-m-d',$nach)."'
)
AND (
`dnev`.`date` <= '".date('Y-m-d',$okonch)."'
)
AND (
`manip_pr`.`manip` = `mater_avto_spis`.`manip` 
)
AND (
`mater_avto_spis`.`mater`  = '".$mater."' 
)
AND (
`manip_pr`.`dnev` = `dnev`.`id` 
)
AND (
`sotr`.`id` = `dnev`.`vrach`
)
)";
////////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$summ=0;
echo "<div class=\"head3\">Расход материала:</div>

		  <table width='100%' border='1' cellspacing='0' cellpadding='0'>
            <tr>
              <td width='20%' class='head2'>Дата</td>
              <td width='60%' class='head2'>Врач</td>
              <td width='20%' class='head2'>Кол-во</td>
            </tr>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode('-',$row['date']);
	$summ+=$row['kolvo'];
    echo "<tr>
              <td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
              <td>".$row['surname']." ".$row['name']." ".$row['otch']."</td>
              <td>".$row['kolvo']."</td>
            </tr>";

}
          echo "</table>
		 <div class=\"head3\"> Всего за период: ".$summ."</div>
		  <a href=\"print.php?type=mater_sootv_otch&mater=".$mater."\" class='menu2'>Печать отчёта</a>
		</form>	";
include("footer.php");
?>