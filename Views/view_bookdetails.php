<!DOCTYPE HTML>
<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<h1>Книга</h1>
		<?php
			$id_item = $_POST['id_item'];
		?>
		<form action="/bookcatalogue/order/id=<?php echo $id_item ?>" method="post">
			<?php
				$name = $_POST['book']['name'];
				$description = $_POST['book']['description'];
				$price = $_POST['book']['price'];
				$authors = $_POST['book']['authors'];
				$genres = $_POST['book']['genres'];
				
				echo "<h3>Автор</h3>";
				
				foreach($authors as $author)
				{
					echo $author."<br/>";
				}
				
				echo "<h3>Жанр</h3>";
				
				foreach($genres as $genre)
				{
					echo $genre."<br/>";
				}
				
				echo "<h3>Название</h3>";
				
				echo $name;
				
				echo "<h3>Краткое описание</h3>";
				
				echo $description;
				
				echo "<h3>Цена ($)</h3>";
				
				echo $price;
			?>
			<br/>
			<input type="submit" value="Заказать"/>
		</form>
	</body>
</html>