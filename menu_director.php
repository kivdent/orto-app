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
                <td bgcolor='#42929D' class='mmenu2'>Отчёты</td>
              </tr> 
			  <tr>
                <td><a href='dir_den_opl.php' class='menu2'>Финансовый отчёт за день </a></td>
              </tr>
              <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>        
              <tr>
                <td><a href='dir_den_opl_per.php' class='menu2'>Финансовый отчёт по врачам за период </a></td>
              </tr>
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>	
              	  <tr>
                <td><a href='dir_den_opl_per_clin.php' class='menu2'>Финансовый отчёт по клинике за период </a></td>
              </tr>
			   <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>	
			 <tr>
                <td><a href='dir_dog.php' class='menu2'>Отчёт по договорам</a></td>
              </tr>
 <tr>
                <td height='1' bgcolor='#42929D'><img src='image/transrerent.gif' width='1' height='1' /></td>
              </tr>	
			 <tr>
                <td><a href='sotr_time.php' class='menu2'>Табель</a></td>
              </tr>			  
</table>
    </td>
  </tr>
</table>";
?>
