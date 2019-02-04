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
                <td bgcolor='#42929D' class='mmenu2'>Материалы</td>
              </tr> 
			  <tr>
                <td><a href='mater.php' class='menu2'>Каталог материалов</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>        
              <tr>
                <td><a href='mater_ost.php' class='menu2'>Остаток материалов</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='mater_prih.php' class='menu2'>Приход материала</a></td>
              </tr>
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='mater_vid.php' class='menu2'>Выдача материалов</a></td>
              </tr>
			   <tr>
			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='raspis/naznach_pat.php' class='menu2'>Инвентаризация</a></td>
              </tr>
			  <tr>
			  <tr>
			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='tech_sp.php' class='menu2'>Учёт приборов</a></td>
              </tr>
			  <tr>
			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='mater_uch.php' class='menu2'>Учёт расхода материалов</a></td>
              </tr>
			  <tr>
			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='spr_edizm.php' class='menu2'>Еденицы измерения</a></td>
              </tr>
			  <tr>
			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='mater_mesta_hr.php' class='menu2'>Mеста хренния материалов</a></td>
              </tr>
			   <tr>
			    <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>		
			 <tr>
                <td><a href='mater_order.php' class='menu2'>Составление заявки</a></td>
              </tr>
</table>



<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Списание материалов</td>
              </tr> 
			  <tr>
                <td><a href='mater_spis.php' class='menu2'>Списание материалов</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>        
              <tr>
                <td><a href='mater_sootv.php' class='menu2'>Установка соотвествий для автосписания</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>	
			  <td><a href='mater_sootv_otch.php' class='menu2'>Отчёт по автосписанию</a></td>
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
                <td><a href='mater_otch_prih.php' class='menu2'>Отчёты по приходам</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>        
              <tr>
                <td><a href='mater_otch_vid.php' class='menu2'>Отчёты по выдаче
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>	
			  <td><a href='mater_otch_spis.php' class='menu2'>отчёты по списанию</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>			
			 
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
				   
				  
                <td bgcolor='#42929D' class='mmenu2'>Сотрудники</td>
              </tr>         
			  <tr>
                <td><a href=spr_sotr.php class='menu2'>Сотрудники</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='sotr_time.php?action=month' class='menu2'>Табель</a></td>
              </tr>
</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
				   
				  
                <td bgcolor='#42929D' class='mmenu2'>Пациенты</td>
              </tr>         
			  <tr>
                <td><a href='PatWork.php?add=add' class='menu2'>Добавить нового </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              <tr>
                <td><a href='pat.php' class='menu2'>Работа с пациентами  </a></td>
              </tr>
</table>

    </td>
  </tr>
</table>";
?>
