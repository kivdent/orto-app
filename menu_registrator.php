<?php
 echo "<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td align='center' valign='top' bgcolor='#42929D' class='mmenu2'><a href='".$_SESSION['valid_user'].".php' class='mmenu2'>Главная</a></td>
  </tr>
  <tr valign='top'>
    <td height='1' align='center' valign='top' class='mmenu2'><img src='image/transrerent.gif' width='1' height='1' /></td>
  </tr>
  <tr valign='top'>
            <td valign='top'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0' valign='top'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Расписание</td>
              </tr> 
			             <tr>
                <td><a href='pat_tooday_reg.php' class='menu2'>Пациенты на сегодня</a></td>
              </tr>        
			               <tr>
			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			               <tr>
                <td><a href='naznach_pat.php' class='menu2'>Назначение пациентов </a></td>
              </tr>
                               <tr>
			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			               <tr>
                <td><a href='sotr_time.php' class='menu2'>График работы персонала</a></td>
              </tr> 
			   <tr>
<!--			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			               <tr>
                <td><a href='raspis/naznach_pat.php' class='menu2'>Oбзвон</a></td>
              </tr>
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>-->
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Оплата</td>
              </tr> 
     
<!--              <tr>
                <td><a href='pr_opl.php' class='menu2'>Приём оплаты </a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>-->
			  <tr>
                <td><a href='pr_opl.php' class='menu2'>Приём оплаты</a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			              <tr>
                <td><a href='pr_dolg.php' class='menu2'>Долги</a></td>
              </tr>
			                <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			               <tr>
                <td><a href='pr_avans.php' class='menu2'>Приём аванса</a></td>
              </tr>
			  
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Скидки</td>
              </tr>         <tr>
                <td><a href='discount.php?act=view' class='menu2'>Выданные карты</a></td>
              </tr>
<tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>   
              <tr>
                <td><a href='discount.php?act=make' class='menu2'>Выдача карт</a></td>
              </tr>
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Касса</td>
              </tr> 
			  <tr>
                <td><a href='vid_deneg.php?step=1' class='menu2'>Выдача денег </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>        
              <tr>
                <td><a href='kassa.php?action=nach&step=1' class='menu2'>Начало смены </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
       <tr>
        <tr>
                <td><a href='kassa.php?action=okonch&step=1' class='menu2'>Окончание смены </a></td>
              </tr>
			  
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Пациенты</td>
              </tr>         <tr>
                <td><a href='PatWork.php?add=add' class='menu2'>Добавить нового </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='pat.php' class='menu2'>Работа с пациентами  </a></td>
              </tr>
                           <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='disp.php' class='menu2'>Диспансеризация</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='dr_pat.php' class='menu2'>День рождения пациентов</a></td>
              </tr>
<!--			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='pat_bad_card.php' class='menu2'>Незаполненные карты</a></td>
              </tr>-->
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Ортодонтия</td>
              </tr>        
			    <tr>
                <td><a href='pr_opl_orto.php' class='menu2'>Приём оплаты ортодонтия</a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			  <tr>
                <td><a href='pr_dolg_orto.php' class='menu2'>Должники</a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr> 
			  		
			   
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Продажа</td>
              </tr>        
			    <tr>
                <td><a href='pr_opl_hyg.php' class='menu2'>Продажа гигиены</a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='certif_gift.php?action=add&step=1' class='menu2'>Подарочные сертификаты</a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='certif_gift.php' class='menu2'>Выданные сертификаты</a></td>
              </tr>
			  
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			  		
			   
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Отчёты</td>
              </tr> 
			  <tr>
                <td><a href='reg_den_opl.php' class='menu2'>Финансовый отчёт за день </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>        
<!--              <tr>
                <td><a href='dir_den_opl_per.php' class='menu2'>Отчёт за период </a></td>
              </tr>
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='dir_dolzh.php' class='menu2'>Отчёт по долгам</a></td>
              </tr>-->
			  
</table>
            </td>
  </tr>
</table>";
?>