<?php
	class Controller_user extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		public function action_list()
		{
			$data = $this->model->getAllUsers();

			$_POST['result'] = $data;

			$this->view->form('view_update_user.php');
		}
		public function action_discount()
		{
			$data = $this->model->getAllDiscounts();

			$_POST['result'] = $data;

			$this->view->form('view_update_discount.php');
		}
		/*
		function action_author()
		{
			$data = $this->model->select_item('Author', 0);
			$_POST['result'] = $data;
			$this->view->form('view_delete_author.php');
		}
		function action_genre()
		{
			$data = $this->model->select_item('Genre');
			$_POST['result'] = $data;
			$this->view->form('view_delete_genre.php');
		}
		function action_book()
		{
			$data = $this->model->select_book();
			$_POST['result'] = $data;
			$this->view->form('view_delete_book.php');
		}
		*/
	}
?>