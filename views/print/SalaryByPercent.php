<?php

                    
	$fp=$this->reportingPeriod->id;
	$query = "SELECT `id`,`nach` , `okonch` ,`uet`
FROM `fin-per` 
ORDER BY `id` DESC" ;


//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$m=array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь");
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
		}
	}
}
	$dt=explode("-",$row['okonch']);
	echo "<div class='bold2'>Начисление заработной платы за ".$m[($this->reportingPeriod->start->format('n')-1)]."</div><br />";
		
	
echo "</table><br />";

///
?>

<span class = 'feature3'>Расчёт по проценту от выручки</span><br />
<table width = '100%' border = '1' cellpadding = '1' cellspacing = '0' bordercolor = '#999999'>
    <?php foreach ($salaryTable as $key => $row): ?>

        <?php if ($key == 0) : ?>
            <tr>
                <?php foreach ($row as $salaryItem): ?>
                    <td class = 'feature3'><?php echo $salaryItem; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php else : ?>

            <tr> 
                <?php foreach ($salaryTable[0] as $itemKey => $salaryItem): ?>

                    <td><?php echo $row[$itemKey]; ?></td>

                <?php endforeach; ?>
            </tr>

        <?php endif; ?>
    <?php endforeach; ?>
</table>
<br />


 <?php
// Оплаты по картам Черненко
    $chern_summ=0;
    include("tables.php");
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
echo "<span class='feature3'>Оплаты по картам Черненко:".$chern_summ."</span><br />";

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
echo "<span class='feature3'>Оплаты по картам Корчемная:".$korch_summ."</span><br /><br />";


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
echo "<span class='feature3'>Расчёт по сменам</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Сотрудник</td>
    <td class='feature3'>Часов</td>
	<td class='feature3'>За час</td>
	<td class='feature3'>Начислено смены</td>
	<td class='feature3'>Начислено по снимкам (сумма)</td>
	<td class='feature3'>Надбавки</td>
    <td class='feature3'>Зарплата</td>

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
    echo "<td>".$zp."</td>";
	echo "</tr>";
}
echo "</table>";

echo "<span class='feature3'>Расчёт по ставке</span><br />
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
  <tr>
    <td class='feature3'>Сотрудник</td>
    <td class='feature3'>Ставка</td>
    <td class='feature3'>Подоходный</td>
	<td class='feature3'>Зарплата</td>
    
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
	echo "<td>".($row['stavka']-($row['stavka']*$row['pn']))."</td></tr>";
}
echo "</table><br />";
	
	

