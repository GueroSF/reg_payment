<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $pathURL; ?>icon/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="<?php echo $pathURL; ?>icon/favicon-32x32.png" sizes="32x32">
	<title><?php echo $titleName; ?></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<a href=".">Назад</a><a href="?logOut=exit">Выход</a>
	<?php if (isset($accountName)): ?>
		<span><?=$accountName?></span>
	<?php endif; ?>
</header>
<content>