<?php

include('mysql_fuction.php');

$ThisVU="all";
$this->title="Карта пациента"; 
$js="ShowPat";
//include("header2.php");
if ($ro==1) $disabled="disabled='disabled'";
else $disabled="";
$query="select * from klinikpat where id='".$id."'";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$rowA = mysqli_fetch_array($result);
echo "<center><span class='head1' >Карта  №".$_GET['id']." ";
$query = "SELECT `surname`,`name`,`otch` FROM `klinikpat` WHERE `id`='".$_GET['id']."'" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);    
	echo $row['surname']." ".$row['name']." ".$row['otch']." "."</span></center>
          <center><a href='pat_card.php?id=".$_GET['id']."' class='mmenu'>Основные сведения</a>| 
		  <a href='pat_card.php?id=".$_GET['id']."&action=medcard' class='mmenu'>Медицинская карта</a>|
		  <a href='pat_card.php?id=".$_GET['id']."&action=ter' class='mmenu'>Терапия </a>|
		  <a href='pat_card.php?id=".$_GET['id']."&action=ortd'class='mmenu'>Ортодонтия</a>|
		  <a href='pat_card.php?id=".$_GET['id']."&action=ortp' class='mmenu'>Ортопедия </a>
		  |<a href='pat_card.php?id=".$_GET['id']."&action=disp' class='mmenu'>Диспансеризация</a>"
                . "|<a href='pat_card.php?id=".$_GET['id']."&action=stat' class='mmenu'>Статистика</a>";
if (($_SESSION['valid_user']=="ortoped") or ($_SESSION['valid_user']=="ortodont") or ($_SESSION['valid_user']=="administrator")) echo "| <a href='pat_card.php?id=".$_GET['id']."&action=orto_sh' class='mmenu'>Схема оплаты за ортодонтию</a>";
 echo "</center>";
function ShowOsnSved($id,$ro)
{	 
$query="select * from klinikpat where id='".$id."'";
if ($ro==1) $disabled="disabled='disabled'";
else $disabled="";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$rowA = mysqli_fetch_array($result);
echo "<form method='post' action='PatWork.php'>";
echo "<input ".$disabled." name='id' type='hidden' value='".$rowA['id']."' onKeyUp='BIG(this)'/>";
echo "  <table width='100%' border='1'>";
echo "    <tr>";
echo "      <td width='40'>&nbsp;</td>";
echo "      <td width='60'>&nbsp;</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Фамилия</td>";
echo "      <td><label>";
echo "        <input ".$disabled." type='text' name='surname' value='".$rowA['surname']."' onKeyUp='BIG(this)'/>";
echo "      </label></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Имя</td>";
echo "      <td><input ".$disabled." type='text' name='name' value='".$rowA['name']."' onKeyUp='BIG(this)'/></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Отчество</td>";
echo "      <td><input ".$disabled." type='text' name='otch' value='".$rowA['otch']."' onKeyUp='BIG(this)'/></td>";
echo "    </tr>";
echo "    <tr>";
$drarray=explode("-",$rowA['dr']);
$drarray[0]=(Integer)$drarray[0];
$drarray[1]=(Integer)$drarray[1];
$drarray[2]=(Integer)$drarray[2];
echo "      <td>Дата рождения</td>";
echo "      <td>День";
echo "       <select ".$disabled."  name='drd'>";
$s="";
for ($i=1; $i<32; $i++)
{
if ($i<10)
{
if ($i==$drarray[2])
        if ($i==$drarray[2]) echo "<option value='0".$i."' selected='selected'>".$i."</option>";
        if (!($i==$drarray[2])) echo "<option value='0".$i."'>".$i."</option>";
}
else
        {
        if ($i==$drarray[2]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
        if (!($i==$drarray[2])) echo "<option value='".$i."'>".$i."</option>";
        }
}
echo "        </select>";
echo "       Месяц  ";
echo "       <label>";
echo "        <select ".$disabled."  name='drm' size='1'>";
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
        if ($i==$drarray[1]) echo "<option value='0".$i."' selected='selected".$s."</option>";
        if (!($i==$drarray[1])) echo "<option value='0".$i.$s."</option>";
}
else
{
        if ($i==$drarray[1]) echo "<option value='".$i."' selected='selected".$s."</option>";
        if (!($i==$drarray[1])) echo "<option value='".$i.$s."</option>";
}
}
echo "        </select>";
echo "      Год";
echo "      <select ".$disabled."  name='dry'>";
$s="";
for ($i=1910; $i<(date('Y')+1); $i++)
{
	if ($i==$drarray[0]) echo "<option value='".$i."' selected='selected'>".$i."</option>";
	else echo "<option value='".$i."'>".$i."</option>";
}
echo "      </select>";
echo "      </label></td>";
echo "    </tr>";
echo "      <td>Пол</td>";
echo "      <td>";
echo "        <select ".$disabled."  name='sex'>";
if ($rowA['sex']==='Муж')
{
	echo "          <option value='Муж' selected='selected'>Муж</option>";
	echo "          <option value='Жен'>Жен</option>";
}
else
{
	echo "          <option value='Муж'>Муж</option>";
	echo "          <option value='Жен' selected='selected'>Жен</option>";
}
echo "        </select></td>";

