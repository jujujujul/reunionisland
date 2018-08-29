<?php 
session_start();
require 'sql.php'; 
require 'functions.php';

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
	$connect = $pdo->prepare('SELECT * FROM hiking WHERE id = ?');
	$connect->execute(array($_GET['id']));
	$item = $connect->fetch();
	if ($_POST) {
		// VAR
		$name = $_POST["name"];
		$difficulty = $_POST["difficulty"];
		$distance = $_POST["distance"];
		$duration = $_POST["duration"];
		$height_difference = $_POST["height_difference"];
		$id = $_GET['id'];
		if (isset($_POST["available"])) {
			$available = 1;
		} else {
			$available = 0;	
		}

		//INSERT INTO DB
		//print_r($_POST);
		$insert = $pdo->prepare("
			UPDATE hiking
			SET name = :name, difficulty = :difficulty, distance = :distance, duration = :duration, height_difference = :height_difference, available = :available WHERE id = :id
			");
		$insert->bindValue(':name', $name);
		$insert->bindValue(':difficulty', $difficulty);
		$insert->bindValue(':distance', $distance);
		$insert->bindValue(':duration', $duration);
		$insert->bindValue(':height_difference', $height_difference);
		$insert->bindValue(':available', $available);
		$insert->bindValue(':id', $id);

		try {
			$insert->execute();
		} catch (PDOException $e) {
		    if ($e->getCode() == 1062) {
		        // Take some action if there is a key constraint violation, i.e. duplicate name
		    } else {
		        throw $e;
		    }
		}
		header('Location: read.php');
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
	<title>Modifier une randonnée</title>
	<link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<?php include "includes/navbar.php" ?>
	<h1>Modifier</h1>
	<form action="" method="post">
		<div>
			<label for="name">Name</label>
			<input type="text" name="name" value="<?php echo $item["name"]; ?>">
		</div>

		<div>
			<label for="difficulty">Difficulté</label>
			<select name="difficulty">
				<option value="très facile" <?php echo isTheSame("Très facile", $item["difficulty"]) ?>>Très facile</option>
				<option value="facile" <?php echo isTheSame("Facile", $item["difficulty"]) ?>>Facile</option>
				<option value="moyen" <?php echo isTheSame("Moyen", $item["difficulty"]) ?>>Moyen</option>
				<option value="difficile" <?php echo isTheSame("Difficile", $item["difficulty"]) ?>>Difficile</option>
				<option value="très difficile" <?php echo isTheSame("Très difficile", $item["difficulty"]) ?>>Très difficile</option>
			</select>
		</div>
		
		<div>
			<label for="distance">Distance</label>
			<input type="text" name="distance" value="<?php echo $item["distance"]; ?>">
		</div>
		<div>
			<label for="duration">Durée</label>
			<input type="duration" name="duration" value="<?php echo $item["duration"]; ?>">
		</div>
		<div>
			<label for="height_difference">Dénivelé</label>
			<input type="text" name="height_difference" value="<?php echo $item["height_difference"]; ?>">
		</div>
		<div>
			<label for="available">Disponible</label>
			<input type="checkbox" name="available" <?php echo isChecked($item["available"]); ?>>
		</div>
		<button type="submit" name="button">Modifier</button>
	</form>
</body>
</html>