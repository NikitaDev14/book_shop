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

		private $nextPage;

		private function __construct()
		{
		}

		public static function getInstance()
		{
			if (null === self::$instance) {
				self::$instance = new DataContainer();
			}

			return self::$instance;
		}

		public function getNextPage()
		{
			return $this->nextPage;
		}

		public function setNextPage($nextPage)
		{
			$this->nextPage = $nextPage;

			return self::$instance;
		}
	}