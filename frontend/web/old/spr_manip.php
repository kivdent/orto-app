<?php
session_start();
//Необходима Установка Cpmposer https://getcomposer.org/
//Необходима установка PHP Spreadsheet https://phpspreadsheet.readthedocs.io/en/latest/
require '/var/www/orto/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


include('mysql_fuction.php');
$ThisVU="administrator";
$ModName="Справочник манипуляций";
$js="manip"; 
include("header.php");

switch ($_POST['action'])
{		
case "price_ch":
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE `preysk`=".$_POST['preysk']." order by `range`, `manip`";
//echo $query."<br />";
	
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$countA=$count;
	$resultA=$result;
	for ($i=0;$i<$countA;$i++)
			{
				$rowA = mysqli_fetch_array($resultA);
				$price_new=	$rowA['price'];
				
				if (round(($rowA['price']+($rowA['price']*$_POST['price'])/100),-1)==$rowA['price'])
			{
				$price_new=(floor((($rowA['price']+($rowA['price']*$_POST['price'])/100))/10))*10;
			}
			else
			{
				$price_new=round(($rowA['price']+($rowA['price']*$_POST['price'])/100),-1);
			}				
				
				//msg($price_new." ".$rowA['price']);
			$query = "UPDATE `manip` 
			SET `price`=".$price_new."
			WHERE `id`=".$rowA['id'];
			$result=sql_query($query,'orto',1);    $count=mysqli_num_rows($result);
			}
			ret('spr_manip.php');
		
		exit;	
	break;
case "all_change":
		$mat=$_SESSION['mat'];
		$price=$_POST['price'];
                                    $koef=$_POST['koef'];
		//msg($mat[$_SESSION['cm]][id']);
		for ($j=1;$j<=$_SESSION['cm'];$j++)
		{
			$query = "UPDATE `manip` 
			SET `price`=".$price[$j].", `koef`=".$koef[$j]."
			WHERE `id`=".$mat[$j]['id'];
			$result=sql_query($query,'orto',1);    $count=mysqli_num_rows($result);
		}
		ret('spr_manip.php');
		
		exit;	
break;
}
switch ($_GET['action'])
{
	case "AddCat":
		switch ($_GET['step'])
		{
			case "1":
				echo "<div class='head1'>Добавление категории</div>
				<form action='spr_manip.php' method='get' name='AddCatf'>
				<input name='action' type='hidden' value='AddCat' />
				<input name='step' type='hidden' value='2' />
				<input name='preysk' type='hidden' value='".$_GET['preysk']."' />
				Название категории:
				<textarea name='manip' cols='50' rows='3'></textarea>
				<br />
		<input name='save' type='submit'  value='Сохранить'/>
				</form> "; 
				include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO manip (`id`, `manip`,`preysk`, `cat`)
					VALUES (NULL,'".$_GET['manip']."','".$_GET['preysk']."','1')";
				////echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				ret("spr_manip.php?preysk=".$_GET['preysk']);
			break;
		}
	break;
	case "add":
		switch ($_GET['step'])
		{
			case "1":
				
echo "
<form action='spr_manip.php' method='get' id='manipf' name='manipf' onsubmit='return(chek(document.manipf.manip.value,document.manipf.price.value))'>
<input name='action' type='hidden' value='add' />
				<input name='step' type='hidden' value='2' />
				<input name='UpId' type='hidden' value='".$_GET['UpId']."' />
				<input name='preysk' type='hidden' value='".$_GET['preysk']."' />
			Новая манипуляция:<textarea name='manip' cols='50' rows='3'></textarea><br />

            Цена: <input type='text' name='price'  size='5' id='price'/><br /> 
            Коэффициент: <input type='text' name='koef'  size='5' id='koef'/><br /> 
            Запись в карте:<textarea name='zapis' cols='50' rows='3'></textarea>            
             <input type='submit' name='add' value='Добавить' />
			 </form>";
			 include("footer.php");
				exit;
			break;
			case "2":
				$query = "INSERT INTO manip (`id`, `manip`, `preysk`, `zapis`, `price`,`cat`, `UpId`,`koef`)
							VALUES (NULL,'".$_GET['manip']."','".$_GET['preysk']."','".$_GET['zapis']."','".$_GET['price']."','0','".$_GET['UpId']."','".$_GET['koef']."')";
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				msg('Манпуляция добавлена');
				ret("spr_manip.php?preysk=".$_GET['preysk']);
			break;
		}
			break;
	case "del":
				$query = "DELETE FROM manip WHERE id=".$_GET['id'];
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				if ($_GET['cat']==1)
				{
				$query = "DELETE FROM manip WHERE UpId=".$_GET['id'];
				//echo $query."<br />";
				$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
				}
				msg('Манипуляция удалена');
				ret("spr_manip.php?preysk=".$_GET['preysk']);
	break;
	case "change":
	if (isset($_GET['del']))
	{
		echo "<script language=\"JavaScript\" type=\"text/javascript\">location.href='spr_manip.php?action=del&id=".$_GET['id']."&cat=1'</script>";
	}
	if (isset($_GET['ok']))
	{
		$query = "UPDATE manip SET `manip`='".$_GET['manip']."',  
									`zapis`='".$_GET['zapis']."', 
									`price`= '".$_GET['price']."',
                                                                                                                                                             `koef`= '".$_GET['koef']."'  
				WHERE id='".$_GET['id']."'";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		msg('Прейскурант изменен');
		ret("spr_manip.php?preysk=".$_GET['preysk']);
	}
	else
	{
	    if ($_GET['id']=="")
		{
			msg('Выбирите позицию');
			ret("spr_manip.php");
		}
		$query = "SELECT * FROM `manip` WHERE `id`=".$_GET['id'];
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$rowA = mysqli_fetch_array($result);		
			echo "<form action='spr_manip.php' method='get' id='manipf' name='manipf' onsubmit='chek(document.manipf.manip.value,document.manipf.price.value)'>
			<input name='action' type='hidden'  value='change'/>
			<input name='id' type='hidden'  value='".$_GET['id']."'/>
			Манипуляция:
			<textarea name='manip' cols='50' rows='3'>".$rowA['manip']."</textarea><br />

             Стоимость:
             <input type='text' name='price'  size='5' id='price' value='".$rowA['price']."'/><br /> 
                  Коэфициент:
             <input type='text' name='koef'  size='5' id='koef' value='".$rowA['koef']."'/><br /> 
			Запись в карте:
			<textarea name='zapis' cols='50' rows='3'>".$rowA['zapis']."</textarea> <br />
          
             <input type='submit' name='ok' value='Изменить' /><input type='submit' name='del' value='Удалить' />";
		include("footer.php");
		exit;
	}
	break;
	case "show":
	 if (!(isset($_GET['preysk'])))
{
	$query = "SELECT `id` FROM `preysk`";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	$preysk=$row[0];
} 
else $preysk=$_GET['preysk'];
echo "
			<form action='' method='get'><script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='spr_manip.php?action=show&preysk=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			<input name='action' type='hidden'  value='add'/>
			Прейскурант:
			 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
			$query = "SELECT * FROM preysk";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($preysk==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
				else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
			}

echo "        </select></form>
<center>";
echo "Манипуляции:";
$query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE `preysk`=".$preysk." order by `range`, `manip`";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$cc=0;
$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['cat']==1)
		{
			$cc++;
			$cat[$cc]['id']=$row['id'];
			$cat[$cc]['manip']=$row['manip'];
			
		}
		else
		{
			$cm++;
			$mat[$cm]['id']=$row['id'];
			$mat[$cm]['manip']=$row['manip'];
			$mat[$cm]['price']=$row['price'];
			$mat[$cm]['UpId']=$row['UpId'];
		}
	}
