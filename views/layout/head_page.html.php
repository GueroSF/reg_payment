<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" sizes="180x180" href="<?= $this->getNameHost() ?>/icon/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="<?= $this->getNameHost() ?>/icon/favicon-32x32.png" sizes="32x32">
    <link rel="manifest" href="<?= $this->getNameHost() ?>/manifest.json">
	<title><?= $this->title ?></title>
	<link rel="stylesheet" type="text/css" href="<?= $this->getNameHost() ?>/style/style.css">
	<?php if (!empty($this->fileCSS)): ?>
		<link rel="stylesheet" type="text/css" href="<?= $this->getNameHost() ?>/style/<?= $this->fileCSS ?>">
	<?php endif; ?>
	<?php if ( !empty($this->fileJS) ): ?>
		<script type="text/javascript" src="<?= $this->getNameHost() ?>/js/<?= $this->fileJS ?>"></script>
	<?php endif; ?>
</head>
<body>
<header>
    <nav>
        <a href="<?= \model\Url::$btmBack ?>">Назад</a>
        <a href="?logOut=exit">Выход</a>
    </nav>
    <div class="calculator">
        <label>
            <span>calc</span>
            <input type="checkbox" name="calculator">
        </label>
    </div>
</header>
<main>