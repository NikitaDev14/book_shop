<?php
	class Controller_add_res extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
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