<?php include(header.inc); ?>
<title>Введите имя пользователя  пароль</title>
</head>
<body>
<h3 align="center"><strong>Введите имя пользователя  пароль</strong></h3>
<form action="auth.php" method="post">
<table width="100%" border="0">
  <tr>
    <td>
	
	<table width="100%" border="0">
  <tr>
    <td align="right" width="50%">Имя пользователя</td>
    <td width="50%"><input name="login" type="text"   size="20"/></td>
  </tr>
  <tr>
    <td align="right">Пароль</td>
    <td><input name="pass" type="password"  size="20"/></td>
  </tr>
</table>

	</td>
  </tr>
  <tr>
    <td align="center"><input type="submit" value="Войти"/></td>
  </tr>
</table>
</form>
</body>
</html>
