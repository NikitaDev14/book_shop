<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="/bookcatalogue/admin/add_res/book" method="post">
			<?php
				$authors = $_POST['authors'];
				$genres = $_POST['genres'];
				
				echo "<h3>Авторы</h3>";
				
				foreach($authors as $row)
				{
					echo "<br/><input type='checkbox' name='authors[]' value=".$row['id']."/>".$row['author'];
				}
				
				echo "<h3>Жанры</h3>";
				
				foreach($genres as $row)
				{
					echo "<br/><input type='checkbox' name='genres[]' value=".$row['id']."/>".$row['genre'];
				}

				echo "<h3>Название</h3>";
				
				echo "<input type='text' name='name' size='30'/>";
				
				echo "<h3>Краткое описание</h3>";
				
				echo "<textarea name='description' maxlength='1000'></textarea>";
				
				echo "<h3>Цена ($)</h3>";
				
				echo "<input type='text' name='price'/>";
			?>
			<br/>
			<input type="submit" name="submit" value="Добавить"/>
		</form>
	</body>
</html>