$_SESSION['mat']=$mat;
$_SESSION['cm']=$cm;
$counter=0;
echo "<form action=\"spr_manip.php\" method=\"post\">";
echo "Увеличить на <input type=\"text\" name=\"price\" size='4' value='5'> %
<input type=\"hidden\" name=\"action\" value=\"price_ch\">
<input type=\"hidden\" name=\"preysk\" value=\"".$preysk."\">
<input type='submit' name='Submit' value='Ok' />";
echo "</form>";
echo "<form action=\"spr_manip.php\" method=\"post\">";

echo "<input type=\"hidden\" name=\"action\" value=\"all_change\">";
echo "<center><a href='spr_manip.php?action=AddCat&step=1&preysk=".$preysk."' class='menu'>Добавить категорию</a></center><hr width='100%' noshade='noshade' size='1'/>";
if ($cc>0)
{
echo "<TABLE BORDER='0'  align='left'>";
for($i=1;$i<=$cc;$i++)
	{
		echo "<TR><TD bgcolor='#FFFFFF'>
    <TABLE border='0' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000' align='left'><TR><TD align='left' bgcolor='#FFFFFF'>".$cat[$i]['manip']."
    <TABLE border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000' >";
		for($j=1;$j<=$cm;$j++)
		{
		if ($cat[$i]['id']==$mat[$j]['UpId'])
			echo "<TR><TD WIDTH=10 bgcolor='#FFFFFF'> ".$mat[$j]['id']." </TD><TD bgcolor='#FFFFFF'> ".$mat[$j]['manip']." </TD><td bgcolor='#FFFFFF'>".$mat[$j]['price']." руб.</td></TR>";
		} 
		echo "</TABLE></DIV></TD></TR>
   </TABLE>
   </TR></TD>";
	}
echo "</TABLE>";


}
include("footer.php");
exit;
	break;
                case "preyskprint":
                  //  msg($GET['koef']);
	 if (!(isset($_GET['preysk'])))
                {
                        $query = "SELECT `id` FROM `preysk`";

                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        $preysk=$row[0];
                } 
                else $preysk=$_GET['preysk'];
