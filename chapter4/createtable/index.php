<?php
try
{
	$pdo = new PDO('mysql:host=localhost; dbname=joke', 'jokeuser', 'jokepas');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
	$output = "Невозможно подключится к серверу баз данных";
	include 'output.html.php';
	exit();
}
try
{
	$sql = 'CREATE TABLE joke (
		id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
		joketext TEXT,
		jokedate DATE NOT NULL
		)DEFAULT CHARACTER SET utf8 ENGINE=INNODB';
	$pdo->exec($sql);
}
catch (PDOException $e)
{
	$output = 'Ошибка при создании таблицы joke: ' . $e->getMessage();
	include 'output.html.php';
	exit();
}

$output = 'Таблица joke была успешно создана.';
include 'output.html.php';