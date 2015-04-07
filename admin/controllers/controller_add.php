<?php
	class Controller_add extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function action_author()
		{
			$this->view->form('view_add_author.php');
		}
		function action_genre()
		{
			$this->view->form('view_add_genre.php');
		}
		function action_book()
		{	
			$data = $this->model->select_item('author');
			$_POST['authors'] = $data;
			
			$data = $this->model->select_item('genre');
			$_POST['genres'] = $data;
			
			$this->view->form('view_add_book.php');
		}
	}
?>