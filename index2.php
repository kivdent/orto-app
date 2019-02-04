<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Ввод оплаты</title>
</head>
<body>
<?php
echo "Привет <br>";
echo "Сегодня:".date("H:i,jS F");
echo "<br>Ведите данные об оплате: <form action=\"PatientPay.php\" method=\"post\"><br>"; 
echo "Фамилия: <input name=\"sirname\" type=\"text\"  /><br>";
echo "Имя: <input name=\"name\" type=\"text\" /><br>";
echo "Итого к оплате: <input name=\"k_opl\" type=\"text\" /><br>";
echo "Внесено денег: <input name=\"vnes_deneg\" type=\"text\" /><br>";
echo "<input name=\"vnesti\" type=\"submit\" value=\"Внести данные\" />";
echo "</form>";
?>
</body>
</html>
