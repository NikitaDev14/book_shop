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
					/author/id=".$row["idAuthor"]."'>".$row["Name"]."</a>";
				
				echo $strLink."<br/>";
			}
		?>
	</body>
</html>