<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter6/includes/db.inc.php';

function totalJokes()
{
	global $pdo;

	try
	{
		$result = $pdo->query('SELECT COUNT(*) FROM joke');
	}
	catch (PDOExeption $e)
	{
		$error = 'Ошибка базы данных при подсчёте шуток!';
		include 'error.html.php';
		exit();
	}
	$row = $result->fetch();
	return $row[0];
}