<?php
	namespace Controllers;

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
			$controllerName = 'Index';
			$actionName = 'index';

			$view = new \Views\View();

			$form = false;

			if(!empty($_GET['controller']))
			{
				$controllerName = $_GET['controller'];
				$actionName = $_GET['action'];

				$form = $_GET;
			}
			elseif(!empty($_POST['controller']))
			{
				$controllerName = $_POST['controller'];
				$actionName = $_POST['action'];

				$form = $_POST;
			}

			$controllerPath = '\Controllers\Controller' . $controllerName;

			$controllerObj = new $controllerPath($form);

			$controllerObj->$actionName();

			$view->render();
		}
	}