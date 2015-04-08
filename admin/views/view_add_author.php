<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="<?php echo BASE_URL_ADMIN; ?>add_res/author" method="post">
			<p>Автор (ФИО)</p>
			<input type="text" name="author" size="30"/>
			<input type="submit" name="submit" value="Добавить"/>
		</form>
	</body>
</html>