<?php 
session_start();
require 'sql.php';
require 'functions.php';

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
	if ($_POST) {
		// VAR
		$name = $_POST["name"];
		$difficulty = $_POST["difficulty"];
		$distance = $_POST["distance"];
		$duration = $_POST["duration"];
		$height_difference = $_POST["height_difference"];
		if (isset($_POST["available"])) {
			$available = 1;
		} else {
			$available = 0;	
		}
		//INSERT INTO DB
		//print_r($_POST);
		$insert = $pdo->prepare("
			INSERT INTO hiking (name, difficulty, distance, duration, height_difference, available) 
			VALUES (:name, :difficulty, :distance, :duration, :height_difference, :available)
			");
		$insert->bindValue(':name', $name);
		$insert->bindValue(':difficulty', $difficulty);
		$insert->bindValue(':distance', $distance);
		$insert->bindValue(':duration', $duration);
		$insert->bindValue(':height_difference', $height_difference);
		$insert->bindValue(':available', $available);

		try {
			$insert->execute();
		} catch (PDOException $e) {
		    if ($e->getCode() == 1062) {
		        // Take some action if there is a key constraint violation, i.e. duplicate name
		    } else {
		        throw $e;
		    }
		}
		header('Location: read.php?status=success');
	}
}
else {
	header('Location: read.php?status=notenoughpermissions');
}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ajouter une randonnée</title>
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
 	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
	<?php include "includes/navbar.php" ?>
	<h1>Ajouter</h1>
	<form action="" method="post">
		<div>
			<label for="name">Name</label>
			<input type="text" name="name" value="">
		</div>
		<div>
			<label for="difficulty">Difficulté</label>
			<select name="difficulty">
				<option value="très facile">Très facile</option>
				<option value="facile">Facile</option>
				<option value="moyen">Moyen</option>
				<option value="difficile">Difficile</option>
				<option value="très difficile">Très difficile</option>
			</select>
		</div>

		<div>
			<label for="distance">Distance</label>
			<input type="text" name="distance" value="">
		</div>
		<div>
			<label for="duration">Durée</label>
			<input type="time" name="duration" value="">
		</div>
		<div>
			<label for="height_difference">Dénivelé</label>
			<input type="text" name="height_difference" value="">
		</div>
		<div>
			<label for="available">Disponible</label>
			<input type="checkbox" name="available" checked>
		</div>
		<button type="submit" name="button">Envoyer</button>
	</form>
</body>
</html>