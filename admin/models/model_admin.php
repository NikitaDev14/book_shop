<?php
	class Model_admin extends Model
	{
		public function add_item($field)
		{
			$db = parent::connection();
			$value = $_POST[$field];

			$stmt = $db->prepare('CALL add' . $field . '(?)');
			$stmt->bindParam(1, $value);

			$result = $stmt->execute();
			
			if($result)
			{
				return "Информация в БД вставлена успешно";
			}
			else
			{
				return "При вставке информации в БД произошла ошибка!";
			}
		}
		private function upload_image($login, $avatar) // обработка фотографии пользователя
		{
			if(is_uploaded_file($avatar['tmp_name']))
			{
				$format = end(explode('.', $avatar['name'])); // получение формата файла

				$fname = $login . '.' . $format; // формирование имени файла на основании логина

				move_uploaded_file($avatar['tmp_name'], 'images/' . $fname); // перемещение файла в папку images

				$image = 'images/' . $fname;
			}
			else { $image = null; }

			return $image;
		}
		public function add_book()
		{
			$db = parent::connection();

			$author = implode(',', $_POST['authors']);
			$genre = implode(',', $_POST['genres']);
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$image = $_FILES['image'];

			if(is_uploaded_file($image['tmp_name']))
			{
				$format = end(explode('.', $image['name']));

				if(in_array($format, ['jpg', 'png', 'gif'], false))
				{
					$stmt = $db->prepare('CALL addBook(?, ?, ?, ?, ?, ?)');
					$stmt->bindParam(1, $author);
					$stmt->bindParam(2, $genre);
					$stmt->bindParam(3, $name);
					$stmt->bindParam(4, $description);
					$stmt->bindParam(5, $price);
					$stmt->bindParam(6, $format);

					$stmt->execute();

					$result = $stmt->fetchAll();

					$fname = $result[0]['idNewBook'] . '.' . $format;

					move_uploaded_file($image['tmp_name'], '../Resources/img/' . $fname);
				}
				else { $result = false; }
			}
			else { $result = false; }
			
			if($result)
			{
				return "Информация в БД вставлена успешно";
			}
			else
			{
				return "При вставке информации в БД произошла ошибка!";
			}
		}
		public function update_item($field, $id)
		{
			$db = parent::connection();
			$value = $_POST[strtolower($field)];

			$stmt = $db->prepare('CALL update' . $field . '(?, ?)');
			$stmt->bindParam(1, $id);
			$stmt->bindParam(2, $value);

			$result = $stmt->execute();

			if($result)
			{
				return "Информация в БД изменена успешно";
			}
			else
			{
				return "При изменении информации в БД произошла ошибка!";
			}
		}
		public function update_book($authors, $genres, $name, $description, $price, $id_book, $image)
		{
			$db = parent::connection();

			$format = '';

			if(is_uploaded_file($image['tmp_name']))
			{
				$format = end(explode('.', $image['name']));

				if(in_array($format, ['jpg', 'png', 'gif'], false))
				{
					$fname = $id_book . '.' . $format;

					move_uploaded_file($image['tmp_name'], '../Resources/img/' . $fname);
				}
				else { $format = ''; }
			}

			$stmt = $db->prepare('CALL updateBook(?, ?, ?, ?, ?, ?, ?)');
			$stmt->bindParam(1, implode(',', $authors));
			$stmt->bindParam(2, implode(',', $genres));
			$stmt->bindParam(3, $name);
			$stmt->bindParam(4, $description);
			$stmt->bindParam(5, $price);
			$stmt->bindParam(6, $id_book);
			$stmt->bindParam(7, $format);

			$stmt->execute();

			$result = $stmt->fetchAll();

			var_dump($result);
			
			if($result)
			{
				return "Информация в БД изменена успешно";
			}
			else
			{
				return "При изменении информации в БД произошла ошибка!";
			}
		}
		public function delete_item($field, $id)
		{
			$db = parent::connection();
			$table = $field.'s';
			
			$stmt = $db->prepare("DELETE FROM $table WHERE id=?");
			$stmt->bindParam(1, $i);
			
			foreach($id as $i)
			{
				$result = $stmt->execute();
			}
			
			if($result)
			{
				return "Информация из БД удалена успешно";
			}
			else
			{
				return "При удалении информации из БД произошла ошибка!";
			}
		}
		public function delete_book($id)
		{
			$db = parent::connection();
			
			$query = null;
			
			foreach($id as $i)
			{	
				$query .= "DELETE FROM books WHERE id='$i';";
			}
			
			$query = substr($query,0,-1);
			
			$result = $db->exec($query);
			
			if($result)
			{
				return "Информация из БД удалена успешно";
			}
			else
			{
				return "При удалении информации из БД произошла ошибка!";
			}
		}
		public function select_item($field, $cond = null)
		{
			return parent::select_item($field, $cond);
		}
		public function select_book($cond = null)
		{
			return parent::select_book($cond);
		}
		public function select_book_id($id_book)
		{
			return parent::select_book_id($id_book);
		}
	}
?>