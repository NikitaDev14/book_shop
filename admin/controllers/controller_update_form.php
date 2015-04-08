<?php
	class Controller_update_form extends Controller {

		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function get_checkbox($catalogue, $book, $param)
		{
			$checkbox = null;
			
			foreach($catalogue as $item)
			{
				$isChecked = false;
				
				foreach($book[$param.'s'] as $key => $b)
				{
					if($key==$item['id' . $param])
					{
						$isChecked = true;
						
						break;
					}
				}
				if($isChecked)
				{
					$checkbox .= "</br><label><input type='checkbox' name=".$param.'[]'."
						value= '".$item['id' . $param]."' checked/>".$item['Name'].'</label>';
				}
				else
				{
					$checkbox .= "</br><label><input type='checkbox' name=".$param.'[]'."
						value= '".$item['id' . $param]."' />".$item['Name'].'</label>';
				}
			}
			
			return $checkbox;
		}
		function action_author()
		{
			$id = $_POST['id_item'];
			$data = $this->model->select_item('Author', $id);
			
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

			$authors = $this->model->select_item('Author', 0);
			$genres = $this->model->select_item('Genre', 0);
			
			$authors = $this->get_checkbox($authors, $book, 'Author');
			$genres = $this->get_checkbox($genres, $book, 'Genre');
			
			$_POST['book'] = $book;
			$_POST['authors'] = $authors;
			$_POST['genres'] = $genres;
			
			$this->view->form('view_update_form_book.php');
		}
	}
?>