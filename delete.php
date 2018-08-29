<?php 
session_start();
require 'sql.php';

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
	echo 'Votre login est '.$_SESSION['username'].' et votre mot de passe est '.$_SESSION['password'].'.';
	echo '<br><a href="./logout.php">Déconnection</a>';
	if (isset($_GET["id"])) {
		$remove = $pdo->prepare("DELETE FROM hiking WHERE id = :id");
		$remove->bindParam(':id', $_GET["id"]);
		try {
			$remove->execute();
		} catch (PDOException $e) {
		    if ($e->getCode() == 1062) {
		        // Take some action if there is a key constraint violation, i.e. duplicate name
		    } else {
		        throw $e;
		    }
		}
		header('Location: read.php');
	} else {
		echo "<h1>Nothing to delete!</h1>";
	}
}
else {
	header('Location: read.php?status=notenoughpermissions');
}


 ?>