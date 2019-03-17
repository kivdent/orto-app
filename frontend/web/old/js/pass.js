// JavaScript Document
function PrPass(p1,p2)
{
    if (p1!=p2) 
	{
        alert('Пароль не совпадает');
        return false;
    }
	if (p1=='')
	{
		alert('Применение пустых паролей недопустимо');
        return false;
	}
    return true;
}