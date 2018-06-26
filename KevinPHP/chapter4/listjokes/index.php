<?php
try
{
	$pdo = new PDO('mysql:host=localhost; dbname=joke', 'jokeuser', 'jokepas');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
	$error = "Невозможно подключится к серверу баз данных";
	include 'error.html.php';
	exit();
}
try
{
	$sql = 'SELECT joketext FROM joke';
	$result = $pdo->query($sql);
}
catch (PDOException $e)
{
	$error = 'Ошибка при извлечении шуток: ' . $e->getMessage();
	include 'error.html.php';
	exit();
}

foreach ($result as $row) 
{
	$jokes[] = $row['joketext'];
}

include 'jokes.html.php';