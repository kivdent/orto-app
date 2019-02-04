function chek(c1,c2)
{
	if (document.manipf.action.value==add)
	{
		if (c1=='') 
		{
			alert('Введите название');
			document.manipf.manip.focus();
			return false;
		}
		if (c2=='')
		{
			alert('Введите цену');
			document.manipf.price.focus();
			return false;
		}
	}
    return true;
}
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