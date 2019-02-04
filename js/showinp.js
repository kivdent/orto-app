function ShowInp()
{
	 document.write('<select name="VidAll['+document.form1.count.value+']">'+'<?php ?>'+'</select>');
	 document.form1.count.value=document.form1.count.value+1;
}