<?php

	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 13.04.2015
	 * Time: 19:22
	 */
	class BaseRegular extends \BaseSingleton
	{
		/**
		 * change access modificator protected->public
		 */
		public function __construct()
		{
			parent::__construct();
		}
	}