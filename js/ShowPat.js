function openPatWin(id,ro) 
{
	var url='pat_card.php?id='+id+'&ro='+ro;
	myWin= open(url,"PatWin","status=no,toolbar=no,menubar=no");
}
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
function BIG(text)
{
	text.value=text.value.toUpperCase();
}
function findP(text)
{
	text.value=text.value.toUpperCase();
	document.fform.FindFl.value=1;
	document.fform.submit();
}
function findp1(text)
{
	document.fform.find.value=text;
	document.fform.FindFl.value=1;
	document.fform.submit();
}
function ShowInfo(PatId)
{
	
	
	
	
	document.patel.NCard.value=document.patel.element.options[document.patel.element.selectedIndex].value;
	document.patel.PatName.value=aSname[document.patel.element.selectedIndex]+' '+aName[document.patel.element.selectedIndex]+' '+aOtch[document.patel.element.selectedIndex];
	document.patel.TelDom.value=aDt[document.patel.element.selectedIndex];
	document.patel.TelRab.value=aRt[document.patel.element.selectedIndex];
	document.patel.TelSot.value=aSt[document.patel.element.selectedIndex];
}
function ShowInfo2(PatId)
{

	document.opl_orto.NCard.value=document.opl_orto.pat.options[document.opl_orto.pat.selectedIndex].value;
	document.opl_orto.PatName.value=aSname[document.opl_orto.pat.selectedIndex]+' '+aName[document.opl_orto.pat.selectedIndex]+' '+aOtch[document.opl_orto.pat.selectedIndex];
	document.opl_orto.DTel.value=aDt[document.opl_orto.pat.selectedIndex];
	document.opl_orto.RTel.value=aRt[document.opl_orto.pat.selectedIndex];
	document.opl_orto.STel.value=aSt[document.opl_orto.pat.selectedIndex];
	document.opl_orto.MSumm.value=aPMonth[document.opl_orto.pat.selectedIndex];
	document.opl_orto.sh_id.value=shID[document.opl_orto.pat.selectedIndex];
}