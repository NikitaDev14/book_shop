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
			return $_COOKIE[$name];
		}
		public function deleteCookie($name)
		{
			setcookie($name, '', time() - $this->expire);

			return $this;
		}
	}