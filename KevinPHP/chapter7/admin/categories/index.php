<?php
include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/magicquotes.inc.php';

if (isset($_GET['add']))
{
	$pageTitle = 'Новая категория';
	$action = 'addform';
	$name = '';
	$id = '';
	$button = 'Добавить категорию';

	include 'form.html.php';
	exit();
}

if (isset($_GET['addform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';
	try
	{
		$sql = 'INSERT INTO category SET name = :name';
		$s = $pdo->prepare($sql);
		$s->bindValue(':name', $_POST['name']);
	 	$s->execute();
	}
	catch(PDOExeption $e)
	{
		$error = 'Ошибка при добавлении категории.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Редактировать')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	try
	{
		$sql = 'SELECT id, name, FROM category WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch(PDOExeption $e)
	{
		$error = 'ошибка при извлечении информации о категории.';
		include 'error.html.php';
		exit();
	}

	$row = $s->fetch();

	$pageTitle = 'Редактировать категорию';
	$action = 'editform';
	$name = $row['name'];
	$id = $row['id'];
	$button = 'Обновать категорию';

	include 'form.html.php';
	exit();
}

if (isset($_GET['editform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	try
	{
		$sql = 'UPDATE category SET name = :name WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->bindValue(':name', $_POST['name']);
		$s->execute();
	}
	catch(PDOExeption $e)
	{
		$error = 'ошибка при обновлении категории.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'Удалить') 
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	// Удаляем все записи, связывающие шутки с этой категорией
	try 
	{
	 	$sql = 'DELETE FROM jokecategory WHERE categoryid = :id';
	 	$s = $pdo->prepare($sql);
	 	$s->bindValue(':id', $_POST['id']);
	 	$s->execute();
	} 
	catch(PDOException $e) 
	{
		$error = 'Ошибка при удалении шуток из категории.';
		include 'error.html.php';
		exit();
	}

	// Удаляем категорию
	try
	{
		$sql = 'DELETE FROM category WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch(PDOExeption $e)
	{
		$error = 'Ошибка при удалении категории.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

try 
{
	$result = $pdo->query('SELECT id, name FROM category');
}
catch(PDOExeption $e)
{
	$error = 'Ошибка при извлечении категории из базы данных!';
	include 'error.html.php';
	exit();
}

foreach($result as $row)
{
	$categories[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'categories.html.php';