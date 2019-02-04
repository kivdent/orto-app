<?php
$ThisVU="gigienist";
$ModName="Внести гигиенические индексы";
include("header.php");
switch ($_GET['action'])
{
	case "saveOsm":
		$query = "INSERT INTO `osmotr` (`id`, `Date`, `Perv`, `Pat`) VALUES (NULL, '".date("Y-m-d")."',0, ".$_GET['pat'].")";
		////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$query = "SELECT LAST_INSERT_ID()";
		////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$osm=$row[0];
		$query = "INSERT INTO `sostzubosm` (`id`, `NZuba`, `SostZuba`, `Osmotr`) VALUES ";
		$sz=$_GET['Nzub'];
		for ($i=1;$i<=32;$i++)
		{
			if ($i==1) $query.="(NULL, ".$i.",".$sz['$i']." , ".$osm.")";
			else $query.=", (NULL, ".$i.",".$sz['$i']." , ".$osm.")";
		}
		////echo $query."<br />";
		ret("gig_index.php?pat=".$_GET['pat']);
        $result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	break;
	case "saveIGV":
		$zn=$_GET['zn'];
		$zk=$_GET['zk'];
		$Szn=0;
		$Szk=0;
		for ($i=1;$i<=6;$i++)
		{
			$Szn+=$zn['$i'];
			$Szk+=$zk['$i'];
		}
		$query = "INSERT INTO `igv` (`id`, `date`, `pat`, `summ`, `izn`, `izk`) VALUES (NULL, '".date("Y-m-d")."', ".$_GET['pat'].", '".((round(($Szn/6),1)+round(($Szk/6),1)))."', '".(round(($Szn/6),1))."', '".(round(($Szk/6),1))."')";
		////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("gig_index.php?pat=".$_GET['pat']);
	break;
	case "saveCPI":
		$zn=$_GET['zn'];
		$Szn=0;
		for ($i=1;$i<=6;$i++)
		{
			$Szn+=$zn['$i'];
		}
		$query = "INSERT INTO `CPI` (`id`, `date`, `pat`, `summ`) VALUES (NULL, '".date("Y-m-d")."', ".$_GET['pat'].", '".(round(($Szn/6),1))."')";
		////echo $query."<br />";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("gig_index.php?pat=".$_GET['pat']);
	break;
}
$query = "SELECT `surname`,`name`,`otch` FROM `klinikpat` WHERE `id`='".$_GET['pat']."'" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
echo "<div class='head1'>Пациент: ".$row['surname']." ".$row['name']." ".$row['otch']." "."</div>";
				$query = "SELECT `osmotr`.`id`,`osmotr`.`Date`
						FROM osmotr
						WHERE (`osmotr`.`Pat` ='".$_GET['pat']."')
						ORDER BY `osmotr`.`Date` DESC" ;
						//////echo $query."<br>";
						$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if (($count>0) and ($_GET['osm']!='new'))
				{
				   echo "<form action=\"gig_index.php\" method=\"get\" name=\"Fosm\" id=\"Fosm\">Осмотр от: <select name=\"osm\" id=\"osm\" onChange=\"location.href='gig_index.php?pat=".$_GET['pat']."&osm='+Fosm.osm.value\">";
				  
					for ($i=0; $i<$count; $i++)
					{
						$row = mysqli_fetch_array($result);
						if ($i==0) 
						{
							if (!(isset($_GET['osm']))) $osm=$row['id'];
					         else $osm=$_GET['osm'];
						}
						$dt=explode("-",$row['Date']);
						if ($row['id']==$_GET['osm']) echo "<option value='".$row['id']."' selected='selected'>".$dt[2].".".$dt[1].".".$dt[0]."</option>"; 
						else echo "<option value='".$row['id']."'>".$dt[2].".".$dt[1].".".$dt[0]."</option>";
					}
					echo "<option value='new'>Новый</option>";
					echo "</select></form>";
					
				}
				else 
				{
					echo "<div class='head3'>Этому пациенту не было произведено ни одного осмотра.</div>";
		  		$osm='new';
				}
		        echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";
				if ($osm!='new')
				{
				echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				
			
					$query = "SELECT `nzuba`.`NZuba` , `sz`.`id` , `sz`.`obozn` , `sz`.`sz` 
FROM `sostzubosm` , `sz` , `nzuba` 
WHERE (
(
`sostzubosm`.`Osmotr` = '".$osm."'
)
AND (
`sostzubosm`.`NZuba` <=32
)
AND (
`sz`.`id` = `sostzubosm`.`SostZuba` 
)
AND (
`nzuba`.`id` = `sostzubosm`.`NZuba` 
)
)
ORDER BY `sostzubosm`.`NZuba` ASC 

" ;
	//////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	unset ($kpu);
	$kpu=0;
	for ($i=1;$i<=32;$i++)
	{
		$row = mysqli_fetch_array($result);
		if (($row['id']==7) or ($row['id']==6)) $z[1]['$i']="<input ".$disabled." type='checkbox' name='Nzub[".$i."]' value='".$i."'  disabled='disabled'/>";
		else $z[1]['$i']="<input ".$disabled." type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		if ($row['obozn']=="") $z[2]['$i']="&nbsp;";
		else $z[2]['$i']=$row['obozn'];
		$z[3]['$i']=$row['NZuba'];
		$z[4]['$i']=$row['sz'];
		if (!(($row[1]==10) or ($row[1]==4))) $kpu++;
	}
	for ($i=2;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
			}
		 echo "</tr>";
	}
		////20 сегмент
		 echo " </table></td>
                <td bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=2;$i<=3;$i++)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=9;$j<=16;$j++)
							{
								echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
							}
						 echo "</tr>";
					}
				echo "                </table></td>
              </tr>
              <tr>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				for ($i=3;$i>=2;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=32;$j>=25;$j--)
							{
								echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=2;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table><br />
КПУ=".$kpu;
		      }
			  //Если формулы нет
			  else
			  {
			  	echo "<form action=\"gig_index.php\" method=\"get\"><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
	$query = "SELECT `id`, `sz`, `obozn` FROM `sz`";
//////echo $query;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
$szC=$count;
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	$sz['$i][id']=$row['id'];
	$sz['$i][sz']=$row['obozn'];

}
	$query = "SELECT `id`, `NZuba` FROM `nzuba` ORDER BY `id`" ;
	////////echo $query."<br>";
	$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
	
	for ($i=1;$i<=32;$i++)
	{	
	$row = mysqli_fetch_array($result);	
		$z[1]['$i']="<select name='Nzub[".$i."]'/>";
		for ($j=0;$j<$szC;$j++)
		{
			if ($sz['$j][id']==10) $z[1]['$i'].="<option value='".$sz['$j][id']."' selected='selected'>".$sz['$j][sz']."</option>";
			else $z[1]['$i'].="<option value='".$sz['$j][id']."'>".$sz['$j][sz']."</option>";
		}
		$z[2]['$i']="&nbsp;";
		$z[3]['$i']=$row['NZuba'];
		$z[4]['$i']="";
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
			}
		 echo "</tr>";
	}
		////20 сегмент
		 echo " </table></td>
                <td bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=1;$i<=3;$i++)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=9;$j<=16;$j++)
							{
								echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
							}
						 echo "</tr>";
					}
				echo "                </table></td>
              </tr>
              <tr>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=32;$j>=25;$j--)
							{
								echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4]['$j']."'>".$z['$i']['$j']."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>
			<input name=\"action\" type=\"hidden\" value=\"saveOsm\" />
			<input name=\"pat\" type=\"hidden\" value=\"".$_GET['pat']."\" />
			";
			echo "<input name='' type='submit'  value='Сохранить изменения'/></form>";
			  }
