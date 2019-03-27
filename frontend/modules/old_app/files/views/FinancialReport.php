<div class="head1">Отчётный период: 01.01.2019-31.01.2019</div>
<table width='100%' border='1' cellpadding='1' cellspacing='0' bordercolor='#999999'>
    <tr>
        <td class='menutext'>Пациент</td>
        <td class='menutext'>Дата чека</td>
        <td class='menutext'>Дата последней оплаты</td>
        <td class='menutext'>Баллы</td>
        <td class='menutext'>Сумма</td>
    </tr>
    <?php foreach ($finacialReport->reportTable as $key =>$value) :?>
    <tr class='alltext'>
        <td><a class='mmenu' target='_blanc' href="show.php?type=chek&dnev=<?php echo $value['invoice_id']; ?>&table=dnev&podr=1">
         <?php echo $value['patient_name']; ?></a>
        </td>
        <td> <?php echo $value['invoice_date']; ?></td>
        <td><?php echo  $value['last_payment_date']; ?></td>
        <td><?php echo $value['invoice_summ_coef']; ?></td>
        <td><?php echo $value['invoice_summ']; ?></td>
    </tr>
    <?php endforeach; ?>
   </table>
   <br /><span class='head2'>Сумма для расчёта зарплаты: <?php echo $finacialReport->summ; ?></span><br />
