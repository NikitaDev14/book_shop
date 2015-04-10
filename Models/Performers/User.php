<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 03.04.2015
 * Time: 11:10
 */

	namespace Models\Performers;

	class User extends \Models\BaseModel
	{
		public function addUser($email, $password)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL addUser(?, ?)')->
				setParam([$email, $password])->
				execute()->getResult();
		}
		public function exsistsUser($email)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL exsistsUser(?)')->
				setParam([$email])->execute()->getResult();
		}
		public function isValidLogin($email, $password)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL isValidLogin(?, ?)')->
				setParam([$email, $password])->
				execute()->getResult();
		}
		public function sessionStart($idUser, $sessionId)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL sessionStart(?, ?)')->
				setParam([$idUser, $sessionId])->
				execute()->getResult();
		}
		public function isValidUser($idUser, $sessionId)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL isValidUser(?, ?)')->
				setParam([$idUser, $sessionId])->
				execute()->getResult();
		}
		public function sessionDestroy($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL sessionDestroy(?)')->
				setParam([$idUser])->execute()->getResult();
		}
	}