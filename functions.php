<?php
	/**
	 * @param $className
	 */
	function __autoload($className)
	{
		/*
		$arr = explode('\\', $className);
		$path = '';

		foreach($arr as $item)
		{
			$path .= $item . '/';
		}

		$path = substr($path, 0, strlen($path)-1);

		require_once $path . '.php';
		*/
		require_once str_replace('\\', '/', $className . '.php');
	}