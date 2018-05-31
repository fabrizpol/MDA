<?php
		header('Content-Type: application/json');
		
		include ("library_class.php");
		$catg = (int)$_GET['category']; //ricevo in post la categoria richiesta

		$dbh = new connessioneDB('localhost', 'root','root','DB_library');	//mi connetto al db

		//provo a selezionare la categoria richiesta
		try {
					$sel = "SELECT id,title,category,DATE_FORMAT(created_at, '%d-%m-%Y %H:%i:%s')  as data_creazione FROM books WHERE category='$catg'";
					$sth = $dbh->pdo->prepare($sel);
					$sth->execute();
			}
		catch (PDOException $e) {
			echo " errore: " .$e->getMessage();
		}


		$result = $sth->fetchAll();	 // memorizzo il risultato della query in un array

		echo json_encode($result, JSON_PRETTY_PRINT);	//stampo il json del risultato della query formattato
?>