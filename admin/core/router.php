<?php
	class Router
	{
		static function start()
		{
			$controller_name = 'main';
			$action_name = 'index';
			
			$routes = explode('/', $_SERVER['REQUEST_URI']);

			if ( !empty($routes[6]) )
			{	
				$controller_name = $routes[6];
			}
			
			if ( !empty($routes[7]) )
			{
				$action_name = $routes[7];
			}
			
			if ( !empty($routes[8]) )
			{
				$_POST['id_item'] = substr($routes[8],3);
			}

			$model_name = 'Model_admin';
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
				Router::ErrorPage404();
			}
			
			$controller = new $controller_name;
			$action = $action_name;
			
			if(method_exists($controller, $action))
			{
				$controller->$action();
			}
			else
			{
				Router::ErrorPage404();
			}
		}
		function ErrorPage404()
		{
			$host = 'http://'.$_SERVER['HTTP_HOST'].'/';
			header('HTTP/1.1 404 Not Found');
			header("Status: 404 Not Found");
			header('Location:'.$host.'404');
		}
	}
?>
