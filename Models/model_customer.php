<?php
	namespace Customer;

	class Model_customer extends \Core\Model {
		
		public function get_email($path)
		{
			return parent::get_email($path);
		}
		public function select_item($field, $cond = null)
		{
			return parent::select_item($field, $cond);
		}
		private function make_cond($cond, $name)
		{
			$where = "(";
			$i = 0;
			
			foreach($cond as $item)
			{
				if($i)
				{	
					$where .= " OR ";
				}
				
				$where .= $name.'s'."_books.id_".$name." = ".(int)$item;
				
				$i++;
			}
			
			$where .= ")";
			
			return $where;
		}
		public function select_book($cond = null)
		{
			if(is_array($cond) && !empty($cond))
			{
				$where = " WHERE ";
				
				if(isset($cond['authors']))
				{
					$where .= $this->make_cond($cond['authors'], 'author');
				}
				if(isset($cond['genres']))
				{
					if(strlen($where) > 8) { $where .= " AND "; }
					
					$where .= $this->make_cond($cond['genres'], 'genre');
				}
				
				$query = "SELECT books.id
					FROM genres_books
						INNER JOIN books
							ON genres_books.id_book = books.id
						INNER JOIN authors_books
							ON books.id = authors_books.id_book";
			
				$query .= $where;
				$db = $this->connection();
				$result = $db->query($query);
				
				$cond = array();
				
				foreach($result as $row)
				{
					$cond[] = (int)$row['id'];
				}
				
				$cond = array_unique($cond);
				
				if(empty($cond)) { return "Отсутствуют книги с заданными параметрами."; }
			}
			
			return parent::select_book($cond);
		}
		public function select_book_det($id_book)
		{
			return parent::select_book_id($id_book);
		}
		public function order($id_book, $addres, $customer, $number)
		{
			$email = get_email('admin/email.txt');
			$book = $this->select_book($id_book);
			$book = implode($book);

			$subject = "Новый заказ из книжного каталога";
			$message = "$book<br/>Заказчик: $customer<br/>Адрес: $addres<br/>Экземпляров: $number";
			
			$result = mail($email, $subject, $message);
			
			if($result)
			{
				return "Ваш заказ оформлен";
			}
			else
			{
				return "Ошибка";
			}
		}
	}
?>