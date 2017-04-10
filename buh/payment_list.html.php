<div class="paymentAdd">
	<div class="month_name"><span>Внести платёж: <b><?php echo $category['name'];?></b> <?php echo $moneySumCat;?></span></div>
	<form id="paymentAdd" class="table" action="" method="post">
		<input type="date" name="date" value="<?php echo date('Y-m-d'); ?>">
		<input type="number" step="0.01" name="money">
		<select name="operation">
			<option></option>
			<?php foreach ($operations as $op): ?>
				<option value="<?php echo $op['id']; ?>"><?php echo $op['name']; ?></option>
			<?php endforeach ?>
		</select>
		<textarea name="comment" maxlength="100" rows="2"></textarea>
		<input type="hidden" name="account" value="<?php echo $idAccount;?>">
		<input type="hidden" name="category" value="<?php echo $idCat;?>">
		<input type="hidden" name="action" value="paymentAdd">
		<input type="submit" value="Добавить">
	</form>

</div>
<div class="paymentList">
	<div class="month_name">Платежи внесенные ранее:</div>
	<div class="table">
		<div class="td1">Дата платежа</div>
		<div class="td2">Сумма</div>
		<div class="td3">Операция</div>
	</div>
	<?php foreach ($payments as $payment): ?>
		<form class="table" action="" method="post">
			<div class="td1"><?php echo $payment['date']; ?></div>
			<div class="td2"><?php echo $payment['money']; ?></div>
			<div class="td3"><?php echo $payment['name']; ?></div>
			<!--<div class="td4">
				<input type="hidden" name="id_payment" value="<?php echo $payment['id']; ?>">
				<input type="hidden" name="action" value="paymentEdit">
				<input type="submit" value="Изменить">
			</div>	-->					
		</form>
	<?php endforeach ?>
</div>
</content>
</body>
<script type="text/javascript">
	const form = document.getElementById('paymentAdd');
	form.addEventListener('submit', function (event) {
		let money = form.querySelector('[name=money]');
		let cat = form.querySelector('[name=category]');
		if (money.value == ''||cat.value == ''){
			event.preventDefault();
			alert('Заполните поля!');
		}
	});
</script>
</html>