echo "    </tr>";
echo "    <tr>";
echo "      <td>Адрес</td>";
echo "      <td>";
echo "        <textarea name='adres' cols='60' rows='4' onKeyUp='BIG(this)'>".$rowA['adres']."</textarea></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Место работы</td>";
echo "      <td><input ".$disabled." type='text' name='MestRab' value='".$rowA['MastRab']."' onKeyUp='BIG(this)'/></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Профессия</td>";
echo "      <td><input ".$disabled." type='text' name='prof' value='".$rowA['Prof']."' onKeyUp='BIG(this)'/></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>E-mail</td>";
echo "      <td><input ".$disabled." type='text' name='email' value='".$rowA['email']."' onKeyUp='BIG(this)'/></td>";
echo "   </tr>";
echo "    <tr>";
echo "      <td>Дом телефон </td>";
echo "      <td><input ".$disabled." type='text' name='DTel' value='".$rowA['DTel']."'/></td>";
echo "    </tr>";
echo "    <tr>";
echo "     <td>Раб. Телефон </td>";
echo "      <td><input ".$disabled." type='text' name='RTel' value='".$rowA['RTel']."'/></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Мобильный телефон </td>";
echo "      <td><input ".$disabled." type='text' name='MTel' value='".$rowA['MTel']."'/></td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Скидка</td>";
echo "      <td><select ".$disabled."  name='Skidka'>";
$query = "SELECT *
FROM skidka" ;
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if($row['id']==$rowA['Skidka']) echo "<option value='".$row['id']."' selected='selected'>".$row['naimenov']."</option>";
	else echo "<option value='".$row['id']."' >".$row['naimenov']."</option>";
}
echo "
</select>
</td>";
echo "    </tr>";
echo "    <tr>";
echo "      <td>Примечание </td>";
echo "      <td><textarea ".$disabled." name='Prim' cols='60' rows='4' value='".$rowA['Prim']."' onKeyUp='BIG(this)'></textarea></td>";
echo "    </tr>";
echo "  </table>";
echo "<input ".$disabled." name='Change' type='submit' value='Сохранить изменения' />";
echo "<input ".$disabled." type='submit' name='Cancel' value='Отменить' />";
echo "<input ".$disabled." value='Очистить'  type='reset'/>
<input ".$disabled." name='pred' type='hidden' value='PC'>";
echo "</form>";
}
function ShowTer($id)
{

	$tables=array ("dnev");
	for ($j=0;$j<=0;$j++)
	{
		$query = "SELECT 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`".$tables[$j]."`.`id`,
		`".$tables[$j]."`.`zh`, 
		`".$tables[$j]."`.`an`, 
		`".$tables[$j]."`.`obk`, 
		`".$tables[$j]."`.`lech`, 
		`".$tables[$j]."`.`date`,
		`".$tables[$j]."`.`summ_k_opl`
		FROM sotr, ".$tables[$j]."
		WHERE 
		((".$id." =`".$tables[$j]."`.`pat`) AND
		(`sotr`.`id`=`".$tables[$j]."`.`vrach`))
		ORDER BY `".$tables[$j]."`.`date`";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);

//	$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `dnev`.`zh`, `dnev`.`an`, `dnev`.`obk`, `dnev`.`lech`, `dnev`.`date`, `dnev`.`ds`,`dnev`.`id`
//FROM sotr, dnev
//WHERE ((`sotr`.`id` =`dnev`.`vrach`) AND (`dnev`.`pat` =".$id."))
//ORDER BY `dnev`.`date` DESC";
//echo $query."<br>";
//$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
if (!($count>0))
{
	echo "<div class='head1'>Записей в карте нет</div>";	
}

echo "<form method='post' action='PatWork.php'>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode('-',$row['date']);
	echo "<input ".$disabled." name='id' type='hidden' value='1' />
		      <br />
		      <div align=\"center\"><span class='head3'>Дата: ".$dt[2].".".$dt[1].".".$dt[0]."</br> 
		      <a class='head2' href='print.php?type=pat&card=".$row['id']."' tarGET='_blank'>Печать карты</a>|
<a class='head2' tarGET='_blanc' href=\"show.php?type=chek&dnev=".$row['id']."&table=".$tables[$j]."&podr=1\">Просмотр оплаты (".$row['summ_k_opl']." руб.)</a>|
<a class='head2' tarGET='_blanc' href=\"\">Редактировать запись</a>

<br /></div>
		      <span class='head3'>Врач: ".$row['surname']." ".$row['name']." ".$row['otch']."</span><br />
		      <span class='head2'>Жалобы:</span>".$row['zh']."<br />
		      <span class='head2'>Анамнез:</span>".$row['an']."<br />
		      <span class='head2'>Обективно:</span>".$row['obk']."<br />
		      <span class='head2'>Диагноз:</span>".$row['ds']."<br />
		      <span class='head2'>Лечение:</span>".$row['lech']."<br />
			  <hr width='100%' noshade='noshade' size='1'/>";
			 // echo "<center><a href='print.php?type=pat&card=".$row['id']."' tarGET='_blank'>Печать карты</a></center>";
}
}
echo "</form>";
}
function ShowMC($id)
{
		
if (isset($_GET['step']))
{

	$z=$_GET['Nzub'];
	reset($z);
	if (isset($_GET['OsmID']))
	{
		$query = "DELETE FROM osmotr WHERE id=".$_GET['OsmID'];
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$query = "DELETE FROM sostzubosm WHERE Osmotr=".$_GET['OsmID'];
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	}
	$query = "INSERT INTO `osmotr` (`id`, `Date`, `Perv`, `Pat`)
							VALUES(NULL,'".date('Y-m-d')."', '".$_GET['perv']."', '".$_GET['id']."')" ;
	//echo $query."<br>";
	$osm=sql_query($query,'orto',0);    
	$query = "INSERT INTO `sostzubosm` (`id`, `NZuba`, `SostZuba`, `Osmotr`) 
VALUES ";
	$kpu=0;
	for ($i=1;$i<=32;$i++)
	{
	if ($z[$i]!=10) $kpu++;
	if ($i==1)
			$query.=" (NULL, ".$i.", ".$z[$i].", ".$osm.")";

		else $query.=", (NULL, ".$i.", ".$z[$i].", ".$osm.")";	
	}
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$query = "INSERT INTO `kpu` (`id`, `summ`,`date`,`pat`) 
								VALUES (NULL, ".$kpu.", '".date('Y-m-d')."','".$_GET['id']."')";
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	ret("pat_card.php?id=".$_GET['id']."&action=medcard");
}
//Отображение зубной формулы
////Фамилия
// 	$query = "SELECT `surname`,`name`,`otch` FROM `klinikpat` WHERE `id`='".$_SESSION['pat']."'" ;
	//echo $query."<br>";
//	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//	$row = mysqli_fetch_array($result);    
//	echo "<div class='head1'>Пациент: ".$row['surname']." ".$row['name']." ".$row['otch']." "."</div>";
//	echo " <center><a href='pat_card.php?id=".$id."' class='mmenu'>Основные сведения</a>| 
//		  <a href='pat_card.php?id=".$id."&action=medcard' class='mmenu'>Медицинская карта</a>|
//		  <a href='pat_card.php?id=".$id."&action=ter' class='mmenu'>Терапия </a>|
//		  <a href='pat_card.php?id=".$id."&action=ortd'class='mmenu'>Ортодонтия</a>|
//		  <a href='pat_card.php?id=".$id."&action=ortp' class='mmenu'>Ортопедия </a></center>";
//	//Предупреждение
	$_SESSION['pat']=$id;
						$query = "SELECT `id`, `obozn` FROM `sz`";
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$sz['count']=$count;
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$sz[$i]['id']=$row['id'];
					$sz[$i]['sz']=$row['obozn'];
				}

	if (!(isset($_SESSION['OsmID'])))
	{

	     		$query = "SELECT `osmotr`.`id`
						FROM osmotr
						WHERE (`osmotr`.`Pat` ='".$_SESSION['pat']."')
						ORDER BY `osmotr`.`Date` DESC" ;
						//echo $query."<br>";
						$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				if ($count>0)
				{
					$row = mysqli_fetch_array($result);
					$_SESSION['OsmID']=$row['id'];
				}
				else 
				{
					//echo "<div class='head1'>Этому пациенту не было произведено ни одного осмотра.</div>
					//<a href='pat_tooday_work.php?action=osm&step=1&pat=$_SESSION['pat']&perv=0' class='mmenu'>Провести осмотр</a>";
					$_SESSION['OsmID']=0;
					////include("footer.php");
					//exit;
				}
	
	}
	echo "		<form  action='pat_card.php' method='GET' >
		<input name='action' type='hidden' value='medcard' />
		<input name='step' type='hidden' value='2' />
		<input name='id' type='hidden' value='".$_SESSION['pat']."' />";
	if ($_SESSION['OsmID']!=0)
	{
	$query = "SELECT `allvid`.`vid`, `allproyav`.`proyav`
				FROM medcard, allergmc, allvid, allproyav
				WHERE ((`medcard`.`PatID` ='".$_SESSION['pat']."') AND 
				(`allergmc`.`MedCardID` =`medcard`.`id`) AND 
				(`allvid`.`id` =`allergmc`.`AllVidID` ) AND 
				(`allproyav`.`id` =`allergmc`.`AllProyavID`))" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	if ($count>0)
	{		
		echo "<div class='feature5'>Упациента аллергия: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo $row['vid']."(".$row['proyav'].") ";
		}
	 echo "</div>";
	}
		$query = "SELECT `allvid`.`vid` 
FROM medcard, allergmc, allvid, allproyav
WHERE (
(
`medcard`.`PatID` = '".$_SESSION['pat']."'
)
AND (
`allergmc`.`MedCardID` = `medcard`.`id` 
)
AND (
`allvid`.`id` = `allergmc`.`AllVidID` 
)
AND (
`allergmc`.`AllProyavID` =0
)
)
" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	if ($count>0)
	{		
		echo "<div class='head2'>Упациента аллергия: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo $row['vid']."  ";
		}
    echo "</div>";
	}
	$query = "SELECT `sopzab`.`zab`
	FROM sopzab, sopzabmc,medcard
	WHERE ((`medcard`.`PatID` ='".$_SESSION['pat']."') AND
	       (`sopzabmc`.`MedCardID` =`medcard`.`id`) AND 
		   (`sopzab`.`id` =`sopzabmc`.`ZabolevID`) )" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	if ($count>0)
	{		
		echo "<div class='head2'>Сопутствующие заболевания: ";
		for ($i=0;$i<$count;$i++)
		{
			$row = mysqli_fetch_array($result);
			echo $row['zab']." ";
		}
         echo "</div>";
	}
	$query = "SELECT `advid`.`vid`, `medcard`.`ADZnach`
	FROM advid, medcard
	WHERE ((`advid`.`id` =`medcard`.`ADVid`) AND (`medcard`.`PatID`  ='".$_SESSION['pat']."'))" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	echo "<div class='head2'>АД пациента: ".$row['vid']."(".$row['ADZnach'].")</div>";

	
		  echo "<div class='head2'>Зубная формула</div>";
		    echo "<input name='OsmID' type='hidden' value='".$_SESSION['OsmID']."' />
		    <table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";
				//Заполняем 10 сегмент
				echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
					$query = "SELECT `nzuba`.`NZuba` , `sz`.`id` , `sz`.`obozn` , `sz`.`sz` ,`nzuba`.`id` as nid