echo "
			<form action='' method='get'><script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='spr_manip.php?action=preyskprint&koef=".$_GET['koef']."&preysk=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			<input name='action' type='hidden'  value='add'/>
			Прейскурант:
			 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
			$query = "SELECT * FROM preysk";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($preysk==$row['id']) 
                                                                        {
                                                                            echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
                                                                            $preysk_name=$row['preysk'];
                                                                        }
				else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
			}

echo "        </select></form>
";
echo "Манипуляции:";
$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`koef` from `manip` WHERE `preysk`=".$preysk." order by `range`, `manip`";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$cc=0;
$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['cat']==1)
		{
			$cc++;
			$cat[$cc]['id']=$row['id'];
			$cat[$cc]['manip']=$row['manip'];
			
		}
		else
		{
			$cm++;
			$mat[$cm]['id']=$row['id'];
			$mat[$cm]['manip']=$row['manip'];
			$mat[$cm]['price']=$row['price'];
			$mat[$cm]['UpId']=$row['UpId'];
                                                    $mat[$cm]['koef']=$row['koef'];
		}
	}
$_SESSION['mat']=$mat;
$_SESSION['cm']=$cm;
$counter=0;
//echo "<form action=\"spr_manip.php\" method=\"post\">";
//echo "Увеличить на <input type=\"text\" name=\"price\" size='4' value='5'> %
//<input type=\"hidden\" name=\"action\" value=\"price_ch\">
//<input type=\"hidden\" name=\"preysk\" value=\"".$preysk."\">
//<input type='submit' name='Submit' value='Ok' />";
//echo "</form>";
//echo "<form action=\"spr_manip.php\" method=\"post\">";
//
//echo "<input type=\"hidden\" name=\"action\" value=\"all_change\">";
//echo "<center><a href='spr_manip.php?action=AddCat&step=1&preysk=".$preysk."' class='menu'>Добавить категорию</a></center><hr width='100%' noshade='noshade' size='1'/>";
echo "<center><a href='spr_manip.php?action=preyskprint&koef=1&preysk=".$preysk."' class='menu'>Прейскурант с коэффициентами</a>|"
        . "<a href='spr_manip.php?action=preyskprint&koef=0&preysk=".$preysk."' class='menu'>Прейскурант ,без коэффициентов</a></center><hr width='100%' noshade='noshade' size='1'/> ";

