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

		public function __construct($dbNameHost, $dbUser, $dbPass)
		{
			$this->db = new \PDO($dbNameHost, $dbUser, $dbPass);
		}

		public function setQuery($query)
		{
			$this->sth = $this->db->prepare($query);

			return $this;
		}

		public function setParam($params)
		{
			$count = count($params);

			for ($i = 0; $i < $count; $i++) {
				$this->sth->bindParam($i, $params[$i]);
			}

			return $this;
		}

		public function execute()
		{
			$this->sth->execute();

			return $this->sth->fetchAll();
		}

		public function __destruct()
		{
			$this->db = null;
		}
	}