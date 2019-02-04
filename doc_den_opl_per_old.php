<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Финансовый отчёт за день (оплаты)"; 
include("header.php");
include("tables.php");
$qsm=1;
$query = "SELECT `nach` , `okonch`,`uet`
FROM `fin-per` 
ORDER BY `id` DESC 
LIMIT 0,1" ;
//echo $query."<br>";
$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
$dtNp=explode("-",$row['nach']);
$dtOp=explode("-",$row['okonch']);
$dtN=$row['nach'];
$dtO=$row['okonch'];
$uet=$row['uet'];
echo "<div class=\"head1\">Отчётный период: ".$dtNp[2].".".$dtNp[1].".".$dtNp[0]."-".$dtOp[2].".".$dtOp[1].".".$dtOp[0]."</div>";
			echo "<span class='head2'>Оплаты по чекам текущего периода</span>";
	////
	$c=0;
        $summ_bal=0;
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Пациент</td>
                                <td class='menutext'>Дата</td>
				<td class='menutext'>Сумма</td>
				<td class='menutext'>Баллы</td>
			  </tr>";
	for ($j=0;$j<=2;$j++)
	{
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`".$tables[$j][0]."`.`id`,
                `".$tables[$j][0]."`.`summ_k_opl`,
                `".$tables[$j][0]."`.`summ_vnes`,
                (`".$tables[$j][0]."`.`summ_k_opl`-`".$tables[$j][0]."`.`summ_vnes`) as dolg,
                    `".$tables[$j][0]."`.`date`
		FROM klinikpat, sotr, ".$tables[$j][0]."
		WHERE (
		(`".$tables[$j][0]."`.`vrach`='".$_SESSION['UserID']."') AND
		(`sotr`.`id` =`".$tables[$j][0]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j][0]."`.`pat`) AND
                (`".$tables[$j][0]."`.`date`<='".$dtO."') AND
                (`".$tables[$j][0]."`.`date`>='".$dtN."')AND";
                if ($j==2) {
                    $query .="(`".$tables[$j][0]."`.`sh_id`=0) AND";
                    
                }
                $query .= "
                (`".$tables[$j][0]."`.`summ_vnes`>=`".$tables[$j][0]."`.`summ_k_opl`))
                ";
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$c+=$count;
		$summ[$j]=0;
                $countA=$count;
                $resultA=$result;
		if ($count>0)
		{
			  for ($i=0;$i<$countA;$i++)
				{
					$rowA = mysqli_fetch_array($resultA);
                                        $dolg=$rowA['dolg'];
                                        $dt=explode("-",$rowA['date']);
                                       
                                        $query = "SELECT    `manip`.`koef`, 
                                                            `".$tables[$j][1]."`.`kolvo`, 
                                                            `".$tables[$j][1]."`.`".$tables[$j][2]."`, 
                                                            `".$tables[$j][1]."`.`manip`
                                                    FROM `".$tables[$j][1]."`, `manip`
                                                    WHERE 
                                                    (
                                                         (`".$tables[$j][1]."`.`".$tables[$j][2]."` =".$rowA['id'].") AND
                                                         (`".$tables[$j][1]."`.`manip` = `manip`.`id`)
                                                    )";
                                      // echo $query."<br />";
                                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                        $summ_dnev=0;
                                        for ($h=0;$h<$count;$h++)
                                        {
                                            $row = mysqli_fetch_array($result);
                                            if ($dolg==0) {$summ_dnev+=$row['koef']*$row['kolvo'];}
                                        }
                                        
					echo "
					  <tr class='alltext'>
						<td><a class='mmenu' target='_blanc' href=\"show.php?type=chek&dnev=".$rowA['id']."&table=".$tables[$j][0]."&podr=1\">".$rowA[0]." ".$rowA[1]." ".$rowA[2]."</a>
						</td>
                                                <td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
						<td>".$rowA['summ_k_opl']." руб.</td>
                                                <td>".$summ_dnev."</td>
					  </tr>";
                                        $summ_bal+=$summ_dnev;
					$summ[$j]+=$rowA[6];
				}
				
		}
	}
	echo "</table>";
        //
        ////
        ///Оплаты за схемы ортодонтии 
                $j=2;
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		`opl_vid`.`vid`,
		`".$tables[$j][0]."`.`id`,
                `oplata`.`dnev`
		FROM klinikpat, sotr, oplata, ".$tables[$j][0].", opl_vid
		WHERE (
		(`".$tables[$j][0]."`.`vrach`='".$_SESSION['UserID']."') AND
		(`oplata`.`date` >='".$dtN."') AND 
                (`oplata`.`date` <='".$dtO."') AND 
		(`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
		(`sotr`.`id` =`".$tables[$j][0]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j][0]."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
                (`".$tables[$j][0]."`.`sh_id`<>0) AND
		(`oplata`.`type`=".($j+1).") AND
                 (`".$tables[$j][0]."`.`date`>='".$dtN."')
                 AND
                 (`".$tables[$j][0]."`.`date`<='".$dtO."'))";
                //echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result); 
                if ($count>0) 
                {
                echo "<span class='head2'>Оплаты за ортодонтию за текущий период:</span>";
	         
                echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Пациент</td>
                                <td class='menutext'>Дата</td>
				<td class='menutext'>Сумма</td>
                                <td class='menutext'>Оплачено</td>
                                <td class='menutext'>Долг</td>
			  </tr>";
                $c=0;
                $summ_orto=0;
		$c+=$count;
                $countA=$count;
                $resultA=$result;
                for ($i=0;$i<$countA;$i++)
                {
                        $rowA = mysqli_fetch_array($resultA);
                        $summ_orto+=$rowA['vnes'];
                        $query = "SELECT `".$tables[$j][0]."`.`summ`,
                                `".$tables[$j][0]."`.`summ_k_opl`,
                                `".$tables[$j][0]."`.`summ_vnes`,
                                (`".$tables[$j][0]."`.`summ_k_opl`-`".$tables[$j][0]."`.`summ_vnes`) as `dolg`, 
                                `".$tables[$j][0]."`.`date`
                                    FROM `".$tables[$j][0]."`
                                    WHERE (`".$tables[$j][0]."`.`id` =".$rowA['dnev'].")";
                       // echo $query."<br />";
                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        $dt=explode("-",$row['date']);
                        $dolg=$row['dolg'];
                        $summ_k_opl=$row['summ_k_opl'];
                        $summ_vnes=$row['summ_vnes'];
                        echo "
                          <tr class='alltext'>
                                <td><a class='mmenu' target='_blanc' href=\"show.php?type=chek&dnev=".$rowA['dnev']."&table=".$tables[$j][0]."&podr=1\">".$rowA[0]." ".$rowA[1]." ".$rowA[2]."</a>
                                </td>
                                <td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
                                <td>".$summ_k_opl." руб.</td>
                                <td>".$summ_vnes." руб.</td>
                                <td>".$dolg."</td>
                          </tr>";
                }
				
		echo "</table>";
                }


// За пред период
        echo "<br /><span class='head2'>Оплаты за лечение за предыдущие периоды :</span>";
	////
	$c=0;
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Пациент</td>
                                <td class='menutext'>Дата</td>
				<td class='menutext'>Сумма</td>
				<td class='menutext'>Баллы</td>
			  </tr>";
	for ($j=0;$j<=2;$j++)
	{
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		`opl_vid`.`vid`,
		`".$tables[$j][0]."`.`id`,
                `oplata`.`dnev`
		FROM klinikpat, sotr, oplata, ".$tables[$j][0].", opl_vid
		WHERE (
		(`".$tables[$j][0]."`.`vrach`='".$_SESSION['UserID']."') AND
		(`oplata`.`date` >='".$dtN."')  
		 AND (`oplata`.`date` <='".$dtO."') AND
		(`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
		(`sotr`.`id` =`".$tables[$j][0]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j][0]."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
                (`".$tables[$j][0]."`.`date`<'".$dtN."') AND
		(`".$tables[$j][0]."`.`date`>'2014-11-1') AND
		(`oplata`.`type`=".($j+1).")";
                 if ($j==2) {$query .="AND (`".$tables[$j][0]."`.`sh_id`=0)";}
                $query .= ")";
                            
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$c+=$count;
		$summ[$j]=0;
                $countA=$count;
                $resultA=$result;
		if ($count>0)
		{
			  for ($i=0;$i<$countA;$i++)
				{
					$rowA = mysqli_fetch_array($resultA);
                                        $query = "SELECT `".$tables[$j][0]."`.`summ`,
                                                `".$tables[$j][0]."`.`summ_k_opl`,
                                                `".$tables[$j][0]."`.`summ_vnes`,
                                                (`".$tables[$j][0]."`.`summ_k_opl`-`".$tables[$j][0]."`.`summ_vnes`) as `dolg`, 
                                                `".$tables[$j][0]."`.`date`
                                                    FROM `".$tables[$j][0]."`
                                                    WHERE (`".$tables[$j][0]."`.`id` =".$rowA['dnev'].")";
                                        //echo $query."<br />";
                                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                        $row = mysqli_fetch_array($result);
                                        $dt=explode("-",$row['date']);
                                        $dolg=$row['dolg'];
                                        $summ_k_opl=$row['summ_k_opl'];
                                        $summ_vnes=$row['summ_vnes'];
                                        $query = "SELECT    `manip`.`koef`, 
                                                            `".$tables[$j][1]."`.`kolvo`, 
                                                            `".$tables[$j][1]."`.`".$tables[$j][2]."`, 
                                                            `".$tables[$j][1]."`.`manip`
                                                    FROM `".$tables[$j][1]."`, `manip`
                                                    WHERE 
                                                    (
                                                         (`".$tables[$j][1]."`.`".$tables[$j][2]."` =".$rowA['dnev'].") AND
                                                         (`".$tables[$j][1]."`.`manip` = `manip`.`id`)
                                                    )";
                                      // echo $query."<br />";
                                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                        $summ_dnev=0;
                                        for ($h=0;$h<$count;$h++)
                                        {
                                            $row = mysqli_fetch_array($result);
                                            if ($dolg==0) {$summ_dnev+=$row['koef']*$row['kolvo'];}
                                        }
                                        
					echo "
					  <tr class='alltext'>
						<td><a class='mmenu' target='_blanc' href=\"show.php?type=chek&dnev=".$rowA['id']."&table=".$tables[$j][0]."&podr=1\">".$rowA[0]." ".$rowA[1]." ".$rowA[2]."</a>
						</td>
                                                <td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
						<td>". $summ_k_opl." руб.</td>
                                                <td>".$summ_dnev."</td>
					  </tr>";
                                        $summ_bal+=$summ_dnev;
					 $summ[$j]+=$rowA[6];
				}
				
		}
	}
	echo "</table>";
	echo "<span class='head2'>Сумма баллов: ".$summ_bal."</span><br>";
        
        
         ///Оплаты  схемы ортодонтии пред период 
                $j=2;
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		`opl_vid`.`vid`,
		`".$tables[$j][0]."`.`id`,
                `oplata`.`dnev`
		FROM klinikpat, sotr, oplata, ".$tables[$j][0].", opl_vid
		WHERE (
		(`".$tables[$j][0]."`.`vrach`='".$_SESSION['UserID']."') AND
		(`oplata`.`date` >='".$dtN."') AND 
                (`oplata`.`date` <='".$dtO."') AND 
		(`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
		(`sotr`.`id` =`".$tables[$j][0]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j][0]."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
                (`".$tables[$j][0]."`.`sh_id`<>0) AND
		(`oplata`.`type`=".($j+1).") AND
                (`".$tables[$j][0]."`.`date`<'".$dtN."') AND
		(`".$tables[$j][0]."`.`date`>'2014-11-1'))";
               // echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result); 
                if ($count>0) 
                {
                echo "<span class='head2'>Оплаты за ортодонтию за прошлый период:</span>";
	         
                echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Пациент</td>
                                <td class='menutext'>Дата</td>
				<td class='menutext'>Сумма</td>
                                <td class='menutext'>Оплачено</td>
                                <td class='menutext'>Долг</td>
			  </tr>";
                $c=0;
		$c+=$count;
                $countA=$count;
                $resultA=$result;
                for ($i=0;$i<$countA;$i++)
                {
                        $rowA = mysqli_fetch_array($resultA);
                        $summ_orto+=$rowA['vnes'];
                        $query = "SELECT `".$tables[$j][0]."`.`summ`,
                                `".$tables[$j][0]."`.`summ_k_opl`,
                                `".$tables[$j][0]."`.`summ_vnes`,
                                (`".$tables[$j][0]."`.`summ_k_opl`-`".$tables[$j][0]."`.`summ_vnes`) as `dolg`, 
                                `".$tables[$j][0]."`.`date`
                                    FROM `".$tables[$j][0]."`
                                    WHERE (`".$tables[$j][0]."`.`id` =".$rowA['dnev'].")";
                       // echo $query."<br />";
                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        $dt=explode("-",$row['date']);
                        $dolg=$row['dolg'];
                        $summ_k_opl=$row['summ_k_opl'];
                        $summ_vnes=$row['summ_vnes'];
                        echo "
                          <tr class='alltext'>
                                <td><a class='mmenu' target='_blanc' href=\"show.php?type=chek&dnev=".$rowA['dnev']."&table=".$tables[$j][0]."&podr=1\">".$rowA[0]." ".$rowA[1]." ".$rowA[2]."</a>
                                </td>
                                <td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
                                <td>".$summ_k_opl." руб.</td>
                                <td>".$summ_vnes." руб.</td>
                                <td>".$dolg."</td>
                          </tr>";
                }
				
		echo "</table>";
                }
        
        /////Оплата по старой схеме до 01-11-2014
          echo "<br /><span class='head2'>Оплаты за лечение за предыдущие периоды по старой схеме :</span>";
	////
	$c=0;
  	$sum_old_sh=0;
	echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
			  <tr>
			  	<td class='menutext'>Пациент</td>
             <td class='menutext'>Дата</td>
				<td class='menutext'>Сумма</td>
             <td class='menutext'>Оплачено</td>
             <td class='menutext'>Долг</td>
				<td class='menutext'>Внесено</td>
			  </tr>";
	for ($j=0;$j<=2;$j++)
	{
		$query = "SELECT 
		`klinikpat`.`surname`, 
		`klinikpat`.`name`, 
		`klinikpat`.`otch`, 
		`sotr`.`surname`, 
		`sotr`.`name`, 
		`sotr`.`otch`, 
		`oplata`.`vnes`, 
		`opl_vid`.`vid`,
		`".$tables[$j][0]."`.`id`,
      `oplata`.`dnev`
		FROM klinikpat, sotr, oplata, ".$tables[$j][0].", opl_vid
		WHERE (
		(`".$tables[$j][0]."`.`vrach`='".$_SESSION['UserID']."') AND
		(`oplata`.`date` >='".$dtN."')  
		 AND (`oplata`.`date` <='".$dtO."') AND
		(`oplata`.`dnev` =`".$tables[$j][0]."`.`id`) AND 
		(`sotr`.`id` =`".$tables[$j][0]."`.`vrach`) AND 
		(`klinikpat`.`id` =`".$tables[$j][0]."`.`pat`) AND
		(`oplata`.`VidOpl`=`opl_vid`.`id`) AND
   		(`".$tables[$j][0]."`.`date`<'2014-11-1') AND
		(`oplata`.`type`=".($j+1)."))";
                
                
		//echo $query."<br />";
		$result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
		$c+=$count;
                $countA=$count;
                $resultA=$result;
		if ($count>0)
		{
			  for ($i=0;$i<$countA;$i++)
				{
					$rowA = mysqli_fetch_array($resultA);
               $sum_old_sh+=$rowA['vnes'];
               $query = "SELECT `".$tables[$j][0]."`.`summ`,
                                                `".$tables[$j][0]."`.`summ_k_opl`,
                                                `".$tables[$j][0]."`.`summ_vnes`,
                                                (`".$tables[$j][0]."`.`summ_k_opl`-`".$tables[$j][0]."`.`summ_vnes`) as `dolg`, 
                                                `".$tables[$j][0]."`.`date`
                                                    FROM `".$tables[$j][0]."`
                                                    WHERE (`".$tables[$j][0]."`.`id` =".$rowA['dnev'].")";
                                        //echo $query."<br />";
                                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                        $row = mysqli_fetch_array($result);
                                        $dt=explode("-",$row['date']);
                                        $dolg=$row['dolg'];
                                        $summ_k_opl=$row['summ_k_opl'];
                                        $summ_vnes=$row['summ_vnes'];
                                        $query = "SELECT    `manip`.`koef`, 
                                                            `".$tables[$j][1]."`.`kolvo`, 
                                                            `".$tables[$j][1]."`.`".$tables[$j][2]."`, 
                                                            `".$tables[$j][1]."`.`manip`
                                                    FROM `".$tables[$j][1]."`, `manip`
                                                    WHERE 
                                                    (
                                                         (`".$tables[$j][1]."`.`".$tables[$j][2]."` =".$rowA['dnev'].") AND
                                                         (`".$tables[$j][1]."`.`manip` = `manip`.`id`)
                                                    )";
                                      // echo $query."<br />";
                                        $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                        $summ_dnev=0;
                                        for ($h=0;$h<$count;$h++)
                                        {
                                            $row = mysqli_fetch_array($result);
                                            if ($dolg==0) {$summ_dnev+=$row['koef']*$row['kolvo'];}
                                        }
                                        
					echo "
					  <tr class='alltext'>
						<td><a class='mmenu' target='_blanc' href=\"show.php?type=chek&dnev=".$rowA['id']."&table=".$tables[$j][0]."&podr=1\">".$rowA[0]." ".$rowA[1]." ".$rowA[2]."</a>
						</td>
                   <td>".$dt[2].".".$dt[1].".".$dt[0]."</td>
						<td>". $summ_k_opl." руб.</td>
                  <td >".$summ_vnes."</td>
						<td>".$dolg."</td>
                  <td>".$rowA['vnes']."</td>
					  </tr>";
		
				}
				
		}
	}
	echo "</table>";
        echo "<p><span class='head2'>Сумма по баллам: ".($summ_bal*$uet)."</span><br />";
        if ($sum_old_sh>0){echo "<p><span class='head2'>Сумма по старой схеме: ".$sum_old_sh."</span><br />";}
        if ($summ_orto>0){
                            echo "<p><span class='head2'>Сумма ортодонтия: ".$summ_orto."</span><br />";
                            $sum_old_sh+=$summ_orto;
                        }
        echo "<p><span class='head2'>Сумма для расчёта зарплаты: ".(($summ_bal*$uet)+$sum_old_sh)."</span><br />";
include("footer.php");
?>