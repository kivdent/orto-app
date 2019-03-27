<?php
function msg($msg) 
{
	echo "<script language=\"JavaScript\" type=\"text/javascript\">alert(\"".$msg."\");</script>";	
}
function ret($href)
{
	echo "<script language=\"JavaScript\" type=\"text/javascript\">
		location.href='".$href."';
	</script>";	
}

?>
