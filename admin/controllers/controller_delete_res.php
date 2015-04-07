<?php
	class Controller_delete_res extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function get_cond()
		{
			$id = $_POST['item'];
			$cond = array();
			
			foreach($id as $i)
			{
				$cond[] = (int)$i;
			}
			
			return $cond;
		}
		function action_author()
		{
			$data = $this->model->delete_item('author',$this->get_cond());
			$this->view->message($data);
		}
		function action_genre()
		{
			$data = $this->model->delete_item('genre',$this->get_cond());
			$this->view->message($data);
		}
		function action_book()
		{
			$this->get_cond();
			$data = $this->model->delete_book($this->get_cond());
			$this->view->message($data);
		}
	}
?>