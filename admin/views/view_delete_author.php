<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="<?php echo BASE_URL_ADMIN; ?>delete_res/author" method="post">
			<?php
				$content = $_POST['result'];
				
				foreach($content as $row)
				{
					echo "<br/><input type='checkbox' name='item[]' value=".$row['idAuthor']."/>".$row['Name'];
				}
			?>
			<br/>
			<input type="submit" value="Удалить"/>
		</form>
	</body>
</html>