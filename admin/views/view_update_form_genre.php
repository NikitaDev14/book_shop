<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$content = $_POST['result'];
			
			foreach($content as $row)
			{
				$genre = $row['Name'];
				$id = $row['idGenre'];
			}
		?>
		<form action="<?php echo BASE_URL_ADMIN; ?>update_res/genre/id=<?php echo $id ?>" method="post">
			<br/>
			<input type="text" name="genre" value="<?php echo $row['Name'] ?>"/>
			<input type="submit" name="submit" value="Изменить"/>
		</form>
	</body>
</html>