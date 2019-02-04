function FindPat()
{	
	
	document.fform.FS1.value=document.fform.FS.value;
	if (document.fform.FS1.value=='ч')
	{
		document.fform.FS1.value='Ч';
	}
	var url='spr_dogovora.php?FS='+document.fform.FS1.value;
	location.href=url;
}