<html>
<head>
	<title>Book catalogue</title>
</head>
<body>
<form action="<?php echo BASE_URL_ADMIN; ?>update_res/order/id=<?php echo $_POST['order'][0]['idOrder']; ?>"
      method="post">
	<h3>OrderId: <?php echo $_POST['order'][0]['idOrder']; ?></h3>

	<h3>Status: </h3>

	<?php echo $_POST['status']; ?>

	</br><input type="submit" value="Применить"/>
</form>
</body>
</html>