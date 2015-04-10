<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$id_book = $_POST['id_item'];
		?>
		<form action="<?php echo BASE_URL_ADMIN; ?>update_res/book/id=<?php echo $id_book ?>" method="post">
			<?php
				$name = $_POST['book']['Name'];
				$description = $_POST['book']['Description'];
				$price = $_POST['book']['Price'];
				$authors = $_POST['authors'];
				$genres = $_POST['genres'];
				$image = $_POST['book']['Image'];
echo <<<HERE
				<h3>Автор</h3>
				
				$authors
				
				<h3>Жанр</h3>
				
				$genres
				
				<h3>Название</h3>
			
				<input type='text' name='name' size='30' value='$name'/>

				<h3>Цена ($)</h3>

				<input type='text' name='price' value='$price'/>

				<h3>Иллюстрация (jpg, png, gif)</h3>

				<img height='300px' src="../../Resources/img/$image" />

				<input type='file' name='image'/>
				
				<h3>Краткое описание</h3>
				
				<textarea name='description' maxlength='1000'>$description</textarea>
HERE;
			?>
			<br/>
			<input type="submit" value="Сохранить"/>
		</form>
	</body>
</html>
