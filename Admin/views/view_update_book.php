<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			echo "<ol>";
			
			$content = $_POST['result'];
			
			foreach($content as $key => $item)
			{
				echo "<li><a href = '/bookcatalogue/admin/update_form/book
					/id=".$key."'>".$item."</a></li>";
			}
			
			echo "</ol>";
		?>
	</body>
</html>