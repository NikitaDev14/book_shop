<html>
	<head>
		<title>Order form</title>
	</head>
	<body>
		<h1>Форма заказа</h1>
		<?php
			$id_item = $_POST['id_item'];
		?>
		<form action="/bookcatalogue/order_res/id=<?php echo $id_item ?>" method="post">
			<?php
echo <<<HERE
				<h3>Адрес</h3>
				<input type='text' name='addres'/>
				<h3>ФИО заказчика</h3>
				<input type='text' name='customer'/>
				<h3>Количество экземпляров</h3>
				<input type='number' min='1' name='number' value='1'/>
				<br/><br/>
				<input type="submit" value="Оформить заказ"/>
HERE;
			?>
		</form>
	</body>
</html>