FROM `sostzubosm` , `sz` , `nzuba`
WHERE (
(
`sostzubosm`.`Osmotr` = '".$_SESSION['OsmID']."'
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
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	

	$kpu=0;
	for ($i=1;$i<=32;$i++)
	{
		$row = mysqli_fetch_array($result);
		
		//
		//$z[1][$i]="<input ".$disabled." type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		$z[1][$i]="<input  type='hidden' name='Nzub[".$i."] value='".$row['id']."' />		
		<select name='Nzub[".$i."]' size='0'>";
		for ($k=0;$k<$sz['count'];$k++)
		{
			if ($sz[$k]['id']==$row['id']) $z[1][$i].="<option selected='selected' value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		else $z[1][$i].="<option value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		}
		$z[1][$i].="</select>";
		if ($row['id']!=10) $kpu++;
		if ($row['obozn']=="") $z[2][$i]="&nbsp;";
		else $z[2][$i]=$row['obozn'];
		$z[3][$i]="<a href='sost_zub.php?pat=".$_SESSION['pat']."&nzub=".$row['nid']."&action=open_last' class='mmenu'>".$row['NZuba']."</a>";

;
		$z[4][$i]=$row['sz'];
			}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
								echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
						 //40
							for ($j=32;$j>=25;$j--)
							{
								echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table><br>КПУ= ".$kpu;
		     
	}
	else
	{
		
		
echo "<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";		
			echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
	$query = "SELECT `id`, `NZuba`  FROM `nzuba` ORDER BY `id`" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	
	for ($i=1;$i<=32;$i++)
	{	
	$row = mysqli_fetch_array($result);	
		$z[1][$i]="<input ".$disabled." type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		$z[1][$i]="
		<input  type='hidden' name='Nzub[".$i."] value='10' />		
		<select name='Nzub[".$i."]' size='0'>";
		for ($k=0;$k<$sz['count'];$k++)
		{
			if ($sz[$k]['id']==10) $z[1][$i].="<option selected='selected' value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		else $z[1][$i].="<option value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		}
		$z[1][$i].="</select>";
		$z[2][$i]="&nbsp;";
		$z[3][$i]="<a href='sost_zub.php?pat=".$_SESSION['pat']."&nzub=".$row['id']."&action=open_last' class='mmenu'>".$row['NZuba']."</a>";

;
		$z[4][$i]="";
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>";		
		
		
	}
	 echo "<div align='center'><input type=\"submit\" value=\"Сохранить\"></div>
		        </form>";
	unset($_SESSION['pat']);
	unset($_SESSION['OsmID']);
}
switch ($_GET['action'])
{
	case "medcard":
		ShowMC($_GET['id']);
	break;
	case "ter":
		ShowTer($_GET['id']);
	break;
	case "ortd":
                 $tables=array ("schet_orto");
	for ($j=0;$j<=0;$j++)
	{
		$query = "SELECT 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`".$tables[$j]."`.`id`,
		`".$tables[$j]."`.`date`,
		`".$tables[$j]."`.`summ_k_opl`
		FROM sotr, ".$tables[$j]."
		WHERE 
		((".$_GET['id']." =`".$tables[$j]."`.`pat`) AND
		(`sotr`.`id`=`".$tables[$j]."`.`vrach`) AND
		(`".$tables[$j]."`.`sh_id`!=0))
		ORDER BY `".$tables[$j]."`.`date`";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);


//	$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `dnev`.`zh`, `dnev`.`an`, `dnev`.`obk`, `dnev`.`lech`, `dnev`.`date`, `dnev`.`ds`,`dnev`.`id`
//FROM sotr, dnev
//WHERE ((`sotr`.`id` =`dnev`.`vrach`) AND (`dnev`.`pat` =".$id."))
//ORDER BY `dnev`.`date` DESC";
//echo $query."<br>";
//$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
if (!($count>0))
{
	echo "<div class='head1'>Записей в карте нет</div>";	
}

echo "<form method='post' action='PatWork.php'>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode('-',$row['date']);
	echo "<input ".$disabled." name='id' type='hidden' value='1' />
		      <br />
		      <div align=\"center\"><span class='head3'>Дата: ".$dt[2].".".$dt[1].".".$dt[0]."</br> 
		      <a class='head2' href='print.php?type=pat&card=".$row['id']."' tarGET='_blank'>Печать карты</a>|
<a class='head2' tarGET='_blanc' href=\"show.php?type=chek&dnev=".$row['id']."&table=".$tables[$j]."&podr=1\">Просмотр оплаты (".$row['summ_k_opl']." руб.)</a>|
<a class='head2' tarGET='_blanc' href=\"\">Редактировать запись</a>
<br /></div>
		      <span class='head3'>Врач: ".$row['surname']." ".$row['name']." ".$row['otch']."</span><br />
			  <hr width='100%' noshade='noshade' size='1'/>";
			 // echo "<center><a href='print.php?type=pat&card=".$row['id']."' tarGET='_blank'>Печать карты</a></center>";
}
}
echo "</form>";
	break;
	case "ortp":
	$tables=array ("zaknar","schet_orto");
	for ($j=0;$j<=1;$j++)
	{
		$query = "SELECT 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`".$tables[$j]."`.`id`,
		`".$tables[$j]."`.`date`,
		`".$tables[$j]."`.`summ_k_opl`
		FROM sotr, ".$tables[$j]."
		WHERE 
		((".$_GET['id']." =`".$tables[$j]."`.`pat`) AND
		(`sotr`.`id`=`".$tables[$j]."`.`vrach`) AND
		(`".$tables[$j]."`.`sh_id`=0))
		ORDER BY `".$tables[$j]."`.`date`";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);


//	$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`, `dnev`.`zh`, `dnev`.`an`, `dnev`.`obk`, `dnev`.`lech`, `dnev`.`date`, `dnev`.`ds`,`dnev`.`id`
//FROM sotr, dnev
//WHERE ((`sotr`.`id` =`dnev`.`vrach`) AND (`dnev`.`pat` =".$id."))
//ORDER BY `dnev`.`date` DESC";
//echo $query."<br>";
//$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
//if (!($count>0))
//{
//	echo "<div class='head1'>Записей в карте нет</div>";	
//}

echo "<form method='post' action='PatWork.php'>";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	$dt=explode('-',$row['date']);
	echo "<input ".$disabled." name='id' type='hidden' value='1' />
		      <br />
		      <div align=\"center\"><span class='head3'>Дата: ".$dt[2].".".$dt[1].".".$dt[0]."</br> 
		      <a class='head2' href='print.php?type=pat&card=".$row['id']."' tarGET='_blank'>Печать карты</a>|
<a class='head2' tarGET='_blanc' href=\"show.php?type=chek&dnev=".$row['id']."&table=".$tables[$j]."&podr=1\">Просмотр оплаты (".$row['summ_k_opl']." руб.)</a>|
<a class='head2' tarGET='_blanc' href=\"\">Редактировать запись</a>
<br /></div>
		      <span class='head3'>Врач: ".$row['surname']." ".$row['name']." ".$row['otch']."</span><br />
			  <hr width='100%' noshade='noshade' size='1'/>";
			 // echo "<center><a href='print.php?type=pat&card=".$row['id']."' tarGET='_blank'>Печать карты</a></center>";
}
}
echo "</form>";
	break;
	case "orto_sh":
	switch ($_GET['act'])
	{
		case "show":
				$query = "SELECT `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`orto_sh`.`date`, `orto_sh`.`per_lech`, `orto_sh`.`summ`, `orto_sh`.`summ_month`, `orto_sh`.`vnes`, `orto_sh`.`full` FROM `orto_sh`,`sotr` WHERE ((`orto_sh`.`id`=".$_GET['SHid'].") AND (`sotr`.`id`=`orto_sh`.`sotr`))";
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$row = mysqli_fetch_array($result);
				$dt=explode("-",$row['date']);
				echo "Схема оплаты ортодонтического лечения от ".$dt[2].".".$dt[1].".".$dt[0]."<br />Врач ".$row[0]." ".$row[1]." ".$row[2]."<br />";
				echo "1. Консультация профессора<br />
				2. Диагностические манипуляции<br />
				3. Гигиенический набор<br />
				4. Ортодонтическая аппаратура: ";
				if (($row['full']==1) or ($row['summ']==$row['vnes'])) echo "Оплачено полностью (".$row['vnes']."р.)"; 
				echo "Оплачено: ".$row['vnes']."р. Долг: ".($row['summ']-$row['vnes'])."р<br />";
				echo "5. Ретейнер";
		//include("footer2.php");
		exit;		
		break;
	}
	$query = "SELECT `id`, `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `full` FROM `orto_sh` WHERE (`pat`=".$_GET['id'].")";
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		if ($count>0) 
			for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$dt=explode("-",$row['date']);
					echo "<a href='pat_card.php?id=".$_GET['id']."&action=orto_sh&act=show&SHid=".$row['id']."' class ='menu2'>Схема оплаты от ".$dt[2].".".$dt[1].".".$dt[0]." </a>";
				}
		else echo "Оплат ортодонтии нет";
	break;
	
        
        /// Диспансеризация
        case "disp":
		switch ($_GET['act'])
		{
			case "add_short":
				switch ($_GET['step'])
				{
                                                                            case "1":
                                                                                     echo ""
                                                                                . "<form action=\"pat_card.php\" method=\"get\">
					<input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\">
					<input type=\"hidden\" name=\"dc\" value=\"".$_GET['dc']."\">
					<input type=\"hidden\" name=\"action\" value=\"".$_GET['action']."\">
					<input type=\"hidden\" name=\"act\" value=\"add_short\">
					<input type=\"hidden\" name=\"step\" value=\"2\">";
                                                                                        $month_name=array(1=>"Январь",
                                                                                            2=>"Февраль",
                                                                                            3=>"Март",
                                                                                            4=>"Апрель",
                                                                                            5=>"Май",
                                                                                            6=>"Июнь",
                                                                                            7=>"Июль",
                                                                                            8=>"Август",
                                                                                            9=>"Сентябрь",
                                                                                            10=>"Октябрь",
                                                                                            11=>"Ноябрь",
                                                                                            12=>"Декабрь");
                                                                                      echo "Следующий осмотр: месяц ";
                                                                                        echo "<select id='month' name='month'>";
                                                                                        foreach ($month_name as $key => $value) {
                                                                                            echo "<option value='".$key."'>".$value."</option>";
                                                                                        }
                                                                                         echo  "</select>";
                                                                                         echo "";
                                                                                         echo " год <select id='year' name='year'>";
                                                                                         for ($i = date("Y"); $i <=(date("Y")+3); $i++) {
                                                                                            echo "<option value='".$i."'>".$i."</option>";
                                                                                        }
                                                                                         echo "</select>";
                                                                                         echo " Приём через <select id='per' name='per'>";
                                                                                        
                                                                                            echo "<option value='3'>3 месяца</option>";
                                                                                             echo "<option value='4'>4 месяца</option>";
                                                                                              echo "<option value='6' selected='selected'>6 месяцев</option>";
                                                                                               echo "<option value='12'>12 месяцев</option>";
                                                                                       
                                                                                         echo "</select>";  
                  echo "<br><br>Планируемая работа во время следующего осмотра<br><textarea name='work' id='work' rows='10' cols='77'  placeholder='Работа'></textarea>";
                                   echo "<select multiple size=\"9\"  name='add_work_list' id='add_work_list'>";
                  $query = "SELECT * FROM `klishe_ko`" ;
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	
	for ($i=0;$i<$count;$i++)
	{	
	$row = mysqli_fetch_array($result);	
    echo "<option value='".$row['nazv']." \n'>".$row['nazv']."</option>";
        }
    ECHO " </select>";
      echo "<script type=\"text/javascript\">
                 $('#add_work_list').dblclick(function(){

                                                         $('#work').val($('#work').val()+$('#add_work_list').val());
                                                 });
                 var month=[];
                 var year=[];
                 month[3]=$(\"#month option[value='".date("n",strtotime("+3 month"))."']\");
                 year[3]=$(\"#year option[value='".date("Y",strtotime("+3 month"))."']\");
                  month[4]=$(\"#month option[value='".date("n",strtotime("+4 month"))."']\");
                 year[4]=$(\"#year option[value='".date("Y",strtotime("+4 month"))."']\");
                  month[6]=$(\"#month option[value='".date("n",strtotime("+6 month"))."']\");
                 year[6]=$(\"#year option[value='".date("Y",strtotime("+12 month"))."']\");
                  month[12]=$(\"#month option[value='".date("n",strtotime("+12 month"))."']\");
                 year[12]=$(\"#year option[value='".date("Y",strtotime("+12 month"))."']\");
                  
                month[6].prop('selected', true);
               year[6].prop('selected', true);
               $(\"#per\").change(function(){
    
                                        var p=Number.parseInt($(\"#per\").val());
                                        alert(p+' '+  month[p]+' '+year[p]);
                                         month[p].prop('selected', true);
                                           year[p].prop('selected', true);
                                      });
              </script>";
                                                                                    $query = "SELECT * FROM `klishe_ko`" ;
                                                                          $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);

                                                                          for ($i=0;$i<$count;$i++)
                                                                          {	
                                                                          $row = mysqli_fetch_array($result);	
                                                                      echo "<option value='".$row['nazv']." \n'>".$row['nazv']."</option>";
                                                                          }
                                                                      ECHO " </select>";
                                                     
                                                                      
                                                                      echo "</div>";
                                                                           echo "<div align='center'><input type=\"submit\" value=\"Сохранить\"></div></form>";

					//include("footer2.php");
					exit;
					break;
                                                                            case "2":
                                                                                        $query = "INSERT INTO `kontr_osm` (`id`, `disp_card`, `date`, `igv`, `psr`, `kpu`,`osm`,`vrach`,`next_date`,`rezobzv`,`work`,`short`) VALUES (NULL, '".$_GET['dc']."', '".date('Y-m-d')."', 0, 0,0,0,'".$_SESSION["UserID"]."','".$_GET['year']."-".$_GET['month']."-".date('d')."','55555','".$_GET['work']."',1)";
                                                                                $result=sql_query($query,'orto',0); 
                                                                                            //include("footer2.php");
                                                                                            ret("pat_card.php?id=".$_GET['id']."&action=disp");
                                                                                         exit;  
                                                                            break;
                                }
                                                                                break;
                            
                                
                                
                                                case "add":
				switch ($_GET['step'])
				{
					case "1":
					echo "
					<form action=\"pat_card.php\" method=\"get\">
					<input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\">
					<input type=\"hidden\" name=\"dc\" value=\"".$_GET['dc']."\">
					<input type=\"hidden\" name=\"action\" value=\"".$_GET['action']."\">
					<input type=\"hidden\" name=\"act\" value=\"add\">
					<input type=\"hidden\" name=\"step\" value=\"2\">";
					//кпу	
						$query = "SELECT `id`, `obozn` FROM `sz`";
				//echo $query."<br>";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				$sz['count']=$count;
				for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
					$sz[$i]['id']=$row['id'];
					$sz[$i]['sz']=$row['obozn'];
				}
					echo "Индекс КПУ<br>";
					echo "
					<table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";
                

			echo "<table width='100%' border='1' align='right' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >";
	$query = "SELECT `id`, `NZuba` FROM `nzuba` ORDER BY `id`" ;
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	
	for ($i=1;$i<=32;$i++)
	{	
	$row = mysqli_fetch_array($result);	
		$z[1][$i]="<input ".$disabled." type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		$z[1][$i]="
		<input  type='hidden' name='Nzub[".$i."] value='10' />		
		<select name='Nzub[".$i."]' size='0'>";
		for ($k=0;$k<$sz['count'];$k++)
		{
			if ($sz[$k]['id']==10) $z[1][$i].="<option selected='selected' value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		else $z[1][$i].="<option value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		}
		$z[1][$i].="</select>";
		$z[2][$i]="&nbsp;";
		$z[3][$i]=$row['NZuba'];
		$z[4][$i]="";
	}
	for ($i=1;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=1;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "</table></td>
              </tr>
            </table><br><br>";		
		
		//игв
		echo "	Индекс Грина-Вермильона <br />
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
                <select name='zn[1]' id='zn[1]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
                </label>
              </div></td>
              <td><div align='center'>
                <select name='zk[1]' id='zk[1]'>
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
                <select name='zn[2]' id='zn[2]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk[2]' id='zk[2]'>
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
                <select name='zn[3]' id='zn[3]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk[3]' id='zk[3]'>
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
                <select name='zn[4]' id='zn[4]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk[4]' id='zk[4]'>
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
                <select name='zn[5]' id='zn[5]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk[5]' id='zk[5]'>
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
                <select name='zn[6]' id='zn[6]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
              <td><div align='center'>
                <select name='zk[6]' id='zk[6]'>
                  <option value='0' selected='selected'>Нет</option>
                  <option value='1'>До 1/3 поверхности</option>
                  <option value='2'>1/3-2/3 поверхности</option>
                  <option value='3'>Более 1/3 повержности</option>
                </select>
              </div></td>
            </tr>
          </table><br><br>";
          //пср
          	echo "Индекс PSR<br>";
          	echo "S1 <select name=\"s1\" size=\"0\">";
          	echo "<option value=\"0\" selected='selected'>0</option>";
          	echo "<option value=\"1\">0*</option>";
          	echo "<option value=\"2\" >1</option>";
          	echo "<option value=\"3\" >1*</option>";
          	echo "<option value=\"4\" >2</option>";
          	echo "<option value=\"5\" >2*</option>";
          	echo "<option value=\"6\" >3</option>";
          	echo "<option value=\"7\">3*</option>";
          	echo "<option value=\"8\" >4</option>";
          	echo "<option value=\"9\" >4*</option>";
          	echo "</select>";
          	echo "  S2 <select name=\"s2\" size=\"0\">";
          	echo "<option value=\"0\" selected='selected'>0</option>";
          	echo "<option value=\"1\" >0*</option>";
          	echo "<option value=\"2\" >1</option>";
          	echo "<option value=\"3\" >1*</option>";
          	echo "<option value=\"4\" >2</option>";
          	echo "<option value=\"5\" >2*</option>";
          	echo "<option value=\"6\">3</option>";
          	echo "<option value=\"7\" >3*</option>";
          	echo "<option value=\"8\" >4</option>";
          	echo "<option value=\"9\" >4*</option>";
          	echo "</select>";
          	echo "  S3 <select name=\"s3\" size=\"0\">";
          	echo "<option value=\"0\" selected='selected'>0</option>";
          	echo "<option value=\"1\" >0*</option>";
          	echo "<option value=\"2\" >1</option>";
          	echo "<option value=\"3\" >1*</option>";
          	echo "<option value=\"4\" >2</option>";
          	echo "<option value=\"5\" >2*</option>";
          	echo "<option value=\"6\" >3</option>";
          	echo "<option value=\"7\" >3*</option>";
          	echo "<option value=\"8\" >4</option>";
          	echo "<option value=\"9\" >4*</option>";
          	echo "</select><br>";
          	echo "S6 <select name=\"s6\" size=\"0\">";
          	echo "<option value=\"0\" selected='selected'>0</option>";
          	echo "<option value=\"1\" >0*</option>";
          	echo "<option value=\"2\" >1</option>";
          	echo "<option value=\"3\" >1*</option>";
          	echo "<option value=\"4\" >2</option>";
          	echo "<option value=\"5\" >2*</option>";
          	echo "<option value=\"6\" >3</option>";
          	echo "<option value=\"7\" >3*</option>";
          	echo "<option value=\"8\" >4</option>";
          	echo "<option value=\"9\" >4*</option>";
          	echo "</select>";
          	echo "  S5 <select name=\"s5\" size=\"0\">";
          	echo "<option value=\"0\" selected='selected'>0</option>";
          	echo "<option value=\"1\" >0*</option>";
          	echo "<option value=\"2\" >1</option>";
          	echo "<option value=\"3\" >1*</option>";
          	echo "<option value=\"4\" >2</option>";
          	echo "<option value=\"5\" >2*</option>";
          	echo "<option value=\"6\" >3</option>";
          	echo "<option value=\"7\" >3*</option>";
          	echo "<option value=\"8\" >4</option>";
          	echo "<option value=\"9\" >4*</option>";
          	echo "</select>";
          	echo "  S4 <select name=\"s4\" size=\"0\">";
          	echo "<option value=\"0\" selected='selected'>0</option>";
          	echo "<option value=\"1\" >0*</option>";
          	echo "<option value=\"2\" >1</option>";
          	echo "<option value=\"3\" >1*</option>";
          	echo "<option value=\"4\" >2</option>";
          	echo "<option value=\"5\" >2*</option>";
          	echo "<option value=\"6\" >3</option>";
          	echo "<option value=\"7\" >3*</option>";
          	echo "<option value=\"8\" >4</option>";
          	echo "<option value=\"9\" >4*</option>";
          	echo "</select>";
             
                  echo "<div align='left'><br><br>";
                 $month_name=array(1=>"Январь",
                                                                                            2=>"Февраль",
                                                                                            3=>"Март",
                                                                                            4=>"Апрель",
                                                                                            5=>"Май",
                                                                                            6=>"Июнь",
                                                                                            7=>"Июль",
                                                                                            8=>"Август",
                                                                                            9=>"Сентябрь",
                                                                                            10=>"Октябрь",
                                                                                            11=>"Ноябрь",
                                                                                            12=>"Декабрь");
                                                                                      echo "Следующий осмотр: месяц ";
                                                                                        echo "<select id='month' name='month'>";
                                                                                        foreach ($month_name as $key => $value) {
                                                                                            echo "<option value='".$key."'>".$value."</option>";
                                                                                        }
                                                                                         echo  "</select>";
                                                                                         echo "";
                                                                                         echo " год <select id='year' name='year'>";
                                                                                         for ($i = date("Y"); $i <=(date("Y")+3); $i++) {
                                                                                            echo "<option value='".$i."'>".$i."</option>";
                                                                                        }
                                                                                         echo "</select>";  
                                                                                         echo " Приём через <select id='per' name='per'>";
                                                                                        
                                                                                            echo "<option value='3'>3 месяца</option>";
                                                                                             echo "<option value='4'>4 месяца</option>";
                                                                                              echo "<option value='6' selected='selected'>6 месяцев</option>";
                                                                                               echo "<option value='12'>12 месяцев</option>";
                                                                                       
                                                                                         echo "</select>";  
                  echo "<br><br>Планируемая работа во время следующего осмотра<br><textarea name='work' id='work' rows='10' cols='77'  placeholder='Работа'></textarea>";
                                   echo "<select multiple size=\"9\"  name='add_work_list' id='add_work_list'>";
                  $query = "SELECT * FROM `klishe_ko`" ;
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	
	for ($i=0;$i<$count;$i++)
	{	
	$row = mysqli_fetch_array($result);	
    echo "<option value='".$row['nazv']." \n'>".$row['nazv']."</option>";
        }
    ECHO " </select>";
      echo "<script type=\"text/javascript\">
                 $('#add_work_list').dblclick(function(){

                                                         $('#work').val($('#work').val()+$('#add_work_list').val());
                                                 });
                 var month=[];
                 var year=[];
                 month[3]=$(\"#month option[value='".date("n",strtotime("+3 month"))."']\");
                 year[3]=$(\"#year option[value='".date("Y",strtotime("+3 month"))."']\");
                  month[4]=$(\"#month option[value='".date("n",strtotime("+4 month"))."']\");
                 year[4]=$(\"#year option[value='".date("Y",strtotime("+4 month"))."']\");
                  month[6]=$(\"#month option[value='".date("n",strtotime("+6 month"))."']\");
                 year[6]=$(\"#year option[value='".date("Y",strtotime("+12 month"))."']\");
                  month[12]=$(\"#month option[value='".date("n",strtotime("+12 month"))."']\");
                 year[12]=$(\"#year option[value='".date("Y",strtotime("+12 month"))."']\");
                  
                month[6].prop('selected', true);
               year[6].prop('selected', true);
               $(\"#per\").change(function(){
    
                                        var p=Number.parseInt($(\"#per\").val());
                                        alert(p+' '+  month[p]+' '+year[p]);
                                         month[p].prop('selected', true);
                                           year[p].prop('selected', true);
                                      });
              </script>";
    echo "</div>";
	 echo "<div align='center'><input type=\"submit\" value=\"Сохранить\"></div></form>";

					//include("footer2.php");
					exit;
					break;
					case "2":
					
					//сохранение кпу
						$z=$_GET['Nzub'];
	reset($z);
                if (isset($_GET['perv'])) {$perv=$_GET['perv'];} else {$perv=0;}
	$query = "INSERT INTO `osmotr` (`id`, `Date`, `Perv`, `Pat`)
							VALUES(NULL,'".date('Y-m-d')."', '".$perv."', '".$_GET['id']."')" ;
	//echo $query."<br>";
	$osm=sql_query($query,'orto',0);  
	$query = "INSERT INTO `sostzubosm` (`id`, `NZuba`, `SostZuba`, `Osmotr`) 
VALUES ";
	$kpu=0;
	for ($i=1;$i<=32;$i++)
	{
	if ($z[$i]!=10) $kpu++;
	if ($i==1)
			$query.=" (NULL, ".$i.", ".$z[$i].", ".$osm.")";

		else $query.=", (NULL, ".$i.", ".$z[$i].", ".$osm.")";	
	}
	//echo $query."<br>";
	$result=sql_query($query,'orto',0); 
	$query = "INSERT INTO `kpu` (`id`, `summ`,`date`,`pat`) 
								VALUES (NULL, ".$kpu.", '".date('Y-m-d')."','".$_GET['id']."')";
//echo $query."<br>";
                                
		$kpuS=$kpu;
		$kpu=sql_query($query,'orto',0);    
//сохранение игв
$zn=$_GET['zn'];
		$zk=$_GET['zk'];
		$Szn=0;
		$Szk=0;
		for ($i=1;$i<=6;$i++)
		{
			$Szn+=$zn[$i];
			$Szk+=$zk[$i];
		}
		$query = "INSERT INTO `igv` (`id`, `date`, `pat`, `summ`, `izn`, `izk`) VALUES (NULL, '".date("Y-m-d")."', ".$_GET['id'].", '".((round(($Szn/6),1)+round(($Szk/6),1)))."', '".(round(($Szn/6),1))."', '".(round(($Szk/6),1))."')";
		//echo $query."<br />";
		  
		$igvS=((round(($Szn/6),1)+round(($Szk/6),1)));
                                    $igv=sql_query($query,'orto',0);  
		//сохранение пср
		$query = "INSERT INTO `psr` (`id`, `date`,`pat`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`) VALUES (NULL, '".date("Y-m-d")."', ".$_GET['id'].", '".$_GET['s1']."', '".$_GET['s2']."', '".$_GET['s3']."', '".$_GET['s4']."', '".$_GET['s5']."', '".$_GET['s6']."')";
	//echo $query."<br>";
                                   $psr=sql_query($query,'orto',0);    
		$query = "INSERT INTO `kontr_osm` (`id`, `disp_card`, `date`, `igv`, `psr`, `kpu`,`osm`,`vrach`,`next_date`,`rezobzv`,`work`) VALUES (NULL, '".$_GET['dc']."', '".date('Y-m-d')."', '".$igv."', '".$psr."', '".$kpu."','".$osm."','".$_SESSION["UserID"]."','".$_GET['year']."-".$_GET['month']."-".date('d')."','55555','".$_GET['work']."')";
		//echo $query."<br>";
                
                                                                                $result=sql_query($query,'orto',0); 
                                                                                            //include("footer2.php");
                                                                                            ret("pat_card.php?id=".$_GET['id']."&action=disp");
                /// Дальше код не работает
                
		$ko=sql_query($query,'orto',0);    
		echo "igv=".$igvS." kpu=".$kpuS;
		for ($i=1;$i<=6;$i++)
		{
			echo " s".$i."=".floor($s[$i]/2);
		}
		echo "<br>";
		if ($kpuS<=6) $kpu=12;
		else if ($kpuS<=9) $kpu=6;
		else $kpu=3;
		
		
		
		if ($igvS>=3.1) $igv=3;
		else if ($igvS>=1.3) $igv=6;
		else  $igv=12;
		
		$s[1]=$_GET['s1'];
		$s[2]=$_GET['s2'];
		$s[3]=$_GET['s3'];
		$s[4]=$_GET['s4'];
		$s[5]=$_GET['s5'];
		$s[6]=$_GET['s6'];
		unset($psr);
		$psr[1]=0;
		$psr[2]=0;
		$psr[3]=0;
		$psr[4]=0;
		for ($i=1;$i<=6;$i++)
		{
			for ($j=1;$j<=4;$j++)
			{
				if(floor($s[$i]/2==$j)) $psr[$j]++;
				//msg($i." ".($s[$i]/2)."=".$j." summ=". $psr[$j]);
			}
		}
		if (($psr[4]!=0) or ($psr[3]>1)) $psrS=3;
		else if (($psr[3]==1) or ($psr[2]!=0)) 
		 {
		 	$psrS=6;
		 }
		else 
		{
			$psrS=12;
		}
		$srok=$kpu;
		echo "igv=".$igvS." kpu=".$kpuS." psr=".$psrS;
		for ($i=1;$i<=4;$i++)
		{
			echo " psr".$i."=".$psr[$i];
		}
		if ($srok>$igv) $srok=$igv;
		if ($srok>$psrS) $srok=$psrS;
		
		//$srok=
		//echo "<br><a href='pat_card.php?id=".$_GET['id']."&action=disp&act=add&step=3&dc=".$dc."' class ='menu2'>Дальше</a><br>";
echo $ko."<br>";		
		echo "
		<form action=\"pat_card.php\" method=\"get\">
		<input type=\"text\" name=\"srok\" value=\"".$srok."\">
		<input type=\"submit\" value=\"Сохранить\">
		<input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\">
		<input type=\"hidden\" name=\"ko\" value=\"".$ko."\">
		<input type=\"hidden\" name=\"action\" value=\"".$_GET['action']."\">
		<input type=\"hidden\" name=\"act\" value=\"add\">
		<input type=\"hidden\" name=\"step\" value=\"3\">
		</form>";			
		//include("footer2.php");
					exit;
					break;
			case "3":
			//$dt=mktime(0,0,0,date('m'),date('d'),date('Y'))+();
			if ((12-date('m'))>=$_GET['srok']) 
				{
					$m=date('m')+$_GET['srok'];
					$Y=date('Y');
				}
			else 
			{
				$m=$_GET['srok']-(12-date('m'));
				$Y=date('Y')+1;
			}
			$query = "UPDATE `kontr_osm` 
			SET `next_date` = '".$Y."-".$m."-".date('d')."' 
			WHERE `id` =".$_GET['ko'];
//echo $query."<br>";
$result=sql_query($query,'orto',0);    
//include("footer2.php");
ret("pat_card.php?id=".$_GET['id']."&action=disp");
			exit;
			break;
				}
			//include("footer2.php");
			exit;
			break;
			case "ch":
				$query = "UPDATE `disp_card` SET `vrach`='".$_GET['vrach']."' WHERE `id`=".$_GET['dc'];
				echo $query."<br>";
				$result=sql_query($query,'orto',0);    
				$row = mysqli_fetch_array($result);
				ret("pat_card.php?id=".$_GET['id']."&action=disp");
			//include("footer2.php");
			exit;
			break;
		}
		$query = "SELECT  
		`disp_card`.`id`,
		`sotr`.`surname`, 
	 	 `sotr`.`name`, 
	 	 `sotr`.`otch`, 
	 	 `sotr`.`id` as sotr_id
	 	  FROM `disp_card`,`sotr` WHERE  ((`disp_card`.`pat`=".$_GET['id'].") AND (`disp_card`.`vrach`=`sotr`.`id`))";
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$rowA = mysqli_fetch_array($result);
		if (!($count>0))
		{
		$query = "INSERT INTO `disp_card` (`id`,  `date`,`pat`,`vrach`) VALUES  (NULL,'".date('Y-m-d')."',".$_GET['id'].",'".$_SESSION["UserID"]."')";
		//echo $query."<br>";
		$dc=sql_query($query,'orto',0);
		$vrach['name']=$_SESSION["UserName"];
		$vrach['id']=$_SESSION["UserID"];		}
		else
		{
			$dc=$rowA[0];
			$vrach['name']=$rowA['surname']." ".$rowA['name']." ".$rowA['otch'];
			$vrach['id']=$rowA['sotr_id'];
			
		}
		echo "<form name=\"form1\" id=\"form1\"><div>Врач: ";
			$query = "SELECT `sotr`.`id`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch` 
						FROM  sotr
							WHERE (`sotr`.`dolzh` IN (1,2,3,9))
						GROUP BY `sotr`.`id`
						ORDER BY `sotr`.`surname` ASC
						";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		echo "<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu1(targ,selObj,restore){ //v3.0
  eval(targ+\".location='pat_card.php?id=".$_GET['id']."&action=disp&dc=".$dc."&act=ch&vrach=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

  <select name=\"vrach\" onchange=\"MM_jumpMenu1('parent',this,0)\">";
for ($i=0;$i<$count;$i++)
{
	$row = mysqli_fetch_array($result);
	if ($vrach['id']==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	else echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
}
echo "  </select>
";
echo "</div></form>";
echo "<br><table border='0' align='left' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' width='100%'>
<tr align='center' bgcolor='#ffffff'>
	<td><a href='pat_card.php?id=".$_GET['id']."&action=disp&act=add&step=1&dc=".$dc."' class ='menu2'>Создать контрольный осмотр</a>||<a href='pat_card.php?id=".$_GET['id']."&action=disp&act=add_short&step=1&dc=".$dc."' class ='menu2'>Задать дату диспансерного посещения</a><br>"
        . "</td>
	
</tr></table>";
		$query = "SELECT `id`, DATE_FORMAT(`date`, '%d.%m.%Y' ) AS date, DATE_FORMAT(`next_date`, '%d.%m.%Y' ) AS next_date  FROM `kontr_osm` WHERE `disp_card`=".$dc." ORDER BY `date` ASC";
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		if($count>0)
		{
			
			echo "<div class='feature'>Контрольный осмотр от ";
			echo "<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu2(targ,selObj,restore){
  eval(targ+\".location='pat_card.php?id=".$_GET['id']."&action=disp&dc=".$dc."&ko=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<select name=\"ko\" onchange=\"MM_jumpMenu2('parent',this,0)\">";
			for ($i=0;$i<$count;$i++)
				{
					$row = mysqli_fetch_array($result);
                                                                                    if (!(isset($_GET['ko'])) and ($i==0)) {$ko=$row['id'];$next_date=$row['next_date'];}
					if ($row['id']==$_GET['ko']) 
					{
						echo "<option value=\"".$row['id']."\" label=\"".$row['date']."\" selected='selected'>".$row['date']."</option>";
						$ko=$row['id'];
                                                                                                         $next_date=$row['next_date'];
					}
					else echo "<option value=\"".$row['id']."\" label=\"".$row['date']."\">".$row['date']."</option>";
				}
			echo "</select> cледующий осмотр ".$next_date."</div>";
			
		}
		else
		{
			echo "<div class='feature'>Нет контрольных осмотров<br>";
			echo "<br><a href='pat_card.php?id=".$_GET['id']."&action=disp&act=add&step=1&dc=".$dc."' class ='menu2'>Создать контрольный осмотр</a>||<a href='pat_card.php?id=".$_GET['id']."&action=disp&act=add&step=1&dc=".$dc."' class ='menu2'><a href='pat_card.php?id=".$_GET['id']."&action=disp&act=add_short&step=1&dc=".$dc."' class ='menu2'>Задать дату диспансерного посещения<</a></a><br></div>";
		 
		 
		 
		 //include("footer2.php");
			exit;
			
		}		
		//кпу
		
		$query = "SELECT `igv`.`izn`, `igv`.`izk`, `igv`.`summ`, `psr`.`s1`, `psr`.`s2`, `psr`.`s3`, `psr`.`s4`, `psr`.`s5`, `psr`.`s6`, `kontr_osm`.`osm`, `kontr_osm`.`short`, `kontr_osm`.`work` FROM `kontr_osm` LEFT JOIN `igv` ON `igv`.`id` = `kontr_osm`.`igv` LEFT JOIN `psr` ON `psr`.`id` = `kontr_osm`.`psr` WHERE (`kontr_osm`.`id` = ".$ko.")";
		//echo $query."<br>";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$igv=$row['summ'];
		$short_ko=$row['short'];
                                   $work=$row['work'];
		$izn=$row['izn'];
		$izk=$row['izk'];
		for ($i=1;$i<=6;$i++)
		{
			if (floor($row[($i+2)]/2)==($row[($i+2)]/2)) $s[$i]=$row[($i+2)]/2;
			else  $s[$i]=floor($row[($i+2)]/2)."*";
		}
		$osm=$row['osm'];
                
                
             //Показывать при коротком осмотре
                if(!($short_ko))
                {
	  echo "<div class='head2'>Зубная формула</div>";
		    echo "
		    <table width='100%' border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000'>
              <tr>
                <td align='right' bgcolor='#FFFFFF'>";
				//Заполняем 10 сегмент
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
	//echo $query."<br>";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	

	$kpu=0;
	for ($i=1;$i<=32;$i++)
	{
		$row = mysqli_fetch_array($result);
		
		//
		//$z[1][$i]="<input ".$disabled." type='checkbox' name='Nzub[".$i."]' value='".$i."' />";
		$z[1][$i]="<input  type='hidden' name='Nzub[".$i."] value='".$row['id']."' />		
		<select name='Nzub[".$i."]' size='0'>";
		for ($k=0;$k<$sz['count'];$k++)
		{
			if ($sz[$k]['id']==$row['id']) $z[1][$i].="<option selected='selected' value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		else $z[1][$i].="<option value='".$sz[$k]['id']."' label='".$sz[$k]['sz']."'>".$sz[$k]['sz']."</option>";
		}
		$z[1][$i].="</select>";
		if ($row['id']!=10) $kpu++;
		if ($row['obozn']=="") $z[2][$i]="&nbsp;";
		else $z[2][$i]="<b>".$row['obozn']."</b>";
		$z[3][$i]=$row['NZuba'];
		$z[4][$i]=$row['sz'];
	}
	for ($i=2;$i<=3;$i++)
	{
		 echo "<tr bgcolor='#FFFFFF'>";
		 	for ($j=1;$j<=8;$j++)
			{
				echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
								echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
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
						 //40
							for ($j=32;$j>=25;$j--)
							{
								echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
					echo "                </table></td>
                <td  bgcolor='#FFFFFF'><table width='100%' border='1' cellspacing='0' cellpadding='0' bgcolor='#000000' bordercolor='#000000' bordercolordark='#FFFFFF' >";
				for ($i=3;$i>=2;$i--)
					{
						 echo "<tr bgcolor='#FFFFFF'>";
							for ($j=24;$j>=17;$j--)
							{
								echo "<td width='12%'><div align='center' title='".$z[4][$j]."'>".$z[$i][$j]."</div></td>";
							}
					}
echo "                </table></td>
              </tr>
            </table>";
echo "<table border=0><tr valign='top'><td><div class='feature'>КПУ= ".$kpu."</div></td>";		 
		//игв
		  echo "<td><div class='head2'>Индекс Грина-Вермилиона</div>";
		   echo "<div class='feature'>ИЗН=".$izn."<br>
		   									ИЗК=".$izk."<br>
		   									ИГВ=".$igv."<br></div></td>";
		//psr
		echo "<td><div class='head2'>Индекс PSR</div>";
		echo "
		<div  class='feature'><table border='1' align='left' cellpadding='0' cellspacing='0' bordercolor='#000000' bordercolordark='#FFFFFF' bgcolor='#000000' >
<tr align='center' bgcolor='#ffffff'>
	<td>s1</td>
	<td>s2</td>
	<td>s3</td>
</tr>
<tr align='center' bgcolor='#ffffff'>
	<td>".$s[1]."</td>
	<td>".$s[2]."</td>
	<td>".$s[3]."</td>
</tr>
<tr align='center' bgcolor='#ffffff'>
	<td>".$s[6]."</td>
	<td>".$s[5]."</td>
	<td>".$s[4]."</td>
</tr>
<tr align='center' bgcolor='#ffffff'>
	<td>s6</td>
	<td>s5</td>
	<td>s4</td>
</tr>
</table><br></div></td></tr>";
                }
                echo "<div align='left'><br><br>Планируемая работа во время осмотра<br><textarea name='work' id='work' rows='10' cols='77' >".$work."</textarea>";                    
                    

		//include("footer2.php");	
		exit;
		
	break;
        
        
        //Статистика для диспансеризации
                case "stat":
                    //Циклы поиска по таблицам
                    include("tables.php");
                  
                  
                    for ($j=0;$j<=2;$j++)
	{
                        //Первое посещение
                    $query = "SELECT
                        DATE_FORMAT(MIN(`".$tables[$j][0]."`.`date`),'%Y') AS first_date
                    FROM
                        ".$tables[$j][0]."
                    WHERE
                        `".$tables[$j][0]."`.`pat` = ".$_GET['id']."
                    group by 
	`".$tables[$j][0]."`.`pat`";
	$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result); $row= mysqli_fetch_array($result);
                  $fd[$j]=$row['first_date'];  
                  
                  //Последняя флорида
                   $query = "SELECT
     DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%d') AS d,
    DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%m') AS m,
    DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%Y') AS y,
    CONCAT_WS(
        \" \",
        `sotr`.`surname`,
        `sotr`.`name`,
        `sotr`.`otch`
    ) AS sotr_fp,
    `".$tables[$j][0]."`.`pat`
FROM
    `".$tables[$j][0]."`,
    `".$tables[$j][1]."`,
    `sotr`
WHERE
    (
        (`".$tables[$j][1]."`.`".$tables[$j][2]."` = `".$tables[$j][0]."`.`id`) AND(
            (`".$tables[$j][1]."`.`manip` = 342) OR(`".$tables[$j][1]."`.`manip` = 343)
        ) AND(`sotr`.`id` = `".$tables[$j][0]."`.`vrach`) AND(`".$tables[$j][0]."`.`pat` = ".$_GET['id'].")
    )
GROUP BY
    `sotr`.`id`";
	$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result); $row= mysqli_fetch_array($result);
                 if ($count>0)  {$dt= mktime(0, 0, 0, $row['m'], $row['d'], $row['y']);}
                  else {$dt= mktime(0, 0, 0, 1, 1, 1990);}
                  $fp[$j]=$dt;   
                  $fp_sotr[$dt]=$row['sotr_fp'];
                  
                                    //Последняя гигиена

                                $query = "SELECT
     DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%d') AS d,
    DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%m') AS m,
    DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%Y') AS y,
    CONCAT_WS(
        \" \",
        `sotr`.`surname`,
        `sotr`.`name`,
        `sotr`.`otch`
    ) AS sotr_fp,
    `".$tables[$j][0]."`.`pat`
FROM
    `".$tables[$j][0]."`,
    `".$tables[$j][1]."`,
    `sotr`
WHERE
    (
        (`".$tables[$j][1]."`.`".$tables[$j][2]."` = `".$tables[$j][0]."`.`id`) AND
            (`".$tables[$j][1]."`.`manip` IN (340,
307,	
286,	
273,	
72,	
69,	
68,	
412,	
413,	
414,	
415,	
638)
 
        ) AND(`sotr`.`id` = `".$tables[$j][0]."`.`vrach`) AND(`".$tables[$j][0]."`.`pat` = ".$_GET['id'].")
    )
GROUP BY
    `sotr`.`id`";
	$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result); $row= mysqli_fetch_array($result);
                 if ($count>0)  {$dt= mktime(0, 0, 0, $row['m'], $row['d'], $row['y']);}
                  else {$dt= mktime(0, 0, 0, 1, 1, 1990);}
                  $pg[$j]=$dt;   
                  $pg_sotr[$dt]=$row['sotr_fp'];
                  
                  
                  //Последний вектор
                   $query = "SELECT
     DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%d') AS d,
    DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%m') AS m,
    DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%Y') AS y,
    CONCAT_WS(
        \" \",
        `sotr`.`surname`,
        `sotr`.`name`,
        `sotr`.`otch`
    ) AS sotr_fp,
    `".$tables[$j][0]."`.`pat`
FROM
    `".$tables[$j][0]."`,
    `".$tables[$j][1]."`,
    `sotr`
WHERE
    (
        (`".$tables[$j][1]."`.`".$tables[$j][2]."` = `".$tables[$j][0]."`.`id`) AND
            (`".$tables[$j][1]."`.`manip` IN (398,	
399,	
400,	
417,	
627,	
629	
)
 
        ) AND(`sotr`.`id` = `".$tables[$j][0]."`.`vrach`) AND(`".$tables[$j][0]."`.`pat` = ".$_GET['id'].")
    )
GROUP BY
    `sotr`.`id`";
	$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result); $row= mysqli_fetch_array($result);
                 if ($count>0)  {$dt= mktime(0, 0, 0, $row['m'], $row['d'], $row['y']);}
                  else {$dt= mktime(0, 0, 0, 1, 1, 1990);}
                  $vec[$j]=$dt;   
                  $vec_sotr[$dt]=$row['sotr_fp'];
                  
                  //Статистика по врачам
              
                   $query = "SELECT
                                COUNT(`".$tables[$j][0]."`.`id`) AS count_vizit,
                                SUM(`".$tables[$j][0]."`.`summ_vnes`) AS sum_vnes,
                                CONCAT_WS(
                                    \" \",
                                    `sotr`.`surname`,
                                    `sotr`.`name`,
                                    `sotr`.`otch`
                                ) AS sotr_name,
                                DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%d') AS d,
                                DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%m') AS m,
                                DATE_FORMAT(MAX(`".$tables[$j][0]."`.`date`),'%Y') AS y, `sotr`.`id`
                            FROM
                                ".$tables[$j][0].",
                                sotr
                            WHERE
                                (`".$tables[$j][0]."`.`pat` =  ".$_GET['id'].") AND(`sotr`.`id` = `".$tables[$j][0]."`.`vrach`)
                            GROUP BY
                                `".$tables[$j][0]."`.`vrach`";
	$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result); 
                if ($count>0)
	{
		  for ($i=0;$i<$count;$i++)
			{
                                                    $row= mysqli_fetch_array($result);
                                                    if (isset( $vr_data[$row['sotr_name']]))
                                                    {
                                                        $vr_data[$row['id']]['sum_vnes']+=$row['sum_vnes']; 
                                                        $vr_data[$row['id']]['count_vizit']+=$row['count_vizit'];  
                                                       if ($vr_data[$row['id']]['last_date']<mktime(0, 0, 0, $row['m'], $row['d'], $row['y']))
                                                       {$vr_data[$row['id']]['last_date']=mktime(0, 0, 0, $row['m'], $row['d'], $row['y']);}
                                                    }
                                                    else 
                                                   {   
                                                         $vr_data[$row['id']]['sotr_name']=$row['sotr_name']; 
                                                        $vr_data[$row['id']]['sum_vnes']=$row['sum_vnes']; 
                                                        $vr_data[$row['id']]['count_vizit']=$row['count_vizit'];  
                                                        $vr_data[$row['id']]['last_date']=mktime(0, 0, 0, $row['m'], $row['d'], $row['y']);
                                                   }
                                                   }
                  }
                
                  
                  }
                  
                 
                  
                  //Вывод информации
                echo  "Пациент клиники с ".max($fd)." года<br><br>";
                   $query = "SELECT `id` FROM `disc_cards` WHERE `pat`= ".$_GET['id'];
                     
	$result=sql_query($query,'orto',0);$count=mysqli_num_rows($result); $row= mysqli_fetch_array($result);
                         IF($count>0) { echo  "Номер карты бесплатной гигиены ".$row['id']."<br><br>";}
                echo "<table width='70%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
              <tr><td> <span class='menutext'>Процедура</span></td>
                    <td  align='center' class='menutext'>Дата последеней записи</td>
                    <td> <span class='menutext'>Врач</span></td>
             </tr>";
                                      
                  if (date('Y',max($pg))>1990) {
                         echo "<tr class='alltext'><td>Профессиональная гигиена</td>";
                         echo "<td>".date('d.m.Y',max($pg))."</td>";
                        echo "<td>". $pg_sotr[max($pg)]."</td></tr>";
                         }
                  else {
                       echo "<tr class='alltext'><td>Профессиональная гигиена не проводилась</td>";
                       echo "<td></td>";
                        echo "<td></td></tr>";
                  }
                        

                 
                  if (date('Y',max($fp))>1990) 
                   {
                         echo "<tr class='alltext'><td> Флорида Проуб</td>";
                         echo "<td>".date('d.m.Y',max($fp))."</td>";
                        echo "<td>". $fp_sotr[max($fp)]."</td></tr>";
                         }
                  else {
                       echo "<tr class='alltext'><td> Флорида Проуб не проводилась</td>";
                       echo "<td></td>";
                        echo "<td></td></tr>";
                  }
                  
                    if (date('Y',max($vec))>1990) 
                   {
                         echo "<tr class='alltext'><td>Вектор терапия</td>";
                         echo "<td>".date('d.m.Y',max($vec))."</td>";
                        echo "<td>". $vec_sotr[max($vec)]."</td></tr>";
                         }
                  else {
                       echo "<tr class='alltext'><td>Вектор терапия не проводилась</td>";
                       echo "<td></td>";
                        echo "<td></td></tr>";
                  }
                  echo "</table>";   
                   echo "<br>Статистика по врачам<br><table width='70%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
              <tr><td> <span class='menutext'>Врач</span></td>
                    <td  align='center' class='menutext'>Количеcтво посещений</td>
                    <td> <span class='menutext'>Сумма за лечение</span></td>
                    <td> <span class='menutext'>Последнее посещение</span></td>
             </tr>";
                foreach ($vr_data as $key =>$value) {
                        if ($key>0)
                        {
                            echo "<tr class='alltext'><td>".$value['sotr_name']."</td>";
                        echo "<td>".$value['count_vizit']."</td>";
                        echo "<td>".$value['sum_vnes']."</td>";
                        echo "<td>".date('d.m.Y',$value['last_date'])."</td></tr>";
                        }
	                  }
               echo "</table>";

                break;
	default:
		ShowOsnSved($_GET['id'],$_GET['ro']);
	break;
}
//include("footer2.php");
?>