if ($cc>0)
{
echo "<strong>".$preysk_name."</strong></br><TABLE BORDER='0'  align='left'>";
for($i=1;$i<=$cc;$i++)
	{
		echo "<TR><TD bgcolor='#FFFFFF'>
    <TABLE border='0' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000' align='left'><TR><TD align='left' bgcolor='#FFFFFF'>".$cat[$i]['manip']."
    <TABLE border='1' cellspacing='0' cellpadding='0' bordercolor='#000000' bgcolor='#000000' >";
		for($j=1;$j<=$cm;$j++)
		{
		if ($cat[$i]['id']==$mat[$j]['UpId'])
                                    {
                                            echo "<TR><TD WIDTH=10 bgcolor='#FFFFFF' id='id'> ".$mat[$j]['id']." </TD>"
                                                                        . "<TD bgcolor='#FFFFFF' id='nazv'> ".$mat[$j]['manip']." </TD><td bgcolor='#FFFFFF' id='price'>".$mat[$j]['price']." руб.</td>";
                                                                        if($_GET['koef']==="1")  
                                                                        {
                                                                            echo "<td bgcolor='#FFFFFF' id='koef'>".$mat[$j]['koef']." </td>";
                                                                        }
                                                                       echo"</TR>";
                                    }
		} 
		echo "</TABLE></DIV></TD></TR>
   </TABLE>
   </TR></TD>";
	}
echo "</TABLE>";


}
include("footer.php");
exit;
break;
 
  case "savexls":
        $query = "SELECT * FROM preysk";
        //echo $query."<br />";
        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);

        for ($i=0;$i<$count;$i++)
        {
                $row = mysqli_fetch_array($result);
                $preysk_array[$row['id']]=$row['preysk'];
        }
        
        $spreadsheet = new Spreadsheet();
       echo "<center><a href='spr_manip.php?action=savexls&koef=1&' class='menu'>Прейскурант в таблицы с коэффициентами</a>|"
        . "<a href='spr_manip.php?action=savexls&koef=0' class='menu'>Прейскурант в талбицы ,без коэффициентов</a></center><hr width='100%' noshade='noshade' size='1'/></br>
        <a href='price.xlsx' class='menu'>Скачать</a>";
       
       
        //print_r($preysk_array);
        foreach ($preysk_array as $key => $value)
        {
         $preysk=(int)$key;
         $preysk_name=$value;
        
         //echo $key.'->'.$value.'('.mb_strlen($value).')</br>';
         if (mb_strlen($value)>31) {$sheet_name=mb_substr($value,0,30);}
         else { $sheet_name=$value;}
         //echo  $sheet_name."<br>";
        $query = "select `id`, `manip`, `price`, `cat`, `UpId`,`koef` from `manip` WHERE `preysk`=".$preysk." order by `range`, `manip`";
        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
        $cc=0;
        $cm=0;
                for ($i=0;$i<$count;$i++)
                {
                        $row = mysqli_fetch_array($result);
                        if ($row['cat']==1)
                        {
                                $cc++;
                                $cat[$cc]['id']=$row['id'];
                                $cat[$cc]['manip']=$row['manip'];

                        }
                        else
                        {
                                $cm++;
                                $mat[$cm]['id']=$row['id'];
                                $mat[$cm]['manip']=$row['manip'];
                                $mat[$cm]['price']=$row['price'];
                                $mat[$cm]['UpId']=$row['UpId'];
                                 $mat[$cm]['koef']=$row['koef'];
                        }
                }
        $counter=0;
$a=1;
if ($cc>0)
{


    $mysheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet,$sheet_name);
    $spreadsheet->addSheet($mysheet, 0);
    $sheet =$spreadsheet->getSheetByName($sheet_name);
    // $invalidCharacters = array('*', ':', '/', '\\', '?', '[', ']');
            //$invalidCharacters = $sheet->getInvalidCharacters();
       //  $preysk_name=str_replace($invalidCharacters, '', $preysk_name);
$sheet->setTitle($sheet_name);
$sheet->getHeaderFooter()
       ->setOddHeader('&C'.$preysk_name);
$sheet->getHeaderFooter()
       ->setOddFooter('&L'.date('d.m.Y').'&RДиректор ООО "Орто-Премьер" Черненко С.В.');
    $sheet->setCellValue('A'.$a, $preysk_name);
     $diap='A'.($a).':D'.$a;
      $sheet->mergeCells('A'.$a.':D'.$a);
      $styleArray = [
                                                        'font' => [
                                                            'bold' => true,
                                                        ]
                                                        ];
                                   $diap='A'.($a).':D'.$a;
                                   $sheet->getStyle($diap)->applyFromArray($styleArray);
  
     $a++;
                                   $sheet->getColumnDimension('A')->setWidth(7);
                                    $sheet->getColumnDimension('B')->setWidth(60);
                                    $sheet->getColumnDimension('C')->setWidth(14);
                                    $sheet->getColumnDimension('D')->setWidth(7);
for($i=1;$i<=$cc;$i++) 
	{                  
		
                                   $sheet->setCellValue('A'.$a, $cat[$i]['manip']);
                                   $sheet->mergeCells('A'.$a.':D'.$a);  
                                    $styleArray = [
                                                        'font' => [
                                                            'bold' => true,
                                                        ]
                                                        ];
                                   $diap='A'.($a).':D'.$a;
                                   $sheet->getStyle($diap)->applyFromArray($styleArray);
                                   $a++;
                                   $arrayData=['Код', 'Наименование', 'Цена', 'Коэф'];
                                   $styleArray = [
                                                        
                                                         'borders' => [
                                                            'allBorders' => [
                                                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                                            ],
                                                        ],
                                                        ];
                                   $diap='A'.($a).':D'.$a;
                                   $sheet->getStyle($diap)->applyFromArray($styleArray);
                                   $sheet->fromArray(
                                                            $arrayData,  // The data to set
                                                            NULL,        // Array values with this value will not be set
                                                            'A'.$a         // Top left coordinate of the worksheet range where
                                                                         //    we want to set these values (default is A1)
                                                        );
                                   $a++;
		for($j=1;$j<=$cm;$j++)
		{
		if ($cat[$i]['id']==$mat[$j]['UpId'])
                                    {
                                            $arrayData=[$mat[$j]['id'], $mat[$j]['manip'],$mat[$j]['price'].' руб.',$mat[$j]['koef']];
                                             $sheet->fromArray(
                                                            $arrayData,  // The data to set
                                                            NULL,        // Array values with this value will not be set
                                                            'A'.$a         // Top left coordinate of the worksheet range where
                                                                         //    we want to set these values (default is A1)
                                                        );
                                             $sheet->getStyle('B'.$a)->getAlignment()->setWrapText(true);
                                               $styleArray = [
                                                        
                                                         'borders' => [
                                                            'allBorders' => [
                                                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                                            ],
                                                        ],
                                                        ];
                                   $diap='A'.($a).':D'.$a;
                                   $sheet->getStyle($diap)->applyFromArray($styleArray);
                                             $a++;
                                    }
		} 
		
	}
}


}
$sheetIndex = $spreadsheet->getIndex(
    $spreadsheet->getSheetByName('Worksheet')
);
$spreadsheet->removeSheetByIndex($sheetIndex);
$writer = new Xlsx($spreadsheet);
$writer->save('price.xlsx');
include("footer.php");
exit;
break;

}
if (!(isset($_GET['preysk'])))
{
	$query = "SELECT `id` FROM `preysk`";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);
	$preysk=$row[0];
} 
else $preysk=$_GET['preysk'];
echo "
			<form action='' method='get'><script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='spr_manip.php?preysk=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
			<input name='action' type='hidden'  value='add'/>
			Прейскурант:
			 <select name='preysk' onchange=\"MM_jumpMenu('parent',this,0)\">";
			$query = "SELECT * FROM preysk";
			//echo $query."<br />";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			for ($i=0;$i<$count;$i++)
			{
				$row = mysqli_fetch_array($result);
				if ($preysk==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['preysk']."</option>";
				else echo "<option value='".$row['id']."'>".$row['preysk']."</option>";
			}

echo "        </select></form>
";
echo "Манипуляции:";
$query = "select `id`, `manip`, `price`, `cat`, `UpId`, `koef`  from manip WHERE `preysk`=".$preysk." order by `range`, `manip`";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$cc=0;
$cm=0;
	for ($i=0;$i<$count;$i++)
	{
		$row = mysqli_fetch_array($result);
		if ($row['cat']==1)
		{
			$cc++;
			$cat[$cc]['id']=$row['id'];
			$cat[$cc]['manip']=$row['manip'];
			
		}
		else
		{
			$cm++;
			$mat[$cm]['id']=$row['id'];
			$mat[$cm]['manip']=$row['manip'];
			$mat[$cm]['price']=$row['price'];
			$mat[$cm]['UpId']=$row['UpId'];
                                                     $mat[$cm]['koef']=$row['koef'];
		}
	}
$_SESSION['mat']=$mat;
$_SESSION['cm']=$cm;
$counter=0;
echo "<form action=\"spr_manip.php\" method=\"post\">";
echo "Увеличить на <input type=\"text\" name=\"price\" size='4' value='5'> %
<input type=\"hidden\" name=\"action\" value=\"price_ch\">
<input type=\"hidden\" name=\"preysk\" value=\"".$preysk."\">
<input type='submit' name='Submit' value='Ok' />";
echo "</form>";
echo "<form action=\"spr_manip.php\" method=\"post\">";

echo "<input type=\"hidden\" name=\"action\" value=\"all_change\">";
echo "<center><a href='spr_manip.php?action=AddCat&step=1&preysk=".$preysk."' class='menu'>Добавить категорию</a>|";
echo "<a href='spr_manip.php?action=preyskprint&koef=1&preysk=".$preysk."' class='menu'>Прейскурант с коэффициентами</a>|"
        . "<a href='spr_manip.php?action=preyskprint&koef=0&preysk=".$preysk."' class='menu'>Прейскурант ,без коэффициентов</a></center><hr width='100%' noshade='noshade' size='1'/>";
echo "<center><a href='spr_manip.php?action=savexls&koef=1&preysk=".$preysk."' class='menu'>Прейскурант в таблицы с коэффициентами</a>|"
        . "<a href='spr_manip.php?action=savexls&koef=0&preysk=".$preysk."' class='menu'>Прейскурант в талбицы ,без коэффициентов</a></center><hr width='100%' noshade='noshade' size='1'/> ";

if ($cc>0)
{
echo "<TABLE BORDER=0 align='left'>";
for($i=1;$i<=$cc;$i++)
	{
		echo "<TR><TD>
    <TABLE BORDER=0 align='left'><TR><TD align='left'><A  onClick='Toggle(this)' class='menu'><IMG SRC='image/minus.gif'> ".$cat[$i]['manip']."</A><DIV><a href='spr_manip.php?action=del&id=".$cat[$i]['id']."&cat=1' class='small2'>Удалить категорию</a>|<a href='spr_manip.php?action=add&UpId=".$cat[$i]['id']."&step=1&preysk=".$preysk."' class='small2'>Добавить манипуляцию</a><TABLE BORDER=0>";
		for($j=1;$j<=$cm;$j++)
		{
		if ($cat[$i]['id']==$mat[$j]['UpId']){
			echo "<TR><TD WIDTH=10></TD><TD><IMG SRC='image/leaf.gif'><a href='spr_manip.php?action=change&id=".$mat[$j]['id']."' class='small'>".$mat[$j]['manip']."</a></TD>"
                                                   . "<td><input type=\"text\" name=\"price[".$j."]\" size='4' value='".$mat[$j]['price']."'></td>"
                                                . "<td><input type=\"text\" name=\"koef[".$j."]\" size='4' value='".$mat[$j]['koef']."'><input type='submit' name='Submit' value='Ok' /></td></TR>";

                }
		} 
		echo "</TABLE></DIV></TD></TR>
   </TABLE>
   </TR></TD>";
	}
echo "</TABLE>";


}

echo "</form>";

include("footer.php");
?>