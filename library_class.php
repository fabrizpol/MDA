<?php

	//classe che effettua una connessione tramite pdo ad un database
	class connessioneDB
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
						echo "connesso" ."<br/>";

					}
				catch (PDOException $e) {
					echo " errore: " .$e->getMessage() ."<br/>";
				}

			}
		}
		
		// estendo la classe connessioneDB con una libro che eredita la variabile pdo
		
		class libro_DBlibrary extends connessioneDB {


			private $titolo;	// titolo libro
			private $categoria;	// categoria libro

			public function __construct () {
				parent:: __construct('localhost','root','root','DB_library');
			}

			public function ins_books (){
				try {
						if (isset($this->titolo) && isset($this->categoria))
						{
							$insert = "INSERT INTO books (title, category, created_at) VALUES ('$this->titolo', '$this->categoria', NOW())";
							$sth = $this->pdo->prepare($insert);
							return $sth->execute();
						}
						else {
							echo "Inserisci titolo e categoria!<br/><a href='library_insert_form.php>Indietro</a>'";
						}
					}
				catch (PDOException $e) {
					echo " errore: " .$e->getMessage() ."<br/>";
				}

			}

			public function setTitle ($t)
			{
				$this->titolo = $t;
			}

			public function setCategory($c)
			{
				$this->categoria = $c;
			}

			public function getTitle()
			{
				return $this->titolo;
			}

			public function getCategory ()
			{
				return $this->categoria;
			}


		}
		
		class categories_DBlibrary extends connessioneDB {
			
			private $name;
			
			public function __construct(){
				parent:: __construct('localhost','root','root','DB_library');
			}
			
			public function ins_category (){
				try {
						if (isset($this->$name))
						{
							$insert = "INSERT INTO categories (name) VALUES ('$this->name')";
							$sth = $this->pdo->prepare($insert);
							return $sth->execute();
						}
						else {
							echo "Inserisci il nome della categoria categoria!<br/>";
						}
					}
				catch (PDOException $e) {
					echo " errore: " .$e->getMessage() ."<br/>";
				}

			}
			
			public function setName ($n)
			{
				$this->name = $n;
			}
			
			public function getName ()
			{
				return $this->name;
			}
		}
?>