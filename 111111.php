<?xml version="1.0" encoding="windows-1251"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru" dir="ltr">
<head>
<link rel="icon" href="./favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
<title>phpMyAdmin</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <link rel="stylesheet" type="text/css" href="./css/phpmyadmin.css.php?token=470177e9783a96dbaf9036a8acfe52df&amp;js_frame=right" />
    <link rel="stylesheet" type="text/css" href="./css/print.css?token=470177e9783a96dbaf9036a8acfe52df" media="print" />
    <script type="text/javascript" language="javascript">
    <!--
    // Updates the title of the frameset if possible (ns4 does not allow this
    if (typeof(parent.document) != 'undefined' && typeof(parent.document) != 'unknown'
        && typeof(parent.document.title) == 'string') {
        parent.document.title = 'orto / localhost / test  / allproyav | phpMyAdmin 2.8.2.4';
    }
    
    // js form validation stuff
    var errorMsg0   = 'Требуется значение для формы!';
    var errorMsg1   = 'Это не число!';
    var noDropDbMsg = 'Команда "Удалить БД" отключена.';
    var confirmMsg  = 'Вы действительно желаете ';
    var confirmMsgDropDB  = 'Вы уверенны что хотите уничтожить всю базу данных?';
    //-->
    </script>
    <script src= type="text/javascript" language="javascript">
	function insertValueQuery() {
    var myQuery = document.sqlform.sql_query;
    var myListBox = document.sqlform.dummy;

    if(myListBox.options.length > 0) {
        sql_box_locked = true;
        var chaineAj = "";
        var NbSelect = 0;
        for(var i=0; i<myListBox.options.length; i++) {
            if (myListBox.options[i].selected){
                NbSelect++;
                if (NbSelect > 1)
                    chaineAj += ", ";
                chaineAj += myListBox.options[i].value;
            }
        }

        //IE support
        if (document.selection) {
            myQuery.focus();
            sel = document.selection.createRange();
            sel.text = chaineAj;
            document.sqlform.insert.focus();
        }
        //MOZILLA/NETSCAPE support
        else if (document.sqlform.sql_query.selectionStart || document.sqlform.sql_query.selectionStart == "0") {
            var startPos = document.sqlform.sql_query.selectionStart;
            var endPos = document.sqlform.sql_query.selectionEnd;
            var chaineSql = document.sqlform.sql_query.value;

            myQuery.value = chaineSql.substring(0, startPos) + chaineAj + chaineSql.substring(endPos, chaineSql.length);
        } else {
            myQuery.value += chaineAj;
        }
        sql_box_locked = false;
    }
}
function selectContent( element, lock, only_once ) {
    if ( only_once && only_once_elements['element.name'] ) {
        return;
    }

    only_once_elements['element.name'] = true;

    if ( lock  ) {
        return;
    }

    element.select();
}
</script>
        
        <script src="./js/tooltip.js" type="text/javascript"
            language="javascript"></script>
        <meta name="OBGZip" content="false" />
    </head>

    <body>
    <div id="TooltipContainer" onmouseover="holdTooltip();" onmouseout="swapTooltip('default');"></div>
    <div id="serverinfo">
<a href="main.php?token=470177e9783a96dbaf9036a8acfe52df" class="item">        <img class="icon" src="./themes/original/img/s_host.png" width="16" height="16" alt="" /> 
Сервер: localhost</a>
        <span class="separator"><img class="icon" src="./themes/original/img/item_ltr.png" width="5" height="9" alt="-" /></span>
<a href="db_details_structure.php?db=test;token=470177e9783a96dbaf9036a8acfe52df" class="item">        <img class="icon" src="./themes/original/img/s_db.png" width="16" height="16" alt="" /> 
БД: test</a>
        <span class="separator"><img class="icon" src="./themes/original/img/item_ltr.png" width="5" height="9" alt="-" /></span>
