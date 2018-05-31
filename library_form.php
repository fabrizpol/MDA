<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inserisci un libro nel database</title>
</head>
<body>
	<h1>
		Inserisci un libro nel database<br/>
	</h1>
	<form action="library_insert.php" method="post" target="_blank">
			<fieldset>
				<legend> Dati del libro </legend>
				<b>Titolo: </b><br/>
				<input id="titolo" name="titolo" type="text" placeholder="Inserisci il titolo" required autofocus>
				<br/>
				<b>Categoria: </b><br/>
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
				<input type="reset" value="Cancella">
			</filedset>
	</form>
</body>
</html>