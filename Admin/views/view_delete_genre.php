<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="/bookcatalogue/admin/delete_res/genre" method="post">
			<?php
				$content = $_POST['result'];
				
				foreach($content as $row)
				{
					echo "<br/><input type='checkbox' name='item[]' value=".$row['id']."/>".$row['genre'];
				}
			?>
			<br/>
			<input type="submit" value="Удалить"/>
		</form>
	</body>
</html>