function Toggle(node)
{
	// Unfold the branch if it isn't visible
	if (node.nextSibling.style.display == 'none')
	{
		// Change the image (if there is an image)
		if (node.children.length > 0)
		{
			if (node.children.item(0).tagName == "IMG")
			{
				node.children.item(0).src = "image/minus.gif";
			}
		}

		node.nextSibling.style.display = '';
	}
	// Collapse the branch if it IS visible
	else
	{
		// Change the image (if there is an image)
		if (node.children.length > 0)
		{
			if (node.children.item(0).tagName == "IMG")
			{
				node.children.item(0).src = "image/plus.gif";
			}
		}

		node.nextSibling.style.display = 'none';
	}

}
function clickHandler() 
{ 
	var targetId, srcElement, targetElement;  srcElement = window.event.srcElement;  
	if (srcElement.className == "mmenuHand") 
	{     
		targetId = srcElement.id + "details";     
		targetElement = document.all(targetId);     
		if (targetElement.style.display == "none") 
			{        
				targetElement.style.display = "";     
			} 
		else 
			{        
				targetElement.style.display = "none";     
			}  
	}
} 