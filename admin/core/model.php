<?php
	class Model {
		protected function connection()
		{
			try
			{
			  $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
			  
			  $db->query("set_client='utf8'");
			  $db->query("set character_set_results='utf8'");
			  $db->query("set collation_connection='utf8_general_ci'");
			  $db->query("SET NAMES utf8");
			  
			  return $db;
			}
			catch (PDOException $e)
			{
			  die( 'Ошибка! Невозможно подключиться к базе данных.'.$e->getMessage() );
			}
		}
		public function select_book($cond)
		{
			$db = $this->connection();
			
			$stmt = $db->prepare('CALL getBooks(?)');
			$stmt->bindParam(1, $cond);

			$stmt->execute();

			return $stmt->fetchAll();
		}
		public function select_item($field, $cond)
		{
			$db = $this->connection();
			$table = $field.'s';

			$stmt = $db->prepare('CALL get' . $table . '(?)');
			$stmt->bindParam(1, $cond);

			$stmt->execute();

			return	$stmt->fetchAll();
		}
		public function select_book_id($id_book)
		{
			$authors = array();
			$genres = array();
			
			$db = $this->connection();
			
			$query = "SELECT authors.Name as Author, authors.idAuthor as idAuthor,
				genres.Name as Genre, genres.idGenre as idGenre, books.Name as Name,
				books.Price, books.Description, books.Image
				FROM genres 
					JOIN genres2books
						ON genres.idGenre = genres2books.idGenre
					JOIN books
						ON genres2books.idBook = books.idBook
					JOIN authors2books
						ON books.idBook = authors2books.idBook
					JOIN authors
						ON authors2books.idAuthor = authors.idAuthor
				WHERE books.idBook = '$id_book'";
			
			$result = $db->query($query);
			
			foreach($result as $row)
			{
				$authors[$row['idAuthor']] = $row['Author'];
				$genres[$row['idGenre']] = $row['Genre'];
				$name = $row['Name'];
				$price = $row['Price'];
				$description = $row['Description'];
				$image = $row['Image'];
			}

			$authors = array_unique($authors);
			$genres = array_unique($genres);
			
			$book = array('Authors' => $authors,'Genres' => $genres,'Name' => $name,
				'Description' => $description,'Price' => $price, 'Image' => $image);

			return $book;
		}
	}
?>