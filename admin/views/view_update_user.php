<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<table border="1">
			<th>Email</th>
			<th>Discount size</th>
	<?php
		$content = $_POST['result'];

		foreach($content as $row)
		{
			$tr = "<tr><td><a href = '" . BASE_URL_ADMIN . "update_form
					/user/id=".$row["idUser"]."'>".$row["Email"]."</a></td>
					<td>" . $row['Discount'] . "</td></tr>";

			echo $tr;
		}
	?>
		</table>
	</body>
</html>