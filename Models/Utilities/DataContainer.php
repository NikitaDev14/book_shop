<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 17:07
	 */

	namespace Models\Utilities;

	class DataContainer
	{
		private static $instance;

		private $params;

		private function __construct() {}

		public static function getInstance()
		{
			if (null === self::$instance) {
				self::$instance = new DataContainer();
			}

			return self::$instance;
		}

		public function getParams()
		{
			return $this->params;
		}

		public function setParams($params)
		{
			foreach($params as $key => $val)
			{
				$this->params[$key] = $val;
			}

			return self::$instance;
		}
	}