<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="/bookcatalogue/admin/main/save_email" method="post">
			<?php
				$email = $_POST['email'];
echo <<<HERE
				<p>Полный e-mail адрес для заказов</p>
				<input type=text name=email value=$email size=30/>
				<input type=submit name=submit value=Добавить>
HERE;
			?>
		</form>
	</body>
</html>