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
                <td bgcolor='#42929D' class='mmenu2'>Отчёты</td>
              </tr> 
			             <tr>
                <td><a href='fin_per.php' class='menu2'>Финансы за период </a></td>
              </tr>        
			               <tr>
			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>

</table>
<table width='100%' border='0' cellspacing='0' cellpadding='0'>
                   <tr>
                <td bgcolor='#42929D' class='mmenu2'>Заработная плата</td>
              </tr> 
			             <tr>
                <td><a href='buhg_zp.php' class='menu2'>Заработная плата</a></td>
              </tr>        
			               <tr>
			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
			<tr>
                <td><a href='buhg_zc.php' class='menu2'>Зарплатная карта</a></td>
              </tr>        
			               <tr>
			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
              			<tr>
                <td><a href='sotr_time.php' class='menu2'>Табель</a></td>
              </tr>        
			               <tr>
			                 <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>
</table>
            </td>
  </tr>
</table>
";?>