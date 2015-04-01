<?php
	class Controller_Update extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function action_author()
		{
			$data = $this->model->select_item('author');
			$_POST['result'] = $data;
			$this->view->form('view_update_author.php');
		}
		function action_genre()
		{
			$data = $this->model->select_item('genre');
			$_POST['result'] = $data;
			$this->view->form('view_update_genre.php');
		}
		function action_book()
		{
			$data = $this->model->select_book();

			$_POST['result'] = $data;
			
			$this->view->form('view_update_book.php');
		}
	}
?>