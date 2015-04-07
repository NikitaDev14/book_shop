<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$content = $_POST['result'];
			
			foreach($content as $row)
			{
				$genre = $row['genre'];
				$id = $row['id'];
			}
		?>
		<form action="/bookcatalogue/admin/update_res/genre/id=<?php echo $id ?>" method="post">
			<br/>
			<input type="text" name="genre" value="<?php echo $row['genre'] ?>"/>
			<input type="submit" name="submit" value="Изменить"/>
		</form>
	</body>
</html>