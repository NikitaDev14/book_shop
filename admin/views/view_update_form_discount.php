<html>
<head>
	<title>Book catalogue</title>
</head>
<body>
<?php
	$content = $_POST['result'];

	foreach($content as $row)
	{
		$discount = $row['Size'];
		$id = $row['idDiscount'];
	}
?>
<form action="<?php echo BASE_URL_ADMIN ?>update_res/discount/id=<?php echo $id ?>" method="post">
	<br/>
	<input type="text" name="discount" value="<?php echo $row['Size'] ?>"/>
	<input type="submit" name="submit" value="Изменить"/>
</form>
</body>
</html>