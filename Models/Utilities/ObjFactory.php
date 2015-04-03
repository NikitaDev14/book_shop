<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 03.04.2015
 * Time: 11:27
 */

	namespace Models\Utilities;

	class ObjFactory
	{
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

		public function getBook()
		{
			return new \Models\Performers\Book();
		}
		public function getAuthor()
		{
			return new \Models\Performers\Author();
		}
		public function getGenre()
		{
			return new \Models\Performers\Genre();
		}
		public function getUser()
		{
			return new \Models\Performers\User();
		}
	}