<a href="tbl_properties_structure.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df" class="item">        <img class="icon" src="./themes/original/img/s_tbl.png" width="16" height="16" alt="" /> 
таблица : allproyav</a>
<span class="table_comment" id="span_table_comment">&quot;Проявление аллергии&quot;</span>
</div><div id="topmenucontainer">
<ul id="topmenu">
<li><a class="tab" href="sql.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php&amp;pos=0" ><img class="icon" src="./themes/original/img/b_browse.png" width="16" height="16" alt="Обзор" />Обзор</a></li>
<li><a class="tab" href="tbl_properties_structure.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php" ><img class="icon" src="./themes/original/img/b_props.png" width="16" height="16" alt="Структура" />Структура</a></li>
<li><a class="tabactive" href="tbl_properties.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php" ><img class="icon" src="./themes/original/img/b_sql.png" width="16" height="16" alt="SQL" />SQL</a></li>
<li><a class="tab" href="tbl_select.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php" ><img class="icon" src="./themes/original/img/b_search.png" width="16" height="16" alt="Искать" />Искать</a></li>
<li><a class="tab" href="tbl_change.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php" ><img class="icon" src="./themes/original/img/b_insrow.png" width="16" height="16" alt="Вставить" />Вставить</a></li>
<li><a class="tab" href="tbl_properties_export.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php&amp;single_table=true" ><img class="icon" src="./themes/original/img/b_tblexport.png" width="16" height="16" alt="Экспорт" />Экспорт</a></li>
<li><a class="tab" href="tbl_import.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php" ><img class="icon" src="./themes/original/img/b_tblimport.png" width="16" height="16" alt="Import" />Import</a></li>
<li><a class="tab" href="tbl_properties_operations.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php" ><img class="icon" src="./themes/original/img/b_tblops.png" width="16" height="16" alt="Операции" />Операции</a></li>
<li><a class="tabcaution" href="sql.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php&amp;sql_query=TRUNCATE+TABLE+%60allproyav%60&amp;zero_rows=%D2%E0%E1%EB%E8%F6%E0+allproyav+%E1%FB%EB%E0+%EE%F7%E8%F9%E5%ED%E0&amp;goto=tbl_properties_structure.php" onclick="return confirmLink(this, 'TRUNCATE TABLE `allproyav`')"><img class="icon" src="./themes/original/img/b_empty.png" width="16" height="16" alt="Очистить" />Очистить</a></li>
<li><a class="tabcaution" href="sql.php?db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df&amp;goto=tbl_properties.php&amp;back=tbl_properties.php&amp;reload=1&amp;purge=1&amp;sql_query=DROP+TABLE+%60allproyav%60&amp;goto=db_details_structure.php&amp;zero_rows=%D2%E0%E1%EB%E8%F6%E0+allproyav+%E1%FB%EB%E0+%F3%E4%E0%EB%E5%ED%E0" onclick="return confirmLink(this, 'DROP TABLE `allproyav`')"><img class="icon" src="./themes/original/img/b_deltbl.png" width="16" height="16" alt="Уничтожить" />Уничтожить</a></li>
</ul>
<div class="clearfloat"></div></div>
<br />
<form method="post" action="import.php"  enctype="multipart/form-data" id="sqlqueryform" onsubmit="return checkSqlQuery(this)" name="sqlform">
<input type="hidden" name="is_js_confirmed" value="0" />
<input type="hidden" name="db" value="test" />
<input type="hidden" name="table" value="allproyav" />
<input type="hidden" name="token" value="470177e9783a96dbaf9036a8acfe52df" />

<input type="hidden" name="pos" value="0" />
<input type="hidden" name="goto" value="tbl_properties.php" />
<input type="hidden" name="zero_rows" value="Ваш SQL-запрос был успешно выполнен" />
<input type="hidden" name="prev_sql_query" value="" />
<a name="querybox"></a>
<div id="queryboxcontainer">
<fieldset id="querybox">
<legend>Выполнить SQL запрос(ы) на БД : <a href="http://dev.mysql.com/doc/refman/4.1/en/select.html" target="mysql_doc"><img class="icon" src="./themes/original/img/b_help.png" width="11" height="11" alt="Документация" title="Документация" /></a></legend>
<div id="queryfieldscontainer">
<div id="sqlquerycontainer">
<textarea name="sql_query" id="sqlquery"  cols="40"  rows="7"  dir="ltr" onfocus="selectContent( this, sql_box_locked, true )">SELECT * FROM `allproyav` WHERE 1</textarea>
</div>
<div id="tablefieldscontainer">
<label>Поля</label>
<select id="tablefields" name="dummy" size="5" multiple="multiple" ondblclick="insertValueQuery()">
<option value="`id`">id</option>
<option value="`proyav`">proyav</option>
</select>
<div id="tablefieldinsertbuttoncontainer">
  <input type="button" name="insert" value="&lt;&lt;" onclick="insertValueQuery()" title="Вставить" />
</div>
</div>
<div class="clearfloat"></div>
</div>
<div class="clearfloat"></div>
</fieldset>
</div>
<fieldset id="queryboxfooter" class="tblFooters">
<div class="formelement">
</div>
<div class="formelement">
<input type="checkbox" name="show_query" value="1" id="checkbox_show_query" checked="checked" />
<label for="checkbox_show_query"> Показать данный запрос снова </label>
</div>
<input type="submit" name="SQL" value="Пошел" />
<div class="clearfloat"></div>
</fieldset>
</form>
<script type="text/javascript" language="javascript">
//<![CDATA[
// updates current settings
if (window.parent.setAll) {
    window.parent.setAll('ru-win1251', '', '1', 'test', 'allproyav');
}


// set current db, table and sql query in the querywindow
if (window.parent.refreshLeft) {
    window.parent.reload_querywindow(
        "test",
        "allproyav",
        "");
}


if (window.parent.frames[1]) {
    // reset content frame name, as querywindow needs to set a unique name
    // before submitting form data, and navigation frame needs the original name
    if (window.parent.frames[1].name != 'frame_content') {
        window.parent.frames[1].name = 'frame_content';
    }
    if (window.parent.frames[1].id != 'frame_content') {
        window.parent.frames[1].id = 'frame_content';
    }
    //window.parent.frames[1].setAttribute('name', 'frame_content');
    //window.parent.frames[1].setAttribute('id', 'frame_content');
}
//]]>
</script>
<div id="selflink">
<a href="index.php?target=tbl_properties.php&amp;db=test;table=allproyav;token=470177e9783a96dbaf9036a8acfe52df" target="_blank">Open new phpMyAdmin window</a>
</div>
</body>
</html>