echo "<div class=\"head2\">Индекс Грина-Вермилиона</div>";
$query = "SELECT `id`, `date`, `summ`, `izn`, `izk` FROM `IGV` WHERE `pat`=".$_GET['pat']." ORDER BY `date` DESC";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if (($count>0) and ($_GET['IGV']!='new'))
{
	
echo "<table width='100%'  border='1' cellpadding='0' cellspacing='0' bordercolor='#000000' bgcolor='#FFFFFF'>
  <tr class='feature3'>
    <td class='feature2'>Дата</td>
    <td class='feature2'>ИГВ</td>
    <td class='feature2'>ИЗН</td>
    <td class='feature2'>ИЗК</td>
    <td class='feature2'>Уровень<br />
      гигиены</td>  </tr>";	
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		$dt=explode("-",$row['date']);
		echo "  <tr class='feature2'>
			<td>".$dt[2]." ".$dt[1]." ".$dt[0]."</td>
			<td>".$row['summ']."</td>
			<td>".$row['izn']."</td>
			<td>".$row['izk']."</td>";
		 if ($row['summ']>=3.1) echo "<td>Плохой</td>";
		 else if ($row['summ']>=1.3) echo "<td>Удовлетворительный</td>";
		 else  echo "<td>Хороший</td>";
		 echo "</tr>";
  }
