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