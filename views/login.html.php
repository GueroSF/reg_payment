<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= \model\Url::homeUrl() ?>/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="<?= \model\Url::homeUrl() ?>/icon/favicon-32x32.png" sizes="32x32">
    <link rel="manifest" href="<?= \model\Url::homeUrl() ?>/manifest.json">
    <title><?= $this->title ?></title>
    <link rel="stylesheet" type="text/css" href="<?= \model\Url::homeUrl() ?>/style/login.css">
</head>
<body>
	<form class="table login" method="post">
		<label><span>Имя:</span><input type="text" name="name" autofocus required></label><br>
		<label><span> Пароль:</span><input type="password" name="pass" required></label><br>
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