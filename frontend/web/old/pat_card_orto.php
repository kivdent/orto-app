<?php
$ThisVU="all";
$ModName="Работа с ортодонтическими картами"; 
$js="ShowPat";
include("header.php");
switch ($_GET['action'])
{
	case "new":
		switch ($_GET['step'])
		{
			case "1":
				$query = "SELECT `id` FROM `orto_sh` WHERE `pat`=".$_GET['element'];
				////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($count>0) ret("pat_card_orto.php?element=".$_GET['element']."&action=ch&step=1");
				$query = "SELECT `surname`,`name`, `otch` FROM `klinikpat` WHERE `id`=".$_GET['element'];
				////echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$_SESSION['pat']=$_GET['element'];
				$_SESSION['pat_name']=$row['surname']." ".$row['name']." ".$row['otch'];
				echo "<form action='pat_card_orto.php' method='get' name='shForm' id='shForm'>";
						echo "<div class='head3'>Пациент: ".$_SESSION['pat_name']."</div>
			            <div class='head3'>Сотавление схемы оплаты за лечение на брекетах</div>
						Врач: <select name='vrach'>";
$query = "select id,surname,name,otch from `sotr` WHERE `dolzh` in (1, 2, 3) ORDER BY surname" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}

						echo "</select><br />

Стоимость аппаратуры: <input name='StApp' type='text' onKeyUp='rassch()'/><br />
							  Срок лечения: <select name='Srok' id='Srok' onChange='rassch()'>";

						for ($i=1;$i<=36;$i++)
						{
							if ($i==1)	echo "<option value='".$i."' selected='selected'>".$i." мес</option>";
							else echo "<option value='".$i."'>".$i." мес</option>";
						}
						echo "</select>";
						echo "<script language='JavaScript' type='text/javascript'>
						function rassch()
						{
							z=Math.floor(
							(
							document.shForm.StApp.value/parseInt
							(
							document.shForm.Srok.options['document.shForm.Srok.selectedIndex'].value
							)
							)/100
							)*100;
							document.shForm.PerMonth.value=z;
						}
						</script><br />

						Оплата в месяц: <input name='PerMonth' id='PerMonth' type='text' /><br />
						Первая оплата: <select name='NDateDD'>";
		for ($i=1;$i<32; $i++)
		{
			$s="";
			if ($i==date("j")) $s=" selected='selected'";
			if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
			else echo "<option value='".$i."' ".$s.">".$i."</option>";
		}
		echo "</select> /
<select name='NDateDM' size='1'>";
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
		for ($i=1910; $i<2009; $i++)
		{
		if ($i==date("Y")) echo "<option value='".$i."' selected='selected'>".$i."</option>";
		else echo "<option value='".$i."'>".$i."</option>";
		}
		echo "      </select><br />
						Уже оплачено месяцев: <select name='OplMonth' id='OplMonth'/>";	  		for ($i=1;$i<=36;$i++)
		{
				if ($i==1)	echo "<option value='".$i."' selected='selected'>".$i." мес</option>";
				else echo "<option value='".$i."'>".$i." мес</option>";
		}
						echo "</select><br />
Месяц последней оплаты: <select name='LastM' size='1'>";
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
		echo "      </select><br />
						<input name='' Value='Сохранить' type='Submit'/>";
						echo "<input name='action' type='hidden' value='new' />
							<input name='step' type='hidden' value='2' />";
						echo "</form>";
				include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO `orto_sh` (`id`, `pat`, `sotr`, `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `full`,`last_pay_month`)
												VALUES (NULL, ".$_SESSION['pat'].", ".$_GET['vrach'].",'".($_GET['NDateDY']."-".$_GET['NDateDM']."-".$_GET['NDateDD'])."', ".$_GET['Srok'].", ".$_GET['StApp'].", ".$_GET['PerMonth'].", ".($_GET['PerMonth']*$_GET['OplMonth']).", 0,".$_GET['LastM'].")";
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				ret("pat_card_orto.php");
				unset($_SESSION['pat']);
				unset($_SESSION['pat_name']);
				include("footer.php");
				exit;
			break;
		}
	break;
		case "ch":
		switch ($_GET['step'])
		{
			case "1":
				$query = "SELECT `id`, `pat`, `sotr`, `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `full`, `last_pay_month` FROM `orto_sh` 
					WHERE ((`pat`=".$_GET['element'].") AND ((`summ`!=`vnes`) OR (`full`=0)))" ;
				////echo $query."<br />";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				if ($count>0)
				{
				$row = mysqli_fetch_array($result);
				$_SESSION['id']=$row['id'];
				$_SESSION['sotr']=$row['sotr'];
				$_SESSION['dt']=explode("-",$row['date']);
				$_SESSION['per_lech']=$row['per_lech'];
				$_SESSION['summ']=$row['summ'];
				$_SESSION['summ_month']=$row['summ_month'];
				$_SESSION['vnes']=$row['vnes'];
				$_SESSION['last_pay_month']=$row['last_pay_month'];
				}
				else
				{
					msg("Пациент оплатил ортодонтию полностью");
					unset($_SESSION['id']);
					unset($_SESSION['sotr']);
					unset($_SESSION['dt']);
					unset($_SESSION['per_lech']);
					unset($_SESSION['summ']);
					unset($_SESSION['summ_month']);
					unset($_SESSION['vnes']);
					unset($_SESSION['last_pay_month']);
					unset($_SESSION['pat']);
					unset($_SESSION['pat_name']);
					ret("pat_card_orto.php");
					include("footer.php");
					exit;
				}
				$query = "SELECT `surname`,`name`, `otch` FROM `klinikpat` WHERE `id`=".$_GET['element'];
				////echo $query;
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$_SESSION['pat']=$_GET['element'];
				$_SESSION['pat_name']=$row['surname']." ".$row['name']." ".$row['otch'];
				echo "<form action='pat_card_orto.php' method='get' name='shForm' id='shForm'>";
						echo "<div class='head3'>Пациент: ".$_SESSION['pat_name']."</div>
			            <div class='head3'>Редактирование схемы оплаты за лечение на брекетах</div>
						Врач: <select name='vrach'>";
$query = "select id,surname,name,otch from `sotr` WHERE `dolzh` in (1, 2, 3) ORDER BY surname" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i=0; $i <$count; $i++)
{
$row = mysqli_fetch_array($result);
if ($row['id']==$_SESSION['sotr']) echo "<option value='".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}
echo "</select><br />";

echo "Стоимость аппаратуры: <input name='StApp' type='text' onKeyUp='rassch()'  value='".$_SESSION['summ']."'/><br />";
echo "Срок лечения: <select name='Srok' id='Srok' onChange='rassch()'>";

						for ($i=1;$i<=36;$i++)
						{
							if ($i==$_SESSION['per_lech'])	echo "<option value='".$i."' selected='selected'>".$i." мес</option>";
							else echo "<option value='".$i."'>".$i." мес</option>";
						}
						echo "</select>";
						echo "<script language='JavaScript' type='text/javascript'>
						function rassch()
						{
							z=Math.floor(
							(
							document.shForm.StApp.value/parseInt
							(
							document.shForm.Srok.options['document.shForm.Srok.selectedIndex'].value
							)
							)/100
							)*100;
							document.shForm.PerMonth.value=z;
						}
						</script><br />

						Оплата в месяц: <input name='PerMonth' id='PerMonth' type='text'  value='".$_SESSION['summ_month']."'/><br />
						Первая оплата: <select name='NDateDD'>";
		for ($i=1;$i<32; $i++)
		{
			$s="";
			if ($i==$_SESSION['dt][2']) $s=" selected='selected'";
			if ($i<10) echo "<option value='0".$i."' ".$s.">".$i."</option>";
			else echo "<option value='".$i."' ".$s.">".$i."</option>";
		}
		echo "</select> /
<select name='NDateDM' size='1'>";
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

					if ($i==$_SESSION['dt][1']) echo "<option value='0".$i."' selected='selected".$s."</option>";
					else echo "<option value='0".$i.$s."</option>";
		}
			else
				{
					if ($i==$_SESSION['dt][1']) echo "<option value='".$i."' selected='selected".$s."</option>";
					else echo "<option value='".$i.$s."</option>";
				}
		
		}
		echo "      </select>";
		echo"/
			  <select name='NDateDY'>";
		$s="";
		for ($i=1910; $i<(date("Y")+1); $i++)
		{
		if ($i==$_SESSION['dt][0']) echo "<option value='".$i."' selected='selected'>".$i."</option>";
		else echo "<option value='".$i."'>".$i."</option>";
		}
		echo "      </select><br />
		Оплачено: <input name='vnes' type='text' value='".$_SESSION['vnes']."'/><br />
