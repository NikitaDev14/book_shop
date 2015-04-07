<?php
	class Controller_main extends Controller {
		
		function __construct()
		{
			$this->view = new View();
			$this->model = new Model_admin();
		}
		function action_index()
		{
			$this->view->message();
		}
		function action_email()
		{
			$data = $this->model->get_email('email.txt');
			$_POST['email'] = $data;
			
			$this->view->form('view_admin_email.php');
		}
		function action_save_email()
		{
			$email = $_POST['email'];
			
			if(!empty($email))
			{
				$this->model->set_email($email);
				$this->view->message();
			}
			else
			{
				$this->view->message('Поле не может быть пустым!');
			}
			
		}
	}
?>