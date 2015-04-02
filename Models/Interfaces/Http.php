<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 02.04.2015
 * Time: 23:32
 */

	namespace Models\Interfaces;

	class Http
	{
		private static $instance;

		private $params;

		private function __construct() {}

		public static function getInstance()
		{
			if(null === self::$instance)
			{
				self::$instance = new Http();
			}

			return self::$instance;
		}

		public function setParams($params)
		{
			foreach($params as $key => $val)
			{
				$this->params[$key] = $val;
			}

			return self::$instance;
		}

		public function getParams()
		{
			return $this->params;
		}
	}