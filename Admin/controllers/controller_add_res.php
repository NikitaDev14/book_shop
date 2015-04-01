<?php
	class Controller_add_res extends Controller
	{
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin(DB_HOST, DB_NAME, DB_USER, DB_PASS);
		}
		function action_author()
		{
			$data = $this->model->add_item('author');
			$this->view->message($data);
		}
		function action_genre()
		{
			$data = $this->model->add_item('genre');
			$this->view->message($data);
		}
		function action_book()
		{
			$data = $this->model->add_book();
			$this->view->message($data);
		}
	}
?>