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
			$data = $this->model->update_item('Author', $id);
			$this->view->message($data);
		}
		function action_genre()
		{
			$id = $_POST['id_item'];
			$data = $this->model->update_item('Genre', $id);
			$this->view->message($data);
		}
		function action_book()
		{	
			$authors = $_POST['Author'];
			$genres = $_POST['Genre'];
			$name = $_POST['name'];
			$description = $_POST['description'];
			$price = $_POST['price'];
			$id_book = $_POST['id_item'];
			$image = $_POST['image'];
			
			$data = $this->model->update_book($authors, $genres, $name, $description, $price, $id_book, $image);
			
			$this->view->message($data);
		}
		public function action_user()
		{
			$id_user = $_POST['id_item'];
			$discount = $_POST['discount'];

			$data = $this->model->updateUser($id_user, $discount);

			$this->view->message($data);
		}
		public function action_discount()
		{
			$id_discount = $_POST['id_item'];
			$discount = $_POST['discount'];

			$data = $this->model->updateDiscount($id_discount, $discount);

			$this->view->message($data);
		}
	}
?>