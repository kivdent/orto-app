<?php

include('mysql_fuction.php');
$ThisVU = "all";
$this->title = "Работа спациентом";
$js = "insert";
$this->context->layout = '@frontend/views/layouts/light.php';
if (!(isset($_SESSION['proc_sk']))) $_SESSION['proc_sk'] = 0;
switch ($_GET['action']) {
    case "oplata":
        $preysk = 4;
        switch ($_GET['act']) {
            case "add":
                if (!(isset($_SESSION['countm'][1]))) {
                    $query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=" . $_GET['manip'];
                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    $_SESSION['countm'][1] = 1;
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][1] = $_GET['manip'];
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][2] = 1;
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][3] = $row['manip'];
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][4] = $row['price'];
                } else {
                    $f = 0;
                    for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                        if ($_GET['manip'] == $_SESSION['chek'][1][$i][1]) {
                            $f = 1;
                            $_SESSION['chek'][1][$i][2] = $_SESSION['chek'][1][$i][2] + 1;
                        }
                    }
                    if ($f == 0) {
                        $query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=" . $_GET['manip'];
                        //echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        $_SESSION['countm'][1]++;
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][1] = $_GET['manip'];
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][2] = 1;
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][3] = $row['manip'];
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][4] = $row['price'];
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][5] = $row['zapis'];
                    }

                }
                ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk);
                break;
            case "del":
                if ($_SESSION['countm'][1] == 1) {
                    $_SESSION['countm'][1] = 0;
                } else
                    for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                        if ($_GET['chek'] == $_SESSION['chek'][1][$i][1]) {
                            for ($j = $i; $j < $_SESSION['countm'][1 - 1]; $j++) {

                                $_SESSION['chek'][1][$j][1] = $_SESSION['chek'][1][$j + 1][1];
                                $_SESSION['chek'][1][$j][2] = $_SESSION['chek'][1][$j + 1][2];
                                $_SESSION['chek'][1][$j][3] = $_SESSION['chek'][1][$j + 1][3];
                                $_SESSION['chek'][1][$j][4] = $_SESSION['chek'][1][$j + 1][4];
                                $_SESSION['chek'][1][$j][5] = $_SESSION['chek'][1][$j + 1][5];
                            }
                            $_SESSION['countm'][1] = $_SESSION['countm'][1] - 1;
                            $i = $j + 1;
                        }
                    }
                ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk);
                break;
            case "p1":
                for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                    if ($_GET['chek'] == $_SESSION['chek'][1][$i][1]) {
                        $_SESSION['chek'][1][$i][2] = $_SESSION['chek'][1][$i][2] + 1;
                    }
                }
                ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk);
                break;
            case "m1":
                for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                    if ($_GET['chek'] == $_SESSION['chek'][1][$i][1]) {
                        if ($_SESSION['chek'][1][$i][2] == 1) {
                            msg("Количество манипуляций не может быть меньше одного");
                        } else $_SESSION['chek'][1][$i][2] = $_SESSION['chek'][1][$i][2] - 1;
                    }
                }
                ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk);
                break;
            case "chQ":
                if ($_GET['sstep'] == 1) {
                    echo "<script language=\"JavaScript\" type=\"text/javascript\">
					function ChQ(id,qq)
					{
						q=prompt('Введите количество',qq);
						url='pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $_GET['preysk'] . "&id='+id+'&act=chQ&sstep=2&q='+q;
						location.href=url;
					}";
                    echo "ChQ('" . $_GET['id'] . "','" . $_SESSION['chek'][1][$_GET['id']][2] . "')</script>";
                } else {
                    $_SESSION['chek'][1][$_GET['id']][2] = $_GET['q'];
                    ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $_GET['preysk']);
                }
                break;
            case "next":
                if ($_SESSION['countm'][1] > 0) {
                    echo "<div class='head3'>Пациент: " . $_SESSION['pat_name'] . "</div><hr width='100%' noshade='noshade' size='1'/>";
                    $opl = 0;


                    for ($i = 1; $i <= 1; $i++) {
                        $opl = $opl + $_SESSION['summ'][$i];
                        if (round(($_SESSION['summ'][$i] - ($_SESSION['summ'][$i] * $_SESSION['proc_sk']) / 100), -1) == $_SESSION['summ'][$i]) {
                            $summ_sk = (floor((($_SESSION['summ'][$i] - ($_SESSION['summ'][$i] * $_SESSION['proc_sk']) / 100)) / 10)) * 10;
                        } else {
                            $summ_sk = round(($_SESSION['summ'][$i] - ($_SESSION['summ'][$i] * $_SESSION['proc_sk']) / 100), -1);
                        }
                    }
                    $query = "INSERT INTO `schet_orto` (`id`, `vrach`, `pat`, `date`, `summ`, `summ_k_opl`, `summ_vnes`,`skidka`)
		VALUES (NULL, 
		'" . $_SESSION["UserID"] . "',
		'" . $_SESSION['pat'] . "', 
		'" . date('Y-m-d') . "',
		'" . $opl . "',
		'" . $summ_sk . "',
		0,
		'" . $_SESSION['proc_sk'] . "')";
                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $pr = $result;
                    $c = 1;
                    $m[$c][1] = $_SESSION['chek'][1][1][1];
                    $m[$c][2] = 0;
                    $m[$c][3] = $_SESSION['chek'][1][1][3];
                    $m[$c][4] = $_SESSION['chek'][1][1][4];
                    for ($i = 1; $i <= 1; $i++) {
                        for ($j = 1; $j <= $_SESSION['countm'][$i]; $j++) {
                            $f = 0;
                            for ($q = 1; $q <= $c; $q++) {
                                if ($m[$q][1] == $_SESSION['chek'][$i][$j][1]) {

                                    $m[$q][2] += $_SESSION['chek'][$i][$j][2];
                                    $f = 1;
                                }
                            }
                            if ($f == 0) {
                                $c = $c + 1;
                                $m[$c][1] = $_SESSION['chek'][$i][$j][1];
                                $m[$c][2] = $_SESSION['chek'][$i][$j][2];
                                $m[$c][3] = $_SESSION['chek'][$i][$j][3];
                                $m[$c][4] = $_SESSION['chek'][$i][$j][4];
                            }
                        }
                    }

                    $query = "INSERT INTO `manip_sh_orto` (`id`,`manip`, `kolvo`,`SO`) values ";
                    for ($i = 1; $i <= 1; $i++) {
                        $NZub = 0;
                        for ($j = 1; $j <= $_SESSION['countm'][$i]; $j++) {
                            if ($j == 1) $query .= " (NULL,'" . $_SESSION['chek'][$i][$j][1] . "','" . $_SESSION['chek'][$i][$j][2] . "','" . $pr . "')";
                            else $query .= ", (NULL,'" . $_SESSION['chek'][$i][$j][1] . "','" . $_SESSION['chek'][$i][$j][2] . "','" . $pr . "')";
                        }
                    }
                    //echo "Вставка в Манипуляции при приёме<br>";
                    //echo $query."<br>";

                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    echo "Оплата № " . $pr;
                    echo "<br /><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
                    unset($s);
                    for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                        echo "  <tr>
				<td width='6%' align='center'>" . $i . "</td>
				<td width='62%' align='left'>" . $m[$i][3] . "</td>
				<td width='10%' align='center'>" . $m[$i][2] . "</td>
				<td width='12%' align='center'>" . $m[$i][4] . " руб.</td>
				<td width='10%' align='center'>" . ($m[$i][2] * $m[$i][4]) . " руб.</td>
			  </tr>";
                        $s += $m[$i][2] * $m[$i][4];
                    }


                    echo "</table>";
                    echo "<div align='right'>Итого: " . $s . " руб. <br>";
                    $query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