echo "</table>";
echo "<input value=\"Новое обледование\" type=\"button\"  onClick=\"location.href='gig_index.php?pat=".$_GET[
pat]."&osm=".$osm."&IGV=new'\"/>";
}
else
{
 //Новое обследование игв
 echo "<form action='' method='get'>
		Индекс Грина-Вермильона <br />
         <table width='100%' border='0'>
            <tr>
              <td><div align='center'>№ зуба </div></td>
              <td><div align='center'>Зубной налёт </div></td>
              <td><div align='center'>Зубной камень </div></td>
            </tr>
            <tr>
              <td>16 (вест) </td>
              <td><div align='center'>
                <label>
                <select name='zn['1]' id='zn[1']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
                </label>
              </div></td>
              <td><div align='center'>
                <select name='zk['1]' id='zk[1']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>11 (вест) </td>
              <td><div align='center'>
                <select name='zn['2]' id='zn[2']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk['2]' id='zk[2']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>26 (вест) </td>
              <td><div align='center'>
                <select name='zn['3]' id='zn[3']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk['3]' id='zk[3']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>36 (яз) </td>
              <td><div align='center'>
                <select name='zn['4]' id='zn[4']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk['4]' id='zk[4']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>41 (вест) </td>
              <td><div align='center'>
                <select name='zn['5]' id='zn[5']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk['5]' id='zk[5']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>46 (яз) </td>
              <td><div align='center'>
                <select name='zn['6]' id='zn[6']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk['6]' id='zk[6']'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
          </table>
		  <center>
		  <input name=\"action\" type=\"hidden\" value=\"saveIGV\" />
		  <input name=\"pat\" type=\"hidden\" value=\"".$_GET['pat']."\" />
		  <input name='' type='submit'  value='Сохранить изменения'/></center></form>";
}
///  CPI
echo "<div class=\"head2\">Комплексный пародональный индекс</div>";
$query = "SELECT `id`, `date`, `summ` FROM `CPI` WHERE `pat`=".$_GET['pat']." ORDER BY `date` DESC";
////echo $query."<br />";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if (($count>0) and ($_GET['CPI']!='new'))
{
	
echo "<table width='100%'  border='1' cellpadding='0' cellspacing='0' bordercolor='#000000' bgcolor='#FFFFFF'>
  <tr class='feature3'>
    <td class='feature2'>Дата</td>
    <td class='feature2'>КПИ</td>
    <td class='feature2'>Тяжесть поражения</td>  </tr>";	
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		$dt=explode("-",$row['date']);
		echo "  <tr class='feature2'>
			<td>".$dt[2]." ".$dt[1]." ".$dt[0]."</td>
			<td>".$row['summ']."</td>";
		 if ($row['summ']>=3.6) echo "<td>Тяжёлая </td>";
		 else if ($row['summ']>=2.1) echo "<td>Средняя</td>";
		 else if ($row['summ']>=1.1) echo "<td>Лёгкая</td>";
		 else  echo "<td>Риск заболевания </td>";
		 echo "</tr>";
  }
echo "</table>";
echo "<input value=\"Новое обледование\" type=\"button\"  onClick=\"location.href='gig_index.php?pat=".$_GET[
pat]."&osm=".$osm."&CPI=new'\"/>";
}
else
{
 //Новое обследование CPI
 echo "<form action='' method='get'>
         <table width='100%' border='0'>
            <tr>
              <td width='15%'><div align='center'>№ зуба </div></td>
              <td><div align='Left'>Признак поражения пародонта</div></td>
            </tr>
            <tr>
              <td>16</td>
              <td><div align='Left'>
                <label>
                <select name='zn['1]' id='zn[1']'>
                  <option value='0' selected='selected'>Здоровый</option>
                  <option value='1'>Зубной налёт</option>
                  <option value='2'>Кровоточивость</option>
                  <option value='3'>Зубной камень</option>
				  <option value='4'>Карман</option>
				  <option value='5'>Подвижность</option>
                </select>
                </label>
              </div></td>
            </tr>
            <tr>
              <td>11</td>
              <td><div align='Left'>
                <select name='zn['2]' id='zn[2']'>
                  <option value='0' selected='selected'>Здоровый</option>
                  <option value='1'>Зубной налёт</option>
                  <option value='2'>Кровоточивость</option>
                  <option value='3'>Зубной камень</option>
				  <option value='4'>Карман</option>
				  <option value='5'>Подвижность</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>26</td>
              <td><div align='Left'>
                <select name='zn['3]' id='zn[3']'>
                  <option value='0' selected='selected'>Здоровый</option>
                  <option value='1'>Зубной налёт</option>
                  <option value='2'>Кровоточивость</option>
                  <option value='3'>Зубной камень</option>
				  <option value='4'>Карман</option>
				  <option value='5'>Подвижность</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>36</td>
              <td><div align='Left'>
                <select name='zn['4]' id='zn[4']'>
                  <option value='0' selected='selected'>Здоровый</option>
                  <option value='1'>Зубной налёт</option>
                  <option value='2'>Кровоточивость</option>
                  <option value='3'>Зубной камень</option>
				  <option value='4'>Карман</option>
				  <option value='5'>Подвижность</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>41</td>
              <td><div align='Left'>
                <select name='zn['5]' id='zn[5']'>
                  <option value='0' selected='selected'>Здоровый</option>
                  <option value='1'>Зубной налёт</option>
                  <option value='2'>Кровоточивость</option>
                  <option value='3'>Зубной камень</option>
				  <option value='4'>Карман</option>
				  <option value='5'>Подвижность</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td>46</td>
              <td><div align='Left'>
                <select name='zn['6]' id='zn[6']'>
                 <option value='0' selected='selected'>Здоровый</option>
                  <option value='1'>Зубной налёт</option>
                  <option value='2'>Кровоточивость</option>
                  <option value='3'>Зубной камень</option>
				  <option value='4'>Карман</option>
				  <option value='5'>Подвижность</option>
                </select>
              </div></td>
            </tr>
          </table>
		  <center>
		  <input name=\"action\" type=\"hidden\" value=\"saveCPI\" />
		  <input name=\"pat\" type=\"hidden\" value=\"".$_GET['pat']."\" />
		  <input name='' type='submit'  value='Сохранить изменения'/></center></form>";
}
include("footer.php");
?>