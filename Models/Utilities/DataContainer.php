<?php

	namespace Models\Utilities;

	/**
	 * this is link between controller and view
	 * controller push data here
	 * view pull data here
	 */
	class DataContainer
	{
		private static $instance;

		private $params; // data set by controller

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