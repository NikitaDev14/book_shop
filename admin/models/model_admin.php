<?php
	class Model_admin extends Model {
		
		public function get_email($path)
		{
			return parent::get_email($path);
		}
		public function set_email($email)
		{
			$f = fopen('email.txt', 'w');
			
			fwrite($f, $email);
			
			fclose($f);
		}
		public function add_item($field)
		{
			$db = parent::connection();
			$table = $field.'s';
			$value = $_POST[$field];
			$result = $db->exec("INSERT INTO $table SET $field='$value'");
			
			if($result)
			{
				return "Информация в БД вставлена успешно";
			}
			else
			{
				return "При вставке информации в БД произошла ошибка!";
			}
		}
		public function add_book()
		{
			$db = parent::connection();

			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$author = $_POST['authors'];
			$genre = $_POST['genres'];
			
			$db->exec("INSERT INTO books SET name='$name', price='$price'");
			
			$id_book = $db->lastInsertId();
			
			$query = NULL;
			
			$sql_descr = "INSERT INTO descriptions SET id_book='$id_book', description='$description'";
			
			foreach($author as $id_author)
			{
				$id_author = (int)$id_author;
				
				$query .= "INSERT INTO authors_books SET id_author='$id_author', id_book='$id_book';";
			}
			
			foreach($genre as $id_genre)
			{
				$id_genre = (int)$id_genre;
				
				$query .= "INSERT INTO genres_books SET id_genre='$id_genre', id_book='$id_book';";
			}
			
			$query .= $sql_descr;

			$result = $db->exec($query);
			
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
			$table = $field.'s';
			$value = $_POST[$field];
			$result = $db->exec("UPDATE $table SET $field='$value' WHERE id='$id'");
			
			if($result)
			{
				return "Информация в БД изменена успешно";
			}
			else
			{
				return "При изменении информации в БД произошла ошибка!";
			}
		}
		public function update_book($authors, $genres, $name, $description, $price, $id_book)
		{
			$db = parent::connection();
			
			$query = "UPDATE books SET name='$name', price='$price' WHERE id='$id_book';";
			$query .= "UPDATE descriptions SET description='$description' WHERE id_book='$id_book';";
			
			$query .= "DELETE FROM authors_books WHERE id_book='$id_book';";
			$query .= "DELETE FROM genres_books WHERE id_book='$id_book';";
			
			foreach($authors as $id_author)
			{
				$query .= "INSERT INTO authors_books SET id_author='$id_author', id_book='$id_book';";
			}
			
			foreach($genres as $id_genre)
			{
				$query .= "INSERT INTO genres_books SET id_genre='$id_genre', id_book='$id_book';";
			}
			
			$query = substr($query,0,-1);

			$result = $db->exec($query);
			
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