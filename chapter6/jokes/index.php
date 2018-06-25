<?php

if(get_magic_quotes_gpc())
{
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while(list($key, $val) = each($process))
	{
		foreach ($val as $k => $v)
		{
			unset($process[$key][$k]);
			if(is_array($v))
			{
				$process[$key][stripcslashes($k)] = $v;
				$process[] = &$process[$key][stripcslashes($k)];
			}	
			else
			{
				$process[$key][stripcslashes($k)] = stripcslashes($v);
			}
		}
	}
	unset($process);
}

if (isset($_GET['addjoke'])) {
	include 'form.html.php';
	exit();
}

if (isset($_POST['joketext'])) 
{
	include 'db.inc.php';

	try
	{
		$sql = 'INSERT INTO joke SET
			joketext = :joketext,
			jokedate = CURDATE()';
		$s = $pdo->prepare($sql);
		$s->bindValue(':joketext', $_POST['joketext']);
		$s->execute();
	}
	catch(PDOException $e)
	{
		$error = 'Ошибка при добавлении шутки: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
	header('location: .');
	exit();
}

if (isset($_GET['deletejoke'])) 
{	
	include 'db.inc.php';

	try {
		$sql = 'DELETE FROM joke WHERE id = :id';
		$s = $pdo->prepare($sql);
		$s->bindValue(':id', $_POST['id']);
		$s->execute();
	} catch (PDOException $e) {
		$erorr = 'Ошибка при удалении шутки: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}

	header('Location: .');
	exit();
}

include 'db.inc.php';

try
{
	$sql = 'SELECT joke.id, joketext, name, email 
		FROM joke INNER JOIN author
		ON authorid = author.id';
	$result = $pdo->query($sql);
}
catch (PDOException $e)
{
	$error = 'Ошибка при извлечении шуток: ' . $e->getMessage();
	include 'error.html.php';
	exit();
}

/*
while ($row = $result->fetch()) {
	$jokes[] = array('id' => $row['id'], 'text' => $row['joketext']);
}
*/

foreach ($result as $row) 
{
	$jokes[] = array(
		'id' => $row['id'],
		'text' => $row['joketext'],
		'name' => $row['name'],
		'email' => $row['email']
	);
}

include 'jokes.html.php';