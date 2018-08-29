<?php 
require 'sql.php';
$username = 'admin';
$password = sha1('admin');

$newUser = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
$newUser->bindParam(':username', $username);
$newUser->bindParam(':password', $password);
$newUser->execute();
 ?>