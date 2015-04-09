<html>
<head>
	<title>Book catalogue</title>
</head>
<body>
<table border="1">
	<th>Id</th>
	<th>Date</th>
	<th>Pay method</th>
	<th>Sum</th>
	<th>Status</th>
	<?php
		$content = $_POST['result'];

		foreach ($content as $row) {
			echo "
					<tr>
						<td>$row[idOrder]</td>
						<td>$row[Date]</td>
						<td>$row[PayMethod]</td>
						<td>$row[Summ]</td>
						<td>
							<a href='" . BASE_URL_ADMIN . "update_form/order/id=$row[idOrder]'>" . $row['OrderStatus'] . "</a>
						</td>
					</tr>";
		}
	?>
</table>
</body>
</html>
<!--
			<td><a href = '" . BASE_URL_ADMIN . "update_form
	/user/id=".$row["idUser"]."'>".$row["Email"]."</a></td>
			<td>" . $row['Discount'] . "</td></tr>";
-->