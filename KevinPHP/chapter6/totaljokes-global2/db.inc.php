<?php
try
{
	$pdo = new PDO('mysql:host=localhost; dbname=joke', 'jokeuser', 'jokepas');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch (PDOExeption $e)
{
	$error = 'не удалось подключится к серверу баз данных.';
	include 'error.html.php';
	exit();
}