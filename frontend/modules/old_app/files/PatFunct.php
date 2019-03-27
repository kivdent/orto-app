<?php 
//include("PatFunct.php");
function PatForm()
{
//Форма для ввода данных пациента
echo "<h4>Введите данные о пациенте </h4>";
echo "<hr />";
echo "<form method='post' action='PatWork.php'>";
echo "  <table width='600' border='0'>";
echo "    <tr>";
echo "      <td width='100'>&nbsp;</td>";
echo "      <td width='304'>&nbsp;</td>";
echo "      <td width='101'>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Фамилия</td>";
echo "      <td><label>";
echo "        <input type='text' name='surname' onKeyUp='BIG(this)' onChange='BIG(this)'/>";
echo "      </label></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Имя</td>";
echo "      <td><input type='text' name='name' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Отчество</td>";
echo "      <td><input type='text' name='otch' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Дата рождения </td>";
echo "      <td>День";
echo "        <select name='drd'>";
echo "          <option value='01' selected='selected'>1</option>";
echo "          <option value='02'>2</option>";
echo "          <option value='03'>3</option>";
echo "          <option value='04'>4</option>";
echo "          <option value='05'>5</option>";
echo "          <option value='06'>6</option>";
echo "          <option value='07'>7</option>";
echo "          <option value='08'>8</option>";
echo "          <option value='09'>9</option>";
echo "          <option value='10'>10</option>";
echo "          <option value='11'>11</option>";
echo "          <option value='12'>12</option>";
echo "          <option value='13'>13</option>";
echo "          <option value='14'>14</option>";
echo "          <option value='15'>15</option>";
echo "          <option value='16'>16</option>";
echo "          <option value='17'>17</option>";
echo "          <option value='18'>18</option>";
echo "          <option value='19'>19</option>";
echo "          <option value='20'>20</option>";
echo "          <option value='21'>21</option>";
echo "          <option value='22'>22</option>";
echo "          <option value='23'>23</option>";
echo "          <option value='24'>24</option>";
echo "          <option value='25'>25</option>";
echo "          <option value='26'>26</option>";
echo "          <option value='27'>27</option>";
echo "          <option value='28'>28</option>";
echo "          <option value='29'>29</option>";
echo "          <option value='30'>30</option>";
echo "          <option value='31'>31</option>";
echo "                                        </select>";
echo "       Месяц  ";
echo "       <label>";
echo "        <select name='drm' size='1'>";
echo "          <option value='01'>Январь</option>";
echo "          <option value='02'>Февраль</option>";
echo "          <option value='03'>Март</option>";
echo "          <option value='04'>Апрель</option>";
echo "          <option value='05'>Май</option>";
echo "          <option value='06'>Июнь</option>";
echo "          <option value='07'>Июль</option>";
echo "          <option value='08'>Август</option>";
echo "          <option value='09'>Сентябрь</option>";
echo "          <option value='10'>Октябрь</option>";
echo "          <option value='11'>Ноябрь</option>";
echo "          <option value='12'>Декабрь</option>";
echo "        </select>";
echo "      Год";
echo "      <select name='dry'>";
for ($i=1910; $i <2008; $i++)
{
echo "        <option value='".$i."'>".$i."</option>";
}
echo "      </select>";
echo "      </label></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Пол</td>";
echo "      <td>";
echo "        <select name='sex'>";
echo "          <option value='Муж'>Муж</option>";
echo "          <option value='Жен'>Жен</option>";
echo "        </select></td>";

echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Адрес</td>";
echo "      <td>";
echo "        <textarea name='adres' id='adres' cols='60' rows='4' onKeyUp='BIG(this)'></textarea></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Место работы</td>";
echo "      <td><input type='text' name='MestRab' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "      <td>Профессия</td>";
echo "      <td><input type='text' name='prof' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "      <td>E-mail</td>";
echo "      <td><input type='text' name='email' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "     <td>&nbsp;</td>";
echo "   </tr>";
echo "    <tr>";

echo "      <td>Дом телефон </td>";
echo "      <td><input type='text' name='DTel' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "     <td>Раб. Телефон </td>";
echo "      <td><input type='text' name='RTel' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "      <td>Мобильный телефон </td>";
echo "      <td><input type='text' name='MTel' onKeyUp='BIG(this)' onChange='BIG(this)'/></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "      <td>Форма лечения </td>";
echo "      <td><select name='FLech' size='1' >";
echo "        <option value='nal'>Наличные</option>";
echo "        <option value='dog'>По договору</option>";
echo "        <option value='strah'>Страховка</option>";
echo "            </select></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "      <td>Скидка</td>";
echo "      <td><select name='Skidka'>";
$query = "SELECT *
FROM skidka" ;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
//////echo $query."<br />";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if($row['id']==$rowA['Skidka']) echo "<option value='".$row['id']."' selected='selected'>".$row['naimenov']."</option>";
	else echo "<option value='".$row['id']."' >".$row['naimenov']."</option>";
}
echo "
</select>
</td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";

