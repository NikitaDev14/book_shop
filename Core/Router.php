<?php
	namespace Core;

	class Router
	{
		private static $instance;

		private function __construct() {}

		public static function getInstance()
		{
			if(null === self::$instance)
			{
				self::$instance = new Router();
			}

			return self::$instance;
		}
		public function start()
		{
			/*
			$controller_name = 'Index';
			$action_name = 'index';

			$routes = explode('/', $_SERVER['REQUEST_URI']);

			if (!empty($routes[2]))
			{
				$action_name = $routes[2];
			}

			if (!empty($routes[3]))
			{
				$_POST['id_item'] = substr($routes[3],3);
			}

			$model_name = 'Model_customer';
			$controller_name = 'Controller_'.$controller_name;
			$action_name = 'action_'.$action_name;

			$model_file = strtolower($model_name).'.php';
			$model_path = "models/".$model_file;

			if(file_exists($model_path))
			{
				include "models/".$model_file;
			}

			$controller_file = strtolower($controller_name).'.php';
			$controller_path = "controllers/".$controller_file;

			if(file_exists($controller_path))
			{
				include "controllers/".$controller_file;
			}
			else
			{
				include "controllers/controller_main.php";
			}

			$controller = new $controller_name;
			$action = $action_name;

			if(method_exists($controller, $action))
			{
				$controller->$action();
			}
			else
			{
				$controller->action_index();
			}
			*/

			$a = new \Controllers\ControllerIndex();
			$b = new \Views\View();

			if(!empty($_GET['action']))
			{
				$a->actionBookList();
			}
			elseif(!empty($_POST['action']))
			{
				$a = new \Controllers\ControllerSignup();

				$a->actionSignup($_POST);
			}
			else
			{
				$a->actionIndex();
			}

			$b->render();
		}
	}