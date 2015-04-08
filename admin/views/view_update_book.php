<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			echo "<ol>";
			
			$content = $_POST['result'];

			foreach($content as $item)
			{
				echo "<li><a href = '" . BASE_URL_ADMIN . "update_form/book
					/id=" . $item['idBook']
					. "'>" . $item['Authors'] . ', '
					. $item['Genres'] . ', '
					. $item['Name'] . ', '
					. $item['Price'] . ', '
					. "</a></li>";
			}
			
			echo "</ol>";
		?>
	</body>
</html>