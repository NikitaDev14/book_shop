<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 19:40
 */

	namespace Models\Interfaces;

	class Session
	{
		private static $instance;

		private function __construct()
		{
			session_start();
		}

		public static function getInstance()
		{
			if(null === self::$instance)
			{
				self::$instance = new Session();
			}

			return self::$instance;
		}
		public function getSessionId()
		{
			return session_id();
		}

		public function __destruct()
		{
			session_destroy();
		}
	}