FROM skidka, klinikpat
WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='" . $_SESSION['pat'] . "'))";
                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    if ($_SESSION['proc_sk'] > 0) {
                        $row = mysqli_fetch_array($result);
                        echo "<div align='right'>Итого со скидкой: " . $summ_sk . " руб.</div>";
                    }

                    echo "<a href='pat_tooday_orto.php'class='mmenu'>Закрыть</a>";
                    unset($_SESSION['chek']);
                    unset($_SESSION['proc_sk']);
                    unset($_SESSION['countm']);
                    unset($_SESSION['NZub']);
                    unset($_SESSION['dsZub']);
                    unset($_SESSION['QZub']);
                    unset($_SESSION['pat']);
                    unset($_SESSION['pat_name']);
                    unset($_SESSION['zh']);
                    unset($_SESSION['obk']);
                    unset($_SESSION['lech']);
                    unset($_SESSION['an']);
                    unset($_SESSION['OsmID']);
                    unset($_SESSION['summ']);

                    //include("footer.php");
                    break;
                } else {
                    msg("Вы не выбрали не одной манипуляции");
                    ret("pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk);
                }


                break;
        }
        /*Оплата*/
        if ($_GET['act'] != 'next') {
            if (!(isset($_GET['preysk']))) {
                $query = "SELECT * 
				FROM `preysk`
				WHERE id <4001
				LIMIT 1";
                //echo $query."<br />";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $preysk = $row[0];
            } else $preysk = $_GET['preysk'];
            if (!(isset($_SESSION['pat']))) $_SESSION['pat'] = $_GET['pat'];
            //////////Заполнение лечения
            echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='1' />";
            $query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=" . $_SESSION['pat'];
            //echo $query."<br>";
            $result = sql_query($query, 'orto', 0);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_array($result);
            $_SESSION['pat_name'] = $row[0] . " " . $row[1] . " " . $row[2];
            echo "<div class='head3'>Пациент: " . $_SESSION['pat_name'] . "</div>
					<hr width='100%' noshade='noshade' size='1'/>
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td><center><div class='head2'>Прейскуранты:</div><br />";
            $query = "select * from preysk WHERE id <4001";
            //echo $query."<br />";
            $result = sql_query($query, 'orto', 0);
            $count = mysqli_num_rows($result);
            for ($i = 0; $i < $count; $i++) {
                $row = mysqli_fetch_array($result);
                if ($row['id'] == $preysk) echo "|<font color='#42929D'>" . $row['preysk'] . "</font>|";
                else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $row['id'] . "'>" . $row['preysk'] . "</a>|";
            }
            $query = "SELECT `id`,`sotr`,`per_lech`, `summ`, `summ_month`, `vnes` FROM `orto_sh` WHERE `pat`=" . $_SESSION['pat'];
            //echo $query."<br>";
            $result = sql_query($query, 'orto', 0);
            $count = mysqli_num_rows($result);
            if ($count > 0) {
                $row = mysqli_fetch_array($result);
                if ($row['sotr'] == $_SESSION["UserID"]) {
                    if ('opl_orto' == $preysk) echo "|<font color='#42929D'>Оплата ортодонтии</font>|";
                    else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=opl_orto'>Оплата ортодонтии</a>|";
                    $sh_id = $row['id'];
                }
            }
            echo " </center></td>
			  </tr>
			  <tr>
				<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>";
            echo "<td width='40%' valign='top' align='center'>Оплата:";

            if ($_SESSION['countm'][1] > 0) {
                echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='6%'><div align='center' class='feature3'>№</div></td>
						<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='17%'><div align='center' class='feature3'>Количество</div></td>
						<td width='12%'><div align='center' class='feature3'>Цена</div></td>
						<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
                unset($_SESSION['summ'][1]);
                for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                    echo "  <tr>
						<td width='6%' align='center'>" . $i . "</td>
						<td width='62%' align='left'>" . $_SESSION['chek'][1][$i][3] . "<br />
						<a href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk . "&chek=" . $_SESSION['chek'][1][$i][1] . "&act=del' class='niz2'>Удалить из списка</a>
		</td>
						<td width='10%' align='center'>" . $_SESSION['chek'][1][$i][2] . "<br />
		<a href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk . "&id=" . $i . "&act=chQ&sstep=1' class=niz2>изменить</a> </td>
						<td width='12%' align='center'>" . $_SESSION['chek'][1][$i][4] . " руб.</td>
						<td width='10%' align='center'>" . ($_SESSION['chek'][1][$i][2] * $_SESSION['chek'][1][$i][4]) . " руб.</td>
					  </tr>";
                    $_SESSION['summ'][1] += $_SESSION['chek'][1][$i][2] * $_SESSION['chek'][1][$i][4];
                }
                echo "</table>";
                echo "<div align='right'>Итого: " . $_SESSION['summ'][1] . " руб. <br>";
                ////скидка


                if (!isset($_GET['skidka'])) {
                    if (!isset($_SESSION['proc_sk'])) {
                        $query = "SELECT  `klinikpat`.`Skidka`,`klinikpat`.`id`
		FROM  klinikpat
		WHERE (`klinikpat`.`id` ='" . $_SESSION['pat'] . "')";

                        ////echo $query."<br>"; <a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&manip=".$mat[$j]['id']."&act=add' class='small'>
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        if ($count > 0) {
                            $row = mysqli_fetch_array($result);
                            $ck = $row[0];

                        } else {
                            $ck = 0;
                        }
                        $_SESSION['proc_sk'] = $ck;
                    } else {
                        $ck = $_SESSION['proc_sk'];
                    }
                } else {
                    $ck = $_GET['skidka'];
                    $_SESSION['proc_sk'] = $ck;
                }
                //msg($ck);
                if (round(($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100), -1) == $_SESSION['summ'][1]) {
                    $summ_sk = (floor((($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100)) / 10)) * 10;
                } else {
                    $summ_sk = round(($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100), -1);
                }
                echo "Итого со скидкой (" . $ck . "%): " . $summ_sk . " руб.</div>";
                /////конец скидки
                if ($_SESSION['QZub'] > 1) {
                    $os = 0;
                    for ($i = 1; $i <= 1; $i++) {
                        $os = $os + ($_SESSION['summ'][$i]);
                    }
                    echo "<div align='right'>Общая сумма: " . round(($os - ($os * $ck) / 100), -1) . " руб.<br>";
                }
            } else echo "&nbsp";
            echo "<input name='act' type='hidden' value='add' />";
            echo "<input name='step' type='hidden' value='4' />";
            echo "<input name='action' type='hidden' value='oplata' />
				  </td>
			  </tr>
			</table>
			</td>
			  </tr>
			</table>";
            echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";


            if ('opl_orto' == $preysk) {

                $query = "SELECT `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `last_pay_month` FROM `orto_sh` WHERE `id`=" . $sh_id;

                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $payd_month = $row['vnes'] / $row['summ_month'];
                $dt = explode("-", $row['date']);
                $base_day = $dt[2];
                $base_mon = $dt[1];
                $base_yr = $dt[0];
                $current_day = date("j");
                $current_mon = date("n");
                $current_yr = date("Y");
                $base_mon_max = date("t", mktime(0, 0, 0, $base_mon, $base_day, $base_yr));
                $base_day_diff = $base_mon_max - $base_day;
                $base_mon_diff = 12 - $base_mon - 1;
                $start_day = 1;
                $start_mon = 1;
                $start_yr = $base_yr + 1;
                $day_diff = ($current_day - $start_day) + 1;
                $mon_diff = ($current_mon - $start_mon) + 1;
                $yr_diff = ($current_yr - $start_yr);
                $day_diff = $day_diff + $base_day_diff;
                $mon_diff = $mon_diff + $base_mon_diff;
                if ($day_diff >= $base_mon_max) {
                    $day_diff = $day_diff - $base_mon_max;
                    $mon_diff = $mon_diff + 1;
                }
                if ($mon_diff >= 12) {
                    $mon_diff = $mon_diff - 12;
                    $yr_diff = $yr_diff + 1;
                }
                if ($yr_diff == 1) $years = " год ";
                if (($yr_diff > 1) and ($yr_diff < 5)) $years = " года ";
                if ($yr_diff > 4) $years = " лет";

                if ($day_diff == 1) $days = " день ";
                if (($day_diff > 1) and ($day_diff < 5)) $days = " дня ";
                if ($day_diff > 4) $days = " дней ";

                if ($mon_diff == 1) $month = " месяц";
                if (($mon_diff > 1) and ($mon_diff < 5)) $month = " месяца ";
                if ($mon_diff > 4) $month = " месяцев ";
                if ($yr_diff >= 1) {
                    $srT = $yr_diff . $years . $mon_diff . $month . $day_diff . $days;
                    $dSR = ($yr_diff * 12) + $mon_diff;
                } else {

                    if ($mon_diff >= "1") {
                        $srT = $mon_diff . $month . $day_diff . $days;
                        $dSR = $mon_diff;
                    } else {
                        $srT = $day_diff . $days;
                        $dSR = 1;
                    }
                }
                $dolgM = $dSR - $payd_month;
                echo "<span class='head1'>Cрок лечения: " . $srT . "<br />";
                if ($dolgM > 0) {
                    echo "<a href='pr_opl_orto.php?type=vrach&step=5&id_shema=" . $sh_id . "&n=" . (date("n") + 1) . "&summ=" . ($row['summ_month'] * $dolgM) . "' class='small'>Оплатить долг за " . $dolgM . " месяцев (" . ($row['summ_month'] * $dolgM) . " р.)</a>";
                }
                echo "<br />
		<a href='pr_opl_orto.php?type=vrach&step=2&id_shema=" . $sh_id . "&n=" . ($row['last_pay_month'] + 1) . "&summ=" . $row['summ_month'] . "' class='small'>Принять оплату за месяц (" . $row['summ_month'] . " р.)</a>			  <br />";
                if ($row['vnes'] != 0) echo "<a href='pr_opl_orto.php?type=vrach&step=3&id_shema=" . $sh_id . "&n=13&summ=" . ($row['summ'] - $row['vnes']) . "' class='small'>Принять остаток (" . ($row['summ'] - $row['vnes']) . " р.)</a><br />";
                else
                    echo "<a href='pr_opl_orto.php?type=vrach&step=4&id_shema=" . $sh_id . "&n=13&summ=" . round(($row['summ'] - ($row['summ'] * 0.05)), -1) . "' class='small'>Принять всю сумму сразу (" . round(($row['summ'] - ($row['summ'] * 0.05)), -1) . " р.) Скидка 5%.</a></span>";
            } else {
                $query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=" . $preysk . " order by `range`, `manip`";
                //echo $query."<br />";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $cc = 0;
                $cm = 0;
                for ($i = 0; $i < $count; $i++) {
                    $row = mysqli_fetch_array($result);
                    if ($row['cat'] == 1) {
                        $cc++;
                        $cat[$cc]['id'] = $row['id'];
                        $cat[$cc]['manip'] = $row['manip'];

                    } else {
                        $cm++;
                        $mat[$cm]['id'] = $row['id'];
                        $mat[$cm]['manip'] = $row['manip'];
                        $mat[$cm]['price'] = $row['price'];
                        $mat[$cm]['UpId'] = $row['UpId'];
                    }
                }
                echo "<script language=\"JavaScript\" type=\"text/javascript\">
					<!--document.onclick = clickHandler;--> 
					</script>";
                for ($i = 1; $i <= $cc; $i++) {
                    echo "
					<SPAN id='Out" . $i . "' class='mmenuHand'>" . $cat[$i]['manip'] . "</SPAN><br />
			<div id=Out" . $i . "details style=\"display:None; position:relative; left:12;\">
				<table width='80%' border='0'>	
			";
                    unset($_SESSION['proc_sk']);
                    for ($j = 1; $j <= $cm; $j++) {

                        if ($cat[$i]['id'] == $mat[$j]['UpId'])
                            echo "<tr>
				<td width='85%'><a href='pat_tooday_work_orto.php?action=oplata&count=1&preysk=" . $preysk . "&manip=" . $mat[$j]['id'] . "&act=add' class='small'>" . $mat[$j]['manip'] . "</a></td>
				<td width='15%'>
				" . $mat[$j]['price'] . "
				</td>
			  </tr>";
                    }
                    echo "</table></div>";
                }
            }
            echo "</form>";
            //include("footer.php");
            //
        }
        break;

    /*оплата*/
    case "Sozd_ZN":
        $preysk = 4;
        switch ($_GET['act']) {
            case "add":
                if (!(isset($_SESSION['countm'][1]))) {
                    $query = "SELECT `manip`,`price` FROM `manip` WHERE `id`=" . $_GET['manip'];
                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);
                    $_SESSION['countm'][1] = 1;
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][1] = $_GET['manip'];
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][2] = 1;
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][3] = $row['manip'];
                    $_SESSION['chek'][1][$_SESSION['countm'][1]][4] = $row['price'];
                } else {
                    $f = 0;
                    for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                        if ($_GET['manip'] == $_SESSION['chek'][1][$i][1]) {
                            $f = 1;
                            $_SESSION['chek'][1][$i][2] = $_SESSION['chek'][1][$i][2] + 1;
                        }
                    }
                    if ($f == 0) {
                        $query = "SELECT `manip`,`price`,`zapis` FROM `manip` WHERE `id`=" . $_GET['manip'];
                        //echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        $_SESSION['countm'][1] = $_SESSION['countm'][1] + 1;
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][1] = $_GET['manip'];
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][2] = 1;
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][3] = $row['manip'];
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][4] = $row['price'];
                        $_SESSION['chek'][1][$_SESSION['countm'][1]][5] = $row[zapis];
                    }

                }
                ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk);
                break;
            case "del":
                if ($_SESSION['countm'][1] == 1) {
                    $_SESSION['countm'][1] = 0;
                } else
                    for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                        if ($_GET['chek'] == $_SESSION['chek'][1][$i][1]) {
                            for ($j = $i; $j < $_SESSION['countm']['1-1']; $j++) {

                                $_SESSION['chek'][1][$j][1] = $_SESSION['chek'][1][$j + 1][1];
                                $_SESSION['chek'][1][$j][2] = $_SESSION['chek'][1][$j + 1][2];
                                $_SESSION['chek'][1][$j][3] = $_SESSION['chek'][1][$j + 1][3];
                                $_SESSION['chek'][1][$j][4] = $_SESSION['chek'][1][$j + 1][4];
                                $_SESSION['chek'][1][$j][5] = $_SESSION['chek'][1][$j + 1][5];
                            }
                            $_SESSION['countm'][1] = $_SESSION['countm'][1] - 1;
                            $i = $j + 1;
                        }
                    }
                ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk);
                break;
            case "p1":
                for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                    if ($_GET['chek'] == $_SESSION['chek'][1][$i][1]) {
                        $_SESSION['chek'][1][$i][2] = $_SESSION['chek'][1][$i][2] + 1;
                    }
                }
                ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk);
                break;
            case "m1":
                for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                    if ($_GET['chek'] == $_SESSION['chek'][1][$i][1]) {
                        if ($_SESSION['chek'][1][$i][2] == 1) {
                            msg("Количество манипуляций не может быть меньше одного");
                        } else $_SESSION['chek'][1][$i][2] = $_SESSION['chek'][1][$i][2] - 1;
                    }
                }
                ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk);
                break;
            case "chQ":
                if ($_GET['sstep'] == 1) {
                    echo "<script language=\"JavaScript\" type=\"text/javascript\">
					function ChQ(id,qq)
					{
						q=prompt('Введите количество',qq);
						url='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $_GET['preysk'] . "&id='+id+'&act=chQ&sstep=2&q='+q;
						location.href=url;
					}";
                    echo "ChQ('" . $_GET['id'] . "','" . $_SESSION['chek'][1][$_GET['id']][2] . "')</script>";
                } else {
                    $_SESSION['chek'][1][$_GET['id']][2] = $_GET['q'];
                    ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1preysk=" . $_GET['preysk']);
                }
                break;
            case "next":
                if ($_SESSION['countm'][1] > 0) {
                    echo "<div class='head3'>Пациент: " . $_SESSION['pat_name'] . "</div><hr width='100%' noshade='noshade' size='1'/>";
//		echo "Жалобы: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$zh=$_SESSION['NZub'][$i]." ".$_SESSION['zh'][$i]."<br />";
//		}
//		echo $zh."<br />";
//		echo "Анамнез: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$an=$_SESSION['NZub'][$i]." ".$_SESSION['an'][$i]."<br />";
//		}
//		echo $an."<br />";
//		echo "Объективно: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$obk=$_SESSION['NZub'][$i]." ".$_SESSION['obk'][$i]."<br />";
//		}
//		echo $obk."<br />";
//		echo "Диагноз : ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//			$NZub=$_SESSION['NZub'][$i];
//			$dsZub=$_SESSION['dsZub'][$NZub];
//			$query = "Select Nazv from ds where id=".$dsZub;
//			//echo $query."<br />";
//			$result=sql_query($query,'orto',0);   $count=mysqli_num_rows($result);
//			$row = mysqli_fetch_array($result);
//			$ds=$ds.$NZub."-й зуб, ".$row['Nazv']."<br />";
//			echo $ds;
//		}
//		echo "<br />Лечение: ";
//		for ($i=1;$i<=$_SESSION['QZub'];$i++)
//		{
//		$lech=$_SESSION['NZub'][$i]." ".$_SESSION['lech'][$i]."<br />";
//		}
//		echo $lech."<br />";
                    //echo "Итого: ";
                    $opl = 0;
                    //$query = "SELECT `skidka`.`proc`, `skidka`.`id`, `klinikpat`.`id`
//FROM skidka, klinikpat
//WHERE ((`skidka`.`id` =`klinikpat`.`Skidka`) AND (`klinikpat`.`id` ='".$_SESSION['pat']."'))" ;
//		//echo $query."<br>";
//		//echo $opl." руб<br />";
//		$result=sql_query($query,'orto',0);   $count=mysqli_num_rows($result);
//		$row = mysqli_fetch_array($result);
//		for ($i=1;$i<=1;$i++)
//		{
//			$opl=$opl+$_SESSION['summ'][$i];
//
//			if ($count>0)
//			{
//				$ck=$row['proc'];
//			}
//			else
//			{
//				$ck=0;
//			}
//		}
                    for ($i = 1; $i <= 1; $i++) {
                        $opl = $opl + $_SESSION['summ'][$i];
                        if (round(($_SESSION['summ'][$i] - ($_SESSION['summ'][$i] * $_SESSION['proc_sk']) / 100), -1) == $_SESSION['summ'][$i]) {
                            $summ_sk = (floor((($_SESSION['summ'][$i] - ($_SESSION['summ'][$i] * $_SESSION['proc_sk']) / 100)) / 10)) * 10;
                        } else {
                            $summ_sk = round(($_SESSION['summ'][$i] - ($_SESSION['summ'][$i] * $_SESSION['proc_sk']) / 100), -1);
                        }
                    }
                    $query = "INSERT INTO `zaknar` (`id`, `vrach`, `pat` , `tech`, `date`, `dateSd`, `timeSd`, `summ`, `summ_k_opl`, `summ_vnes`,`skidka`)
		VALUES (NULL, 
		'" . $_SESSION["UserID"] . "',
		'" . $_SESSION['pat'] . "', 
		'" . $_GET['tech'] . "',
		'" . date('Y-m-d') . "',
		'" . $_GET['DateDY'] . "-" . $_GET['DateDM'] . "-" . $_GET['DateDD'] . "',
		'" . $_GET['TimeH'] . ":" . $_GET['TimeM'] . ":00',
		'" . $opl . "',
		'" . $summ_sk . "',
		0,
		" . $_SESSION['proc_sk'] . ")";
                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $pr = $result;
                    $c = 1;
                    $m[$c][1] = $_SESSION['chek'][1][1][1];
                    $m[$c][2] = 0;
                    $m[$c][3] = $_SESSION['chek'][1][1][3];
                    $m[$c][4] = $_SESSION['chek'][1][1][4];
                    for ($i = 1; $i <= 1; $i++) {
                        for ($j = 1; $j <= $_SESSION['countm'][$i]; $j++) {
                            $f = 0;
                            for ($q = 1; $q <= $c; $q++) {
                                if ($m[$q][1] == $_SESSION['chek'][$i][$j][1]) {

                                    $m[$q][2] += $_SESSION['chek'][$i][$j][2];
                                    $f = 1;
                                }
                            }
                            if ($f == 0) {
                                $c = $c + 1;
                                $m[$c][1] = $_SESSION['chek'][$i][$j][1];
                                $m[$c][2] = $_SESSION['chek'][$i][$j][2];
                                $m[$c][3] = $_SESSION['chek'][$i][$j][3];
                                $m[$c][4] = $_SESSION['chek'][$i][$j][4];
                            }
                        }
                    }

                    $query = "INSERT INTO `manip_zn` (`id`,`manip`, `kolvo`,`ZN`) values ";
                    for ($i = 1; $i <= 1; $i++) {
                        $NZub = 0;
                        for ($j = 1; $j <= $_SESSION['countm'][$i]; $j++) {
                            if ($j == 1) $query .= " (NULL,'" . $_SESSION['chek'][$i][$j][1] . "','" . $_SESSION['chek'][$i][$j][2] . "','" . $pr . "')";
                            else $query .= ", (NULL,'" . $_SESSION['chek'][$i][$j][1] . "','" . $_SESSION['chek'][$i][$j][2] . "','" . $pr . "')";
                        }
                    }
                    //echo "Вставка в Манипуляции при приёме<br>";
                    //echo $query."<br>";

                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    $query = "SELECT `id`, `surname`, `name`, `otch` FROM `sotr` WHERE `id`=" . $_GET['tech'];
                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    $row = mysqli_fetch_array($result);

                    echo "№ Заказ наряда" . $pr . "<br />
		Техник :" . $row['surname'] . " " . $row['name'] . " " . $row['otch'];
                    if ($_GET['DateDD'] == 0) echo "Дата сдачи:__/__/______";
                    else echo "Дата сдачи:" . $_GET['DateDD'] . "/" . $_GET['DateDM'] . "/" . $_GET['DateDY'];
                    if ($_GET['TimeH'] == 0) echo " __ч:__м";
                    else  echo " " . $_GET['TimeH'] . ":" . $_GET['TimeM'];
                    echo "<br /><table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
			  <tr>
				<td width='6%'><div align='center' class='feature3'>№</div></td>
				<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
				<td width='17%'><div align='center' class='feature3'>Количество</div></td>
				<td width='12%'><div align='center' class='feature3'>Цена</div></td>
				<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
			  </tr>";
                    unset($s);
                    for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                        echo "  <tr>
				<td width='6%' align='center'>" . $i . "</td>
				<td width='62%' align='left'>" . $m[$i][3] . "</td>
				<td width='10%' align='center'>" . $m[$i][2] . "</td>
				<td width='12%' align='center'>" . $m[$i][4] . " руб.</td>
				<td width='10%' align='center'>" . ($m[$i][2] * $m[$i][4]) . " руб.</td>
			  </tr>";
                        $s += $m[$i][2] * $m[$i][4];
                    }


                    echo "</table>";
                    echo "<div align='right'>Итого: " . $s . " руб. <br>";


                    //скидка

                    if (!isset($_GET['skidka'])) {
                        if (!isset($_SESSION['proc_sk'])) {
                            $query = "SELECT  `klinikpat`.`Skidka`,`klinikpat`.`id`
		FROM  klinikpat
		WHERE (`klinikpat`.`id` ='" . $_SESSION['pat'] . "')";

                            ////echo $query."<br>"; <a href='pat_tooday_work.php?action=lech&step=4&count=".$_GET['count']."&preysk=".$preysk."&manip=".$mat[$j]['id']."&act=add' class='small'>
                            $result = sql_query($query, 'orto', 0);
                            $count = mysqli_num_rows($result);
                            if ($count > 0) {
                                $row = mysqli_fetch_array($result);
                                $ck = $row[0];

                            } else {
                                $ck = 0;
                            }
                            $_SESSION['proc_sk'] = $ck;
                        } else {
                            $ck = $_SESSION['proc_sk'];
                        }
                    } else {
                        $ck = $_GET['skidka'];
                        $_SESSION['proc_sk'] = $ck;
                    }
                    //msg($ck);
                    if (round(($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100), -1) == $_SESSION['summ'][1]) {
                        $summ_sk = (floor((($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100)) / 10)) * 10;
                    } else {
                        $summ_sk = round(($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100), -1);
                    }
                    echo "Итого со скидкой (" . $ck . "%): " . $summ_sk . " руб.</div>";

                    //конец скидки


                    echo "<a href='pat_tooday_orto.php'class='mmenu'>Закрыть</a>";
                    unset($_SESSION['chek']);
                    unset($_SESSION['proc_sk']);
                    unset($_SESSION['proc_sk']);
                    unset($_SESSION['countm']);
                    unset($_SESSION['NZub']);
                    unset($_SESSION['dsZub']);
                    unset($_SESSION['QZub']);
                    unset($_SESSION['pat']);
                    unset($_SESSION['pat_name']);
                    unset($_SESSION['zh']);
                    unset($_SESSION['obk']);
                    unset($_SESSION['lech']);
                    unset($_SESSION['an']);
                    unset($_SESSION['OsmID']);
                    unset($_SESSION['summ']);
                    unset($_SESSION['proc_sk']);
                    //include("footer.php");
                    break;
                } else {
                    msg("Вы не выбрали не одной манипуляции" . $_SESSION['countm'][1]);
                    ret("pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk);
                }


                break;
        }
        if (!(isset($_GET['preysk']))) $preysk = 4;
        else $preysk = $_GET['preysk'];
        if (!(isset($_SESSION['pat']))) $_SESSION['pat'] = $_GET['pat'];
        //////////Заполнение лечения
        echo "<form action='pat_tooday_work_orto.php' method='get' id='lech' name='lech'>
			<input name='count' type='hidden' value='1' />";
        $query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=" . $_SESSION['pat'];
        //echo $query."<br>";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        $_SESSION['pat_name'] = $row[0] . " " . $row[1] . " " . $row[2];
        echo "<div class='head3'>Пациент: " . $_SESSION['pat_name'] . "</div>
					<hr width='100%' noshade='noshade' size='1'/>
					<table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>
				<td><!--<center><div class='head2'>Прейскуранты:</div><br />";
        $query = "select * from preysk  WHERE id<4001";
        echo $query . "<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            if ($row['id'] == $preysk) echo "|<font color='#42929D'>" . $row['preysk'] . "</font>|";
            else echo "|<a class=menu2 href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $row['id'] . "'>" . $row['preysk'] . "</a>|";
        }
        echo " </center>--></td>
			  </tr>
			  <tr>
				<td><table width='100%' border='0' cellspacing='0' cellpadding='1'>
			  <tr>";


        echo "<td width='40%' valign='top' align='center'>Заказ-наряд:<br />
				Техник:  ";
        $query = "SELECT `id`, `surname`, `name`, `otch` FROM `sotr` WHERE `dolzh`=8 ORDER BY `surname`";
        //echo $query."<br>";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        echo "<select name=\"tech\">";
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            if ($row['id'] == $_GET['tech']) echo "<option value=" . $row['id'] . " selected='selected'>" . $row['surname'] . " " . $row['name'] . " " . $row['otch'] . "</option>";
            echo "<option value=" . $row['id'] . ">" . $row['surname'] . " " . $row['name'] . " " . $row['otch'] . "</option>";
        }
        echo "</select> Срок сдачи <select name='DateDD'>";
        if (($_GET['DateDD'] == 0) or (!(isset($_GET['DateDD'])))) echo "<option value='0'  selected='selected'>&nbsp;</option>";
        else echo "<option value='0'>&nbsp;</option>";

        for ($i = 1; $i < 32; $i++) {
            $s = "";
            if ($i == $_GET['DateDD']) $s = " selected='selected'";
            if ($i < 10) echo "<option value='0" . $i . "' " . $s . ">" . $i . "</option>";
            else echo "<option value='" . $i . "' " . $s . ">" . $i . "</option>";
        }

        echo "</select>
  /
