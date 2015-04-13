<?php

	namespace Models\Performers;

	class User extends \BaseRegular
	{
		/**
		 * @param $email
		 * @param $password
		 * add new email and password
		 * @return (LAST_INSERT_ID())
		 */
		public function addUser($email, $password)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL addUser(?, ?)')->
				setParam([$email, $password])->
				execute()->getResult();
		}

		/**
		 * @param $email
		 * @return if $email is set true
		 * false otherwise
		 */
		public function exsistsUser($email)
		{
			return (bool) $this->objFactory->getObjDatabase()->
				setQuery('CALL exsistsUser(?)')->
				setParam([$email])->execute()->getResult();
		}

		/**
		 * @param $email
		 * @param $password
		 * check existing pair $email and $password
		 * @return (idUser)
		 */
		public function isValidLogin($email, $password)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL isValidLogin(?, ?)')->
				setParam([$email, $password])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * @param $sessionId
		 * set new session for specified user
		 * @return (ROW_COUNT())
		 */
		public function sessionStart($idUser, $sessionId)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL sessionStart(?, ?)')->
				setParam([$idUser, $sessionId])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * @param $sessionId
		 * check session of specified user
		 * @return (idUser, SessionId)
		 */
		public function isValidUser($idUser, $sessionId)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL isValidUser(?, ?)')->
				setParam([$idUser, $sessionId])->
				execute()->getResult();
		}

		/**
		 * @param $idUser
		 * stop session of specified user
		 * @return (ROW_COUNT())
		 */
		public function sessionDestroy($idUser)
		{
			return $this->objFactory->getObjDatabase()->
				setQuery('CALL sessionDestroy(?)')->
				setParam([$idUser])->execute()->getResult();
		}
	}