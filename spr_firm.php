<?php
session_start();
include('mysql_fuction.php');
$ThisVU="administrator";
$ModName="Реквизиты фирм";
include("header.php");
switch ($_GET['action'])
{
	case "add":
	switch ($_GET['step'])
	{
		case "1":
			echo "<form action='spr_firm.php' method='get' name='firmf'  id='firmf'>
					Внесите данные:<br />
					 <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
		
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>nazv</strong></p></td>
						<td nowrap='nowrap'>Название</td>
						<td nowrap='nowrap'><label>
						  <input name='nazv' type='text' id='nazv' />
						</label></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>index</strong></p></td>
						<td nowrap='nowrap'>Индекс</td>
						<td nowrap='nowrap'><input name='index' type='text' id='index' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>strana</strong></p></td>
						<td nowrap='nowrap'>Страна</td>
						<td nowrap='nowrap'><input name='strana' type='text' id='strana' value='Россия' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>region</strong></p></td>
						<td nowrap='nowrap'>Регион</td>
						<td nowrap='nowrap'><input name='region' type='text' id='region' value='Кемеровская область' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>gorod</strong></p></td>
						<td nowrap='nowrap'>Город</td>
						<td nowrap='nowrap'><input name='gorod' type='text' id='gorod' value='Новокузнецк' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>adres</strong></p></td>
						<td nowrap='nowrap'>Адрес</td>
						<td nowrap='nowrap'><input name='adres' type='text' id='adres' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>tel1</strong></p></td>
						<td nowrap='nowrap'>Телефон 1 </td>
						<td nowrap='nowrap'><input name='tel1' type='text' id='tel1' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>tel2</strong></p></td>
						<td nowrap='nowrap'>Телефон 1 </td>
						<td nowrap='nowrap'><input name='tel2' type='text' id='tel2' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>fax</strong></p></td>
						<td nowrap='nowrap'>Факс</td>
						<td nowrap='nowrap'><input name='fax' type='text' id='fax' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>eMail</strong></p></td>
						<td nowrap='nowrap'>Электр. почта </td>
						<td nowrap='nowrap'><input name='eMail' type='text' id='eMail' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>www</strong></p></td>
						<td nowrap='nowrap'>Интернет сайт </td>
						<td nowrap='nowrap'><input name='www' type='text' id='www' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>OKUD</strong></p></td>
						<td nowrap='nowrap'>Код по ОКУД </td>
						<td nowrap='nowrap'><input name='OKUD' type='text' id='OKUD' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>OKPO</strong></p></td>
						<td nowrap='nowrap'>Код по ОКПО </td>
						<td nowrap='nowrap'><input name='OKPO' type='text' id='OKPO' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>INN</strong></p></td>
						<td nowrap='nowrap'>ИНН</td>
						<td nowrap='nowrap'><input name='INN' type='text' id='INN' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>KPP</strong></p></td>
						<td nowrap='nowrap'>КПП</td>
						<td nowrap='nowrap'><input name='KPP' type='text' id='KPP' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>bank</strong></p></td>
						<td nowrap='nowrap'>Банк</td>
						<td nowrap='nowrap'><input name='bank' type='text' id='bank' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>R_sch</strong></p></td>
						<td nowrap='nowrap'>Р\сч</td>
						<td nowrap='nowrap'><input name='R_sch' type='text' id='R_sch' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>K_sch</strong></p></td>
						<td nowrap='nowrap'>К\сч</td>
						<td nowrap='nowrap'><input name='K_sch' type='text' id='K_sch' /></td>
					  </tr>
					  <tr>
						<td nowrap='nowrap'><p align='center'><strong>BIK</strong></p></td>
						<td nowrap='nowrap'>Бик</td>
						<td nowrap='nowrap'><input name='BIK' type='text' id='BIK' /></td>
					  </tr>
					</table>
					<input name='ok' type='submit'  value='Добавить'/>
					<input name='action' type='hidden' value='add' />
					<input name='step' type='hidden' value='2' />
				</form>";
				include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO `firms` (`id`, `nazv`, `index`, `strana`, `region`, `gorod`, `adres`, `tel1`, `tel2`, `fax`, `eMail`, `www`, `OKUD`, `OKPO`, `INN`, `KPP`, `bank`, `R_sch`, `K_sch`, `BIK`, `sv`) VALUES (NULL, '".$_GET['nazv']."', '".$_GET['index']."', '".$_GET['strana']."', '".$_GET['region']."', '".$_GET['gorod']."', '".$_GET['adres']."', '".$_GET['tel1']."', '".$_GET['tel2']."', '".$_GET['fax']."', '".$_GET['eMail']."', '".$_GET['www']."', '".$_GET['OKUD']."', '".$_GET['OKPO']."', '".$_GET['INN']."', '".$_GET['KPP']."', '".$_GET['bank']."', '".$_GET['R_sch']."', '".$_GET['K_sch']."', '".$_GET['BIK']."',0)" ;
				////////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret("spr_firm.php");
			break;
	}
	break;
	case "change":
	switch ($_GET['step'])
	{
		case "1":
			if (!(isset($_GET['id'])))
			{
				msg("Выбирите значение");
				ret("spr_firm.php");
			}
			$query = "SELECT * FROM `firms` WHERE id=".$_GET['id'];
			////////echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			$row = mysqli_fetch_array($result);
			echo "<form action='spr_firm.php' method='get' name='firmf'  >
			<input name='action' type='hidden' value='change' />
			<input name='step' type='hidden' value='2' />
			<input name='id' type='hidden' value='".$_GET['id']."' />
				Внесите данные:<br />
				 <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
	
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>nazv</strong></p></td>
					<td nowrap='nowrap'>Название</td>
					<td nowrap='nowrap'><label>
					  <input name='nazv' type='text' value='".$row['nazv']."' />
					</label></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>index</strong></p></td>
					<td nowrap='nowrap'>Индекс</td>
					<td nowrap='nowrap'><input name='index' type='text' value='".$row['index']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>strana</strong></p></td>
					<td nowrap='nowrap'>Страна</td>
					<td nowrap='nowrap'><input name='strana' type='text' value='".$row['strana']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>region</strong></p></td>
					<td nowrap='nowrap'>Регион</td>
					<td nowrap='nowrap'><input name='region' type='text' value='".$row['region']."'  /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>gorod</strong></p></td>
					<td nowrap='nowrap'>Город</td>
					<td nowrap='nowrap'><input name='gorod' type='text' value='".$row['gorod']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>adres</strong></p></td>
					<td nowrap='nowrap'>Адрес</td>
					<td nowrap='nowrap'><input name='adres' type='text' value='".$row['adres']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>tel1</strong></p></td>
					<td nowrap='nowrap'>Телефон 1 </td>
					<td nowrap='nowrap'><input name='tel1' type='text' value='".$row['tel1']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>tel2</strong></p></td>
					<td nowrap='nowrap'>Телефон 1 </td>
					<td nowrap='nowrap'><input name='tel2' type='text' value='".$row['tel2']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>fax</strong></p></td>
					<td nowrap='nowrap'>Факс</td>
					<td nowrap='nowrap'><input name='fax' type='text' value='".$row['fax']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>eMail</strong></p></td>
					<td nowrap='nowrap'>Электр. почта </td>
					<td nowrap='nowrap'><input name='eMail' type='text' value='".$row['eMail']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>www</strong></p></td>
					<td nowrap='nowrap'>Интернет сайт </td>
					<td nowrap='nowrap'><input name='www' type='text' value='".$row['www']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>OKUD</strong></p></td>
					<td nowrap='nowrap'>Код по ОКУД </td>
					<td nowrap='nowrap'><input name='OKUD' type='text' value='".$row['OKUD']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>OKPO</strong></p></td>
					<td nowrap='nowrap'>Код по ОКПО </td>
					<td nowrap='nowrap'><input name='OKPO' type='text' value='".$row['OKPO']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>INN</strong></p></td>
					<td nowrap='nowrap'>ИНН</td>
					<td nowrap='nowrap'><input name='INN' type='text' value='".$row['INN']."'/></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>KPP</strong></p></td>
					<td nowrap='nowrap'>КПП</td>
					<td nowrap='nowrap'><input name='KPP' type='text' value='".$row['KPP']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>bank</strong></p></td>
					<td nowrap='nowrap'>Банк</td>
					<td nowrap='nowrap'><input name='bank' type='text' value='".$row['bank']."'/></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>R_sch</strong></p></td>
					<td nowrap='nowrap'>Р\сч</td>
					<td nowrap='nowrap'><input name='R_sch' type='text' value='".$row['R_sch']."'/></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>K_sch</strong></p></td>
					<td nowrap='nowrap'>К\сч</td>
					<td nowrap='nowrap'><input name='K_sch' type='text' value='".$row['K_sch']."' /></td>
				  </tr>
				  <tr>
					<td nowrap='nowrap'><p align='center'><strong>BIK</strong></p></td>
					<td nowrap='nowrap'>Бик</td>
					<td nowrap='nowrap'><input name='BIK' type='text' value='".$row['BIK']."'/></td>
				  </tr>
				</table>
				<input name='ok' type='submit'  value='Добавить'/>
					<input name='action' type='hidden' value='change' />
					<input name='step' type='hidden' value='2' />
				<input name='ok' type='submit'  value='Изменить'/>
			</form>";
			include("footer.php");
			exit;
		break;
		case "2":
			$query = "UPDATE `firms` 
SET
`nazv`='".$_GET['nazv']."',
`index`='".$_GET['index']."', 
`strana`='".$_GET['strana']."', 
`region`='".$_GET['region']."', 
`gorod`='".$_GET['gorod']."', 
`adres`='".$_GET['adres']."', 
`tel1`='".$_GET['tel1']."', 
`tel2`='".$_GET['tel2']."', 
`fax`='".$_GET['fax']."', 
`eMail`='".$_GET['eMail']."', 
`www`='".$_GET['www']."', 
`OKUD`='".$_GET['OKUD']."', 
`OKPO`='".$_GET['OKPO']."', 
`INN`='".$_GET['INN']."', 
`KPP`='".$_GET['KPP']."', 
`bank`='".$_GET['bank']."', 
`R_sch`='".$_GET['R_sch']."', 
`K_sch`='".$_GET['K_sch']."', 
`BIK`='".$_GET['BIK']."'
WHERE id=".$_GET['id'] ;
			////////echo $query."<br>";
			$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
			ret("spr_firm.php");
		break;
	}
	break;
	case "del":
			if (!(isset($_GET['id'])))
			{
				msg("Выбирите значение");
				ret("spr_firm.php");
			}
		$query = "delete FROM `firms` WHERE `id`=".$_GET['id'] ;
		////////echo $query."<br>";
		$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
		ret("spr_firm.php");
	break;
}
echo "<form action='spr_firm.php' method='get' name='firmf'  id='firmf'>
		  <span class='mmenu'>Фирмы</span>
		  <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
 <tr>
    <td width='6%'><center>&nbsp;</center></td>
    <td width='60%' class='alltext'> <center>Название</center></td>
    <td width='34%' class='alltext'><center>Телефон</center></td>
    <td width='34%' class='alltext'><center>Факс</center></td>
  </tr>";
$query = "SELECT `id`,`tel1`,`nazv`,`fax` FROM `firms` WHERE `sv`!=1" ;
////////echo $query."<br>";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	echo " <tr>
    <td width='6%'><center><input name='id' type='radio' value='".$row[0]."'></center></td>
    <td width='60%' class='alltext'> <center>".$row[2]."</center></td>
    <td width='34%' class='alltext'><center>".$row[1]."</center></td>
    <td width='34%' class='alltext'><center>".$row[3]."</center></td>
  </tr>";
} 
echo "</table>
<input name='action' type='hidden' value='add' />
<input name='step' type='hidden' value='1' />
<input name='add' type='submit'  value='Добавить' />
<input name='change' type='submit'  value='Изменить' onclick='document.firmf.action.value=\"change\"'/>
<input name='del' type='submit'  value='Удалить' onclick='document.firmf.action.value=\"del\"'/>
		</form>";
include("footer.php");
?>