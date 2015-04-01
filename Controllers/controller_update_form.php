<?php
	class Controller_update_form extends Controller {

		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function get_checkbox($catalogue,$book,$param)
		{
			$checkbox = null;
			$i = 0;
			
			foreach($catalogue as $item)
			{
				$isChecked = false;
				
				foreach($book[$param.'s'] as $b)
				{
					if($b==$item['id'])
					{
						$isChecked = true;
						
						break;
					}
				}
				if($isChecked)
				{
					$checkbox .= "<br/><input type='checkbox' name=".$param.'[]'."
						value=".$item['id']." checked/>".$item[$param];
				}
				else
				{
					$checkbox .= "<br/><input type='checkbox' name=".$param.'[]'."
						value=".$item['id']."/>".$item[$param];
				}
				
				$i++;
			}
			
			return $checkbox;
		}
		function action_author()
		{
			$id = $_POST['id_item'];
			$data = $this->model->select_item('author', $id);
			
			$_POST['result'] = $data;
			$this->view->form('view_update_form_author.php');
		}
		function action_genre()
		{
			$id = $_POST['id_item'];
			$data = $this->model->select_item('genre', $id);
			
			$_POST['result'] = $data;
			$this->view->form('view_update_form_genre.php');
		}
		function action_book()
		{
			$id = $_POST['id_item'];
			$book = $this->model->select_book_id($id);
			
			$authors = $this->model->select_item('author');
			$genres = $this->model->select_item('genre');
			
			$authors = $this->get_checkbox($authors, $book, 'author');
			$genres = $this->get_checkbox($genres, $book, 'genre');
			
			$_POST['book'] = $book;
			$_POST['authors'] = $authors;
			$_POST['genres'] = $genres;
			
			$this->view->form('view_update_form_book.php');
		}
	}
?>