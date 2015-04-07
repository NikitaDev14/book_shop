<html>
	<head>
		<title>Book catalogue</title>
	</head>
	<body>
		<?php
			$content = $_POST['result'];
			
			foreach($content as $row)
			{
				$strLink = "<a href = '/bookcatalogue/admin/update_form
					/genre/id=".$row["id"]."'>".$row["genre"]."</a>";
				
				echo $strLink."<br/>";
			}		
		?>
	</body>
</html>