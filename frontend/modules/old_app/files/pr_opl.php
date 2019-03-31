<?php

include('mysql_fuction.php');
$ThisVU = "registrator";
$this->title = "Приём платежей";
//include("header.php");
$query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='" . date('Y-m-d') . "') and (`timeO`='00:00:00')";
//echo $query."<br />";
$result = sql_query($query, 'orto', 0);
$count = mysqli_num_rows($result);
if (!($count > 0)) {
    msg("Необходимо открыть кассовую смену");
    ret("kassa.php?action=nach&step=1");
} else {
    $row = mysqli_fetch_array($result);
    $_SESSION['kassa'] = $row['id'];
}
switch ($_GET['action']) {
    case "set_sk":
        switch ($_GET['step']) {
            case "1":
                $query = "SELECT `disc_cards_types`.`proc`
FROM disc_cards_types, disc_cards
WHERE ((`disc_cards_types`.`id` =`disc_cards`.`type`) AND (`disc_cards`.`num` =" . $_GET['num'] . "))";
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $_SESSION['proc'] = $row['proc'];
                $query = "SELECT `Skidka` FROM `klinikpat` WHERE `id`=" . $_GET['Pid'];
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $query = "SELECT `proc` FROM `skidka` WHERE `id`=" . $row[0];
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $proc = $row[0];
                if ($proc > $_SESSION['proc'])
                    $_SESSION['proc'] = $proc;
                $query = "SELECT `skidka`,`summ` FROM `dnev` WHERE `id`=" . $_GET['dnev'];
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                if ($row['proc'] >= $_SESSION['proc']) {
                    msg("Скидка по дискнтной карте меньше скидки в чеке");
                    ret('pr_opl.php?' . $_GET['str']);
                    //exit;
                }

                if (round(($row['summ'] - ($row['summ'] * $_SESSION['proc']) / 100), -1) == $row['summ']) {
                    $summ_sk = (floor((($row['summ'] - ($row['summ'] * $_SESSION['proc']) / 100)) / 10)) * 10;
                } else {
                    $summ_sk = round(($row['summ'] - ($row['summ'] * $_SESSION['proc']) / 100), -1);
                }
                $query = "UPDATE " . $_GET['table1'] . "
SET
`summ_k_opl`=" . $summ_sk . ",
`skidka`=" . $_SESSION['proc'] . "
 WHERE `id`=" . $_GET['dnev'];
//echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $row = mysqli_fetch_array($result);
                ret('pr_opl.php?' . $_GET['str']);
                //exit;				
                break;
            case "2":
                break;
        }

        break;
    case "pr":
        switch ($_GET['step']) {
            case "1":
                $_SESSION['table'] = $_GET['table1'];
                $_SESSION['type'] = $_GET['type'];
                $query = "SELECT `summ_k_opl`, `summ_vnes`, `skidka` FROM `" . $_SESSION['table'] . "` WHERE `id`=" . $_GET['dnev'];
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                $_SESSION['kop'] = $row['summ_k_opl'];
                $_SESSION['skidka'] = $row['skidka'];
                $_SESSION['dolg'] = $row['summ_k_opl'] - $row['summ_vnes'];
                $_SESSION['svn'] = $row['summ_vnes'];
                $_SESSION['id'] = $_GET['dnev'];
                echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
					<span class='head3'>Приём оплаты:</span><br />
					<input name='step' type='hidden' value='2'>	
					<input name='action' type='hidden' value='pr'>			
					К оплате: " . $_SESSION['kop'] . "<br />
					Оплачено: " . $row['summ_vnes'] . "<br />
					Сумма долга: " . $_SESSION['dolg'] . "<br />
					Скидка: " . $_SESSION['skidka'] . "%<br />";
                $query = "SELECT * FROM `dogovor` WHERE (`pat`='" . $_GET['Pid'] . "')";
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                if ($count > 0) {
                    $row = mysqli_fetch_array($result);
                    $firm = $row['firm'];
                }

                $query = "SELECT `id`,`avans` FROM `avans` WHERE `pat`='" . $_GET['Pid'] . "'";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                if ($count > 0) {
                    $row = mysqli_fetch_array($result);
                    $av = $row['avans'];
                }

                $query = "SELECT * FROM `opl_vid`";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                echo "<script type=\"text/javascript\">
                                                                    function show_gift_num_input() {
                                                                    if ($('#v_opl').val()==\"4004\") 
                                                                        {
                                                                            $('#gift_num').attr(\"type\",\"text\");
                                                                        }
                                                                        else
                                                                        {
                                                                            $('#gift_num').attr(\"type\",\"hidden\");
                                                                        }
                                                                                           
                                                                    }
                                                                    </script>";
                echo "Вид оплаты: <select name='v_opl' id='v_opl' onchange='show_gift_num_input()'>";
                for ($i = 0; $i < $count; $i++) {
                    $row = mysqli_fetch_array($result);
                    if ($row[0] == 3) {
                        if (isset($av)) {
                            echo "<option value=" . $row[0] . " selected='selected'>" . $row[1] . "</option>";
                        }
                    } else {
                        if ($row[0] == 2) {
                            if (isset($firm))
                                echo "<option value=" . $row[0] . " selected='selected'>" . $row[1] . "</option>";
                        } else
                            echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                    }
                }
                echo "</select> <input name='gift_num' id='gift_num' type='hidden' value=''><br />
";
                echo "Оплата на: ";
                $query = "SELECT `id`, `nazv` FROM `podr` ORDER BY `id`";
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                echo "<select name='podr'>";
                for ($i = 0; $i < $count; $i++) {
                    $row = mysqli_fetch_array($result);
                    echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                }
                echo "</select><br />
";
                if (isset($av))
                    echo "<input name='av' type='hidden' value=" . $av . ">";
                if (isset($firm))
                    echo "<input name='firm' type='hidden' value='" . $firm . "'>";
                echo "<input name='ok' type='submit'  value='Дальше>>>'/>
				</form>";
                $query = "SELECT `num`,`type` FROM `disc_cards` WHERE `pat`=" . $_GET['Pid'];
                //echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                $count = mysqli_num_rows($result);
                $row = mysqli_fetch_array($result);
                if ($count > 0) {
                    $num = $row[0];
                    $type = $row[1];
                } else {
                    $num = '';
                    $type = $row[0];
                }

                echo "<form action=\"pr_opl.php\" method=\"get\">";
                echo "<input name='str' type='hidden' value='dnev=" . $_GET['dnev'] . "&action=pr&step=1&Pid=" . $_GET['Pid'] . "&table1=" . $_GET['table1'] . "&type=" . $_GET['type'] . "'>";
                echo "<input name='action' type='hidden' value='set_sk'>";
                echo "<input name='step' type='hidden' value='1'>";
                echo "<input name='table1' type='hidden' value='" . $_GET['table1'] . " '>";
                echo "<input  type='hidden' name='dnev' value='" . $_GET['dnev'] . "'>";
                echo "<input  type='hidden' name='Pid' value='" . $_GET['Pid'] . "'>";
                echo "Скидка по карте № <input type='text' name='num' value='" . $num . "'/>";
                echo "<input name='OK' type='submit'  value='внести'/>";
                echo "</form>";
                if ($type == 3) {
                    echo "<form action=\"pr_opl.php\" method=\"get\">";
                    //echo "<input name='str' type='hidden' value='dnev=".$_GET['dnev']."&action=pr&step=1&Pid=".$_GET['Pid']."&table1=".$_GET['table1']."&type=$_GET['type']'>";
                    //echo "<input name='action' type='hidden' value='set_sk'>";
                    echo "<input name='step' type='hidden' value='3'>";
                    echo "<input name='action' type='hidden' value='pr'>";
                    echo "<input name='summ' type='hidden' value='" . $_SESSION['dolg'] . "'>";
                    //echo "<input name='table1' type='hidden' value='".$_GET['table1']." '>";
                    //	echo "<input  type='hidden' name='dnev' value='".$_GET['dnev']."'>";
                    //	echo "<input  type='hidden' name='Pid' value='".$_GET['Pid']."'>";
                    echo "<input  type='hidden' name='v_opl' value='4'>";
                    echo "<input name='OK' type='submit'  value='Бесплатная гигиена'/>";
                    echo "</form>";
                    //include("footer.php");
                    echo "</form>";
                }

                //exit;
                break;
            case "2":
                $_SESSION['podr'] = $_GET['podr'];
                switch ($_GET['v_opl']) {
                    case "1":
                        echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='" . $_GET['v_opl'] . "'>
							К оплате: " . $_SESSION['kop'] . "<br />
							Сумма долга: " . $_SESSION['dolg'] . "<br />
							Сумма к оплате:<input type='text' name='summ' value='" . $_SESSION['dolg'] . "'/>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>	";
                        //include("footer.php");
                        //exit;
                        break;
                    case "2":
                        echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='" . $_GET['v_opl'] . "'>
							 Договор<br />";
                        //echo "<select name='Fid' size='5'>";
                        $query = "SELECT `id`,`nazv` FROM `firms` WHERE id=" . $_GET['firm'];
                        $row = mysqli_fetch_array($result);
                        //echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
//						for ($i=0;$i<$count;$i++)
//						{
//							
//							echo "<option value=".$row['id'].">".$row['nazv']."</option>";
//							
//						}
                        //echo "</select>";
                        echo "<input name='Fid' type='hidden' value='" . $_GET['firm'] . "' />";
                        echo "<br />
							Фирма: " . $row['nazv'] . "<br />
							К оплате: " . $_SESSION['kop'] . "<br />
							Сумма долга: " . $_SESSION['dolg'] . "<br />
							Сумма к оплате:<input type='text' name='summ' value='" . $_SESSION['dolg'] . "'/>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>";
                        //include("footer.php");
                        //exit;
                        break;
                    case "3":
                        echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='av' type='hidden' value='" . $_GET['av'] . "'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='" . $_GET['v_opl'] . "'>
							Размер аванса: " . $_GET['av'] . "
							 <br />
							К оплате: " . $_SESSION['kop'] . "<br />
							Сумма долга: " . $_SESSION['dolg'] . "<br />";
                        if ($_SESSION['dolg'] < $_GET['av'])
                            echo " Сумма к оплате:<input type='text' name='summ' value='" . $_SESSION['dolg'] . "'/>		руб.<br />";
                        else
                            echo " Сумма к оплате:<input type='text' name='summ' value='" . $_GET['av'] . "'/>		руб.<br />";
                        echo "<input name='ok' type='submit'  value='Дальше>>>'>
							</form>";
                        //include("footer.php");
                        //exit;
                        break;
                    case "5":
                        echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
							<input name='step' type='hidden' value='3'>	
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='" . $_GET['v_opl'] . "'>
							К оплате: " . $_SESSION['kop'] . "<br />
							Сумма долга: " . $_SESSION['dolg'] . "<br />
							Сумма к оплате:<input type='text' name='summ' value='" . $_SESSION['dolg'] . "'/>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>	";
                        //include("footer.php");
                        //exit;
                        break;
                    case "4004":

                        $query = "SELECT `balance`,`id` FROM `certif` WHERE `number`=" . $_GET['gift_num'];
                        $row = mysqli_fetch_array($result);
                        //echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        if (!($count > 0)) {
                            msg("Карта не найдена");
                            echo "<script type=\"text/javascript\">
                                                                                                                            history.back();
                                                                                                                    </script>";
                        }
                        if ($row['balance'] < $_SESSION['dolg']) {
                            $max_summ = $row['balance'];
                        } else {
                            $max_summ = $_SESSION['dolg'];
                        }
                        echo "<script type=\"text/javascript\">
                                                                                                        function chek() {
                                                                                                        if ($('#summ').val()>" . $max_summ . ") 
                                                                                                            {
                                                                                                                alert('Сумма не может быть больше " . $max_summ . "');
                                                                                                                $('#summ').val(" . $max_summ . ");
                                                                                                            }
                                                                                                      

                                                                                                        }
                                                                                                        </script>";
                        echo "<form id='dolgf' name='dolgf' method='get' action='pr_opl.php'>
                                                    
							<input name='step' type='hidden' value='3'>
                                                                                                                          <input name='gift_balance' type='hidden' value='" . $row['balance'] . "'>
                                                                                                                          <input name='gift_id' type='hidden' value='" . $row['id'] . "'>
							<input name='action' type='hidden' value='pr'>
							<input name='v_opl' type='hidden' value='" . $_GET['v_opl'] . "'>
							К оплате: " . $_SESSION['kop'] . "<br />
							Сумма долга: " . $_SESSION['dolg'] . "<br />
                                                                                                                         Номер карты " . $_GET['gift_num'] . " баланс " . $row['balance'] . "</br>
							Сумма к оплате:<input type='text' id='summ' name='summ'  value='" . $max_summ . "'/ onkeyup='chek()'>		руб.<br />
							<input name='ok' type='submit'  value='Дальше>>>'>
							</form>	";
                        //include("footer.php");
                        //exit;
                        break;
                }
                break;
            case "3":
                switch ($_GET['v_opl']) {
                    case "1":
                        if ($_GET['summ'] > $_SESSION['dolg']) {
                            msg('Максимальный размер оплаты' . $_SESSION['dolg']);
                            ret('pr_opl.php?action=pr&step=2&v_opl=1');
                        }
                        break;
                    case "2":
                        if ($_GET['summ'] > $_SESSION['dolg']) {
                            msg('Максимальный размер оплаты' . $_SESSION['dolg']);
                            ret('pr_opl.php?action=pr&step=2&v_opl=2&firm=' . $_GET['Fid']);
                        }
                        $query = "INSERT INTO `opl_firm` (`id`, `firm`, `opl`) VALUES (NULL,'" . $_GET['Fid'] . "', '" . $_GET['summ'] . "')";
                        //echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $row = mysqli_fetch_array($result);
                        break;
                    case "3":
                        if ($_GET['summ'] > $_SESSION['dolg']) {
                            msg('Максимальный размер оплаты' . $_SESSION['dolg']);
                            ret('pr_opl.php?action=pr&step=2&v_opl=3&av=' . $_GET['av']);
                        }
                        if ($_GET['summ'] > $_GET['av']) {
                            msg('Максимальный размер оплаты через аванс' . $_GET['av']);
                            ret('pr_opl.php?action=pr&step=2&v_opl=3&av=' . $_GET['av']);
                        }
                        $query = "SELECT `avans`.`id`, `avans`.`avans`
FROM avans,`" . $_SESSION['table'] . "`
WHERE ((`avans`.`pat` =`" . $_SESSION['table'] . "` .`pat`) AND (`" . $_SESSION['table'] . "` .`id` ='" . $_SESSION['id'] . "'))";
                        ////echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $count = mysqli_num_rows($result);
                        $row = mysqli_fetch_array($result);
                        if ($row['avans'] == $_GET['summ'])
                            $query = "DELETE  FROM `avans` WHERE `id` =" . $row['id'];
                        else
                            $query = "UPDATE `avans` 
									SET `avans`=" . ($row['avans'] - $_GET['summ']) . "
									WHERE `id`=" . $row['id'];
                        ////echo $query."<br>";
                        $result = sql_query($query, 'orto', 0);
                        $row = mysqli_fetch_array($result);
                        break;
                    case "4":

                        break;
                    case "5":
                        if ($_GET['summ'] > $_SESSION['dolg']) {
                            msg('Максимальный размер оплаты' . $_SESSION['dolg']);
                            ret('pr_opl.php?action=pr&step=2&v_opl=1');
                        }
                        break;
                    case "4004":
                        if ($_GET['gift_balance'] == $_GET['summ']) {
                            $query = "DELETE FROM `certif` WHERE `id`=" . $_GET['gift_id'];
                            echo "<strong>Баланс падарочной карты нулевой.</strong>";
                        } else {
                            $balance = $_GET['gift_balance'] - $_GET['summ'];
                            $query = "UPDATE `certif` SET `balance`=" . $balance . " WHERE `id`=" . $_GET['gift_id'];
                            echo "<strong>Баланс падарочной карты " . $balance . " рублей.</br></strong>";
                        }
                        break;
                }
                $result = sql_query($query, 'orto', 1);
                $query = "UPDATE `" . $_SESSION['table'] . "` 
                                                                    SET `summ_vnes`=" . ($_SESSION['svn'] + $_GET['summ']) . "
                                                                    WHERE `id`=" . $_SESSION['id'];
                ////echo $query."<br>";
                $result = sql_query($query, 'orto', 0);
                if (!(isset($_SESSION['podr'])))
                    $_SESSION['podr'] = 1;
                $query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
						VALUES (NULL, '" . date('Y-m-d') . "','" . date('H:i') . ":00','" . $_SESSION['id'] . "','" . $_GET['summ'] . "', '" . $_GET['v_opl'] . "','" . $_SESSION['podr'] . "','" . $_SESSION['type'] . "') ";
                ////echo $query."<br>";
                $result = sql_query($query, 'orto', 0);

                if ($_GET['v_opl'] == 1) {
                    $query = "UPDATE `kassa` 
					SET `summ`=`summ`+" . $_GET['summ'] . "
					WHERE `id`=" . $_SESSION['kassa'];
                    ////echo $query."<br />";
                    $result = sql_query($query, 'orto', 0);
                }
                echo "<a class='mmenu' target='_blanc' href=\"print.php?type=chek&dnev=" . $_SESSION['id'] . "&table=" . $_SESSION['table'] . "&podr=" . $_SESSION['podr'] . "\">Печать чека</a><br />";
                echo "<a class='mmenu' href=\"pr_opl.php\">Дальше</a>";
                unset($_SESSION['podr']);
                unset($_SESSION['dolg']);
                unset($_SESSION['kassa']);
                unset($_SESSION['id']);
                unset($_SESSION['svn']);
                unset($_SESSION['kop']);

                //EXIT;

                //ret("pr_opl.php");
                break;
        }
        break;
}
if (!isset($_GET['action'])) {
    echo "<form id='lechf' name='lechf' method='post' action=''>
            <span class='head3'>Список должников на сегодня:</span><br />
			<span class='head3'>Терапеия</span>
            <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
              <tr>
                <td width='44%' class='mmenu'>Пациент</td>
                <td width='44%' class='mmenu'>Врач</td>
                <td width='12%' class='mmenu'>Сумма<br />
                  долга</td>
                </tr>";
    $query = "SELECT 
`dnev`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`dnev`.`summ_k_opl`,`dnev`.`summ_vnes`,`klinikpat`.`id`
FROM dnev, klinikpat, sotr
WHERE ((`dnev`.`date` ='" . date('Y-m-d') . "') AND (`klinikpat`.`id` =`dnev`.`pat`) AND (`sotr`.`id` =`dnev`.`vrach`) AND (`dnev`.`summ_k_opl` !=`dnev`.`summ_vnes`))"
    ;
////echo $query."<br>";
    $result = sql_query($query, 'orto', 0);
    $count = mysqli_num_rows($result);
    $countA = $count;
    $resultA = $result;
    for ($j = 0; $j < $countA; $j++) {
        $rowA = mysqli_fetch_array($resultA);
        echo "<tr><td width='44%' bgcolor='#cccccc'><a href='pr_opl.php?dnev=" . $rowA[0] . "&action=pr&step=1&Pid=" . $rowA[9] . "&table1=dnev&type=1' class='menu2' title='Принять долг'>" . $rowA[1] . " " . $rowA[2] . " " . $rowA[3] . "</a></td>
                <td width='44%'>" . $rowA[4] . " " . $rowA[5] . " " . $rowA[6] . "</td>
                <td width='12%' >" . ($rowA[7] - $rowA[8]) . " руб.</td>
                </tr>";
        $query = "SELECT 
`dnev`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`dnev`.`summ_k_opl`,
`dnev`.`summ_vnes`,
`dnev`.`pat`,
`dnev`.`date`
FROM dnev, klinikpat, sotr
WHERE ((`dnev`.`date` !='" . date('Y-m-d') . "') 
AND (`dnev`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`dnev`.`pat`) 
AND (`sotr`.`id` =`dnev`.`vrach`) 
AND (`dnev`.`summ_k_opl` !=`dnev`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=dnev&type=1' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
        $query = "SELECT 
`zaknar`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`zaknar`.`summ_k_opl`,
`zaknar`.`summ_vnes`,
`zaknar`.`pat`,
`zaknar`.`date`
FROM zaknar, klinikpat, sotr
WHERE ((`zaknar`.`date` !='" . date('Y-m-d') . "') 
AND (`zaknar`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`zaknar`.`pat`) 
AND (`sotr`.`id` =`zaknar`.`vrach`) 
AND (`zaknar`.`summ_k_opl` !=`zaknar`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=zaknar&type=2' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
        $query = "SELECT 
`schet_orto`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`schet_orto`.`summ_k_opl`,
`schet_orto`.`summ_vnes`,
`schet_orto`.`pat`,
`schet_orto`.`date`,
`schet_orto`.`sh_id`
FROM schet_orto, klinikpat, sotr
WHERE ((`schet_orto`.`date` !='" . date('Y-m-d') . "') 
AND (`schet_orto`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`schet_orto`.`pat`) 
AND (`sotr`.`id` =`schet_orto`.`vrach`) 
AND (`schet_orto`.`summ_k_opl` !=`schet_orto`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>";
            echo "<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=schet_orto&type=3' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
    }
    echo " </table>";


//////ортопедия
    echo "<span class='head3'>Ортопедия </span>
            <table width='100%' border='1' cellpadding='0' cellspacing='0' bordercolor='#333333' bgcolor='#FFFFFF'>
              <tr>
                <td width='44%' class='mmenu'>Пациент</td>
                <td width='44%' class='mmenu'>Врач</td>
                <td width='12%' class='mmenu'>Сумма<br />
                  долга</td>
                </tr>";
    $query = "SELECT 
`zaknar`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`zaknar`.`summ_k_opl`,`zaknar`.`summ_vnes`,`klinikpat`.`id`
FROM zaknar, klinikpat, sotr
WHERE ((`zaknar`.`date` ='" . date('Y-m-d') . "') AND (`klinikpat`.`id` =`zaknar`.`pat`) AND (`sotr`.`id` =`zaknar`.`vrach`) AND (`zaknar`.`summ_k_opl` !=`zaknar`.`summ_vnes`))
"
    ;
////echo $query."<br>";
    $result = sql_query($query, 'orto', 0);
    $count = mysqli_num_rows($result);
    $countA = $count;
    $resultA = $result;
    for ($j = 0; $j < $countA; $j++) {
        $rowA = mysqli_fetch_array($resultA);
        echo "<tr><td width='44%' bgcolor='#cccccc'><a href='pr_opl.php?dnev=" . $rowA[0] . "&action=pr&step=1&Pid=" . $rowA[9] . "&table1=zaknar&type=2' class='menu2' title='Принять долг'>" . $rowA[1] . " " . $rowA[2] . " " . $rowA[3] . "</a></td>
                <td width='44%'>" . $rowA[4] . " " . $rowA[5] . " " . $rowA[6] . "</td>
                <td width='12%' >" . ($rowA[7] - $rowA[8]) . " руб.</td>
                </tr>";

        $query = "SELECT 
`dnev`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`dnev`.`summ_k_opl`,
`dnev`.`summ_vnes`,
`dnev`.`pat`,
`dnev`.`date`
FROM dnev, klinikpat, sotr
WHERE ((`dnev`.`date` !='" . date('Y-m-d') . "') 
AND (`dnev`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`dnev`.`pat`) 
AND (`sotr`.`id` =`dnev`.`vrach`) 
AND (`dnev`.`summ_k_opl` !=`dnev`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=dnev&type=1' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
        $query = "SELECT 
`zaknar`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`zaknar`.`summ_k_opl`,
`zaknar`.`summ_vnes`,
`zaknar`.`pat`,
`zaknar`.`date`
FROM zaknar, klinikpat, sotr
WHERE ((`zaknar`.`date` !='" . date('Y-m-d') . "') 
AND (`zaknar`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`zaknar`.`pat`) 
AND (`sotr`.`id` =`zaknar`.`vrach`) 
AND (`zaknar`.`summ_k_opl` !=`zaknar`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=zaknar&type=2' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
        $query = "SELECT 
`schet_orto`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`schet_orto`.`summ_k_opl`,
`schet_orto`.`summ_vnes`,
`schet_orto`.`pat`,
`schet_orto`.`date`,
`schet_orto`.`sh_id`
FROM schet_orto, klinikpat, sotr
WHERE ((`schet_orto`.`date` !='" . date('Y-m-d') . "') 
AND (`schet_orto`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`schet_orto`.`pat`) 
AND (`sotr`.`id` =`schet_orto`.`vrach`) 
AND (`schet_orto`.`summ_k_opl` !=`schet_orto`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=schet_orto&type=3' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
    }
///////////////

    $query = "SELECT 
`schet_orto`.`id`, `klinikpat`.`surname`, `klinikpat`.`name`, `klinikpat`.`otch`, `sotr`.`surname`, `sotr`.`name`, `sotr`.`otch`,`schet_orto`.`summ_k_opl`,`schet_orto`.`summ_vnes`,`klinikpat`.`id`, `schet_orto`.`sh_id`
FROM schet_orto, klinikpat, sotr
WHERE ((`schet_orto`.`date` ='" . date('Y-m-d') . "') AND (`klinikpat`.`id` =`schet_orto`.`pat`) AND (`sotr`.`id` =`schet_orto`.`vrach`) AND (`schet_orto`.`summ_k_opl` !=`schet_orto`.`summ_vnes`))
"

    ;
////echo $query."<br>";
    $result = sql_query($query, 'orto', 0);
    $count = mysqli_num_rows($result);
    $countA = $count;
    $resultA = $result;
    for ($j = 0; $j < $countA; $j++) {
        $rowA = mysqli_fetch_array($resultA);
        if ($rowA['sh_id'] == 0) {
            echo "<tr><td width='44%' bgcolor='#cccccc'><a href='pr_opl.php?dnev=" . $rowA[0] . "&action=pr&step=1&Pid=" . $rowA[9] . "&table1=schet_orto&type=3' class='menu2' title='Принять долг'>" . $rowA[1] . " " . $rowA[2] . " " . $rowA[3] . "</a></td>
                <td width='44%'>" . $rowA[4] . " " . $rowA[5] . " " . $rowA[6] . "</td>
                <td width='12%' >" . ($rowA[7] - $rowA[8]) . " руб.</td>
                </tr>";
        }
        if ($rowA['sh_id'] > 0) {
            $query = "SELECT `id`,`step`, `n`, `summ`,`sh_id` FROM `schet_orto_schema` WHERE `id`=" . $rowA['sh_id'];
            ////echo $query."<br>";
            $result = sql_query($query, 'orto', 0);
            $count = mysqli_num_rows($result);
            $row = mysqli_fetch_array($result);
            echo "<tr><td width='44%' bgcolor='#cccccc'><a href='pr_opl_orto.php?action=prOpl&step=" . $row['step'] . "&id_shema=" . $row['sh_id'] . "&n=" . $row[n] . "&summ=" . $row['summ'] . "&so=" . $rowA[0] . "' class='menu2' title='Принять долг'>" . $rowA[1] . " " . $rowA[2] . " " . $rowA[3] . "</a></td>
                <td width='44%'>" . $rowA[4] . " " . $rowA[5] . " " . $rowA[6] . "</td>
                <td width='12%' >" . ($rowA[7] - $rowA[8]) . " руб.</td>
                </tr>";
        }
        $query = "SELECT 
`dnev`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`dnev`.`summ_k_opl`,
`dnev`.`summ_vnes`,
`dnev`.`pat`,
`dnev`.`date`
FROM dnev, klinikpat, sotr
WHERE ((`dnev`.`date` !='" . date('Y-m-d') . "') 
AND (`dnev`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`dnev`.`pat`) 
AND (`sotr`.`id` =`dnev`.`vrach`) 
AND (`dnev`.`summ_k_opl` !=`dnev`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=dnev&type=1' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
        $query = "SELECT 
`zaknar`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`zaknar`.`summ_k_opl`,
`zaknar`.`summ_vnes`,
`zaknar`.`pat`,
`zaknar`.`date`
FROM zaknar, klinikpat, sotr
WHERE ((`zaknar`.`date` !='" . date('Y-m-d') . "') 
AND (`zaknar`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`zaknar`.`pat`) 
AND (`sotr`.`id` =`zaknar`.`vrach`) 
AND (`zaknar`.`summ_k_opl` !=`zaknar`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=zaknar&type=2' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
        $query = "SELECT 
`schet_orto`.`id`, 
`klinikpat`.`surname`, 
`klinikpat`.`name`, 
`klinikpat`.`otch`, 
`sotr`.`surname`, 
`sotr`.`name`, 
`sotr`.`otch`,
`schet_orto`.`summ_k_opl`,
`schet_orto`.`summ_vnes`,
`schet_orto`.`pat`,
`schet_orto`.`date`
FROM schet_orto, klinikpat, sotr
WHERE ((`schet_orto`.`date` !='" . date('Y-m-d') . "') 
AND (`schet_orto`.`pat`='" . $rowA[9] . "') 
AND (`klinikpat`.`id`=`schet_orto`.`pat`) 
AND (`sotr`.`id` =`schet_orto`.`vrach`) 
AND (`schet_orto`.`summ_k_opl` !=`schet_orto`.`summ_vnes`))";
        ////echo $query."<br />";
        $result = sql_query($query, 'orto', 0);
        $count = mysqli_num_rows($result);
        for ($i = 0; $i < $count; $i++) {
            $row = mysqli_fetch_array($result);
            $dt = explode("-", $row[10]);
            echo "<tr><td width='44%'>
		<span class='bottom2'>Ещё долг от " . $dt[2] . "." . $dt[1] . "." . $dt[0] . "</span>
		<a href='pr_opl.php?dnev=" . $row[0] . "&action=pr&step=1&Pid=" . $row[9] . "&table1=schet_orto&type=3' class='menu2' title='Принять долг'>" . $row[1] . " " . $row[2] . " " . $row[3] . "</a></td>
					<td width='44%'>" . $row[4] . " " . $row[5] . " " . $row[6] . "</td>
					<td width='12%' >" . ($row[7] - $row[8]) . " руб.</td>
					</tr>";
        }
    }
    echo " </table>";
    echo "</form>";
    echo " <script language=\"JavaScript\" type=\"text/javascript\">
						setTimeout(\"javascript:location.href='pr_opl.php'\", 60000);
						</script>";
}
//include("footer.php");
?>