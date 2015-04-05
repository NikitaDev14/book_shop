<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 04.04.2015
 * Time: 19:40
 */

	namespace Models\Interfaces;

	class Cookie
	{
		private $expire;

		public function __construct($expire)
		{
			$this->expire = $expire;
		}
		public function setCookie($name, $value)
		{
			setcookie($name, $value, time() + $this->expire);

			return $this;
		}
		public function getCookie($name)
		{
			if(!empty($_COOKIE[$name]))
			{
				$result = $_COOKIE[$name];
			}
			else
			{
				$result = false;
			}

			return $result;
		}
		public function deleteCookie($name)
		{
			setcookie($name, '', time() - $this->expire);

			return $this;
		}
	}