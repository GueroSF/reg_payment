<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>Учёт</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header><span>Учёт</span></header>
<content>
<?php for($i=0;$i<4;$i++): ?>
	<div class="month">
		<div class="month_name"><span><?php echo $monthDisplay[$i]['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td colspan="2">офицально</td>
				</tr>
				<tr>
					<td><?php echo $moneyCat[1][$i];?></td><td>из 15000</td>
				</tr>
				<tr>
					<td colspan="2">не офицально</td>
				</tr>
				<tr>
					<td><?php echo $moneyCat[2][$i];?></td><td>из 100000</td>
				</tr>
			</table>
		</div>
		<div class="swallow">
			<table>
				<tr>
					<th>Ласточка</th>
				</tr>
				<tr>
					<td>Оплачено</td>
				</tr>
				<tr>
					<td><?php echo $moneyCat[3][$i];?></td>
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<form action="payment.php" method="post">
				<input type="hidden" name="month" value="<?php echo $monthDisplay[$i]['num'];?>">
				<input type="hidden" name="monthName" value="<?php echo $monthDisplay[$i]['name'];?>">
				<input type="hidden" name="month_payment" value="edit">
				<input type="submit" value="Просмотр">
			</form>
		</div>
	</div>
<?php endfor; ?>
</content>
</body>
</html>