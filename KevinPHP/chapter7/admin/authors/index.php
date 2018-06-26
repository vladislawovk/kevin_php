<?php
include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/magicquotes.inc.php';

if (isset($_GET['add'])) 
{
	$pageTitle = 'Новый автор';
	$action = 'addform';
	$name = '';
	$email = '';
	$id = '';
	$button = 'Добавить автора';

	include 'form.html.php';
	exit();
}

if(isset($_GET['addform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	try
	{
		$sql = 'INSERT INTO author SET
			name = :name,
			email = :email';
		$s = $pdo->prepare($sql);
		$s->bindValue(':name', $_POST['name']);
		$s->bindValue(':email', $_POST['email']);
		$s->execute();
	}
	catch(PDOException $e)
	{
		$error = 'Ошибка при добавлении автора.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

if(isset($_POST['action']) and $_POST['action'] == 'Редактировать')
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	try
	{
		$sql = 'SELECT id, name, email FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch(PDOException $e)
	{
		$error = 'Ошибка при извлечении информации об авторе.';
		include 'error.html.php';
		exit();
	}

	$row = $s->fetch();

	$pageTitle = 'Редактировать автора';
	$action = 'editform';
	$name = $row['name'];
	$email = $row['email'];
	$id = $row['id'];
	$button = 'Обновить информацию об авторе';

	include 'form.html.php';
	exit();
}

if (isset($_GET['editform']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	try
	{
		$sql = 'UPDATE author SET
			name = :name,
			email = :email
			WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->bindValue(':name', $_POST['name']);
		$s->bindValue(':email', $_POST['email']);
		$s->execute();
	}
	catch(PDOException $e)
	{
		$error = 'Ошибка при обновлении записи об авторе.';
		include 'error.html.php';
		exit();
	}
	header('Location: .');
	exit();
}

if(isset($_POST['action']) and $_POST['action'] == 'Удалить') 
{
	include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

	// Получаем шутки, принадлежащие автору
	try 
	{
		$sql = 'SELECT id FROM joke WHERE authorid = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch(PDOException $e) 
	{
		$error = 'Ошибка при получении списка шуток, которые нужно удалить.';
		include 'error.html.php';
		exit();
	}
	$result = $s->fetchAll();

	// Удаляем записи о категориях шуток
	try
	{
		$sql = 'DELETE FROM jokecategory WHERE jokeid = :id';
		$s = $pdo->prepare($sql);

		// Для каждой шутки
		foreach ($result as $row) 
		{
			$jokeid = $row['id'];
			$s->bindValue(':id', $jokeid);
			$s->execute();
		}
	}
	catch(PDOException $e) 
	{
		$error = 'Ошибка при удалении записей о категориях шутки.';
		include 'error.html.php';
		exit();
	}

	// Удаляем шутки, принадлежащие автору
	try
	{
		$sql = 'DELETE FROM joke WHERE authorid = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch (PDOException $e)
	{
		$error = 'Ошибка при удалении шуток, принадлежащих автору.';
		include 'error.html.php';
		exit();
	}
	// Удаляем имя автора
	try
	{
		$sql = 'DELETE FROM author WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	}
	catch(PDOException $e)
	{
		$error = 'Ошибка при удалении автора.';
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

// выводим список авторов
include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/db.inc.php';

try 
{
	$result = $pdo->query('SELECT id, name FROM author');
}
catch(PDOException $e)
{
	$error = 'Ошибка при извлечении авторов из базы данных!';
	include 'error.html.php';
	exit();
}

foreach ($result as $row) 
{
	$authors[] = array('id' => $row['id'], 'name' => $row['name']);
}

include 'authors.html.php';