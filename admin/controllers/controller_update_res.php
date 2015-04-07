<?php
	class Controller_update_res extends Controller {

		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function action_author()
		{
			$id = $_POST['id_item'];
			$data = $this->model->update_item('author', $id);
			$this->view->message($data);
		}
		function action_genre()
		{
			$id = $_POST['id_item'];
			$data = $this->model->update_item('genre', $id);
			$this->view->message($data);
		}
		function action_book()
		{	
			$authors = $_POST['author'];
			$genres = $_POST['genre'];
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$id_book = $_POST['id_item'];
			
			$data = $this->model->update_book($authors, $genres, $name, $description, $price, $id_book);
			
			$this->view->message($data);
		}
	}
?>