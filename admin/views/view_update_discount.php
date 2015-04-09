<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
	<?php
		$content = $_POST['result'];

		foreach($content as $row)
		{
			$strLink = "<a href = '" . BASE_URL_ADMIN . "update_form
					/discount/id=".$row["idDiscount"]."'>".$row["Size"]."</a>";

			echo $strLink."<br/>";
		}
	?>
	</body>
</html>