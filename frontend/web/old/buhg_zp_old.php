<?php
session_start();
include('mysql_fuction.php');
$ThisVU="buhg";
$ModName="Начисление заработной платы";  
include("header.php");
include("tables.php");
$query = "SELECT `id`
FROM `preysk`";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0; $i<$count; $i++)
{
    $row = mysqli_fetch_array($result);
    $preysk[$i]=$row['id'];
}
$preysk_count=$count;

//Финансовый период

$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");

// форма выбора финансового периода

echo "<form name=\"form1\" id=\"form1\"><div>Выбирите период: ";
						
echo "<script type=\"text/JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='buhg_zp.php?fp=\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

  <select name=\"fp\" onchange=\"MM_jumpMenu('parent',this,0)\">";


	if ($_GET['fp']==$row['id']) echo "<option value='".$row['id']."' selected='selected'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";
	else echo "<option value='".$row['id']."'>".$row['surname']." ".$row['name']." ".$row['otch']."</option>";


$query = "SELECT `id`,`nach` , `okonch`,`uet`
FROM `fin-per` 
ORDER BY `id` DESC" ;

$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);

for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
  
	if (!(isset($_GET['fp'])) and ($i==0))
	{
		$dtNp=explode("-",$row['nach']);
		$dtOp=explode("-",$row['okonch']);
		$dtN=$row['nach'];
		$dtO=$row['okonch'];
		$fp=$row['id']; 
		$uet=$row['uet'];
                                   echo "<option value='".$row['id']."' selected='selected'>".$m[($dtOp[1]-1)]." ".$dtOp[0]."</option>";
	}
	else
	{
		if ($_GET['fp']==$row['id'])
		{
			$dtNp=explode("-",$row['nach']);
			$dtOp=explode("-",$row['okonch']);
			$dtN=$row['nach'];
			$dtO=$row['okonch'];
			$fp=$row['id'];
			$uet=$row['uet'];
                        echo "<option value='".$row['id']."' selected='selected'>".$m[($dtOp[1]-1)]." ".$dtOp[0]."</option>";
		}
                else  
                    {
                    $dt=explode("-",$row['okonch']); 
                    echo "<option value='".$row['id']."'>".$m[($dt[1]-1)]." ".$dt[0]."</option>";
                }
                   
                    }
	
               
	switch ($_GET['action'])
	{
		case "avans":
			switch ($_GET['avans'])
			{
			 case "insert":
			 $query = "INSERT INTO `zp_avans` (`id`, `sotr`, `fp`, `avans`) 
			 			VALUES (NULL, ".$_GET['sotr'].", ".$_GET['fp'].", ".$_GET['summ'].")";
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			ret('buhg_zp.php');
				exit;
			 break;
			 case "update":
			 	 $query = "UPDATE `zp_avans` 
			 	 			SET 
			 	 			`avans`= ".$_GET['summ']."
			 	 			WHERE
			 	 			`id`=".$_GET['id'];
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			ret('buhg_zp.php');
				exit;
			 break;
			}
			
			$query = "SELECT `id`,`avans` FROM `zp_avans` WHERE ((`sotr`=".$_GET['sotr'].") AND (`fp`=".$_GET['fp']."))";
			//echo $query."<br>";
			$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
			
			if ($count>0)
			{
				$row = mysqli_fetch_array($result);
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ()
			{
				q=prompt('Изменение суммы аванса','".$row['avans']."');
				url='buhg_zp.php?action=avans&fp=".$_GET['fp']."&sotr=".$_GET['sotr']."&avans=update&id=".$row['id']."&summ='+q;
				location.href=url;
			}";
			echo "ChQ()</script>";
			exit;
				
			}
			echo "<script language=\"JavaScript\" type=\"text/javascript\">
			function ChQ()
			{
				q=prompt('Сумма аванса','1000');
				url='buhg_zp.php?action=avans&fp=".$_GET['fp']."&sotr=".$_GET['sotr']."&avans=insert&summ='+q;
				location.href=url;
			}";
			echo "ChQ()</script>";
			exit;
			ret('buhg_zp.php');
		break;
	}
	
}
echo "  </select>
";
echo "</div></form>";
                echo "<a class='mmenu' href=\"buhg_zp_new.php\">Печать отчёта</a><br />";
	echo "<div class='head1'>Начисление заработной платы за ".$m[($dtOp[1]-1)]." ".$dtOp[0]."</div><br />";
	echo "<a class='mmenu' target='_blanc' href=\"print.php?type=zp_otchet&fp=".$fp."&m=".($dtOp[1]-1)."\">Печать отчёта</a><br />";
			//Суммы врачей
		$c=0;
                $query = "SELECT 
                `sotr`.`id`, 
                `sotr`.`surname`, 
                `sotr`.`name`, 
                `sotr`.`otch`,
                `sotr`.`dolzh`, 
                `zarp_card`.`stavka`,
                `zarp_card`.`id` as zc_id,
                `proc_sh`.`id` as pc_id,
                `zarp_card`.`pn`
                FROM sotr,zarp_card,proc_sh
                WHERE (
                (`proc_sh`.`id`=`zarp_card`.`ps`) AND 
                (`zarp_card`.`type`=1) AND
                (`sotr`.`id`=`zarp_card`.`sotr`) 
                )";
                //echo $query."<br />";
                $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
             //   echo $count."<br />"; 
                for ($i=0;$i<$count;$i++)
                {
                                $row = mysqli_fetch_array($result);              
                                $sotr[$row['id']]['zc']=$row['zc_id'];
                                $sotr[$row['id']]['stavka']=$row['stavka'];
                                $sotr[$row['id']]['pc']=$row['pc_id'];
                                $sotr[$row['id']]['name']=$row['surname']." ".$row['name']." ".$row['otch'];
                                $sotr[$row['id']]['dolzh']=$row['dolzh'];
                                $sotr[$row['id']]['pn']=$row['pn'];
                                for ($h=0;$h<$preysk_count;$h++)
                                {
                                    $sotr[$row['id']]['lech_bal'][$preysk[$h]]=0;
                                } 
                                $sotr[$row['id']]['orto']=0;
                                $sotr[$row['id']]['old']=0;
                                $sotr_sp[$c]=$row['id'];
                                $c++;
                }
