﻿<html>
	<head>
		<title>Book catalogue</title>
		<base href="<?php echo BASE_URL_ADMIN; ?>">
	</head>
	<body>
		<h1>Администрирование</h1>
		<table cellspacing="15">
			<tr>
				<td>
					<a href="">Главная</a>
				</td>
				<td>
					<a href="<?php echo BASE_URL; ?>">Клиентская часть</a>
				</td>
				<td>
					<a href="help.html" target="_blank">Справка</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="<?php echo BASE_URL_ADMIN; ?>add/author">Добавить автора</a>
				</td>
				<td>
					<a href="add/genre">Добавить жанр</a>
				</td>
				<td>
					<a href="add/book">Добавить книгу</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="update/author">Изменить автора</a>
				</td>
				<td>
					<a href="update/genre">Изменить жанр</a>
				</td>
				<td>
					<a href="update/book">Изменить книгу</a>
				</td>
			</tr>
			<tr>
				<td>
					<a href="user/list">Пользователи</a>
				</td>
				<td>
					<a href="update/order">Заказы</a>
				</td>
				<td>
					<a href="user/discount">Скидки</a>
				</td>
			</tr>
			<!--
			<tr>
				<td>
					<a href="delete/author">Удалить автора</a>
				</td>
				<td>
					<a href="delete/genre">Удалить жанр</a>
				</td>
				<td>
					<a href="delete/book">Удалить книгу</a>
				</td>
			</tr>
			-->
		</table>
	</body>
</html>