Месяц последней оплаты: <select name='LastM' size='1'>";
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

					if ($i==$_SESSION['last_pay_month']) echo "<option value='0".$i."' selected='selected".$s."</option>";
					else echo "<option value='0".$i.$s."</option>";
		}
			else
				{
					if ($i==$_SESSION['last_pay_month']) echo "<option value='".$i."' selected='selected".$s."</option>";
					else echo "<option value='".$i.$s."</option>";
				}
		
		}
		echo "      </select><br />
						<input name='' Value='Сохранить' type='Submit'/>";
						echo "<input name='action' type='hidden' value='ch' />
							<input name='step' type='hidden' value='2' />";
						echo "</form>";
				include("footer.php");
				exit;
			break;
			case "2":
				$query = "UPDATE `orto_sh` 
				SET
				`sotr`=".$_GET['vrach'].", 
				`date`='".($_GET['NDateDY']."-".$_GET['NDateDM']."-".$_GET['NDateDD'])."', 
				`per_lech`=".$_GET['Srok'].", 
				`summ`=".$_GET['StApp'].", 
				`summ_month`=".$_GET['PerMonth'].", 
				`vnes`=".$_GET['vnes'].", 
				`last_pay_month`=".$_GET['LastM']."
				WHERE `id`=".$_SESSION['id'];
				////echo $query."<br>";
				$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
				//ret("pat_card_orto.php");
				unset($_SESSION['id']);
					unset($_SESSION['sotr']);
					unset($_SESSION['dt']);
					unset($_SESSION['per_lech']);
					unset($_SESSION['summ']);
					unset($_SESSION['summ_month']);
					unset($_SESSION['vnes']);
					unset($_SESSION['last_pay_month']);
				unset($_SESSION['pat']);
				unset($_SESSION['pat_name']);
				include("footer.php");
				exit;
			break;
		}
	break;
}
echo "<center>Выбирите пациента:<br />
		<form name='fform' id='fform' method='post' action='pat_card_orto.php'>
		<br><a href='#' OnClick='findp1(\"А\")' class='head2'>А</a>|