<select name='DateDM'' size='1'>";
        if (($_GET['DateDM'] == 0) or (!(isset($_GET['DateDM'])))) echo "<option value='0'  selected='selected'>&nbsp;</option>";
        else echo "<option value='0'>&nbsp;</option>";
        $s = "";
        for ($i = 1; $i < 13; $i++) {
            switch ($i) {
                case "1":
                    $s = "'>Январь</option>";
                    break;
                case "2":
                    $s = "'>Февраль</option>";
                    break;
                case "3":
                    $s = "'>Март</option>";
                    break;
                case "4":
                    $s = "'>Апрель</option>";
                    break;
                case "5":
                    $s = "'>Май</option>";
                    break;
                case "6":
                    $s = "'>Июнь</option>";
                    break;
                case "7":
                    $s = "'>Июль</option>";
                    break;
                case "8":
                    $s = "'>Август</option>";
                    break;
                case"9":
                    $s = "'>Сентябрь</option>";
                    break;
                case "10":
                    $s = "'>Октябрь</option>";
                    break;
                case "11":
                    $s = "'>Ноябрь</option>";
                    break;
                case "12":
                    $s = "'>Декабрь</option>";
                    break;
            }
            if ($i < 10) {
                if ($i == $_GET['DateDM']) echo "<option value='0" . $i . "' selected='selected" . $s . "</option>";
                else echo "<option value='0" . $i . $s . "</option>";
            } else {
                if ($i == $_GET['DateDM']) echo "<option value='" . $i . "' selected='selected" . $s . "</option>";
                else echo "<option value='" . $i . $s . "</option>";
            }
        }
        echo "      </select>";
        echo "/
      <select name='DateDY'>";
        if (($_GET['DateDY'] == 0) or (!(isset($_GET['DateDY'])))) echo "<option value='0'  selected='selected'>&nbsp;</option>";
        else echo "<option value='0'>&nbsp;</option>";
        $s = "";
        for ($i = 2007; $i < 2010; $i++) {
            if ($i == $_GET['DateDY']) echo "<option value='" . $i . "' selected='selected'>" . $i . "</option>";
            else echo "<option value='" . $i . "'>" . $i . "</option>";
        }
        echo "      </select> к  <select name='TimeH'>";
        if (($_GET['TimeH'] == 0) or (!(isset($_GET['TimeH'])))) echo "<option value='0'  selected='selected'>&nbsp;</option>";
        else echo "<option value='0'>&nbsp;</option>";
        $s = "";
        for ($i = 8; $i < 20; $i++) {
            if ($_GET['TimeH'] == $i) echo "<option value='" . $i . "' selected='selected'>" . $i . "</option>";
            echo "<option value='" . $i . "'>" . $i . "</option>";
        }
        echo "      </select>ч <select name='TimeM'>";
        if (($_GET['TimeM'] == 0) or (!(isset($_GET['TimeM'])))) echo "<option value='N'  selected='selected'>&nbsp;</option>";
        else echo "<option value='N'>&nbsp;</option>";
        $s = "";
        for ($i = 0; $i < 60; $i += 15) {
            if (0 == $i) echo "<option value='" . $i . "'>0" . $i . "</option>";
            else echo "<option value='" . $i . "'>" . $i . "</option>";
        }
        echo "      </select>м ";
        if ($_SESSION['countm'][1] > 0) {
            echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>
					  <tr>
						<td width='6%'><div align='center' class='feature3'>№</div></td>
						<td width='49%'><div align='center' class='feature3'>Наименование</div></td>
						<td width='17%'><div align='center' class='feature3'>Количество</div></td>
						<td width='12%'><div align='center' class='feature3'>Цена</div></td>
						<td width='16%'><div align='center' class='feature3'>Стоимость</div></td>
					  </tr>";
            unset($_SESSION['summ'][1]);
            for ($i = 1; $i <= $_SESSION['countm'][1]; $i++) {
                echo "  <tr>
						<td width='6%' align='center'>" . $i . "</td>
						<td width='62%' align='left'>" . $_SESSION['chek'][1][$i][3] . "<br />
						<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk . "&chek=" . $_SESSION['chek'][1][$i][1] . "&act=del' class='niz2'>Удалить из списка</a>
		</td>
						<td width='10%' align='center'>" . $_SESSION['chek'][1][$i][2] . "<br />
		<a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk . "&id=" . $i . "&act=chQ&sstep=1' class=niz2>изменить</a> </td>
						<td width='12%' align='center'>" . $_SESSION['chek'][1][$i][4] . " руб.</td>
						<td width='10%' align='center'>" . ($_SESSION['chek'][1][$i][2] * $_SESSION['chek'][1][$i][4]) . " руб.</td>
					  </tr>";
                $_SESSION['summ'][1] += $_SESSION['chek'][1][$i][2] * $_SESSION['chek'][1][$i][4];
            }
            echo "</table>";
            echo "<div align='right'>Итого: " . $_SESSION['summ'][1] . " руб. <br>";


            ////скидка

            if (!isset($_GET['skidka'])) {
                if (!isset($_SESSION['proc_sk'])) {
                    $query = "SELECT  `klinikpat`.`Skidka`,`klinikpat`.`id`
		FROM  klinikpat
		WHERE (`klinikpat`.`id` ='" . $_SESSION['pat'] . "')";

                    //echo $query."<br>";
                    $result = sql_query($query, 'orto', 0);
                    $count = mysqli_num_rows($result);
                    if ($count > 0) {
                        $row = mysqli_fetch_array($result);
                        $ck = $row[0];

                    } else {
                        $ck = 0;
                    }
                    $_SESSION['proc_sk'] = $ck;
                } else {
                    $ck = $_SESSION['proc_sk'];
                }
            } else {
                $ck = $_GET['skidka'];
                $_SESSION['proc_sk'] = $ck;
            }
            //msg($ck." ".$_SESSION['proc_sk']);
            if (round(($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100), -1) == $_SESSION['summ'][1]) {
                $summ_sk = (floor((($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100)) / 10)) * 10;
            } else {
                $summ_sk = round(($_SESSION['summ'][1] - ($_SESSION['summ'][1] * $ck) / 100), -1);
            }
            echo "Итого со скидкой (" . $ck . "%): " . $summ_sk . " руб.</div>";


            /////конец скидки


            if ($_SESSION['QZub'] > 1) {
                $os = 0;
                for ($i = 1; $i <= 1; $i++) {
                    $os = $os + ($_SESSION['summ'][$i]);
                }
                echo "<div align='right'>Общая сумма: " . round(($os - ($os * $ck) / 100), -1) . " руб.</div>";
            }
            //echo "<input name='' type='submit'  value='Удалить из списка' onclick='document.lech.act.value=\"del\"'/>
            //		  <input name='' type='submit'  value='Количество +1' onclick='document.lech.act.value=\"p1\"'/>
            //		  <input name='' type='submit'  value='Количество -1' onclick='document.lech.act.value=\"m1\"'/>";
        } else echo "&nbsp";
        echo "<input name='act' type='hidden' value='add' />";
        echo "<input name='step' type='hidden' value='4' />";
        echo "<input name='action' type='hidden' value='Sozd_ZN' />
				  </td>
			  </tr>
			</table>
			</td>
			  </tr>
			</table>";
        echo "<center><input name='' type='submit'  value='Дальше>>' onclick='document.lech.act.value=\"next\"'/></center>";


        //$query = "select `id`, `manip`, `price`, `cat`, `UpId`,`range` from manip WHERE preysk=".$preysk." order by `range`";
        $query = "select `id`, `manip`, `price`, `cat`, `UpId` from manip WHERE preysk=" . $preysk . " order by `range`, `manip`";
        //echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        $cc = 0;
        $cm = 0;
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            if ($row['cat'] == 1) {
                $cc++;
                $cat[$cc]['id'] = $row['id'];
                $cat[$cc]['manip'] = $row['manip'];

            } else {
                $cm++;
                $mat[$cm]['id'] = $row['id'];
                $mat[$cm]['manip'] = $row['manip'];
                $mat[$cm]['price'] = $row['price'];
                $mat[$cm]['UpId'] = $row['UpId'];
            }
        }
        echo "<script language=\"JavaScript\" type=\"text/javascript\">
					<!--document.onclick = clickHandler;--> 
					</script>";
        for ($i = 1; $i <= $cc; $i++) {
            echo "
					<SPAN id='Out" . $i . "' class='mmenuHand'>" . $cat[$i]['manip'] . "</SPAN><br />
			<div id=Out" . $i . "details style=\"display:None; position:relative; left:12;\">
				<table width='80%' border='0'>
			";

            for ($j = 1; $j <= $cm; $j++) {

                if ($cat[$i]['id'] == $mat[$j]['UpId'])
                    echo "<tr>
				<td width='85%'><a href='pat_tooday_work_orto.php?action=Sozd_ZN&count=1&preysk=" . $preysk . "&manip=" . $mat[$j]['id'] . "&act=add' class='small'>" . $mat[$j]['manip'] . "</a></td>
				<td width='15%'>
				" . $mat[$j]['price'] . "
				</td>
			  </tr>";
            }
            echo "</table></div>";
        }

        echo "</form>";
        //include("footer.php");
        break;
        break;

    case "Sozd_SH":
        if (isset($_GET['type'])) {
            $_SESSION['type'] = $_GET['type'];
            $_SESSION['step'] = $_GET['step'];
        }
        if (isset($_GET['step'])) {
            $_SESSION['step'] = $_GET['step'];
        }
        switch ($_SESSION['type']) {
            /////Миобрейс
            case "myo":
                switch ($_SESSION['step']) {
                    case "1":
                        //include("footer2.php");
                        break;
                        break;
                    case "2":
                        //include("footer2.php");
                        break;
                        break;
                }
                break;
            /////трейнер
            case "tr":
                switch ($_SESSION['step']) {
                    case "1":
                        //include("footer2.php");
                        break;
                        break;
                    case "2":
                        //include("footer2.php");
                        break;
                        break;
                }
                break;
            /////Брекеты
            case "br":
                switch ($_SESSION['step']) {
                    case "1":
                        $_SESSION['step'] = 2;
                        echo "<form action='' method='get' name='shForm' id='shForm'>";
                        echo "<div class='head3'>Пациент: " . $_SESSION['pat_name'] . "</div>
			            <div class='head3'>Сотавление схемы оплаты за лечение на брекетах</div>";
                        echo "Стоимость аппаратуры: <input name='StApp' type='text' onKeyUp='rassch()'/><br />
							  Срок лечения: <select name='Srok' id='Srok' onChange='rassch()'>";

                        for ($i = 1; $i <= 36; $i++) {
                            if ($i == 1) echo "<option value='" . $i . "' selected='selected'>" . $i . " мес</option>";
                            else echo "<option value='" . $i . "'>" . $i . " мес</option>";
                        }
                        echo "</select>";
                        echo "<script language='JavaScript' type='text/javascript'>
						function rassch()
						{
							z=Math.floor(
							(
							document.shForm.StApp.value/parseInt
							(
							document.shForm.Srok.options[document.shForm.Srok.selectedIndex].value
							)
							)/100
							)*100;
							document.shForm.PerMonth.value=z;
						}
						</script><br />

						Оплата в месяц: <input name='PerMonth' id='PerMonth' type='text' />";
                        echo "<br />
						<input name='action' type='hidden' value='Sozd_SH' />
						<input name='' Value='Сохранить' type='Submit'/>";
                        echo "</form>";
                        //include("footer2.php");
                        break;
                        break;
                    case "2":
                        $query = "INSERT INTO `orto_sh` (`id`, `pat`, `sotr`, `date`, `per_lech`, `summ`, `summ_month`, `vnes`, `full`)
												VALUES (NULL, " . $_SESSION['pat'] . ", " . $_SESSION['UserID'] . ",'" . date('Y-m-d') . "', " . $_GET['Srok'] . ", " . $_GET['StApp'] . ", " . $_GET['PerMonth'] . ", 0, 0)";
                        //echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        ret("pat_tooday_orto.php");
                        unset($_SESSION['pat']);
                        unset($_SESSION['pat_name']);
                        unset($_SESSION['step']);
                        unset($_SESSION['type']);
                        //include("footer2.php");
                        break;
                        break;
                }
                break;
        }
        if (!isset($_GET['type'])) {
            if (!(isset($_SESSION['pat']))) $_SESSION['pat'] = $_GET['pat'];
            $query = "SELECT `surname`, `name`, `otch` FROM `klinikpat` WHERE `id`=" . $_SESSION['pat'];
            //echo $query."<br>";
            $result = sql_query($query, 'orto', 0);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_array($result);
            $_SESSION['pat_name'] = $row[0] . " " . $row[1] . " " . $row[2];
            echo "		<div class='head3'>Пациент: " . $_SESSION['pat_name'] . "</div>
			<div class='head3'>Выбор аппараптуры: </div>";
            echo "<!--<a href='pat_tooday_work_orto.php?action=Sozd_SH&type=myo&step=1' class='menu2'>Миобрейс</a><br />
";
            echo "<a href='pat_tooday_work_orto.php?action=Sozd_SH&type=tr&step=1' class='menu2'>Трейнер</a><br />-->
";
            echo "<a href='pat_tooday_work_orto.php?action=Sozd_SH&type=br&step=1' class='menu2'>Брекеты</a><br />
";
            //include("footer2.php");
        }
        break;

}


/*комменты*/
?>
