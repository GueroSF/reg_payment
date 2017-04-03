<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>О платежах</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header><a href=".">Назад</a></header>
<content>
	<div class="paymentAdd">
		<div class="month_name"><span>Внести платёж за месяц: <b><?php echo $monthName;?></b></span></div>
		<form class="table" action="payment.php" method="post">
			<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
			<input type="number" step="0.01" name="money">
			<select name="category" required>
				<option></option>
				<?php foreach ($paymentCategory as $cat): ?>
					<option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
				<?php endforeach ?>				
			</select>
			<input type="hidden" name="month" value="<?php echo $month;?>">
			<input type="hidden" name="action" value="paymentAdd">
			<input type="submit" value="Добавить">
		</form>
		
	</div>
	<div class="paymentList">
		<div class="table">
			<div class="td1">Дата платежа</div>
			<div class="td2">Сумма</div>
			<div class="td3">Назначение</div>
		</div>
		<?php foreach ($paymentMonth as $payment): ?>
			<form class="table" action="payment.php" method="post">
				<div class="td1"><?php echo $payment['pd']; ?></div>
				<div class="td2"><input type="number" step="0.01" name="sum" value="<?php echo $payment['money']; ?>"></div>
				<div class="td3"><?php echo $payment['name']; ?></div>
				<div class="td4">
					<input type="hidden" name="id_payment" value="<?php echo $payment['id']; ?>">
					<input type="hidden" name="action" value="edit_payment">
					<input type="submit" value="Изменить">
				</div>						
			</form>
		<?php endforeach ?>
	</div>

</content>
</body>
</html>