<a href='#' OnClick='findp1(\"Б\")' class='head2'>Б</a>|
<a href='#' OnClick='findp1(\"В\")' class='head2'>В</a>|
<a href='#' OnClick='findp1(\"Г\")' class='head2'>Г</a>|
<a href='#' OnClick='findp1(\"Д\")' class='head2'>Д</a>|
<a href='#' OnClick='findp1(\"Е\")' class='head2'>Е</a>|
<a href='#' OnClick='findp1(\"Ё\")' class='head2'>Ё</a>|
<a href='#' OnClick='findp1(\"Ж\")' class='head2'>Ж</a>|
<a href='#' OnClick='findp1(\"З\")' class='head2'>З</a>|
<a href='#' OnClick='findp1(\"И\")' class='head2'>И</a>|
<a href='#' OnClick='findp1(\"Й\")' class='head2'>Й</a>|
<a href='#' OnClick='findp1(\"К\")' class='head2'>К</a>|
<a href='#' OnClick='findp1(\"Л\")' class='head2'>Л</a>|
<a href='#' OnClick='findp1(\"М\")' class='head2'>М</a>|
<a href='#' OnClick='findp1(\"Н\")' class='head2'>Н</a>|
<a href='#' OnClick='findp1(\"О\")' class='head2'>О</a>|
<a href='#' OnClick='findp1(\"П\")' class='head2'>П</a>|
<a href='#' OnClick='findp1(\"Р\")' class='head2'>Р</a>|
<a href='#' OnClick='findp1(\"С\")' class='head2'>С</a>|
<a href='#' OnClick='findp1(\"Т\")' class='head2'>Т</a>|
<a href='#' OnClick='findp1(\"У\")' class='head2'>У</a>|
<a href='#' OnClick='findp1(\"Ф\")' class='head2'>Ф</a>|
<a href='#' OnClick='findp1(\"Х\")' class='head2'>Х</a>|
<a href='#' OnClick='findp1(\"Ц\")' class='head2'>Ц</a>|
<a href='#' OnClick='findp1(\"Ч\")' class='head2'>Ч</a>|
<a href='#' OnClick='findp1(\"Ш\")' class='head2'>Ш</a>|
<a href='#' OnClick='findp1(\"Щ\")' class='head2'>Щ</a>|
<a href='#' OnClick='findp1(\"Э\")' class='head2'>Э</a>|
<a href='#' OnClick='findp1(\"Ю\")' class='head2'>Ю</a>|
<a href='#' OnClick='findp1(\"Я\")' class='head2'>Я</a>
<br>
";
		  if ($_POST['FindFl']!='1')
{
	$query = 'select id,surname,name,otch,dr from klinikpat order by surname';
echo "<input name=\"find\" type=\"text\" onKeyUp='findP(this)' tabindex='1'/><br />
<input name=\"FindFl\" type=\"hidden\" value=\"0\" />";
$query = "select id,surname,name,otch,dr,DTel, RTel, MTel from klinikpat
		where  surname like 'А%' 
		order by surname ASC";
}
else
{
	$query = "select id,surname,name,otch,dr,DTel, RTel, MTel from klinikpat 
	where  surname like '".$_POST['find']."%'
	order by surname";
	echo "
<input name=\"find\" type=\"text\" value='".$_POST['find']."' onKeyUp='findP(this)' tabindex='1'/><br />
<input name=\"FindFl\" type=\"hidden\" value=\"0\" />";
}
		  echo "</form>
		<form id='OPForm' name='OPForm' method='get' action='pat_card_orto.php'>";
		  //////echo $query;
           $result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
if ($count>0)
{
	if ($count>15) echo "<select name='element' size='15'  id='element'>";
	else echo "<select name='element' id='element' size='".$count."'>";	
	for ($i=0; $i<$count; $i++)
	{
		$row = mysqli_fetch_array($result);
		echo "<option value=".$row['id'].">".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	}
	echo "</select>";	
}
else
{
	echo "Ничего не найдено";
}
		  echo "<br /><br />
<input name='action' type='hidden' value='new' />
<input name='step' type='hidden' value='1' />
<input name='' type='submit' Value='Дальше'/>
           </form>
		</center>";
include("footer.php");
?>
