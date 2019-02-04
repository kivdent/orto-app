<?php 
echo "<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td align='center' valign='top' bgcolor='#42929D' class='mmenu2'><a href='".$_SESSION['valid_user'].".php' class='mmenu2'>Главная</a></td>
  </tr>
  <tr>
    <td height='1' align='center' valign='top' class='mmenu2'><img src='image/transrerent.gif' width='1' height='1' /></td>
  </tr>
  <tr>
            <td valign='top'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Расписание</td>
              </tr>         
              <tr>
                <td><a href='raspis_show.php' class='menu2'>Ежедневник</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='raspis_newpack.php' class='menu2'>Соcтавление пакета расписаний </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='raspis_change.php' class='menu2'>Изменить расписание</a></td>
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
                <td><a href='tabel.php' class='menu2'>Табель</a></td>
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
                <td><a href='pat_card_orto.php' class='menu2'>Работа с пациентами ортодонтия</a></td>
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
                <td><a href='discount.php?act=new' class='menu2'>Новые карты</a></td>
              </tr>
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='discount.php?act=make' class='menu2'>Выдача карт</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='discount.php?act=types' class='menu2'>Виды карт</a></td>
              </tr>
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Заплнение справочников</td>
              </tr>         
			  <tr>
                <td><a href=spr_sotr.php class='menu2'>Сотрудники</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href=spr_polz.php class='menu2'>Пользователи</a></td>
              </tr>
			  	 <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Права пользователей</a></td>
              </tr>
			    <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2' href='spr_firm.php'>Реквизиты фирм</a></td>
              </tr>
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			  <tr>
                <td><a class='menu2' href='spr_dogovora.php'>Договора</a></td>
              </tr>
			  
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			 <tr>
                <td><a class='menu2' href='klishe.php'>Клише</a></td>
              </tr>
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Состояние зуба</a></td>
              </tr>
			     <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Номер зуба</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=spr_ds.php>Диагноз</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2' href='spr_manip.php'>Манипуляции</a></td>
              </tr>
			  			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2' href='spr_preysk.php'>Прейскуранты</a></td>
              </tr>
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Материалы</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Еден. измерения</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Обозначения при осмотре</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2' href='spr_zh.php'>Жалобы</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2' href=spr_an.php>Анамнез</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=spr_ob.php>Объективно</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2' href='spr_dolzh.php'>Должности</a></td>
              </tr>
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Клише</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Манипуляции в клише</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Результаты приёма</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Виды оплат</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Договоры по б/н расчётам</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Содержания приёма</a></td>
              </tr>
			  
			  <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a class='menu2'href=prpolz.php>Варианты выполнения заявок</a></td>
              </tr>          
				<tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
</table></td>
          </tr>
</table>";
?>