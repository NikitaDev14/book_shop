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
			//echo $email . ' ; ' . $password . '</br>';

			return $this->objFactory->getObjDatabase()->
				setQuery('CALL addUser(?, ?)')->
				setParam([$email, $password])->
				execute()->getResult();
		}
		public function exsistsUser($email)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL exsistsUser(?)')->
				setParam([$email])->
				execute()->getResult();
		}
	}