<?php
	class Model {
	
		protected function connection()
		{
			$host = 'localhost';
			$user = 'root';
			$db = 'bookcatalogue';
			$pass = '';
			
			try
			{
			  $db = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass);
			  
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
		public function get_email($path)
		{
			$f = fopen($path, 'r');
			$email = fgets($f);
			
			fclose($f);
			
			return $email;
		}
		public function select_book($cond)
		{
			$db = $this->connection();
			
			if(is_array($cond) && !empty($cond))
			{
				$id_book = $cond;
			}
			else
			{
				$query = "SELECT id FROM books";
				
				if($cond != null)
				{
					$query .= " WHERE id=$cond";
				}
				
				$id_book = $db->query($query);
			}
			
			$book = array("author" => array(),"genre" => array(),"name" => "temp","price" => "temp");
			$catalogue = array();
			
			$sql = "SELECT genres.genre, books.name, books.price, authors.author
				FROM genres
					INNER JOIN genres_books
						ON genres.id = genres_books.id_genre
					INNER JOIN books
						ON genres_books.id_book = books.id
					LEFT JOIN authors_books
						ON books.id = authors_books.id_book
					LEFT JOIN authors
						ON authors_books.id_author = authors.id
				WHERE books.id = ?";
				
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $i);
			
			foreach($id_book as $row)
			{
				if(!isset($row['id']))	{ $i = $row; }
				else { $i = (int)$row['id']; }
				
				$stmt->execute();
				
				while($line = $stmt->fetchAll())
				{
					foreach($line as $item)
					{
						$book['author'][] = $item['author'];
						$book['genre'][] = $item['genre'];
						$book['name'] = $item['name'];
						$book['price'] = $item['price'];
					}
				}
				
				$book['author'] = array_unique($book['author']);
				$book['genre'] = array_unique($book['genre']);
				
				$book['price'] .= '$';
				
				$catalogue[$i] = $book;
				
				$book['author'] = array();
				$book['genre'] = array();
			}
			
			foreach($catalogue as $key => $item)
			{
				$bookLink = null;
				
				foreach($item['author'] as $a)
				{
					$bookLink .= $a.", ";
				}
				foreach($item['genre'] as $g)
				{
					$bookLink .= $g.", ";
				}
				
				$bookLink .= $catalogue[$key]['name'].", ".$catalogue[$key]['price'];
				
				$catalogue[$key] = $bookLink;
			}
			
			return $catalogue;
		}
		public function select_item($field, $cond)
		{
			$db = $this->connection();
			$table = $field.'s';
			$query = "SELECT * FROM $table";
			
			if($cond)
			{
				$query .= " WHERE id=$cond";
			}
			
			$result = $db->query($query);

			return	$result;
		}
		public function select_book_id($id_book)
		{
			$authors = array();
			$genres = array();
			
			$db = $this->connection();
			
			$query = "SELECT authors.author,authors_books.id_author, genres.genre, 
				genres_books.id_genre, books.name, books.price, descriptions.description
				FROM genres 
					INNER JOIN genres_books 
						ON genres.id = genres_books.id_genre 
					INNER JOIN books 
						ON genres_books.id_book = books.id 
					INNER JOIN authors_books 
						ON books.id = authors_books.id_book 
					INNER JOIN authors 
						ON authors_books.id_author = authors.id
					INNER JOIN descriptions
						ON books.id = descriptions.id_book
				WHERE books.id = '$id_book'";
			
			$result = $db->query($query);
			
			foreach($result as $row)
			{
				$authors[$row['id_author']] = $row['author'];
				$genres[$row['id_genre']] = $row['genre'];
				$name = $row['name'];
				$price = $row['price'];
				$description = $row['description'];
			}

			$authors = array_unique($authors);
			$genres = array_unique($genres);
			
			$book = array('authors' => $authors,'genres' => $genres,'name' => $name,
				'description' => $description,'price' => $price);

			return $book;
		}
	}
?>