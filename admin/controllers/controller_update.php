<?php
	class Controller_Update extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function action_author()
		{
			$data = $this->model->select_item('Author', 0);
			$_POST['result'] = $data;
			$this->view->form('view_update_author.php');
		}
		function action_genre()
		{
			$data = $this->model->select_item('Genre', 0);
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