//msg ($c); 
                for ($i=0;$i<$c;$i++)
                {
                    // Расчёт оплат за лечение за текущий месяц
                    for ($j=0;$j<=2;$j++)
                    {
                        $query = "SELECT `manip`.`preysk`, ROUND(sum( `manip`.`koef`*`".$tables[$j][1]."`.`kolvo`),2) as summ
                        FROM `manip`, `".$tables[$j][0]."`, `".$tables[$j][1]."`
                        WHERE (
                        (`".$tables[$j][0]."`.`vrach` =".$sotr_sp[$i].") AND 
                        (`".$tables[$j][0]."`.`id` =`".$tables[$j][1]."`.`".$tables[$j][2]."`) AND 
                        (`".$tables[$j][1]."`.`manip` = `manip`.`id`) AND 
                        (`".$tables[$j][0]."`.`date` >='".$dtN."') AND 
                        (`".$tables[$j][0]."`.`date` <='".$dtO."') AND
                        (`".$tables[$j][0]."`.`summ_k_opl` =`".$tables[$j][0]."`.`summ_vnes`) 
                        ";
                          if ($j==2) 
                              {
                              $query .="AND (`".$tables[$j][0]."`.`sh_id`=0)";
                              }
                           $query .= ") GROUP BY `manip`.`preysk`
                           				 ";
                        //echo $query."<br />";
                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                        FOR ($w=0;$w<$count;$w++)
                        {
                            $row = mysqli_fetch_array($result);
                            $sotr[$sotr_sp[$i]]['lech_bal'][$row['preysk']]+=$row['summ'];
                        }
                        }
                      // Расчёт оплат за лечение за предыдущий период
                        
                    for ($j=0;$j<=2;$j++)
                    {
                        $query = "SELECT `manip`.`preysk`, ROUND(sum( `manip`.`koef`*`".$tables[$j][1]."`.`kolvo`),2) as summ
                        FROM `oplata`,`manip`, `".$tables[$j][0]."`, `".$tables[$j][1]."`
                        WHERE (
                        (`".$tables[$j][0]."`.`vrach` =".$sotr_sp[$i].") AND 
                        (`".$tables[$j][0]."`.`id` =`".$tables[$j][1]."`.`".$tables[$j][2]."`) AND 
                        (`".$tables[$j][1]."`.`manip` = `manip`.`id`) AND 
                        (`".$tables[$j][0]."`.`date` <'".$dtN."') AND
                        (`".$tables[$j][0]."`.`date` >='2014-11-01') AND 
                        (`oplata`.`date` >='".$dtN."')  
                         AND (`oplata`.`date` <='".$dtO."') AND
                        (`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
                        (`".$tables[$j][0]."`.`summ_k_opl` =`".$tables[$j][0]."`.`summ_vnes`)AND
                        (`oplata`.`type`=".($j+1).")";
                         if ($j==2) {$query .="AND (`".$tables[$j][0]."`.`sh_id`=0)";}
                        $query .= ") GROUP BY `manip`.`preysk`";
                       //echo $query."<br />";
                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                       FOR ($w=0;$w<$count;$w++)
                        {
                            $row = mysqli_fetch_array($result);
                            $sotr[$sotr_sp[$i]]['lech_bal'][$row['preysk']]+=$row['summ'];
                        }
                        
                    }   
                    //Оплаты ортодонтии по схеме
                $j=2;
		$query = "SELECT 
		sum(`oplata`.`vnes`) as summ
		FROM klinikpat, oplata, ".$tables[$j][0]."
		WHERE (
		(`".$tables[$j][0]."`.`vrach`='".$sotr_sp[$i]."') AND
		(`oplata`.`date` >='".$dtN."') AND 
                (`oplata`.`date` <='".$dtO."') AND 
		(`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
		(`klinikpat`.`id` =`".$tables[$j][0]."`.`pat`) AND
		(`".$tables[$j][0]."`.`sh_id`<>0) AND
		(`oplata`.`type`=".($j+1).") AND
		(`".$tables[$j][0]."`.`date`>='2014-11-1'))";
              //  echo $query."<br />";
               $result=sql_query($query,'orto',1);    $count=mysqli_num_rows($result);
                    if ($count>0)
                    {
                    $row = mysqli_fetch_array($result);
                    $sotr[$sotr_sp[$i]]['orto']=$row['summ'];
                    }
                //Оплаты по чекам до 2014-11-01
                      for ($j=0;$j<=2;$j++)
                    {
                        $query = "SELECT 
                        sum(`oplata`.`vnes`) as summ
                        FROM oplata, ".$tables[$j][0]."
                        WHERE (
                        (`".$tables[$j][0]."`.`vrach`='".$sotr_sp[$i]."') AND
                        (`oplata`.`date` >='".$dtN."') AND 
                        (`oplata`.`date` <='".$dtO."') AND 
                        (`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
                        (`oplata`.`type`=".($j+1).") AND
                        (`".$tables[$j][0]."`.`date`<'2014-11-1'))";
                        //echo $query."<br />";
                       $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                       FOR ($w=0;$w<$count;$w++)
                        {
                            $row = mysqli_fetch_array($result);
                            $sotr[$sotr_sp[$i]]['old']+=$row['summ'];
                        }
                      }
}
	echo "<br /><span class='head3'>Расчёт по проценту от выручки</span><br />
		<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Врач</td>
    <td class='menutext'>Сумма (баллы) за лечение</td>
    <td class='menutext'>Сумма (баллы) за хирургию</td>
    <td class='menutext'>Сумма (баллы) за ортодонтию</td>
    <td class='menutext'>Оплаты по схемам ортодонтии</td>
   
  </tr>";
for ($i=0;$i<$c;$i++)
{
echo "<tr>";	

   echo " <td class='menutext'>".$sotr[$sotr_sp[$i]]['name']."</td>";
   echo " <td class='menutext'>".((array_sum($sotr[$sotr_sp[$i]]['lech_bal'])-$sotr[$sotr_sp[$i]]['lech_bal'][6]-$sotr[$sotr_sp[$i]]['lech_bal'][3])*$uet)." (".(array_sum($sotr[$sotr_sp[$i]]['lech_bal'])-$sotr[$sotr_sp[$i]]['lech_bal'][6]-$sotr[$sotr_sp[$i]]['lech_bal'][3]).")</td>";
    echo "<td class='menutext'>".($sotr[$sotr_sp[$i]]['lech_bal'][6]*$uet)." (".$sotr[$sotr_sp[$i]]['lech_bal'][6].")</td>";
    echo "<td class='menutext'>".($sotr[$sotr_sp[$i]]['lech_bal'][3]*$uet)." (".$sotr[$sotr_sp[$i]]['lech_bal'][3].")</td>";
    echo "<td class='menutext'>".$sotr[$sotr_sp[$i]]['orto']."</td>";


echo "</tr>";
}




echo "</table><br />";


// Оплаты по картам Черненко
$chern_summ=0;
 for ($j=0;$j<=2;$j++)
 {
    $query = "SELECT 
    sum(`oplata`.`vnes`) as summ
    FROM oplata, ".$tables[$j][0]."
    WHERE (
    (`".$tables[$j][0]."`.`vrach`='2') AND
    (`oplata`.`date` >='".$dtN."') AND 
    (`oplata`.`date` <='".$dtO."') AND 
    (`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
    (`oplata`.`VidOpl`=5) AND
    (`oplata`.`type`=".($j+1)."))";
   // echo $query."<br />";
    $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
    if ($count>0)
    {
    FOR ($w=0;$w<$count;$w++)
    {
    $row = mysqli_fetch_array($result);
    $chern_summ+=$row['summ'];
    }
    }
}
echo "<span class='head3'>Оплаты по картам Черненко:".$chern_summ."</span><br />";

/// Оплаты по картам Корчемная
$korch_summ=0;
 for ($j=0;$j<=2;$j++)
 {
    $query = "SELECT 
    sum(`oplata`.`vnes`) as summ
    FROM oplata, ".$tables[$j][0]."
    WHERE (
    (`".$tables[$j][0]."`.`vrach`='3') AND
    (`oplata`.`date` >='".$dtN."') AND 
    (`oplata`.`date` <='".$dtO."') AND 
    (`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
    (`oplata`.`VidOpl`=5) AND
    (`oplata`.`type`=".($j+1)."))";
   // echo $query."<br />";
    $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
    if ($count>0)
    {
    FOR ($w=0;$w<$count;$w++)
    {
    $row = mysqli_fetch_array($result);
    $korch_summ+=$row['summ'];
    }
    }
}
echo "<span class='head3'>Оплаты по картам Корчемная:".$korch_summ."</span><br />";


$query = "SELECT `sotr`.`id`,`sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` , `zarp_card`.`ph`,`zarp_card`.`id` as zc
FROM sotr, zarp_card
WHERE (
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =3
)
)";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$countA=$count;
$resultA=$result;
echo "<span class='head3'>Расчёт по сменам</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Сотрудник</td>
    <td class='menutext'>Часов</td>
	<td class='menutext'>За час</td>
	<td class='menutext'>Начислено смены</td>
	<td class='menutext'>Начислено по снимкам (сумма)</td>
	<td class='menutext'>Надбавки</td>
	<td class='menutext'>Подоходный</td>
    <td class='menutext'>Зарплата</td>
    <td class='menutext'>Действия</td>
  </tr>";
for ($i=0; $i<$countA; $i++)
{
	$rowA = mysqli_fetch_array($resultA);
	echo "<tr>";
	echo "<td>".$rowA['surname']." ".$rowA['name']." ".$rowA['otch']."</td>";

$dtN_TS=mktime(0,0,0,(integer)$dtNp[1],(integer)$dtNp[2],(integer)$dtNp[0]);
$dtO_TS=mktime(0,0,0,(integer)$dtOp[1],(integer)$dtOp[2],(integer)$dtOp[0]);

	$query = "SELECT `tabel`.`time`
	FROM  tabel
	WHERE (
	(`tabel`.`date` >='".$dtN."') AND 
	(`tabel`.`date` <='".$dtO."') AND 
	(`tabel`.`sotr` =".$rowA['id'].")
	)";
	//echo $query."<br />";

	
$query = "SELECT `sotr` as id,`in`, `out`, `id` as tid, `date` 
	FROM `tabel_reg`
	 WHERE (
(`date` >='".$dtN."') AND 
(`date` <='".$dtO."') AND 
(`sotr` =".$rowA['id'].")
)
ORDER BY `sotr` ASC, `date` ASC";	
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
			$in=explode(":",$row['in']);
		$in2=mktime($in[0],$in[1],0,date('m'),date('d'),date('Y'));
	
		$out=explode(":",$row['out']);
		$out2=mktime($out[0],$out[1],0,date('m'),date('d'),date('Y'));
		if (($out2-$in2)>0) $summ+=($out2-$in2);
		
	}
	//
	$summ+=21600;
	$ss=round($summ/3600,2);
    echo "<td>".$ss."</td>";
	echo "<td>".$rowA['ph']."</td>";
	$zp=(($summ/3600)*$rowA['ph']);
	echo "<td>".round($zp,2)."</td>";
        ///Снимики
              // Расчёт оплат за лечение за текущий месяц
                    $j=0;
                    $summ=0;
                        $query = "SELECT `manip`.`preysk`, ROUND(sum( `manip`.`koef`*`".$tables[$j][1]."`.`kolvo`),2) as summ
                        FROM `manip`, `".$tables[$j][0]."`, `".$tables[$j][1]."`
                        WHERE (
                        (`".$tables[$j][0]."`.`vrach` =".$rowA['id'].") AND 
                        (`".$tables[$j][0]."`.`id` =`".$tables[$j][1]."`.`".$tables[$j][2]."`) AND 
                        (`".$tables[$j][1]."`.`manip` = `manip`.`id`) AND 
                        (`".$tables[$j][0]."`.`date` >='".$dtN."') AND 
                        (`".$tables[$j][0]."`.`date` <='".$dtO."') AND
                        (`".$tables[$j][0]."`.`summ_k_opl` =`".$tables[$j][0]."`.`summ_vnes`)
                        ";
                          if ($j==2) 
                              {
                              $query .="AND (`".$tables[$j][0]."`.`sh_id`=0)";
                              }
                           $query .= ") GROUP BY `manip`.`preysk`";
                       //echo $query."<br />";
                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                        FOR ($w=0;$w<$count;$w++)
                        {
                            $row = mysqli_fetch_array($result);
                            $summ+=$row['summ'];
                        }
                        
                      // Расчёт оплат за лечение за предыдущий период
                       
                   
                        $query = "SELECT `manip`.`preysk`, ROUND(sum( `manip`.`koef`*`".$tables[$j][1]."`.`kolvo`),2) as summ
                        FROM `oplata`,`manip`, `".$tables[$j][0]."`, `".$tables[$j][1]."`
                        WHERE (
                        (`".$tables[$j][0]."`.`vrach` =".$rowA['id'].") AND 
                        (`".$tables[$j][0]."`.`id` =`".$tables[$j][1]."`.`".$tables[$j][2]."`) AND 
                        (`".$tables[$j][1]."`.`manip` = `manip`.`id`) AND 
                        (`".$tables[$j][0]."`.`date` <'".$dtN."') AND
                        (`oplata`.`date` >='".$dtN."')  
                         AND (`oplata`.`date` <='".$dtO."') AND
                        (`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
                        (`".$tables[$j][0]."`.`summ_k_opl` =`".$tables[$j][0]."`.`summ_vnes`)AND
                        (`oplata`.`type`=".($j+1).")";
                         if ($j==2) {$query .="AND (`".$tables[$j][0]."`.`sh_id`=0)";}
                         $query .= ") GROUP BY `manip`.`preysk`";
                      // echo $query."<br />";
                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                       FOR ($w=0;$w<$count;$w++)
                        {
                            $row = mysqli_fetch_array($result);
                            $summ+=$row['summ'];
                        }
                        
                 $summ=$summ*$uet;
	echo "<td>".$summ*0.15." (".$summ.")</td>";
	$zp+=$summ*0.15;
	$query = "SELECT `nadb`.`summ`
FROM nadb, nadb_sootv
WHERE ((`nadb_sootv`.`zc` =".$rowA['zc'].") AND (`nadb`.`id` =`nadb_sootv`.`nadb`))";
	//echo $query."<br />";
	$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
	$summ=0;
	for ($j=0; $j<$count; $j++)
	{
		$row = mysqli_fetch_array($result);
		$summ+=$row['summ'];
	}
	echo "<td>".$summ."</td>";
	$zp+=$summ;
	echo "<td>".round(($zp*0.13),2)."</td>";
	$zp-=($zp*0.13);
    echo "<td>".round($zp,2)."</td>";
    echo "<td>";
    echo " <a class='menu2' target='_blanc' href=\"print.php?type=zp_fishka&sotr=".$rowA['id']."&vid=2&fp=".$fp."\">Печать</a><br />";
 
    echo "</td>";
	echo "</tr>";
}
echo "</table>";

echo "<span class='head3'>Расчёт по ставке</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='menutext'>Сотрудник</td>
    <td class='menutext'>Ставка</td>
    <td class='menutext'>Подоходный</td>
	<td class='menutext'>Зарплата</td>
    <td class='menutext'>Действия</td>
  </tr>";
$query = "SELECT `sotr`.`id`, `sotr`.`surname` , `sotr`.`name` , `sotr`.`otch` , `zarp_card`.`pn` , `zarp_card`.`stavka` 
FROM sotr, zarp_card
WHERE (
(
`zarp_card`.`sotr` = `sotr`.`id` 
)
AND (
`zarp_card`.`type` =2
)
)";
//echo $query."<br />";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
for ($i=0; $i<$count; $i++)
{
	$row = mysqli_fetch_array($result);
	echo "<tr>";
	echo "<td>".$row['surname']." ".$row['name']." ".$row['otch']."</td>";
	echo "<td>".$row['stavka']."</td>";
	echo "<td>".($row['stavka']*$row['pn'])."</td>";
	echo "<td>".($row['stavka']-($row['stavka']*$row['pn']))."</td>";
	echo "<td>";
	echo " <a class='menu2' target='_blanc' href=\"print.php?type=zp_fishka&sotr=".$row['id']."&vid=3&fp=".$fp."\">Печать</a><br />";
	echo "</td></tr>";
}
echo "</table><br />";
include("footer.php");
?>