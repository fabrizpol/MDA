<?php
		header('Content-Type: application/json');
			
		class connessione
		{
			private $dbname;
			private $pwd;
			private $user;
			private $host;
			public $pdo;

			public function __construct ($host, $user, $pwd, $dbname){
				$this->dbname = $dbname;
				$this->pwd = $pwd;
				$this->user = $user;
				$this->host = $host;
				$this->getInstance();
			}

			private function getInstance(){
				try {
						$dsn = "mysql:host=$this->host;dbname=$this->dbname;";
						$opt = [
   									PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    								PDO::ATTR_EMULATE_PREPARES   => false,
								];
						return $this->pdo = new PDO($dsn, $this->user, $this->pwd, $opt);
						echo "connesso";

					}
				catch (PDOException $e) {
					echo " errore: " .$e->getMessage();
				}

			}
		}
		$catg = (int)$_GET['category'];

		$dbh = new connessione('localhost', 'root','root','DB_library');

		try {
					$sel = "SELECT id,title,category,DATE_FORMAT(created_at, '%d-%m-%Y %H:%i:%s')  as data FROM books WHERE category='$catg'";
					$sth = $dbh->pdo->prepare($sel);
					$sth->execute();
			}
		catch (PDOException $e) {
			echo " errore: " .$e->getMessage();
		}


		$result = $sth->fetchAll();

		echo json_encode($result, JSON_PRETTY_PRINT);