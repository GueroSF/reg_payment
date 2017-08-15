<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="http://<?= $_SERVER['HTTP_HOST'] ?>/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="http://<?= $_SERVER['HTTP_HOST'] ?>/icon/favicon-32x32.png" sizes="32x32">
    <title><?= $this->title ?></title>
    <link rel="stylesheet" type="text/css" href="http://<?= $_SERVER['HTTP_HOST'] ?>/style/login.css">
</head>
<body>
	<form class="table login" method="post">
		<label><span>Имя:</span><input type="text" name="name"></label><br>
		<label><span> Пароль:</span><input type="password" name="pass"></label><br>
        <?php if (!empty($GLOBALS['login']['error'])): ?>
            <div style="background: red">
                <?= $GLOBALS['login']['error'] ?>
            </div>
        <?php endif; ?>
		<input type="hidden" name="action" value="login">
		<input type="submit" value="Вход">
	</form>
</body>
</html>