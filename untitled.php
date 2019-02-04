<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="main2.css" rel="stylesheet" type="text/css" /><script type='text/javascript' language='javascript' src='js/insert.js'></script><title>Орто-премьер. Работа спациентом - Корчемный Владимир Маркович</title>
	</head>
	<body>
	<table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0' bgcolor='#FFFFFF'>
	  <tr>
		<td><div class='head1'>Стоматологическая клиника &quot;Орто-премьер&quot; </div></td>
	  </tr>
	  <tr>
		<td bgcolor='#42929D' class='bold4' ><table width='100%' border=0><tr><td width='150'><a href='index.php' class='niz'>Выход</a></td><td>Пользователь: Корчемный Владимир Маркович</td></tr></table></td>
	  </tr>
	  <tr>
		<td valign='top'>
		<table width='100%' height='100%' border='0' cellpadding='1' cellspacing='1' bordercolor='#FFFFFF'>
		  <tr>
			<td width='150' valign='top'><table width='100%' height='100%' border='0' cellpadding='0' cellspacing='0'>
  <tr>
    <td align='center' valign='top' bgcolor='#42929D' class='mmenu2'><a href='terapevt.php' class='mmenu2'>Главная</a></td>
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
                <td><a href='pat_tooday.php' class='menu2'>Пациенты на сегодня</a></td>
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
			  
</table>
			<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Отчёты</td>
              </tr>
			  <tr>
                <td><a href='doc_den.php' class='menu2'>Отчёт за день</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>         
              <tr>
                <td><a href='raspis_doctor_show.php' class='menu2'>Отчёт за период</a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
               <tr>
	               <tr>
                <td><a href='naznach_pat.php' class='menu2'>Должники</a></td>
              </tr>
			  			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			  
</table>
            </td>
  </tr>
</table></td><td valign='top' bgcolor='#ffffff'><table width='100%' border='0' cellspacing='0' cellpadding='1' bgcolor='#42929D'>
  <tr>
    <td><table width='100%' border='0' cellspacing='0' cellpadding='2' bgcolor='#FFFFFF'>
      <tr>
        <td><form method='get' action='pat_tooday_work.php' id='card' name='card'>
	<input name='count' type='hidden' value='1' />
	
	 <div class='head3'> Пациент:Иванов Иван Иванович</div><input name='step' type='hidden' value='4'/>
	<input name='action' type='hidden' value='lech'/><div class='head2'>Диагноз: 47-й зуб, Кариес, I класс по Блэку</div>
	  <hr width='100%' noshade='noshade' size='1'/>
	  <a href='#' class='niz2' >Пропустить заполнение карты</a><br />
	    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='300' align='right' valign='top'><div class='head2'>Жалобы</div><textarea name='zh_1' id='zh'  cols='40'  rows='2'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td width='' align='left' valign='top'><div class='head2'>Варианты</div><select id='tablefields' name='var_zh' size='1' multiple='multiple' ondblclick= 'insertValueQuery()' onMouseOver='document.card.var_zh.size=7' onmouseout='document.card.var_zh.size=1'>SELECT `zh`.`zh`, `zh`.`id`
FROM zh, soot_zh
WHERE ((`zh`.`id` =`soot_zh`.`zh`) AND (`soot_zh`.`ds` ='1'))
ORDER BY `zh`.`zh` ASC<br /><option value='боль'>боль</option><option value='наличие кариозной полости'>наличие кариозной полости</option><option value='от'>от</option><option value='нет'>нет</option><option value='механичесеих'>механичесеих</option><option value='химических'>химических</option><option value='температурных'>температурных</option></select><br />
<input type='button' name='insertzh' value='&lt;&lt;' onclick='insertValueQuery()' title='Вставить' /></td>
  </tr>
  <tr>
    <td height='148' align='right' valign='top'><div class='head2'>Анамнез</div>
        <textarea name='an_1' id='an'  cols='40'  rows='2'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td align='left' valign='top'><div class='head2'>Варианты</div><select id='tablefields' name='var_an' size='1' multiple='multiple' ondblclick= 'insertValueQueryan()' onMouseOver='document.card.var_an.size=6' onmouseout='document.card.var_an.size=1'><option value='Зуб ранее лечен по поводу осложнённого кариеса'>Зуб ранее лечен по поводу осложнённого кариеса</option><option value='Зуб ранее лечен по поводу неосложнённого кариеса'>Зуб ранее лечен по поводу неосложнённого кариеса</option><option value='Зуб ранее не лечен'>Зуб ранее не лечен</option><option value='Обратился с целью санации полости рта'>Обратился с целью санации полости рта</option><option value='перед ортопедическим лечением'>перед ортопедическим лечением</option><option value='перед ортодонтическим лечением'>перед ортодонтическим лечением</option></select>
      <br />
        <input type='button' name='insertan' value='&lt;&lt;' onclick='insertValueQueryan()' title='Вставить' /></td>
  </tr>		  
  <tr>
    <td height='148' align='right' valign='top'><div class='head2'>Объективно</div>
        <textarea name='obk_1' id='obk'  cols='40'  rows='10'  dir='ltr' onfocus='selectContent( this, sql_box_locked, true)'></textarea></td>
    <td align='left' valign='top'><div class='head2'>Варианты</div><select id='tablefields' name='var_obk' size='1' multiple='multiple' ondblclick= 'insertValueQueryobk()' onMouseOver='document.card.var_obk.size=3' onmouseout='document.card.var_obk.size=1'><option value='глубокая'>глубокая</option><option value='кариозная полость'>кариозная полость</option><option value='На вестибулярной поверхности'>На вестибулярной поверхности</option></select>
<br />
        <input type='button' name='insertobk' value='&lt;&lt;' onclick='insertValueQueryobk()' title='Вставить' /></td>
  </tr>
</table>
<center><input name='next' type='submit'  value='Дальше>>>'/></center>
</form></td>
      </tr>
    </table></td>
  </tr>
</table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>