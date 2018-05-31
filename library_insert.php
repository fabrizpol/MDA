<!DOCTYPE html>
<html>
<head>
	<title>Dati inviati</title>
</head>
<body>
	<h1>
		I tuoi dati sono stati inviati
	</h1>
	<?php
		
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
						echo "connesso" ."<br/>";

					}
				catch (PDOException $e) {
					echo " errore: " .$e->getMessage() ."<br/>";
				}

			}



		}

		class libro extends connessione {


			private $titolo;
			private $categoria;

			public function __construct () {
				parent:: __construct('localhost','root','root','DB_library');
			}

			public function ins_books (){
				try {
					$insert = "INSERT INTO books (title, category, created_at) VALUES ('$this->titolo', '$this->categoria', NOW())";
					$sth = $this->pdo->prepare($insert);
					return $sth->execute();
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

			public function getTitle($t)
			{
				return $this->titolo;
			}

			public function getCategory ($c)
			{
				return $this->categoria;
			}


		}
		$titolo = (string)$_POST['titolo'];
		echo "<br/>".$titolo;
		$category = (int)$_POST['category'];
		echo "<br/>" .$category;
		$libro = new libro();
		$libro->setTitle($titolo);
		$libro->setCategory($category);
		echo "<br/><pre>";
		print_r($libro);
		echo "</pre>";

		$ins=$libro->ins_books();
		$libro=NULL;

	?>
	<div>
		<form action="library_json.php" method="get" target="_blank">
			<b> Seleziona la categoria che vuoi visualizzare </b><br/>
			<select name="category">
					<?php

						try {
								$dsn = "mysql:host=localhost;dbname=DB_library;";
								$opt = [
			   								PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			   								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			   								PDO::ATTR_EMULATE_PREPARES   => false,
										];
								$pdo = new PDO($dsn, 'root', 'root', $opt);
								//echo "connesso";

							}
							catch (PDOException $e) {
								echo " errore: " .$e->getMessage();
								}

						try {
									$sel = "SELECT * FROM categories";
									$sth = $pdo->prepare($sel);
									$sth->execute();
							}
						catch (PDOException $e) {
							echo " errore: " .$e->getMessage();
						}


						$result = $sth->fetchAll();
						foreach ($result as $value)
						{
							echo "<option value=" .$value['id'] .">" .$value['name'] ."</option>";
						}
					?>
				</select><br/><br/>
					<input type="submit" value="Invia dati">	
		</form>
	</div>
	

</body>
</html>