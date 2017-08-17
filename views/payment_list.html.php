<?php /** @var $this \model\ViewCategory */ ?>
<div class="paymentAdd">
	<div class="month_name"><span>Внести платёж: <b><?= $this->getCategoryName(true)?></b> <?= $this->getMoneyOfCategory() ?></span></div>
	<form id="paymentAdd" class="table" action="" method="post">
		<input type="date" name="date" value="<?= date('Y-m-d'); ?>">
		<input type="number" step="0.01" name="money">
		<select name="operation">
			<option></option>
			<?php foreach (\model\Payment::getOperations() as $op): ?>
				<option value="<?= $op['id']; ?>"><?= $op['name']; ?></option>
			<?php endforeach ?>
		</select>
		<textarea name="comment" maxlength="100" rows="2"></textarea>
		<input type="hidden" name="account" value="<?= $this->iAccountId ?>">
		<input type="hidden" name="category" value="<?= $this->iCategoryId ?>">
		<input type="hidden" name="action" value="addPayment">
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
	<?php foreach ($this->getPaymetsOfCategory() as $payment): ?>
		<div class="payment">
			<div class="table">
				<div class="td1"><?= $payment['date']; ?></div>
				<div class="td2"><?= $payment['money']; ?></div>
				<div class="td3"><?= $payment['name']; ?></div>
			</div>
			<?php if($payment['comm']!=='false'): ?>
				<div class="comment">
					<span class="td1">Комм:</span>
					<span class="comm"><?= $payment['comm']; ?></span>
				</div>
			<?php endif; ?>
		</div>
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