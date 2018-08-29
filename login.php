<?php 
require 'sql.php';
$submitedUsername = $_POST["username"];
$submitedPassword = sha1($_POST["password"]);

// FAIRE SANITISATION
$verifyLogin = $pdo->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
$verifyLogin->bindParam(':username', $submitedUsername);
$verifyLogin->bindParam(':password', $submitedPassword);
$verifyLogin->execute();

// SI IL Y A PLUS D'UNE LIGNE EN RETOUR DE LA REQUETE -> DONC QUE L'UTILISATEUR EXISTE
if ($verifyLogin->rowCount() > 0) {
	echo "You are now logged in !";
	session_start();
	$_SESSION['username'] = $submitedUsername;
	$_SESSION['password'] = $submitedPassword;
	header('Location: read.php');
} else {
	header('Location: index.php?login=failed');
}

$data = $verifyLogin->fetch();
echo is_null($data);
//print_r($data);


 ?>