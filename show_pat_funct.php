<?php
session_start();
include('mysql_fuction.php');
$ThisVU="all";
$ModName="Работа с пациентами"; 

include("header.php");
// Форма для вывода пациентов
echo "<h3 align=center><strong>Пациенты клиники</strong></h3>";



echo "<form id=\"searchform\" method=\"post\"> 
<div> 
        <label for=\"search_term\">Поиск пациентов</label> 
        <input type=\"text\" name=\"search_term\" id=\"search_term\" /> 
<input type=\"submit\" value=\"Поиск\" id=\"search_button\" /> 
</div> 
    </form> ";
echo "<div id=\"patinfo\" class=\"child\">Выбирете пациента</div>";
echo "<div id=\"search_results\" class=\"child\">";
echo "<div id=\"patinfo\" class=\"child\">Выбирете пациента</div>";

//Функция поиска
echo "<script type='text/javascript'> 
$(document).ready(function(){ 
$(\"#search_results\").slideUp(); 
    $(\"#search_button\").click(function(e){ 
        e.preventDefault(); 
        ajax_search(); 
    }); 
    $(\"#search_term\").keyup(function(e){ 
        e.preventDefault(); 
        ajax_search(); 
    }); 
 });

function ajax_search(){ 
  $(\"#search_results\").show(); 
  var search_val=$(\"#search_term\").val(); 
  $.post(\"./pat_find_funct.php\", {action : \"find\",search_term : search_val}, function(data){
   if (data.length>0){ 
     $(\"#search_results\").html(data); 
   } 
  }) 
}
</script>";

include("footer.php");
?>