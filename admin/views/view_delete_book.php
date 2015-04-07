<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<form action="/bookcatalogue/admin/delete_res/book" method="post">
			<?php
				$content = $_POST['result'];
				
				foreach($content as $key => $row)
				{
					echo "<br/><input type='checkbox' name='item[]' value=".$key."/>".$row;
				}
			?>
			<br/>
			<input type="submit" value="Удалить"/>
		</form>
	</body>
</html>