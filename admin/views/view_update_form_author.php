<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$content = $_POST['result'];
			
			foreach($content as $row)
			{
				$author = $row['Name'];
				$id = $row['idAuthor'];
			}
		?>
		<form action="<?php echo BASE_URL_ADMIN ?>update_res/author/id=<?php echo $id ?>" method="post">
			<br/>
			<input type="text" name="author" value="<?php echo $row['Name'] ?>"/>
			<input type="submit" name="submit" value="Изменить"/>
		</form>
	</body>
</html>