<?php
$ThisVU="administrator";
$ModName="Введите необходимые данные для составление пакета";
include("header.php");
if (isset($_POST['save']))
{

}
echo "<h4>Выбирите продолжение</h4>";
echo "<hr />";
//Сохранение пакета расписаний

if (isset($_POST['save'])
{

}
echo "<form action='raspis_Ned.php' method='post' enctype='multipart/form-data'>
  <table width='460' border='1'>
    <tr>
      <td>Врач</td>
      <td><select name='vrach'>";
$query="select id,surname,name,otch,dolzh from sotr where dolzh='врач'";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i="0"; $i<$count; $i++) 
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>"; 
}
echo " </select></td>
    </tr>
    <tr>
      <td>Рабочее место<br /></td>
      <td><select name='rabmesto'>";
	$query="select * from rabmesta";
$result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
for ($i="0"; $i<$count; $i++) 
{
$row = mysqli_fetch_array($result);
echo "<option value='".$row['id']."'>".$row['nazv']."</option>"; 
}  
echo "      </select></td>
    </tr>
  </table>
  <table width=460 border='1' cellpadding='1'>";
//echo "     <tr >
//      <td width='30%'>Период составления </td>
//    </tr>
//    <tr>
//      <td>С: Д
//        <select name='perdateN_d'>";
//
//for ($i=1; $i<32; $i++)
//{
//if ($i<10)  echo "<option value='0".$i."'>".$i."</option>";
//else echo "<option value='".$i."'>".$i."</option>";
//}
//echo "
//        </select>
//        М
//        <select name='perdateN_m'>";
// $s="";
//for ($i=1; $i<13; $i++)
//{
//switch ($i)
//	{
//	case "1":
//		$s="'>Январь</option>";
//		break;
//	case "2":
//		$s="'>Февраль</option>";
//		break;
//	case "3":
//		$s="'>Март</option>";
//		break;
//	case "4":
//		$s="'>Апрель</option>";
//		break;
//	case "5":
//		$s="'>Май</option>";
//		break;
//	case "6":
//		$s="'>Июнь</option>";
//		break;
//	case "7":
//		$s="'>Июль</option>";
//		break;
//	case "8":
//		$s="'>Август</option>";
//		break;
//	case"9":
//		$s="'>Сентябрь</option>";
//		break;
//	case "10":
//		$s="'>Октябрь</option>";
//		break;
//	case "11":
//		$s="'>Ноябрь</option>";
//		break;
//	case "12":
//		$s="'>Декабрь</option>";
//		break;
//}
//if ($i<10) echo "<option value='0".$i."'".$s."</option>";
//      else echo "<option value='".$i."'".$s."</option>";
//}
//echo "
// </select>    
//
//        Г
//        
//         <select name='perdateN_y'>";
// 
//for ($i=2007; $i<2009; $i++) echo "<option value='".$i."'>".$i."</option>"; 
//echo "
//        </select></td>
//    </tr>
//    <tr>
//      <td>По:Д
//        <label>
//          <select name='perdateO_d'>
//";
//for ($i=1; $i<32; $i++)
//{
//if ($i<10)  echo "<option value='0".$i."'>".$i."</option>";
//else echo "<option value='".$i."'>".$i."</option>";
//}
//echo "
//          </select>
//          М
//          <select name='perdateO_m'>";
//		             $s="";
//for ($i=1; $i<13; $i++)
//{
//switch ($i)
//	{
//	case "1":
//		$s="'>Январь</option>";
//		break;
//	case "2":
//		$s="'>Февраль</option>";
//		break;
//	case "3":
//		$s="'>Март</option>";
//		break;
//	case "4":
//		$s="'>Апрель</option>";
//		break;
//	case "5":
//		$s="'>Май</option>";
//		break;
//	case "6":
//		$s="'>Июнь</option>";
//		break;
//	case "7":
//		$s="'>Июль</option>";
//		break;
//	case "8":
//		$s="'>Август</option>";
//		break;
//	case"9":
//		$s="'>Сентябрь</option>";
//		break;
//	case "10":
//		$s="'>Октябрь</option>";
//		break;
//	case "11":
//		$s="'>Ноябрь</option>";
//		break;
//	case "12":
//		$s="'>Декабрь</option>";
//		break;
//}
//if ($i<10) echo "<option value='0".$i."'".$s."</option>";
//     else echo "<option value='".$i."'>".$s."</option>"; 
//	 }
//echo "
//          </select>
//          Г
//          <select name='perdateO_y'>
//";
//for ($i=2007; $i<2009; $i++) echo "<option value='".$i."'>".$i."</option>"; 
// echo "         </select>
//        </label></td>
//    </tr>";
echo " <tr>
      <td>Продолжительность приёма
        <input name='prodPriem' type='text' size='2' maxlength='2'  value='30'/></td>
    </tr>
  </table>
  <table width='500' border='1' cellpadding='1'>
    <tr>
      <td width='21%'><div align='center'>День недели </div></td>
      <td width='15%'><div align='center'>Выходной</div></td>
      <td width='32%'><div align='center'>Начало<br />
      смены</div></td>
      <td width='32%'><div align='center'>Окончание<br />
      смены</div></td>
    </tr>
";
for ($i=1; $i<8; $i++)
{

switch ($i)
{
case "1":
$s="Понедельник";
break;
case "2":
$s="Вторник";
break;
case "3":
$s="Среда";
break;
case "4":
$s="Четверг";
break;
case "5":
$s="Пятница";
break;
case "6":
$s="Суббота";
break;
case "7":
$s="Воскресенье";
break;
}
echo "<tr>
      <td>".$s."</td>
      <td><div align='center'><label>
        
          <select name='vih'".$i.">
		     <option value='0' 'selected'>Нет</option>
            <option value='1'>Да</option>
          </select>
      </label></div></td>
      <td><div align='center'><label>
       
          <input name='NachSm_H".$i."' type='text' size='2' maxlength='2'/>ч:
          <input type='text' name='NachSm_M".$i."'  size='2' maxlength='2'/>м
       
      </label> </div></td>
      <td><div align='center'>
        <input type='text' name='OkonchSm_H".$i."'  size='2' maxlength='2'/>ч:
        <input type='text' name='OkonchSm_M".$i."'  size='2' maxlength='2'/>м
      </div></td>
    </tr>
";
}

echo "  </table>
    <label>
    <div align='center'>
      <input type='Submit' name='save' value='Сохранить' />
    </label>
    <label>
      <input  name='reset' value='Очистить'  type='reset'/>
    </label>
	  <label>
        <input  name='cancel' value='Отменить'  type='submit'/>
    </label> </div>
</form>";
include("footer.php");
?>