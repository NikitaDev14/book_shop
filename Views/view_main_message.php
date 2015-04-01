<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<a href="admin/">Администраторская часть</a>
		<h1>Книжный каталог</h1>
		<form action="/BookCatalogue" method="get">
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

				echo "<br/><input type='submit' value='Применить фильтр'/>";
			?>
		</form>
	</body>
</html>