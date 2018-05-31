<!DOCTYPE html>
<html>
<head>
	<title>Dati inviati</title>
</head>
<body>
	<h1>
		I tuoi dati sono stati inviati con successo!
	</h1>
	<?php
		include ("library_class.php");
		$titolo = addslashes((string)$_POST['titolo']);
		//echo "<br/>".$titolo;
		$category = (int)$_POST['category'];
		//echo "<br/>" .$category;
		$libro = new libro_DBlibrary();
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
						// adatto il menu html facendo una select sulla tabella categorie
						try { 			// creo la connessione
								$dsn = "mysql:host=localhost;dbname=DB_library;";
								$opt =  [
			   								PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			   								PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			   								PDO::ATTR_EMULATE_PREPARES   => false,
										];
								$pdo = new PDO($dsn, 'root', 'root', $opt);
							}
						catch (PDOException $e) 
							{
								echo " errore: " .$e->getMessage();
							}

						try { 		//eseguo la select su tabella categorie
								$sel = "SELECT * FROM categories";
								$sth = $pdo->prepare($sel);
								$sth->execute();
							}
						catch (PDOException $e) 
							{
							echo " errore: " .$e->getMessage();
							}


						$result = $sth->fetchAll(); // 
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