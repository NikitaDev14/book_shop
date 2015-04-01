<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$content = $_POST['result'];
			
			foreach($content as $row)
			{
				$author = $row['author'];
				$id = $row['id'];
			}
		?>
		<form action="/bookcatalogue/admin/update_res/author/id=<?php echo $id ?>" method="post">
			<br/>
			<input type="text" name="author" value="<?php echo $row['author'] ?>"/>
			<input type="submit" name="submit" value="Изменить"/>
		</form>
	</body>
</html>