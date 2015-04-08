<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="<?php echo BASE_URL_ADMIN ?>add_res/book" method="post" enctype="multipart/form-data">
			<?php
				$authors = $_POST['authors'];
				$genres = $_POST['genres'];
				
				echo "<h3>Авторы</h3>";
				
				foreach($authors as $row)
				{
					echo "<br/><label><input type='checkbox' name='authors[]' value='".$row['idAuthor']."'/>".$row['Name'].'</label>';
				}
				
				echo "<h3>Жанры</h3>";
				
				foreach($genres as $row)
				{
					echo "<br/><label><input type='checkbox' name='genres[]' value='".$row['idGenre']."'/>".$row['Name'].'</label>';
				}

				echo "<h3>Название</h3>";
				
				echo "<input type='text' name='name' size='30'/>";

				echo "<h3>Цена ($)</h3>";
				
				echo "<input type='text' name='price'/>";

				echo "<h3>Иллюстрация (jpg, png, gif)</h3>";

				echo "<input type='file' name='image' accept='image/jpeg, image/png, image/gif'/>";

				echo "<h3>Краткое описание</h3>";

				echo "<textarea name='description' maxlength='1000'></textarea>";

			?>
			<br/>
			<input type="submit" name="submit" value="Добавить"/>
		</form>
	</body>
</html>