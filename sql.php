<?php
try
{
	$pdo = new PDO('mysql:host=localhost;dbname=reunion_island;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Error : '.$e->getMessage());
}
?>