echo "      <td>Примечание</td>";
echo "      <td><textarea name='Prim' cols='60' rows='4'></textarea></td>";
echo "      <td>&nbsp;</td>";
echo "    </tr>";
echo "  </table>";
echo "<input name='Save' type='submit' value='Сохранить' />";
echo "<input type='submit' name='Cancel' value='Отменить' />";
echo "<input value='Очистить'  type='reset'/>";
echo "</form>";
}
//
//
//Отображение всех пациентов клиники
function ShowPat()
{
include('mysql_fuction.php');    
echo "<form action=\"pat.php\" method=\"post\" name='fform' id='fform'>
<center><h3 align=center><strong>Пациенты клиники</strong></h3>
<a href='#' OnClick='findp1(\"А\")' class='head2'>А</a>|
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

 <table width='100%' border='0'>
  <tr>
    <td width='33%'><center>";

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
	echo "
	</center></td>
    <td width=\"67%\" VALIGN=top>
</table>
</form>";
////////echo $query;
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
echo "<form action='PatWork.php' method='post' name='patel' id='patel'>";
echo "<table width='100%' border='0'>
  <tr>
    <td width='33%'><center>";
if ($count>0)
{
if ($count>15) echo "<select name='element' size='15'  id='element' onClick=\"ShowInfo(this)\" ondblclick=\"OpenWin()\">";
else echo "<select name='element' id='element' size='".$count."' onClick=\"ShowInfo(this)\" ondblclick=\"OpenWin()\">";	
	$aNum=	"";
	$aName=	"";
	$aSname="";
	$aOtch=	"";
	$aRt=	"";
	$aDt=	"";
	$aSt=	"";
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "<option value=".$row['id'].">".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	if ($i==0)
	{
		$aNum.="aNum=new Array(\"".$row['id']."\"";
		$aName.="aName=new Array(\"".$row['name']."\"";
		$aSname.="aSname=new Array(\"".$row['surname']."\"";
		$aOtch.="aOtch=new Array(\"".$row['otch']."\"";
		$aRt.="aRt=new Array(\"".$row['RTel']."\"";
		$aDt.="aDt=new Array(\"".$row['DTel']."\"";
		$aSt.="aSt=new Array(\"".$row['MTel']."\"";
	}
	else
	{
		$aNum.=", \"".$row['id']."\"";
		$aName.=", \"".$row['name']."\"";
		$aSname.=", \"".$row['surname']."\"";
		$aOtch.=", \"".$row['otch']."\"";
		$aRt.=", \"".$row['RTel']."\"";
		$aDt.=", \"".$row['DTel']."\"";
		$aSt.=", \"".$row['MTel']."\"";
	}
}
$aNum.=");";
$aName.=");";
$aSname.=");";
$aOtch.=");";
$aRt.=");";
$aDt.=");";
$aSt.=");";
echo "</select><br />";
echo "<script language='JavaScript' type='text/javascript'>";
echo $aNum;
echo $aName;
echo $aSname;
echo $aOtch;
echo $aRt;
echo $aDt;
echo $aSt;
echo "</script>";
}
else
{
	msg('Ничего не найдено');
	ret('pat.php');
}
//echo "<table width=100% border=1 cellspacing=1>";
//echo "<tr>";
//echo    "<td width=10%>&nbsp;</td>";
//echo    "<td width=30%>Фамилия</td>";
//echo    "<td wIDTH=25%>Имя</td>";
//echo    "<td wIDTH=25%>Отчество</td>";
//echo    "<td width=10%>Дата рождения</td>";
//echo  "</tr>";
//for ($i=0; $i <$count; $i++)
//{
//$row = mysqli_fetch_array($result);
//echo "<tr>";
//echo    "<td width=10%><input value='".$row['id']."' name=\"element\" type=\"radio\">".$row['id']."</td>";
//echo    "<td width=28%>".$row['surname']."</td>";
//echo    "<td wIDTH=22%>".$row['name']."</td>";
//echo    "<td wIDTH=17%>".$row['otch']."</td>";
//echo    "<td width=8%>".$row['dr']."</td>";
//echo  "</tr>";
//}
//echo "</table>";

echo "</center></td>
    <td width=\"67%\" VALIGN=top><script language=\"JavaScript\" type=\"text/javascript\">
function OpenWin()
{";

if (($_SESSION['valid_user']=="administrator") or ($_SESSION['valid_user']=="registrator") or ($_SESSION['valid_user']=="glVrach") or ($_SESSION['valid_user']=="directorh")) echo "myWin= open('pat_card.php?id='+document.patel.element.options[document.patel.element.selectedIndex].value+'&ro=0');";
else  echo "myWin= open('pat_card.php?id='+document.patel.element.options[document.patel.element.selectedIndex].value+'&ro=1');";

echo "
}
</script>";
echo "Карта № <input name='NCard' type='text' size='9' maxlength='5' /><br /><br />
Пациент: <input name='PatName' type='text'  size='75'/><br /><br />
ТД: <input name='TelDom' type='text' />&nbsp;ТС: <input name='TelSot' type='text' />&nbsp;ТР: <input name='TelRab' type='text' />

<hr align='center' width='100%' size='1' color='#999999'  />
<center><input name='Input' type='button' value='Показать карту' onclick='OpenWin()'/>&nbsp;
  <input name=add type=submit value='Добавить пациента' />&nbsp;
 <!--  <input name=del type=submit value='Удалить пациента' /><br /> --></center>

 </td></tr>
</table>
<br /></form></center>";
}
?>