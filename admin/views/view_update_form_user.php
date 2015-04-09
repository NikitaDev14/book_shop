<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="<?php echo BASE_URL_ADMIN; ?>update_res/user/id=<?php echo $_POST['user'][0]['idUser'];  ?>" method="post">
			<h3>User: <?php echo $_POST['user'][0]['Email']; ?></h3>

			<h3>Discount: </h3>

			<?php echo $_POST['discount']; ?>

			</br><input type="submit" value="Применить"/>
		</form>
	</body>
</html>