<?php

	namespace Models\Utilities;

	/**
	 * make objects with set parameters
	 */
	class ObjFactory
	{
		private static $database;
		private static $instance;

		private function __construct() {}

		public static function getInstance()
		{
			if(null === self::$instance)
			{
				self::$instance = new ObjFactory();
			}

			return self::$instance;
		}
		public function getObjDatabase()
		{
			if(null === self::$database)
			{
				self::$database = new \Models\Interfaces\Database(
					DB_NAME, DB_HOST, DB_USER, DB_PASS);
			}

			return self::$database;
		}
		public function getObjDataContainer()
		{
			return \Models\Utilities\DataContainer::getInstance();
		}
		public function getObjValidatorSignup()
		{
			return \Models\Validators\ValidatorSignup::getInstance();
		}
		public function getObjValidatorLogin()
		{
			return \Models\Validators\ValidatorLogin::getInstance();
		}
		public function getObjValidatorUser()
		{
			return \Models\Validators\ValidatorUser::getInstance();
		}
		public function getObjHttp()
		{
			return \Models\Interfaces\Http::getInstance();
		}
		public function getObjSession()
		{
			return \Models\Interfaces\Session::getInstance();
		}
		public function getObjCookie()
		{
			return new \Models\Interfaces\Cookie(COOKIE_EXPIRE);
		}
		public function getObjBook()
		{
			return new \Models\Performers\Book();
		}
		public function getObjAuthor()
		{
			return new \Models\Performers\Author();
		}
		public function getObjGenre()
		{
			return new \Models\Performers\Genre();
		}
		public function getObjUser()
		{
			return new \Models\Performers\User();
		}
		public function getObjCart()
		{
			return new \Models\Performers\Cart();
		}
		public function getObjOrder()
		{
			return new \Models\Performers\Order();
		}
	}