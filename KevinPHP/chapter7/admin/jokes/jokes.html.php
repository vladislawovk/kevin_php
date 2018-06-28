<?php //include $_SERVER['DOCUMENT_ROOT'] . '/KevinPHP/chapter7/admin/includes/helpers.inc.php'; 
    include $_SERVER['DOCUMENT_ROOT'] . '/kevin_php/KevinPHP/chapter7/admin/includes/helpers.inc.php'; 
    ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Управление шутками: результаты поиска</title>
</head>
<body>
    <h1>Результаты поиска</h1>
    <?php if (isset($jokes)): ?>
        <table>
            <tr><th>Текст шутки</th><th>Действия</th></tr>
            <?php foreach ($jokes as $joke): ?>
                <tr>
                    <td><?php htmlout($joke['text']); ?></td>
                    <td>
                        <form action="?" method="post">
                            <div>
                                <input type="hidden" name="id" value="<?php htmlout($joke['id']); ?>">
                                <input type="submit" name="action" value="Редактировать">
                                <input type="submit" name="action" value="Удалить">
                            </div>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <p><a href="?">Искать заново</a></p>
    <p><a href="..">Вернуться на главную страницу</a></p>
</body>
</html>
