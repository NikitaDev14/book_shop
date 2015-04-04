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
			setcookie($name, $value, $this->expire);

			return $this;
		}
	}