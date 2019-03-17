<?php 
echo "<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td align='center' valign='top' bgcolor='#42929D' class='mmenu2'><a href='".$_SESSION['valid_user'].".php' class='mmenu2'>Главная</a></td>
  </tr>
  <tr>
    <td height='1' align='center' valign='top' class='mmenu2'><img src='image/transrerent.gif' width='1' height='1' /></td>
  </tr>
  <tr>
            <td valign='top'>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Расписание</td>
              </tr>
			  <tr>
                <td><a href='pat_tooday_gig.php' class='menu2'>Пациенты на сегодня</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>         
              <tr>
                <td><a href='raspis_doctor_show.php' class='menu2'>Ежедневник</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
               <tr>
	               <tr>
                <td><a href='naznach_pat.php' class='menu2'>Назначение пациентов </a></td>
              </tr>
			  			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			  
</table><table width='100%' border='0' cellspacing='0' cellpadding='0'>
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
</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Отчёты</td>
              </tr>
			  <tr>
                <td><a href='doc_den_ch.php' class='menu2'>Отчёт за день (чеки)</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>         
              <tr>
                <td><a href='doc_den_ch_per.php' class='menu2'>Отчёт за период (чеки)</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			   <tr>
                <td><a href='doc_den_opl.php' class='menu2'>Отчёт за день (оплаты)</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr> 
			  <tr>
                <td><a href='doc_den_opl_per.php' class='menu2'>Отчёт за период (оплаты)</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>             
               <tr>
	               <tr>
                <td><a href='dolzh.php' class='menu2'>Должники</a></td>
              </tr>
			  			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			  
</table>
            </td>
  </tr>
</table>";?>