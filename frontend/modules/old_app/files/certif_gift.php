<?php

include('mysql_fuction.php');
$ThisVU="all";
$this->title="Подарочные сертификаты"; 
//include("header.php");
//Выданные сертификаты
//Выдать сетификат
switch ($_GET['action'])
{
	case "add":
                           switch ($_GET['step'])
                            {
                                case "1":
                                            //Выдача подарочных сертификатов шаг первый
                                            $query = "SELECT `id`, `summ` FROM `kassa` WHERE (`date`='".date('Y-m-d')."') and (`timeO`='00:00:00')";
                                            $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                            if (!($count>0))
                                            {
                                                    msg("Необходимо открыть кассовую смену");
                                                    ret("kassa.php?action=nach&step=1");
                                            }
                                            else
                                            {
                                                    $row = mysqli_fetch_array($result);
                                                    $_SESSION['kassa']=$row['id'];
                                            }
                                            echo "<script type=\"text/javascript\">
                                                    function go() {
                                                    var link='certif_gift.php?action=add&step=2'+$('#cert_type').val()+'&cert_num='+$('#cert_num').val()+'&opl_vid='+$('#opl_vid').val();
                                                    document.location.href=link;
                                                    }
                                                    </script>";
                                            echo "Вид сертификата:";
                                            echo "<select id='cert_type'>";     
                                            $query="SELECT `id`, `nazv`, `nominal`, `price`, `type`,`manip` FROM `certif_type` ";
                                            $result=sql_query($query,'orto',0);     $count=mysqli_num_rows($result);
                                            for ($i=0;$i<$count;$i++)
                                            {             
                                                    $row= mysqli_fetch_array($result);
                                                    echo "<option value='&cert_type=".$row['id']."&cert_balance=".$row['nominal']."&price=".$row['price']."&manip=".$row['manip']."'>".$row['nazv']."</option>";
                                            }
                                            echo  "</select></br>";
                                            $query = "SELECT * FROM `opl_vid` where (`id`=1 or `id`=5)";
                                            $result=sql_query($query,'orto',0);    $count=mysqli_num_rows($result);
                                            echo "Вид оплаты: <select id='opl_vid'>";
                                            for ($i=0;$i<$count;$i++)
                                            {
                                                    $row = mysqli_fetch_array($result);
                                                    echo "<option value=".$row['id'].">".$row['vid']."</option>";
                                            }
                                            echo "</select><br />";
                                            echo "Номер сертификата: <input id='cert_num' size='9'  type='text' autofocus></br>";
                                            echo "<input type='button' onclick=\"go()\" value='Выдать cертификат'>";
                                  break;
                                  case "2":
                                   //Выдача подарочных сертификатов шаг второй
                                      //Вставка в дневники
                                     $query=" INSERT INTO `dnev` (`id`, `vrach`, `pat`, `date`, `osm`, `ds`, `zh`, `an`, `obk`, `lech`, `resl`, `summ`, `summ_k_opl`, `summ_vnes`, `skidka`, `nzub`, `Nid`) 
                                                                        VALUES (NULL, '0', '1', '".date('Y-m-d')."', '0', '', '', '', '', '', '0', '".$_GET['cert_balance']."', '".$_GET['cert_balance']."', '".$_GET['cert_balance']."', '0', '0', '0')";
                                       $result=sql_query($query,'orto',0);
                                       $dnev=$result;
                                      //Вставка в манипуляции
                                       $query = "INSERT INTO `manip_pr` (`id`, `NZuba`, `manip`, `kolvo`, `dnev`) VALUES (NULL, '0', '".$_GET['manip']."', '1', '".$dnev."')";
                                      $result=sql_query($query,'orto',0);
                                      //Вставка в оплаты
                                      $query = "INSERT INTO `oplata` (`id`,`date`,`time`,`dnev`, `vnes`, `VidOpl`, `podr`,`type`) 
		  VALUES (NULL, '".date('Y-m-d')."','".date('H:i').":00','".$dnev."','".$_GET['cert_balance']."', '".$_GET['opl_vid']."','1','1') " ;
				
                                       $result=sql_query($query,'orto',0);
                                       //Обновление кассы
                                       if ($_GET['opl_vid']==1)
                                            {
                                                    $query = "UPDATE `kassa` 
                                                    SET `summ`=`summ`+".$_GET['cert_balance']."
                                                    WHERE `id`=".$_SESSION['kassa'];
                                                    $result=sql_query($query,'orto',0);   
                                            }
                                      //вставка в сертификаты
                                      echo "";
                                      $query="INSERT INTO `certif` (`id`, `type`, `number`, `balance`, `cliniс_gift`) "
                                          . "VALUES (NULL, '".$_GET['cert_type']."', '".$_GET['cert_num']."', '".$_GET['cert_balance']."', '0')";
                                     $result=sql_query($query,'orto',0);
                                     ret("pat_tooday_reg.php");
                                  break;
                        }
                 break;
                default:
                        //Выданные сертификаты
                    $query="SELECT `certif`.`id`,`certif`.`number`,`certif`.`balance`,`certif_type`.`nominal` FROM `certif`,`certif_type` WHERE `certif`.`type`=`certif_type`.`id`";
                    $result=sql_query($query,'orto',0);
                    echo "<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
              <tr><td> <span class='menutext'>№ сертификата</span></td>
                    <td  align='center' class='menutext'>Номинал</td>
                    <td> <span class='menutext'>Остаток</span></td>          
             </tr>";
                 $count=mysqli_num_rows($result);
                 for ($i=0;$i<$count;$i++)
                        {             
                                $row= mysqli_fetch_array($result);
                                echo "<tr class='alltext'><td>".$row['number']."</td>";
                                echo "<td>".$row['nominal']."</td>";
                                echo "<td>".$row['balance']."</td></tr>";
                      }
               echo "</table>";    
                break;
}
//include("footer.php");
?>
