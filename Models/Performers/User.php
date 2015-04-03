<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 03.04.2015
 * Time: 11:10
 */

	namespace Models\Performers;

	class User extends \Models\Model
	{
		public function addUser($email, $password)
		{
			return $this->database->setQuery('CALL addUser(:email, :password')->
				setParam([':email' => $email, ':password' => $password])->execute()->getResult();
		}
	}