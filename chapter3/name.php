<?php
$firstname = $_REQUEST['firstname'];
$lastname = $_REQUEST['lastname'];
if ($firstname == 'Злата' and $lastname == 'Дидык')
{
	echo 'Добро пожаловать, о блистательный правитель!';
}
else 
{
	echo 'ну привет, ' . 
	htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8') . ' ' .
	htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
} 
