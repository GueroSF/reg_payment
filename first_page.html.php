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
	<div class="month">
		<div class="month_name"><span><?php echo $month2Last['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td colspan="2">офицально</td>
				</tr>
				<tr>
					<td>15000</td><td>из 15000</td>
				</tr>
				<tr>
					<td colspan="2">не офицально</td>
				</tr>
				<tr>
					<td>100000</td><td>из 100000</td>
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
					
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<form>
				<input type="hidden" name="month" value="<?php echo $month2Last['num'];?>">
				<input type="hidden" name="swallow" value="edit">
				<input type="submit" value="Просмотр">
			</form>
		</div>
	</div>
		<div class="month">
		<div class="month_name"><span><?php echo $month1Last['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td colspan="2">офицально</td>
				</tr>
				<tr>
					<td>15000</td><td>из 15000</td>
				</tr>
				<tr>
					<td colspan="2">не офицально</td>
				</tr>
				<tr>
					<td>100000</td><td>из 100000</td>
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
					
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<form>
				<input type="hidden" name="month" value="<?php echo $month1Last['num'];?>">
				<input type="hidden" name="swallow" value="edit">
				<input type="submit" value="Просмотр">
			</form>
		</div>
	</div>
		<div class="month">
		<div class="month_name"><span><?php echo $monthToday['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td colspan="2">офицально</td>
				</tr>
				<tr>
					<td>15000</td><td>из 15000</td>
				</tr>
				<tr>
					<td colspan="2">не офицально</td>
				</tr>
				<tr>
					<td>100000</td><td>из 100000</td>
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
					
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<form>
				<input type="hidden" name="month" value="<?php echo $monthToday['num'];?>">
				<input type="hidden" name="swallow" value="edit">
				<input type="submit" value="Просмотр">
			</form>
		</div>
	</div>
		<div class="month">
		<div class="month_name"><span><?php echo $monthNext['name'];?></span></div>
		<div class="salary">
			<table>
				<tr>
					<td colspan="2">офицально</td>
				</tr>
				<tr>
					<td>15000</td><td>из 15000</td>
				</tr>
				<tr>
					<td colspan="2">не офицально</td>
				</tr>
				<tr>
					<td>100000</td><td>из 100000</td>
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
					
				</tr>
			</table>
		</div>
		<div class="view_detail">
			<form>
				<input type="hidden" name="month" value="<?php echo $monthNext['num'];?>">
				<input type="hidden" name="swallow" value="edit">
				<input type="submit" value="Просмотр">
			</form>
		</div>
	</div>
</content>
</body>
</html>