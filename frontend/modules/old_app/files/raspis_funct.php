<?php
function ShowForm2()
{
echo "<form method='post' action='raspis_newpack.php'>
<input name='step' value='0'  type='hidden' />
  Врач 
  <label>
<select name='vrach'>";
$query = "select id,surname,name,otch from `sotr`" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}
echo "</select>
  </label>
  <br />
  Дата вступления в силу: <select name='DateDD'>";
for ($i=1; $i<32; $i++)
{
	$s="";
	if ($i==date("j")) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}
echo "</select>
  /
<select name='DateDM'' size='1'>";
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
	if ($i==$drarray[1])
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
}
echo "      </select>";
echo"/
      <select name='DateDY'>";
$s="";
for ($i=date("Y"); $i<(date("Y")+10); $i++)
{
if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
else echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select>
     <br />
  Продолжительность приёма
  <label>
  <input type='text' name='ProdPr'  size='2' maxlength='2' value='15'/>минут
  </label>
  <br />  <input name='next' type='submit' value='Дальше>>'>
</form>";
}





//                                    Старая форма
function ShowForm()
{
echo "<form method='post' action='raspis_newpack.php'>
  Врач 
  <label>
<select name='vrach'>";
$query = "select id,surname,name,otch from `sotr`" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}
echo "</select>
  </label>
  <br />
  Дата вступления в силу
  <select name='DateDD'>";
for ($i=1; $i<32; $i++)
{
	$s="";
	if ($i==date("j")) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}
echo "</select>
  /
<select name='DateDM'' size='1'>";
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
	if ($i==$drarray[1])
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
}
echo "      </select>";
echo"/
      <select name='DateDY'>";
$s="";
for ($i=1910; $i<2008; $i++)
{
if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
else echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select>
     <br />
  Рабочее место
  <label>
  <select name='rabmesto'>";
$query = "SELECT * FROM `rabmesto`" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['nazv']."</option>"; 
}
echo "  </select>
  </label>
  <br />
  Продолжительность приёма
  <label>
  <input type='text' name='ProdPr'  size='2' maxlength='2' value='30'/>минут
  </label>
  <br />
  <table width='100%' border='1' cellspacing='1'>
  <tr>
    <td><div align='center'>День недели </div></td>
    <td><div align='center'>Выходной</div></td>
    <td><div align='center'>Начало приёма </div></td>
    <td><div align='center'>Окончение приёма </div></td>
  </tr>
";
$dn=array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота","Воскресенье");
for ($j=0;$j<7;$j++)
{
echo "
<tr>
    <td>".$dn['$j']."
	<input name='dnned' type='hidden' value='".$j."'></td>
    <td>
      <div align='center'>
        <select name='vih[".$j."]'>";
if ($j<5) echo "<option value='1'>Да</option><option value='0' selected='selected'>Нет</option>";
else echo "<option value='1'  selected='selected'>Да</option><option value='0'>Нет</option>";
echo "        </select>
        </div>
    </td>
    <td>
      <div align='center'>
		<select name='nachH[".$j."]'>";
for ($i=8; $i<21; $i++)
{

	$s="";
	if ($i==8) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}		
echo "		</select>
        ч:
		<select name='nachM[".$j."]'>";
for ($i=0; $i<61; $i++)
{

	$s="";
	if ($i==0) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">0".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}			
echo "	</select>
		
        м</div>
	  </td>
    <td><div align='center'>
      <select name='okonchH[".$j."]'>";
for ($i=8; $i<21; $i++)
{

	$s="";
	if ($i==20) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}		
echo "		</select>
      ч:
<select name='okonchM[".$j."]'>";
for ($i=0; $i<61; $i++)
{

	$s="";
	if ($i==00) $s=" selected='selected'";
	if ($i<10) echo "<option value='0".$i."' ".$s.">0".$i."</option>";
	else echo "<option value='".$i."' ".$s.">".$i."</option>";
}		
echo "		</select>
      м</div></td>
  </tr>
";

} 
echo "
</table>
<input name='save' type='submit' value='Сохранить пакет'>
<input name='cancel' type='submit' value='Отменить'>
</form>";
}
?>