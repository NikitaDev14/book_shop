<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 05.04.2015
 * Time: 11:08
 */

	namespace Views\Pallets;

	class LogoutPallet
	{
		public function generate()
		{
			header('Location: ' . BASE_URL);
		}
	}