<?php

	namespace Views\Pallets;

	class LogoutPallet
	{
		/**
		 * redirect to index
		 */
		public function generate()
		{
			header('Location: ' . BASE_URL);
		}
	}