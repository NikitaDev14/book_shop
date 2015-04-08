<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="<?php echo BASE_URL_ADMIN; ?>add_res/genre" method="post">
			<p>Жанр</p>
			<input type="text" name="genre" size="30"/>
			<input type="submit" name="submit" value="Добавить"/>
		</form>
	</body>
</html>