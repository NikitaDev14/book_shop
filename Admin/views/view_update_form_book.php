<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$id_book = $_POST['id_item'];
		?>
		<form action="/bookcatalogue/admin/update_res/book/id=<?php echo $id_book ?>" method="post">
			<?php
				$name = $_POST['book']['name'];
				$description = $_POST['book']['description'];
				$price = $_POST['book']['price'];
				$authors = $_POST['authors'];
				$genres = $_POST['genres'];
echo <<<HERE
				<h3>Автор</h3>
				
				$authors
				
				<h3>Жанр</h3>
				
				$genres
				
				<h3>Название</h3>
			
				<input type='text' name='name' size='30' value='$name'/>
				
				<h3>Краткое описание</h3>
				
				<textarea name='description' maxlength='1000'>$description</textarea>
				
				<h3>Цена ($)</h3>
				
				<input type='text' name='price' value='$price'/>
HERE;
			?>
			<br/>
			<input type="submit" value="Сохранить"/>
		</form>
	</body>
</html>