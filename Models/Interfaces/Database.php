<?php
	/**
	 * Created by PhpStorm.
	 * User: Developer
	 * Date: 01.04.2015
	 * Time: 18:43
	 */

	namespace Models\Interfaces;

	class Database
	{
		private $db;
		private $sth;

		public function __construct()
		{
			$this->db = new \PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, DB_USER, DB_PASS);
		}

		public function setQuery($query)
		{
			$this->sth = $this->db->prepare($query);

			return $this;
		}

		public function setParam($params)
		{
			/*
			$count = count($params);

			for ($i = 0; $i < $count; $i++) {
				$this->sth->bindParam($i, $params[$i]);
			}
			*/
			foreach($params as $param)
			{
				$this->sth->bindParam(key($params), $param);
			}

			return $this;
		}

		public function execute()
		{
			$this->sth->execute();

			return $this;
		}

		/**
		 * @return mixed
		 */
		public function getResult()
		{
			return $this->sth->fetchAll();
		}

		public function __destruct()
		{
			$this->db = null;
		}
	}